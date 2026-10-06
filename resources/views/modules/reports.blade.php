<x-app-layout>
    <div class="py-6" x-data="{ 
        activeReport: '{{ $selectedPartyId ? 'ledger' : 'stock' }}', 
        stockSubTab: 'items', 
        salesSubTab: 'customer', 
        purchaseSubTab: 'supplier' 
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Module Navigation Bar -->
            <x-module-nav active="reports" />

            <!-- Compact Header Toolbar -->
            <div class="prowave-glass-card rounded-2xl border border-slate-800 p-3.5 flex flex-col md:flex-row md:items-center justify-between gap-4 shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-500/20 border border-purple-400/30 flex items-center justify-center text-purple-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-extrabold text-white font-['Outfit']">Financial & Business Reports</h1>
                        <p class="text-xs text-slate-400">Stock Valuation, Sales, Purchases, P&L & Party Statements</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" onclick="window.print()" class="prowave-btn-secondary px-3.5 py-2 rounded-xl text-xs font-bold flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>Print Report</span>
                    </button>
                    <a href="{{ route('dashboard') }}" class="prowave-btn-secondary px-3.5 py-2 rounded-xl text-xs font-bold">← Dashboard</a>
                </div>
            </div>

            <!-- DETAILED REPORT FILTER FORM BAR -->
            <form method="GET" action="{{ route('reports.index') }}" class="prowave-glass-card rounded-2xl border border-slate-800 p-4 shadow-xl">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-end">
                    
                    <!-- From Date -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">From Date</label>
                        <input type="date" name="from_date" value="{{ $fromDate }}" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-mono" />
                    </div>

                    <!-- To Date -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">To Date</label>
                        <input type="date" name="to_date" value="{{ $toDate }}" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-mono" />
                    </div>

                    <!-- Party Filter Dropdown -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">Filter by Party Statement</label>
                        <select name="party_id" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs">
                            <option value="">-- All Accounts / Modules Summary --</option>
                            @foreach($parties as $p)
                                <option value="{{ $p->id }}" {{ $selectedPartyId == $p->id ? 'selected' : '' }}>
                                    {{ $p->name }} ({{ ucfirst($p->type) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="flex items-center gap-2">
                        <button type="submit" class="w-full prowave-btn-primary py-2 rounded-xl text-xs font-bold flex items-center justify-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                            <span>Apply Filter</span>
                        </button>
                        <a href="{{ route('reports.index') }}" class="prowave-btn-secondary px-3 py-2 rounded-xl text-xs font-bold">Reset</a>
                    </div>
                </div>
            </form>

            <!-- REPORT TYPE SELECTION BOXES (DASHBOARD CARDS) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5 font-['Outfit']">
                
                <!-- Card 1: Item Stock Report -->
                <button type="button" @click="activeReport = 'stock'" 
                    :class="activeReport === 'stock' ? 'border-cyan-500 bg-cyan-500/10 ring-2 ring-cyan-500/40 shadow-cyan-500/10 shadow-lg' : 'border-slate-800 hover:border-slate-700 bg-slate-900/60'" 
                    class="prowave-glass-card rounded-2xl p-4 text-left transition-all group flex flex-col justify-between border cursor-pointer">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-9 h-9 rounded-xl bg-cyan-500/20 text-cyan-300 border border-cyan-400/30 flex items-center justify-center font-bold text-base">📦</div>
                            <span class="text-[10px] font-mono px-2 py-0.5 rounded-full bg-cyan-500/20 text-cyan-300 font-bold border border-cyan-500/30">{{ count($products) }} Items</span>
                        </div>
                        <h3 class="text-sm font-extrabold text-white group-hover:text-cyan-300 transition-colors">Item Stock Report</h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">Category & Product-wise Stock</p>
                    </div>
                    <div class="mt-3 text-[10px] font-mono text-cyan-400 flex items-center justify-between pt-2 border-t border-slate-800/80">
                        <span>Valuation: Rs. {{ number_format($stockRetailValue, 0) }}</span>
                        <span>→</span>
                    </div>
                </button>

                <!-- Card 2: Sale Report -->
                <button type="button" @click="activeReport = 'sales'" 
                    :class="activeReport === 'sales' ? 'border-indigo-500 bg-indigo-500/10 ring-2 ring-indigo-500/40 shadow-indigo-500/10 shadow-lg' : 'border-slate-800 hover:border-slate-700 bg-slate-900/60'" 
                    class="prowave-glass-card rounded-2xl p-4 text-left transition-all group flex flex-col justify-between border cursor-pointer">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-9 h-9 rounded-xl bg-indigo-500/20 text-indigo-300 border border-indigo-400/30 flex items-center justify-center font-bold text-base">📈</div>
                            <span class="text-[10px] font-mono px-2 py-0.5 rounded-full bg-indigo-500/20 text-indigo-300 font-bold border border-indigo-500/30">{{ count($filteredSales) }} Invoices</span>
                        </div>
                        <h3 class="text-sm font-extrabold text-white group-hover:text-indigo-300 transition-colors">Sale Report</h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">Customer & Product-wise</p>
                    </div>
                    <div class="mt-3 text-[10px] font-mono text-indigo-400 flex items-center justify-between pt-2 border-t border-slate-800/80">
                        <span>Revenue: Rs. {{ number_format($totalSales, 0) }}</span>
                        <span>→</span>
                    </div>
                </button>

                <!-- Card 3: Purchase Report -->
                <button type="button" @click="activeReport = 'purchases'" 
                    :class="activeReport === 'purchases' ? 'border-purple-500 bg-purple-500/10 ring-2 ring-purple-500/40 shadow-purple-500/10 shadow-lg' : 'border-slate-800 hover:border-slate-700 bg-slate-900/60'" 
                    class="prowave-glass-card rounded-2xl p-4 text-left transition-all group flex flex-col justify-between border cursor-pointer">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-9 h-9 rounded-xl bg-purple-500/20 text-purple-300 border border-purple-400/30 flex items-center justify-center font-bold text-base">🛒</div>
                            <span class="text-[10px] font-mono px-2 py-0.5 rounded-full bg-purple-500/20 text-purple-300 font-bold border border-purple-500/30">{{ count($filteredPurchases) }} Bills</span>
                        </div>
                        <h3 class="text-sm font-extrabold text-white group-hover:text-purple-300 transition-colors">Purchase Report</h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">Supplier & Bill Summary</p>
                    </div>
                    <div class="mt-3 text-[10px] font-mono text-purple-400 flex items-center justify-between pt-2 border-t border-slate-800/80">
                        <span>Total: Rs. {{ number_format($totalPurchases, 0) }}</span>
                        <span>→</span>
                    </div>
                </button>

                <!-- Card 4: Profit & Loss Report -->
                <button type="button" @click="activeReport = 'pnl'" 
                    :class="activeReport === 'pnl' ? 'border-emerald-500 bg-emerald-500/10 ring-2 ring-emerald-500/40 shadow-emerald-500/10 shadow-lg' : 'border-slate-800 hover:border-slate-700 bg-slate-900/60'" 
                    class="prowave-glass-card rounded-2xl p-4 text-left transition-all group flex flex-col justify-between border cursor-pointer">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 flex items-center justify-center font-bold text-base">💰</div>
                            <span class="text-[10px] font-mono px-2 py-0.5 rounded-full {{ $netProfit >= 0 ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-rose-500/20 text-rose-300 border border-rose-500/30' }} font-bold">P&L</span>
                        </div>
                        <h3 class="text-sm font-extrabold text-white group-hover:text-emerald-300 transition-colors">Profit & Loss</h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">Net Profit & Expense Analysis</p>
                    </div>
                    <div class="mt-3 text-[10px] font-mono flex items-center justify-between pt-2 border-t border-slate-800/80 {{ $netProfit >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                        <span>Net: Rs. {{ number_format($netProfit, 0) }}</span>
                        <span>→</span>
                    </div>
                </button>

                <!-- Card 5: Party Ledger Statements -->
                <button type="button" @click="activeReport = 'ledger'" 
                    :class="activeReport === 'ledger' ? 'border-amber-500 bg-amber-500/10 ring-2 ring-amber-500/40 shadow-amber-500/10 shadow-lg' : 'border-slate-800 hover:border-slate-700 bg-slate-900/60'" 
                    class="prowave-glass-card rounded-2xl p-4 text-left transition-all group flex flex-col justify-between border cursor-pointer">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-9 h-9 rounded-xl bg-amber-500/20 text-amber-300 border border-amber-400/30 flex items-center justify-center font-bold text-base">📑</div>
                            <span class="text-[10px] font-mono px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-300 font-bold border border-amber-500/30">{{ count($parties) }} Parties</span>
                        </div>
                        <h3 class="text-sm font-extrabold text-white group-hover:text-amber-300 transition-colors">Party Ledgers</h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">Customer & Supplier Statements</p>
                    </div>
                    <div class="mt-3 text-[10px] font-mono text-amber-400 flex items-center justify-between pt-2 border-t border-slate-800/80">
                        <span>Ledger Accounts</span>
                        <span>→</span>
                    </div>
                </button>
            </div>

            <!-- EXECUTIVE FINANCIAL SUMMARY STRIP -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                <div class="prowave-glass-card rounded-xl p-3 text-center border border-slate-800">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Sales</span>
                    <div class="text-base font-extrabold text-cyan-400 font-mono mt-0.5">Rs. {{ number_format($totalSales, 2) }}</div>
                </div>
                <div class="prowave-glass-card rounded-xl p-3 text-center border border-slate-800">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Purchases</span>
                    <div class="text-base font-extrabold text-indigo-400 font-mono mt-0.5">Rs. {{ number_format($totalPurchases, 2) }}</div>
                </div>
                <div class="prowave-glass-card rounded-xl p-3 text-center border border-slate-800">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Expenses</span>
                    <div class="text-base font-extrabold text-amber-400 font-mono mt-0.5">Rs. {{ number_format($totalExpenses, 2) }}</div>
                </div>
                <div class="prowave-glass-card rounded-xl p-3 text-center border border-slate-800">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Receipts</span>
                    <div class="text-base font-extrabold text-emerald-400 font-mono mt-0.5">Rs. {{ number_format($totalReceipts, 2) }}</div>
                </div>
                <div class="prowave-glass-card rounded-xl p-3 text-center border border-slate-800">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Payments</span>
                    <div class="text-base font-extrabold text-rose-400 font-mono mt-0.5">Rs. {{ number_format($totalPayments, 2) }}</div>
                </div>
            </div>

            <!-- ==================================================================== -->
            <!-- 1. ITEM STOCK & VALUATION REPORT VIEW -->
            <!-- ==================================================================== -->
            <div x-show="activeReport === 'stock'" class="prowave-glass-card rounded-2xl border border-cyan-500/30 p-6 shadow-2xl space-y-6">
                
                <!-- Header & Stock Sub-tab Switcher -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-800">
                    <div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase bg-cyan-500/20 text-cyan-300 border border-cyan-400/30">Stock Report</span>
                        <h2 class="text-lg font-extrabold text-white font-['Outfit'] mt-1">Inventory & Stock Valuation Report</h2>
                    </div>

                    <div class="flex items-center gap-2 bg-slate-900 p-1 rounded-xl border border-slate-800">
                        <button type="button" @click="stockSubTab = 'items'" 
                            :class="stockSubTab === 'items' ? 'bg-cyan-500 text-slate-950 font-extrabold' : 'text-slate-400 hover:text-white font-semibold'" 
                            class="px-3 py-1.5 rounded-lg text-xs transition-all">
                            Product-Wise Stock
                        </button>
                        <button type="button" @click="stockSubTab = 'category'" 
                            :class="stockSubTab === 'category' ? 'bg-cyan-500 text-slate-950 font-extrabold' : 'text-slate-400 hover:text-white font-semibold'" 
                            class="px-3 py-1.5 rounded-lg text-xs transition-all">
                            Category-Wise Valuation
                        </button>
                    </div>
                </div>

                <!-- Stock Summary Badges -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs font-mono">
                    <div class="p-3 bg-slate-900/80 rounded-xl border border-slate-800">
                        <span class="text-[10px] text-slate-400 uppercase font-sans font-bold block">Total Items Qty</span>
                        <span class="text-base font-extrabold text-white mt-0.5 block">{{ number_format($totalStockQty) }}</span>
                    </div>
                    <div class="p-3 bg-slate-900/80 rounded-xl border border-slate-800">
                        <span class="text-[10px] text-slate-400 uppercase font-sans font-bold block">Purchase Valuation</span>
                        <span class="text-base font-extrabold text-indigo-400 mt-0.5 block">Rs. {{ number_format($stockPurchaseValue, 2) }}</span>
                    </div>
                    <div class="p-3 bg-slate-900/80 rounded-xl border border-slate-800">
                        <span class="text-[10px] text-slate-400 uppercase font-sans font-bold block">Retail Valuation [R]</span>
                        <span class="text-base font-extrabold text-emerald-400 mt-0.5 block">Rs. {{ number_format($stockRetailValue, 2) }}</span>
                    </div>
                    <div class="p-3 bg-slate-900/80 rounded-xl border border-slate-800">
                        <span class="text-[10px] text-slate-400 uppercase font-sans font-bold block">Wholesale Valuation [W]</span>
                        <span class="text-base font-extrabold text-amber-400 mt-0.5 block">Rs. {{ number_format($stockWholesaleValue, 2) }}</span>
                    </div>
                </div>

                <!-- Sub-tab 1: Product-Wise Stock Table -->
                <div x-show="stockSubTab === 'items'" class="overflow-x-auto rounded-xl border border-slate-800">
                    <table class="w-full text-left text-xs text-slate-300">
                        <thead class="bg-slate-900 text-slate-400 uppercase font-mono border-b border-slate-800">
                            <tr>
                                <th class="p-3">#</th>
                                <th class="p-3">Barcode</th>
                                <th class="p-3">Product Name</th>
                                <th class="p-3">Company / Category</th>
                                <th class="p-3 text-right">Purchase Price</th>
                                <th class="p-3 text-right">Retail [R]</th>
                                <th class="p-3 text-right">Wholesale [W]</th>
                                <th class="p-3 text-center">Stock Qty</th>
                                <th class="p-3 text-right">Stock Pur Value</th>
                                <th class="p-3 text-right">Stock Retail Value</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80">
                            @forelse($products as $index => $prod)
                                @php
                                    $rowPurValue = ($prod->purchase_price ?? 0) * ($prod->stock_quantity ?? 0);
                                    $rowRetailValue = ($prod->sale_price ?? 0) * ($prod->stock_quantity ?? 0);
                                @endphp
                                <tr class="hover:bg-slate-900/40">
                                    <td class="p-3 font-mono text-slate-500">{{ $index + 1 }}</td>
                                    <td class="p-3 font-mono font-bold text-cyan-400">{{ $prod->barcode }}</td>
                                    <td class="p-3 font-bold text-white">{{ $prod->name }}</td>
                                    <td class="p-3">
                                        <span class="text-indigo-300 font-semibold block">{{ $prod->company->name ?? 'N/A' }}</span>
                                        <span class="text-[10px] text-slate-400">{{ $prod->category ?? 'General' }}</span>
                                    </td>
                                    <td class="p-3 text-right font-mono text-slate-300">Rs. {{ number_format($prod->purchase_price, 2) }}</td>
                                    <td class="p-3 text-right font-mono text-emerald-400 font-bold">Rs. {{ number_format($prod->sale_price, 2) }}</td>
                                    <td class="p-3 text-right font-mono text-amber-400 font-bold">Rs. {{ number_format($prod->wholesale_price ?? 0, 2) }}</td>
                                    <td class="p-3 text-center font-mono font-bold">
                                        <span class="px-2 py-0.5 rounded-md {{ ($prod->stock_quantity ?? 0) <= 5 ? 'bg-rose-500/20 text-rose-300 border border-rose-500/40' : 'bg-slate-800 text-white' }}">
                                            {{ $prod->stock_quantity }} {{ $prod->unit }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-right font-mono font-bold text-indigo-300">Rs. {{ number_format($rowPurValue, 2) }}</td>
                                    <td class="p-3 text-right font-mono font-bold text-emerald-300">Rs. {{ number_format($rowRetailValue, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="10" class="p-6 text-center text-slate-500">No products found in inventory.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Sub-tab 2: Category-Wise Stock Summary Table -->
                <div x-show="stockSubTab === 'category'" style="display: none;" class="overflow-x-auto rounded-xl border border-slate-800">
                    <table class="w-full text-left text-xs text-slate-300">
                        <thead class="bg-slate-900 text-slate-400 uppercase font-mono border-b border-slate-800">
                            <tr>
                                <th class="p-3">#</th>
                                <th class="p-3">Category Name</th>
                                <th class="p-3 text-center">Total Products</th>
                                <th class="p-3 text-center">Total Quantity</th>
                                <th class="p-3 text-right">Total Purchase Value</th>
                                <th class="p-3 text-right">Total Retail Value [R]</th>
                                <th class="p-3 text-right">Total Wholesale Value [W]</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80">
                            @forelse($categoryStockSummary as $idx => $cat)
                                <tr class="hover:bg-slate-900/40">
                                    <td class="p-3 font-mono text-slate-500">{{ $idx + 1 }}</td>
                                    <td class="p-3 font-bold text-cyan-300">{{ $cat['category'] }}</td>
                                    <td class="p-3 text-center font-mono font-bold text-white">{{ $cat['product_count'] }}</td>
                                    <td class="p-3 text-center font-mono font-bold text-indigo-300">{{ number_format($cat['total_qty']) }}</td>
                                    <td class="p-3 text-right font-mono text-slate-300">Rs. {{ number_format($cat['purchase_val'], 2) }}</td>
                                    <td class="p-3 text-right font-mono text-emerald-400 font-bold">Rs. {{ number_format($cat['retail_val'], 2) }}</td>
                                    <td class="p-3 text-right font-mono text-amber-400 font-bold">Rs. {{ number_format($cat['wholesale_val'], 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="p-6 text-center text-slate-500">No categories found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- ==================================================================== -->
            <!-- 2. SALES REPORT VIEW (CUSTOMER-WISE, PRODUCT-WISE, ALL INVOICES) -->
            <!-- ==================================================================== -->
            <div x-show="activeReport === 'sales'" style="display: none;" class="prowave-glass-card rounded-2xl border border-indigo-500/30 p-6 shadow-2xl space-y-6">
                
                <!-- Header & Sales Sub-tab Switcher -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-800">
                    <div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase bg-indigo-500/20 text-indigo-300 border border-indigo-400/30">Sales Summary</span>
                        <h2 class="text-lg font-extrabold text-white font-['Outfit'] mt-1">Period Sales & Revenue Analysis</h2>
                    </div>

                    <div class="flex items-center gap-2 bg-slate-900 p-1 rounded-xl border border-slate-800">
                        <button type="button" @click="salesSubTab = 'customer'" 
                            :class="salesSubTab === 'customer' ? 'bg-indigo-500 text-white font-extrabold' : 'text-slate-400 hover:text-white font-semibold'" 
                            class="px-3 py-1.5 rounded-lg text-xs transition-all">
                            Customer-Wise Sales
                        </button>
                        <button type="button" @click="salesSubTab = 'product'" 
                            :class="salesSubTab === 'product' ? 'bg-indigo-500 text-white font-extrabold' : 'text-slate-400 hover:text-white font-semibold'" 
                            class="px-3 py-1.5 rounded-lg text-xs transition-all">
                            Product-Wise Sales
                        </button>
                        <button type="button" @click="salesSubTab = 'invoices'" 
                            :class="salesSubTab === 'invoices' ? 'bg-indigo-500 text-white font-extrabold' : 'text-slate-400 hover:text-white font-semibold'" 
                            class="px-3 py-1.5 rounded-lg text-xs transition-all">
                            All Sale Invoices
                        </button>
                    </div>
                </div>

                <!-- Sub-tab 1: Customer-Wise Sales Summary -->
                <div x-show="salesSubTab === 'customer'" class="overflow-x-auto rounded-xl border border-slate-800">
                    <table class="w-full text-left text-xs text-slate-300">
                        <thead class="bg-slate-900 text-slate-400 uppercase font-mono border-b border-slate-800">
                            <tr>
                                <th class="p-3">#</th>
                                <th class="p-3">Customer Code</th>
                                <th class="p-3">Customer Name</th>
                                <th class="p-3">Type</th>
                                <th class="p-3 text-center">Invoices Count</th>
                                <th class="p-3 text-right">Total Net Sales (Rs.)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80">
                            @forelse($customerSalesSummary as $idx => $cs)
                                <tr class="hover:bg-slate-900/40">
                                    <td class="p-3 font-mono text-slate-500">{{ $idx + 1 }}</td>
                                    <td class="p-3 font-mono font-bold text-cyan-400">{{ $cs['party_code'] }}</td>
                                    <td class="p-3 font-bold text-white">{{ $cs['party_name'] }}</td>
                                    <td class="p-3"><span class="px-2 py-0.5 rounded-full text-[10px] uppercase bg-slate-800 text-slate-300">{{ $cs['party_type'] }}</span></td>
                                    <td class="p-3 text-center font-mono font-bold text-indigo-300">{{ $cs['invoice_count'] }}</td>
                                    <td class="p-3 text-right font-mono font-bold text-emerald-400 text-sm">Rs. {{ number_format($cs['total_amount'], 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="p-6 text-center text-slate-500">No customer sales recorded in selected date range.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Sub-tab 2: Product-Wise Sales Summary -->
                <div x-show="salesSubTab === 'product'" style="display: none;" class="overflow-x-auto rounded-xl border border-slate-800">
                    <table class="w-full text-left text-xs text-slate-300">
                        <thead class="bg-slate-900 text-slate-400 uppercase font-mono border-b border-slate-800">
                            <tr>
                                <th class="p-3">#</th>
                                <th class="p-3">Item Name</th>
                                <th class="p-3 text-center">Total Qty Sold</th>
                                <th class="p-3 text-right">Total Sales Revenue (Rs.)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80">
                            @forelse($productSalesSummary as $idx => $ps)
                                <tr class="hover:bg-slate-900/40">
                                    <td class="p-3 font-mono text-slate-500">{{ $idx + 1 }}</td>
                                    <td class="p-3 font-bold text-cyan-300">{{ $ps['item_name'] }}</td>
                                    <td class="p-3 text-center font-mono font-bold text-white">{{ number_format($ps['total_qty']) }}</td>
                                    <td class="p-3 text-right font-mono font-bold text-emerald-400">Rs. {{ number_format($ps['total_revenue'], 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="p-6 text-center text-slate-500">No product sales recorded in selected date range.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Sub-tab 3: All Sale Invoices List -->
                <div x-show="salesSubTab === 'invoices'" style="display: none;" class="overflow-x-auto rounded-xl border border-slate-800">
                    <table class="w-full text-left text-xs text-slate-300">
                        <thead class="bg-slate-900 text-slate-400 uppercase font-mono border-b border-slate-800">
                            <tr>
                                <th class="p-3">Date</th>
                                <th class="p-3">Invoice #</th>
                                <th class="p-3">Customer Party</th>
                                <th class="p-3 text-right">Amount</th>
                                <th class="p-3 text-right">Discount</th>
                                <th class="p-3 text-right">Net Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80">
                            @forelse($filteredSales as $sale)
                                <tr class="hover:bg-slate-900/40">
                                    <td class="p-3 font-mono text-slate-400">{{ $sale->date }}</td>
                                    <td class="p-3 font-mono font-bold text-cyan-400">{{ $sale->invoice_no }}</td>
                                    <td class="p-3 font-bold text-white">{{ $sale->party->name ?? 'Walk-in Customer' }}</td>
                                    <td class="p-3 text-right font-mono text-slate-300">Rs. {{ number_format($sale->amount, 2) }}</td>
                                    <td class="p-3 text-right font-mono text-rose-400">Rs. {{ number_format($sale->discount, 2) }}</td>
                                    <td class="p-3 text-right font-mono font-bold text-emerald-400">Rs. {{ number_format($sale->net_amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="p-6 text-center text-slate-500">No sales invoices found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- ==================================================================== -->
            <!-- 3. PURCHASE REPORT VIEW (SUPPLIER-WISE, ALL BILLS) -->
            <!-- ==================================================================== -->
            <div x-show="activeReport === 'purchases'" style="display: none;" class="prowave-glass-card rounded-2xl border border-purple-500/30 p-6 shadow-2xl space-y-6">
                
                <!-- Header & Purchase Sub-tab Switcher -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-800">
                    <div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase bg-purple-500/20 text-purple-300 border border-purple-400/30">Purchase Report</span>
                        <h2 class="text-lg font-extrabold text-white font-['Outfit'] mt-1">Supplier Purchases & Inventory Inward</h2>
                    </div>

                    <div class="flex items-center gap-2 bg-slate-900 p-1 rounded-xl border border-slate-800">
                        <button type="button" @click="purchaseSubTab = 'supplier'" 
                            :class="purchaseSubTab === 'supplier' ? 'bg-purple-500 text-white font-extrabold' : 'text-slate-400 hover:text-white font-semibold'" 
                            class="px-3 py-1.5 rounded-lg text-xs transition-all">
                            Supplier-Wise Summary
                        </button>
                        <button type="button" @click="purchaseSubTab = 'bills'" 
                            :class="purchaseSubTab === 'bills' ? 'bg-purple-500 text-white font-extrabold' : 'text-slate-400 hover:text-white font-semibold'" 
                            class="px-3 py-1.5 rounded-lg text-xs transition-all">
                            All Purchase Bills
                        </button>
                    </div>
                </div>

                <!-- Sub-tab 1: Supplier-Wise Purchase Summary -->
                <div x-show="purchaseSubTab === 'supplier'" class="overflow-x-auto rounded-xl border border-slate-800">
                    <table class="w-full text-left text-xs text-slate-300">
                        <thead class="bg-slate-900 text-slate-400 uppercase font-mono border-b border-slate-800">
                            <tr>
                                <th class="p-3">#</th>
                                <th class="p-3">Supplier Code</th>
                                <th class="p-3">Supplier Party</th>
                                <th class="p-3 text-center">Bills Count</th>
                                <th class="p-3 text-right">Total Net Purchase (Rs.)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80">
                            @forelse($supplierPurchaseSummary as $idx => $sp)
                                <tr class="hover:bg-slate-900/40">
                                    <td class="p-3 font-mono text-slate-500">{{ $idx + 1 }}</td>
                                    <td class="p-3 font-mono font-bold text-cyan-400">{{ $sp['party_code'] }}</td>
                                    <td class="p-3 font-bold text-white">{{ $sp['party_name'] }}</td>
                                    <td class="p-3 text-center font-mono font-bold text-purple-300">{{ $sp['bill_count'] }}</td>
                                    <td class="p-3 text-right font-mono font-bold text-indigo-400 text-sm">Rs. {{ number_format($sp['total_amount'], 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="p-6 text-center text-slate-500">No supplier purchases recorded.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Sub-tab 2: All Purchase Bills List -->
                <div x-show="purchaseSubTab === 'bills'" style="display: none;" class="overflow-x-auto rounded-xl border border-slate-800">
                    <table class="w-full text-left text-xs text-slate-300">
                        <thead class="bg-slate-900 text-slate-400 uppercase font-mono border-b border-slate-800">
                            <tr>
                                <th class="p-3">Date</th>
                                <th class="p-3">Bill / Inv #</th>
                                <th class="p-3">Supplier Party</th>
                                <th class="p-3 text-right">Amount</th>
                                <th class="p-3 text-right">Discount</th>
                                <th class="p-3 text-right">Net Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80">
                            @forelse($filteredPurchases as $pur)
                                <tr class="hover:bg-slate-900/40">
                                    <td class="p-3 font-mono text-slate-400">{{ $pur->date }}</td>
                                    <td class="p-3 font-mono font-bold text-purple-400">{{ $pur->invoice_no }}</td>
                                    <td class="p-3 font-bold text-white">{{ $pur->party->name ?? 'Direct Purchase' }}</td>
                                    <td class="p-3 text-right font-mono text-slate-300">Rs. {{ number_format($pur->amount, 2) }}</td>
                                    <td class="p-3 text-right font-mono text-rose-400">Rs. {{ number_format($pur->discount, 2) }}</td>
                                    <td class="p-3 text-right font-mono font-bold text-indigo-400">Rs. {{ number_format($pur->net_amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="p-6 text-center text-slate-500">No purchase bills found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- ==================================================================== -->
            <!-- 4. PROFIT & LOSS STATEMENT VIEW -->
            <!-- ==================================================================== -->
            <div x-show="activeReport === 'pnl'" style="display: none;" class="prowave-glass-card rounded-2xl border border-emerald-500/30 p-6 shadow-2xl space-y-6">
                
                <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                    <div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">P&L Statement</span>
                        <h2 class="text-lg font-extrabold text-white font-['Outfit'] mt-1">Profit & Loss Financial Statement</h2>
                    </div>
                    <span class="text-xs font-mono px-3 py-1 rounded-xl bg-slate-900 text-slate-300 border border-slate-800">{{ $fromDate }} to {{ $toDate }}</span>
                </div>

                <div class="max-w-3xl mx-auto space-y-4 font-mono text-sm">
                    <div class="p-4 bg-slate-900/60 rounded-xl border border-slate-800 space-y-3">
                        <h3 class="text-xs uppercase font-extrabold font-sans text-cyan-400 tracking-wider">1. Operating Income / Revenue</h3>
                        <div class="flex justify-between items-center text-slate-200">
                            <span>Total Period Gross Sales</span>
                            <span class="font-bold text-cyan-300">Rs. {{ number_format($totalSales, 2) }}</span>
                        </div>
                    </div>

                    <div class="p-4 bg-slate-900/60 rounded-xl border border-slate-800 space-y-3">
                        <h3 class="text-xs uppercase font-extrabold font-sans text-indigo-400 tracking-wider">2. Cost of Goods / Inventory Inward</h3>
                        <div class="flex justify-between items-center text-slate-200">
                            <span>Total Purchases / Inventory Inward Cost (-)</span>
                            <span class="font-bold text-indigo-300">Rs. {{ number_format($totalPurchases, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t border-slate-800 font-bold">
                            <span class="text-slate-300">GROSS PROFIT / MARGIN</span>
                            <span class="{{ $grossProfit >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">Rs. {{ number_format($grossProfit, 2) }}</span>
                        </div>
                    </div>

                    <div class="p-4 bg-slate-900/60 rounded-xl border border-slate-800 space-y-3">
                        <h3 class="text-xs uppercase font-extrabold font-sans text-amber-400 tracking-wider">3. Operating Expenses</h3>
                        <div class="flex justify-between items-center text-slate-200">
                            <span>Total Operating & General Expenses (-)</span>
                            <span class="font-bold text-amber-300">Rs. {{ number_format($totalExpenses, 2) }}</span>
                        </div>
                    </div>

                    <div class="p-5 rounded-2xl border flex flex-col sm:flex-row items-center justify-between gap-4 {{ $netProfit >= 0 ? 'bg-emerald-500/10 border-emerald-500/40 text-emerald-300' : 'bg-rose-500/10 border-rose-500/40 text-rose-300' }}">
                        <div>
                            <span class="text-xs uppercase font-bold font-sans tracking-wider block text-slate-400">NET FINANCIAL RESULT</span>
                            <h3 class="text-xl font-extrabold font-['Outfit'] mt-0.5">{{ $netProfit >= 0 ? 'NET PROFIT' : 'NET LOSS' }}</h3>
                        </div>
                        <div class="text-2xl font-extrabold font-mono">
                            Rs. {{ number_format($netProfit, 2) }}
                        </div>
                    </div>
                </div>

            </div>

            <!-- ==================================================================== -->
            <!-- 5. PARTY LEDGER STATEMENTS & ALL PARTIES LIST -->
            <!-- ==================================================================== -->
            <div x-show="activeReport === 'ledger'" style="display: none;" class="space-y-6">
                
                @if($selectedParty)
                    <!-- DETAILED PARTY LEDGER STATEMENT FOR SELECTED PARTY -->
                    <div class="prowave-glass-card rounded-2xl border border-cyan-500/40 p-6 shadow-2xl space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-800 gap-2">
                            <div>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase bg-cyan-500/20 text-cyan-300 border border-cyan-400/30">Party Ledger Statement</span>
                                <h2 class="text-xl font-extrabold text-white font-['Outfit'] mt-1">{{ $selectedParty->name }}</h2>
                                <p class="text-xs text-slate-400">Phone: {{ $selectedParty->phone ?? 'N/A' }} | City: {{ $selectedParty->city ?? 'N/A' }} | Type: {{ ucfirst($selectedParty->type) }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-slate-400 block uppercase font-bold">Current Closing Balance</span>
                                <span class="text-2xl font-extrabold font-mono text-emerald-400">Rs. {{ number_format($selectedParty->current_balance, 2) }}</span>
                            </div>
                        </div>

                        <div class="overflow-x-auto rounded-xl border border-slate-800">
                            <table class="w-full text-left text-xs text-slate-300">
                                <thead class="bg-slate-900 text-slate-400 uppercase font-mono border-b border-slate-800">
                                    <tr>
                                        <th class="p-3">Date</th>
                                        <th class="p-3">Voucher / Ref #</th>
                                        <th class="p-3">Description</th>
                                        <th class="p-3 text-right">Debit (Rs.)</th>
                                        <th class="p-3 text-right">Credit (Rs.)</th>
                                        <th class="p-3 text-right">Running Balance</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-800/80">
                                    <!-- Opening Balance Row -->
                                    <tr class="bg-slate-900/50 font-bold">
                                        <td class="p-3 font-mono text-slate-400">{{ $fromDate }}</td>
                                        <td class="p-3 font-mono text-cyan-400">OP-BAL</td>
                                        <td class="p-3 text-slate-300">Opening Balance Carried Forward</td>
                                        <td class="p-3 text-right font-mono text-slate-400">-</td>
                                        <td class="p-3 text-right font-mono text-slate-400">-</td>
                                        <td class="p-3 text-right font-mono text-cyan-300">Rs. {{ number_format($selectedParty->opening_balance, 2) }}</td>
                                    </tr>

                                    @php
                                        $runningBal = $selectedParty->opening_balance;
                                    @endphp

                                    @forelse($ledgerEntries as $entry)
                                        @php
                                            if ($selectedParty->type === 'supplier') {
                                                $runningBal += ($entry['credit'] - $entry['debit']);
                                            } else {
                                                $runningBal += ($entry['debit'] - $entry['credit']);
                                            }
                                        @endphp
                                        <tr class="hover:bg-slate-900/40">
                                            <td class="p-3 font-mono text-slate-400">{{ $entry['date'] }}</td>
                                            <td class="p-3 font-mono font-bold text-cyan-400">{{ $entry['ref'] }}</td>
                                            <td class="p-3 font-semibold text-white">{{ $entry['description'] }}</td>
                                            <td class="p-3 text-right font-mono text-cyan-300 font-bold">
                                                {{ $entry['debit'] > 0 ? 'Rs. ' . number_format($entry['debit'], 2) : '-' }}
                                            </td>
                                            <td class="p-3 text-right font-mono text-emerald-400 font-bold">
                                                {{ $entry['credit'] > 0 ? 'Rs. ' . number_format($entry['credit'], 2) : '-' }}
                                            </td>
                                            <td class="p-3 text-right font-mono font-bold text-white">
                                                Rs. {{ number_format($runningBal, 2) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="6" class="p-6 text-center text-slate-500">No transactions recorded for this party in the selected date range.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <!-- ALL PARTIES SUMMARY TABLE -->
                    <div class="prowave-glass-card rounded-2xl border border-slate-800 p-6 shadow-2xl space-y-4">
                        <h3 class="text-base font-bold text-white font-['Outfit']">All Customer & Supplier Ledger Accounts</h3>
                        
                        <div class="overflow-x-auto rounded-xl border border-slate-800">
                            <table class="w-full text-left text-xs text-slate-300">
                                <thead class="bg-slate-900 text-slate-400 uppercase font-mono border-b border-slate-800">
                                    <tr>
                                        <th class="p-3.5">Party Code</th>
                                        <th class="p-3.5">Party Name</th>
                                        <th class="p-3.5">Type</th>
                                        <th class="p-3.5">Opening Bal</th>
                                        <th class="p-3.5 text-right">Current Closing Balance</th>
                                        <th class="p-3.5 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-800/80">
                                    @foreach($parties as $party)
                                        <tr class="hover:bg-slate-900/40">
                                            <td class="p-3.5 font-mono font-bold text-cyan-400">{{ $party->code }}</td>
                                            <td class="p-3.5 font-bold text-white">{{ $party->name }}</td>
                                            <td class="p-3.5"><span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold uppercase bg-slate-800 text-slate-300">{{ $party->type }}</span></td>
                                            <td class="p-3.5 font-mono">Rs. {{ number_format($party->opening_balance, 2) }}</td>
                                            <td class="p-3.5 text-right font-mono font-bold text-emerald-400">Rs. {{ number_format($party->current_balance, 2) }}</td>
                                            <td class="p-3.5 text-center">
                                                <a href="{{ route('reports.index', ['party_id' => $party->id, 'from_date' => $fromDate, 'to_date' => $toDate]) }}" class="px-3 py-1 rounded-lg bg-cyan-500/10 hover:bg-cyan-500/20 text-cyan-300 text-[11px] font-bold border border-cyan-500/30">
                                                    View Detailed Ledger →
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>
