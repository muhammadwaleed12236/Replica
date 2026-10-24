<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        try {
            Schema::table('sales', function (Blueprint $table) {
                $table->dropUnique('sales_invoice_no_unique');
            });
        } catch (\Exception $e) {
            // Index may not exist or already dropped
        }

        try {
            DB::statement('ALTER TABLE `sales` MODIFY `invoice_no` VARCHAR(255) NULL');
        } catch (\Exception $e) {
            try {
                Schema::table('sales', function (Blueprint $table) {
                    $table->string('invoice_no')->nullable()->change();
                });
            } catch (\Exception $ex) {
                // Ignore if already nullable
            }
        }
    }

    public function down(): void
    {
        //
    }
};
