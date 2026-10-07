<x-app-layout>
    <div class="py-6">
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
                        <h1 class="text-lg font-extrabold text-white font-['Outfit']">Financial & Ledger Reports</h1>
                        <p class="text-xs text-slate-400">Filtered Date-Range & Detailed Module Summaries</p>
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

            <!-- Executive Financial Summary Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                <div class="prowave-glass-card rounded-2xl p-4 text-center">
                    <span class="text-xs font-bold text-slate-400 uppercase">Period Sales</span>
                    <div class="text-xl font-extrabold text-cyan-400 font-mono mt-1">Rs. {{ number_format($totalSales, 2) }}</div>
                </div>
                <div class="prowave-glass-card rounded-2xl p-4 text-center">
                    <span class="text-xs font-bold text-slate-400 uppercase">Period Purchases</span>
                    <div class="text-xl font-extrabold text-indigo-400 font-mono mt-1">Rs. {{ number_format($totalPurchases, 2) }}</div>
                </div>
                <div class="prowave-glass-card rounded-2xl p-4 text-center">
                    <span class="text-xs font-bold text-slate-400 uppercase">Total Receipts</span>
                    <div class="text-xl font-extrabold text-emerald-400 font-mono mt-1">Rs. {{ number_format($totalReceipts, 2) }}</div>
                </div>
                <div class="prowave-glass-card rounded-2xl p-4 text-center">
                    <span class="text-xs font-bold text-slate-400 uppercase">Total Payments</span>
                    <div class="text-xl font-extrabold text-rose-400 font-mono mt-1">Rs. {{ number_format($totalPayments, 2) }}</div>
                </div>
                <div class="prowave-glass-card rounded-2xl p-4 text-center">
                    <span class="text-xs font-bold text-slate-400 uppercase">Total Expenses</span>
                    <div class="text-xl font-extrabold text-amber-400 font-mono mt-1">Rs. {{ number_format($totalExpenses, 2) }}</div>
                </div>
            </div>

            <!-- DETAILED PARTY LEDGER STATEMENT (IF PARTY SELECTED) -->
            @if($selectedParty)
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
                <!-- ALL MODULES EXECUTIVE SUMMARY REPORT (TABBED SECTIONS) -->
                <div class="space-y-6" x-data="{ activeTab: 'parties' }">
                    
                    <!-- Report Category Selector Tabs -->
                    <div class="flex items-center gap-2 overflow-x-auto border-b border-slate-800 pb-3 font-['Outfit']">
                        <button type="button" @click="activeTab = 'cash_book'" :class="activeTab === 'cash_book' ? 'bg-emerald-500/20 text-emerald-300 border-emerald-400/40' : 'text-slate-400 hover:text-white bg-slate-900/40 border-slate-800'" class="px-4 py-2 rounded-xl text-xs font-bold border transition-all whitespace-nowrap">
                            💵 Cash Book (Day-By-Day Grid)
                        </button>
                        <button type="button" @click="activeTab = 'credit_limits'" :class="activeTab === 'credit_limits' ? 'bg-amber-500/20 text-amber-300 border-amber-400/40' : 'text-slate-400 hover:text-white bg-slate-900/40 border-slate-800'" class="px-4 py-2 rounded-xl text-xs font-bold border transition-all whitespace-nowrap">
                            ⏱️ Credit Limits & Time Limit Report
                        </button>
                        <button type="button" @click="activeTab = 'parties'" :class="activeTab === 'parties' ? 'bg-cyan-500/20 text-cyan-300 border-cyan-400/40' : 'text-slate-400 hover:text-white bg-slate-900/40 border-slate-800'" class="px-4 py-2 rounded-xl text-xs font-bold border transition-all whitespace-nowrap">
                            1 Parties Ledgers ({{ count($parties) }})
                        </button>
                        <button type="button" @click="activeTab = 'medical_reps'" :class="activeTab === 'medical_reps' ? 'bg-indigo-500/20 text-indigo-300 border-indigo-400/40' : 'text-slate-400 hover:text-white bg-slate-900/40 border-slate-800'" class="px-4 py-2 rounded-xl text-xs font-bold border transition-all whitespace-nowrap">
                            2 Medical Reps ({{ count($medicalReps) }})
                        </button>
                        <button type="button" @click="activeTab = 'companies'" :class="activeTab === 'companies' ? 'bg-purple-500/20 text-purple-300 border-purple-400/40' : 'text-slate-400 hover:text-white bg-slate-900/40 border-slate-800'" class="px-4 py-2 rounded-xl text-xs font-bold border transition-all whitespace-nowrap">
                            3 Companies ({{ count($companies) }})
                        </button>
                        <button type="button" @click="activeTab = 'salesmen'" :class="activeTab === 'salesmen' ? 'bg-cyan-500/20 text-cyan-300 border-cyan-400/40' : 'text-slate-400 hover:text-white bg-slate-900/40 border-slate-800'" class="px-4 py-2 rounded-xl text-xs font-bold border transition-all whitespace-nowrap">
                            4 Salesmen ({{ count($salesmen) }})
                        </button>
                        <button type="button" @click="activeTab = 'banks'" :class="activeTab === 'banks' ? 'bg-emerald-500/20 text-emerald-300 border-emerald-400/40' : 'text-slate-400 hover:text-white bg-slate-900/40 border-slate-800'" class="px-4 py-2 rounded-xl text-xs font-bold border transition-all whitespace-nowrap">
                            5 Banks ({{ count($banks) }})
                        </button>
                        <button type="button" @click="activeTab = 'amanats'" :class="activeTab === 'amanats' ? 'bg-amber-500/20 text-amber-300 border-amber-400/40' : 'text-slate-400 hover:text-white bg-slate-900/40 border-slate-800'" class="px-4 py-2 rounded-xl text-xs font-bold border transition-all whitespace-nowrap">
                            7 Amanats ({{ count($amanats) }})
                        </button>
                        <button type="button" @click="activeTab = 'lotteries'" :class="activeTab === 'lotteries' ? 'bg-sky-500/20 text-sky-300 border-sky-400/40' : 'text-slate-400 hover:text-white bg-slate-900/40 border-slate-800'" class="px-4 py-2 rounded-xl text-xs font-bold border transition-all whitespace-nowrap">
                            8 Lotteries ({{ count($lotteries) }})
                        </button>
                    </div>

                    <!-- CASH BOOK DAY-BY-DAY GRID MATRIX TAB -->
                    <div x-show="activeTab === 'cash_book'" class="prowave-glass-card rounded-2xl border border-emerald-500/30 p-6 shadow-2xl space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                            <div>
                                <h3 class="text-base font-extrabold text-white font-['Outfit']">💵 Cash Book (Day-By-Day Grid Matrix)</h3>
                                <p class="text-xs text-slate-400">Daily Cash In (Sales/Receipts) vs Cash Out (Purchases/Expenses/Payments)</p>
                            </div>
                            <span class="text-xs font-mono text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-3 py-1 rounded-xl font-bold">{{ $fromDate }} to {{ $toDate }}</span>
                        </div>

                        <div class="overflow-x-auto rounded-xl border border-slate-800">
                            <table class="w-full text-left text-xs text-slate-300">
                                <thead class="bg-slate-900 text-slate-400 uppercase font-mono border-b border-slate-800">
                                    <tr>
                                        <th class="p-3">Date</th>
                                        <th class="p-3 text-right">Opening Cash</th>
                                        <th class="p-3 text-right">Cash In (Sales)</th>
                                        <th class="p-3 text-right">Cash In (Receipts)</th>
                                        <th class="p-3 text-right font-bold text-emerald-400">Total Cash In</th>
                                        <th class="p-3 text-right">Cash Out (Pur)</th>
                                        <th class="p-3 text-right">Cash Out (Exp)</th>
                                        <th class="p-3 text-right">Cash Out (Pay)</th>
                                        <th class="p-3 text-right font-bold text-rose-400">Total Cash Out</th>
                                        <th class="p-3 text-right font-extrabold text-cyan-300">Closing Cash</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-800/80">
                                    @forelse($cashBookDays as $day)
                                        <tr class="hover:bg-slate-900/40 font-mono">
                                            <td class="p-3 font-bold text-white">{{ $day['date'] }}</td>
                                            <td class="p-3 text-right text-slate-400">Rs. {{ number_format($day['opening_cash'], 2) }}</td>
                                            <td class="p-3 text-right text-cyan-300">Rs. {{ number_format($day['cash_in_sales'], 2) }}</td>
                                            <td class="p-3 text-right text-emerald-300">Rs. {{ number_format($day['cash_in_receipts'], 2) }}</td>
                                            <td class="p-3 text-right font-bold text-emerald-400 bg-emerald-500/5">Rs. {{ number_format($day['total_cash_in'], 2) }}</td>
                                            <td class="p-3 text-right text-indigo-300">Rs. {{ number_format($day['cash_out_purchases'], 2) }}</td>
                                            <td class="p-3 text-right text-amber-300">Rs. {{ number_format($day['cash_out_expenses'], 2) }}</td>
                                            <td class="p-3 text-right text-rose-300">Rs. {{ number_format($day['cash_out_payments'], 2) }}</td>
                                            <td class="p-3 text-right font-bold text-rose-400 bg-rose-500/5">Rs. {{ number_format($day['total_cash_out'], 2) }}</td>
                                            <td class="p-3 text-right font-extrabold text-cyan-300 text-sm bg-cyan-500/5">Rs. {{ number_format($day['closing_cash'], 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="10" class="p-6 text-center text-slate-500">No transactions recorded in selected date range.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- CREDIT LIMITS & TIME LIMIT AGING REPORT TAB -->
                    <div x-show="activeTab === 'credit_limits'" style="display: none;" class="prowave-glass-card rounded-2xl border border-amber-500/30 p-6 shadow-2xl space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                            <div>
                                <h3 class="text-base font-extrabold text-white font-['Outfit']">⏱️ Party Credit Limit & Time Limit Report</h3>
                                <p class="text-xs text-slate-400">Overdue Days & Credit Limit Exceeded Alerts (Yellow Highlights)</p>
                            </div>
                        </div>

                        <div class="overflow-x-auto rounded-xl border border-slate-800">
                            <table class="w-full text-left text-xs text-slate-300">
                                <thead class="bg-slate-900 text-slate-400 uppercase font-mono border-b border-slate-800">
                                    <tr>
                                        <th class="p-3.5">Code</th>
                                        <th class="p-3.5">Party Name</th>
                                        <th class="p-3.5">Type</th>
                                        <th class="p-3.5 text-right">Credit Limit (Rs.)</th>
                                        <th class="p-3.5 text-center">Time Limit</th>
                                        <th class="p-3.5 text-right">Current Balance (Rs.)</th>
                                        <th class="p-3.5 text-center">Credit Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-800/80">
                                    @forelse($creditLimitReport as $p)
                                        <tr class="{{ $p['is_over_limit'] ? 'bg-amber-500/10 text-amber-200' : 'hover:bg-slate-900/40' }}">
                                            <td class="p-3.5 font-mono font-bold text-cyan-400">{{ $p['code'] }}</td>
                                            <td class="p-3.5 font-bold text-white">{{ $p['name'] }}</td>
                                            <td class="p-3.5"><span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold uppercase bg-slate-800 text-slate-300">{{ $p['type'] }}</span></td>
                                            <td class="p-3.5 text-right font-mono text-amber-400 font-bold">
                                                {{ $p['credit_limit'] > 0 ? 'Rs. ' . number_format($p['credit_limit'], 2) : 'Unlimited' }}
                                            </td>
                                            <td class="p-3.5 text-center font-mono text-cyan-300">{{ $p['credit_days_limit'] }} Days</td>
                                            <td class="p-3.5 text-right font-mono font-bold text-emerald-400">Rs. {{ number_format($p['current_balance'], 2) }}</td>
                                            <td class="p-3.5 text-center">
                                                @if($p['is_over_limit'])
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase bg-amber-500/20 text-amber-300 border border-amber-500/40">
                                                        ⚠️ OVER LIMIT
                                                    </span>
                                                @else
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase bg-emerald-500/20 text-emerald-300 border border-emerald-500/40">
                                                        ✅ OK / CLEAR
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="7" class="p-6 text-center text-slate-500">No parties registered.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- 1 PARTIES TAB -->
                    <div x-show="activeTab === 'parties'" class="prowave-glass-card rounded-2xl border border-slate-800 p-6 shadow-2xl">
                        <h3 class="text-base font-bold text-white mb-4 font-['Outfit']">1 All Parties Ledger Summary</h3>
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

                    <!-- 2 MEDICAL REPS TAB -->
                    <div x-show="activeTab === 'medical_reps'" style="display: none;" class="prowave-glass-card rounded-2xl border border-slate-800 p-6 shadow-2xl">
                        <h3 class="text-base font-bold text-white mb-4 font-['Outfit']">2 Medical Representatives Report</h3>
                        <div class="overflow-x-auto rounded-xl border border-slate-800">
                            <table class="w-full text-left text-xs text-slate-300">
                                <thead class="bg-slate-900 text-slate-400 uppercase font-mono border-b border-slate-800">
                                    <tr>
                                        <th class="p-3.5">#</th>
                                        <th class="p-3.5">Representative Name</th>
                                        <th class="p-3.5">Phone Number</th>
                                        <th class="p-3.5">Assigned Company</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-800/80">
                                    @forelse($medicalReps as $index => $rep)
                                        <tr class="hover:bg-slate-900/40">
                                            <td class="p-3.5 font-mono text-slate-500">{{ $index + 1 }}</td>
                                            <td class="p-3.5 font-bold text-white">{{ $rep->name }}</td>
                                            <td class="p-3.5 font-mono text-cyan-300">{{ $rep->phone ?? 'N/A' }}</td>
                                            <td class="p-3.5 font-semibold text-indigo-300">{{ $rep->company_name ?? 'N/A' }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="p-6 text-center text-slate-500">No medical reps found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- 3 COMPANIES TAB -->
                    <div x-show="activeTab === 'companies'" style="display: none;" class="prowave-glass-card rounded-2xl border border-slate-800 p-6 shadow-2xl">
                        <h3 class="text-base font-bold text-white mb-4 font-['Outfit']">3 Pharmaceutical Companies Report</h3>
                        <div class="overflow-x-auto rounded-xl border border-slate-800">
                            <table class="w-full text-left text-xs text-slate-300">
                                <thead class="bg-slate-900 text-slate-400 uppercase font-mono border-b border-slate-800">
                                    <tr>
                                        <th class="p-3.5">#</th>
                                        <th class="p-3.5">Company Name</th>
                                        <th class="p-3.5">Phone</th>
                                        <th class="p-3.5">City</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-800/80">
                                    @forelse($companies as $index => $c)
                                        <tr class="hover:bg-slate-900/40">
                                            <td class="p-3.5 font-mono text-slate-500">{{ $index + 1 }}</td>
                                            <td class="p-3.5 font-bold text-white">{{ $c->name }}</td>
                                            <td class="p-3.5 font-mono text-cyan-300">{{ $c->phone ?? 'N/A' }}</td>
                                            <td class="p-3.5">{{ $c->city ?? 'N/A' }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="p-6 text-center text-slate-500">No companies found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- 4 SALESMEN TAB -->
                    <div x-show="activeTab === 'salesmen'" style="display: none;" class="prowave-glass-card rounded-2xl border border-slate-800 p-6 shadow-2xl">
                        <h3 class="text-base font-bold text-white mb-4 font-['Outfit']">4 Salesmen Performance & Commission Report</h3>
                        <div class="overflow-x-auto rounded-xl border border-slate-800">
                            <table class="w-full text-left text-xs text-slate-300">
                                <thead class="bg-slate-900 text-slate-400 uppercase font-mono border-b border-slate-800">
                                    <tr>
                                        <th class="p-3.5">#</th>
                                        <th class="p-3.5">Salesman Name</th>
                                        <th class="p-3.5">Phone</th>
                                        <th class="p-3.5 text-right">Commission Rate (%)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-800/80">
                                    @forelse($salesmen as $index => $sm)
                                        <tr class="hover:bg-slate-900/40">
                                            <td class="p-3.5 font-mono text-slate-500">{{ $index + 1 }}</td>
                                            <td class="p-3.5 font-bold text-white">{{ $sm->name }}</td>
                                            <td class="p-3.5 font-mono text-cyan-300">{{ $sm->phone ?? 'N/A' }}</td>
                                            <td class="p-3.5 text-right font-mono font-bold text-emerald-400">{{ $sm->commission_rate }}%</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="p-6 text-center text-slate-500">No salesmen found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- 5 BANKS TAB -->
                    <div x-show="activeTab === 'banks'" style="display: none;" class="prowave-glass-card rounded-2xl border border-slate-800 p-6 shadow-2xl">
                        <h3 class="text-base font-bold text-white mb-4 font-['Outfit']">5 Bank Accounts & Liquidity Report</h3>
                        <div class="overflow-x-auto rounded-xl border border-slate-800">
                            <table class="w-full text-left text-xs text-slate-300">
                                <thead class="bg-slate-900 text-slate-400 uppercase font-mono border-b border-slate-800">
                                    <tr>
                                        <th class="p-3.5">#</th>
                                        <th class="p-3.5">Bank Name</th>
                                        <th class="p-3.5">Account Title</th>
                                        <th class="p-3.5">Account Number</th>
                                        <th class="p-3.5 text-right">Balance (Rs.)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-800/80">
                                    @forelse($banks as $index => $b)
                                        <tr class="hover:bg-slate-900/40">
                                            <td class="p-3.5 font-mono text-slate-500">{{ $index + 1 }}</td>
                                            <td class="p-3.5 font-bold text-white">{{ $b->bank_name }}</td>
                                            <td class="p-3.5 font-semibold text-slate-300">{{ $b->account_title }}</td>
                                            <td class="p-3.5 font-mono text-cyan-300">{{ $b->account_number }}</td>
                                            <td class="p-3.5 text-right font-mono font-bold text-emerald-400">Rs. {{ number_format($b->balance, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="p-6 text-center text-slate-500">No banks found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- 7 AMANATS TAB -->
                    <div x-show="activeTab === 'amanats'" style="display: none;" class="prowave-glass-card rounded-2xl border border-slate-800 p-6 shadow-2xl">
                        <h3 class="text-base font-bold text-white mb-4 font-['Outfit']">7 Amanats / Trust Deposits Report</h3>
                        <div class="overflow-x-auto rounded-xl border border-slate-800">
                            <table class="w-full text-left text-xs text-slate-300">
                                <thead class="bg-slate-900 text-slate-400 uppercase font-mono border-b border-slate-800">
                                    <tr>
                                        <th class="p-3.5">Date</th>
                                        <th class="p-3.5">Depositor / Party</th>
                                        <th class="p-3.5">Details</th>
                                        <th class="p-3.5 text-right">Amanat Amount (Rs.)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-800/80">
                                    @forelse($amanats as $a)
                                        <tr class="hover:bg-slate-900/40">
                                            <td class="p-3.5 font-mono text-slate-400">{{ $a->date }}</td>
                                            <td class="p-3.5 font-bold text-white">{{ $a->party->name ?? $a->depositor_name }}</td>
                                            <td class="p-3.5 text-slate-300">{{ $a->details ?? 'N/A' }}</td>
                                            <td class="p-3.5 text-right font-mono font-bold text-amber-400">Rs. {{ number_format($a->amount, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="p-6 text-center text-slate-500">No amanats recorded.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- 8 LOTTERIES TAB -->
                    <div x-show="activeTab === 'lotteries'" style="display: none;" class="prowave-glass-card rounded-2xl border border-slate-800 p-6 shadow-2xl">
                        <h3 class="text-base font-bold text-white mb-4 font-['Outfit']">8 Lotteries & Schemes Report</h3>
                        <div class="overflow-x-auto rounded-xl border border-slate-800">
                            <table class="w-full text-left text-xs text-slate-300">
                                <thead class="bg-slate-900 text-slate-400 uppercase font-mono border-b border-slate-800">
                                    <tr>
                                        <th class="p-3.5">#</th>
                                        <th class="p-3.5">Scheme Name</th>
                                        <th class="p-3.5">Date</th>
                                        <th class="p-3.5">Status</th>
                                        <th class="p-3.5 text-right">Amount (Rs.)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-800/80">
                                    @forelse($lotteries as $index => $lot)
                                        <tr class="hover:bg-slate-900/40">
                                            <td class="p-3.5 font-mono text-slate-500">{{ $index + 1 }}</td>
                                            <td class="p-3.5 font-bold text-white">{{ $lot->scheme_name }}</td>
                                            <td class="p-3.5 font-mono text-slate-400">{{ $lot->date ?? 'N/A' }}</td>
                                            <td class="p-3.5"><span class="px-2 py-0.5 rounded-full text-[10px] bg-sky-500/10 text-sky-400 uppercase font-bold">{{ $lot->status ?? 'Active' }}</span></td>
                                            <td class="p-3.5 text-right font-mono font-bold text-emerald-400">Rs. {{ number_format($lot->amount, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="p-6 text-center text-slate-500">No lotteries recorded.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            @endif

        </div>
    </div>
</x-app-layout>
