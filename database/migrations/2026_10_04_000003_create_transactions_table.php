<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->decimal('amount', 12, 2);
            $table->date('date');
            $table->string('category')->default('General');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('amanats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('party_id')->nullable()->constrained('parties')->onDelete('set null');
            $table->string('depositor_name')->nullable();
            $table->decimal('amount', 12, 2);
            $table->date('date');
            $table->text('details')->nullable();
            $table->timestamps();
        });

        Schema::create('lotteries', function (Blueprint $table) {
            $table->id();
            $table->string('scheme_name');
            $table->decimal('amount', 12, 2);
            $table->date('date');
            $table->string('status')->default('Pending');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique();
            $table->date('date');
            $table->foreignId('party_id')->constrained('parties')->onDelete('cascade');
            $table->foreignId('salesman_id')->nullable()->constrained('salesmen')->onDelete('set null');
            $table->decimal('amount', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('net_amount', 12, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');
            $table->string('item_name');
            $table->integer('qty')->default(1);
            $table->decimal('rate', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique();
            $table->date('date');
            $table->foreignId('party_id')->constrained('parties')->onDelete('cascade');
            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('set null');
            $table->decimal('amount', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('net_amount', 12, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained('purchases')->onDelete('cascade');
            $table->string('item_name');
            $table->integer('qty')->default(1);
            $table->decimal('rate', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_no')->unique();
            $table->enum('type', ['receipt', 'payment']);
            $table->date('date');
            $table->foreignId('party_id')->nullable()->constrained('parties')->onDelete('cascade');
            $table->decimal('amount', 12, 2)->default(0);
            $table->string('payment_mode')->default('Cash'); // Cash, Bank, Cheque
            $table->string('reference_no')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
        Schema::dropIfExists('purchase_items');
        Schema::dropIfExists('purchases');
        Schema::dropIfExists('sale_items');
        Schema::dropIfExists('sales');
        Schema::dropIfExists('lotteries');
        Schema::dropIfExists('amanats');
        Schema::dropIfExists('expenses');
    }
};
