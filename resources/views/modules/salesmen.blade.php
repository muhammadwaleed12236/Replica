<x-app-layout>
    <div class="py-6" x-data="{ showModal: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Module Navigation Bar -->
            <x-module-nav active="salesmen" />

            <div class="prowave-glass-card rounded-2xl border border-slate-800 p-3.5 flex items-center justify-between shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-cyan-500/20 border border-cyan-400/30 flex items-center justify-center text-cyan-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <h1 class="text-base font-extrabold text-white font-['Outfit']">4 Salesmen Force</h1>
                        <p class="text-[11px] text-slate-400">Total Active Salesmen: <span class="text-cyan-300 font-bold font-mono">{{ count($salesmen) }}</span></p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" @click="showModal = true" class="prowave-btn-primary px-3.5 py-2 rounded-xl text-xs font-bold">
                        + Add Salesman
                    </button>
                    <a href="{{ route('dashboard') }}" class="prowave-btn-secondary px-3.5 py-2 rounded-xl text-xs font-bold">← Dashboard</a>
                </div>
            </div>

            <div class="prowave-glass-card rounded-2xl border border-slate-800 overflow-hidden shadow-2xl">
                <table class="w-full text-left text-xs text-slate-300">
                    <thead class="bg-slate-900 text-slate-400 uppercase font-mono border-b border-slate-800">
                        <tr>
                            <th class="p-3.5">#</th>
                            <th class="p-3.5">Salesman Name</th>
                            <th class="p-3.5">Phone Number</th>
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
                            <tr><td colspan="4" class="p-8 text-center text-slate-500">No salesmen registered yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        <div x-show="showModal" x-cloak style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md">
            <div @click.away="showModal = false" class="prowave-glass-card rounded-2xl max-w-lg w-full p-6 border border-slate-700 shadow-2xl">
                <div class="flex items-center justify-between pb-3 border-b border-slate-800 mb-4">
                    <h3 class="text-base font-extrabold text-white font-['Outfit']">Add Sales Representative</h3>
                    <button type="button" @click="showModal = false" class="text-slate-400 hover:text-white font-bold">✕</button>
                </div>

                <form method="POST" action="{{ route('salesmen.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Salesman Name</label>
                        <input type="text" name="name" required placeholder="e.g. Tariq Mehmood" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Phone</label>
                            <input type="text" name="phone" placeholder="0300-9988776" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-mono" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Commission Rate (%)</label>
                            <input type="number" step="0.1" name="commission_rate" value="2.5" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-mono" />
                        </div>
                    </div>
                    <div class="pt-3 flex justify-end gap-3">
                        <button type="button" @click="showModal = false" class="prowave-btn-secondary px-4 py-2 rounded-xl text-xs font-bold">Cancel</button>
                        <button type="submit" class="prowave-btn-primary px-5 py-2 rounded-xl text-xs font-bold">Save Salesman</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
