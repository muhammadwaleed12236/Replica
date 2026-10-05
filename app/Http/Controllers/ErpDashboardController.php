<?php

namespace App\Http\Controllers;

use App\Models\Party;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Expense;
use App\Models\Voucher;
use App\Models\Bank;
use App\Models\Salesman;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;

class ErpDashboardController extends Controller
{
    public function index()
    {
        $partiesCount = Party::count();
        $productsCount = Product::count();
        $companiesCount = Company::count();
        $salesmenCount = Salesman::count();
        $banksCount = Bank::count();
        $salesCount = Sale::count();
        $purchasesCount = Purchase::count();
        $expensesTotal = Expense::sum('amount');
        $totalSalesAmount = Sale::sum('net_amount');
        $totalPurchaseAmount = Purchase::sum('net_amount');
        
        $receiptsTotal = Voucher::where('type', 'receipt')->sum('amount');
        $paymentsTotal = Voucher::where('type', 'payment')->sum('amount');

        $latestSales = Sale::with('party')->latest()->take(5)->get();
        $latestPurchases = Purchase::with('party')->latest()->take(5)->get();

        return view('dashboard', compact(
            'partiesCount',
            'productsCount',
            'companiesCount',
            'salesmenCount',
            'banksCount',
            'salesCount',
            'purchasesCount',
            'expensesTotal',
            'totalSalesAmount',
            'totalPurchaseAmount',
            'receiptsTotal',
            'paymentsTotal',
            'latestSales',
            'latestPurchases'
        ));
    }
}
