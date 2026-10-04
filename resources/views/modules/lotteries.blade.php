<x-app-layout>
    <div class="py-6" x-data="{ showModal: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-semibold flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Module Navigation Bar -->
            <x-module-nav active="lotteries" />

            <!-- Compact Header Toolbar -->
            <div class="prowave-glass-card rounded-2xl border border-slate-800 p-3 flex items-center justify-between shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-sky-500/20 border border-sky-400/30 flex items-center justify-center text-sky-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H5z"/></svg>
                    </div>
                    <div>
                        <h1 class="text-base font-extrabold text-white font-['Outfit']">8 Lotteries & Schemes Directory</h1>
                        <p class="text-[11px] text-slate-400">Total Active Schemes: <span class="text-sky-300 font-bold font-mono">{{ count($lotteries) }}</span></p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" @click="showModal = true" class="prowave-btn-primary px-3.5 py-2 rounded-xl text-xs font-bold flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <span>+ Add Lottery Scheme</span>
                    </button>
                    <a href="{{ route('dashboard') }}" class="prowave-btn-secondary px-3.5 py-2 rounded-xl text-xs font-bold">← Dashboard</a>
                </div>
            </div>

            <!-- Table Card -->
            <div class="prowave-glass-card rounded-2xl border border-slate-800 overflow-hidden shadow-2xl">
                <table class="w-full text-left text-xs text-slate-300">
                    <thead class="bg-slate-900 text-slate-400 uppercase font-mono border-b border-slate-800">
                        <tr>
                            <th class="p-3.5">#</th>
                            <th class="p-3.5">Scheme Name</th>
                            <th class="p-3.5">Date</th>
                            <th class="p-3.5">Status</th>
                            <th class="p-3.5">Remarks</th>
                            <th class="p-3.5 text-right">Amount (Rs.)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/80">
                        @forelse($lotteries as $index => $lottery)
                            <tr class="hover:bg-slate-900/40 transition-colors">
                                <td class="p-3.5 font-mono text-slate-500">{{ $index + 1 }}</td>
                                <td class="p-3.5 font-bold text-white">{{ $lottery->scheme_name }}</td>
                                <td class="p-3.5 font-mono text-slate-400">{{ $lottery->date ?? 'N/A' }}</td>
                                <td class="p-3.5">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold uppercase bg-sky-500/10 text-sky-400 border border-sky-500/20">
                                        {{ $lottery->status ?? 'Active' }}
                                    </span>
                                </td>
                                <td class="p-3.5 text-slate-400">{{ $lottery->remarks ?? 'N/A' }}</td>
                                <td class="p-3.5 text-right font-mono font-bold text-emerald-400">Rs. {{ number_format($lottery->amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="p-8 text-center text-slate-500">No lottery schemes recorded yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        <!-- Add Lottery Scheme Modal -->
        <div x-show="showModal" x-cloak style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md">
            <div @click.away="showModal = false" class="prowave-glass-card rounded-2xl max-w-lg w-full p-6 border border-slate-700 shadow-2xl">
                <div class="flex items-center justify-between pb-3 border-b border-slate-800 mb-4">
                    <h3 class="text-base font-extrabold text-white font-['Outfit']">Create New Lottery Scheme</h3>
                    <button type="button" @click="showModal = false" class="text-slate-400 hover:text-white font-bold">✕</button>
                </div>

                <form method="POST" action="{{ route('lotteries.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Scheme Name</label>
                        <input type="text" name="scheme_name" required placeholder="e.g. Monthly Bumper Scheme" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Amount (Rs.)</label>
                            <input type="number" step="0.01" name="amount" required placeholder="50000" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-mono text-emerald-400 font-bold" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Date</label>
                            <input type="date" name="date" value="{{ date('Y-m-d') }}" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-mono" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Remarks / Details</label>
                        <input type="text" name="remarks" placeholder="Optional notes..." class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs" />
                    </div>
                    <div class="pt-3 flex justify-end gap-3">
                        <button type="button" @click="showModal = false" class="prowave-btn-secondary px-4 py-2 rounded-xl text-xs font-bold">Cancel</button>
                        <button type="submit" class="prowave-btn-primary px-5 py-2 rounded-xl text-xs font-bold">Save Scheme</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
