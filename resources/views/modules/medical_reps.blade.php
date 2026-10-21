<x-app-layout>
    <div class="py-5 px-3 sm:px-6 lg:px-8 font-sans" 
         x-data="{
             currentTab: '{{ request('view', $viewMode ?? 'ledger') }}',
             showAddModal: false,
             setTab(tab) {
                 this.currentTab = tab;
                 const url = new URL(window.location);
                 url.searchParams.set('view', tab);
                 window.history.pushState({}, '', url);
             }
         }"
         @keydown.window="if ($event.key === 'Escape' && !showAddModal) { window.location.href = '{{ route('dashboard') }}'; }">

        <div class="max-w-[1360px] mx-auto space-y-4">
            
            <!-- Executive Subheader Ribbon Bar: Professional Blue Theme -->
            <div class="bg-gradient-to-r from-[#0c2f55] via-[#0f4c81] to-[#144b84] rounded-lg p-3 sm:px-5 sm:py-3.5 shadow-sm border border-[#0a2747] flex flex-col sm:flex-row sm:items-center justify-between gap-3 select-none print:hidden">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded bg-white/10 border border-white/20 flex items-center justify-center p-1 shrink-0">
                        <svg class="w-7 h-7 text-sky-200" viewBox="0 0 64 64" fill="currentColor">
                            <circle cx="32" cy="18" r="9" />
                            <path d="M14 50c0-9 8-15 18-15s18 6 18 15v4H14v-4z" />
                            <polygon points="32,35 25,43 28,45 32,39 36,45 39,43" fill="#ffffff" />
                            <polygon points="32,39 34,43 33,52 32,54 31,52 30,43" fill="#0f172a" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-black text-white tracking-tight" 
                            x-text="currentTab === 'ledger' ? 'Medical Rep Account Ledger' : 'Last Closing / Medical Reps\' Balance Report'">
                            Medical Rep Account Ledger
                        </h1>
                        <p class="text-xs text-sky-200/80 font-medium">DevoAccounts ERP • Licensed to DAWN</p>
                    </div>
                </div>

                <!-- Navigation Tabs & Actions -->
                <div class="flex items-center gap-2">
                    <!-- Tab 1: Account Ledger -->
                    <button type="button" 
                            @click="setTab('ledger')"
                            :class="currentTab === 'ledger' ? 'bg-white text-[#0c2f55] shadow-sm' : 'bg-white/15 text-white hover:bg-white/25'"
                            class="px-3.5 py-1.5 text-xs font-black rounded border border-white/30 transition-all cursor-pointer">
                        Account Ledger
                    </button>

                    <!-- Tab 2: Last Closing / Balance Report -->
                    <button type="button" 
                            @click="setTab('balance')"
                            :class="currentTab === 'balance' ? 'bg-white text-[#0c2f55] shadow-sm' : 'bg-white/15 text-white hover:bg-white/25'"
                            class="px-3.5 py-1.5 text-xs font-black rounded border border-white/30 transition-all cursor-pointer">
                        Last Closing Report
                    </button>

                    <div class="h-6 w-[1px] bg-white/30 mx-1"></div>

                    <!-- Print Button -->
                    <button type="button" 
                            onclick="window.print()"
                            class="px-3 py-1.5 rounded bg-white/20 hover:bg-white/30 text-white text-xs font-bold flex items-center gap-1.5 transition-all"
                            title="Print Current Report">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>Print</span>
                    </button>

                    <!-- Exit / Dashboard Button -->
                    <a href="{{ route('dashboard') }}" 
                       class="px-3 py-1.5 rounded bg-white/10 hover:bg-rose-600/80 text-white text-xs font-bold border border-white/30 transition-all"
                       title="Return to Main Menu [Esc]">
                        Exit [Esc]
                    </a>
                </div>
            </div>


            <!-- ========================================================================= -->
            <!-- SECTION 1: MEDICAL REP ACCOUNT LEDGER (Clone of Screenshot 1) -->
            <!-- ========================================================================= -->
            <div x-show="currentTab === 'ledger'" class="space-y-4">
                
                <!-- Filter Bar (Screen view only) -->
                <div class="bg-[#f0f4f9] rounded-lg border border-[#c6d7e8] p-4 shadow-sm print:hidden">
                    <form method="GET" action="{{ route('medical_reps.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3 items-end font-sans">
                        <input type="hidden" name="view" value="ledger">

                        <!-- Select Medical Rep -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-800 mb-1">
                                Medical Representative
                            </label>
                            <select name="medical_rep_id" 
                                    onchange="this.form.submit()" 
                                    class="w-full px-3 py-1.5 text-xs font-bold uppercase rounded border-2 border-slate-700 bg-white text-slate-900 focus:outline-none focus:border-[#0f4c81]">
                                @foreach($medicalReps as $rep)
                                    <option value="{{ $rep->id }}" {{ ($selectedRep && $selectedRep->id == $rep->id) ? 'selected' : '' }}>
                                        {{ $rep->name }} &nbsp; {{ $rep->company_name ?? 'BOSCH PHARMA' }} &nbsp; CELL {{ $rep->phone ?? '03334095348' }} &nbsp; FIRM: DAWN
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- From Date -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-800 mb-1">From Date</label>
                            <input type="date" 
                                   name="from_date" 
                                   value="{{ $fromDate }}" 
                                   class="w-full px-2.5 py-1.5 text-xs font-bold font-mono rounded border-2 border-slate-700 bg-white text-slate-900 focus:outline-none focus:border-[#0f4c81]">
                        </div>

                        <!-- To Date & Submit -->
                        <div class="flex items-center gap-2">
                            <div class="flex-1">
                                <label class="block text-xs font-black uppercase tracking-wider text-slate-800 mb-1">To Date</label>
                                <input type="date" 
                                       name="to_date" 
                                       value="{{ $toDate }}" 
                                       class="w-full px-2.5 py-1.5 text-xs font-bold font-mono rounded border-2 border-slate-700 bg-white text-slate-900 focus:outline-none focus:border-[#0f4c81]">
                            </div>
                            <button type="submit" class="px-4 py-2 mt-5 rounded bg-[#0f4c81] hover:bg-[#0c2f55] text-white text-xs font-black shadow-xs transition-all">
                                Filter
                            </button>
                            <button type="button" @click="showAddModal = true" class="px-3 py-2 mt-5 rounded bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold shadow-xs transition-all" title="Add Voucher to Ledger">
                                + Entry
                            </button>
                        </div>
                    </form>
                </div>

                <!-- MAIN LEDGER REPORT CANVAS: Exact Visual Match to Screenshot 1 -->
                <div class="bg-white rounded-lg border-2 border-slate-900 p-4 sm:p-6 shadow-md font-sans text-slate-950">
                    
                    <!-- Report Header Block matching Screenshot 1 -->
                    <div class="border-b-2 border-slate-900 pb-2 mb-3">
                        <!-- Top Center Title -->
                        <div class="text-center space-y-0.5">
                            <h2 class="text-xl sm:text-2xl font-black uppercase tracking-wider text-slate-950">DAWN</h2>
                            <h3 class="text-base sm:text-lg font-black uppercase tracking-wide text-slate-950">MEDICAL REP ACCOUNT LEDGER</h3>
                        </div>

                        <!-- Subtitle Meta Information Line matching Screenshot 1 -->
                        <div class="mt-2 pt-1 flex flex-col sm:flex-row sm:items-center justify-between text-xs font-black text-slate-900 gap-1 uppercase">
                            <div>
                                <span>Medical Rep: <strong>{{ $selectedRep->name ?? 'DASRAT KUMAR' }}</strong></span>
                                <span class="mx-1"><strong>{{ $selectedRep->company_name ?? 'BOSCH PHARMA' }}</strong></span>
                                <span class="mx-1">CELL <strong>{{ $selectedRep->phone ?? '03334095348' }}</strong></span>
                                <span class="mx-1">Firm: <strong>DAWN</strong></span>
                                <span class="mx-1">City: <strong>UMERKOT</strong></span>
                                <span class="mx-1">From: <strong>{{ \Carbon\Carbon::parse($fromDate)->format('d/m/Y') }}</strong> To <strong>{{ \Carbon\Carbon::parse($toDate)->format('d/m/Y') }}</strong></span>
                            </div>
                            <div class="text-right shrink-0">
                                Page# 1 of 1
                            </div>
                        </div>
                    </div>

                    <!-- Ledger Table with Exact Grid Lines and Columns from Screenshot 1 -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs border border-slate-900">
                            <!-- Column Headers matching Screenshot 1 -->
                            <thead class="border-b-2 border-slate-900 bg-slate-100 select-none">
                                <tr class="font-black text-slate-950 uppercase text-[11px]">
                                    <th class="p-1.5 border border-slate-900 w-24 text-center">DATE</th>
                                    <th class="p-1.5 border border-slate-900">DETAIL</th>
                                    <th class="p-1.5 border border-slate-900 w-24 text-center">VOUCHER#</th>
                                    <th class="p-1.5 border border-slate-900 w-28 text-right">DEBIT</th>
                                    <th class="p-1.5 border border-slate-900 w-28 text-right">CREDIT</th>
                                    <th class="p-1.5 border border-slate-900 w-32 text-right">BALANCE</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-400 font-mono text-[11px] text-slate-950 font-bold">
                                
                                <!-- Row 1: OPENING BALANCE from Screenshot 1 -->
                                <tr class="bg-amber-50/50">
                                    <td class="p-1.5 border border-slate-900 text-center">{{ \Carbon\Carbon::parse($fromDate)->format('d/m/Y') }}</td>
                                    <td class="p-1.5 border border-slate-900 font-sans font-black uppercase">OPENING BALANCE</td>
                                    <td class="p-1.5 border border-slate-900 text-center"></td>
                                    <td class="p-1.5 border border-slate-900 text-right"></td>
                                    <td class="p-1.5 border border-slate-900 text-right"></td>
                                    <td class="p-1.5 border border-slate-900 text-right font-black">
                                        {{ number_format($openingBalance, 2, '.', '') }} {{ $openingType }}
                                    </td>
                                </tr>

                                <!-- All Transaction Rows matching Screenshot 1 -->
                                @forelse($calculatedLedger as $row)
                                    <tr class="hover:bg-slate-50">
                                        <!-- DATE -->
                                        <td class="p-1.5 border border-slate-900 text-center">
                                            {{ \Carbon\Carbon::parse($row['date'])->format('d/m/Y') }}
                                        </td>
                                        <!-- DETAIL -->
                                        <td class="p-1.5 border border-slate-900 font-sans text-slate-900 font-bold">
                                            {{ $row['detail'] }}
                                        </td>
                                        <!-- VOUCHER# -->
                                        <td class="p-1.5 border border-slate-900 text-center font-sans font-bold">
                                            {{ $row['voucher_no'] }}
                                        </td>
                                        <!-- DEBIT -->
                                        <td class="p-1.5 border border-slate-900 text-right">
                                            {{ $row['debit'] > 0 ? number_format($row['debit'], 0, '.', '') : '' }}
                                        </td>
                                        <!-- CREDIT -->
                                        <td class="p-1.5 border border-slate-900 text-right">
                                            {{ $row['credit'] > 0 ? number_format($row['credit'], 0, '.', '') : '' }}
                                        </td>
                                        <!-- BALANCE -->
                                        <td class="p-1.5 border border-slate-900 text-right font-black">
                                            {{ number_format($row['running_balance'], 2, '.', '') }} {{ $row['balance_type'] }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-4 text-center font-sans text-slate-500 font-bold">
                                            No transactions recorded within selected date range.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                            <!-- Summary Totals Footer -->
                            <tfoot class="border-t-2 border-slate-900 bg-slate-100 font-mono font-black text-xs">
                                <tr>
                                    <td colspan="3" class="p-2 border border-slate-900 text-right font-sans uppercase">
                                        TOTAL:
                                    </td>
                                    <td class="p-2 border border-slate-900 text-right">
                                        {{ number_format($totalDebit, 2, '.', '') }}
                                    </td>
                                    <td class="p-2 border border-slate-900 text-right">
                                        {{ number_format($totalCredit, 2, '.', '') }}
                                    </td>
                                    <td class="p-2 border border-slate-900 text-right text-sm">
                                        {{ number_format($finalBalance, 2, '.', '') }} {{ $finalBalanceType }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>

            </div>


            <!-- ========================================================================= -->
            <!-- SECTION 2: LAST CLOSING / MEDICAL REPS' BALANCE REPORT (Clone of Screenshot 2) -->
            <!-- ========================================================================= -->
            <div x-show="currentTab === 'balance'" class="space-y-4">
                
                <!-- Filter Bar (Screen view only) -->
                <div class="bg-[#f0f4f9] rounded-lg border border-[#c6d7e8] p-4 shadow-sm print:hidden">
                    <form method="GET" action="{{ route('medical_reps.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3 items-end font-sans">
                        <input type="hidden" name="view" value="balance">

                        <!-- As On Date -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-800 mb-1">As On Date</label>
                            <input type="date" 
                                   name="as_on_date" 
                                   value="{{ $asOnDate }}" 
                                   class="w-full px-2.5 py-1.5 text-xs font-bold font-mono rounded border-2 border-slate-700 bg-white text-slate-900 focus:outline-none focus:border-[#0f4c81]">
                        </div>

                        <!-- Filter Dropdown: Debit / Credit / NIL / All -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-800 mb-1">Show Balance Filter</label>
                            <select name="show_filter" 
                                    onchange="this.form.submit()" 
                                    class="w-full px-2.5 py-1.5 text-xs font-bold rounded border-2 border-slate-700 bg-white text-slate-900 focus:outline-none focus:border-[#0f4c81]">
                                <option value="Medical Rep With Debit Balance" {{ $showFilter === 'Medical Rep With Debit Balance' ? 'selected' : '' }}>
                                    Medical Rep With Debit Balance
                                </option>
                                <option value="Medical Rep With Credit Balance" {{ $showFilter === 'Medical Rep With Credit Balance' ? 'selected' : '' }}>
                                    Medical Rep With Credit Balance
                                </option>
                                <option value="Medical Rep With NIL Balance" {{ $showFilter === 'Medical Rep With NIL Balance' ? 'selected' : '' }}>
                                    Medical Rep With NIL Balance
                                </option>
                                <option value="All Medical Rep" {{ $showFilter === 'All Medical Rep' ? 'selected' : '' }}>
                                    All Medical Rep
                                </option>
                            </select>
                        </div>

                        <!-- City Filter -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-800 mb-1">City Filter</label>
                            <select name="city_filter" 
                                    onchange="this.form.submit()" 
                                    class="w-full px-2.5 py-1.5 text-xs font-bold rounded border-2 border-slate-700 bg-white text-slate-900 focus:outline-none focus:border-[#0f4c81]">
                                <option value="(ALL)" {{ $cityFilter === '(ALL)' ? 'selected' : '' }}>(ALL)</option>
                                <option value="UMERKOT" {{ $cityFilter === 'UMERKOT' ? 'selected' : '' }}>UMERKOT</option>
                                <option value="OUTSTATION" {{ $cityFilter === 'OUTSTATION' ? 'selected' : '' }}>OUTSTATION</option>
                            </select>
                        </div>

                        <!-- Submit -->
                        <div>
                            <button type="submit" class="w-full py-2 rounded bg-[#0f4c81] hover:bg-[#0c2f55] text-white text-xs font-black shadow-xs transition-all">
                                Refresh Report
                            </button>
                        </div>
                    </form>
                </div>

                <!-- MAIN LAST CLOSING REPORT CANVAS: Exact Visual Match to Screenshot 2 -->
                <div class="bg-white rounded-lg border-2 border-slate-900 p-4 sm:p-6 shadow-md font-sans text-slate-950">
                    
                    <!-- Report Header Block matching Screenshot 2 -->
                    <div class="border-b-2 border-slate-900 pb-2 mb-3">
                        <!-- Top Center Title -->
                        <div class="text-center space-y-0.5">
                            <h2 class="text-xl sm:text-2xl font-black uppercase tracking-wider text-slate-950">DAWN</h2>
                            <h3 class="text-base sm:text-lg font-black uppercase tracking-wide text-slate-950">MEDICAL REPS' BALANCE REPORT</h3>
                        </div>

                        <!-- Subtitle Meta Information Line matching Screenshot 2 -->
                        <div class="mt-2 pt-1 flex flex-col sm:flex-row sm:items-center justify-between text-xs font-black text-slate-900 gap-1 uppercase">
                            <div>
                                <span>As On: <strong>{{ \Carbon\Carbon::parse($asOnDate)->format('d/m/Y') }}</strong></span>
                                <span class="mx-2">|</span>
                                <span>Filter: <strong>{{ $showFilter }}</strong></span>
                                <span class="mx-2">|</span>
                                <span>Firm: <strong>{{ $firmFilter }}</strong></span>
                                <span class="mx-2">|</span>
                                <span>City: <strong>{{ $cityFilter }}</strong></span>
                            </div>
                            <div class="text-right shrink-0">
                                Page# 1 of 1 &nbsp; Printed On: {{ date('d/m/Y') }}
                            </div>
                        </div>
                    </div>

                    <!-- Exact 3-Column Table matching Screenshot 2: S#, MEDICAL REP, BALANCE -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs border border-slate-900">
                            <!-- Headers matching Screenshot 2 -->
                            <thead class="border-b-2 border-slate-900 bg-slate-100 select-none">
                                <tr class="font-black text-slate-950 uppercase text-[11px]">
                                    <th class="p-1.5 border border-slate-900 w-14 text-center">S#</th>
                                    <th class="p-1.5 border border-slate-900">MEDICAL REP</th>
                                    <th class="p-1.5 border border-slate-900 w-36 text-right">BALANCE</th>
                                </tr>
                            </thead>

                            <!-- All 35 Real Records from Screenshot 2 -->
                            <tbody class="divide-y divide-slate-400 font-mono text-[11px] text-slate-950">
                                @forelse($filteredBalanceReport as $row)
                                    <tr class="hover:bg-blue-50/60 transition-colors">
                                        <!-- S# -->
                                        <td class="p-1.5 border border-slate-900 text-center font-bold font-sans">
                                            {{ $row['s_no'] }}
                                        </td>

                                        <!-- MEDICAL REP: Name, Phone, Firm, City (Clickable to Ledger) -->
                                        <td class="p-1.5 border border-slate-900 font-sans font-bold">
                                            <a href="{{ route('medical_reps.index', ['view' => 'ledger', 'medical_rep_id' => $row['id']]) }}" 
                                               class="hover:text-[#0f4c81] hover:underline flex items-center justify-between group"
                                               title="Click to view complete Account Ledger for {{ $row['name'] }}">
                                                <span>{{ $row['full_rep_label'] }}</span>
                                                <span class="opacity-0 group-hover:opacity-100 text-[10px] text-[#0f4c81] font-sans uppercase font-bold shrink-0 ml-2">
                                                    [Open Ledger →]
                                                </span>
                                            </a>
                                        </td>

                                        <!-- BALANCE with DR/CR matching Screenshot 2 -->
                                        <td class="p-1.5 border border-slate-900 text-right font-black">
                                            {{ number_format($row['balance'], 2, '.', '') }} {{ $row['status'] }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="p-4 text-center font-sans text-slate-500 font-bold">
                                            No medical representatives found matching the selected balance filter.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                            <!-- Bottom Row: TOTAL matching Screenshot 2 -->
                            <tfoot class="border-t-2 border-slate-900 bg-slate-100 font-mono font-black text-xs select-none">
                                <tr>
                                    <td colspan="2" class="p-2 border border-slate-900 text-right font-sans uppercase">
                                        TOTAL
                                    </td>
                                    <td class="p-2 border border-slate-900 text-right text-sm">
                                        {{ number_format($totalBalanceSum, 2, '.', '') }} DR
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>

            </div>

        </div>

        <!-- ========================================================================= -->
        <!-- MODAL: ADD TRANSACTION VOUCHER TO MEDICAL REP -->
        <!-- ========================================================================= -->
        <div x-show="showAddModal" 
             x-cloak 
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-3 sm:p-6"
             @click.self="showAddModal = false">
            <div class="bg-white rounded-xl shadow-2xl border-2 border-[#0f4c81] w-full max-w-md overflow-hidden font-sans animate-in fade-in zoom-in duration-150">
                <div class="bg-gradient-to-r from-[#0c2f55] via-[#0f4c81] to-[#144b84] px-4 py-3 flex items-center justify-between text-white border-b border-[#0a2747]">
                    <h3 class="text-sm font-black">Add Transaction to Medical Rep Ledger</h3>
                    <button type="button" @click="showAddModal = false" class="text-white/80 hover:text-white font-bold">✕</button>
                </div>
                <form method="POST" action="{{ route('medical_reps.store') }}" class="p-4 space-y-3 text-xs">
                    @csrf
                    <input type="hidden" name="add_ledger_entry" value="1">
                    <input type="hidden" name="medical_rep_id" value="{{ $selectedRep->id ?? 1 }}">

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Medical Representative</label>
                        <input type="text" readonly value="{{ $selectedRep->name ?? 'DASRAT KUMAR' }} ({{ $selectedRep->company_name ?? 'BOSCH PHARMA' }})" class="w-full px-2.5 py-1.5 rounded border border-slate-300 bg-slate-100 font-bold text-slate-800">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Date</label>
                            <input type="date" name="date" required value="{{ date('Y-m-d') }}" class="w-full px-2.5 py-1.5 rounded border border-slate-300 font-mono">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Type</label>
                            <select name="type" class="w-full px-2.5 py-1.5 rounded border border-slate-300 font-bold">
                                <option value="debit">Debit (Sales / Payment to Rep)</option>
                                <option value="credit">Credit (Cash Received / Recovery)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Detail / Description</label>
                        <input type="text" name="detail" required placeholder="e.g. Sales Invoice# 2497 CK, RECD CASH" class="w-full px-2.5 py-1.5 rounded border border-slate-300">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Amount (Rs.)</label>
                            <input type="number" step="0.01" min="0.01" name="amount" required placeholder="0.00" class="w-full px-2.5 py-1.5 rounded border border-slate-300 font-mono font-bold">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Voucher # (Optional)</label>
                            <input type="text" name="voucher_no" placeholder="Optional" class="w-full px-2.5 py-1.5 rounded border border-slate-300 font-mono">
                        </div>
                    </div>

                    <div class="pt-3 flex justify-end gap-2 border-t border-slate-200">
                        <button type="button" @click="showAddModal = false" class="px-3 py-1.5 rounded bg-slate-200 hover:bg-slate-300 font-bold text-slate-700">Cancel</button>
                        <button type="submit" class="px-4 py-1.5 rounded bg-[#0f4c81] hover:bg-[#0c2f55] text-white font-bold">Save to Ledger</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
