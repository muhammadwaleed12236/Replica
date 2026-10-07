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
            <x-module-nav active="parties" />

            <!-- Compact Header Toolbar -->
            <div class="prowave-glass-card rounded-2xl border border-slate-800 p-3 flex items-center justify-between shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-cyan-500/20 border border-cyan-400/30 flex items-center justify-center text-cyan-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div>
                        <h1 class="text-base font-extrabold text-white font-['Outfit']">Parties & Accounts Directory</h1>
                        <p class="text-[11px] text-slate-400">Total Registered Parties: <span class="text-cyan-300 font-bold font-mono">{{ count($parties) }}</span></p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" @click="showModal = true" class="prowave-btn-primary px-3.5 py-2 rounded-xl text-xs font-bold flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <span>+ Add New Party</span>
                    </button>
                    <a href="{{ route('dashboard') }}" class="prowave-btn-secondary px-3.5 py-2 rounded-xl text-xs font-bold">← Dashboard</a>
                </div>
            </div>

            <!-- Table Card -->
            <div class="prowave-glass-card rounded-2xl border border-slate-800 overflow-hidden shadow-2xl">
                <table class="w-full text-left text-xs text-slate-300">
                    <thead class="bg-slate-900 text-slate-400 uppercase font-mono border-b border-slate-800">
                        <tr>
                            <th class="p-3.5">Party Code</th>
                            <th class="p-3.5">Party Name</th>
                            <th class="p-3.5">Type</th>
                            <th class="p-3.5">Phone / City</th>
                            <th class="p-3.5 text-right">Credit Limit</th>
                            <th class="p-3.5 text-center">Time Limit</th>
                            <th class="p-3.5 text-right">Current Balance (Rs.)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/80">
                        @forelse($parties as $party)
                            <tr class="hover:bg-slate-900/40 transition-colors">
                                <td class="p-3.5 font-mono text-cyan-400 font-bold">{{ $party->code }}</td>
                                <td class="p-3.5 font-bold text-white">{{ $party->name }}</td>
                                <td class="p-3.5">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold uppercase {{ $party->type == 'customer' ? 'bg-cyan-500/10 text-cyan-400 border border-cyan-500/20' : 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' }}">
                                        {{ $party->type }}
                                    </span>
                                </td>
                                <td class="p-3.5">
                                    <span class="font-mono block text-slate-300">{{ $party->phone ?? 'N/A' }}</span>
                                    <span class="text-[10px] text-slate-400">{{ $party->city ?? 'N/A' }}</span>
                                </td>
                                <td class="p-3.5 text-right font-mono text-amber-400 font-bold">
                                    {{ $party->credit_limit > 0 ? 'Rs. ' . number_format($party->credit_limit, 2) : 'No Limit' }}
                                </td>
                                <td class="p-3.5 text-center font-mono text-cyan-300">
                                    {{ $party->credit_days_limit ?? 30 }} Days
                                </td>
                                <td class="p-3.5 text-right font-mono font-bold text-emerald-400">Rs. {{ number_format($party->current_balance, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="p-8 text-center text-slate-500">No parties registered yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        <!-- Add Party Modal with x-cloak & inline style="display:none" -->
        <div x-show="showModal" x-cloak style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md">
            <div @click.away="showModal = false" class="prowave-glass-card rounded-2xl max-w-lg w-full p-6 border border-slate-700 shadow-2xl">
                <div class="flex items-center justify-between pb-3 border-b border-slate-800 mb-4">
                    <h3 class="text-base font-extrabold text-white font-['Outfit']">Register New Party</h3>
                    <button type="button" @click="showModal = false" class="text-slate-400 hover:text-white font-bold">✕</button>
                </div>

                <form method="POST" action="{{ route('parties.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Party Name</label>
                        <input type="text" name="name" required placeholder="e.g. Dawn Pharmacy" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Type</label>
                        <select name="type" required class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs">
                            <option value="customer">Customer</option>
                            <option value="supplier">Supplier</option>
                            <option value="both">Both</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Phone</label>
                            <input type="text" name="phone" placeholder="0300-1234567" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-mono" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-300 mb-1">City</label>
                            <input type="text" name="city" placeholder="Lahore" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs" />
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-slate-300 mb-1">Opening Bal (Rs.)</label>
                            <input type="number" step="0.01" name="opening_balance" value="0" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-mono text-emerald-400 font-bold" />
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-slate-300 mb-1">Credit Limit (Rs.)</label>
                            <input type="number" step="0.01" name="credit_limit" value="0" placeholder="0 = Unlimited" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-mono text-amber-400 font-bold" />
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-slate-300 mb-1">Time Limit (Days)</label>
                            <input type="number" name="credit_days_limit" value="30" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-mono text-cyan-300 font-bold" />
                        </div>
                    </div>
                    <div class="pt-3 flex justify-end gap-3">
                        <button type="button" @click="showModal = false" class="prowave-btn-secondary px-4 py-2 rounded-xl text-xs font-bold">Cancel</button>
                        <button type="submit" class="prowave-btn-primary px-5 py-2 rounded-xl text-xs font-bold">Save Party</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
