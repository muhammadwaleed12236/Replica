<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sale_items', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->after('sale_id')->constrained('products')->onDelete('set null');
        });

        Schema::table('purchase_items', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->after('purchase_id')->constrained('products')->onDelete('set null');
        });
        
        // Optionally backfill product_id by looking up the name in the products table if it exists
        // (For simplicity in this task we'll just link the names to the first matching product)
        DB::statement('UPDATE sale_items SET product_id = (SELECT id FROM products WHERE products.name = sale_items.item_name LIMIT 1)');
        DB::statement('UPDATE purchase_items SET product_id = (SELECT id FROM products WHERE products.name = purchase_items.item_name LIMIT 1)');
    }

    public function down(): void
    {
        Schema::table('purchase_items', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
        });

        Schema::table('sale_items', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
        });
    }
};
