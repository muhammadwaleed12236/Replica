<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-rose-600 to-indigo-700 rounded-2xl p-5 shadow-2xl flex items-center justify-between border border-rose-400/30">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-white">
                    <svg class="w-7 h-7 text-rose-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold text-white font-['Outfit']">6 Expenses Tracker</h1>
                    <p class="text-xs text-rose-200">Record Operational Expenses & Bills</p>
                </div>
            </div>
            <a href="{{ route('dashboard') }}" class="prowave-btn-secondary px-4 py-2 rounded-xl text-xs font-bold">← Dashboard</a>
        </div>
    </x-slot>

    <div class="py-8" x-data="{ showModal: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Module Navigation Bar -->
            <x-module-nav active="expenses" />

            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-white font-['Outfit']">Expense Vouchers Log</h3>
                <button type="button" @click="showModal = true" class="prowave-btn-primary px-4 py-2.5 rounded-xl text-xs font-bold flex items-center gap-2">
                    + Record Expense
                </button>
            </div>

            <div class="prowave-glass-card rounded-2xl border border-slate-800 overflow-hidden shadow-2xl">
                <table class="w-full text-left text-xs text-slate-300">
                    <thead class="bg-slate-900 text-slate-400 uppercase font-mono border-b border-slate-800">
                        <tr>
                            <th class="p-4">Date</th>
                            <th class="p-4">Expense Title</th>
                            <th class="p-4">Category</th>
                            <th class="p-4">Remarks</th>
                            <th class="p-4 text-right">Amount (Rs.)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/80">
                        @forelse($expenses as $exp)
                            <tr class="hover:bg-slate-900/40">
                                <td class="p-4 font-mono text-slate-400">{{ $exp->date }}</td>
                                <td class="p-4 font-bold text-white">{{ $exp->title }}</td>
                                <td class="p-4"><span class="px-2.5 py-1 rounded-full text-[10px] bg-rose-500/10 text-rose-400 border border-rose-500/20 font-semibold uppercase">{{ $exp->category }}</span></td>
                                <td class="p-4 text-slate-400">{{ $exp->remarks ?? 'N/A' }}</td>
                                <td class="p-4 text-right font-mono font-bold text-rose-400">Rs. {{ number_format($exp->amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="p-8 text-center text-slate-500">No expenses recorded yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        <div x-show="showModal" x-cloak style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md">
            <div @click.away="showModal = false" class="prowave-glass-card rounded-2xl max-w-lg w-full p-6 border border-slate-700 shadow-2xl">
                <h3 class="text-lg font-bold text-white font-['Outfit'] mb-4">Record New Expense</h3>
                <form method="POST" action="{{ route('expenses.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Expense Title</label>
                        <input type="text" name="title" required placeholder="e.g. Office Electricity Bill" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-sm" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Amount (Rs.)</label>
                            <input type="number" step="0.01" name="amount" required class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-sm font-mono" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Date</label>
                            <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-sm font-mono" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Category</label>
                        <input type="text" name="category" placeholder="Utilities, Rent, Salaries, Fuel..." class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-sm" />
                    </div>
                    <div class="pt-3 flex justify-end gap-3">
                        <button type="button" @click="showModal = false" class="prowave-btn-secondary px-4 py-2 rounded-xl text-xs font-bold">Cancel</button>
                        <button type="submit" class="prowave-btn-primary px-5 py-2 rounded-xl text-xs font-bold">Save Expense</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
