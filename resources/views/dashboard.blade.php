<x-app-layout>
    <div class="py-6" x-data="{
        handleKey(e) {
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
            const key = e.key.toLowerCase();
            if (key === '1') window.location.href = '{{ route('parties.index') }}';
            if (key === '2') window.location.href = '{{ route('products.index') }}';
            if (key === '3') window.location.href = '{{ route('companies.index') }}';
            if (key === '4') window.location.href = '{{ route('salesmen.index') }}';
            if (key === '5') window.location.href = '{{ route('banks.index') }}';
            if (key === '6') window.location.href = '{{ route('expenses.index') }}';
            if (key === '9') window.location.href = '{{ route('sales.index') }}';
            if (key === '0') window.location.href = '{{ route('purchases.index') }}';
            if (key === 'a') window.location.href = '{{ route('vouchers.index', 'receipt') }}';
            if (key === 'b') window.location.href = '{{ route('vouchers.index', 'payment') }}';
            if (key === 'r') window.location.href = '{{ route('reports.index') }}';
        }
    }" @keydown.window="handleKey($event)">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">
            
            <!-- Quick Keyboard Navigation Notice Bar -->
            <div class="flex items-center justify-between text-xs text-slate-400 bg-slate-900/60 py-2.5 px-4 rounded-xl border border-slate-800 shadow-sm">
                <div class="flex items-center gap-2">
                    <span class="px-2 py-0.5 rounded bg-cyan-500/20 text-cyan-300 font-mono font-bold text-[10px]">KEYBOARD SHORTCUTS</span>
                    <span>Press key <kbd class="px-1.5 py-0.5 bg-slate-800 text-cyan-300 rounded font-mono">1</kbd>-<kbd class="px-1.5 py-0.5 bg-slate-800 text-cyan-300 rounded font-mono">6</kbd> for Masters/Products, <kbd class="px-1.5 py-0.5 bg-slate-800 text-cyan-300 rounded font-mono">9</kbd> for Sales, <kbd class="px-1.5 py-0.5 bg-slate-800 text-cyan-300 rounded font-mono">0</kbd> for Purchases, <kbd class="px-1.5 py-0.5 bg-slate-800 text-cyan-300 rounded font-mono">A</kbd> Receipts, <kbd class="px-1.5 py-0.5 bg-slate-800 text-cyan-300 rounded font-mono">B</kbd> Payments</span>
                </div>
                <span class="text-cyan-400 font-semibold hidden sm:inline">Press shortcut key on keyboard anytime</span>
            </div>

            <!-- Main ERP Grid Menu -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                
                <!-- Left 3 Columns: Grid Menu -->
                <div class="md:col-span-3 grid grid-cols-2 sm:grid-cols-4 gap-4">
                    
                    <!-- 1 Parties -->
                    <a href="{{ route('parties.index') }}" class="prowave-glass-card rounded-2xl p-5 border border-slate-800 hover:border-cyan-400 text-center flex flex-col items-center justify-center gap-3 group">
                        <div class="w-13 h-13 rounded-2xl bg-cyan-500/10 border border-cyan-500/30 flex items-center justify-center text-cyan-400 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-base font-extrabold text-gray-900 dark:text-white font-['Outfit']">1 Parties</div>
                            <div class="text-[11px] text-slate-400 font-mono mt-0.5">{{ $partiesCount }} Registered</div>
                        </div>
                    </a>

                    <!-- 2 Products (With Barcode) -->
                    <a href="{{ route('products.index') }}" class="prowave-glass-card rounded-2xl p-5 border border-indigo-500/40 bg-indigo-950/10 hover:border-cyan-400 text-center flex flex-col items-center justify-center gap-3 group">
                        <div class="w-13 h-13 rounded-2xl bg-indigo-500/20 border border-indigo-500/40 flex items-center justify-center text-indigo-300 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <div>
                            <div class="text-base font-extrabold text-indigo-200 font-['Outfit']">2 Products</div>
                            <div class="text-[11px] text-cyan-400 font-mono mt-0.5 font-bold">{{ $productsCount }} Barcode Items</div>
                        </div>
                    </a>

                    <!-- 3 Companies -->
                    <a href="{{ route('companies.index') }}" class="prowave-glass-card rounded-2xl p-5 border border-slate-800 hover:border-cyan-400 text-center flex flex-col items-center justify-center gap-3 group">
                        <div class="w-13 h-13 rounded-2xl bg-purple-500/10 border border-purple-500/30 flex items-center justify-center text-purple-400 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div>
                            <div class="text-base font-extrabold text-gray-900 dark:text-white font-['Outfit']">3 Companies</div>
                            <div class="text-[11px] text-slate-400 font-mono mt-0.5">Manufacturers</div>
                        </div>
                    </a>

                    <!-- 4 Salesmen -->
                    <a href="{{ route('salesmen.index') }}" class="prowave-glass-card rounded-2xl p-5 border border-slate-800 hover:border-cyan-400 text-center flex flex-col items-center justify-center gap-3 group">
                        <div class="w-13 h-13 rounded-2xl bg-cyan-500/10 border border-cyan-500/30 flex items-center justify-center text-cyan-400 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <div class="text-base font-extrabold text-gray-900 dark:text-white font-['Outfit']">4 Salesmen</div>
                            <div class="text-[11px] text-slate-400 font-mono mt-0.5">Sales Force</div>
                        </div>
                    </a>

                    <!-- 5 Banks -->
                    <a href="{{ route('banks.index') }}" class="prowave-glass-card rounded-2xl p-5 border border-slate-800 hover:border-cyan-400 text-center flex flex-col items-center justify-center gap-3 group">
                        <div class="w-13 h-13 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center text-emerald-400 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m4 0h1m-7 4h12a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <div class="text-base font-extrabold text-gray-900 dark:text-white font-['Outfit']">5 Banks</div>
                            <div class="text-[11px] text-slate-400 font-mono mt-0.5">Accounts & Cash</div>
                        </div>
                    </a>

                    <!-- 6 Expenses -->
                    <a href="{{ route('expenses.index') }}" class="prowave-glass-card rounded-2xl p-5 border border-slate-800 hover:border-cyan-400 text-center flex flex-col items-center justify-center gap-3 group">
                        <div class="w-13 h-13 rounded-2xl bg-rose-500/10 border border-rose-500/30 flex items-center justify-center text-rose-400 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <div class="text-base font-extrabold text-gray-900 dark:text-white font-['Outfit']">6 Expenses</div>
                            <div class="text-[11px] text-rose-400 font-mono mt-0.5 font-bold">Rs. {{ number_format($expensesTotal, 0) }}</div>
                        </div>
                    </a>

                    <!-- 9 Sales -->
                    <a href="{{ route('sales.index') }}" class="prowave-glass-card rounded-2xl p-5 border-2 border-cyan-400 bg-cyan-950/20 text-center flex flex-col items-center justify-center gap-3 group shadow-lg shadow-cyan-500/20">
                        <div class="w-13 h-13 rounded-2xl bg-cyan-500/20 border border-cyan-400 flex items-center justify-center text-cyan-300 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z"/></svg>
                        </div>
                        <div>
                            <div class="text-lg font-extrabold text-cyan-300 font-['Outfit']">9 Sales</div>
                            <div class="text-xs text-cyan-400 font-mono mt-0.5 font-bold">{{ $salesCount }} Invoices</div>
                        </div>
                    </a>

                    <!-- 0 Purchases -->
                    <a href="{{ route('purchases.index') }}" class="prowave-glass-card rounded-2xl p-5 border-2 border-indigo-400 bg-indigo-950/20 text-center flex flex-col items-center justify-center gap-3 group shadow-lg shadow-indigo-500/20">
                        <div class="w-13 h-13 rounded-2xl bg-indigo-500/20 border border-indigo-400 flex items-center justify-center text-indigo-300 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        </div>
                        <div>
                            <div class="text-lg font-extrabold text-indigo-300 font-['Outfit']">0 Purchases</div>
                            <div class="text-xs text-indigo-400 font-mono mt-0.5 font-bold">{{ $purchasesCount }} Bills</div>
                        </div>
                    </a>

                    <!-- A Receipts -->
                    <a href="{{ route('vouchers.index', 'receipt') }}" class="prowave-glass-card rounded-2xl p-5 border border-slate-800 hover:border-cyan-400 text-center flex flex-col items-center justify-center gap-3 group sm:col-span-2">
                        <div class="w-13 h-13 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center text-emerald-400 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-base font-extrabold text-gray-900 dark:text-white font-['Outfit']">A Receipts</div>
                            <div class="text-[11px] text-emerald-400 font-mono mt-0.5 font-bold">Rs. {{ number_format($receiptsTotal, 0) }}</div>
                        </div>
                    </a>

                    <!-- B Payments -->
                    <a href="{{ route('vouchers.index', 'payment') }}" class="prowave-glass-card rounded-2xl p-5 border border-slate-800 hover:border-cyan-400 text-center flex flex-col items-center justify-center gap-3 group sm:col-span-2">
                        <div class="w-13 h-13 rounded-2xl bg-rose-500/10 border border-rose-500/30 flex items-center justify-center text-rose-400 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-base font-extrabold text-gray-900 dark:text-white font-['Outfit']">B Payments</div>
                            <div class="text-[11px] text-rose-400 font-mono mt-0.5 font-bold">Rs. {{ number_format($paymentsTotal, 0) }}</div>
                        </div>
                    </a>

                </div>

                <!-- Right Sidebar Column -->
                <div class="space-y-4">
                    
                    <!-- Reports Tile -->
                    <a href="{{ route('reports.index') }}" class="prowave-glass-card rounded-2xl p-5 border border-slate-800 hover:border-cyan-400 flex items-center gap-4 group">
                        <div class="w-12 h-12 rounded-xl bg-purple-500/10 border border-purple-500/30 flex items-center justify-center text-purple-400 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <div class="text-base font-bold text-gray-900 dark:text-white font-['Outfit']">Reports</div>
                            <div class="text-xs text-slate-400">Financial Ledgers & Stock</div>
                        </div>
                    </a>

                    <!-- Settings & Others -->
                    <a href="{{ route('profile.edit') }}" class="prowave-glass-card rounded-2xl p-5 border-2 border-amber-500 bg-amber-500/20 flex items-center gap-4 group shadow-lg shadow-amber-500/20">
                        <div class="w-12 h-12 rounded-xl bg-amber-500/30 border border-amber-400 flex items-center justify-center text-amber-200 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-base font-extrabold text-amber-200 font-['Outfit']">Settings & Others</div>
                            <div class="text-xs text-amber-300/80">Config & Preferences</div>
                        </div>
                    </a>

                    <!-- Change Firm -->
                    <a href="{{ route('dashboard') }}" class="prowave-glass-card rounded-2xl p-5 border border-slate-800 hover:border-cyan-400 flex items-center gap-4 group">
                        <div class="w-12 h-12 rounded-xl bg-cyan-500/10 border border-cyan-500/30 flex items-center justify-center text-cyan-400 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                        </div>
                        <div>
                            <div class="text-base font-bold text-gray-900 dark:text-white font-['Outfit']">Change Firm</div>
                            <div class="text-xs text-slate-400">Switch Branch / Company</div>
                        </div>
                    </a>

                    <!-- Exit -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full prowave-glass-card rounded-2xl p-5 border border-rose-500/30 hover:bg-rose-500/10 flex items-center gap-4 group text-left">
                            <div class="w-12 h-12 rounded-xl bg-rose-500/20 border border-rose-400 flex items-center justify-center text-rose-400 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            </div>
                            <div>
                                <div class="text-base font-bold text-rose-300 font-['Outfit']">Exit</div>
                                <div class="text-xs text-rose-400/70">Logout Session</div>
                            </div>
                        </button>
                    </form>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
