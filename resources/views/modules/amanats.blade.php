<x-app-layout>
    <div class="py-6" x-data="{ showModal: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Module Navigation Bar -->
            <x-module-nav active="amanats" />

            <div class="prowave-glass-card rounded-2xl border border-slate-800 p-3.5 flex items-center justify-between shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/20 border border-amber-400/30 flex items-center justify-center text-amber-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h1 class="text-base font-extrabold text-white font-['Outfit']">7 Amanats / Trust Deposits</h1>
                        <p class="text-[11px] text-slate-400">Total Amanat Records: <span class="text-amber-300 font-bold font-mono">{{ count($amanats) }}</span></p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" @click="showModal = true" class="prowave-btn-primary px-3.5 py-2 rounded-xl text-xs font-bold">
                        + Record Amanat Deposit
                    </button>
                    <a href="{{ route('dashboard') }}" class="prowave-btn-secondary px-3.5 py-2 rounded-xl text-xs font-bold">← Dashboard</a>
                </div>
            </div>

            <div class="prowave-glass-card rounded-2xl border border-slate-800 overflow-hidden shadow-2xl">
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
                            <tr><td colspan="4" class="p-8 text-center text-slate-500">No amanat deposits recorded yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        <div x-show="showModal" x-cloak style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md">
            <div @click.away="showModal = false" class="prowave-glass-card rounded-2xl max-w-lg w-full p-6 border border-slate-700 shadow-2xl">
                <div class="flex items-center justify-between pb-3 border-b border-slate-800 mb-4">
                    <h3 class="text-base font-extrabold text-white font-['Outfit']">Record Amanat Deposit</h3>
                    <button type="button" @click="showModal = false" class="text-slate-400 hover:text-white font-bold">✕</button>
                </div>

                <form method="POST" action="{{ route('amanats.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Select Party</label>
                        <select name="party_id" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs">
                            <option value="">-- Or enter custom depositor name below --</option>
                            @foreach($parties as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Depositor Name</label>
                        <input type="text" name="depositor_name" placeholder="Full Depositor Name" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Amount (Rs.)</label>
                            <input type="number" step="0.01" name="amount" required class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-mono text-amber-400 font-bold" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Date</label>
                            <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-mono" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Details / Notes</label>
                        <textarea name="details" rows="2" placeholder="Deposit notes..." class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs"></textarea>
                    </div>
                    <div class="pt-3 flex justify-end gap-3">
                        <button type="button" @click="showModal = false" class="prowave-btn-secondary px-4 py-2 rounded-xl text-xs font-bold">Cancel</button>
                        <button type="submit" class="prowave-btn-primary px-5 py-2 rounded-xl text-xs font-bold">Save Amanat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
