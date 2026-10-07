<?php

namespace App\Http\Controllers;

use App\Models\Party;
use App\Models\Expense;
use App\Models\Voucher;
use App\Models\Bank;
use App\Models\Salesman;
use App\Models\Company;
use App\Models\MedicalRep;
use App\Models\Amanat;
use App\Models\Lottery;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    // Parties Management
    public function partiesIndex()
    {
        $parties = Party::latest()->get();
        return view('modules.parties', compact('parties'));
    }

    public function partiesStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:customer,supplier,both',
            'phone' => 'nullable|string',
            'city' => 'nullable|string',
            'opening_balance' => 'nullable|numeric',
            'credit_limit' => 'nullable|numeric',
            'credit_days_limit' => 'nullable|integer',
        ]);

        Party::create([
            'code' => 'P-' . rand(1000, 9999),
            'name' => $request->name,
            'type' => $request->type,
            'phone' => $request->phone,
            'city' => $request->city,
            'opening_balance' => $request->opening_balance ?? 0,
            'current_balance' => $request->opening_balance ?? 0,
            'credit_limit' => $request->credit_limit ?? 0,
            'credit_days_limit' => $request->credit_days_limit ?? 30,
        ]);

        return redirect()->back()->with('success', 'Party created successfully!');
    }

    // Medical Reps Management
    public function medicalRepsIndex()
    {
        $medicalReps = MedicalRep::latest()->get();
        return view('modules.medical_reps', compact('medicalReps'));
    }

    public function medicalRepsStore(Request $request)
    {
        $request->validate(['name' => 'required|string']);
        MedicalRep::create($request->only(['name', 'phone', 'company_name']));
        return redirect()->back()->with('success', 'Medical Rep created successfully!');
    }

    // Companies Management
    public function companiesIndex()
    {
        $companies = Company::latest()->get();
        return view('modules.companies', compact('companies'));
    }

    public function companiesStore(Request $request)
    {
        $request->validate(['name' => 'required|string']);
        Company::create($request->only(['name', 'phone', 'city']));
        return redirect()->back()->with('success', 'Company created successfully!');
    }

    // Salesmen Management
    public function salesmenIndex()
    {
        $salesmen = Salesman::latest()->get();
        return view('modules.salesmen', compact('salesmen'));
    }

    public function salesmenStore(Request $request)
    {
        $request->validate(['name' => 'required|string']);
        Salesman::create($request->only(['name', 'phone', 'commission_rate']));
        return redirect()->back()->with('success', 'Salesman created successfully!');
    }

    // Banks Management
    public function banksIndex()
    {
        $banks = Bank::latest()->get();
        return view('modules.banks', compact('banks'));
    }

    public function banksStore(Request $request)
    {
        $request->validate(['bank_name' => 'required|string', 'account_number' => 'required|string']);
        Bank::create($request->only(['bank_name', 'account_title', 'account_number', 'balance']));
        return redirect()->back()->with('success', 'Bank account created successfully!');
    }

    // Amanats Management
    public function amanatsIndex()
    {
        $amanats = Amanat::with('party')->latest()->get();
        $parties = Party::orderBy('name')->get();
        return view('modules.amanats', compact('amanats', 'parties'));
    }

    public function amanatsStore(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:0', 'date' => 'required|date']);
        Amanat::create($request->only(['party_id', 'depositor_name', 'amount', 'date', 'details']));
        return redirect()->back()->with('success', 'Amanat deposit recorded successfully!');
    }

    // Lotteries Management
    public function lotteriesIndex()
    {
        $lotteries = Lottery::latest()->get();
        return view('modules.lotteries', compact('lotteries'));
    }

    public function lotteriesStore(Request $request)
    {
        $request->validate(['scheme_name' => 'required|string', 'amount' => 'required|numeric|min:0']);
        Lottery::create($request->only(['scheme_name', 'amount', 'date', 'status', 'remarks']));
        return redirect()->back()->with('success', 'Lottery scheme recorded successfully!');
    }

    // Expenses Management
    public function expensesIndex()
    {
        $expenses = Expense::latest()->get();
        return view('modules.expenses', compact('expenses'));
    }

    public function expensesStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        Expense::create($request->only(['title', 'amount', 'date', 'category', 'remarks']));
        return redirect()->back()->with('success', 'Expense recorded successfully!');
    }

    // Receipts & Payments Vouchers
    public function vouchersIndex($type)
    {
        $vouchers = Voucher::with('party')->where('type', $type)->latest()->get();
        $parties = Party::orderBy('name')->get();
        return view('modules.vouchers', compact('vouchers', 'parties', 'type'));
    }

    public function vouchersStore(Request $request)
    {
        $request->validate([
            'type' => 'required|in:receipt,payment',
            'date' => 'required|date',
            'party_id' => 'required|exists:parties,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $voucher = Voucher::create([
            'voucher_no' => strtoupper(substr($request->type, 0, 3)) . '-' . time(),
            'type' => $request->type,
            'date' => $request->date,
            'party_id' => $request->party_id,
            'amount' => $request->amount,
            'payment_mode' => $request->payment_mode ?? 'Cash',
            'reference_no' => $request->reference_no,
            'remarks' => $request->remarks,
        ]);

        // Recalculate Party Balance
        if ($voucher->party) {
            $voucher->party->recalculateBalance();
        }

        return redirect()->back()->with('success', ucfirst($request->type) . ' voucher saved & party balance updated!');
    }

    // Comprehensive Reports & Detailed Ledgers
    public function reportsIndex(Request $request)
    {
        $fromDate = $request->input('from_date', date('Y-m-01'));
        $toDate = $request->input('to_date', date('Y-m-d'));
        $selectedPartyId = $request->input('party_id');

        $parties = Party::orderBy('name')->get();

        // Base Queries with Date Range Filters
        $salesQuery = \App\Models\Sale::with('party')->whereBetween('date', [$fromDate, $toDate]);
        $purchasesQuery = \App\Models\Purchase::with('party')->whereBetween('date', [$fromDate, $toDate]);
        $expensesQuery = Expense::whereBetween('date', [$fromDate, $toDate]);
        $vouchersQuery = Voucher::with('party')->whereBetween('date', [$fromDate, $toDate]);

        if ($selectedPartyId) {
            $salesQuery->where('party_id', $selectedPartyId);
            $purchasesQuery->where('party_id', $selectedPartyId);
            $vouchersQuery->where('party_id', $selectedPartyId);
        }

        $filteredSales = $salesQuery->latest()->get();
        $filteredPurchases = $purchasesQuery->latest()->get();
        $filteredExpenses = $expensesQuery->latest()->get();
        $filteredVouchers = $vouchersQuery->latest()->get();

        $totalSales = $filteredSales->sum('net_amount');
        $totalPurchases = $filteredPurchases->sum('net_amount');
        $totalExpenses = $filteredExpenses->sum('amount');
        $totalReceipts = $filteredVouchers->where('type', 'receipt')->sum('amount');
        $totalPayments = $filteredVouchers->where('type', 'payment')->sum('amount');

        // Detailed Party Ledger Statement if a Party is selected
        $ledgerEntries = collect();
        $selectedParty = null;
        if ($selectedPartyId) {
            $selectedParty = Party::find($selectedPartyId);

            // Fetch sales for party
            foreach ($filteredSales as $sale) {
                $ledgerEntries->push([
                    'date' => $sale->date,
                    'type' => 'Sale Invoice',
                    'ref' => $sale->invoice_no,
                    'description' => 'Sales Invoice #' . $sale->invoice_no,
                    'debit' => $sale->net_amount, // Increases customer balance
                    'credit' => 0,
                ]);
            }

            // Fetch purchases for party
            foreach ($filteredPurchases as $pur) {
                $ledgerEntries->push([
                    'date' => $pur->date,
                    'type' => 'Purchase Bill',
                    'ref' => $pur->invoice_no,
                    'description' => 'Purchase Bill #' . $pur->invoice_no,
                    'debit' => 0,
                    'credit' => $pur->net_amount, // Increases supplier balance
                ]);
            }

            // Fetch vouchers for party
            foreach ($filteredVouchers as $v) {
                if ($v->type === 'receipt') {
                    $ledgerEntries->push([
                        'date' => $v->date,
                        'type' => 'Receipt Voucher',
                        'ref' => $v->voucher_no,
                        'description' => 'Cash/Bank Receipt - ' . ($v->remarks ?? 'Voucher'),
                        'debit' => 0,
                        'credit' => $v->amount,
                    ]);
                } else {
                    $ledgerEntries->push([
                        'date' => $v->date,
                        'type' => 'Payment Voucher',
                        'ref' => $v->voucher_no,
                        'description' => 'Cash/Bank Payment - ' . ($v->remarks ?? 'Voucher'),
                        'debit' => $v->amount,
                        'credit' => 0,
                    ]);
                }
            }

            // Sort chronologically by date
            $ledgerEntries = $ledgerEntries->sortBy('date')->values();
        }

        // Cash Book Day-By-Day Matrix
        $cashBookDays = collect();
        $currentDate = \Carbon\Carbon::parse($fromDate);
        $endDate = \Carbon\Carbon::parse($toDate);

        // Precalculate opening cash prior to fromDate
        $priorSales = \App\Models\Sale::where('date', '<', $fromDate)->sum('net_amount');
        $priorReceipts = Voucher::where('type', 'receipt')->where('date', '<', $fromDate)->sum('amount');
        $priorPurchases = \App\Models\Purchase::where('date', '<', $fromDate)->sum('net_amount');
        $priorExpenses = Expense::where('date', '<', $fromDate)->sum('amount');
        $priorPayments = Voucher::where('type', 'payment')->where('date', '<', $fromDate)->sum('amount');

        $runningCash = ($priorSales + $priorReceipts) - ($priorPurchases + $priorExpenses + $priorPayments);

        while ($currentDate->lte($endDate)) {
            $dStr = $currentDate->format('Y-m-d');

            $daySales = $filteredSales->where('date', $dStr)->sum('net_amount');
            $dayReceipts = $filteredVouchers->where('type', 'receipt')->where('date', $dStr)->sum('amount');
            $dayCashIn = $daySales + $dayReceipts;

            $dayPurchases = $filteredPurchases->where('date', $dStr)->sum('net_amount');
            $dayExpenses = $filteredExpenses->where('date', $dStr)->sum('amount');
            $dayPayments = $filteredVouchers->where('type', 'payment')->where('date', $dStr)->sum('amount');
            $dayCashOut = $dayPurchases + $dayExpenses + $dayPayments;

            $closingCash = $runningCash + $dayCashIn - $dayCashOut;

            $cashBookDays->push([
                'date' => $dStr,
                'opening_cash' => $runningCash,
                'cash_in_sales' => $daySales,
                'cash_in_receipts' => $dayReceipts,
                'total_cash_in' => $dayCashIn,
                'cash_out_purchases' => $dayPurchases,
                'cash_out_expenses' => $dayExpenses,
                'cash_out_payments' => $dayPayments,
                'total_cash_out' => $dayCashOut,
                'closing_cash' => $closingCash,
            ]);

            $runningCash = $closingCash;
            $currentDate->addDay();
        }

        // Credit Limit & Overdue Report
        $creditLimitReport = $parties->map(function ($p) {
            return [
                'party_id' => $p->id,
                'code' => $p->code,
                'name' => $p->name,
                'phone' => $p->phone,
                'type' => $p->type,
                'credit_limit' => $p->credit_limit,
                'credit_days_limit' => $p->credit_days_limit,
                'current_balance' => $p->current_balance,
                'is_over_limit' => $p->credit_limit > 0 && $p->current_balance > $p->credit_limit,
            ];
        });

        $medicalReps = MedicalRep::latest()->get();
        $companies = Company::latest()->get();
        $salesmen = Salesman::latest()->get();
        $banks = Bank::latest()->get();
        $amanats = Amanat::with('party')->latest()->get();
        $lotteries = Lottery::latest()->get();

        return view('modules.reports', compact(
            'parties',
            'medicalReps',
            'companies',
            'salesmen',
            'banks',
            'amanats',
            'lotteries',
            'fromDate',
            'toDate',
            'selectedPartyId',
            'selectedParty',
            'totalSales',
            'totalPurchases',
            'totalExpenses',
            'totalReceipts',
            'totalPayments',
            'filteredSales',
            'filteredPurchases',
            'filteredExpenses',
            'filteredVouchers',
            'ledgerEntries',
            'cashBookDays',
            'creditLimitReport'
        ));
    }
}
