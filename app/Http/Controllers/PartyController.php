<?php

namespace App\Http\Controllers;

use App\Models\Party;
use App\Models\Expense;
use App\Models\Voucher;
use App\Models\Bank;
use App\Models\Salesman;
use App\Models\Company;
use App\Models\Product;
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
        ]);

        Party::create([
            'code' => 'P-' . rand(1000, 9999),
            'name' => $request->name,
            'type' => $request->type,
            'phone' => $request->phone,
            'city' => $request->city,
            'opening_balance' => $request->opening_balance ?? 0,
            'current_balance' => $request->opening_balance ?? 0,
        ]);

        return redirect()->back()->with('success', 'Party created successfully!');
    }

    // Products Management with Barcode
    public function productsIndex()
    {
        $products = Product::with('company')->latest()->get();
        $companies = Company::orderBy('name')->get();
        return view('modules.products', compact('products', 'companies'));
    }

    public function productsStore(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string|unique:products,barcode',
            'name' => 'required|string|max:255',
            'company_id' => 'nullable|exists:companies,id',
            'purchase_price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'wholesale_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
        ]);

        Product::create([
            'barcode' => $request->barcode,
            'name' => $request->name,
            'company_id' => $request->company_id,
            'category' => $request->category ?? 'General',
            'unit' => $request->unit ?? 'Pcs',
            'purchase_price' => $request->purchase_price ?? 0,
            'sale_price' => $request->sale_price ?? 0,
            'wholesale_price' => $request->wholesale_price ?? 0,
            'stock_quantity' => $request->stock_quantity ?? 0,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Product added successfully with barcode!');
    }

    public function productsDestroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully!');
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
        $salesQuery = \App\Models\Sale::with(['party', 'items', 'salesman'])->whereBetween('date', [$fromDate, $toDate]);
        $purchasesQuery = \App\Models\Purchase::with(['party', 'company'])->whereBetween('date', [$fromDate, $toDate]);
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

        $grossProfit = $totalSales - $totalPurchases;
        $netProfit = $grossProfit - $totalExpenses;

        // Customer-Wise Sales Summary
        $customerSalesSummary = $filteredSales->groupBy('party_id')->map(function ($sales) {
            $party = $sales->first()->party;
            return [
                'party_name' => $party->name ?? 'Walk-in Customer',
                'party_code' => $party->code ?? 'N/A',
                'party_type' => $party->type ?? 'customer',
                'invoice_count' => $sales->count(),
                'total_amount' => $sales->sum('net_amount'),
            ];
        })->sortByDesc('total_amount')->values();

        // Product-Wise Sales Summary
        $productSalesSummary = collect();
        foreach ($filteredSales as $sale) {
            foreach ($sale->items as $item) {
                $name = $item->item_name;
                if (!$productSalesSummary->has($name)) {
                    $productSalesSummary->put($name, [
                        'item_name' => $name,
                        'total_qty' => 0,
                        'total_revenue' => 0,
                    ]);
                }
                $curr = $productSalesSummary->get($name);
                $curr['total_qty'] += $item->qty;
                $curr['total_revenue'] += $item->total;
                $productSalesSummary->put($name, $curr);
            }
        }
        $productSalesSummary = $productSalesSummary->sortByDesc('total_revenue')->values();

        // Supplier-Wise Purchase Summary
        $supplierPurchaseSummary = $filteredPurchases->groupBy('party_id')->map(function ($purchases) {
            $party = $purchases->first()->party;
            return [
                'party_name' => $party->name ?? 'Direct Purchase',
                'party_code' => $party->code ?? 'N/A',
                'bill_count' => $purchases->count(),
                'total_amount' => $purchases->sum('net_amount'),
            ];
        })->sortByDesc('total_amount')->values();

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

        $products = Product::with('company')->latest()->get();
        $companies = Company::latest()->get();
        $salesmen = Salesman::latest()->get();
        $banks = Bank::latest()->get();

        // Category-Wise Stock Summary
        $categoryStockSummary = $products->groupBy(function ($p) {
            return $p->category ?: 'General';
        })->map(function ($prods, $catName) {
            return [
                'category' => $catName,
                'product_count' => $prods->count(),
                'total_qty' => $prods->sum('stock_quantity'),
                'purchase_val' => $prods->sum(function ($p) {
                    return ($p->purchase_price ?? 0) * ($p->stock_quantity ?? 0);
                }),
                'retail_val' => $prods->sum(function ($p) {
                    return ($p->sale_price ?? 0) * ($p->stock_quantity ?? 0);
                }),
                'wholesale_val' => $prods->sum(function ($p) {
                    return ($p->wholesale_price ?? 0) * ($p->stock_quantity ?? 0);
                }),
            ];
        })->sortByDesc('retail_val')->values();

        // Stock Valuation Calculations
        $totalStockQty = $products->sum('stock_quantity');
        $stockPurchaseValue = $products->sum(function ($p) {
            return ($p->purchase_price ?? 0) * ($p->stock_quantity ?? 0);
        });
        $stockRetailValue = $products->sum(function ($p) {
            return ($p->sale_price ?? 0) * ($p->stock_quantity ?? 0);
        });
        $stockWholesaleValue = $products->sum(function ($p) {
            return ($p->wholesale_price ?? 0) * ($p->stock_quantity ?? 0);
        });

        return view('modules.reports', compact(
            'parties',
            'products',
            'companies',
            'salesmen',
            'banks',
            'fromDate',
            'toDate',
            'selectedPartyId',
            'selectedParty',
            'totalSales',
            'totalPurchases',
            'totalExpenses',
            'totalReceipts',
            'totalPayments',
            'grossProfit',
            'netProfit',
            'filteredSales',
            'filteredPurchases',
            'filteredExpenses',
            'filteredVouchers',
            'ledgerEntries',
            'totalStockQty',
            'stockPurchaseValue',
            'stockRetailValue',
            'stockWholesaleValue',
            'customerSalesSummary',
            'productSalesSummary',
            'supplierPurchaseSummary',
            'categoryStockSummary'
        ));
    }
}
