<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Party;
use App\Models\Salesman;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $parties = Party::orderBy('name')->get();
        $salesmen = Salesman::orderBy('name')->get();
        $products = Product::with('company')->orderBy('name')->get();
        
        // Load target sale if ID provided or load latest
        $currentSale = null;
        if ($request->has('id')) {
            $currentSale = Sale::with(['party', 'salesman', 'items'])->find($request->id);
        }

        $allSales = Sale::with('party')->latest()->get();
        $nextInvoiceNo = 'INV-' . str_pad((Sale::max('id') + 1), 5, '0', STR_PAD_LEFT);

        return view('sales.index', compact('parties', 'salesmen', 'products', 'currentSale', 'allSales', 'nextInvoiceNo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'party_id' => 'required|exists:parties,id',
            'salesman_id' => 'nullable|exists:salesmen,id',
            'invoice_no' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
            'items' => 'nullable|array',
        ]);

        $subtotal = (float) $request->amount;
        $discount = (float) ($request->discount ?? 0);
        $netAmount = max(0, $subtotal - $discount);

        $sale = Sale::updateOrCreate(
            ['invoice_no' => $request->invoice_no],
            [
                'date' => $request->date,
                'party_id' => $request->party_id,
                'salesman_id' => $request->salesman_id,
                'amount' => $subtotal,
                'discount' => $discount,
                'net_amount' => $netAmount,
                'remarks' => $request->remarks,
            ]
        );

        // Update items if passed
        if (!empty($request->items)) {
            $sale->items()->delete();
            foreach ($request->items as $item) {
                if (!empty($item['name'])) {
                    $qty = (int) ($item['qty'] ?? 1);
                    $rate = (float) ($item['rate'] ?? 0);
                    $sale->items()->create([
                        'item_name' => $item['name'],
                        'qty' => $qty,
                        'rate' => $rate,
                        'total' => $qty * $rate,
                    ]);
                }
            }
        }

        // Recalculate Party Balance
        if ($sale->party) {
            $sale->party->recalculateBalance();
        }

        return redirect()->route('sales.index', ['id' => $sale->id])
            ->with('success', 'Sale Invoice ' . $sale->invoice_no . ' saved successfully!');
    }

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $invoiceNo = $sale->invoice_no;
        $party = $sale->party;
        $sale->delete();

        if ($party) {
            $party->recalculateBalance();
        }

        return redirect()->route('sales.index')
            ->with('success', 'Sale Invoice ' . $invoiceNo . ' deleted successfully.');
    }
}
