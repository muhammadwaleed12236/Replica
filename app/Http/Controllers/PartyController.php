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
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Setting;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    // Parties Management
    public function partiesIndex(Request $request)
    {
        $parties = Party::orderBy('name')->get();
        $currentParty = null;
        if ($request->has('id')) {
            $currentParty = Party::find($request->id);
        }

        // Generate next Party Code (e.g. P-1004)
        $maxId = Party::max('id') ?? 0;
        $counter = 1001 + $maxId;
        $existingCodes = Party::pluck('code')->toArray();
        while (in_array('P-' . $counter, $existingCodes)) {
            $counter++;
        }
        $nextCode = 'P-' . $counter;

        return view('modules.parties', compact('parties', 'currentParty', 'nextCode'));
    }

    public function partiesStore(Request $request)
    {
        $request->validate([
            'id' => 'nullable|exists:parties,id',
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'type' => 'required|in:customer,supplier,both',
            'phone' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:100',
            'opening_balance' => 'nullable|numeric',
            'credit_limit' => 'nullable|numeric|min:0',
            'credit_days_limit' => 'nullable|integer|min:0',
        ]);

        if ($request->filled('id')) {
            $party = Party::findOrFail($request->id);
            $party->update([
                'code' => $request->code,
                'name' => $request->name,
                'type' => $request->type,
                'phone' => $request->phone,
                'city' => $request->city,
                'opening_balance' => $request->opening_balance ?? 0,
                'credit_limit' => $request->credit_limit ?? 0,
                'credit_days_limit' => $request->credit_days_limit ?? 30,
            ]);
            $party->recalculateBalance();

            return redirect()->route('parties.index', ['id' => $party->id])
                ->with('success', "Party '{$party->name}' updated successfully in Ledger!");
        } else {
            $party = Party::create([
                'code' => $request->code,
                'name' => $request->name,
                'type' => $request->type,
                'phone' => $request->phone,
                'city' => $request->city,
                'opening_balance' => $request->opening_balance ?? 0,
                'current_balance' => $request->opening_balance ?? 0,
                'credit_limit' => $request->credit_limit ?? 0,
                'credit_days_limit' => $request->credit_days_limit ?? 30,
            ]);

            return redirect()->route('parties.index', ['id' => $party->id])
                ->with('success', "Party '{$party->name}' registered successfully!");
        }
    }

    public function partiesDestroy($id)
    {
        $party = Party::findOrFail($id);

        $hasSales = $party->sales()->exists();
        $hasPurchases = $party->purchases()->exists();
        $hasVouchers = $party->vouchers()->exists();

        if ($hasSales || $hasPurchases || $hasVouchers) {
            return redirect()->route('parties.index', ['id' => $party->id])
                ->withErrors(['delete' => "Cannot delete party '{$party->name}' because transactions (Sales, Purchases, or Vouchers) are linked to this ledger account."]);
        }

        $name = $party->name;
        $party->delete();

        return redirect()->route('parties.index')
            ->with('success', "Party '{$name}' deleted successfully.");
    }

    // Medical Reps Management
    public function medicalRepsIndex(Request $request)
    {
        $medicalReps = MedicalRep::latest()->get();
        $currentMedicalRep = null;
        if ($request->has('id')) {
            $currentMedicalRep = MedicalRep::find($request->id);
        }
        return view('modules.medical_reps', compact('medicalReps', 'currentMedicalRep'));
    }

    public function medicalRepsStore(Request $request)
    {
        $request->validate([
            'id' => 'nullable|exists:medical_reps,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'company_name' => 'nullable|string|max:255',
        ]);

        if ($request->filled('id')) {
            $medicalRep = MedicalRep::findOrFail($request->id);
            $medicalRep->update($request->only(['name', 'phone', 'company_name']));
            $msg = "Medical Rep '{$medicalRep->name}' updated successfully!";
        } else {
            $medicalRep = MedicalRep::create($request->only(['name', 'phone', 'company_name']));
            $msg = "Medical Rep '{$medicalRep->name}' created successfully!";
        }

        return redirect()->route('medical_reps.index', ['id' => $medicalRep->id])->with('success', $msg);
    }

    public function medicalRepsDestroy($id)
    {
        $medicalRep = MedicalRep::findOrFail($id);
        $name = $medicalRep->name;
        $medicalRep->delete();

        return redirect()->route('medical_reps.index')->with('success', "Medical Rep '{$name}' deleted successfully!");
    }

    // Companies Management
    public function companiesIndex(Request $request)
    {
        $companies = Company::latest()->get();
        $currentCompany = null;
        if ($request->has('id')) {
            $currentCompany = Company::find($request->id);
        }
        return view('modules.companies', compact('companies', 'currentCompany'));
    }

    public function companiesStore(Request $request)
    {
        $request->validate([
            'id' => 'nullable|exists:companies,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:100',
        ]);

        if ($request->filled('id')) {
            $company = Company::findOrFail($request->id);
            $company->update($request->only(['name', 'phone', 'city']));
            $msg = "Company '{$company->name}' updated successfully!";
        } else {
            $company = Company::create($request->only(['name', 'phone', 'city']));
            $msg = "Company '{$company->name}' created successfully!";
        }

        return redirect()->route('companies.index', ['id' => $company->id])->with('success', $msg);
    }

    public function companiesDestroy($id)
    {
        $company = Company::findOrFail($id);
        if (Purchase::where('company_id', $id)->exists()) {
            return redirect()->back()->withErrors(['error' => "Cannot delete Company '{$company->name}' because it is linked to existing purchase invoices."]);
        }
        $name = $company->name;
        $company->delete();

        return redirect()->route('companies.index')->with('success', "Company '{$name}' deleted successfully!");
    }

    // Salesmen Management
    public function salesmenIndex(Request $request)
    {
        $salesmen = Salesman::latest()->get();
        $currentSalesman = null;
        if ($request->has('id')) {
            $currentSalesman = Salesman::find($request->id);
        }
        return view('modules.salesmen', compact('salesmen', 'currentSalesman'));
    }

    public function salesmenStore(Request $request)
    {
        $request->validate([
            'id' => 'nullable|exists:salesmen,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
        ]);

        $data = $request->only(['name', 'phone', 'commission_rate']);
        $data['commission_rate'] = $data['commission_rate'] ?? 0;

        if ($request->filled('id')) {
            $salesman = Salesman::findOrFail($request->id);
            $salesman->update($data);
            $msg = "Salesman '{$salesman->name}' updated successfully!";
        } else {
            $salesman = Salesman::create($data);
            $msg = "Salesman '{$salesman->name}' created successfully!";
        }

        return redirect()->route('salesmen.index', ['id' => $salesman->id])->with('success', $msg);
    }

    public function salesmenDestroy($id)
    {
        $salesman = Salesman::findOrFail($id);
        if (Sale::where('salesman_id', $id)->exists()) {
            return redirect()->back()->withErrors(['error' => "Cannot delete Salesman '{$salesman->name}' because they are linked to existing sales invoices."]);
        }
        $name = $salesman->name;
        $salesman->delete();

        return redirect()->route('salesmen.index')->with('success', "Salesman '{$name}' deleted successfully!");
    }

    // Banks Management
    public function banksIndex(Request $request)
    {
        $banks = Bank::latest()->get();
        $currentBank = null;
        if ($request->has('id')) {
            $currentBank = Bank::find($request->id);
        }
        return view('modules.banks', compact('banks', 'currentBank'));
    }

    public function banksStore(Request $request)
    {
        $request->validate([
            'id' => 'nullable|exists:banks,id',
            'bank_name' => 'required|string|max:255',
            'account_title' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'balance' => 'nullable|numeric',
        ]);

        $data = $request->only(['bank_name', 'account_title', 'account_number', 'balance']);
        $data['balance'] = $data['balance'] ?? 0;

        if ($request->filled('id')) {
            $bank = Bank::findOrFail($request->id);
            $bank->update($data);
            $msg = "Bank Account '{$bank->bank_name} - {$bank->account_number}' updated successfully!";
        } else {
            $bank = Bank::create($data);
            $msg = "Bank Account '{$bank->bank_name} - {$bank->account_number}' created successfully!";
        }

        return redirect()->route('banks.index', ['id' => $bank->id])->with('success', $msg);
    }

    public function banksDestroy($id)
    {
        $bank = Bank::findOrFail($id);
        $title = "{$bank->bank_name} ({$bank->account_number})";
        $bank->delete();

        return redirect()->route('banks.index')->with('success', "Bank Account '{$title}' deleted successfully!");
    }

    // Amanats Management
    public function amanatsIndex(Request $request)
    {
        $amanats = Amanat::with('party')->latest()->get();
        $parties = Party::orderBy('name')->get();
        $currentAmanat = null;
        if ($request->has('id')) {
            $currentAmanat = Amanat::with('party')->find($request->id);
        }
        return view('modules.amanats', compact('amanats', 'parties', 'currentAmanat'));
    }

    public function amanatsStore(Request $request)
    {
        $request->validate([
            'id' => 'nullable|exists:amanats,id',
            'party_id' => 'nullable|exists:parties,id',
            'depositor_name' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'details' => 'nullable|string',
        ]);

        $data = $request->only(['party_id', 'depositor_name', 'amount', 'date', 'details']);

        if ($request->filled('id')) {
            $amanat = Amanat::findOrFail($request->id);
            $amanat->update($data);
            $msg = "Amanat deposit record updated successfully!";
        } else {
            $amanat = Amanat::create($data);
            $msg = "Amanat deposit of Rs. " . number_format($amanat->amount, 2) . " recorded successfully!";
        }

        return redirect()->route('amanats.index', ['id' => $amanat->id])->with('success', $msg);
    }

    public function amanatsDestroy($id)
    {
        $amanat = Amanat::findOrFail($id);
        $amanat->delete();

        return redirect()->route('amanats.index')->with('success', "Amanat record deleted successfully!");
    }

    // Lotteries Management
    public function lotteriesIndex(Request $request)
    {
        $lotteries = Lottery::latest()->get();
        $currentLottery = null;
        if ($request->has('id')) {
            $currentLottery = Lottery::find($request->id);
        }
        return view('modules.lotteries', compact('lotteries', 'currentLottery'));
    }

    public function lotteriesStore(Request $request)
    {
        $request->validate([
            'id' => 'nullable|exists:lotteries,id',
            'scheme_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'status' => 'nullable|string|max:50',
            'remarks' => 'nullable|string',
        ]);

        $data = $request->only(['scheme_name', 'amount', 'date', 'status', 'remarks']);
        $data['status'] = $data['status'] ?: 'Pending';

        if ($request->filled('id')) {
            $lottery = Lottery::findOrFail($request->id);
            $lottery->update($data);
            $msg = "Lottery scheme '{$lottery->scheme_name}' updated successfully!";
        } else {
            $lottery = Lottery::create($data);
            $msg = "Lottery scheme '{$lottery->scheme_name}' created successfully!";
        }

        return redirect()->route('lotteries.index', ['id' => $lottery->id])->with('success', $msg);
    }

    public function lotteriesDestroy($id)
    {
        $lottery = Lottery::findOrFail($id);
        $name = $lottery->scheme_name;
        $lottery->delete();

        return redirect()->route('lotteries.index')->with('success', "Lottery scheme '{$name}' deleted successfully!");
    }

    // Expenses Management
    public function expensesIndex(Request $request)
    {
        $expenses = Expense::latest()->get();
        $currentExpense = null;
        if ($request->has('id')) {
            $currentExpense = Expense::find($request->id);
        }
        $lockedDate = Setting::get('date_lock_date');
        return view('modules.expenses', compact('expenses', 'currentExpense', 'lockedDate'));
    }

    public function expensesStore(Request $request)
    {
        $request->validate([
            'id' => 'nullable|exists:expenses,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'category' => 'nullable|string|max:100',
            'remarks' => 'nullable|string',
        ]);

        // Date Lock Validation
        $dateLockDate = Setting::get('date_lock_date');
        if ($dateLockDate && $request->date <= $dateLockDate && !$request->has('admin_override')) {
            return redirect()->back()->withErrors(['date' => 'Date Lock is active for dates on or before ' . $dateLockDate . '. Entry blocked!']);
        }

        $data = $request->only(['title', 'amount', 'date', 'category', 'remarks']);
        $data['category'] = $data['category'] ?: 'General';

        if ($request->filled('id')) {
            $expense = Expense::findOrFail($request->id);
            $expense->update($data);
            $msg = "Expense '{$expense->title}' updated successfully!";
        } else {
            $expense = Expense::create($data);
            $msg = "Expense '{$expense->title}' recorded successfully!";
        }

        return redirect()->route('expenses.index', ['id' => $expense->id])->with('success', $msg);
    }

    public function expensesDestroy($id)
    {
        $expense = Expense::findOrFail($id);
        // Check date lock
        $dateLockDate = Setting::get('date_lock_date');
        if ($dateLockDate && $expense->date <= $dateLockDate) {
            return redirect()->back()->withErrors(['error' => 'Cannot delete locked expense record prior to ' . $dateLockDate]);
        }
        $title = $expense->title;
        $expense->delete();

        return redirect()->route('expenses.index')->with('success', "Expense '{$title}' deleted successfully!");
    }

    // Receipts & Payments Vouchers
    public function vouchersIndex(Request $request, $type)
    {
        if (!in_array($type, ['receipt', 'payment'])) {
            abort(404);
        }

        $parties = Party::orderBy('name')->get();
        
        $currentVoucher = null;
        if ($request->has('id')) {
            $currentVoucher = Voucher::with('party')->where('type', $type)->find($request->id);
        }

        $allVouchers = Voucher::with('party')->where('type', $type)->latest()->get();
        $vouchers = $allVouchers;

        // Systematic voucher numbering (e.g. RCT-00001, PMT-00001)
        $prefix = $type === 'receipt' ? 'RCT-' : 'PMT-';
        $maxId = Voucher::where('type', $type)->max('id') ?? 0;
        $nextVoucherNo = $prefix . str_pad($maxId + 1, 5, '0', STR_PAD_LEFT);

        return view('modules.vouchers', compact('vouchers', 'allVouchers', 'parties', 'type', 'currentVoucher', 'nextVoucherNo'));
    }

    public function vouchersStore(Request $request)
    {
        $request->validate([
            'id' => 'nullable|exists:vouchers,id',
            'type' => 'required|in:receipt,payment',
            'date' => 'required|date',
            'party_id' => 'required|exists:parties,id',
            'voucher_no' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'payment_mode' => 'nullable|string',
            'reference_no' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        // Check Date Lock
        $dateLockDate = \App\Models\Setting::get('date_lock_date');
        if ($dateLockDate && $request->date <= $dateLockDate && !$request->has('admin_override')) {
            return redirect()->back()->withErrors(['date' => 'Date Lock is active for dates on or before ' . $dateLockDate . '. Entry blocked!']);
        }

        $oldParty = null;
        if ($request->filled('id')) {
            $voucher = Voucher::findOrFail($request->id);
            $oldParty = $voucher->party;
            $voucher->update([
                'type' => $request->type,
                'date' => $request->date,
                'party_id' => $request->party_id,
                'voucher_no' => $request->voucher_no,
                'amount' => $request->amount,
                'payment_mode' => $request->payment_mode ?? 'Cash',
                'reference_no' => $request->reference_no,
                'remarks' => $request->remarks,
            ]);

            if ($oldParty) {
                $oldParty->recalculateBalance();
            }
            if ($voucher->party && $voucher->party_id != $oldParty?->id) {
                $voucher->party->recalculateBalance();
            }

            return redirect()->route('vouchers.index', ['type' => $voucher->type, 'id' => $voucher->id])
                ->with('success', ucfirst($voucher->type) . ' voucher (' . $voucher->voucher_no . ') updated successfully!');
        } else {
            $voucherNo = $request->voucher_no;
            if (Voucher::where('voucher_no', $voucherNo)->exists()) {
                $prefix = $request->type === 'receipt' ? 'RCT-' : 'PMT-';
                $maxId = Voucher::where('type', $request->type)->max('id') ?? 0;
                $voucherNo = $prefix . str_pad($maxId + 1, 5, '0', STR_PAD_LEFT);
            }

            $voucher = Voucher::create([
                'voucher_no' => $voucherNo,
                'type' => $request->type,
                'date' => $request->date,
                'party_id' => $request->party_id,
                'amount' => $request->amount,
                'payment_mode' => $request->payment_mode ?? 'Cash',
                'reference_no' => $request->reference_no,
                'remarks' => $request->remarks,
            ]);

            if ($voucher->party) {
                $voucher->party->recalculateBalance();
            }

            return redirect()->route('vouchers.index', ['type' => $voucher->type, 'id' => $voucher->id])
                ->with('success', ucfirst($voucher->type) . ' voucher (' . $voucher->voucher_no . ') recorded successfully!');
        }
    }

    public function vouchersDestroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $type = $voucher->type;
        $party = $voucher->party;
        $voucherNo = $voucher->voucher_no;
        $voucher->delete();

        if ($party) {
            $party->recalculateBalance();
        }

        return redirect()->route('vouchers.index', $type)
            ->with('success', ucfirst($type) . ' voucher (' . $voucherNo . ') deleted & party ledger balance recalculated!');
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
