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
            $currentPurchase = Purchase::with(['party', 'company'])->find($request->id);
        }

        $allPurchases = Purchase::with('party')->latest()->get();
        $nextInvoiceNo = '';

        return view('purchases.index', compact('parties', 'companies', 'currentPurchase', 'allPurchases', 'nextInvoiceNo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|exists:purchases,id',
            'date' => 'required|date',
            'party_id' => 'required|exists:parties,id',
            'company_id' => 'nullable|exists:companies,id',
            'invoice_no' => 'nullable|string',
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
        $invoiceNo = !empty(trim($request->invoice_no ?? '')) ? trim($request->invoice_no) : null;

        $oldParty = null;
        if ($request->filled('id')) {
            $purchase = Purchase::findOrFail($request->id);
            $oldParty = $purchase->party;
            $purchase->update([
                'date' => $request->date,
                'party_id' => $request->party_id,
                'company_id' => $request->company_id,
                'invoice_no' => $invoiceNo,
                'amount' => $subtotal,
                'discount' => $discount,
                'net_amount' => $netAmount,
                'remarks' => $request->remarks,
            ]);
        } else {
            $purchase = Purchase::create([
                'date' => $request->date,
                'party_id' => $request->party_id,
                'company_id' => $request->company_id,
                'invoice_no' => $invoiceNo,
                'amount' => $subtotal,
                'discount' => $discount,
                'net_amount' => $netAmount,
                'remarks' => $request->remarks,
            ]);
        }

        // Recalculate party balances
        if ($oldParty && $oldParty->id != $purchase->party_id) {
            $oldParty->recalculateBalance();
        }

        if ($purchase->party) {
            $purchase->party->recalculateBalance();
        }

        $invDisplay = $purchase->invoice_no ? ('Bill ' . $purchase->invoice_no) : ('#' . $purchase->id);
        return redirect()->route('purchases.index', ['id' => $purchase->id])
            ->with('success', 'Purchase ' . $invDisplay . ' saved successfully in Ledger!');
    }

    public function destroy($id)
    {
        $purchase = Purchase::findOrFail($id);
        $invDisplay = $purchase->invoice_no ? ('Bill ' . $purchase->invoice_no) : ('#' . $purchase->id);
        $party = $purchase->party;
        $purchase->delete();

        if ($party) {
            $party->recalculateBalance();
        }

        return redirect()->route('purchases.index')
            ->with('success', 'Purchase ' . $invDisplay . ' deleted and ledger balance reversed successfully.');
    }
}
