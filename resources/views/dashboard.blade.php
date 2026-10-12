<x-app-layout>
    <div class="py-4" x-data="{
        handleKey(e) {
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
            const key = e.key.toLowerCase();
            if (key === '1') window.location.href = '{{ route('parties.index') }}';
            if (key === '2') window.location.href = '{{ route('medical_reps.index') }}';
            if (key === '3') window.location.href = '{{ route('companies.index') }}';
            if (key === '4') window.location.href = '{{ route('salesmen.index') }}';
            if (key === '5') window.location.href = '{{ route('banks.index') }}';
            if (key === '6') window.location.href = '{{ route('expenses.index') }}';
            if (key === '7') window.location.href = '{{ route('amanats.index') }}';
            if (key === '8') window.location.href = '{{ route('lotteries.index') }}';
            if (key === '9') window.location.href = '{{ route('sales.index') }}';
            if (key === '0') window.location.href = '{{ route('purchases.index') }}';
            if (key === 'a') window.location.href = '{{ route('vouchers.index', 'receipt') }}';
            if (key === 'b') window.location.href = '{{ route('vouchers.index', 'payment') }}';
            if (key === 'r') window.location.href = '{{ route('reports.index') }}';
        }
    }" @keydown.window="handleKey($event)">
        
        <div class="max-w-7xl mx-auto px-3 sm:px-6 space-y-4">
            
            <!-- DAWN Top Header Banner matching Reference Image -->
            <div class="bg-[#00a2e8] rounded-lg p-4 shadow-md border-2 border-[#008ecb] text-black flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <span class="text-xl">🖥️</span>
                    <span class="text-base font-black uppercase tracking-wider text-black">Main Terminal System</span>
                </div>
                <div class="flex items-center gap-2 text-xs font-bold bg-white/30 px-3 py-1.5 rounded-full border border-white/50">
                    <span>Direct Key Access:</span>
                    <kbd class="px-1.5 py-0.5 bg-white text-black rounded font-mono font-bold text-[11px] shadow-sm">1-8</kbd> Masters
                    <kbd class="px-1.5 py-0.5 bg-white text-black rounded font-mono font-bold text-[11px] shadow-sm">9</kbd> Sales
                    <kbd class="px-1.5 py-0.5 bg-white text-black rounded font-mono font-bold text-[11px] shadow-sm">0</kbd> Purchases
                </div>
            </div>

            <!-- Main ERP Grid Menu matching Image 1 layout -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                
                <!-- Left 3 Columns: 12 Tile Items Grid -->
                <div class="md:col-span-3 grid grid-cols-2 sm:grid-cols-4 gap-3.5">
                    
                    <!-- 1 Parties -->
                    <a href="{{ route('parties.index') }}" class="bg-white rounded-lg p-4 border-2 border-[#c6d7e6] hover:border-[#00a2e8] hover:shadow-md text-center flex flex-col items-center justify-center gap-2.5 transition-all group shadow-sm">
                        <div class="w-12 h-12 rounded-lg bg-[#e8f4fa] border border-[#00a2e8] flex items-center justify-center text-[#007cb5] group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-sm font-black text-slate-900 font-sans">1 Parties</div>
                            <div class="text-[11px] text-slate-500 font-mono mt-0.5">{{ $partiesCount }} Registered</div>
                        </div>
                    </a>

                    <!-- 2 Medical Reps -->
                    <a href="{{ route('medical_reps.index') }}" class="bg-white rounded-lg p-4 border-2 border-[#c6d7e6] hover:border-[#00a2e8] hover:shadow-md text-center flex flex-col items-center justify-center gap-2.5 transition-all group shadow-sm">
                        <div class="w-12 h-12 rounded-lg bg-[#e8f4fa] border border-[#00a2e8] flex items-center justify-center text-[#007cb5] group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <div class="text-sm font-black text-slate-900 font-sans">2 Medical Reps</div>
                            <div class="text-[11px] text-slate-500 font-mono mt-0.5">Field Reps</div>
                        </div>
                    </a>

                    <!-- 3 Companies -->
                    <a href="{{ route('companies.index') }}" class="bg-white rounded-lg p-4 border-2 border-[#c6d7e6] hover:border-[#00a2e8] hover:shadow-md text-center flex flex-col items-center justify-center gap-2.5 transition-all group shadow-sm">
                        <div class="w-12 h-12 rounded-lg bg-[#e8f4fa] border border-[#00a2e8] flex items-center justify-center text-[#007cb5] group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div>
                            <div class="text-sm font-black text-slate-900 font-sans">3 Companies</div>
                            <div class="text-[11px] text-slate-500 font-mono mt-0.5">Manufacturers</div>
                        </div>
                    </a>

                    <!-- 4 Salesmen -->
                    <a href="{{ route('salesmen.index') }}" class="bg-white rounded-lg p-4 border-2 border-[#c6d7e6] hover:border-[#00a2e8] hover:shadow-md text-center flex flex-col items-center justify-center gap-2.5 transition-all group shadow-sm">
                        <div class="w-12 h-12 rounded-lg bg-[#e8f4fa] border border-[#00a2e8] flex items-center justify-center text-[#007cb5] group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <div class="text-sm font-black text-slate-900 font-sans">4 Salesmen</div>
                            <div class="text-[11px] text-slate-500 font-mono mt-0.5">Sales Force</div>
                        </div>
                    </a>

                    <!-- 5 Banks -->
                    <a href="{{ route('banks.index') }}" class="bg-white rounded-lg p-4 border-2 border-[#c6d7e6] hover:border-[#00a2e8] hover:shadow-md text-center flex flex-col items-center justify-center gap-2.5 transition-all group shadow-sm">
                        <div class="w-12 h-12 rounded-lg bg-[#e8f4fa] border border-[#00a2e8] flex items-center justify-center text-[#007cb5] group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m4 0h1m-7 4h12a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <div class="text-sm font-black text-slate-900 font-sans">5 Banks</div>
                            <div class="text-[11px] text-slate-500 font-mono mt-0.5">Accounts & Cash</div>
                        </div>
                    </a>

                    <!-- 6 Expenses -->
                    <a href="{{ route('expenses.index') }}" class="bg-white rounded-lg p-4 border-2 border-[#c6d7e6] hover:border-[#00a2e8] hover:shadow-md text-center flex flex-col items-center justify-center gap-2.5 transition-all group shadow-sm">
                        <div class="w-12 h-12 rounded-lg bg-[#e8f4fa] border border-[#00a2e8] flex items-center justify-center text-[#007cb5] group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <div class="text-sm font-black text-slate-900 font-sans">6 Expenses</div>
                            <div class="text-[11px] text-rose-600 font-mono mt-0.5 font-bold">Rs. {{ number_format($expensesTotal, 0) }}</div>
                        </div>
                    </a>

                    <!-- 7 Amanats -->
                    <a href="{{ route('amanats.index') }}" class="bg-white rounded-lg p-4 border-2 border-[#c6d7e6] hover:border-[#00a2e8] hover:shadow-md text-center flex flex-col items-center justify-center gap-2.5 transition-all group shadow-sm">
                        <div class="w-12 h-12 rounded-lg bg-[#e8f4fa] border border-[#00a2e8] flex items-center justify-center text-[#007cb5] group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-sm font-black text-slate-900 font-sans">7 Amanats</div>
                            <div class="text-[11px] text-slate-500 font-mono mt-0.5">Trust Funds</div>
                        </div>
                    </a>

                    <!-- 8 Lotteries -->
                    <a href="{{ route('lotteries.index') }}" class="bg-white rounded-lg p-4 border-2 border-[#c6d7e6] hover:border-[#00a2e8] hover:shadow-md text-center flex flex-col items-center justify-center gap-2.5 transition-all group shadow-sm">
                        <div class="w-12 h-12 rounded-lg bg-[#e8f4fa] border border-[#00a2e8] flex items-center justify-center text-[#007cb5] group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H5z"/></svg>
                        </div>
                        <div>
                            <div class="text-sm font-black text-slate-900 font-sans">8 Lotteries</div>
                            <div class="text-[11px] text-slate-500 font-mono mt-0.5">Schemes</div>
                        </div>
                    </a>

                    <!-- 9 Sales (DAWN CORE MODULE) -->
                    <a href="{{ route('sales.index') }}" class="bg-white rounded-lg p-4 border-2 border-[#00a2e8] bg-[#f0f8fd] hover:shadow-lg text-center flex flex-col items-center justify-center gap-2.5 transition-all group shadow-sm">
                        <div class="w-12 h-12 rounded-lg bg-[#00a2e8] text-white flex items-center justify-center group-hover:scale-105 transition-transform shadow-sm">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z"/></svg>
                        </div>
                        <div>
                            <div class="text-base font-black text-slate-900 font-sans">9 Sales</div>
                            <div class="text-xs text-[#007cb5] font-mono mt-0.5 font-bold">{{ $salesCount }} Invoices</div>
                        </div>
                    </a>

                    <!-- 0 Purchases (DAWN CORE MODULE - MATCHING REFERENCE IMAGE) -->
                    <a href="{{ route('purchases.index') }}" class="bg-white rounded-lg p-4 border-2 border-[#00a2e8] bg-[#f0f8fd] hover:shadow-lg text-center flex flex-col items-center justify-center gap-2.5 transition-all group shadow-sm">
                        <div class="w-12 h-12 rounded-lg bg-[#00a2e8] text-white flex items-center justify-center group-hover:scale-105 transition-transform shadow-sm">
                            <!-- Truck Icon -->
                            <svg class="w-7 h-7" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 7h15v14H3z" />
                                <path d="M18 12h6l4 4v5h-10z" />
                                <circle cx="8" cy="23" r="2.5" />
                                <circle cx="23" cy="23" r="2.5" />
                                <line x1="10.5" y1="23" x2="20.5" y2="23" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-base font-black text-slate-900 font-sans">0 Purchases</div>
                            <div class="text-xs text-[#007cb5] font-mono mt-0.5 font-bold">{{ $purchasesCount }} Bills</div>
                        </div>
                    </a>

                    <!-- A Receipts -->
                    <a href="{{ route('vouchers.index', 'receipt') }}" class="bg-white rounded-lg p-4 border-2 border-[#c6d7e6] hover:border-[#00a2e8] hover:shadow-md text-center flex flex-col items-center justify-center gap-2.5 transition-all group shadow-sm">
                        <div class="w-12 h-12 rounded-lg bg-[#e8f4fa] border border-[#00a2e8] flex items-center justify-center text-[#007cb5] group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-sm font-black text-slate-900 font-sans">A Receipts</div>
                            <div class="text-[11px] text-emerald-700 font-mono mt-0.5 font-bold">Rs. {{ number_format($receiptsTotal, 0) }}</div>
                        </div>
                    </a>

                    <!-- B Payments -->
                    <a href="{{ route('vouchers.index', 'payment') }}" class="bg-white rounded-lg p-4 border-2 border-[#c6d7e6] hover:border-[#00a2e8] hover:shadow-md text-center flex flex-col items-center justify-center gap-2.5 transition-all group shadow-sm">
                        <div class="w-12 h-12 rounded-lg bg-[#e8f4fa] border border-[#00a2e8] flex items-center justify-center text-[#007cb5] group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-sm font-black text-slate-900 font-sans">B Payments</div>
                            <div class="text-[11px] text-rose-600 font-mono mt-0.5 font-bold">Rs. {{ number_format($paymentsTotal, 0) }}</div>
                        </div>
                    </a>

                </div>

                <!-- Right Sidebar Column matching Classic DAWN Layout -->
                <div class="space-y-3">
                    
                    <!-- Reports Tile -->
                    <a href="{{ route('reports.index') }}" class="bg-white rounded-lg p-4 border-2 border-[#c6d7e6] hover:border-[#00a2e8] hover:shadow-md flex items-center gap-3.5 group shadow-sm transition-all">
                        <div class="w-11 h-11 rounded-lg bg-[#e8f4fa] border border-[#00a2e8] flex items-center justify-center text-[#007cb5] group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <div class="text-sm font-black text-slate-900 font-sans">Reports</div>
                            <div class="text-xs text-slate-500">Financial Statements</div>
                        </div>
                    </a>

                    <!-- Settings & Others -->
                    <a href="{{ route('settings.index') }}" class="bg-white rounded-lg p-4 border-2 border-[#c6d7e6] hover:border-[#00a2e8] hover:shadow-md flex items-center gap-3.5 group shadow-sm transition-all">
                        <div class="w-11 h-11 rounded-lg bg-[#fff8e7] border border-amber-400 flex items-center justify-center text-amber-600 group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-sm font-black text-slate-900 font-sans">Settings & Config</div>
                            <div class="text-xs text-slate-500">Security & Preferences</div>
                        </div>
                    </a>

                    <!-- Profile -->
                    <a href="{{ route('profile.edit') }}" class="bg-white rounded-lg p-4 border-2 border-[#c6d7e6] hover:border-[#00a2e8] hover:shadow-md flex items-center gap-3.5 group shadow-sm transition-all">
                        <div class="w-11 h-11 rounded-lg bg-[#e8f4fa] border border-[#00a2e8] flex items-center justify-center text-[#007cb5] group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <div class="text-sm font-black text-slate-900 font-sans">User Profile</div>
                            <div class="text-xs text-slate-500">Account Credentials</div>
                        </div>
                    </a>

                    <!-- Exit -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full bg-white rounded-lg p-4 border-2 border-rose-300 hover:border-rose-500 hover:bg-rose-50 flex items-center gap-3.5 group text-left shadow-sm transition-all">
                            <div class="w-11 h-11 rounded-lg bg-rose-100 border border-rose-400 flex items-center justify-center text-rose-600 group-hover:scale-105 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            </div>
                            <div>
                                <div class="text-sm font-black text-rose-700 font-sans">Exit System</div>
                                <div class="text-xs text-rose-500">Logout Session</div>
                            </div>
                        </button>
                    </form>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
