<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Party;
use App\Models\Salesman;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $parties = Party::orderBy('name')->get();
        $salesmen = Salesman::orderBy('name')->get();
        
        $currentSale = null;
        if ($request->has('id')) {
            $currentSale = Sale::with(['party', 'salesman', 'items'])->find($request->id);
        }

        $products = \App\Models\SaleItem::select('item_name')
            ->union(\App\Models\PurchaseItem::select('item_name'))
            ->whereNotNull('item_name')
            ->where('item_name', '!=', '')
            ->distinct()
            ->pluck('item_name');

        $allSales = Sale::with(['party', 'items'])->latest()->get();
        $nextInvoiceNo = 'INV-' . str_pad((Sale::max('id') + 1), 5, '0', STR_PAD_LEFT);

        $dateLockDate = \App\Models\Setting::get('date_lock_date');
        $minDate = $dateLockDate ? \Carbon\Carbon::parse($dateLockDate)->addDay()->format('Y-m-d') : null;

        return view('sales.index', compact('parties', 'salesmen', 'currentSale', 'allSales', 'nextInvoiceNo', 'dateLockDate', 'minDate', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|exists:sales,id',
            'date' => 'required|date',
            'party_id' => 'required|exists:parties,id',
            'salesman_id' => 'nullable|exists:salesmen,id',
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

        // Check Party Credit Limit
        $party = Party::find($request->party_id);
        if ($party && $party->credit_limit > 0 && !$request->has('admin_override')) {
            $existingAmount = 0;
            if ($request->filled('id')) {
                $existingSale = Sale::find($request->id);
                if ($existingSale && $existingSale->party_id == $party->id) {
                    $existingAmount = $existingSale->net_amount;
                }
            }
            if (($party->current_balance - $existingAmount + $netAmount) > $party->credit_limit) {
                return redirect()->back()->with('credit_warning', 'Customer ' . $party->name . ' credit limit of Rs. ' . number_format($party->credit_limit, 2) . ' exceeded! Current balance: Rs. ' . number_format($party->current_balance, 2));
            }
        }

        $oldParty = null;
        if ($request->filled('id')) {
            $sale = Sale::findOrFail($request->id);
            $oldParty = $sale->party;
            $sale->update([
                'date' => $request->date,
                'party_id' => $request->party_id,
                'salesman_id' => $request->salesman_id,
                'invoice_no' => $request->invoice_no,
                'amount' => $subtotal,
                'discount' => $discount,
                'net_amount' => $netAmount,
                'remarks' => $request->remarks,
            ]);
        } else {
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
        }

        // Save or update Product Item record
        if ($request->filled('product_name')) {
            $sale->items()->delete();
            $sale->items()->create([
                'item_name' => trim($request->product_name),
                'qty' => 1,
                'rate' => $netAmount,
                'total' => $netAmount,
            ]);
        }

        // Recalculate Party Balance
        if ($oldParty && $oldParty->id != $sale->party_id) {
            $oldParty->recalculateBalance();
        }

        if ($sale->party) {
            $sale->party->recalculateBalance();

            // Auto-send Direct Background WhatsApp Message if phone exists
            if (!empty($sale->party->phone)) {
                $tmpl = \App\Models\Setting::get('whatsapp_template', 'Dear {customer_name}, Invoice #{invoice_no} total amount is Rs. {amount}. Date: {date}.');
                $msg = str_replace(
                    ['{customer_name}', '{invoice_no}', '{amount}', '{date}'],
                    [$sale->party->name, $sale->invoice_no, number_format($sale->net_amount, 2), $sale->date],
                    $tmpl
                );
                \App\Services\WhatsAppService::sendDirectMessage($sale->party->phone, $msg);
            }
        }

        return redirect()->route('sales.index', ['id' => $sale->id])
            ->with('success', 'Sale Invoice ' . $sale->invoice_no . ' saved successfully in Ledger!');
    }

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);

        // Check Date Lock
        $dateLockDate = \App\Models\Setting::get('date_lock_date');
        if ($dateLockDate && $sale->date <= $dateLockDate && !request()->has('admin_override')) {
            return redirect()->back()->withErrors(['date' => 'Date Lock is active for dates on or before ' . $dateLockDate . '. Deletion blocked!']);
        }

        $invoiceNo = $sale->invoice_no;
        $party = $sale->party;
        $sale->delete();

        if ($party) {
            $party->recalculateBalance();
        }

        return redirect()->route('sales.index')
            ->with('success', 'Sale Invoice ' . $invoiceNo . ' deleted and ledger balance reversed successfully.');
    }
}
