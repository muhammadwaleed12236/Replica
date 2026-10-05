<x-app-layout>
    <div class="py-6" x-data="{
        search: '',
        showAddModal: false,
        barcodeInput: '',
        generateBarcode() {
            this.barcodeInput = '890' + Math.floor(100000000 + Math.random() * 900000000);
        }
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Module Navigation Bar -->
            <x-module-nav active="products" />

            <!-- Compact Header Toolbar -->
            <div class="prowave-glass-card rounded-2xl border border-slate-800 p-4 flex flex-col md:flex-row md:items-center justify-between gap-4 shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-cyan-500 to-indigo-600 p-0.5 shadow-lg shadow-cyan-500/20">
                        <div class="w-full h-full bg-slate-900 rounded-[14px] flex items-center justify-center text-cyan-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-xl font-extrabold text-white font-['Outfit']">Products Catalog & Barcode Inventory</h1>
                        <p class="text-xs text-slate-400">Scan Barcodes, Manage Items, Stock Quantities & Prices</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" @click="showAddModal = true; generateBarcode()" class="prowave-btn-primary px-4 py-2.5 rounded-xl text-xs font-bold flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Add New Product</span>
                    </button>
                    <a href="{{ route('dashboard') }}" class="prowave-btn-secondary px-3.5 py-2.5 rounded-xl text-xs font-bold">← Dashboard</a>
                </div>
            </div>

            <!-- Session Success Alert -->
            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-semibold flex items-center justify-between">
                    <span>✓ {{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400/60 hover:text-emerald-400">✕</button>
                </div>
            @endif

            <!-- Quick Stats Bar -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="prowave-glass-card rounded-2xl p-4 border border-slate-800 text-center">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Products</span>
                    <div class="text-2xl font-extrabold text-cyan-400 font-mono mt-1">{{ count($products) }}</div>
                </div>
                <div class="prowave-glass-card rounded-2xl p-4 border border-slate-800 text-center">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Units in Stock</span>
                    <div class="text-2xl font-extrabold text-indigo-400 font-mono mt-1">{{ number_format($products->sum('stock_quantity')) }}</div>
                </div>
                <div class="prowave-glass-card rounded-2xl p-4 border border-slate-800 text-center">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Inventory Value</span>
                    <div class="text-2xl font-extrabold text-emerald-400 font-mono mt-1">Rs. {{ number_format($products->sum(fn($p) => $p->purchase_price * $p->stock_quantity), 0) }}</div>
                </div>
                <div class="prowave-glass-card rounded-2xl p-4 border border-slate-800 text-center">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Low Stock Warning (<5)</span>
                    <div class="text-2xl font-extrabold text-amber-400 font-mono mt-1">{{ $products->where('stock_quantity', '<=', 5)->count() }}</div>
                </div>
            </div>

            <!-- Search & Filter Bar -->
            <div class="prowave-glass-card rounded-2xl border border-slate-800 p-4 shadow-xl">
                <div class="relative">
                    <input type="text" x-model="search" placeholder="🔍 Scan Barcode with Scanner or Type Product Name / Code..." class="w-full pl-11 pr-4 py-3 rounded-xl bg-slate-900/90 border border-slate-700 text-white text-sm placeholder-slate-500 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400" autofocus />
                    <div class="absolute left-3.5 top-3.5 text-cyan-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    </div>
                </div>
            </div>

            <!-- Products List Table -->
            <div class="prowave-glass-card rounded-2xl border border-slate-800 overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-300">
                        <thead class="bg-slate-900/90 text-slate-400 uppercase font-mono border-b border-slate-800">
                            <tr>
                                <th class="p-3.5">Barcode / Code</th>
                                <th class="p-3.5">Product Details</th>
                                <th class="p-3.5">Company</th>
                                <th class="p-3.5 text-right">Purchase Price</th>
                                <th class="p-3.5 text-right">Sale Price</th>
                                <th class="p-3.5 text-center">Stock Qty</th>
                                <th class="p-3.5 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80">
                            @forelse($products as $product)
                                <tr class="hover:bg-slate-900/40 transition-colors" x-show="!search || '{{ strtolower($product->name . ' ' . $product->barcode . ' ' . ($product->company->name ?? '')) }}'.includes(search.toLowerCase())">
                                    <td class="p-3.5 font-mono">
                                        <div class="flex flex-col items-start gap-1">
                                            <!-- Visual Barcode Graphic simulation -->
                                            <div class="bg-white p-1 rounded border border-slate-300 inline-flex flex-col items-center">
                                                <div class="flex items-center gap-[2px] h-6 px-1">
                                                    @for($i = 0; $i < 16; $i++)
                                                        <div class="h-full bg-slate-900" style="width: {{ ($i % 3 == 0) ? '3px' : (($i % 2 == 0) ? '1px' : '2px') }}"></div>
                                                    @endfor
                                                </div>
                                                <span class="text-[9px] font-mono text-slate-900 font-bold tracking-widest leading-none mt-0.5">{{ $product->barcode }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-3.5">
                                        <div class="font-extrabold text-white text-sm font-['Outfit']">{{ $product->name }}</div>
                                        <div class="flex items-center gap-2 text-[11px] text-slate-400 mt-0.5">
                                            <span class="px-2 py-0.2 rounded bg-slate-800 text-cyan-300 font-mono">{{ $product->category }}</span>
                                            <span>Unit: {{ $product->unit }}</span>
                                        </div>
                                    </td>
                                    <td class="p-3.5 font-semibold text-indigo-300">
                                        {{ $product->company->name ?? 'N/A' }}
                                    </td>
                                    <td class="p-3.5 text-right font-mono text-slate-400">
                                        Rs. {{ number_format($product->purchase_price, 2) }}
                                    </td>
                                    <td class="p-3.5 text-right font-mono font-bold text-emerald-400 text-sm">
                                        Rs. {{ number_format($product->sale_price, 2) }}
                                    </td>
                                    <td class="p-3.5 text-center font-mono">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $product->stock_quantity <= 5 ? 'bg-rose-500/20 text-rose-300 border border-rose-500/40' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/40' }}">
                                            {{ $product->stock_quantity }} {{ $product->unit }}
                                        </span>
                                    </td>
                                    <td class="p-3.5 text-center">
                                        <form method="POST" action="{{ route('products.destroy', $product->id) }}" onsubmit="return confirm('Are you sure you want to delete this product?')" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/30 transition-colors" title="Delete Product">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-slate-500">
                                        No products found in catalog. Click "Add New Product" to create your first item with barcode!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Add New Product Modal -->
        <div x-show="showAddModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md">
            <div @click.away="showAddModal = false" class="w-full max-w-lg prowave-glass-card rounded-2xl border border-cyan-500/30 p-6 shadow-2xl space-y-5">
                
                <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-8 rounded-xl bg-cyan-500/20 text-cyan-400 flex items-center justify-center font-bold text-sm">📦</span>
                        <h2 class="text-lg font-extrabold text-white font-['Outfit']">Add New Product (Barcode)</h2>
                    </div>
                    <button type="button" @click="showAddModal = false" class="text-slate-400 hover:text-white">✕</button>
                </div>

                <form method="POST" action="{{ route('products.store') }}" class="space-y-4">
                    @csrf
                    
                    <!-- Barcode Input with Auto-Generate -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">Barcode / Item Code *</label>
                        <div class="flex gap-2">
                            <input type="text" name="barcode" x-model="barcodeInput" required placeholder="Scan or type barcode" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white font-mono text-sm focus:border-cyan-400" />
                            <button type="button" @click="generateBarcode()" class="prowave-btn-secondary px-3 py-2 rounded-xl text-xs font-bold whitespace-nowrap text-cyan-300 border-cyan-500/30">⚡ Auto Generate</button>
                        </div>
                    </div>

                    <!-- Product Name -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">Product Name *</label>
                        <input type="text" name="name" required placeholder="e.g. Panadol Extra 500mg" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-sm focus:border-cyan-400" />
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <!-- Company -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">Company / Manufacturer</label>
                            <select name="company_id" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs">
                                <option value="">-- None --</option>
                                @foreach($companies as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Category -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">Category</label>
                            <input type="text" name="category" value="General" placeholder="General, Pharma, etc." class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs" />
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <!-- Purchase Price -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">Purchase Price</label>
                            <input type="number" step="0.01" name="purchase_price" value="0" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white font-mono text-xs" />
                        </div>

                        <!-- Sale Price -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">Sale Price</label>
                            <input type="number" step="0.01" name="sale_price" value="0" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white font-mono text-xs" />
                        </div>

                        <!-- Opening Stock -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">Initial Stock Qty</label>
                            <input type="number" name="stock_quantity" value="0" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white font-mono text-xs" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-800">
                        <button type="button" @click="showAddModal = false" class="prowave-btn-secondary px-4 py-2 rounded-xl text-xs font-bold">Cancel</button>
                        <button type="submit" class="prowave-btn-primary px-5 py-2 rounded-xl text-xs font-bold">Save Product</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
