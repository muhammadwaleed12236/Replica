<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product_units', function (Blueprint $table) {
            // New fields
            $table->decimal('purchase_price', 15, 2)->nullable()->after('factor');
            $table->decimal('sale_price', 15, 2)->nullable()->after('purchase_price');
            $table->boolean('is_purchase_unit')->default(true)->after('sale_price');
            $table->boolean('is_sale_unit')->default(true)->after('is_purchase_unit');
            
            // Remove the operator column if no longer needed, 
            $table->dropColumn('operator');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_units', function (Blueprint $table) {
            $table->dropColumn([
                'purchase_price',
                'sale_price',
                'is_purchase_unit',
                'is_sale_unit',
            ]);
            $table->string('operator')->default('*');
        });
    }
};
