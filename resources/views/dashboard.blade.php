<x-app-layout>
    <div class="py-4 px-2 sm:px-6" x-data="erpDashboard()" @keydown.window="handleKey($event)">

        <!-- Hidden Logout Form for Exit button -->
        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
            @csrf
        </form>

        <div class="max-w-6xl mx-auto space-y-3 font-sans">
            
            <!-- MAIN CANVAS: Exact 4-Column Layout from Reference Image (Calendar Removed) -->
            <div class="bg-[#f7f4ed] rounded-xl border border-[#ded8cb] shadow-sm p-6 sm:p-10 flex flex-col justify-between min-h-[640px]">
                
                <!-- 4 Columns of Desktop Icon Buttons -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-y-10 gap-x-6 sm:gap-x-12 items-start justify-items-center">
                    
                    <!-- COLUMN 1: Masters (1 Parties, 2 Medical Reps, 3 Companies, 4 Salesmen, 5 Banks) -->
                    <div class="flex flex-col space-y-8 items-center w-full">
                        
                        <!-- 1 Parties -->
                        <a href="{{ route('parties.index') }}" class="group flex flex-col items-center text-center p-2.5 rounded-xl hover:bg-white/80 hover:shadow-md hover:scale-105 active:scale-95 transition-all select-none w-36 cursor-pointer" title="[HotKey: 1] Parties Ledger Accounts">
                            <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 shadow-sm flex items-center justify-center group-hover:border-[#00a2e8] transition-colors">
                                <svg class="w-10 h-10 text-slate-800 group-hover:text-[#007cb5] transition-colors" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="24" cy="20" r="4.5" fill="#e8f4fa"/>
                                    <path d="M17 31c0-3.8 3.1-7 7-7s7 3.2 7 7"/>
                                    <circle cx="9" cy="14" r="2.8" fill="#e0f2fe"/>
                                    <line x1="12" y1="16" x2="19" y2="19"/>
                                    <circle cx="39" cy="14" r="2.8" fill="#e0f2fe"/>
                                    <line x1="36" y1="16" x2="29" y2="19"/>
                                    <circle cx="10" cy="35" r="2.8" fill="#e0f2fe"/>
                                    <line x1="13" y1="34" x2="18" y2="30"/>
                                    <circle cx="38" cy="35" r="2.8" fill="#e0f2fe"/>
                                    <line x1="35" y1="34" x2="30" y2="30"/>
                                </svg>
                            </div>
                            <span class="mt-2 text-xs sm:text-sm font-black text-slate-900 group-hover:text-[#007cb5] tracking-tight">
                                <span class="underline decoration-2">1</span> Parties
                            </span>
                        </a>

                        <!-- 2 Medical Reps -->
                        <a href="{{ route('medical_reps.index') }}" class="group flex flex-col items-center text-center p-2.5 rounded-xl hover:bg-white/80 hover:shadow-md hover:scale-105 active:scale-95 transition-all select-none w-36 cursor-pointer" title="[HotKey: 2] Medical Representatives">
                            <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 shadow-sm flex items-center justify-center group-hover:border-[#00a2e8] transition-colors">
                                <svg class="w-10 h-10 text-slate-800 group-hover:text-[#007cb5] transition-colors" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="24" cy="14" r="5.5" fill="#e8f4fa"/>
                                    <path d="M14 36c0-5.5 4.5-10 10-10s10 4.5 10 10v1H14v-1z" fill="#f8fafc"/>
                                    <polygon points="24,24 25.5,28 24,33 22.5,28" fill="#0284c7" stroke="#0284c7"/>
                                </svg>
                            </div>
                            <span class="mt-2 text-xs sm:text-sm font-black text-slate-900 group-hover:text-[#007cb5] tracking-tight whitespace-nowrap">
                                <span class="underline decoration-2">2</span> Medical Reps
                            </span>
                        </a>

                        <!-- 3 Companies -->
                        <a href="{{ route('companies.index') }}" class="group flex flex-col items-center text-center p-2.5 rounded-xl hover:bg-white/80 hover:shadow-md hover:scale-105 active:scale-95 transition-all select-none w-36 cursor-pointer" title="[HotKey: 3] Pharma Companies / Suppliers">
                            <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 shadow-sm flex items-center justify-center group-hover:border-[#00a2e8] transition-colors">
                                <svg class="w-10 h-10 text-slate-800 group-hover:text-[#007cb5] transition-colors" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="13" y="9" width="22" height="30" rx="1.5" fill="#f8fafc"/>
                                    <line x1="18" y1="15" x2="21" y2="15"/>
                                    <line x1="27" y1="15" x2="30" y2="15"/>
                                    <line x1="18" y1="21" x2="21" y2="21"/>
                                    <line x1="27" y1="21" x2="30" y2="21"/>
                                    <line x1="18" y1="27" x2="21" y2="27"/>
                                    <line x1="27" y1="27" x2="30" y2="27"/>
                                    <rect x="21" y="33" width="6" height="6" fill="#00a2e8" stroke="#00a2e8"/>
                                </svg>
                            </div>
                            <span class="mt-2 text-xs sm:text-sm font-black text-slate-900 group-hover:text-[#007cb5] tracking-tight">
                                <span class="underline decoration-2">3</span> Companies
                            </span>
                        </a>

                        <!-- 4 Salesmen -->
                        <a href="{{ route('salesmen.index') }}" class="group flex flex-col items-center text-center p-2.5 rounded-xl hover:bg-white/80 hover:shadow-md hover:scale-105 active:scale-95 transition-all select-none w-36 cursor-pointer" title="[HotKey: 4] Salesmen & Order Bookers">
                            <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 shadow-sm flex items-center justify-center group-hover:border-[#00a2e8] transition-colors">
                                <svg class="w-10 h-10 text-slate-800 group-hover:text-[#007cb5] transition-colors" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="24" cy="14" r="5.5" fill="#e8f4fa"/>
                                    <path d="M13 36c0-6 5-11 11-11s11 5 11 11v1H13v-1z" fill="#f8fafc"/>
                                    <line x1="24" y1="25" x2="24" y2="33" stroke="#00a2e8" stroke-width="2"/>
                                </svg>
                            </div>
                            <span class="mt-2 text-xs sm:text-sm font-black text-slate-900 group-hover:text-[#007cb5] tracking-tight">
                                <span class="underline decoration-2">4</span> Salesmen
                            </span>
                        </a>

                        <!-- 5 Banks -->
                        <a href="{{ route('banks.index') }}" class="group flex flex-col items-center text-center p-2.5 rounded-xl hover:bg-white/80 hover:shadow-md hover:scale-105 active:scale-95 transition-all select-none w-36 cursor-pointer" title="[HotKey: 5] Bank Accounts & Cash Register">
                            <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 shadow-sm flex items-center justify-center group-hover:border-[#00a2e8] transition-colors">
                                <svg class="w-10 h-10 text-slate-800 group-hover:text-[#007cb5] transition-colors" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="24,9 9,17 39,17" fill="#e8f4fa"/>
                                    <line x1="13" y1="17" x2="13" y2="33"/>
                                    <line x1="20" y1="17" x2="20" y2="33"/>
                                    <line x1="28" y1="17" x2="28" y2="33"/>
                                    <line x1="35" y1="17" x2="35" y2="33"/>
                                    <rect x="8" y="33" width="32" height="5" rx="1" fill="#f8fafc"/>
                                </svg>
                            </div>
                            <span class="mt-2 text-xs sm:text-sm font-black text-slate-900 group-hover:text-[#007cb5] tracking-tight">
                                <span class="underline decoration-2">5</span> Banks
                            </span>
                        </a>

                    </div>

                    <!-- COLUMN 2: Registers & Vouchers (6 Expenses, 7 Amanats, 8 Lotteries, 9 Sales, 0 Purchases) -->
                    <div class="flex flex-col space-y-8 items-center w-full">
                        
                        <!-- 6 Expenses -->
                        <a href="{{ route('expenses.index') }}" class="group flex flex-col items-center text-center p-2.5 rounded-xl hover:bg-white/80 hover:shadow-md hover:scale-105 active:scale-95 transition-all select-none w-36 cursor-pointer" title="[HotKey: 6] Daily Expenses & Overhead">
                            <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 shadow-sm flex items-center justify-center group-hover:border-[#00a2e8] transition-colors">
                                <svg class="w-10 h-10 text-slate-800 group-hover:text-[#007cb5] transition-colors" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="11" y="8" width="26" height="32" rx="2.5" fill="#f8fafc"/>
                                    <rect x="15" y="12" width="18" height="6" rx="1" fill="#e8f4fa" stroke="#00a2e8"/>
                                    <circle cx="17" cy="24" r="1.5" fill="currentColor"/>
                                    <circle cx="24" cy="24" r="1.5" fill="currentColor"/>
                                    <circle cx="31" cy="24" r="1.5" fill="currentColor"/>
                                    <circle cx="17" cy="30" r="1.5" fill="currentColor"/>
                                    <circle cx="24" cy="30" r="1.5" fill="currentColor"/>
                                    <circle cx="31" cy="30" r="1.5" fill="currentColor"/>
                                    <line x1="16" y1="35" x2="32" y2="35" stroke="#00a2e8"/>
                                </svg>
                            </div>
                            <span class="mt-2 text-xs sm:text-sm font-black text-slate-900 group-hover:text-[#007cb5] tracking-tight">
                                <span class="underline decoration-2">6</span> Expenses
                            </span>
                        </a>

                        <!-- 7 Amanats -->
                        <a href="{{ route('amanats.index') }}" class="group flex flex-col items-center text-center p-2.5 rounded-xl hover:bg-white/80 hover:shadow-md hover:scale-105 active:scale-95 transition-all select-none w-36 cursor-pointer" title="[HotKey: 7] Amanats & Trust Funds">
                            <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 shadow-sm flex items-center justify-center group-hover:border-[#00a2e8] transition-colors">
                                <svg class="w-10 h-10 text-slate-800 group-hover:text-[#007cb5] transition-colors" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="10" y="10" width="28" height="28" rx="3" fill="#f8fafc"/>
                                    <circle cx="24" cy="24" r="6" stroke="#00a2e8" stroke-width="2" fill="#e8f4fa"/>
                                    <line x1="24" y1="18" x2="24" y2="20"/>
                                    <line x1="24" y1="28" x2="24" y2="30"/>
                                    <line x1="18" y1="24" x2="20" y2="24"/>
                                    <line x1="28" y1="24" x2="30" y2="24"/>
                                    <circle cx="24" cy="24" r="2" fill="#00a2e8"/>
                                </svg>
                            </div>
                            <span class="mt-2 text-xs sm:text-sm font-black text-slate-900 group-hover:text-[#007cb5] tracking-tight">
                                <span class="underline decoration-2">7</span> Amanats
                            </span>
                        </a>

                        <!-- 8 Lotteries -->
                        <a href="{{ route('lotteries.index') }}" class="group flex flex-col items-center text-center p-2.5 rounded-xl hover:bg-white/80 hover:shadow-md hover:scale-105 active:scale-95 transition-all select-none w-36 cursor-pointer" title="[HotKey: 8] Lotteries & Committees">
                            <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 shadow-sm flex items-center justify-center group-hover:border-[#00a2e8] transition-colors">
                                <svg class="w-10 h-10 text-slate-800 group-hover:text-[#007cb5] transition-colors" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M10 15c2 0 3-1 3-3V11h22v1c0 2 1 3 3 3h1v18h-1c-2 0-3 1-3 3v1H13v-1c0-2-1-3-3-3H9V15h1z" fill="#f8fafc"/>
                                    <line x1="20" y1="11" x2="20" y2="37" stroke-dasharray="2 2" stroke="#94a3b8"/>
                                    <polygon points="29,20 30.2,23 33.5,23.5 31,25.8 31.6,29 29,27.2 26.4,29 27,25.8 24.5,23.5 27.8,23" fill="#fef08a" stroke="#ca8a04" stroke-width="1.2"/>
                                </svg>
                            </div>
                            <span class="mt-2 text-xs sm:text-sm font-black text-slate-900 group-hover:text-[#007cb5] tracking-tight">
                                <span class="underline decoration-2">8</span> Lotteries
                            </span>
                        </a>

                        <!-- 9 Sales (CORE MODULE) -->
                        <a href="{{ route('sales.index') }}" class="group flex flex-col items-center text-center p-2.5 rounded-xl hover:bg-white/80 hover:shadow-md hover:scale-105 active:scale-95 transition-all select-none w-36 cursor-pointer" title="[HotKey: 9] Sales Ledger & Invoices">
                            <div class="w-16 h-16 rounded-xl bg-white border-2 border-[#00a2e8]/40 shadow-sm flex items-center justify-center group-hover:border-[#00a2e8] group-hover:bg-[#f0f8fd] transition-all">
                                <svg class="w-10 h-10 text-[#007cb5] group-hover:scale-110 transition-transform" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="18" cy="37" r="3.2" fill="#00a2e8"/>
                                    <circle cx="34" cy="37" r="3.2" fill="#00a2e8"/>
                                    <path d="M9 11h5l4 17h18l4-13H15.5" fill="#f8fafc"/>
                                    <path d="M24 18l4 4 6-6" stroke="#00a2e8" stroke-width="2.5"/>
                                </svg>
                            </div>
                            <span class="mt-2 text-xs sm:text-sm font-black text-[#007cb5] group-hover:text-[#00a2e8] tracking-tight">
                                <span class="underline decoration-2">9</span> Sales
                            </span>
                        </a>

                        <!-- 0 Purchases (CORE MODULE) -->
                        <a href="{{ route('purchases.index') }}" class="group flex flex-col items-center text-center p-2.5 rounded-xl hover:bg-white/80 hover:shadow-md hover:scale-105 active:scale-95 transition-all select-none w-36 cursor-pointer" title="[HotKey: 0] Purchases Register & Bills">
                            <div class="w-16 h-16 rounded-xl bg-white border-2 border-[#00a2e8]/40 shadow-sm flex items-center justify-center group-hover:border-[#00a2e8] group-hover:bg-[#f0f8fd] transition-all">
                                <svg class="w-10 h-10 text-[#007cb5] group-hover:scale-110 transition-transform" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="8" y="14" width="20" height="17" rx="1.5" fill="#f8fafc"/>
                                    <path d="M28 19h7l5 5v7h-12V19z" fill="#f8fafc"/>
                                    <circle cx="16" cy="36" r="3.2" fill="#00a2e8"/>
                                    <circle cx="35" cy="36" r="3.2" fill="#00a2e8"/>
                                    <line x1="19.2" y1="36" x2="31.8" y2="36"/>
                                    <line x1="8" y1="36" x2="12.8" y2="36"/>
                                </svg>
                            </div>
                            <span class="mt-2 text-xs sm:text-sm font-black text-[#007cb5] group-hover:text-[#00a2e8] tracking-tight">
                                <span class="underline decoration-2">0</span> Purchases
                            </span>
                        </a>

                    </div>

                    <!-- COLUMN 3: Cash Flow (A Receipts, B Payments) -->
                    <div class="flex flex-col space-y-8 items-center w-full">
                        
                        <!-- A Receipts -->
                        <a href="{{ route('vouchers.index', 'receipt') }}" class="group flex flex-col items-center text-center p-2.5 rounded-xl hover:bg-white/80 hover:shadow-md hover:scale-105 active:scale-95 transition-all select-none w-36 cursor-pointer" title="[HotKey: A] Cash & Bank Receipts">
                            <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 shadow-sm flex items-center justify-center group-hover:border-emerald-500 transition-colors">
                                <svg class="w-10 h-10 text-emerald-700 group-hover:scale-110 transition-transform" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="8" y="16" width="32" height="19" rx="2.5" fill="#f0fdf4" stroke="#16a34a"/>
                                    <circle cx="24" cy="25.5" r="4" fill="#dcfce7" stroke="#16a34a"/>
                                    <!-- Incoming Money Arrow -->
                                    <path d="M12 10l8 7m0 0l-5 1m5-1l-1-5" stroke="#16a34a" stroke-width="2.5"/>
                                </svg>
                            </div>
                            <span class="mt-2 text-xs sm:text-sm font-black text-slate-900 group-hover:text-emerald-700 tracking-tight">
                                <span class="underline decoration-2">A</span> Receipts
                            </span>
                        </a>

                        <!-- B Payments -->
                        <a href="{{ route('vouchers.index', 'payment') }}" class="group flex flex-col items-center text-center p-2.5 rounded-xl hover:bg-white/80 hover:shadow-md hover:scale-105 active:scale-95 transition-all select-none w-36 cursor-pointer" title="[HotKey: B] Cash & Bank Payments">
                            <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 shadow-sm flex items-center justify-center group-hover:border-rose-500 transition-colors">
                                <svg class="w-10 h-10 text-rose-700 group-hover:scale-110 transition-transform" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="8" y="16" width="32" height="19" rx="2.5" fill="#fff1f2" stroke="#e11d48"/>
                                    <circle cx="24" cy="25.5" r="4" fill="#ffe4e6" stroke="#e11d48"/>
                                    <!-- Outgoing Money Arrow -->
                                    <path d="M28 17l8-7m0 0l-5 1m5-1l-1-5" stroke="#e11d48" stroke-width="2.5"/>
                                </svg>
                            </div>
                            <span class="mt-2 text-xs sm:text-sm font-black text-slate-900 group-hover:text-rose-700 tracking-tight">
                                <span class="underline decoration-2">B</span> Payments
                            </span>
                        </a>

                    </div>

                    <!-- COLUMN 4: Actions & System (Reports, Settings & Others, Change Firm, Exit) -->
                    <div class="flex flex-col space-y-8 items-center w-full">
                        
                        <!-- Reports -->
                        <a href="{{ route('reports.index') }}" class="group flex flex-col items-center text-center p-2.5 rounded-xl hover:bg-white/80 hover:shadow-md hover:scale-105 active:scale-95 transition-all select-none w-36 cursor-pointer" title="[HotKey: R] Financial & Party Reports">
                            <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 shadow-sm flex items-center justify-center group-hover:border-[#00a2e8] transition-colors">
                                <svg class="w-10 h-10 text-slate-800 group-hover:text-[#007cb5] transition-colors" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="12" y="8" width="24" height="32" rx="2" fill="#f8fafc"/>
                                    <line x1="17" y1="15" x2="31" y2="15"/>
                                    <line x1="17" y1="21" x2="31" y2="21"/>
                                    <line x1="17" y1="27" x2="25" y2="27"/>
                                    <rect x="17" y="31" width="3" height="4" fill="#00a2e8" stroke="#00a2e8"/>
                                    <rect x="22" y="29" width="3" height="6" fill="#00a2e8" stroke="#00a2e8"/>
                                    <rect x="27" y="27" width="3" height="8" fill="#00a2e8" stroke="#00a2e8"/>
                                </svg>
                            </div>
                            <span class="mt-2 text-xs sm:text-sm font-black text-slate-900 group-hover:text-[#007cb5] tracking-tight">
                                Reports
                            </span>
                        </a>

                        <!-- Settings & Others -->
                        <a href="{{ route('settings.index') }}" class="group flex flex-col items-center text-center p-2.5 rounded-xl hover:bg-white/80 hover:shadow-md hover:scale-105 active:scale-95 transition-all select-none w-36 cursor-pointer" title="[HotKey: S] System Settings & Configuration">
                            <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 shadow-sm flex items-center justify-center group-hover:border-amber-500 transition-colors">
                                <svg class="w-10 h-10 text-slate-800 group-hover:text-amber-600 transition-colors" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="23" cy="23" r="5" fill="#f0f6fa"/>
                                    <path d="M23 12v3m0 16v3m-11-11h3m16 0h3m-17-7l2 2m11 11l2 2m-15 0l2-2m11-11l2-2"/>
                                    <circle cx="34" cy="34" r="3.5" fill="#fef08a" stroke="#ca8a04"/>
                                </svg>
                            </div>
                            <span class="mt-2 text-xs sm:text-sm font-black text-slate-900 group-hover:text-amber-600 tracking-tight whitespace-nowrap">
                                Settings & Others
                            </span>
                        </a>

                        <!-- Change Firm -->
                        <button type="button" @click="changeFirm()" class="group flex flex-col items-center text-center p-2.5 rounded-xl hover:bg-white/80 hover:shadow-md hover:scale-105 active:scale-95 transition-all select-none w-36 cursor-pointer" title="Switch Active Enterprise Firm">
                            <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 shadow-sm flex items-center justify-center group-hover:border-[#00a2e8] transition-colors">
                                <svg class="w-10 h-10 text-slate-800 group-hover:text-[#007cb5] transition-colors" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="9" y="14" width="15" height="22" rx="1.5" fill="#f8fafc"/>
                                    <rect x="24" y="11" width="15" height="25" rx="1.5" fill="#e0f2fe"/>
                                    <path d="M14 9h12m0 0l-3-3m3 3l-3 3" stroke="#00a2e8" stroke-width="2"/>
                                    <path d="M34 39H22m0 0l3-3m-3 3l3 3" stroke="#00a2e8" stroke-width="2"/>
                                </svg>
                            </div>
                            <span class="mt-2 text-xs sm:text-sm font-black text-slate-900 group-hover:text-[#007cb5] tracking-tight">
                                Change Firm
                            </span>
                        </button>

                        <!-- Exit -->
                        <button type="button" @click="confirmExit()" class="group flex flex-col items-center text-center p-2.5 rounded-xl hover:bg-white/80 hover:shadow-md hover:scale-105 active:scale-95 transition-all select-none w-36 cursor-pointer" title="[HotKey: Esc] Exit Session">
                            <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 shadow-sm flex items-center justify-center group-hover:border-rose-500 transition-colors">
                                <svg class="w-10 h-10 text-rose-600 group-hover:scale-110 transition-transform" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M25 11H14a3 3 0 0 0-3 3v20a3 3 0 0 0 3 3h11" fill="#f8fafc"/>
                                    <path d="M22 24h17m0 0l-5-5m5 5l-5 5" stroke="#dc2626" stroke-width="2.5"/>
                                </svg>
                            </div>
                            <span class="mt-2 text-xs sm:text-sm font-black text-rose-600 group-hover:text-rose-700 tracking-tight">
                                Exit
                            </span>
                        </button>

                    </div>

                </div>

                <!-- Bottom Helper Keyboard Hint & Session Tag -->
                <div class="mt-12 pt-4 border-t border-[#e2dcd0] flex flex-col sm:flex-row items-center justify-between text-xs text-slate-600 gap-2 select-none">
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded bg-white border border-slate-300 font-mono font-bold text-[#007cb5]">DESKTOP DIRECT KEY ACCESS</span>
                        <span>Press highlighted key (<kbd class="px-1.5 py-0.5 bg-white border border-slate-300 rounded font-mono font-bold">1</kbd>-<kbd class="px-1.5 py-0.5 bg-white border border-slate-300 rounded font-mono font-bold">0</kbd>, <kbd class="px-1.5 py-0.5 bg-white border border-slate-300 rounded font-mono font-bold">A</kbd>, <kbd class="px-1.5 py-0.5 bg-white border border-slate-300 rounded font-mono font-bold">B</kbd>) on keyboard anytime to launch</span>
                    </div>
                    <div class="text-[11px] font-mono text-slate-500 font-medium">
                        This is a non-commercial session. • {{ date('h:i A') }} • {{ date('d-M-Y') }}
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Externalized Alpine Component to prevent any HTML Attribute Escaping issues -->
    <script>
        function erpDashboard() {
            return {
                changeFirm() {
                    Swal.fire({
                        title: 'Change Firm / Branch',
                        html: '<div class="text-left text-xs text-slate-700 space-y-2">' +
                              '<p><strong>Current Active Firm:</strong><br><span class="font-mono font-bold text-emerald-700 text-sm">DAWN Medical Store & Co.</span></p>' +
                              '<p><strong>License ID:</strong> <span class="font-mono">PK-DAWN-2026-8820</span></p>' +
                              '<p class="text-slate-500 text-[11px] mt-2">Single-firm operational mode is currently enabled. Additional branch licenses can be attached in System Settings.</p>' +
                              '</div>',
                        icon: 'info',
                        confirmButtonColor: '#00a2e8',
                        confirmButtonText: 'OK'
                    });
                },
                confirmExit() {
                    Swal.fire({
                        title: 'Exit DAWN ERP?',
                        text: 'Are you sure you want to log out of your session?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#e11d48',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Yes, Exit',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('logout-form').submit();
                        }
                    });
                },
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
                    if (key === 's') window.location.href = '{{ route('settings.index') }}';
                    if (key === 'escape') this.confirmExit();
                }
            };
        }
    </script>
</x-app-layout>
