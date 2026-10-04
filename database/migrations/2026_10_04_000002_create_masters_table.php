<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->timestamps();
        });

        Schema::create('salesmen', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->decimal('commission_rate', 5, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('medical_reps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('company_name')->nullable();
            $table->timestamps();
        });

        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name');
            $table->string('account_title');
            $table->string('account_number');
            $table->decimal('balance', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banks');
        Schema::dropIfExists('medical_reps');
        Schema::dropIfExists('salesmen');
        Schema::dropIfExists('companies');
    }
};
