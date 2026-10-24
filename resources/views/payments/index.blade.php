<x-app-layout>
    <div class="py-2 px-3 sm:px-6 lg:px-8 font-sans flex-grow flex flex-col overflow-hidden" x-data="paymentsMenu()" @keydown.window="handleKey($event)">

        <div class="max-w-[1360px] mx-auto flex flex-col flex-grow overflow-hidden w-full">
            
            <!-- MAIN CANVAS: Recreated directly from Payments Reference Screenshot -->
            <div class="bg-[#f0f4f9] rounded-xl border border-[#c6d7e8] shadow-md p-3 sm:p-5 lg:p-6 flex flex-col justify-between flex-grow overflow-hidden">
                
                <div>
                    <!-- Subheader Ribbon Banner: Cash Note with Outgoing Arrow + Payments -->
                    <div class="bg-gradient-to-r from-[#0c2f55] via-[#0f4c81] to-[#144b84] rounded-lg p-2.5 sm:px-4 sm:py-2.5 shadow-sm border border-[#0a2747] flex items-center justify-between mb-4 select-none">
                        <div class="flex items-center gap-3">
                            <!-- Cash with Outgoing Right Arrow Icon matching Screenshot -->
                            <div class="w-9 h-9 rounded bg-white/10 border border-white/20 flex items-center justify-center p-1 shrink-0">
                                <svg class="w-7 h-7 text-sky-200" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="6" y="14" width="28" height="20" rx="2" fill="none" stroke="currentColor" stroke-width="2.2" />
                                    <rect x="9" y="17" width="22" height="14" rx="1" stroke="currentColor" stroke-width="1.4" />
                                    <circle cx="12" cy="20" r="1.2" fill="currentColor" />
                                    <circle cx="28" cy="20" r="1.2" fill="currentColor" />
                                    <ellipse cx="20" cy="24" rx="4.5" ry="3.5" stroke="currentColor" stroke-width="1.5" />
                                    <!-- Bold Outgoing Arrow to the right -->
                                    <path d="M26 24h16m0 0l-5-5m5 5l-5 5" stroke="#38bdf8" stroke-width="2.6" />
                                </svg>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-black text-white tracking-tight">Payments</h1>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('dashboard') }}" 
                               onclick="if(window.history.length > 1 && document.referrer.includes(window.location.host)) { event.preventDefault(); window.history.back(); } else { window.location.href='{{ route('dashboard') }}'; }" 
                               class="group flex flex-col items-center justify-center min-w-[54px] h-[48px] px-2.5 py-1 rounded-md bg-white hover:bg-slate-100 hover:border-red-400 text-slate-800 border border-white/80 shadow-md transition-all select-none cursor-pointer active:scale-95" 
                               title="Exit [Esc]">
                                <div class="text-slate-800 group-hover:text-red-600 transition-colors">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                        <polyline points="16 17 21 12 16 7" />
                                        <line x1="21" y1="12" x2="9" y2="12" />
                                    </svg>
                                </div>
                                <span class="text-[11px] font-bold text-slate-900 group-hover:text-red-600 leading-tight mt-0.5">
                                    <span class="underline">E</span>xit
                                </span>
                            </a>
                        </div>
                    </div>

                    <!-- 2-Column Desktop Icons Grid matching Screenshot Layout & Alignment -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 sm:gap-y-3 gap-x-12 sm:gap-x-20 max-w-xl items-start">
                        
                        <!-- ========================================================= -->
                        <!-- COLUMN 1: Left Stack (1 Parties, 2 Medical Reps, 3 Companies, 4 Salesmen, 5 Banks) -->
                        <!-- ========================================================= -->
                        <div class="flex flex-col space-y-1 sm:space-y-1.5 items-center w-full">
                            
                            <!-- 1 Parties -->
                            <a href="{{ route('parties.index') }}" 
                               class="group flex flex-col items-center justify-center text-center p-2 rounded-lg hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm active:scale-95 transition-all select-none w-36 h-[72px] cursor-pointer border border-transparent" 
                               title="[HotKey: 1] Parties">
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
                            </a>

                            <!-- 2 Medical Reps (Active / Hovered state with soft focus card matching screenshot) -->
                            <a href="{{ route('medical_reps.index') }}" 
                               class="group flex flex-col items-center justify-center text-center p-2 rounded-lg bg-sky-50/70 border border-sky-300 shadow-sm hover:bg-sky-100/80 hover:border-sky-400 active:scale-95 transition-all select-none w-36 h-[72px] cursor-pointer" 
                               title="[HotKey: 2] Medical Representatives">
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
                            </a>

                            <!-- 3 Companies -->
                            <a href="{{ route('companies.index') }}" 
                               class="group flex flex-col items-center justify-center text-center p-2 rounded-lg hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm active:scale-95 transition-all select-none w-36 h-[72px] cursor-pointer border border-transparent" 
                               title="[HotKey: 3] Companies">
                                <div class="w-12 h-12 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-800 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="18" y="10" width="28" height="46" rx="1.5" fill="#ffffff" stroke="#1e293b" stroke-width="2.2" />
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
                                        <rect x="29" y="48" width="6" height="8" fill="#1e293b" />
                                    </svg>
                                </div>
                                <span class="mt-2 text-[13px] sm:text-[14px] font-bold text-slate-900 group-hover:text-[#0f3868] tracking-tight">
                                    <span class="underline decoration-2 underline-offset-2">3</span> Companies
                                </span>
                            </a>

                            <!-- 4 Salesmen -->
                            <a href="{{ route('salesmen.index') }}" 
                               class="group flex flex-col items-center justify-center text-center p-2 rounded-lg hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm active:scale-95 transition-all select-none w-36 h-[72px] cursor-pointer border border-transparent" 
                               title="[HotKey: 4] Salesmen">
                                <div class="w-12 h-12 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-900 group-hover:text-[#0f3868] transition-colors" viewBox="0 0 64 64">
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
                               class="group flex flex-col items-center justify-center text-center p-2 rounded-lg hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm active:scale-95 transition-all select-none w-36 h-[72px] cursor-pointer border border-transparent" 
                               title="[HotKey: 5] Bank Accounts">
                                <div class="w-12 h-12 flex items-center justify-center">
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
                                    <span class="underline decoration-2 underline-offset-2">5</span> Banks
                                </span>
                            </a>

                        </div>

                        <!-- ========================================================= -->
                        <!-- COLUMN 2: Right Stack (6 Expenses, 7 Amanats, 8 Lotteries) -->
                        <!-- ========================================================= -->
                        <div class="flex flex-col space-y-1 sm:space-y-1.5 items-center w-full">
                            
                            <!-- 6 Expenses -->
                            <a href="{{ route('expenses.index') }}" 
                               class="group flex flex-col items-center justify-center text-center p-2 rounded-lg hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm active:scale-95 transition-all select-none w-36 h-[72px] cursor-pointer border border-transparent" 
                               title="[HotKey: 6] Expenses">
                                <div class="w-12 h-12 flex items-center justify-center">
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
                               class="group flex flex-col items-center justify-center text-center p-2 rounded-lg hover:bg-blue-50/90 hover:border-sky-300 hover:shadow-sm active:scale-95 transition-all select-none w-36 h-[72px] cursor-pointer border border-transparent" 
                               title="[HotKey: 7] Amanats">
                                <div class="w-12 h-12 flex items-center justify-center">
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

                            <!-- 8 Lotteries: Selected Card with Outline Focus Box matching Screenshot -->
                            <a href="{{ route('payments-to-lotteries.index') }}" 
                               class="group flex flex-col items-center justify-center text-center p-2 rounded-lg bg-sky-50/70 border border-sky-400/90 shadow-sm hover:bg-sky-100 hover:border-sky-500 active:scale-95 transition-all select-none w-36 h-[72px] cursor-pointer" 
                               title="[HotKey: 8] Payments to Lotteries">
                                <div class="w-12 h-12 flex items-center justify-center">
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

                            <!-- Empty slots for rows 4 & 5 to preserve exact alignment -->
                            <div class="w-36 h-[72px] hidden sm:block"></div>
                            <div class="w-36 h-[72px] hidden sm:block"></div>

                        </div>

                    </div>
                </div>

                <!-- Bottom Helper Hints & Key Access -->
                <div class="mt-2 pt-2 border-t border-[#d5e2f0] flex flex-col sm:flex-row items-center justify-between text-xs text-slate-600 gap-1.5 select-none">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="px-2 py-0.5 rounded bg-white border border-[#c6d7e8] font-mono font-bold text-[#0f4c81] text-[11px] shadow-2xs">
                            PAYMENTS SHORTCUTS
                        </span>
                        <span class="text-slate-600 text-xs">
                            Press hotkeys (<kbd class="px-1.5 py-0.5 bg-white border border-slate-300 rounded font-mono font-bold text-slate-800">1</kbd>-<kbd class="px-1.5 py-0.5 bg-white border border-slate-300 rounded font-mono font-bold text-slate-800">8</kbd>, <kbd class="px-1.5 py-0.5 bg-white border border-slate-300 rounded font-mono font-bold text-slate-800">Esc</kbd>) to navigate instantly
                        </span>
                    </div>
                    <div class="text-[11px] font-mono text-slate-500 font-medium">
                        Payments Subsystem • DAWN ERP
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script>
        function paymentsMenu() {
            return {
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
                    if (key === 'escape') window.location.href = '{{ route('dashboard') }}';
                }
            };
        }
    </script>
</x-app-layout>
