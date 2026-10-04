<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Party;
use App\Models\Company;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $parties = Party::orderBy('name')->get();
        $companies = Company::orderBy('name')->get();
        
        $currentPurchase = null;
        if ($request->has('id')) {
            $currentPurchase = Purchase::with(['party', 'company', 'items'])->find($request->id);
        }

        $allPurchases = Purchase::with('party')->latest()->get();
        $nextInvoiceNo = 'PUR-' . str_pad((Purchase::max('id') + 1), 5, '0', STR_PAD_LEFT);

        return view('purchases.index', compact('parties', 'companies', 'currentPurchase', 'allPurchases', 'nextInvoiceNo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'party_id' => 'required|exists:parties,id',
            'company_id' => 'nullable|exists:companies,id',
            'invoice_no' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
            'items' => 'nullable|array',
        ]);

        $subtotal = (float) $request->amount;
        $discount = (float) ($request->discount ?? 0);
        $netAmount = max(0, $subtotal - $discount);

        $purchase = Purchase::updateOrCreate(
            ['invoice_no' => $request->invoice_no],
            [
                'date' => $request->date,
                'party_id' => $request->party_id,
                'company_id' => $request->company_id,
                'amount' => $subtotal,
                'discount' => $discount,
                'net_amount' => $netAmount,
                'remarks' => $request->remarks,
            ]
        );

        if (!empty($request->items)) {
            $purchase->items()->delete();
            foreach ($request->items as $item) {
                if (!empty($item['name'])) {
                    $qty = (int) ($item['qty'] ?? 1);
                    $rate = (float) ($item['rate'] ?? 0);
                    $purchase->items()->create([
                        'item_name' => $item['name'],
                        'qty' => $qty,
                        'rate' => $rate,
                        'total' => $qty * $rate,
                    ]);
                }
            }
        }

        if ($purchase->party) {
            $purchase->party->recalculateBalance();
        }

        return redirect()->route('purchases.index', ['id' => $purchase->id])
            ->with('success', 'Purchase Bill ' . $purchase->invoice_no . ' saved successfully!');
    }

    public function destroy($id)
    {
        $purchase = Purchase::findOrFail($id);
        $invoiceNo = $purchase->invoice_no;
        $party = $purchase->party;
        $purchase->delete();

        if ($party) {
            $party->recalculateBalance();
        }

        return redirect()->route('purchases.index')
            ->with('success', 'Purchase Bill ' . $invoiceNo . ' deleted successfully.');
    }
}
