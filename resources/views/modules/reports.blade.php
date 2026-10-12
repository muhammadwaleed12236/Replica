<x-app-layout>
    <div class="py-4">
        <div class="max-w-7xl mx-auto px-2 sm:px-4 space-y-4">

            <!-- Module Navigation Bar -->
            <x-module-nav active="reports" />

            <!-- DAWN Top Header Banner for Reports -->
            <div class="w-full bg-[#00a2e8] select-none shadow-md rounded-lg overflow-hidden border border-[#008ecb]">
                <div class="px-4 py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <x-application-logo />
                        <div class="h-7 w-px bg-black/20 mx-1 hidden sm:block"></div>
                        <div class="flex items-center gap-2 bg-[#008cc9]/70 border border-white/50 px-3 py-1.5 rounded-lg text-black">
                            <span class="text-xl">📊</span>
                            <h1 class="text-lg font-black tracking-normal font-sans">Financial & Ledger Reports</h1>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" onclick="window.print()" class="px-3 py-1.5 rounded bg-white hover:bg-[#f0f4f8] text-slate-900 text-xs font-bold flex items-center gap-1.5 shadow-sm border border-white/60 transition-all">
                            <svg class="w-4 h-4 text-[#007cb5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            <span>Print Report</span>
                        </button>
                        <a href="{{ route('dashboard') }}" class="px-3 py-1.5 rounded bg-white/20 hover:bg-white/30 text-black text-xs font-bold border border-white/40 transition-all">
                            ← Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <!-- DETAILED REPORT FILTER FORM BAR -->
            <form method="GET" action="{{ route('reports.index') }}" class="bg-white rounded-lg border-2 border-[#cbd8e4] p-4 shadow-md font-sans">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-end">
                    
                    <!-- From Date -->
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-800 mb-1">From Date</label>
                        <input type="date" name="from_date" value="{{ $fromDate }}" class="w-full px-3 py-1.5 rounded bg-white border border-[#9ab3c9] focus:border-[#00a2e8] text-slate-900 text-xs font-bold font-mono shadow-sm" />
                    </div>

                    <!-- To Date -->
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-800 mb-1">To Date</label>
                        <input type="date" name="to_date" value="{{ $toDate }}" class="w-full px-3 py-1.5 rounded bg-white border border-[#9ab3c9] focus:border-[#00a2e8] text-slate-900 text-xs font-bold font-mono shadow-sm" />
                    </div>

                    <!-- Party Filter Dropdown -->
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-800 mb-1">Filter by Party Statement</label>
                        <select name="party_id" class="w-full px-3 py-1.5 rounded bg-white border border-[#9ab3c9] focus:border-[#00a2e8] text-slate-900 text-xs font-bold shadow-sm">
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
                        <button type="submit" class="flex-1 py-1.5 rounded bg-[#00a2e8] hover:bg-[#008ecb] text-white text-xs font-black flex items-center justify-center gap-1.5 shadow-sm transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                            <span>Apply Filter</span>
                        </button>
                        <a href="{{ route('reports.index') }}" class="px-3.5 py-1.5 rounded bg-slate-100 hover:bg-slate-200 border border-[#9ab3c9] text-slate-800 text-xs font-bold transition-all">
                            Reset
                        </a>
                    </div>
                </div>
            </form>

            <!-- Executive Financial Summary Cards (High-Contrast Desktop Cards) -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 font-sans">
                <!-- Sales -->
                <div class="bg-white rounded-lg border-2 border-[#cbd8e4] border-t-4 border-t-[#00a2e8] p-3.5 text-center shadow-sm">
                    <span class="text-[11px] font-black text-slate-700 uppercase tracking-wider block">Period Sales</span>
                    <div class="text-lg font-black text-[#007cb5] font-mono mt-1">Rs. {{ number_format($totalSales, 2) }}</div>
                </div>
                <!-- Purchases -->
                <div class="bg-white rounded-lg border-2 border-[#cbd8e4] border-t-4 border-t-indigo-600 p-3.5 text-center shadow-sm">
                    <span class="text-[11px] font-black text-slate-700 uppercase tracking-wider block">Period Purchases</span>
                    <div class="text-lg font-black text-indigo-700 font-mono mt-1">Rs. {{ number_format($totalPurchases, 2) }}</div>
                </div>
                <!-- Receipts -->
                <div class="bg-white rounded-lg border-2 border-[#cbd8e4] border-t-4 border-t-emerald-600 p-3.5 text-center shadow-sm">
                    <span class="text-[11px] font-black text-slate-700 uppercase tracking-wider block">Total Receipts</span>
                    <div class="text-lg font-black text-emerald-700 font-mono mt-1">Rs. {{ number_format($totalReceipts, 2) }}</div>
                </div>
                <!-- Payments -->
                <div class="bg-white rounded-lg border-2 border-[#cbd8e4] border-t-4 border-t-rose-600 p-3.5 text-center shadow-sm">
                    <span class="text-[11px] font-black text-slate-700 uppercase tracking-wider block">Total Payments</span>
                    <div class="text-lg font-black text-rose-700 font-mono mt-1">Rs. {{ number_format($totalPayments, 2) }}</div>
                </div>
                <!-- Expenses -->
                <div class="bg-white rounded-lg border-2 border-[#cbd8e4] border-t-4 border-t-amber-500 p-3.5 text-center shadow-sm">
                    <span class="text-[11px] font-black text-slate-700 uppercase tracking-wider block">Total Expenses</span>
                    <div class="text-lg font-black text-amber-700 font-mono mt-1">Rs. {{ number_format($totalExpenses, 2) }}</div>
                </div>
            </div>

            <!-- DETAILED PARTY LEDGER STATEMENT (IF PARTY SELECTED) -->
            @if($selectedParty)
                <div class="bg-white rounded-lg border-2 border-[#0092d0] p-5 shadow-xl space-y-4 font-sans">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b-2 border-[#cbd8e4] gap-2">
                        <div>
                            <span class="px-2.5 py-0.5 rounded text-[11px] font-black uppercase bg-[#e8f4fa] text-[#007cb5] border border-[#00a2e8]">Party Ledger Statement</span>
                            <h2 class="text-2xl font-black text-slate-900 mt-1">{{ $selectedParty->name }}</h2>
                            <p class="text-xs text-slate-600 font-semibold">Phone: {{ $selectedParty->phone ?? 'N/A' }} | City: {{ $selectedParty->city ?? 'N/A' }} | Type: {{ ucfirst($selectedParty->type) }}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-xs text-slate-600 font-bold block">Current Ledger Balance:</span>
                            <span class="text-xl font-black font-mono text-emerald-700">Rs. {{ number_format($selectedParty->current_balance, 2) }}</span>
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded border border-[#cbd8e4]">
                        <table class="w-full text-left text-xs border border-[#cbd8e4]">
                            <thead class="bg-[#eaf1f7] text-slate-900 uppercase font-mono font-black border-b-2 border-[#cbd8e4]">
                                <tr>
                                    <th class="p-2.5 border-r border-[#cbd8e4]">Date</th>
                                    <th class="p-2.5 border-r border-[#cbd8e4]">Voucher / Ref #</th>
                                    <th class="p-2.5 border-r border-[#cbd8e4]">Description / Details</th>
                                    <th class="p-2.5 border-r border-[#cbd8e4] text-right">Debit (Sales/Dr)</th>
                                    <th class="p-2.5 border-r border-[#cbd8e4] text-right">Credit (Receipts/Cr)</th>
                                    <th class="p-2.5 text-right font-black">Running Balance</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#e2ebf3]">
                                <tr class="bg-[#f0f5fa] font-bold">
                                    <td class="p-2.5 border-r border-[#cbd8e4] font-mono text-slate-600">{{ $fromDate }}</td>
                                    <td class="p-2.5 border-r border-[#cbd8e4] font-mono text-[#007cb5]">OPENING</td>
                                    <td class="p-2.5 border-r border-[#cbd8e4] text-slate-800">Opening Balance Brought Forward</td>
                                    <td class="p-2.5 border-r border-[#cbd8e4] text-right font-mono">-</td>
                                    <td class="p-2.5 border-r border-[#cbd8e4] text-right font-mono">-</td>
                                    <td class="p-2.5 text-right font-mono font-black text-slate-900">Rs. {{ number_format($selectedParty->opening_balance, 2) }}</td>
                                </tr>
                                @php $runningBal = $selectedParty->opening_balance; @endphp
                                @forelse($ledgerEntries as $entry)
                                    @php
                                        if ($selectedParty->type === 'supplier') {
                                            $runningBal += ($entry['debit'] - $entry['credit']);
                                        } else {
                                            $runningBal += ($entry['debit'] - $entry['credit']);
                                        }
                                    @endphp
                                    <tr class="hover:bg-[#f6f9fc] transition-colors">
                                        <td class="p-2.5 border-r border-[#e2ebf3] font-mono text-slate-700 font-semibold">{{ $entry['date'] }}</td>
                                        <td class="p-2.5 border-r border-[#e2ebf3] font-mono font-bold text-[#007cb5]">{{ $entry['ref'] }}</td>
                                        <td class="p-2.5 border-r border-[#e2ebf3] text-slate-900 font-medium">{{ $entry['details'] }}</td>
                                        <td class="p-2.5 border-r border-[#e2ebf3] text-right font-mono text-rose-700 font-bold">
                                            {{ $entry['debit'] > 0 ? 'Rs. ' . number_format($entry['debit'], 2) : '-' }}
                                        </td>
                                        <td class="p-2.5 border-r border-[#e2ebf3] text-right font-mono text-emerald-700 font-bold">
                                            {{ $entry['credit'] > 0 ? 'Rs. ' . number_format($entry['credit'], 2) : '-' }}
                                        </td>
                                        <td class="p-2.5 text-right font-mono font-black text-slate-900">
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
                <!-- ALL MODULES EXECUTIVE SUMMARY REPORT (HIGH-CONTRAST TABBED SECTIONS) -->
                <div class="space-y-4 font-sans" x-data="{ activeTab: 'cash_book' }">
                    
                    <!-- Report Category Selector Tabs (High-Contrast Buttons) -->
                    <div class="flex items-center gap-1.5 overflow-x-auto pb-2 scrollbar-none select-none">
                        <button type="button" @click="activeTab = 'cash_book'" :class="activeTab === 'cash_book' ? 'bg-[#00a2e8] text-white font-black shadow-sm' : 'bg-white hover:bg-[#eaf4fa] text-slate-800 border border-[#cbd8e4] font-bold'" class="px-3.5 py-1.5 rounded text-xs transition-all whitespace-nowrap cursor-pointer">
                            💵 Cash Book (Day-By-Day Grid)
                        </button>
                        <button type="button" @click="activeTab = 'credit_limits'" :class="activeTab === 'credit_limits' ? 'bg-[#00a2e8] text-white font-black shadow-sm' : 'bg-white hover:bg-[#eaf4fa] text-slate-800 border border-[#cbd8e4] font-bold'" class="px-3.5 py-1.5 rounded text-xs transition-all whitespace-nowrap cursor-pointer">
                            ⏱️ Credit Limits & Aging
                        </button>
                        <button type="button" @click="activeTab = 'parties'" :class="activeTab === 'parties' ? 'bg-[#00a2e8] text-white font-black shadow-sm' : 'bg-white hover:bg-[#eaf4fa] text-slate-800 border border-[#cbd8e4] font-bold'" class="px-3.5 py-1.5 rounded text-xs transition-all whitespace-nowrap cursor-pointer">
                            1 Parties Ledgers ({{ count($parties) }})
                        </button>
                        <button type="button" @click="activeTab = 'medical_reps'" :class="activeTab === 'medical_reps' ? 'bg-[#00a2e8] text-white font-black shadow-sm' : 'bg-white hover:bg-[#eaf4fa] text-slate-800 border border-[#cbd8e4] font-bold'" class="px-3.5 py-1.5 rounded text-xs transition-all whitespace-nowrap cursor-pointer">
                            2 Medical Reps ({{ count($medicalReps) }})
                        </button>
                        <button type="button" @click="activeTab = 'companies'" :class="activeTab === 'companies' ? 'bg-[#00a2e8] text-white font-black shadow-sm' : 'bg-white hover:bg-[#eaf4fa] text-slate-800 border border-[#cbd8e4] font-bold'" class="px-3.5 py-1.5 rounded text-xs transition-all whitespace-nowrap cursor-pointer">
                            3 Companies ({{ count($companies) }})
                        </button>
                        <button type="button" @click="activeTab = 'salesmen'" :class="activeTab === 'salesmen' ? 'bg-[#00a2e8] text-white font-black shadow-sm' : 'bg-white hover:bg-[#eaf4fa] text-slate-800 border border-[#cbd8e4] font-bold'" class="px-3.5 py-1.5 rounded text-xs transition-all whitespace-nowrap cursor-pointer">
                            4 Salesmen ({{ count($salesmen) }})
                        </button>
                        <button type="button" @click="activeTab = 'banks'" :class="activeTab === 'banks' ? 'bg-[#00a2e8] text-white font-black shadow-sm' : 'bg-white hover:bg-[#eaf4fa] text-slate-800 border border-[#cbd8e4] font-bold'" class="px-3.5 py-1.5 rounded text-xs transition-all whitespace-nowrap cursor-pointer">
                            5 Banks ({{ count($banks) }})
                        </button>
                        <button type="button" @click="activeTab = 'amanats'" :class="activeTab === 'amanats' ? 'bg-[#00a2e8] text-white font-black shadow-sm' : 'bg-white hover:bg-[#eaf4fa] text-slate-800 border border-[#cbd8e4] font-bold'" class="px-3.5 py-1.5 rounded text-xs transition-all whitespace-nowrap cursor-pointer">
                            7 Amanats ({{ count($amanats) }})
                        </button>
                        <button type="button" @click="activeTab = 'lotteries'" :class="activeTab === 'lotteries' ? 'bg-[#00a2e8] text-white font-black shadow-sm' : 'bg-white hover:bg-[#eaf4fa] text-slate-800 border border-[#cbd8e4] font-bold'" class="px-3.5 py-1.5 rounded text-xs transition-all whitespace-nowrap cursor-pointer">
                            8 Lotteries ({{ count($lotteries) }})
                        </button>
                    </div>

                    <!-- 💵 CASH BOOK DAY-BY-DAY GRID MATRIX TAB -->
                    <div x-show="activeTab === 'cash_book'" class="bg-white rounded-lg border-2 border-[#cbd8e4] p-5 shadow-md space-y-3">
                        <div class="flex items-center justify-between pb-2 border-b border-[#cbd8e4]">
                            <div>
                                <h3 class="text-sm font-black text-slate-900 uppercase tracking-wide">💵 Cash Book (Day-By-Day Accounting Grid)</h3>
                                <p class="text-xs text-slate-600 font-medium">Daily Cash In (Sales/Receipts) vs Cash Out (Purchases/Expenses/Payments)</p>
                            </div>
                            <span class="text-xs font-mono text-[#007cb5] bg-[#eaf4fa] border border-[#00a2e8] px-2.5 py-1 rounded font-bold">{{ $fromDate }} to {{ $toDate }}</span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs border border-[#cbd8e4]">
                                <thead class="bg-[#eaf1f7] text-slate-900 uppercase font-mono font-black border-b-2 border-[#cbd8e4]">
                                    <tr>
                                        <th class="p-2 border-r border-[#cbd8e4]">Date</th>
                                        <th class="p-2 border-r border-[#cbd8e4] text-right">Opening Cash</th>
                                        <th class="p-2 border-r border-[#cbd8e4] text-right">Cash In (Sales)</th>
                                        <th class="p-2 border-r border-[#cbd8e4] text-right">Cash In (Receipts)</th>
                                        <th class="p-2 border-r border-[#cbd8e4] text-right font-black text-emerald-800 bg-emerald-50">Total Cash In</th>
                                        <th class="p-2 border-r border-[#cbd8e4] text-right">Cash Out (Pur)</th>
                                        <th class="p-2 border-r border-[#cbd8e4] text-right">Cash Out (Exp)</th>
                                        <th class="p-2 border-r border-[#cbd8e4] text-right">Cash Out (Pay)</th>
                                        <th class="p-2 border-r border-[#cbd8e4] text-right font-black text-rose-800 bg-rose-50">Total Cash Out</th>
                                        <th class="p-2 text-right font-black text-slate-900 bg-[#eaf4fa]">Closing Cash</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#e2ebf3]">
                                    @forelse($cashBookDays as $day)
                                        <tr class="hover:bg-[#f6f9fc] font-mono text-slate-800">
                                            <td class="p-2 border-r border-[#e2ebf3] font-bold text-slate-900">{{ $day['date'] }}</td>
                                            <td class="p-2 border-r border-[#e2ebf3] text-right text-slate-600">Rs. {{ number_format($day['opening_cash'], 2) }}</td>
                                            <td class="p-2 border-r border-[#e2ebf3] text-right text-[#007cb5] font-semibold">Rs. {{ number_format($day['cash_in_sales'], 2) }}</td>
                                            <td class="p-2 border-r border-[#e2ebf3] text-right text-emerald-700 font-semibold">Rs. {{ number_format($day['cash_in_receipts'], 2) }}</td>
                                            <td class="p-2 border-r border-[#e2ebf3] text-right font-black text-emerald-800 bg-emerald-50/50">Rs. {{ number_format($day['total_cash_in'], 2) }}</td>
                                            <td class="p-2 border-r border-[#e2ebf3] text-right text-indigo-700 font-semibold">Rs. {{ number_format($day['cash_out_purchases'], 2) }}</td>
                                            <td class="p-2 border-r border-[#e2ebf3] text-right text-amber-700 font-semibold">Rs. {{ number_format($day['cash_out_expenses'], 2) }}</td>
                                            <td class="p-2 border-r border-[#e2ebf3] text-right text-rose-700 font-semibold">Rs. {{ number_format($day['cash_out_payments'], 2) }}</td>
                                            <td class="p-2 border-r border-[#e2ebf3] text-right font-black text-rose-800 bg-rose-50/50">Rs. {{ number_format($day['total_cash_out'], 2) }}</td>
                                            <td class="p-2 text-right font-black text-[#007cb5] bg-[#eaf4fa]/50 text-sm">Rs. {{ number_format($day['closing_cash'], 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="10" class="p-6 text-center text-slate-500">No transactions recorded in selected date range.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ⏱️ CREDIT LIMITS & AGING REPORT TAB -->
                    <div x-show="activeTab === 'credit_limits'" style="display: none;" class="bg-white rounded-lg border-2 border-[#cbd8e4] p-5 shadow-md space-y-3">
                        <div class="flex items-center justify-between pb-2 border-b border-[#cbd8e4]">
                            <div>
                                <h3 class="text-sm font-black text-slate-900 uppercase tracking-wide">⏱️ Party Credit Limit & Time Limit Report</h3>
                                <p class="text-xs text-slate-600 font-medium">Overdue Days & Credit Limit Exceeded Alerts (Warning Highlights)</p>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs border border-[#cbd8e4]">
                                <thead class="bg-[#eaf1f7] text-slate-900 uppercase font-mono font-black border-b-2 border-[#cbd8e4]">
                                    <tr>
                                        <th class="p-2.5 border-r border-[#cbd8e4]">Code</th>
                                        <th class="p-2.5 border-r border-[#cbd8e4]">Party Name</th>
                                        <th class="p-2.5 border-r border-[#cbd8e4]">Type</th>
                                        <th class="p-2.5 border-r border-[#cbd8e4] text-right">Credit Limit (Rs.)</th>
                                        <th class="p-2.5 border-r border-[#cbd8e4] text-center">Time Limit</th>
                                        <th class="p-2.5 border-r border-[#cbd8e4] text-right">Current Balance (Rs.)</th>
                                        <th class="p-2.5 text-center">Credit Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#e2ebf3]">
                                    @forelse($creditLimitReport as $p)
                                        <tr class="{{ $p['is_over_limit'] ? 'bg-amber-100/60 font-bold' : 'hover:bg-[#f6f9fc]' }}">
                                            <td class="p-2.5 border-r border-[#e2ebf3] font-mono font-bold text-[#007cb5]">{{ $p['code'] }}</td>
                                            <td class="p-2.5 border-r border-[#e2ebf3] font-bold text-slate-900">{{ $p['name'] }}</td>
                                            <td class="p-2.5 border-r border-[#e2ebf3]">
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-slate-100 border border-slate-300 text-slate-800">{{ $p['type'] }}</span>
                                            </td>
                                            <td class="p-2.5 border-r border-[#e2ebf3] text-right font-mono text-amber-800 font-bold">
                                                {{ $p['credit_limit'] > 0 ? 'Rs. ' . number_format($p['credit_limit'], 2) : 'Unlimited' }}
                                            </td>
                                            <td class="p-2.5 border-r border-[#e2ebf3] text-center font-mono text-slate-700">{{ $p['credit_days_limit'] }} Days</td>
                                            <td class="p-2.5 border-r border-[#e2ebf3] text-right font-mono font-black text-emerald-800">Rs. {{ number_format($p['current_balance'], 2) }}</td>
                                            <td class="p-2.5 text-center">
                                                @if($p['is_over_limit'])
                                                    <span class="px-2.5 py-0.5 rounded text-[10px] font-black uppercase bg-amber-200 text-amber-900 border border-amber-400">
                                                        ⚠️ OVER LIMIT
                                                    </span>
                                                @else
                                                    <span class="px-2.5 py-0.5 rounded text-[10px] font-black uppercase bg-emerald-100 text-emerald-800 border border-emerald-300">
                                                        ✅ CLEAR / OK
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
                    <div x-show="activeTab === 'parties'" class="bg-white rounded-lg border-2 border-[#cbd8e4] p-5 shadow-md space-y-3">
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-wide">1 All Parties Ledger Summary</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs border border-[#cbd8e4]">
                                <thead class="bg-[#eaf1f7] text-slate-900 uppercase font-mono font-black border-b-2 border-[#cbd8e4]">
                                    <tr>
                                        <th class="p-2.5 border-r border-[#cbd8e4]">Party Code</th>
                                        <th class="p-2.5 border-r border-[#cbd8e4]">Party Name</th>
                                        <th class="p-2.5 border-r border-[#cbd8e4]">Type</th>
                                        <th class="p-2.5 border-r border-[#cbd8e4]">Opening Bal</th>
                                        <th class="p-2.5 border-r border-[#cbd8e4] text-right">Current Closing Balance</th>
                                        <th class="p-2.5 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#e2ebf3]">
                                    @foreach($parties as $party)
                                        <tr class="hover:bg-[#f6f9fc] transition-colors">
                                            <td class="p-2.5 border-r border-[#e2ebf3] font-mono font-bold text-[#007cb5]">{{ $party->code }}</td>
                                            <td class="p-2.5 border-r border-[#e2ebf3] font-bold text-slate-900">{{ $party->name }}</td>
                                            <td class="p-2.5 border-r border-[#e2ebf3]">
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-slate-100 border border-slate-300 text-slate-800">{{ $party->type }}</span>
                                            </td>
                                            <td class="p-2.5 border-r border-[#e2ebf3] font-mono text-slate-700 font-semibold">Rs. {{ number_format($party->opening_balance, 2) }}</td>
                                            <td class="p-2.5 border-r border-[#e2ebf3] text-right font-mono font-black text-emerald-800 text-sm">Rs. {{ number_format($party->current_balance, 2) }}</td>
                                            <td class="p-2.5 text-center">
                                                <a href="{{ route('reports.index', ['party_id' => $party->id, 'from_date' => $fromDate, 'to_date' => $toDate]) }}" class="px-2.5 py-1 rounded bg-[#e8f4fa] hover:bg-[#d0ebf8] text-[#007cb5] text-xs font-bold border border-[#00a2e8] transition-all">
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
                    <div x-show="activeTab === 'medical_reps'" style="display: none;" class="bg-white rounded-lg border-2 border-[#cbd8e4] p-5 shadow-md space-y-3">
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-wide">2 Medical Representatives Report</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs border border-[#cbd8e4]">
                                <thead class="bg-[#eaf1f7] text-slate-900 uppercase font-mono font-black border-b-2 border-[#cbd8e4]">
                                    <tr>
                                        <th class="p-2.5 border-r border-[#cbd8e4] w-12 text-center">#</th>
                                        <th class="p-2.5 border-r border-[#cbd8e4]">Representative Name</th>
                                        <th class="p-2.5 border-r border-[#cbd8e4]">Phone Number</th>
                                        <th class="p-2.5">Assigned Company</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#e2ebf3]">
                                    @forelse($medicalReps as $index => $rep)
                                        <tr class="hover:bg-[#f6f9fc]">
                                            <td class="p-2.5 border-r border-[#e2ebf3] text-center font-mono text-slate-500">{{ $index + 1 }}</td>
                                            <td class="p-2.5 border-r border-[#e2ebf3] font-bold text-slate-900">{{ $rep->name }}</td>
                                            <td class="p-2.5 border-r border-[#e2ebf3] font-mono text-slate-700">{{ $rep->phone ?? 'N/A' }}</td>
                                            <td class="p-2.5 font-semibold text-slate-800">{{ $rep->company_name ?? 'N/A' }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="p-6 text-center text-slate-500">No medical reps found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- 3 COMPANIES TAB -->
                    <div x-show="activeTab === 'companies'" style="display: none;" class="bg-white rounded-lg border-2 border-[#cbd8e4] p-5 shadow-md space-y-3">
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-wide">3 Pharmaceutical Companies Report</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs border border-[#cbd8e4]">
                                <thead class="bg-[#eaf1f7] text-slate-900 uppercase font-mono font-black border-b-2 border-[#cbd8e4]">
                                    <tr>
                                        <th class="p-2.5 border-r border-[#cbd8e4] w-12 text-center">#</th>
                                        <th class="p-2.5 border-r border-[#cbd8e4]">Company Name</th>
                                        <th class="p-2.5 border-r border-[#cbd8e4]">Phone</th>
                                        <th class="p-2.5">City</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#e2ebf3]">
                                    @forelse($companies as $index => $c)
                                        <tr class="hover:bg-[#f6f9fc]">
                                            <td class="p-2.5 border-r border-[#e2ebf3] text-center font-mono text-slate-500">{{ $index + 1 }}</td>
                                            <td class="p-2.5 border-r border-[#e2ebf3] font-bold text-slate-900">{{ $c->name }}</td>
                                            <td class="p-2.5 border-r border-[#e2ebf3] font-mono text-slate-700">{{ $c->phone ?? 'N/A' }}</td>
                                            <td class="p-2.5 text-slate-800">{{ $c->city ?? 'N/A' }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="p-6 text-center text-slate-500">No companies found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- 4 SALESMEN TAB -->
                    <div x-show="activeTab === 'salesmen'" style="display: none;" class="bg-white rounded-lg border-2 border-[#cbd8e4] p-5 shadow-md space-y-3">
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-wide">4 Salesmen Performance & Commission Report</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs border border-[#cbd8e4]">
                                <thead class="bg-[#eaf1f7] text-slate-900 uppercase font-mono font-black border-b-2 border-[#cbd8e4]">
                                    <tr>
                                        <th class="p-2.5 border-r border-[#cbd8e4] w-12 text-center">#</th>
                                        <th class="p-2.5 border-r border-[#cbd8e4]">Salesman Name</th>
                                        <th class="p-2.5 border-r border-[#cbd8e4]">Phone</th>
                                        <th class="p-2.5 text-right">Commission Rate (%)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#e2ebf3]">
                                    @forelse($salesmen as $index => $sm)
                                        <tr class="hover:bg-[#f6f9fc]">
                                            <td class="p-2.5 border-r border-[#e2ebf3] text-center font-mono text-slate-500">{{ $index + 1 }}</td>
                                            <td class="p-2.5 border-r border-[#e2ebf3] font-bold text-slate-900">{{ $sm->name }}</td>
                                            <td class="p-2.5 border-r border-[#e2ebf3] font-mono text-slate-700">{{ $sm->phone ?? 'N/A' }}</td>
                                            <td class="p-2.5 text-right font-mono font-black text-emerald-800">{{ $sm->commission_rate }}%</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="p-6 text-center text-slate-500">No salesmen found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- 5 BANKS TAB -->
                    <div x-show="activeTab === 'banks'" style="display: none;" class="bg-white rounded-lg border-2 border-[#cbd8e4] p-5 shadow-md space-y-3">
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-wide">5 Bank Accounts & Liquidity Report</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs border border-[#cbd8e4]">
                                <thead class="bg-[#eaf1f7] text-slate-900 uppercase font-mono font-black border-b-2 border-[#cbd8e4]">
                                    <tr>
                                        <th class="p-2.5 border-r border-[#cbd8e4] w-12 text-center">#</th>
                                        <th class="p-2.5 border-r border-[#cbd8e4]">Bank Name</th>
                                        <th class="p-2.5 border-r border-[#cbd8e4]">Account Title</th>
                                        <th class="p-2.5 border-r border-[#cbd8e4]">Account Number</th>
                                        <th class="p-2.5 text-right">Balance (Rs.)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#e2ebf3]">
                                    @forelse($banks as $index => $b)
                                        <tr class="hover:bg-[#f6f9fc]">
                                            <td class="p-2.5 border-r border-[#e2ebf3] text-center font-mono text-slate-500">{{ $index + 1 }}</td>
                                            <td class="p-2.5 border-r border-[#e2ebf3] font-bold text-slate-900">{{ $b->bank_name }}</td>
                                            <td class="p-2.5 border-r border-[#e2ebf3] font-semibold text-slate-800">{{ $b->account_title }}</td>
                                            <td class="p-2.5 border-r border-[#e2ebf3] font-mono text-[#007cb5] font-bold">{{ $b->account_number }}</td>
                                            <td class="p-2.5 text-right font-mono font-black text-emerald-800 text-sm">Rs. {{ number_format($b->balance, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="p-6 text-center text-slate-500">No banks found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- 7 AMANATS TAB -->
                    <div x-show="activeTab === 'amanats'" style="display: none;" class="bg-white rounded-lg border-2 border-[#cbd8e4] p-5 shadow-md space-y-3">
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-wide">7 Amanats / Trust Deposits Report</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs border border-[#cbd8e4]">
                                <thead class="bg-[#eaf1f7] text-slate-900 uppercase font-mono font-black border-b-2 border-[#cbd8e4]">
                                    <tr>
                                        <th class="p-2.5 border-r border-[#cbd8e4]">Date</th>
                                        <th class="p-2.5 border-r border-[#cbd8e4]">Depositor / Party</th>
                                        <th class="p-2.5 border-r border-[#cbd8e4]">Details</th>
                                        <th class="p-2.5 text-right">Amanat Amount (Rs.)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#e2ebf3]">
                                    @forelse($amanats as $a)
                                        <tr class="hover:bg-[#f6f9fc]">
                                            <td class="p-2.5 border-r border-[#e2ebf3] font-mono text-slate-700">{{ $a->date }}</td>
                                            <td class="p-2.5 border-r border-[#e2ebf3] font-bold text-slate-900">{{ $a->party->name ?? $a->depositor_name }}</td>
                                            <td class="p-2.5 border-r border-[#e2ebf3] text-slate-800">{{ $a->details ?? 'N/A' }}</td>
                                            <td class="p-2.5 text-right font-mono font-black text-amber-800 text-sm">Rs. {{ number_format($a->amount, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="p-6 text-center text-slate-500">No amanats recorded.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- 8 LOTTERIES TAB -->
                    <div x-show="activeTab === 'lotteries'" style="display: none;" class="bg-white rounded-lg border-2 border-[#cbd8e4] p-5 shadow-md space-y-3">
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-wide">8 Lotteries & Schemes Report</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs border border-[#cbd8e4]">
                                <thead class="bg-[#eaf1f7] text-slate-900 uppercase font-mono font-black border-b-2 border-[#cbd8e4]">
                                    <tr>
                                        <th class="p-2.5 border-r border-[#cbd8e4] w-12 text-center">#</th>
                                        <th class="p-2.5 border-r border-[#cbd8e4]">Scheme Name</th>
                                        <th class="p-2.5 border-r border-[#cbd8e4]">Date</th>
                                        <th class="p-2.5 border-r border-[#cbd8e4]">Status</th>
                                        <th class="p-2.5 text-right">Amount (Rs.)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#e2ebf3]">
                                    @forelse($lotteries as $index => $lot)
                                        <tr class="hover:bg-[#f6f9fc]">
                                            <td class="p-2.5 border-r border-[#e2ebf3] text-center font-mono text-slate-500">{{ $index + 1 }}</td>
                                            <td class="p-2.5 border-r border-[#e2ebf3] font-bold text-slate-900">{{ $lot->scheme_name }}</td>
                                            <td class="p-2.5 border-r border-[#e2ebf3] font-mono text-slate-700">{{ $lot->date ?? 'N/A' }}</td>
                                            <td class="p-2.5 border-r border-[#e2ebf3]">
                                                <span class="px-2 py-0.5 rounded text-[10px] bg-slate-100 border border-slate-300 text-slate-800 uppercase font-bold">{{ $lot->status ?? 'Active' }}</span>
                                            </td>
                                            <td class="p-2.5 text-right font-mono font-black text-emerald-800 text-sm">Rs. {{ number_format($lot->amount, 2) }}</td>
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
