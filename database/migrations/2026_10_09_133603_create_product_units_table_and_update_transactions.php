<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create product_units table
        Schema::create('product_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('name'); // e.g. Box, Carton, Pcs
            $table->string('alias')->nullable();
            $table->string('operator')->default('*'); // * or /
            $table->decimal('factor', 15, 5)->default(1);
            $table->boolean('is_base_unit')->default(false);
            $table->boolean('is_default_purchase')->default(false);
            $table->boolean('is_default_sale')->default(false);
            $table->timestamps();
            
            $table->unique(['product_id', 'name']);
            $table->unique(['product_id', 'alias']);
        });

        // 2. Migrate existing products to have a base unit
        $products = DB::table('products')->get();
        foreach ($products as $product) {
            $unitName = $product->unit ?: 'Pcs';
            DB::table('product_units')->insert([
                'product_id' => $product->id,
                'name' => $unitName,
                'operator' => '*',
                'factor' => 1,
                'is_base_unit' => true,
                'is_default_purchase' => true,
                'is_default_sale' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Update products table stock_quantity to decimal
        Schema::table('products', function (Blueprint $table) {
            // Drop old column and add new one to allow float/decimal, or change it
            $table->decimal('stock_quantity', 15, 3)->default(0)->change();
        });

        // 4. Update sale_items
        Schema::table('sale_items', function (Blueprint $table) {
            $table->decimal('qty', 15, 3)->default(1)->change();
            $table->string('unit_name')->nullable()->after('qty');
            $table->decimal('unit_factor', 15, 5)->default(1)->after('unit_name');
            $table->decimal('base_qty', 15, 3)->default(0)->after('unit_factor');
        });
        
        DB::statement('UPDATE sale_items SET base_qty = qty, unit_factor = 1');

        // 5. Update purchase_items
        Schema::table('purchase_items', function (Blueprint $table) {
            $table->decimal('qty', 15, 3)->default(1)->change();
            $table->string('unit_name')->nullable()->after('qty');
            $table->decimal('unit_factor', 15, 5)->default(1)->after('unit_name');
            $table->decimal('base_qty', 15, 3)->default(0)->after('unit_factor');
        });
        
        DB::statement('UPDATE purchase_items SET base_qty = qty, unit_factor = 1');
    }

    public function down(): void
    {
        Schema::table('purchase_items', function (Blueprint $table) {
            $table->dropColumn(['unit_name', 'unit_factor', 'base_qty']);
            $table->integer('qty')->default(1)->change();
        });

        Schema::table('sale_items', function (Blueprint $table) {
            $table->dropColumn(['unit_name', 'unit_factor', 'base_qty']);
            $table->integer('qty')->default(1)->change();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->integer('stock_quantity')->default(0)->change();
        });

        Schema::dropIfExists('product_units');
    }
};
