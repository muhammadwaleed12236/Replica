<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Party;
use App\Models\Company;
use App\Models\Salesman;
use App\Models\MedicalRep;
use App\Models\Bank;
use App\Models\Expense;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Voucher;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        User::factory()->create([
            'name' => 'ProWave Admin',
            'email' => 'admin@prowave.com',
            'password' => bcrypt('password'),
        ]);

        // Parties
        $p1 = Party::create(['code' => 'P-1001', 'name' => 'Dawn Pharmacy', 'type' => 'customer', 'phone' => '0300-1234567', 'city' => 'Lahore', 'opening_balance' => 25000, 'current_balance' => 25000]);
        $p2 = Party::create(['code' => 'P-1002', 'name' => 'Apex Traders', 'type' => 'supplier', 'phone' => '0321-9876543', 'city' => 'Karachi', 'opening_balance' => 50000, 'current_balance' => 50000]);
        $p3 = Party::create(['code' => 'P-1003', 'name' => 'City Medico', 'type' => 'customer', 'phone' => '0312-4567890', 'city' => 'Islamabad', 'opening_balance' => 12000, 'current_balance' => 12000]);

        // Companies
        $c1 = Company::create(['name' => 'GlaxoSmithKline', 'phone' => '021-111-475', 'city' => 'Karachi']);
        $c2 = Company::create(['name' => 'Getz Pharma', 'phone' => '021-38660000', 'city' => 'Karachi']);

        // Salesmen
        $s1 = Salesman::create(['name' => 'Tariq Mehmood', 'phone' => '0300-9988776', 'commission_rate' => 2.5]);
        $s2 = Salesman::create(['name' => 'Usman Ali', 'phone' => '0333-5544332', 'commission_rate' => 3.0]);

        // Medical Reps
        MedicalRep::create(['name' => 'Bilal Ahmed', 'phone' => '0345-1122334', 'company_name' => 'Getz Pharma']);

        // Banks
        Bank::create(['bank_name' => 'Meezan Bank', 'account_title' => 'Dawn Enterprise', 'account_number' => '0101-02030405', 'balance' => 450000]);
        Bank::create(['bank_name' => 'Habib Bank Limited', 'account_title' => 'Dawn Enterprise', 'account_number' => '0987-65432101', 'balance' => 280000]);

        // Expenses
        Expense::create(['title' => 'Office Shop Rent (October)', 'amount' => 35000, 'date' => date('Y-m-d'), 'category' => 'Rent', 'remarks' => 'Paid via cheque']);
        Expense::create(['title' => 'Electricity Bill', 'amount' => 18450, 'date' => date('Y-m-d'), 'category' => 'Utilities', 'remarks' => 'WAPDA bill']);

        // Sales Invoices
        $sale1 = Sale::create([
            'invoice_no' => 'INV-00001',
            'date' => date('Y-m-d'),
            'party_id' => $p1->id,
            'salesman_id' => $s1->id,
            'amount' => 15000,
            'discount' => 500,
            'net_amount' => 14500,
            'remarks' => 'Bulk medicine order',
        ]);
        $sale1->items()->create(['item_name' => 'Panadol Extra 500mg (Box)', 'qty' => 10, 'rate' => 1000, 'total' => 10000]);
        $sale1->items()->create(['item_name' => 'Disprin 50mg (Pack)', 'qty' => 10, 'rate' => 500, 'total' => 5000]);

        // Purchase Bills
        $pur1 = Purchase::create([
            'invoice_no' => 'PUR-00001',
            'date' => date('Y-m-d'),
            'party_id' => $p2->id,
            'company_id' => $c1->id,
            'amount' => 45000,
            'discount' => 1000,
            'net_amount' => 44000,
            'remarks' => 'Stock replenishment',
        ]);
        $pur1->items()->create(['item_name' => 'Augmentin 625mg (Carton)', 'qty' => 5, 'rate' => 9000, 'total' => 45000]);

        // Vouchers
        Voucher::create([
            'voucher_no' => 'REC-001',
            'type' => 'receipt',
            'date' => date('Y-m-d'),
            'party_id' => $p1->id,
            'amount' => 10000,
            'payment_mode' => 'Cash',
            'remarks' => 'Partial payment received',
        ]);

        Voucher::create([
            'voucher_no' => 'PAY-001',
            'type' => 'payment',
            'date' => date('Y-m-d'),
            'party_id' => $p2->id,
            'amount' => 20000,
            'payment_mode' => 'Bank Transfer',
            'remarks' => 'Supplier advance payment',
        ]);

        // Recalculate Party Balances
        Party::all()->each(fn($party) => $party->recalculateBalance());
    }
}
