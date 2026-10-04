<x-app-layout>
    <div class="py-6" x-data="{ showModal: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Module Navigation Bar -->
            <x-module-nav active="medical_reps" />

            <div class="prowave-glass-card rounded-2xl border border-slate-800 p-3.5 flex items-center justify-between shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/20 border border-indigo-400/30 flex items-center justify-center text-indigo-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <h1 class="text-base font-extrabold text-white font-['Outfit']">2 Medical Representatives</h1>
                        <p class="text-[11px] text-slate-400">Total Medical Reps: <span class="text-indigo-300 font-bold font-mono">{{ count($medicalReps) }}</span></p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" @click="showModal = true" class="prowave-btn-primary px-3.5 py-2 rounded-xl text-xs font-bold">
                        + Add Medical Rep
                    </button>
                    <a href="{{ route('dashboard') }}" class="prowave-btn-secondary px-3.5 py-2 rounded-xl text-xs font-bold">← Dashboard</a>
                </div>
            </div>

            <div class="prowave-glass-card rounded-2xl border border-slate-800 overflow-hidden shadow-2xl">
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
                            <tr><td colspan="4" class="p-8 text-center text-slate-500">No medical representatives registered.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        <div x-show="showModal" x-cloak style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md">
            <div @click.away="showModal = false" class="prowave-glass-card rounded-2xl max-w-lg w-full p-6 border border-slate-700 shadow-2xl">
                <div class="flex items-center justify-between pb-3 border-b border-slate-800 mb-4">
                    <h3 class="text-base font-extrabold text-white font-['Outfit']">Add Medical Representative</h3>
                    <button type="button" @click="showModal = false" class="text-slate-400 hover:text-white font-bold">✕</button>
                </div>

                <form method="POST" action="{{ route('medical_reps.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Rep Name</label>
                        <input type="text" name="name" required placeholder="e.g. Bilal Ahmed" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Phone Number</label>
                        <input type="text" name="phone" placeholder="0300-1122334" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-mono" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Company Name</label>
                        <input type="text" name="company_name" placeholder="e.g. Getz Pharma" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs" />
                    </div>
                    <div class="pt-3 flex justify-end gap-3">
                        <button type="button" @click="showModal = false" class="prowave-btn-secondary px-4 py-2 rounded-xl text-xs font-bold">Cancel</button>
                        <button type="submit" class="prowave-btn-primary px-5 py-2 rounded-xl text-xs font-bold">Save Representative</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
