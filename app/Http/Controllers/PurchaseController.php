<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Party;
use App\Models\Company;
use App\Models\Product;
use App\Services\UnitConversionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    protected $unitService;

    public function __construct(UnitConversionService $unitService)
    {
        $this->unitService = $unitService;
    }

    public function index(Request $request)
    {
        $parties = Party::orderBy('name')->get();
        $companies = Company::orderBy('name')->get();
        $products = Product::with(['company', 'units'])->orderBy('name')->get();
        
        $currentPurchase = null;
        if ($request->has('id')) {
            $currentPurchase = Purchase::with(['party', 'company', 'items.product'])->find($request->id);
        }

        $allPurchases = Purchase::with('party')->latest()->get();
        $nextInvoiceNo = 'PUR-' . str_pad((Purchase::max('id') + 1), 5, '0', STR_PAD_LEFT);
        
        $initialItems = old('items');
        if (!$initialItems) {
            if ($currentPurchase && $currentPurchase->items->count() > 0) {
                $initialItems = $currentPurchase->items->map(function ($i) {
                    return [
                        'name' => $i->item_name,
                        'product_id' => $i->product_id,
                        'qty' => (float) $i->qty,
                        'unit_name' => $i->unit_name,
                        'rate' => (float) $i->rate,
                    ];
                })->values()->toArray();
            } else {
                $initialItems = [
                    ['name' => '', 'product_id' => '', 'qty' => 1, 'unit_name' => '', 'rate' => 0]
                ];
            }
        }

        return view('purchases.index', compact('parties', 'companies', 'products', 'currentPurchase', 'allPurchases', 'nextInvoiceNo', 'initialItems'));
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

        return DB::transaction(function () use ($request) {
            $subtotal = (float) $request->amount;
            $discount = (float) ($request->discount ?? 0);
            $netAmount = max(0, $subtotal - $discount);

            $purchase = Purchase::where('invoice_no', $request->invoice_no)->first();
            if ($purchase) {
                // Deduct old stock before deleting
                foreach ($purchase->items as $oldItem) {
                    if ($oldItem->product_id) {
                        $product = Product::find($oldItem->product_id);
                        if ($product) {
                            $product->stock_quantity -= $oldItem->base_qty;
                            // Allowing negative stock on purchase edit rollback is generally okay, but could be restricted.
                            $product->save();
                        }
                    }
                }
                $purchase->items()->delete();
                $purchase->update([
                    'date' => $request->date,
                    'party_id' => $request->party_id,
                    'company_id' => $request->company_id,
                    'amount' => $subtotal,
                    'discount' => $discount,
                    'net_amount' => $netAmount,
                    'remarks' => $request->remarks,
                ]);
            } else {
                $purchase = Purchase::create([
                    'invoice_no' => $request->invoice_no,
                    'date' => $request->date,
                    'party_id' => $request->party_id,
                    'company_id' => $request->company_id,
                    'amount' => $subtotal,
                    'discount' => $discount,
                    'net_amount' => $netAmount,
                    'remarks' => $request->remarks,
                ]);
            }

            if (!empty($request->items)) {
                foreach ($request->items as $item) {
                    if (!empty($item['name'])) {
                        $productId = $item['product_id'] ?? null;
                        if (!$productId) {
                            $foundProduct = Product::where('name', $item['name'])->first();
                            $productId = $foundProduct ? $foundProduct->id : null;
                        }

                        $qty = (float) ($item['qty'] ?? 1);
                        $rate = (float) ($item['rate'] ?? 0);
                        $unitName = $item['unit_name'] ?? 'Pcs';
                        $unitFactor = 1;
                        $baseQty = $qty;

                        if ($productId) {
                            $product = Product::find($productId);
                            if ($product) {
                                $unitModel = $product->units()
                                    ->where(function ($query) use ($unitName) {
                                        $query->where('name', $unitName)
                                              ->orWhere('alias', $unitName);
                                    })->first();
                                if ($unitModel) {
                                    $unitFactor = $unitModel->factor;
                                    $baseQty = $this->unitService->convertToBase($qty, $unitModel);
                                } else {
                                    $baseQty = $qty;
                                }
                                // Increment stock
                                $product->stock_quantity += $baseQty;
                                $product->save();
                                
                            }
                        }

                        $purchase->items()->create([
                            'product_id' => $productId,
                            'item_name' => $item['name'],
                            'qty' => $qty,
                            'unit_name' => $unitName,
                            'unit_factor' => $unitFactor,
                            'base_qty' => $baseQty,
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
        });
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            $purchase = Purchase::findOrFail($id);
            $invoiceNo = $purchase->invoice_no;
            $party = $purchase->party;
            
            // Deduct stock
            foreach ($purchase->items as $oldItem) {
                if ($oldItem->product_id) {
                    $product = Product::find($oldItem->product_id);
                    if ($product) {
                        $product->stock_quantity -= $oldItem->base_qty;
                        $product->save();
                    }
                }
            }
            
            $purchase->delete();

            if ($party) {
                $party->recalculateBalance();
            }

            return redirect()->route('purchases.index')
                ->with('success', 'Purchase Bill ' . $invoiceNo . ' deleted successfully.');
        });
    }
}
