<x-app-layout>
    <div class="py-5 px-3 sm:px-6 lg:px-8" x-data="erpDashboard()" @keydown.window="handleKey($event)">

        <!-- Hidden Logout Form for Exit button -->
        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
            @csrf
        </form>

        <div class="max-w-[1360px] mx-auto space-y-4 font-sans">
            
            <!-- MAIN DESKTOP CANVAS: 1:1 Accurate Layout Cloned from Reference Screenshot -->
            <div class="bg-[#f0f4f9] rounded-xl border border-[#c6d7e8] shadow-md p-6 sm:p-10 lg:p-12 flex flex-col justify-between min-h-[660px]">
                
                <!-- 4 Columns of Desktop Icons with exact Horizontal & Vertical Alignment -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-y-9 sm:gap-y-11 gap-x-6 sm:gap-x-10 lg:gap-x-16 items-start">
                    
                    <!-- ========================================================= -->
                    <!-- COLUMN 1: Masters (1 Parties, 2 Medical Reps, 3 Companies, 4 Salesmen, 5 Banks) -->
                    <!-- ========================================================= -->
                    <div class="flex flex-col space-y-9 sm:space-y-11 items-center w-full">
                        
                        <!-- 1 Parties -->
                        <a href="{{ route('parties.index') }}" 
                           class="group flex flex-col items-center justify-center text-center p-2 rounded-lg hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer border border-transparent" 
                           title="[HotKey: 1] Parties Ledger Accounts">
                            <div class="w-12 h-12 flex items-center justify-center">
                                <svg class="w-12 h-12 text-slate-800 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <!-- Center Circle & Person Silhouette -->
                                    <circle cx="32" cy="32" r="10.5" fill="#e2edfa" stroke="#1e293b" stroke-width="2.2" />
                                    <circle cx="32" cy="27" r="3.2" fill="#1e293b" />
                                    <path d="M26 38c0-3.2 2.7-5.2 6-5.2s6 2 6 5.2" fill="#1e293b" />
                                    <!-- 6 Surrounding Connector Nodes -->
                                    <circle cx="32" cy="9" r="3.8" fill="#ffffff" stroke="#1e293b" stroke-width="2" />
                                    <line x1="32" y1="13" x2="32" y2="21.5" stroke="#1e293b" stroke-width="1.8" />
                                    <circle cx="52" cy="20" r="3.8" fill="#ffffff" stroke="#1e293b" stroke-width="2" />
                                    <line x1="48.5" y1="23" x2="41.5" y2="27.5" stroke="#1e293b" stroke-width="1.8" />
                                    <circle cx="52" cy="44" r="3.8" fill="#ffffff" stroke="#1e293b" stroke-width="2" />
                                    <line x1="48.5" y1="41" x2="41.5" y2="36.5" stroke="#1e293b" stroke-width="1.8" />
                                    <circle cx="32" cy="55" r="3.8" fill="#ffffff" stroke="#1e293b" stroke-width="2" />
                                    <line x1="32" y1="51" x2="32" y2="42.5" stroke="#1e293b" stroke-width="1.8" />
                                    <circle cx="12" cy="44" r="3.8" fill="#ffffff" stroke="#1e293b" stroke-width="2" />
                                    <line x1="15.5" y1="41" x2="22.5" y2="36.5" stroke="#1e293b" stroke-width="1.8" />
                                    <circle cx="12" cy="20" r="3.8" fill="#ffffff" stroke="#1e293b" stroke-width="2" />
                                    <line x1="15.5" y1="23" x2="22.5" y2="27.5" stroke="#1e293b" stroke-width="1.8" />
                                </svg>
                            </div>
                            <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight">
                                <span class="underline decoration-2 underline-offset-2">1</span> Parties
                            </span>
                        </a>

                        <!-- 2 Medical Reps -->
                        <a href="{{ route('medical_reps.index') }}" 
                           class="group flex flex-col items-center justify-center text-center p-2 rounded-lg hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer border border-transparent" 
                           title="[HotKey: 2] Medical Representatives">
                            <div class="w-12 h-12 flex items-center justify-center">
                                <svg class="w-12 h-12 text-slate-900 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64">
                                    <!-- Head Silhouette -->
                                    <circle cx="32" cy="18" r="9" fill="#1e293b" />
                                    <!-- Suit Shoulders & Jacket -->
                                    <path d="M14 50c0-9 8-15 18-15s18 6 18 15v4H14v-4z" fill="#1e293b" />
                                    <!-- White Dress Shirt V-Neck Collar -->
                                    <polygon points="32,35 25,43 28,45 32,39 36,45 39,43" fill="#ffffff" />
                                    <!-- Black Necktie -->
                                    <polygon points="32,39 34,43 33,52 32,54 31,52 30,43" fill="#0f172a" />
                                </svg>
                            </div>
                            <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight whitespace-nowrap">
                                <span class="underline decoration-2 underline-offset-2">2</span> Medical Reps
                            </span>
                        </a>

                        <!-- 3 Companies -->
                        <a href="{{ route('companies.index') }}" 
                           class="group flex flex-col items-center justify-center text-center p-2 rounded-lg hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer border border-transparent" 
                           title="[HotKey: 3] Companies">
                            <div class="w-12 h-12 flex items-center justify-center">
                                <svg class="w-12 h-12 text-slate-800 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <!-- Office Building Outline -->
                                    <rect x="18" y="10" width="28" height="46" rx="1.5" fill="#ffffff" stroke="#1e293b" stroke-width="2.2" />
                                    <!-- Grid of Windows: 3 columns x 4 rows -->
                                    <rect x="23" y="16" width="4.5" height="4.5" fill="#1e293b" stroke="#1e293b" />
                                    <rect x="30" y="16" width="4.5" height="4.5" fill="#1e293b" stroke="#1e293b" />
                                    <rect x="37" y="16" width="4.5" height="4.5" fill="#1e293b" stroke="#1e293b" />
                                    
                                    <rect x="23" y="24" width="4.5" height="4.5" fill="#1e293b" stroke="#1e293b" />
                                    <rect x="30" y="24" width="4.5" height="4.5" fill="#1e293b" stroke="#1e293b" />
                                    <rect x="37" y="24" width="4.5" height="4.5" fill="#1e293b" stroke="#1e293b" />
                                    
                                    <rect x="23" y="32" width="4.5" height="4.5" fill="#1e293b" stroke="#1e293b" />
                                    <rect x="30" y="32" width="4.5" height="4.5" fill="#1e293b" stroke="#1e293b" />
                                    <rect x="37" y="32" width="4.5" height="4.5" fill="#1e293b" stroke="#1e293b" />
                                    
                                    <rect x="23" y="40" width="4.5" height="4.5" fill="#1e293b" stroke="#1e293b" />
                                    <rect x="30" y="40" width="4.5" height="4.5" fill="#1e293b" stroke="#1e293b" />
                                    <rect x="37" y="40" width="4.5" height="4.5" fill="#1e293b" stroke="#1e293b" />
                                    
                                    <!-- Entrance Doorway -->
                                    <rect x="29" y="48" width="6" height="8" fill="#1e293b" />
                                </svg>
                            </div>
                            <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight">
                                <span class="underline decoration-2 underline-offset-2">3</span> Companies
                            </span>
                        </a>

                        <!-- 4 Salesmen -->
                        <a href="{{ route('salesmen.index') }}" 
                           class="group flex flex-col items-center justify-center text-center p-2 rounded-lg hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer border border-transparent" 
                           title="[HotKey: 4] Salesmen">
                            <div class="w-12 h-12 flex items-center justify-center">
                                <svg class="w-12 h-12 text-slate-900 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64">
                                    <!-- Person Silhouette -->
                                    <circle cx="32" cy="18" r="9" fill="#1e293b" />
                                    <path d="M14 50c0-9 8-15 18-15s18 6 18 15v4H14v-4z" fill="#1e293b" />
                                    <polygon points="32,35 27,43 32,41 37,43" fill="#ffffff" />
                                </svg>
                            </div>
                            <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight">
                                <span class="underline decoration-2 underline-offset-2">4</span> Salesmen
                            </span>
                        </a>

                        <!-- 5 Banks -->
                        <a href="{{ route('banks.index') }}" 
                           class="group flex flex-col items-center justify-center text-center p-2 rounded-lg hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer border border-transparent" 
                           title="[HotKey: 5] Bank Accounts & Ledgers">
                            <div class="w-12 h-12 flex items-center justify-center">
                                <!-- Accounting Document with Pie Chart, Bar Chart & Calculator matching Screenshot -->
                                <svg class="w-12 h-12 text-slate-800 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <!-- Document with folded corner -->
                                    <path d="M14 8h24l12 12v36H14z" fill="#ffffff" stroke="#1e293b" stroke-width="2.2"/>
                                    <path d="M38 8v12h12" fill="#e2edfa" stroke="#1e293b" stroke-width="2"/>
                                    <!-- Pie Chart (upper left) -->
                                    <circle cx="25" cy="22" r="6.5" stroke="#1e293b" stroke-width="1.8" fill="#f8fafc"/>
                                    <path d="M25 22l4.5 -4.5M25 22v-6.5" stroke="#1e293b" stroke-width="1.8"/>
                                    <!-- Bar Chart (lower left) -->
                                    <rect x="18" y="44" width="3.5" height="6" fill="#1e293b"/>
                                    <rect x="23" y="40" width="3.5" height="10" fill="#1e293b"/>
                                    <rect x="28" y="36" width="3.5" height="14" fill="#1e293b"/>
                                    <line x1="16" y1="50" x2="33" y2="50" stroke="#1e293b" stroke-width="1.8"/>
                                    <!-- Calculator (right side) -->
                                    <rect x="35" y="24" width="12" height="26" rx="1.5" fill="#ffffff" stroke="#1e293b" stroke-width="1.8"/>
                                    <rect x="37" y="27" width="8" height="5" fill="#e2edfa" stroke="#1e293b" stroke-width="1.2"/>
                                    <rect x="37" y="35" width="2" height="2" fill="#1e293b"/>
                                    <rect x="40" y="35" width="2" height="2" fill="#1e293b"/>
                                    <rect x="43" y="35" width="2" height="2" fill="#1e293b"/>
                                    <rect x="37" y="39" width="2" height="2" fill="#1e293b"/>
                                    <rect x="40" y="39" width="2" height="2" fill="#1e293b"/>
                                    <rect x="43" y="39" width="2" height="2" fill="#1e293b"/>
                                    <rect x="37" y="43" width="3.5" height="3" fill="#1e293b"/>
                                    <rect x="42" y="43" width="3.5" height="3" fill="#1e293b"/>
                                </svg>
                            </div>
                            <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight">
                                <span class="underline decoration-2 underline-offset-2">5</span> Banks
                            </span>
                        </a>

                    </div>

                    <!-- ========================================================= -->
                    <!-- COLUMN 2: Registers & Vouchers (6 Expenses, 7 Amanats, 8 Lotteries, 9 Sales, 0 Purchases) -->
                    <!-- ========================================================= -->
                    <div class="flex flex-col space-y-9 sm:space-y-11 items-center w-full">
                        
                        <!-- 6 Expenses -->
                        <a href="{{ route('expenses.index') }}" 
                           class="group flex flex-col items-center justify-center text-center p-2 rounded-lg hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer border border-transparent" 
                           title="[HotKey: 6] Expenses">
                            <div class="w-12 h-12 flex items-center justify-center">
                                <!-- Accounting Document with Pie Chart, Bar Chart & Calculator -->
                                <svg class="w-12 h-12 text-slate-800 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 8h24l12 12v36H14z" fill="#ffffff" stroke="#1e293b" stroke-width="2.2"/>
                                    <path d="M38 8v12h12" fill="#e2edfa" stroke="#1e293b" stroke-width="2"/>
                                    <circle cx="25" cy="22" r="6.5" stroke="#1e293b" stroke-width="1.8" fill="#f8fafc"/>
                                    <path d="M25 22l4.5 -4.5M25 22v-6.5" stroke="#1e293b" stroke-width="1.8"/>
                                    <rect x="18" y="44" width="3.5" height="6" fill="#1e293b"/>
                                    <rect x="23" y="40" width="3.5" height="10" fill="#1e293b"/>
                                    <rect x="28" y="36" width="3.5" height="14" fill="#1e293b"/>
                                    <line x1="16" y1="50" x2="33" y2="50" stroke="#1e293b" stroke-width="1.8"/>
                                    <rect x="35" y="24" width="12" height="26" rx="1.5" fill="#ffffff" stroke="#1e293b" stroke-width="1.8"/>
                                    <rect x="37" y="27" width="8" height="5" fill="#e2edfa" stroke="#1e293b" stroke-width="1.2"/>
                                    <rect x="37" y="35" width="2" height="2" fill="#1e293b"/>
                                    <rect x="40" y="35" width="2" height="2" fill="#1e293b"/>
                                    <rect x="43" y="35" width="2" height="2" fill="#1e293b"/>
                                    <rect x="37" y="39" width="2" height="2" fill="#1e293b"/>
                                    <rect x="40" y="39" width="2" height="2" fill="#1e293b"/>
                                    <rect x="43" y="39" width="2" height="2" fill="#1e293b"/>
                                    <rect x="37" y="43" width="3.5" height="3" fill="#1e293b"/>
                                    <rect x="42" y="43" width="3.5" height="3" fill="#1e293b"/>
                                </svg>
                            </div>
                            <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight">
                                <span class="underline decoration-2 underline-offset-2">6</span> Expenses
                            </span>
                        </a>

                        <!-- 7 Amanats -->
                        <a href="{{ route('amanats.index') }}" 
                           class="group flex flex-col items-center justify-center text-center p-2 rounded-lg hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer border border-transparent" 
                           title="[HotKey: 7] Amanats">
                            <div class="w-12 h-12 flex items-center justify-center">
                                <!-- Accounting Document with Pie Chart, Bar Chart & Calculator -->
                                <svg class="w-12 h-12 text-slate-800 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 8h24l12 12v36H14z" fill="#ffffff" stroke="#1e293b" stroke-width="2.2"/>
                                    <path d="M38 8v12h12" fill="#e2edfa" stroke="#1e293b" stroke-width="2"/>
                                    <circle cx="25" cy="22" r="6.5" stroke="#1e293b" stroke-width="1.8" fill="#f8fafc"/>
                                    <path d="M25 22l4.5 -4.5M25 22v-6.5" stroke="#1e293b" stroke-width="1.8"/>
                                    <rect x="18" y="44" width="3.5" height="6" fill="#1e293b"/>
                                    <rect x="23" y="40" width="3.5" height="10" fill="#1e293b"/>
                                    <rect x="28" y="36" width="3.5" height="14" fill="#1e293b"/>
                                    <line x1="16" y1="50" x2="33" y2="50" stroke="#1e293b" stroke-width="1.8"/>
                                    <rect x="35" y="24" width="12" height="26" rx="1.5" fill="#ffffff" stroke="#1e293b" stroke-width="1.8"/>
                                    <rect x="37" y="27" width="8" height="5" fill="#e2edfa" stroke="#1e293b" stroke-width="1.2"/>
                                    <rect x="37" y="35" width="2" height="2" fill="#1e293b"/>
                                    <rect x="40" y="35" width="2" height="2" fill="#1e293b"/>
                                    <rect x="43" y="35" width="2" height="2" fill="#1e293b"/>
                                    <rect x="37" y="39" width="2" height="2" fill="#1e293b"/>
                                    <rect x="40" y="39" width="2" height="2" fill="#1e293b"/>
                                    <rect x="43" y="39" width="2" height="2" fill="#1e293b"/>
                                    <rect x="37" y="43" width="3.5" height="3" fill="#1e293b"/>
                                    <rect x="42" y="43" width="3.5" height="3" fill="#1e293b"/>
                                </svg>
                            </div>
                            <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight">
                                <span class="underline decoration-2 underline-offset-2">7</span> Amanats
                            </span>
                        </a>

                        <!-- 8 Lotteries (Shows thin highlight border box as seen in Reference Screenshot) -->
                        <a href="{{ route('payments-to-lotteries.index') }}" 
                           class="group flex flex-col items-center justify-center text-center p-2 rounded-lg bg-sky-50/60 border border-sky-400/80 shadow-sm hover:bg-blue-50/95 hover:border-sky-500 active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer" 
                           title="[HotKey: 8] Lotteries & Schemes">
                            <div class="w-12 h-12 flex items-center justify-center">
                                <!-- Accounting Document with Pie Chart, Bar Chart & Calculator -->
                                <svg class="w-12 h-12 text-slate-800 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 8h24l12 12v36H14z" fill="#ffffff" stroke="#1e293b" stroke-width="2.2"/>
                                    <path d="M38 8v12h12" fill="#e2edfa" stroke="#1e293b" stroke-width="2"/>
                                    <circle cx="25" cy="22" r="6.5" stroke="#1e293b" stroke-width="1.8" fill="#f8fafc"/>
                                    <path d="M25 22l4.5 -4.5M25 22v-6.5" stroke="#1e293b" stroke-width="1.8"/>
                                    <rect x="18" y="44" width="3.5" height="6" fill="#1e293b"/>
                                    <rect x="23" y="40" width="3.5" height="10" fill="#1e293b"/>
                                    <rect x="28" y="36" width="3.5" height="14" fill="#1e293b"/>
                                    <line x1="16" y1="50" x2="33" y2="50" stroke="#1e293b" stroke-width="1.8"/>
                                    <rect x="35" y="24" width="12" height="26" rx="1.5" fill="#ffffff" stroke="#1e293b" stroke-width="1.8"/>
                                    <rect x="37" y="27" width="8" height="5" fill="#e2edfa" stroke="#1e293b" stroke-width="1.2"/>
                                    <rect x="37" y="35" width="2" height="2" fill="#1e293b"/>
                                    <rect x="40" y="35" width="2" height="2" fill="#1e293b"/>
                                    <rect x="43" y="35" width="2" height="2" fill="#1e293b"/>
                                    <rect x="37" y="39" width="2" height="2" fill="#1e293b"/>
                                    <rect x="40" y="39" width="2" height="2" fill="#1e293b"/>
                                    <rect x="43" y="39" width="2" height="2" fill="#1e293b"/>
                                    <rect x="37" y="43" width="3.5" height="3" fill="#1e293b"/>
                                    <rect x="42" y="43" width="3.5" height="3" fill="#1e293b"/>
                                </svg>
                            </div>
                            <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight">
                                <span class="underline decoration-2 underline-offset-2">8</span> Lotteries
                            </span>
                        </a>

                        <!-- 9 Sales -->
                        <a href="{{ route('sales.index') }}" 
                           class="group flex flex-col items-center justify-center text-center p-2 rounded-lg hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer border border-transparent" 
                           title="[HotKey: 9] Sales Invoices">
                            <div class="w-12 h-12 flex items-center justify-center">
                                <!-- Shopping Cart with curved upward arrow matching screenshot -->
                                <svg class="w-12 h-12 text-slate-800 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 16h8l7 24h23l6-18H23" stroke="#1e293b" stroke-width="2.5" fill="none" />
                                    <circle cx="28" cy="47" r="3.5" fill="#1e293b" stroke="#1e293b" />
                                    <circle cx="48" cy="47" r="3.5" fill="#1e293b" stroke="#1e293b" />
                                    <!-- Upward curved arrow inside/above cart -->
                                    <path d="M28 29c5-4 12-4 17-9" stroke="#1e293b" stroke-width="2.8" />
                                    <path d="M39 17h6v6" stroke="#1e293b" stroke-width="2.8" />
                                </svg>
                            </div>
                            <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight">
                                <span class="underline decoration-2 underline-offset-2">9</span> Sales
                            </span>
                        </a>

                        <!-- 0 Purchases -->
                        <a href="{{ route('purchases.index') }}" 
                           class="group flex flex-col items-center justify-center text-center p-2 rounded-lg hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer border border-transparent" 
                           title="[HotKey: 0] Purchases">
                            <div class="w-12 h-12 flex items-center justify-center">
                                <!-- Delivery Box Truck matching screenshot -->
                                <svg class="w-12 h-12 text-slate-800 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="10" y="20" width="28" height="24" rx="2" fill="#ffffff" stroke="#1e293b" stroke-width="2.2" />
                                    <path d="M38 27h9l7 8v9h-16z" fill="#ffffff" stroke="#1e293b" stroke-width="2.2" />
                                    <path d="M40 30h6l4 5h-10z" fill="#f1f5f9" stroke="#1e293b" stroke-width="1.8" />
                                    <circle cx="21" cy="48" r="4.5" fill="#ffffff" stroke="#1e293b" stroke-width="2.5" />
                                    <circle cx="46" cy="48" r="4.5" fill="#ffffff" stroke="#1e293b" stroke-width="2.5" />
                                    <line x1="8" y1="53" x2="56" y2="53" stroke="#1e293b" stroke-width="1.8" />
                                </svg>
                            </div>
                            <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight">
                                <span class="underline decoration-2 underline-offset-2">0</span> Purchases
                            </span>
                        </a>

                    </div>

                    <!-- ========================================================= -->
                    <!-- COLUMN 3: Cash Flow (A Receipts, B Payments) -->
                    <!-- ========================================================= -->
                    <div class="flex flex-col space-y-9 sm:space-y-11 items-center w-full">
                        
                        <!-- A Receipts -->
                        <a href="{{ route('receipts.index') }}" 
                           class="group flex flex-col items-center justify-center text-center p-2 rounded-lg hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer border border-transparent" 
                           title="[HotKey: A] Receipts">
                            <div class="w-12 h-12 flex items-center justify-center">
                                <!-- Banknote / Cash Currency matching screenshot -->
                                <svg class="w-12 h-12 text-slate-800 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="10" y="20" width="44" height="26" rx="2.5" fill="#ffffff" stroke="#1e293b" stroke-width="2.2" />
                                    <rect x="14" y="23.5" width="36" height="19" rx="1.5" stroke="#1e293b" stroke-width="1.4" />
                                    <circle cx="17.5" cy="27" r="1.5" fill="#1e293b" />
                                    <circle cx="46.5" cy="27" r="1.5" fill="#1e293b" />
                                    <circle cx="17.5" cy="39" r="1.5" fill="#1e293b" />
                                    <circle cx="46.5" cy="39" r="1.5" fill="#1e293b" />
                                    <ellipse cx="32" cy="33" rx="7" ry="5.5" stroke="#1e293b" stroke-width="1.8" fill="#f8fafc" />
                                </svg>
                            </div>
                            <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight">
                                <span class="underline decoration-2 underline-offset-2">A</span> Receipts
                            </span>
                        </a>

                        <!-- B Payments -->
                        <a href="{{ route('payments.index') }}" 
                           class="group flex flex-col items-center justify-center text-center p-2 rounded-lg hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer border border-transparent" 
                           title="[HotKey: B] Payments">
                            <div class="w-12 h-12 flex items-center justify-center">
                                <!-- Cash note with outgoing right-facing arrow matching screenshot -->
                                <svg class="w-12 h-12 text-slate-800 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="8" y="20" width="38" height="26" rx="2.5" fill="#ffffff" stroke="#1e293b" stroke-width="2.2" />
                                    <rect x="11.5" y="23.5" width="31" height="19" rx="1.5" stroke="#1e293b" stroke-width="1.4" />
                                    <circle cx="14.5" cy="27" r="1.5" fill="#1e293b" />
                                    <circle cx="39.5" cy="27" r="1.5" fill="#1e293b" />
                                    <ellipse cx="27" cy="33" rx="5.5" ry="4.5" stroke="#1e293b" stroke-width="1.6" fill="#f8fafc" />
                                    <!-- Bold right-pointing outgoing arrow -->
                                    <path d="M34 33h20m0 0l-6-6m6 6l-6 6" stroke="#1e293b" stroke-width="2.8" />
                                </svg>
                            </div>
                            <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight">
                                <span class="underline decoration-2 underline-offset-2">B</span> Payments
                            </span>
                        </a>

                        <!-- Empty space for rows 3, 4, 5 (keeps exact alignment matching screenshot) -->
                        <div class="w-36 h-[96px] hidden md:block"></div>
                        <div class="w-36 h-[96px] hidden md:block"></div>
                        <div class="w-36 h-[96px] hidden md:block"></div>

                    </div>

                    <!-- ========================================================= -->
                    <!-- COLUMN 4: System & Actions Sidebar (Reports, Settings & Others, Change Firm, Exit) -->
                    <!-- ========================================================= -->
                    <div class="flex flex-col space-y-9 sm:space-y-11 items-center w-full">
                        
                        <!-- Reports -->
                        <a href="{{ route('reports.index') }}" 
                           class="group flex flex-col items-center justify-center text-center p-2 rounded-lg hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer border border-transparent" 
                           title="[HotKey: R] Financial & Party Reports">
                            <div class="w-12 h-12 flex items-center justify-center">
                                <!-- Document with horizontal checklist lines matching screenshot -->
                                <svg class="w-12 h-12 text-slate-800 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="16" y="10" width="32" height="44" rx="2" fill="#ffffff" stroke="#1e293b" stroke-width="2.2" />
                                    <!-- Checklist Lines -->
                                    <line x1="22" y1="21" x2="26" y2="21" stroke="#1e293b" stroke-width="2.5" />
                                    <line x1="29" y1="21" x2="42" y2="21" stroke="#1e293b" stroke-width="2" />
                                    <line x1="22" y1="29" x2="26" y2="29" stroke="#1e293b" stroke-width="2.5" />
                                    <line x1="29" y1="29" x2="42" y2="29" stroke="#1e293b" stroke-width="2" />
                                    <line x1="22" y1="37" x2="26" y2="37" stroke="#1e293b" stroke-width="2.5" />
                                    <line x1="29" y1="37" x2="42" y2="37" stroke="#1e293b" stroke-width="2" />
                                    <line x1="22" y1="45" x2="26" y2="45" stroke="#1e293b" stroke-width="2.5" />
                                    <line x1="29" y1="45" x2="38" y2="45" stroke="#1e293b" stroke-width="2" />
                                </svg>
                            </div>
                            <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight">
                                Reports
                            </span>
                        </a>

                        <!-- Settings & Others -->
                        <a href="{{ route('settings.index') }}" 
                           class="group flex flex-col items-center justify-center text-center p-2 rounded-lg hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer border border-transparent" 
                           title="[HotKey: S] System Settings">
                            <div class="w-12 h-12 flex items-center justify-center">
                                <!-- Gear with secondary gear / checkmark badge matching screenshot -->
                                <svg class="w-12 h-12 text-slate-800 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="29" cy="29" r="8" fill="#ffffff" stroke="#1e293b" stroke-width="2.2" />
                                    <path d="M29 14v4M29 40v4M14 29h4M40 29h4M18.4 18.4l2.8 2.8M36.8 36.8l2.8 2.8M18.4 39.6l2.8-2.8M36.8 21.2l2.8-2.8" stroke="#1e293b" stroke-width="3" />
                                    <!-- Secondary gear badge -->
                                    <circle cx="43" cy="43" r="7" fill="#ffffff" stroke="#1e293b" stroke-width="2" />
                                    <path d="M40 43l2.5 2.5 4-4" stroke="#1e293b" stroke-width="2" />
                                </svg>
                            </div>
                            <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight whitespace-nowrap">
                                Settings & Others
                            </span>
                        </a>

                        <!-- Change Firm -->
                        <button type="button" @click="changeFirm()" 
                                class="group flex flex-col items-center justify-center text-center p-2 rounded-lg hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer border border-transparent" 
                                title="Change Firm">
                            <div class="w-12 h-12 flex items-center justify-center">
                                <!-- Document with Pie Chart, Bar Chart & Calculator matching screenshot -->
                                <svg class="w-12 h-12 text-slate-800 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 8h24l12 12v36H14z" fill="#ffffff" stroke="#1e293b" stroke-width="2.2"/>
                                    <path d="M38 8v12h12" fill="#e2edfa" stroke="#1e293b" stroke-width="2"/>
                                    <circle cx="25" cy="22" r="6.5" stroke="#1e293b" stroke-width="1.8" fill="#f8fafc"/>
                                    <path d="M25 22l4.5 -4.5M25 22v-6.5" stroke="#1e293b" stroke-width="1.8"/>
                                    <rect x="18" y="44" width="3.5" height="6" fill="#1e293b"/>
                                    <rect x="23" y="40" width="3.5" height="10" fill="#1e293b"/>
                                    <rect x="28" y="36" width="3.5" height="14" fill="#1e293b"/>
                                    <line x1="16" y1="50" x2="33" y2="50" stroke="#1e293b" stroke-width="1.8"/>
                                    <rect x="35" y="24" width="12" height="26" rx="1.5" fill="#ffffff" stroke="#1e293b" stroke-width="1.8"/>
                                    <rect x="37" y="27" width="8" height="5" fill="#e2edfa" stroke="#1e293b" stroke-width="1.2"/>
                                    <rect x="37" y="35" width="2" height="2" fill="#1e293b"/>
                                    <rect x="40" y="35" width="2" height="2" fill="#1e293b"/>
                                    <rect x="43" y="35" width="2" height="2" fill="#1e293b"/>
                                    <rect x="37" y="39" width="2" height="2" fill="#1e293b"/>
                                    <rect x="40" y="39" width="2" height="2" fill="#1e293b"/>
                                    <rect x="43" y="39" width="2" height="2" fill="#1e293b"/>
                                    <rect x="37" y="43" width="3.5" height="3" fill="#1e293b"/>
                                    <rect x="42" y="43" width="3.5" height="3" fill="#1e293b"/>
                                </svg>
                            </div>
                            <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight">
                                Change Firm
                            </span>
                        </button>

                        <!-- Exit -->
                        <button type="button" @click="confirmExit()" 
                                class="group flex flex-col items-center justify-center text-center p-2 rounded-lg hover:bg-rose-50/90 hover:border-rose-300 hover:shadow-sm active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer border border-transparent" 
                                title="[HotKey: Esc] Exit Session">
                            <div class="w-12 h-12 flex items-center justify-center">
                                <!-- Square Doorway with bold outward arrow matching screenshot -->
                                <svg class="w-12 h-12 text-slate-800 group-hover:text-rose-600 transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M34 14H16v36h18" stroke="#1e293b" stroke-width="2.6" />
                                    <path d="M25 32h25m0 0l-7-7m7 7l-7 7" stroke="#1e293b" stroke-width="2.8" />
                                </svg>
                            </div>
                            <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-rose-600 tracking-tight">
                                Exit
                            </span>
                        </button>

                    </div>

                </div>

                <!-- Bottom Helper Hints & Non-commercial Status matching Screenshot Watermark -->
                <div class="mt-14 pt-4 border-t border-[#d5e2f0] flex flex-col sm:flex-row items-center justify-between text-xs text-slate-600 gap-3 select-none">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="px-2 py-0.5 rounded bg-white border border-[#c6d7e8] font-mono font-bold text-[#0f4c81] text-[11px] shadow-2xs">
                            DIRECT KEY ACCESS
                        </span>
                        <span class="text-slate-600 text-xs">
                            Press hotkeys (<kbd class="px-1.5 py-0.5 bg-white border border-slate-300 rounded font-mono font-bold text-slate-800">1</kbd>-<kbd class="px-1.5 py-0.5 bg-white border border-slate-300 rounded font-mono font-bold text-slate-800">0</kbd>, <kbd class="px-1.5 py-0.5 bg-white border border-slate-300 rounded font-mono font-bold text-slate-800">A</kbd>, <kbd class="px-1.5 py-0.5 bg-white border border-slate-300 rounded font-mono font-bold text-slate-800">B</kbd>, <kbd class="px-1.5 py-0.5 bg-white border border-slate-300 rounded font-mono font-bold text-slate-800">Esc</kbd>) to open instantly
                        </span>
                    </div>
                    <div class="text-[11px] font-mono text-slate-500 font-medium">
                        This is a non-commercial version • DAWN ERP
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Alpine.js Component for Dynamic Behaviors & Keyboard Hotkeys -->
    <script>
        function erpDashboard() {
            return {
                changeFirm() {
                    Swal.fire({
                        title: 'Change Active Firm',
                        html: '<div class="text-left text-xs text-slate-700 space-y-2.5 p-2">' +
                              '<div class="bg-blue-50 border border-blue-200 rounded p-3">' +
                              '<p class="text-[11px] text-blue-600 font-semibold uppercase tracking-wider">Active Organization</p>' +
                              '<p class="font-bold text-slate-900 text-base mt-0.5">DAWN Medical Store & Co.</p>' +
                              '</div>' +
                              '<p><strong>Branch Location:</strong> Umerkot</p>' +
                              '<p><strong>License Terminal:</strong> <span class="font-mono text-slate-600">PK-DAWN-2026-8820</span></p>' +
                              '<p class="text-slate-500 text-[11px] pt-1">Single-firm operational profile is currently active. Additional branch databases can be managed in System Settings.</p>' +
                              '</div>',
                        icon: 'info',
                        confirmButtonColor: '#0f4c81',
                        confirmButtonText: 'OK'
                    });
                },
                confirmExit() {
                    Swal.fire({
                        title: 'Exit DevoAccounts?',
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
                    if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA' || e.target.tagName === 'SELECT') return;
                    const key = e.key.toLowerCase();
                    if (key === '1') window.location.href = '{{ route('parties.index') }}';
                    if (key === '2') window.location.href = '{{ route('medical_reps.index') }}';
                    if (key === '3') window.location.href = '{{ route('companies.index') }}';
                    if (key === '4') window.location.href = '{{ route('salesmen.index') }}';
                    if (key === '5') window.location.href = '{{ route('banks.index') }}';
                    if (key === '6') window.location.href = '{{ route('expenses.index') }}';
                    if (key === '7') window.location.href = '{{ route('amanats.index') }}';
                    if (key === '8') window.location.href = '{{ route('payments-to-lotteries.index') }}';
                    if (key === '9') window.location.href = '{{ route('sales.index') }}';
                    if (key === '0') window.location.href = '{{ route('purchases.index') }}';
                    if (key === 'a') window.location.href = '{{ route('receipts.index') }}';
                    if (key === 'b') window.location.href = '{{ route('payments.index') }}';
                    if (key === 'r') window.location.href = '{{ route('reports.index') }}';
                    if (key === 's') window.location.href = '{{ route('settings.index') }}';
                    if (key === 'escape') this.confirmExit();
                }
            };
        }
    </script>
</x-app-layout>
