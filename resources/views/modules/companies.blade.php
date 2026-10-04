<x-app-layout>
    <div class="py-6" x-data="{ showModal: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Module Navigation Bar -->
            <x-module-nav active="companies" />

            <div class="prowave-glass-card rounded-2xl border border-slate-800 p-3.5 flex items-center justify-between shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-500/20 border border-purple-400/30 flex items-center justify-center text-purple-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <h1 class="text-base font-extrabold text-white font-['Outfit']">3 Pharmaceutical Companies</h1>
                        <p class="text-[11px] text-slate-400">Total Manufacturers: <span class="text-purple-300 font-bold font-mono">{{ count($companies) }}</span></p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" @click="showModal = true" class="prowave-btn-primary px-3.5 py-2 rounded-xl text-xs font-bold">
                        + Add Company
                    </button>
                    <a href="{{ route('dashboard') }}" class="prowave-btn-secondary px-3.5 py-2 rounded-xl text-xs font-bold">← Dashboard</a>
                </div>
            </div>

            <div class="prowave-glass-card rounded-2xl border border-slate-800 overflow-hidden shadow-2xl">
                <table class="w-full text-left text-xs text-slate-300">
                    <thead class="bg-slate-900 text-slate-400 uppercase font-mono border-b border-slate-800">
                        <tr>
                            <th class="p-3.5">#</th>
                            <th class="p-3.5">Company Name</th>
                            <th class="p-3.5">Contact Phone</th>
                            <th class="p-3.5">City / Location</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/80">
                        @forelse($companies as $index => $comp)
                            <tr class="hover:bg-slate-900/40">
                                <td class="p-3.5 font-mono text-slate-500">{{ $index + 1 }}</td>
                                <td class="p-3.5 font-bold text-white">{{ $comp->name }}</td>
                                <td class="p-3.5 font-mono text-cyan-300">{{ $comp->phone ?? 'N/A' }}</td>
                                <td class="p-3.5">{{ $comp->city ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="p-8 text-center text-slate-500">No companies registered yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        <div x-show="showModal" x-cloak style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md">
            <div @click.away="showModal = false" class="prowave-glass-card rounded-2xl max-w-lg w-full p-6 border border-slate-700 shadow-2xl">
                <div class="flex items-center justify-between pb-3 border-b border-slate-800 mb-4">
                    <h3 class="text-base font-extrabold text-white font-['Outfit']">Add Manufacturer Company</h3>
                    <button type="button" @click="showModal = false" class="text-slate-400 hover:text-white font-bold">✕</button>
                </div>

                <form method="POST" action="{{ route('companies.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Company Name</label>
                        <input type="text" name="name" required placeholder="e.g. GlaxoSmithKline" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Phone</label>
                            <input type="text" name="phone" placeholder="021-111-475" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-mono" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-300 mb-1">City</label>
                            <input type="text" name="city" placeholder="Karachi" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs" />
                        </div>
                    </div>
                    <div class="pt-3 flex justify-end gap-3">
                        <button type="button" @click="showModal = false" class="prowave-btn-secondary px-4 py-2 rounded-xl text-xs font-bold">Cancel</button>
                        <button type="submit" class="prowave-btn-primary px-5 py-2 rounded-xl text-xs font-bold">Save Company</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
