<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Party;
use App\Models\Salesman;
use App\Models\Product;
use App\Services\UnitConversionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    protected $unitService;

    public function __construct(UnitConversionService $unitService)
    {
        $this->unitService = $unitService;
    }

    public function index(Request $request)
    {
        $parties = Party::orderBy('name')->get();
        $salesmen = Salesman::orderBy('name')->get();
        $products = Product::with(['company', 'units'])->orderBy('name')->get();
        
        $currentSale = null;
        if ($request->has('id')) {
            $currentSale = Sale::with(['party', 'salesman', 'items.product'])->find($request->id);
        }

        $allSales = Sale::with('party')->latest()->get();
        $nextInvoiceNo = 'INV-' . str_pad((Sale::max('id') + 1), 5, '0', STR_PAD_LEFT);

        $initialItems = old('items');
        if (!$initialItems) {
            if ($currentSale && $currentSale->items->count() > 0) {
                $initialItems = $currentSale->items->map(function ($i) {
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

        return view('sales.index', compact('parties', 'salesmen', 'products', 'currentSale', 'allSales', 'nextInvoiceNo', 'initialItems'));
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

        return DB::transaction(function () use ($request) {
            $subtotal = (float) $request->amount;
            $discount = (float) ($request->discount ?? 0);
            $netAmount = max(0, $subtotal - $discount);

            // Fetch existing sale if updating, to restore stock
            $sale = Sale::where('invoice_no', $request->invoice_no)->first();
            if ($sale) {
                // Restore old stock before deleting
                foreach ($sale->items as $oldItem) {
                    if ($oldItem->product_id) {
                        $product = Product::find($oldItem->product_id);
                        if ($product) {
                            $product->stock_quantity += $oldItem->base_qty;
                            $product->save();
                        }
                    }
                }
                $sale->items()->delete();
                $sale->update([
                    'date' => $request->date,
                    'party_id' => $request->party_id,
                    'salesman_id' => $request->salesman_id ?: null,
                    'amount' => $subtotal,
                    'discount' => $discount,
                    'net_amount' => $netAmount,
                    'remarks' => $request->remarks,
                ]);
            } else {
                $sale = Sale::create([
                    'invoice_no' => $request->invoice_no,
                    'date' => $request->date,
                    'party_id' => $request->party_id,
                    'salesman_id' => $request->salesman_id ?: null,
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
                            // Try to find product by name
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
                                // Get factor for snapshot with proper query grouping
                                $unitModel = $product->units()
                                    ->where(function ($query) use ($unitName) {
                                        $query->where('name', $unitName)
                                              ->orWhere('alias', $unitName);
                                    })->first();
                                
                                if ($unitModel) {
                                    $unitFactor = $unitModel->factor;
                                    // Conversion logic
                                    $baseQty = $this->unitService->convertToBase($qty, $unitModel);
                                } else {
                                    // fallback if unit not found
                                    $baseQty = $qty;
                                }
                                // Deduct stock
                                $product->stock_quantity -= $baseQty;
                                if ($product->stock_quantity < 0) {
                                    throw \Illuminate\Validation\ValidationException::withMessages([
                                        'items' => "Insufficient stock for {$product->name}. Requested: {$baseQty}, Available: ".($product->stock_quantity + $baseQty)
                                    ]);
                                }
                                $product->save();
                                
                            }
                        }

                        $sale->items()->create([
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

            if ($sale->party) {
                $sale->party->recalculateBalance();
            }

            return redirect()->route('sales.index', ['id' => $sale->id])
                ->with('success', 'Sale Invoice ' . $sale->invoice_no . ' saved successfully!');
        });
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            $sale = Sale::findOrFail($id);
            $invoiceNo = $sale->invoice_no;
            $party = $sale->party;
            
            // Restore stock
            foreach ($sale->items as $oldItem) {
                if ($oldItem->product_id) {
                    $product = Product::find($oldItem->product_id);
                    if ($product) {
                        $product->stock_quantity += $oldItem->base_qty;
                        $product->save();
                    }
                }
            }
            
            $sale->delete();

            if ($party) {
                $party->recalculateBalance();
            }

            return redirect()->route('sales.index')
                ->with('success', 'Sale Invoice ' . $invoiceNo . ' deleted successfully.');
        });
    }
}
