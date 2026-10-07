<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create Settings Table
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->timestamps();
            });

            // Seed default settings
            DB::table('settings')->insert([
                ['key' => 'date_lock_date', 'value' => null, 'created_at' => now(), 'updated_at' => now()],
                ['key' => 'admin_password', 'value' => Hash::make('admin123'), 'created_at' => now(), 'updated_at' => now()],
                ['key' => 'whatsapp_template', 'value' => 'Dear {customer_name}, thank you for your business! Invoice #{invoice_no} total amount is Rs. {amount}. Date: {date}.', 'created_at' => now(), 'updated_at' => now()],
                ['key' => 'auto_backup_enabled', 'value' => '1', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        // 2. Add Role to Users Table
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('admin')->after('email');
            });
        }

        // 3. Add Credit Limits & Days Limit to Parties Table
        if (Schema::hasTable('parties')) {
            Schema::table('parties', function (Blueprint $table) {
                if (!Schema::hasColumn('parties', 'credit_limit')) {
                    $table->decimal('credit_limit', 15, 2)->default(0)->after('opening_balance');
                }
                if (!Schema::hasColumn('parties', 'credit_days_limit')) {
                    $table->integer('credit_days_limit')->default(30)->after('credit_limit');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');

        if (Schema::hasTable('users') && Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }

        if (Schema::hasTable('parties')) {
            Schema::table('parties', function (Blueprint $table) {
                if (Schema::hasColumn('parties', 'credit_limit')) {
                    $table->dropColumn('credit_limit');
                }
                if (Schema::hasColumn('parties', 'credit_days_limit')) {
                    $table->dropColumn('credit_days_limit');
                }
            });
        }
    }
};
