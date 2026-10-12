<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
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

        $products = \App\Models\PurchaseItem::select('item_name')
            ->union(\App\Models\SaleItem::select('item_name'))
            ->whereNotNull('item_name')
            ->where('item_name', '!=', '')
            ->distinct()
            ->pluck('item_name');

        $allPurchases = Purchase::with(['party', 'items'])->latest()->get();
        $nextInvoiceNo = 'PUR-' . str_pad((Purchase::max('id') + 1), 5, '0', STR_PAD_LEFT);

        return view('purchases.index', compact('parties', 'companies', 'currentPurchase', 'allPurchases', 'nextInvoiceNo', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|exists:purchases,id',
            'date' => 'required|date',
            'party_id' => 'required|exists:parties,id',
            'company_id' => 'nullable|exists:companies,id',
            'invoice_no' => 'required|string',
            'product_name' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
        ]);

        // Check Date Lock
        $dateLockDate = \App\Models\Setting::get('date_lock_date');
        if ($dateLockDate && $request->date <= $dateLockDate && !$request->has('admin_override')) {
            return redirect()->back()->withErrors(['date' => 'Date Lock is active for dates on or before ' . $dateLockDate . '. Entry blocked!']);
        }

        $subtotal = (float) $request->amount;
        $discount = (float) ($request->discount ?? 0);
        $netAmount = max(0, $subtotal - $discount);

        $oldParty = null;
        if ($request->filled('id')) {
            $purchase = Purchase::findOrFail($request->id);
            $oldParty = $purchase->party;
            $purchase->update([
                'date' => $request->date,
                'party_id' => $request->party_id,
                'company_id' => $request->company_id,
                'invoice_no' => $request->invoice_no,
                'amount' => $subtotal,
                'discount' => $discount,
                'net_amount' => $netAmount,
                'remarks' => $request->remarks,
            ]);
        } else {
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
        }

        // Save or update Product Item record
        if ($request->filled('product_name')) {
            $purchase->items()->delete();
            $purchase->items()->create([
                'item_name' => trim($request->product_name),
                'qty' => 1,
                'rate' => $netAmount,
                'total' => $netAmount,
            ]);
        }

        // Recalculate party balances
        if ($oldParty && $oldParty->id != $purchase->party_id) {
            $oldParty->recalculateBalance();
        }

        if ($purchase->party) {
            $purchase->party->recalculateBalance();
        }

        return redirect()->route('purchases.index', ['id' => $purchase->id])
            ->with('success', 'Purchase Bill ' . $purchase->invoice_no . ' saved successfully in Ledger!');
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
            ->with('success', 'Purchase Bill ' . $invoiceNo . ' deleted and ledger balance reversed successfully.');
    }
}
