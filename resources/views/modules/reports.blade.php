<x-app-layout>
    <div class="py-5 px-3 sm:px-6 lg:px-8 font-sans" 
         x-data="reportsMenu({ 
             activeReport: '{{ request('report', (request('party_id') || request('from_date')) ? 'parties' : '') }}',
             focusedItem: 'parties'
         })" 
         @keydown.window="handleKey($event)">

        <div class="max-w-[1360px] mx-auto space-y-4">
            
            <!-- MAIN CANVAS: Exact Visual Clone of Reports Reference Screenshot -->
            <div class="bg-[#f0f4f9] rounded-xl border border-[#c6d7e8] shadow-md p-6 sm:p-10 lg:p-12 flex flex-col justify-between min-h-[640px]">
                
                <div>
                    <!-- Subheader Ribbon Banner: Document Checklist Icon + Bold "Reports" Title -->
                    <div class="bg-gradient-to-r from-[#0c2f55] via-[#0f4c81] to-[#144b84] rounded-lg p-3 sm:px-5 sm:py-3.5 shadow-sm border border-[#0a2747] flex items-center justify-between mb-8 select-none">
                        <div class="flex items-center gap-3">
                            <!-- Document Checklist Icon matching Screenshot -->
                            <div class="w-9 h-9 rounded bg-white/10 border border-white/20 flex items-center justify-center p-1 shrink-0">
                                <svg class="w-7 h-7 text-sky-200" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <!-- Document page with folded top-right corner -->
                                    <path d="M12 6h16l10 10v26a2 2 0 0 1-2 2H12a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2z" stroke="currentColor" stroke-width="2.5" fill="none" />
                                    <path d="M28 6v10h10" stroke="currentColor" stroke-width="2.5" />
                                    <!-- Checklist bullet lines -->
                                    <line x1="16" y1="22" x2="32" y2="22" stroke="currentColor" stroke-width="2.2" />
                                    <line x1="16" y1="29" x2="32" y2="29" stroke="currentColor" stroke-width="2.2" />
                                    <line x1="16" y1="36" x2="26" y2="36" stroke="currentColor" stroke-width="2.2" />
                                </svg>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-black text-white tracking-tight">Reports</h1>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded bg-white/15 hover:bg-white/25 text-white border border-white/30 transition-all" title="Return to Main Menu [Esc]">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                                <span>Main Menu</span>
                            </a>
                        </div>
                    </div>

                    <!-- 3-Column Desktop Grid matching Reference Screenshot Exact Layout & Horizontal Alignment -->
                    <!-- Row 1: 1 Parties      | 6 Expenses   | A Receipts -->
                    <!-- Row 2: 2 Medical Reps | 7 Amanats    | B Payments -->
                    <!-- Row 3: 3 Companies    | 8 Lotteries  | C Cash & Others -->
                    <!-- Row 4: 4 Salesmen     | 9 Sales      | [empty] -->
                    <!-- Row 5: 5 Banks        | 0 Purchases  | [empty] -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-y-9 sm:gap-y-11 gap-x-8 sm:gap-x-14 lg:gap-x-20 max-w-2xl items-start">
                        
                        <!-- ========================================== -->
                        <!-- ROW 1 -->
                        <!-- ========================================== -->
                        <!-- 1 Parties (Selected Card Box style matching Reference Screenshot) -->
                        <div class="flex justify-center sm:justify-start">
                            <button type="button"
                                    @click="openReport('parties')"
                                    :class="focusedItem === 'parties' ? 'border-2 border-[#0092d0] bg-sky-50/80 shadow-sm' : 'border border-transparent hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm'"
                                    class="group flex flex-col items-center justify-center text-center p-2 rounded-lg active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer" 
                                    title="[HotKey: 1] Parties Ledger & Statement">
                                <div class="w-12 h-12 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-800 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="32" cy="32" r="10.5" fill="#e2edfa" stroke="#1e293b" stroke-width="2.2" />
                                        <circle cx="32" cy="27" r="3.2" fill="#1e293b" />
                                        <path d="M26 38c0-3.2 2.7-5.2 6-5.2s6 2 6 5.2" fill="#1e293b" />
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
                            </button>
                        </div>

                        <!-- 6 Expenses -->
                        <div class="flex justify-center sm:justify-start">
                            <button type="button"
                                    @click="openReport('expenses')"
                                    :class="focusedItem === 'expenses' ? 'border-2 border-[#0092d0] bg-sky-50/80 shadow-sm' : 'border border-transparent hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm'"
                                    class="group flex flex-col items-center justify-center text-center p-2 rounded-lg active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer" 
                                    title="[HotKey: 6] Expenses Summary">
                                <div class="w-12 h-12 flex items-center justify-center">
                                    <!-- Accounting Document with Pie Chart, Bar Chart & Calculator -->
                                    <svg class="w-12 h-12 text-slate-800 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        <!-- Paper sheet -->
                                        <rect x="8" y="8" width="30" height="48" rx="2" fill="#ffffff" stroke="#1e293b" stroke-width="2.2" />
                                        <!-- Pie Chart on top left -->
                                        <circle cx="21" cy="20" r="7" stroke="#1e293b" stroke-width="1.8" fill="#e2edfa" />
                                        <path d="M21 20L21 13A7 7 0 0 1 28 20Z" fill="#1e293b" />
                                        <!-- Bar Chart below pie -->
                                        <rect x="13" y="42" width="3.5" height="8" fill="#1e293b" />
                                        <rect x="18" y="38" width="3.5" height="12" fill="#1e293b" />
                                        <rect x="23" y="34" width="3.5" height="16" fill="#1e293b" />
                                        <!-- Calculator on the right -->
                                        <rect x="34" y="16" width="22" height="34" rx="2" fill="#ffffff" stroke="#1e293b" stroke-width="2.2" />
                                        <rect x="37.5" y="20" width="15" height="6.5" rx="1" fill="#e2edfa" stroke="#1e293b" stroke-width="1.4" />
                                        <!-- Calculator buttons 2x3 -->
                                        <rect x="38" y="30" width="4" height="3.5" rx="0.5" fill="#1e293b" />
                                        <rect x="44.5" y="30" width="4" height="3.5" rx="0.5" fill="#1e293b" />
                                        <rect x="38" y="36" width="4" height="3.5" rx="0.5" fill="#1e293b" />
                                        <rect x="44.5" y="36" width="4" height="3.5" rx="0.5" fill="#1e293b" />
                                        <rect x="38" y="42" width="4" height="3.5" rx="0.5" fill="#1e293b" />
                                        <rect x="44.5" y="42" width="4" height="3.5" rx="0.5" fill="#1e293b" />
                                    </svg>
                                </div>
                                <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight">
                                    <span class="underline decoration-2 underline-offset-2">6</span> Expenses
                                </span>
                            </button>
                        </div>

                        <!-- A Receipts -->
                        <div class="flex justify-center sm:justify-start">
                            <button type="button"
                                    @click="openReport('receipts')"
                                    :class="focusedItem === 'receipts' ? 'border-2 border-[#0092d0] bg-sky-50/80 shadow-sm' : 'border border-transparent hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm'"
                                    class="group flex flex-col items-center justify-center text-center p-2 rounded-lg active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer" 
                                    title="[HotKey: A] Receipts Register">
                                <div class="w-12 h-12 flex items-center justify-center">
                                    <!-- Banknote Cash Icon matching Screenshot -->
                                    <svg class="w-12 h-12 text-slate-800 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="8" y="18" width="48" height="28" rx="2.5" fill="#ffffff" stroke="#1e293b" stroke-width="2.2" />
                                        <rect x="12" y="21.5" width="40" height="21" rx="1.5" stroke="#1e293b" stroke-width="1.5" />
                                        <circle cx="16" cy="25.5" r="1.5" fill="#1e293b" />
                                        <circle cx="48" cy="25.5" r="1.5" fill="#1e293b" />
                                        <circle cx="16" cy="38.5" r="1.5" fill="#1e293b" />
                                        <circle cx="48" cy="38.5" r="1.5" fill="#1e293b" />
                                        <ellipse cx="32" cy="32" rx="7.5" ry="6" fill="#e2edfa" stroke="#1e293b" stroke-width="1.8" />
                                    </svg>
                                </div>
                                <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight">
                                    <span class="underline decoration-2 underline-offset-2">A</span> Receipts
                                </span>
                            </button>
                        </div>

                        <!-- ========================================== -->
                        <!-- ROW 2 -->
                        <!-- ========================================== -->
                        <!-- 2 Medical Reps -->
                        <div class="flex justify-center sm:justify-start">
                            <button type="button"
                                    @click="openReport('medical_reps')"
                                    :class="focusedItem === 'medical_reps' ? 'border-2 border-[#0092d0] bg-sky-50/80 shadow-sm' : 'border border-transparent hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm'"
                                    class="group flex flex-col items-center justify-center text-center p-2 rounded-lg active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer" 
                                    title="[HotKey: 2] Medical Representatives Statement">
                                <div class="w-12 h-12 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-900 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64">
                                        <circle cx="32" cy="18" r="9" fill="#1e293b" />
                                        <path d="M14 50c0-9 8-15 18-15s18 6 18 15v4H14v-4z" fill="#1e293b" />
                                        <polygon points="32,35 25,43 28,45 32,39 36,45 39,43" fill="#ffffff" />
                                        <polygon points="32,39 34,43 33,52 32,54 31,52 30,43" fill="#0f172a" />
                                    </svg>
                                </div>
                                <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight whitespace-nowrap">
                                    <span class="underline decoration-2 underline-offset-2">2</span> Medical Reps
                                </span>
                            </button>
                        </div>

                        <!-- 7 Amanats -->
                        <div class="flex justify-center sm:justify-start">
                            <button type="button"
                                    @click="openReport('amanats')"
                                    :class="focusedItem === 'amanats' ? 'border-2 border-[#0092d0] bg-sky-50/80 shadow-sm' : 'border border-transparent hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm'"
                                    class="group flex flex-col items-center justify-center text-center p-2 rounded-lg active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer" 
                                    title="[HotKey: 7] Amanats Ledger">
                                <div class="w-12 h-12 flex items-center justify-center">
                                    <!-- Accounting Document with Pie Chart, Bar Chart & Calculator -->
                                    <svg class="w-12 h-12 text-slate-800 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="8" y="8" width="30" height="48" rx="2" fill="#ffffff" stroke="#1e293b" stroke-width="2.2" />
                                        <circle cx="21" cy="20" r="7" stroke="#1e293b" stroke-width="1.8" fill="#e2edfa" />
                                        <path d="M21 20L21 13A7 7 0 0 1 28 20Z" fill="#1e293b" />
                                        <rect x="13" y="42" width="3.5" height="8" fill="#1e293b" />
                                        <rect x="18" y="38" width="3.5" height="12" fill="#1e293b" />
                                        <rect x="23" y="34" width="3.5" height="16" fill="#1e293b" />
                                        <rect x="34" y="16" width="22" height="34" rx="2" fill="#ffffff" stroke="#1e293b" stroke-width="2.2" />
                                        <rect x="37.5" y="20" width="15" height="6.5" rx="1" fill="#e2edfa" stroke="#1e293b" stroke-width="1.4" />
                                        <rect x="38" y="30" width="4" height="3.5" rx="0.5" fill="#1e293b" />
                                        <rect x="44.5" y="30" width="4" height="3.5" rx="0.5" fill="#1e293b" />
                                        <rect x="38" y="36" width="4" height="3.5" rx="0.5" fill="#1e293b" />
                                        <rect x="44.5" y="36" width="4" height="3.5" rx="0.5" fill="#1e293b" />
                                        <rect x="38" y="42" width="4" height="3.5" rx="0.5" fill="#1e293b" />
                                        <rect x="44.5" y="42" width="4" height="3.5" rx="0.5" fill="#1e293b" />
                                    </svg>
                                </div>
                                <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight">
                                    <span class="underline decoration-2 underline-offset-2">7</span> Amanats
                                </span>
                            </button>
                        </div>

                        <!-- B Payments -->
                        <div class="flex justify-center sm:justify-start">
                            <button type="button"
                                    @click="openReport('payments')"
                                    :class="focusedItem === 'payments' ? 'border-2 border-[#0092d0] bg-sky-50/80 shadow-sm' : 'border border-transparent hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm'"
                                    class="group flex flex-col items-center justify-center text-center p-2 rounded-lg active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer" 
                                    title="[HotKey: B] Payments Register">
                                <div class="w-12 h-12 flex items-center justify-center">
                                    <!-- Banknote with Outgoing Right Arrow Icon matching Screenshot -->
                                    <svg class="w-12 h-12 text-slate-800 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="6" y="18" width="36" height="28" rx="2.5" fill="#ffffff" stroke="#1e293b" stroke-width="2.2" />
                                        <rect x="9.5" y="21.5" width="29" height="21" rx="1.5" stroke="#1e293b" stroke-width="1.5" />
                                        <circle cx="13" cy="25.5" r="1.5" fill="#1e293b" />
                                        <circle cx="35" cy="25.5" r="1.5" fill="#1e293b" />
                                        <circle cx="13" cy="38.5" r="1.5" fill="#1e293b" />
                                        <circle cx="35" cy="38.5" r="1.5" fill="#1e293b" />
                                        <ellipse cx="24" cy="32" rx="6" ry="5" fill="#e2edfa" stroke="#1e293b" stroke-width="1.8" />
                                        <!-- Bold Outgoing Arrow to the right -->
                                        <path d="M36 32h22m0 0l-7-7m7 7l-7 7" stroke="#1e293b" stroke-width="3" />
                                    </svg>
                                </div>
                                <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight">
                                    <span class="underline decoration-2 underline-offset-2">B</span> Payments
                                </span>
                            </button>
                        </div>

                        <!-- ========================================== -->
                        <!-- ROW 3 -->
                        <!-- ========================================== -->
                        <!-- 3 Companies -->
                        <div class="flex justify-center sm:justify-start">
                            <button type="button"
                                    @click="openReport('companies')"
                                    :class="focusedItem === 'companies' ? 'border-2 border-[#0092d0] bg-sky-50/80 shadow-sm' : 'border border-transparent hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm'"
                                    class="group flex flex-col items-center justify-center text-center p-2 rounded-lg active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer" 
                                    title="[HotKey: 3] Companies Statement">
                                <div class="w-12 h-12 flex items-center justify-center">
                                    <!-- Office Skyscraper with 12 Windows matching Screenshot -->
                                    <svg class="w-12 h-12 text-slate-800 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="18" y="10" width="28" height="46" rx="1.5" fill="#ffffff" stroke="#1e293b" stroke-width="2.2" />
                                        <!-- Row 1 Windows -->
                                        <rect x="23" y="16" width="4.5" height="4.5" fill="#1e293b" />
                                        <rect x="30" y="16" width="4.5" height="4.5" fill="#1e293b" />
                                        <rect x="37" y="16" width="4.5" height="4.5" fill="#1e293b" />
                                        <!-- Row 2 Windows -->
                                        <rect x="23" y="24" width="4.5" height="4.5" fill="#1e293b" />
                                        <rect x="30" y="24" width="4.5" height="4.5" fill="#1e293b" />
                                        <rect x="37" y="24" width="4.5" height="4.5" fill="#1e293b" />
                                        <!-- Row 3 Windows -->
                                        <rect x="23" y="32" width="4.5" height="4.5" fill="#1e293b" />
                                        <rect x="30" y="32" width="4.5" height="4.5" fill="#1e293b" />
                                        <rect x="37" y="32" width="4.5" height="4.5" fill="#1e293b" />
                                        <!-- Row 4 Windows -->
                                        <rect x="23" y="40" width="4.5" height="4.5" fill="#1e293b" />
                                        <rect x="30" y="40" width="4.5" height="4.5" fill="#1e293b" />
                                        <rect x="37" y="40" width="4.5" height="4.5" fill="#1e293b" />
                                        <!-- Door at bottom -->
                                        <rect x="29" y="48" width="6" height="8" fill="#e2edfa" stroke="#1e293b" stroke-width="1.5" />
                                    </svg>
                                </div>
                                <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight">
                                    <span class="underline decoration-2 underline-offset-2">3</span> Companies
                                </span>
                            </button>
                        </div>

                        <!-- 8 Lotteries -->
                        <div class="flex justify-center sm:justify-start">
                            <button type="button"
                                    @click="openReport('lotteries')"
                                    :class="focusedItem === 'lotteries' ? 'border-2 border-[#0092d0] bg-sky-50/80 shadow-sm' : 'border border-transparent hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm'"
                                    class="group flex flex-col items-center justify-center text-center p-2 rounded-lg active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer" 
                                    title="[HotKey: 8] Lotteries Register">
                                <div class="w-12 h-12 flex items-center justify-center">
                                    <!-- Accounting Document with Pie Chart, Bar Chart & Calculator -->
                                    <svg class="w-12 h-12 text-slate-800 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="8" y="8" width="30" height="48" rx="2" fill="#ffffff" stroke="#1e293b" stroke-width="2.2" />
                                        <circle cx="21" cy="20" r="7" stroke="#1e293b" stroke-width="1.8" fill="#e2edfa" />
                                        <path d="M21 20L21 13A7 7 0 0 1 28 20Z" fill="#1e293b" />
                                        <rect x="13" y="42" width="3.5" height="8" fill="#1e293b" />
                                        <rect x="18" y="38" width="3.5" height="12" fill="#1e293b" />
                                        <rect x="23" y="34" width="3.5" height="16" fill="#1e293b" />
                                        <rect x="34" y="16" width="22" height="34" rx="2" fill="#ffffff" stroke="#1e293b" stroke-width="2.2" />
                                        <rect x="37.5" y="20" width="15" height="6.5" rx="1" fill="#e2edfa" stroke="#1e293b" stroke-width="1.4" />
                                        <rect x="38" y="30" width="4" height="3.5" rx="0.5" fill="#1e293b" />
                                        <rect x="44.5" y="30" width="4" height="3.5" rx="0.5" fill="#1e293b" />
                                        <rect x="38" y="36" width="4" height="3.5" rx="0.5" fill="#1e293b" />
                                        <rect x="44.5" y="36" width="4" height="3.5" rx="0.5" fill="#1e293b" />
                                        <rect x="38" y="42" width="4" height="3.5" rx="0.5" fill="#1e293b" />
                                        <rect x="44.5" y="42" width="4" height="3.5" rx="0.5" fill="#1e293b" />
                                    </svg>
                                </div>
                                <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight">
                                    <span class="underline decoration-2 underline-offset-2">8</span> Lotteries
                                </span>
                            </button>
                        </div>

                        <!-- C Cash & Others -->
                        <div class="flex justify-center sm:justify-start">
                            <button type="button"
                                    @click="openReport('cash')"
                                    :class="focusedItem === 'cash' ? 'border-2 border-[#0092d0] bg-sky-50/80 shadow-sm' : 'border border-transparent hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm'"
                                    class="group flex flex-col items-center justify-center text-center p-2 rounded-lg active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer" 
                                    title="[HotKey: C] Daily Cash Book & Matrix">
                                <div class="w-12 h-12 flex items-center justify-center">
                                    <!-- Banknote Cash Icon matching Screenshot -->
                                    <svg class="w-12 h-12 text-slate-800 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="8" y="18" width="48" height="28" rx="2.5" fill="#ffffff" stroke="#1e293b" stroke-width="2.2" />
                                        <rect x="12" y="21.5" width="40" height="21" rx="1.5" stroke="#1e293b" stroke-width="1.5" />
                                        <circle cx="16" cy="25.5" r="1.5" fill="#1e293b" />
                                        <circle cx="48" cy="25.5" r="1.5" fill="#1e293b" />
                                        <circle cx="16" cy="38.5" r="1.5" fill="#1e293b" />
                                        <circle cx="48" cy="38.5" r="1.5" fill="#1e293b" />
                                        <ellipse cx="32" cy="32" rx="7.5" ry="6" fill="#e2edfa" stroke="#1e293b" stroke-width="1.8" />
                                    </svg>
                                </div>
                                <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight whitespace-nowrap">
                                    <span class="underline decoration-2 underline-offset-2">C</span> Cash &amp; Others
                                </span>
                            </button>
                        </div>

                        <!-- ========================================== -->
                        <!-- ROW 4 -->
                        <!-- ========================================== -->
                        <!-- 4 Salesmen -->
                        <div class="flex justify-center sm:justify-start">
                            <button type="button"
                                    @click="openReport('salesmen')"
                                    :class="focusedItem === 'salesmen' ? 'border-2 border-[#0092d0] bg-sky-50/80 shadow-sm' : 'border border-transparent hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm'"
                                    class="group flex flex-col items-center justify-center text-center p-2 rounded-lg active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer" 
                                    title="[HotKey: 4] Salesmen Statement">
                                <div class="w-12 h-12 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-900 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64">
                                        <circle cx="32" cy="18" r="9" fill="#1e293b" />
                                        <path d="M14 50c0-9 8-15 18-15s18 6 18 15v4H14v-4z" fill="#1e293b" />
                                        <polygon points="32,35 25,43 28,45 32,39 36,45 39,43" fill="#ffffff" />
                                        <polygon points="32,39 34,43 33,52 32,54 31,52 30,43" fill="#0f172a" />
                                    </svg>
                                </div>
                                <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight">
                                    <span class="underline decoration-2 underline-offset-2">4</span> Salesmen
                                </span>
                            </button>
                        </div>

                        <!-- 9 Sales -->
                        <div class="flex justify-center sm:justify-start">
                            <button type="button"
                                    @click="openReport('sales')"
                                    :class="focusedItem === 'sales' ? 'border-2 border-[#0092d0] bg-sky-50/80 shadow-sm' : 'border border-transparent hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm'"
                                    class="group flex flex-col items-center justify-center text-center p-2 rounded-lg active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer" 
                                    title="[HotKey: 9] Sales Register">
                                <div class="w-12 h-12 flex items-center justify-center">
                                    <!-- Shopping Cart with Upward Curve Arrow matching Screenshot -->
                                    <svg class="w-12 h-12 text-slate-800 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        <!-- Cart handle and body -->
                                        <path d="M12 16h8l6 24h24l5-16H24" stroke="#1e293b" stroke-width="2.5" fill="#ffffff" />
                                        <!-- Wheels -->
                                        <circle cx="28" cy="46" r="3.5" fill="#1e293b" />
                                        <circle cx="48" cy="46" r="3.5" fill="#1e293b" />
                                        <!-- Upward Arrow inside/above cart -->
                                        <path d="M28 28c6-6 14-8 20-3m0 0l-5-1m5 1l-1 5" stroke="#1e293b" stroke-width="2.8" />
                                    </svg>
                                </div>
                                <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight">
                                    <span class="underline decoration-2 underline-offset-2">9</span> Sales
                                </span>
                            </button>
                        </div>

                        <!-- Empty cell in Row 4, Column 3 matching Screenshot -->
                        <div class="hidden sm:block"></div>

                        <!-- ========================================== -->
                        <!-- ROW 5 -->
                        <!-- ========================================== -->
                        <!-- 5 Banks -->
                        <div class="flex justify-center sm:justify-start">
                            <button type="button"
                                    @click="openReport('banks')"
                                    :class="focusedItem === 'banks' ? 'border-2 border-[#0092d0] bg-sky-50/80 shadow-sm' : 'border border-transparent hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm'"
                                    class="group flex flex-col items-center justify-center text-center p-2 rounded-lg active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer" 
                                    title="[HotKey: 5] Bank Accounts Ledger">
                                <div class="w-12 h-12 flex items-center justify-center">
                                    <!-- Accounting Document with Pie Chart, Bar Chart & Calculator -->
                                    <svg class="w-12 h-12 text-slate-800 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="8" y="8" width="30" height="48" rx="2" fill="#ffffff" stroke="#1e293b" stroke-width="2.2" />
                                        <circle cx="21" cy="20" r="7" stroke="#1e293b" stroke-width="1.8" fill="#e2edfa" />
                                        <path d="M21 20L21 13A7 7 0 0 1 28 20Z" fill="#1e293b" />
                                        <rect x="13" y="42" width="3.5" height="8" fill="#1e293b" />
                                        <rect x="18" y="38" width="3.5" height="12" fill="#1e293b" />
                                        <rect x="23" y="34" width="3.5" height="16" fill="#1e293b" />
                                        <rect x="34" y="16" width="22" height="34" rx="2" fill="#ffffff" stroke="#1e293b" stroke-width="2.2" />
                                        <rect x="37.5" y="20" width="15" height="6.5" rx="1" fill="#e2edfa" stroke="#1e293b" stroke-width="1.4" />
                                        <rect x="38" y="30" width="4" height="3.5" rx="0.5" fill="#1e293b" />
                                        <rect x="44.5" y="30" width="4" height="3.5" rx="0.5" fill="#1e293b" />
                                        <rect x="38" y="36" width="4" height="3.5" rx="0.5" fill="#1e293b" />
                                        <rect x="44.5" y="36" width="4" height="3.5" rx="0.5" fill="#1e293b" />
                                        <rect x="38" y="42" width="4" height="3.5" rx="0.5" fill="#1e293b" />
                                        <rect x="44.5" y="42" width="4" height="3.5" rx="0.5" fill="#1e293b" />
                                    </svg>
                                </div>
                                <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight">
                                    <span class="underline decoration-2 underline-offset-2">5</span> Banks
                                </span>
                            </button>
                        </div>

                        <!-- 0 Purchases -->
                        <div class="flex justify-center sm:justify-start">
                            <button type="button"
                                    @click="openReport('purchases')"
                                    :class="focusedItem === 'purchases' ? 'border-2 border-[#0092d0] bg-sky-50/80 shadow-sm' : 'border border-transparent hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm'"
                                    class="group flex flex-col items-center justify-center text-center p-2 rounded-lg active:scale-95 transition-all select-none w-36 h-[96px] cursor-pointer" 
                                    title="[HotKey: 0] Purchases Register">
                                <div class="w-12 h-12 flex items-center justify-center">
                                    <!-- Delivery Truck matching Screenshot -->
                                    <svg class="w-12 h-12 text-slate-800 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        <!-- Cargo box on left -->
                                        <rect x="10" y="18" width="28" height="24" rx="1.5" fill="#ffffff" stroke="#1e293b" stroke-width="2.2" />
                                        <line x1="34" y1="18" x2="34" y2="42" stroke="#1e293b" stroke-width="1.2" />
                                        <!-- Cab on right -->
                                        <path d="M38 24h10l6 8v10h-16v-18z" fill="#ffffff" stroke="#1e293b" stroke-width="2.2" />
                                        <polygon points="40,28 47,28 51,34 40,34" fill="#e2edfa" stroke="#1e293b" stroke-width="1.4" />
                                        <!-- Wheels -->
                                        <circle cx="20" cy="44" r="4.5" fill="#1e293b" />
                                        <circle cx="20" cy="44" r="1.5" fill="#ffffff" />
                                        <circle cx="48" cy="44" r="4.5" fill="#1e293b" />
                                        <circle cx="48" cy="44" r="1.5" fill="#ffffff" />
                                    </svg>
                                </div>
                                <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight">
                                    <span class="underline decoration-2 underline-offset-2">0</span> Purchases
                                </span>
                            </button>
                        </div>

                        <!-- Empty cell in Row 5, Column 3 matching Screenshot -->
                        <div class="hidden sm:block"></div>

                    </div>
                </div>

                <!-- Footer Status Bar -->
                <div class="mt-8 pt-4 border-t border-[#cbd8e4] flex flex-col sm:flex-row items-center justify-between text-xs text-slate-600 font-sans gap-2 select-none">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center gap-1 font-bold text-slate-800">
                            <kbd class="px-2 py-0.5 rounded bg-white border border-slate-300 shadow-xs font-mono text-[11px]">1 - 0</kbd>
                            <kbd class="px-2 py-0.5 rounded bg-white border border-slate-300 shadow-xs font-mono text-[11px]">A - C</kbd>
                            <span>Open Report</span>
                        </span>
                        <span class="text-slate-300">|</span>
                        <span class="inline-flex items-center gap-1">
                            <kbd class="px-1.5 py-0.5 rounded bg-white border border-slate-300 shadow-xs font-mono text-[11px]">Esc</kbd>
                            <span>Main Menu</span>
                        </span>
                    </div>
                    <div class="font-medium text-slate-500">
                        DevoAccounts 2.0 • Licensed to DAWN
                    </div>
                </div>

            </div>

        </div>

        <!-- ========================================================================= -->
        <!-- REPORT DIALOG / MODAL (Opens for any selected report to provide full data) -->
        <!-- ========================================================================= -->
        <div x-show="activeReport !== ''" 
             x-cloak 
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-3 sm:p-6"
             @click.self="closeReport()">
            
            <div class="bg-white rounded-xl shadow-2xl border-2 border-[#0092d0] w-full max-w-5xl max-h-[92vh] flex flex-col overflow-hidden font-sans animate-in fade-in zoom-in duration-150">
                
                <!-- Modal Header Ribbon -->
                <div class="bg-gradient-to-r from-[#0c2f55] via-[#0f4c81] to-[#144b84] px-5 py-3.5 flex items-center justify-between text-white shrink-0 border-b border-[#0a2747]">
                    <div class="flex items-center gap-2.5">
                        <span class="text-lg">📊</span>
                        <h2 class="text-base sm:text-lg font-black tracking-tight" x-text="getReportTitle()"></h2>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="window.print()" class="px-2.5 py-1 rounded bg-white/20 hover:bg-white/30 text-white text-xs font-bold flex items-center gap-1.5 transition-all" title="Print this Report">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            <span>Print</span>
                        </button>
                        <button type="button" @click="closeReport()" class="p-1 rounded hover:bg-white/20 text-white/80 hover:text-white transition-all text-sm font-bold">
                            ✕
                        </button>
                    </div>
                </div>

                <!-- Modal Body (Dynamic per selected report) -->
                <div class="p-5 overflow-y-auto space-y-4 text-slate-800 text-sm">
                    
                    <!-- 1. PARTIES REPORT (Ledger Statement, Balance & Filters) -->
                    <template x-if="activeReport === 'parties'">
                        <div class="space-y-4">
                            <!-- Filter Bar -->
                            <form method="GET" action="{{ route('reports.index') }}" class="bg-[#f0f4f9] p-3 rounded-lg border border-[#cbd8e4] grid grid-cols-1 sm:grid-cols-4 gap-3 items-end">
                                <input type="hidden" name="report" value="parties">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">From Date</label>
                                    <input type="date" name="from_date" value="{{ $fromDate }}" class="w-full px-2.5 py-1 text-xs rounded border border-slate-300 font-mono">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">To Date</label>
                                    <input type="date" name="to_date" value="{{ $toDate }}" class="w-full px-2.5 py-1 text-xs rounded border border-slate-300 font-mono">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Select Party</label>
                                    <select name="party_id" class="w-full px-2.5 py-1 text-xs rounded border border-slate-300">
                                        <option value="">-- All Parties Summary --</option>
                                        @foreach($parties as $p)
                                            <option value="{{ $p->id }}" {{ $selectedPartyId == $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ ucfirst($p->type) }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex gap-2">
                                    <button type="submit" class="flex-1 py-1 px-3 rounded bg-[#0f4c81] hover:bg-[#0c2f55] text-white text-xs font-bold transition-all">Filter</button>
                                    <a href="{{ route('reports.index', ['report' => 'parties']) }}" class="py-1 px-3 rounded bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold text-center">Reset</a>
                                </div>
                            </form>

                            <!-- Party Ledger Table if Party Selected -->
                            @if($selectedParty)
                                <div class="bg-blue-50/50 p-3 rounded-lg border border-sky-200 flex justify-between items-center">
                                    <div>
                                        <h3 class="font-bold text-base text-[#0f4c81]">{{ $selectedParty->name }}</h3>
                                        <p class="text-xs text-slate-600">Code: {{ $selectedParty->code ?? 'N/A' }} | Phone: {{ $selectedParty->phone ?? 'N/A' }} | Type: {{ ucfirst($selectedParty->type) }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs font-bold text-slate-600">Current Balance</span>
                                        <div class="text-lg font-black font-mono {{ $selectedParty->current_balance > 0 ? 'text-emerald-700' : 'text-slate-800' }}">
                                            Rs. {{ number_format($selectedParty->current_balance, 2) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="overflow-x-auto border border-slate-200 rounded-lg">
                                    <table class="w-full text-left text-xs border-collapse">
                                        <thead class="bg-[#0f4c81] text-white font-bold uppercase text-[10px] tracking-wider">
                                            <tr>
                                                <th class="p-2.5">Date</th>
                                                <th class="p-2.5">Type</th>
                                                <th class="p-2.5">Reference #</th>
                                                <th class="p-2.5">Description</th>
                                                <th class="p-2.5 text-right">Debit (Rs.)</th>
                                                <th class="p-2.5 text-right">Credit (Rs.)</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-200">
                                            @forelse($ledgerEntries as $entry)
                                                <tr class="hover:bg-slate-50">
                                                    <td class="p-2.5 font-mono">{{ $entry['date'] }}</td>
                                                    <td class="p-2.5 font-semibold text-slate-700">{{ $entry['type'] }}</td>
                                                    <td class="p-2.5 font-mono text-sky-800 font-bold">{{ $entry['ref'] }}</td>
                                                    <td class="p-2.5 text-slate-600">{{ $entry['description'] }}</td>
                                                    <td class="p-2.5 text-right font-mono font-bold text-rose-700">{{ $entry['debit'] > 0 ? number_format($entry['debit'], 2) : '-' }}</td>
                                                    <td class="p-2.5 text-right font-mono font-bold text-emerald-700">{{ $entry['credit'] > 0 ? number_format($entry['credit'], 2) : '-' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="p-4 text-center text-slate-500">No transactions recorded for this party within selected period.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <!-- All Parties Balances Summary -->
                                <div class="overflow-x-auto border border-slate-200 rounded-lg">
                                    <table class="w-full text-left text-xs border-collapse">
                                        <thead class="bg-[#0f4c81] text-white font-bold uppercase text-[10px] tracking-wider">
                                            <tr>
                                                <th class="p-2.5">Code</th>
                                                <th class="p-2.5">Party Name</th>
                                                <th class="p-2.5">Type</th>
                                                <th class="p-2.5">Phone</th>
                                                <th class="p-2.5 text-right">Credit Limit</th>
                                                <th class="p-2.5 text-right">Current Balance (Rs.)</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-200">
                                            @foreach($parties as $p)
                                                <tr class="hover:bg-slate-50">
                                                    <td class="p-2.5 font-mono text-slate-600">{{ $p->code ?? '-' }}</td>
                                                    <td class="p-2.5 font-bold text-[#0f4c81]">{{ $p->name }}</td>
                                                    <td class="p-2.5"><span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700 uppercase">{{ $p->type }}</span></td>
                                                    <td class="p-2.5 font-mono text-slate-600">{{ $p->phone ?? '-' }}</td>
                                                    <td class="p-2.5 text-right font-mono text-slate-600">Rs. {{ number_format($p->credit_limit, 2) }}</td>
                                                    <td class="p-2.5 text-right font-mono font-bold {{ $p->current_balance > 0 ? 'text-emerald-700' : ($p->current_balance < 0 ? 'text-rose-700' : 'text-slate-700') }}">
                                                        Rs. {{ number_format($p->current_balance, 2) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </template>

                    <!-- 2. MEDICAL REPS REPORT -->
                    <template x-if="activeReport === 'medical_reps'">
                        <div class="overflow-x-auto border border-slate-200 rounded-lg">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead class="bg-[#0f4c81] text-white font-bold uppercase text-[10px] tracking-wider">
                                    <tr>
                                        <th class="p-2.5">ID</th>
                                        <th class="p-2.5">Representative Name</th>
                                        <th class="p-2.5">Designation / Area</th>
                                        <th class="p-2.5">Phone</th>
                                        <th class="p-2.5 text-right">Balance (Rs.)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200">
                                    @forelse($medicalReps as $mr)
                                        <tr class="hover:bg-slate-50">
                                            <td class="p-2.5 font-mono text-slate-600">{{ $mr->id }}</td>
                                            <td class="p-2.5 font-bold text-[#0f4c81]">{{ $mr->name }}</td>
                                            <td class="p-2.5 text-slate-600">{{ $mr->area ?? 'General' }}</td>
                                            <td class="p-2.5 font-mono text-slate-600">{{ $mr->phone ?? '-' }}</td>
                                            <td class="p-2.5 text-right font-mono font-bold text-slate-900">Rs. {{ number_format($mr->balance ?? 0, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="p-4 text-center text-slate-500">No medical representatives registered.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </template>

                    <!-- 3. COMPANIES REPORT -->
                    <template x-if="activeReport === 'companies'">
                        <div class="overflow-x-auto border border-slate-200 rounded-lg">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead class="bg-[#0f4c81] text-white font-bold uppercase text-[10px] tracking-wider">
                                    <tr>
                                        <th class="p-2.5">ID</th>
                                        <th class="p-2.5">Company Name</th>
                                        <th class="p-2.5">Contact Person</th>
                                        <th class="p-2.5">Phone</th>
                                        <th class="p-2.5 text-right">Balance (Rs.)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200">
                                    @forelse($companies as $comp)
                                        <tr class="hover:bg-slate-50">
                                            <td class="p-2.5 font-mono text-slate-600">{{ $comp->id }}</td>
                                            <td class="p-2.5 font-bold text-[#0f4c81]">{{ $comp->name }}</td>
                                            <td class="p-2.5 text-slate-600">{{ $comp->contact_person ?? '-' }}</td>
                                            <td class="p-2.5 font-mono text-slate-600">{{ $comp->phone ?? '-' }}</td>
                                            <td class="p-2.5 text-right font-mono font-bold text-slate-900">Rs. {{ number_format($comp->balance ?? 0, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="p-4 text-center text-slate-500">No companies registered.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </template>

                    <!-- 4. SALESMEN REPORT -->
                    <template x-if="activeReport === 'salesmen'">
                        <div class="overflow-x-auto border border-slate-200 rounded-lg">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead class="bg-[#0f4c81] text-white font-bold uppercase text-[10px] tracking-wider">
                                    <tr>
                                        <th class="p-2.5">ID</th>
                                        <th class="p-2.5">Salesman Name</th>
                                        <th class="p-2.5">Commission %</th>
                                        <th class="p-2.5">Phone</th>
                                        <th class="p-2.5 text-right">Balance (Rs.)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200">
                                    @forelse($salesmen as $sm)
                                        <tr class="hover:bg-slate-50">
                                            <td class="p-2.5 font-mono text-slate-600">{{ $sm->id }}</td>
                                            <td class="p-2.5 font-bold text-[#0f4c81]">{{ $sm->name }}</td>
                                            <td class="p-2.5 font-mono text-slate-600">{{ $sm->commission_rate ?? '0' }}%</td>
                                            <td class="p-2.5 font-mono text-slate-600">{{ $sm->phone ?? '-' }}</td>
                                            <td class="p-2.5 text-right font-mono font-bold text-slate-900">Rs. {{ number_format($sm->balance ?? 0, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="p-4 text-center text-slate-500">No salesmen registered.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </template>

                    <!-- 5. BANKS REPORT -->
                    <template x-if="activeReport === 'banks'">
                        <div class="overflow-x-auto border border-slate-200 rounded-lg">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead class="bg-[#0f4c81] text-white font-bold uppercase text-[10px] tracking-wider">
                                    <tr>
                                        <th class="p-2.5">Bank Name</th>
                                        <th class="p-2.5">Account Title</th>
                                        <th class="p-2.5">Account #</th>
                                        <th class="p-2.5">Branch</th>
                                        <th class="p-2.5 text-right">Balance (Rs.)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200">
                                    @forelse($banks as $b)
                                        <tr class="hover:bg-slate-50">
                                            <td class="p-2.5 font-bold text-[#0f4c81]">{{ $b->name }}</td>
                                            <td class="p-2.5 text-slate-700">{{ $b->account_title ?? '-' }}</td>
                                            <td class="p-2.5 font-mono text-slate-600">{{ $b->account_number ?? '-' }}</td>
                                            <td class="p-2.5 text-slate-600">{{ $b->branch ?? '-' }}</td>
                                            <td class="p-2.5 text-right font-mono font-bold text-emerald-700">Rs. {{ number_format($b->current_balance ?? 0, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="p-4 text-center text-slate-500">No bank accounts registered.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </template>

                    <!-- 6. EXPENSES REPORT -->
                    <template x-if="activeReport === 'expenses'">
                        <div class="space-y-3">
                            <div class="flex justify-between items-center bg-amber-50 p-3 rounded-lg border border-amber-200">
                                <span class="font-bold text-amber-900">Total Period Expenses:</span>
                                <span class="text-base font-black font-mono text-amber-800">Rs. {{ number_format($totalExpenses, 2) }}</span>
                            </div>
                            <div class="overflow-x-auto border border-slate-200 rounded-lg">
                                <table class="w-full text-left text-xs border-collapse">
                                    <thead class="bg-[#0f4c81] text-white font-bold uppercase text-[10px] tracking-wider">
                                        <tr>
                                            <th class="p-2.5">Date</th>
                                            <th class="p-2.5">Category</th>
                                            <th class="p-2.5">Description</th>
                                            <th class="p-2.5 text-right">Amount (Rs.)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200">
                                        @forelse($filteredExpenses as $exp)
                                            <tr class="hover:bg-slate-50">
                                                <td class="p-2.5 font-mono">{{ $exp->date }}</td>
                                                <td class="p-2.5 font-bold text-slate-700">{{ $exp->category ?? 'General' }}</td>
                                                <td class="p-2.5 text-slate-600">{{ $exp->description ?? '-' }}</td>
                                                <td class="p-2.5 text-right font-mono font-bold text-amber-700">Rs. {{ number_format($exp->amount, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="p-4 text-center text-slate-500">No expenses recorded in this period.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </template>

                    <!-- 7. AMANATS REPORT -->
                    <template x-if="activeReport === 'amanats'">
                        <div class="overflow-x-auto border border-slate-200 rounded-lg">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead class="bg-[#0f4c81] text-white font-bold uppercase text-[10px] tracking-wider">
                                    <tr>
                                        <th class="p-2.5">Date</th>
                                        <th class="p-2.5">Party</th>
                                        <th class="p-2.5">Detail</th>
                                        <th class="p-2.5 text-right">Amount (Rs.)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200">
                                    @forelse($amanats as $am)
                                        <tr class="hover:bg-slate-50">
                                            <td class="p-2.5 font-mono">{{ $am->date ?? '-' }}</td>
                                            <td class="p-2.5 font-bold text-[#0f4c81]">{{ $am->party?->name ?? 'Direct' }}</td>
                                            <td class="p-2.5 text-slate-600">{{ $am->detail ?? '-' }}</td>
                                            <td class="p-2.5 text-right font-mono font-bold text-slate-900">Rs. {{ number_format($am->amount ?? 0, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="p-4 text-center text-slate-500">No amanats on record.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </template>

                    <!-- 8. LOTTERIES REPORT -->
                    <template x-if="activeReport === 'lotteries'">
                        <div class="overflow-x-auto border border-slate-200 rounded-lg">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead class="bg-[#0f4c81] text-white font-bold uppercase text-[10px] tracking-wider">
                                    <tr>
                                        <th class="p-2.5">Lottery Name</th>
                                        <th class="p-2.5">Ticket Series</th>
                                        <th class="p-2.5">Draw Date</th>
                                        <th class="p-2.5 text-right">Amount (Rs.)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200">
                                    @forelse($lotteries as $lot)
                                        <tr class="hover:bg-slate-50">
                                            <td class="p-2.5 font-bold text-[#0f4c81]">{{ $lot->name }}</td>
                                            <td class="p-2.5 font-mono text-slate-600">{{ $lot->series ?? '-' }}</td>
                                            <td class="p-2.5 font-mono text-slate-600">{{ $lot->draw_date ?? '-' }}</td>
                                            <td class="p-2.5 text-right font-mono font-bold text-slate-900">Rs. {{ number_format($lot->amount ?? 0, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="p-4 text-center text-slate-500">No lotteries on record.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </template>

                    <!-- 9. SALES REPORT -->
                    <template x-if="activeReport === 'sales'">
                        <div class="space-y-3">
                            <div class="flex justify-between items-center bg-sky-50 p-3 rounded-lg border border-sky-200">
                                <span class="font-bold text-sky-900">Total Period Sales:</span>
                                <span class="text-base font-black font-mono text-[#007cb5]">Rs. {{ number_format($totalSales, 2) }}</span>
                            </div>
                            <div class="overflow-x-auto border border-slate-200 rounded-lg">
                                <table class="w-full text-left text-xs border-collapse">
                                    <thead class="bg-[#0f4c81] text-white font-bold uppercase text-[10px] tracking-wider">
                                        <tr>
                                            <th class="p-2.5">Invoice #</th>
                                            <th class="p-2.5">Date</th>
                                            <th class="p-2.5">Customer / Party</th>
                                            <th class="p-2.5 text-right">Net Amount (Rs.)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200">
                                        @forelse($filteredSales as $sale)
                                            <tr class="hover:bg-slate-50">
                                                <td class="p-2.5 font-mono font-bold text-sky-800">{{ $sale->invoice_no }}</td>
                                                <td class="p-2.5 font-mono">{{ $sale->date }}</td>
                                                <td class="p-2.5 font-bold text-slate-800">{{ $sale->party?->name ?? 'Walk-in' }}</td>
                                                <td class="p-2.5 text-right font-mono font-bold text-sky-700">Rs. {{ number_format($sale->net_amount, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="p-4 text-center text-slate-500">No sales recorded for this period.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </template>

                    <!-- 0. PURCHASES REPORT -->
                    <template x-if="activeReport === 'purchases'">
                        <div class="space-y-3">
                            <div class="flex justify-between items-center bg-indigo-50 p-3 rounded-lg border border-indigo-200">
                                <span class="font-bold text-indigo-900">Total Period Purchases:</span>
                                <span class="text-base font-black font-mono text-indigo-700">Rs. {{ number_format($totalPurchases, 2) }}</span>
                            </div>
                            <div class="overflow-x-auto border border-slate-200 rounded-lg">
                                <table class="w-full text-left text-xs border-collapse">
                                    <thead class="bg-[#0f4c81] text-white font-bold uppercase text-[10px] tracking-wider">
                                        <tr>
                                            <th class="p-2.5">Bill #</th>
                                            <th class="p-2.5">Date</th>
                                            <th class="p-2.5">Supplier / Party</th>
                                            <th class="p-2.5 text-right">Net Amount (Rs.)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200">
                                        @forelse($filteredPurchases as $pur)
                                            <tr class="hover:bg-slate-50">
                                                <td class="p-2.5 font-mono font-bold text-indigo-800">{{ $pur->invoice_no }}</td>
                                                <td class="p-2.5 font-mono">{{ $pur->date }}</td>
                                                <td class="p-2.5 font-bold text-slate-800">{{ $pur->party?->name ?? 'Direct' }}</td>
                                                <td class="p-2.5 text-right font-mono font-bold text-indigo-700">Rs. {{ number_format($pur->net_amount, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="p-4 text-center text-slate-500">No purchases recorded for this period.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </template>

                    <!-- A. RECEIPTS REPORT -->
                    <template x-if="activeReport === 'receipts'">
                        <div class="space-y-3">
                            <div class="flex justify-between items-center bg-emerald-50 p-3 rounded-lg border border-emerald-200">
                                <span class="font-bold text-emerald-900">Total Period Receipts:</span>
                                <span class="text-base font-black font-mono text-emerald-700">Rs. {{ number_format($totalReceipts, 2) }}</span>
                            </div>
                            <div class="overflow-x-auto border border-slate-200 rounded-lg">
                                <table class="w-full text-left text-xs border-collapse">
                                    <thead class="bg-[#0f4c81] text-white font-bold uppercase text-[10px] tracking-wider">
                                        <tr>
                                            <th class="p-2.5">Voucher #</th>
                                            <th class="p-2.5">Date</th>
                                            <th class="p-2.5">Received From</th>
                                            <th class="p-2.5">Remarks</th>
                                            <th class="p-2.5 text-right">Amount (Rs.)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200">
                                        @forelse($filteredVouchers->where('type', 'receipt') as $v)
                                            <tr class="hover:bg-slate-50">
                                                <td class="p-2.5 font-mono font-bold text-emerald-800">{{ $v->voucher_no }}</td>
                                                <td class="p-2.5 font-mono">{{ $v->date }}</td>
                                                <td class="p-2.5 font-bold text-slate-800">{{ $v->party?->name ?? 'Cash' }}</td>
                                                <td class="p-2.5 text-slate-600">{{ $v->remarks ?? '-' }}</td>
                                                <td class="p-2.5 text-right font-mono font-bold text-emerald-700">Rs. {{ number_format($v->amount, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="p-4 text-center text-slate-500">No receipts recorded for this period.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </template>

                    <!-- B. PAYMENTS REPORT -->
                    <template x-if="activeReport === 'payments'">
                        <div class="space-y-3">
                            <div class="flex justify-between items-center bg-rose-50 p-3 rounded-lg border border-rose-200">
                                <span class="font-bold text-rose-900">Total Period Payments:</span>
                                <span class="text-base font-black font-mono text-rose-700">Rs. {{ number_format($totalPayments, 2) }}</span>
                            </div>
                            <div class="overflow-x-auto border border-slate-200 rounded-lg">
                                <table class="w-full text-left text-xs border-collapse">
                                    <thead class="bg-[#0f4c81] text-white font-bold uppercase text-[10px] tracking-wider">
                                        <tr>
                                            <th class="p-2.5">Voucher #</th>
                                            <th class="p-2.5">Date</th>
                                            <th class="p-2.5">Paid To</th>
                                            <th class="p-2.5">Remarks</th>
                                            <th class="p-2.5 text-right">Amount (Rs.)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200">
                                        @forelse($filteredVouchers->where('type', 'payment') as $v)
                                            <tr class="hover:bg-slate-50">
                                                <td class="p-2.5 font-mono font-bold text-rose-800">{{ $v->voucher_no }}</td>
                                                <td class="p-2.5 font-mono">{{ $v->date }}</td>
                                                <td class="p-2.5 font-bold text-slate-800">{{ $v->party?->name ?? 'Cash' }}</td>
                                                <td class="p-2.5 text-slate-600">{{ $v->remarks ?? '-' }}</td>
                                                <td class="p-2.5 text-right font-mono font-bold text-rose-700">Rs. {{ number_format($v->amount, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="p-4 text-center text-slate-500">No payments recorded for this period.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </template>

                    <!-- C. CASH & OTHERS (Daily Cash Book Matrix) -->
                    <template x-if="activeReport === 'cash'">
                        <div class="overflow-x-auto border border-slate-200 rounded-lg">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead class="bg-[#0f4c81] text-white font-bold uppercase text-[10px] tracking-wider">
                                    <tr>
                                        <th class="p-2.5">Date</th>
                                        <th class="p-2.5 text-right">Opening Cash</th>
                                        <th class="p-2.5 text-right">Cash In (Receipts)</th>
                                        <th class="p-2.5 text-right">Cash Out (Payments)</th>
                                        <th class="p-2.5 text-right">Closing Cash</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200">
                                    @forelse($cashBookDays as $day)
                                        <tr class="hover:bg-slate-50">
                                            <td class="p-2.5 font-mono font-bold">{{ $day['date'] }}</td>
                                            <td class="p-2.5 text-right font-mono text-slate-600">Rs. {{ number_format($day['opening_cash'], 2) }}</td>
                                            <td class="p-2.5 text-right font-mono font-bold text-emerald-700">Rs. {{ number_format($day['total_cash_in'], 2) }}</td>
                                            <td class="p-2.5 text-right font-mono font-bold text-rose-700">Rs. {{ number_format($day['total_cash_out'], 2) }}</td>
                                            <td class="p-2.5 text-right font-mono font-black text-[#0f4c81]">Rs. {{ number_format($day['closing_cash'], 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="p-4 text-center text-slate-500">No cash transactions in this date range.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </template>

                </div>

                <!-- Modal Footer -->
                <div class="bg-slate-100 px-5 py-3 border-t border-slate-200 flex justify-end gap-2 shrink-0">
                    <button type="button" @click="closeReport()" class="px-4 py-1.5 rounded bg-slate-300 hover:bg-slate-400 text-slate-800 text-xs font-bold transition-all">
                        Close [Esc]
                    </button>
                </div>

            </div>

        </div>

    </div>

    <!-- Alpine.js Reports Menu Controller with Keyboard Navigation -->
    <script>
        function reportsMenu(config) {
            return {
                activeReport: config.activeReport || '',
                focusedItem: config.focusedItem || 'parties',

                openReport(repKey) {
                    this.focusedItem = repKey;
                    this.activeReport = repKey;
                },

                closeReport() {
                    this.activeReport = '';
                },

                getReportTitle() {
                    const titles = {
                        'parties': 'Parties Ledger & Account Statements',
                        'medical_reps': 'Medical Representatives Statement',
                        'companies': 'Pharmaceutical Companies Statement',
                        'salesmen': 'Salesmen Commission & Statement',
                        'banks': 'Bank Accounts & Balances',
                        'expenses': 'Expenses Summary & Ledger',
                        'amanats': 'Amanats & Security Deposits',
                        'lotteries': 'Lottery Vouchers & Register',
                        'sales': 'Sales Register & Invoices',
                        'purchases': 'Purchases Register & Bills',
                        'receipts': 'Receipt Vouchers Register',
                        'payments': 'Payment Vouchers Register',
                        'cash': 'Daily Cash Book & Flow Statement'
                    };
                    return titles[this.activeReport] || 'Report';
                },

                handleKey(e) {
                    // Ignore hotkeys when typing in form inputs
                    const tag = e.target.tagName.toLowerCase();
                    if (tag === 'input' || tag === 'select' || tag === 'textarea') {
                        return;
                    }

                    const key = e.key.toUpperCase();

                    // ESC key closes modal or returns to main menu
                    if (e.key === 'Escape') {
                        if (this.activeReport !== '') {
                            this.closeReport();
                        } else {
                            window.location.href = "{{ route('dashboard') }}";
                        }
                        return;
                    }

                    // Keyboard shortcuts matching underlined keys:
                    if (key === '1') {
                        e.preventDefault();
                        this.openReport('parties');
                    } else if (key === '2') {
                        e.preventDefault();
                        this.openReport('medical_reps');
                    } else if (key === '3') {
                        e.preventDefault();
                        this.openReport('companies');
                    } else if (key === '4') {
                        e.preventDefault();
                        this.openReport('salesmen');
                    } else if (key === '5') {
                        e.preventDefault();
                        this.openReport('banks');
                    } else if (key === '6') {
                        e.preventDefault();
                        this.openReport('expenses');
                    } else if (key === '7') {
                        e.preventDefault();
                        this.openReport('amanats');
                    } else if (key === '8') {
                        e.preventDefault();
                        this.openReport('lotteries');
                    } else if (key === '9') {
                        e.preventDefault();
                        this.openReport('sales');
                    } else if (key === '0') {
                        e.preventDefault();
                        this.openReport('purchases');
                    } else if (key === 'A') {
                        e.preventDefault();
                        this.openReport('receipts');
                    } else if (key === 'B') {
                        e.preventDefault();
                        this.openReport('payments');
                    } else if (key === 'C') {
                        e.preventDefault();
                        this.openReport('cash');
                    }
                }
            };
        }
    </script>
</x-app-layout>
