<x-app-layout>
    <script>
        function salesFormData() {
            return {
                showFindModal: false,
                barcodeScan: '',
                invoiceAmount: {{ $currentSale ? (float)$currentSale->amount : 0 }},
                invoiceDiscount: {{ $currentSale ? (float)$currentSale->discount : 0 }},
                productsList: @json($products),
                items: @json(old('items') ?? ($currentSale && count($currentSale->items) > 0 ? $currentSale->items->map(fn($i) => ['name' => $i->item_name, 'qty' => (int)$i->qty, 'rate' => (float)$i->rate, 'product_id' => ''])->toArray() : [['name' => '', 'qty' => 1, 'rate' => 0, 'product_id' => '']])),
                
                addItem() {
                    this.items.push({ name: '', qty: 1, rate: 0, product_id: '' });
                },
                
                removeItem(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                        this.recalc();
                    }
                },
                
                onProductSelect(index, productId) {
                    if (!productId) return;
                    const p = this.productsList.find(item => item.id == productId);
                    if (p) {
                        this.items[index].name = p.name;
                        this.items[index].rate = parseFloat(p.sale_price) || 0;
                        this.recalc();
                    }
                },

                handleBarcodeScan() {
                    if (!this.barcodeScan) return;
                    const code = this.barcodeScan.trim();
                    const p = this.productsList.find(item => item.barcode == code || (item.barcode && item.barcode.toLowerCase() == code.toLowerCase()));
                    
                    if (p) {
                        let lastItem = this.items[this.items.length - 1];
                        if (lastItem && !lastItem.name) {
                            lastItem.name = p.name;
                            lastItem.rate = parseFloat(p.sale_price) || 0;
                            lastItem.qty = 1;
                            lastItem.product_id = p.id;
                        } else {
                            this.items.push({
                                name: p.name,
                                qty: 1,
                                rate: parseFloat(p.sale_price) || 0,
                                product_id: p.id
                            });
                        }
                        this.barcodeScan = '';
                        this.recalc();
                    } else {
                        alert('No product found with barcode: ' + code);
                    }
                },

                recalc() {
                    let sum = 0;
                    this.items.forEach(i => {
                        sum += (parseFloat(i.qty) || 0) * (parseFloat(i.rate) || 0);
                    });
                    this.invoiceAmount = sum;
                },

                calculateTotal() {
                    let sum = 0;
                    this.items.forEach(i => {
                        sum += (parseFloat(i.qty) || 0) * (parseFloat(i.rate) || 0);
                    });
                    return sum;
                }
            };
        }
    </script>

    <div class="py-6" x-data="salesFormData()" x-effect="invoiceAmount = calculateTotal()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-semibold flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="p-3 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-400 text-xs font-semibold">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Module Navigation Bar -->
            <x-module-nav active="sales" />

            <!-- Main Form Card -->
            <div class="prowave-glass-card rounded-2xl border border-slate-800 overflow-hidden shadow-2xl">
                
                <!-- TOP ACTION TOOLBAR (+ New, Find, Edit, Save, Delete, Refresh, Exit) -->
                <div class="bg-gradient-to-r from-sky-900/90 via-slate-900 to-indigo-950/90 border-b border-slate-800 p-2.5 flex flex-wrap items-center gap-2">
                    <!-- Section Badge -->
                    <div class="flex items-center gap-2 pr-3 border-r border-slate-800">
                        <div class="w-8 h-8 rounded-lg bg-cyan-500/20 border border-cyan-400/40 flex items-center justify-center text-cyan-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z"/></svg>
                        </div>
                        <span class="text-base font-extrabold text-white font-['Outfit']">Sales Invoice</span>
                    </div>

                    <!-- + New Button -->
                    <a href="{{ route('sales.index') }}" class="px-3 py-1.5 rounded-lg bg-cyan-500/10 hover:bg-cyan-500/20 border border-cyan-500/30 text-cyan-300 text-xs font-bold flex items-center gap-1.5 transition-all">
                        <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <span>+ New</span>
                    </a>

                    <!-- Find Button -->
                    <button type="button" @click="showFindModal = true" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold flex items-center gap-1.5 transition-all border border-slate-700">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>Find / Search</span>
                    </button>

                    <!-- Save Button -->
                    <button type="submit" form="sales-form" class="px-4 py-1.5 rounded-lg prowave-btn-primary text-xs font-bold flex items-center gap-1.5 shadow-lg shadow-cyan-500/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                        <span>Save Invoice</span>
                    </button>

                    <!-- Delete Button -->
                    @if(isset($currentSale))
                        <form method="POST" action="{{ route('sales.destroy', $currentSale->id) }}" onsubmit="return confirm('Are you sure you want to delete this sale invoice?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/30 text-rose-300 text-xs font-bold flex items-center gap-1.5 transition-all">
                                <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                <span>Delete</span>
                            </button>
                        </form>
                    @endif

                    <!-- Refresh Button -->
                    <a href="{{ route('sales.index') }}" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold flex items-center gap-1.5 transition-all border border-slate-700">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        <span>Refresh</span>
                    </a>

                    <!-- Exit Button -->
                    <a href="{{ route('dashboard') }}" class="ml-auto px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-rose-900/40 text-slate-300 text-xs font-bold flex items-center gap-1.5 transition-all border border-slate-700">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span>Exit</span>
                    </a>
                </div>

                <!-- Sales Form Header Fields -->
                <form id="sales-form" method="POST" action="{{ route('sales.store') }}" class="p-5 space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 p-4 rounded-xl bg-slate-900/60 border border-slate-800">
                        <!-- Date -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">
                                Date <span class="text-cyan-400 font-mono">//</span>
                            </label>
                            <input type="date" 
                                   name="date" 
                                   value="{{ old('date', $currentSale ? $currentSale->date : date('Y-m-d')) }}" 
                                   required 
                                   class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 text-xs font-mono" />
                        </div>

                        <!-- Party -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">
                                Party Name
                            </label>
                            <select name="party_id" required class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 text-xs">
                                <option value="">-- Select Customer / Party --</option>
                                @foreach($parties as $party)
                                    <option value="{{ $party->id }}" {{ old('party_id', $currentSale ? $currentSale->party_id : '') == $party->id ? 'selected' : '' }}>
                                        {{ $party->name }} ({{ ucfirst($party->type) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Invoice# -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">
                                Invoice #
                            </label>
                            <input type="text" 
                                   name="invoice_no" 
                                   value="{{ old('invoice_no', $currentSale ? $currentSale->invoice_no : $nextInvoiceNo) }}" 
                                   required 
                                   class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-cyan-300 font-bold font-mono focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 text-xs" />
                        </div>

                        <!-- Salesman -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">
                                Salesman
                            </label>
                            <select name="salesman_id" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 text-xs">
                                <option value="">-- Select Salesman --</option>
                                @foreach($salesmen as $sm)
                                    <option value="{{ $sm->id }}" {{ old('salesman_id', $currentSale ? $currentSale->salesman_id : '') == $sm->id ? 'selected' : '' }}>
                                        {{ $sm->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Amount, Discount, Remarks Row -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 p-4 rounded-xl bg-slate-900/60 border border-slate-800">
                        <!-- Net Amount (auto-calculated) -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">
                                Subtotal (Rs.) <span class="text-cyan-400 font-mono">// auto</span>
                            </label>
                            <input type="number" 
                                   step="0.01" 
                                   name="amount" 
                                   x-model.number="invoiceAmount"
                                   required 
                                   readonly
                                   class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-700 text-emerald-400 font-bold font-mono text-base focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 cursor-not-allowed" />
                        </div>

                        <!-- Discount -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">
                                Discount (Rs.)
                            </label>
                            <input type="number" 
                                   step="0.01" 
                                   min="0"
                                   name="discount" 
                                   x-model.number="invoiceDiscount"
                                   class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-amber-400 font-bold font-mono text-base focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400" />
                        </div>

                        <!-- Net Amount Display -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">
                                Net Amount (Rs.) <span class="text-emerald-400 font-mono">// final</span>
                            </label>
                            <div class="w-full px-3.5 py-2 rounded-xl bg-emerald-950/30 border border-emerald-500/40 text-emerald-400 font-extrabold font-mono text-base"
                                 x-text="'Rs. ' + (Math.max(0, invoiceAmount - (invoiceDiscount || 0))).toFixed(2)">
                            </div>
                        </div>

                        <!-- Remarks -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">
                                Remarks
                            </label>
                            <input type="text" 
                                   name="remarks" 
                                   value="{{ old('remarks', $currentSale ? $currentSale->remarks : '') }}" 
                                   placeholder="Optional notes..."
                                   class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 text-xs" />
                        </div>
                    </div>

                    <!-- Quick Barcode Scanner Bar -->
                    <div class="p-3 rounded-xl bg-indigo-950/30 border border-indigo-500/30 flex flex-col sm:flex-row items-center justify-between gap-3">
                        <div class="flex items-center gap-2 text-indigo-300 text-xs font-bold font-['Outfit']">
                            <span class="p-1 rounded bg-indigo-500/20">⚡</span>
                            <span>BARCODE SCANNER QUICK ADD:</span>
                        </div>
                        <div class="relative w-full sm:w-80">
                            <input type="text" 
                                   x-model="barcodeScan" 
                                   @keydown.enter.prevent="handleBarcodeScan()" 
                                   placeholder="Scan item barcode & press enter..." 
                                   class="w-full px-3 py-1.5 rounded-lg bg-slate-900 border border-indigo-500/50 text-white font-mono text-xs focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400" />
                        </div>
                    </div>

                    <!-- Itemized Sales Products Grid -->
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-cyan-400 font-['Outfit']">Sales Items Grid (Select Product Catalog or Type Custom Item)</h3>
                            <button type="button" @click="addItem()" class="px-2.5 py-1 rounded-lg bg-cyan-500/10 hover:bg-cyan-500/20 text-cyan-300 text-xs font-bold flex items-center gap-1 border border-cyan-500/30">
                                + Add Row
                            </button>
                        </div>

                        <div class="overflow-x-auto rounded-xl border border-slate-800">
                            <table class="w-full text-left text-xs text-slate-300">
                                <thead class="bg-slate-900 text-slate-400 uppercase font-mono border-b border-slate-800">
                                    <tr>
                                        <th class="p-2.5">#</th>
                                        <th class="p-2.5 w-64">Select Product from Catalog</th>
                                        <th class="p-2.5">Item Name / Description</th>
                                        <th class="p-2.5 w-24">Qty</th>
                                        <th class="p-2.5 w-32">Rate (Rs.)</th>
                                        <th class="p-2.5 w-36">Line Total</th>
                                        <th class="p-2.5 w-16 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(item, index) in items" :key="index">
                                        <tr class="border-b border-slate-800/80 hover:bg-slate-900/40">
                                            <td class="p-2.5 text-slate-500 font-mono" x-text="index + 1"></td>
                                            
                                            <!-- Select fetched product -->
                                            <td class="p-2.5">
                                                <select x-model="item.product_id" @change="onProductSelect(index, $event.target.value)" class="w-full px-2.5 py-1.5 rounded-lg bg-slate-900 border border-slate-700 text-cyan-300 text-xs">
                                                    <option value="">-- Choose Product --</option>
                                                    <template x-for="p in productsList" :key="p.id">
                                                        <option :value="p.id" x-text="`${p.name} (Rs. ${p.sale_price}) [${p.barcode}]`"></option>
                                                    </template>
                                                </select>
                                            </td>

                                            <!-- Item name text input -->
                                            <td class="p-2.5">
                                                <input type="text" x-model="item.name" :name="`items[${index}][name]`" placeholder="Product name" class="w-full px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs font-semibold" />
                                            </td>

                                            <!-- Qty -->
                                            <td class="p-2.5">
                                                <input type="number" min="1" x-model.number="item.qty" :name="`items[${index}][qty]`" @input="recalc()" class="w-full px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs font-mono" />
                                            </td>

                                            <!-- Rate -->
                                            <td class="p-2.5">
                                                <input type="number" step="0.01" min="0" x-model.number="item.rate" :name="`items[${index}][rate]`" @input="recalc()" class="w-full px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-700 text-emerald-400 font-bold text-xs font-mono" />
                                            </td>

                                            <!-- Total -->
                                            <td class="p-2.5 font-mono font-bold text-emerald-400 text-sm" x-text="'Rs. ' + ((parseFloat(item.qty) || 0) * (parseFloat(item.rate) || 0)).toFixed(2)"></td>

                                            <!-- Action -->
                                            <td class="p-2.5 text-center">
                                                <button type="button" @click="removeItem(index)" class="text-rose-400 hover:text-rose-300 font-bold text-sm">✕</button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>

            </div>

        </div>

        <!-- FIND / SEARCH SALES INVOICES MODAL -->
        <div x-show="showFindModal" x-cloak style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md">
            <div @click.away="showFindModal = false" class="prowave-glass-card rounded-2xl max-w-2xl w-full p-6 border border-slate-700 shadow-2xl max-h-[85vh] flex flex-col">
                <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                    <h3 class="text-lg font-extrabold text-white font-['Outfit']">Find Sales Invoices</h3>
                    <button type="button" @click="showFindModal = false" class="text-slate-400 hover:text-white font-bold">✕</button>
                </div>

                <div class="overflow-y-auto mt-4 flex-grow space-y-3">
                    @forelse($allSales as $sale)
                        <a href="{{ route('sales.index', ['id' => $sale->id]) }}" class="flex items-center justify-between p-4 rounded-xl bg-slate-900/80 border border-slate-800 hover:border-cyan-400 transition-colors">
                            <div>
                                <span class="font-mono font-bold text-cyan-300 block">{{ $sale->invoice_no }}</span>
                                <span class="text-xs text-slate-400">{{ $sale->party->name ?? 'N/A' }} • {{ $sale->date }}</span>
                            </div>
                            <div class="text-right">
                                <span class="font-mono font-extrabold text-emerald-400 text-base">Rs. {{ number_format($sale->net_amount, 2) }}</span>
                                <span class="block text-[10px] text-cyan-400">Click to load</span>
                            </div>
                        </a>
                    @empty
                        <div class="p-8 text-center text-slate-500 text-xs">No sales invoices recorded yet.</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

</x-app-layout>
