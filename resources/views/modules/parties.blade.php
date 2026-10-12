<x-app-layout>
    <div class="py-4" x-data="{ showModal: false }">
        <div class="max-w-6xl mx-auto px-2 sm:px-4 space-y-3">

            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: '{{ session('success') }}',
                            timer: 2500,
                            timerProgressBar: true,
                            confirmButtonColor: '#00a2e8'
                        });
                    });
                </script>
            @endif

            <!-- Module Navigation Bar -->
            <x-module-nav active="parties" />

            <!-- DAWN Form / Master Window Card -->
            <div class="bg-white border-2 border-[#0092d0] rounded-lg shadow-xl overflow-hidden font-sans">
                <!-- DAWN Header Component for Parties -->
                <x-dawn-header 
                    title="1 Parties & Accounts" 
                    icon="users" 
                    :exitRoute="route('dashboard')"
                />

                <!-- Table & Actions Container -->
                <div class="p-4 bg-[#eaf0f6] space-y-3">
                    
                    <!-- Search & Action Strip -->
                    <div class="bg-[#f5f8fb] p-3 rounded border border-[#c3d1df] flex flex-wrap items-center justify-between gap-3 shadow-inner">
                        <div>
                            <span class="text-xs font-black text-slate-800 uppercase tracking-wider">Registered Accounts:</span>
                            <span class="ml-1 text-sm font-bold font-mono text-[#007cb5]">{{ count($parties) }} Parties</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" @click="showModal = true" class="px-3.5 py-1.5 rounded bg-[#00a2e8] hover:bg-[#008ecb] text-white font-extrabold text-xs shadow-sm flex items-center gap-1.5 transition-all">
                                <span class="text-base leading-none font-black">+</span> Register New Party
                            </button>
                            <a href="{{ route('dashboard') }}" class="px-3 py-1.5 rounded bg-white hover:bg-slate-100 border border-[#c3d1df] text-slate-800 font-bold text-xs shadow-sm">
                                ← Dashboard
                            </a>
                        </div>
                    </div>

                    <!-- Table Card -->
                    <div class="bg-white rounded border border-[#c3d1df] overflow-x-auto shadow-sm">
                        <table class="w-full text-left text-xs border border-[#cbd8e4]">
                            <thead class="bg-[#eaf1f7] text-slate-800 uppercase font-mono font-bold border-b border-[#cbd8e4]">
                                <tr>
                                    <th class="p-2.5 border-r border-[#cbd8e4]">Party Code</th>
                                    <th class="p-2.5 border-r border-[#cbd8e4]">Party Name</th>
                                    <th class="p-2.5 border-r border-[#cbd8e4]">Type</th>
                                    <th class="p-2.5 border-r border-[#cbd8e4]">Phone / City</th>
                                    <th class="p-2.5 border-r border-[#cbd8e4] text-right">Credit Limit</th>
                                    <th class="p-2.5 border-r border-[#cbd8e4] text-center">Time Limit</th>
                                    <th class="p-2.5 text-right">Current Balance (Rs.)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#e2ebf3]">
                                @forelse($parties as $party)
                                    <tr class="hover:bg-[#f6f9fc] transition-colors">
                                        <td class="p-2.5 border-r border-[#e2ebf3] font-mono text-[#007cb5] font-bold">{{ $party->code }}</td>
                                        <td class="p-2.5 border-r border-[#e2ebf3] font-bold text-slate-900">{{ $party->name }}</td>
                                        <td class="p-2.5 border-r border-[#e2ebf3]">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $party->type == 'customer' ? 'bg-[#e8f4fa] text-[#007cb5] border border-[#00a2e8]' : 'bg-slate-100 text-slate-800 border border-slate-300' }}">
                                                {{ $party->type }}
                                            </span>
                                        </td>
                                        <td class="p-2.5 border-r border-[#e2ebf3]">
                                            <span class="font-mono block text-slate-800">{{ $party->phone ?? 'N/A' }}</span>
                                            <span class="text-[10px] text-slate-500">{{ $party->city ?? 'N/A' }}</span>
                                        </td>
                                        <td class="p-2.5 border-r border-[#e2ebf3] text-right font-mono text-amber-700 font-bold">
                                            {{ $party->credit_limit > 0 ? 'Rs. ' . number_format($party->credit_limit, 2) : 'No Limit' }}
                                        </td>
                                        <td class="p-2.5 border-r border-[#e2ebf3] text-center font-mono text-slate-700">
                                            {{ $party->credit_days_limit ?? 30 }} Days
                                        </td>
                                        <td class="p-2.5 text-right font-mono font-bold text-emerald-700">Rs. {{ number_format($party->current_balance, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="p-8 text-center text-slate-500">No parties registered yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>

        <!-- Add Party Modal -->
        <div x-show="showModal" x-cloak style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
            <div @click.away="showModal = false" class="bg-white rounded-lg max-w-lg w-full border-2 border-[#0092d0] shadow-2xl overflow-hidden">
                <div class="bg-[#00a2e8] text-white p-3.5 flex items-center justify-between">
                    <h3 class="text-base font-extrabold font-sans">Register New Party</h3>
                    <button type="button" @click="showModal = false" class="text-white hover:text-slate-200 font-bold text-lg leading-none">✕</button>
                </div>

                <form method="POST" action="{{ route('parties.store') }}" class="p-5 space-y-4 bg-[#f6f9fc]">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-800 mb-1">Party Name</label>
                        <input type="text" name="name" required placeholder="e.g. Dawn Pharmacy" class="w-full px-3 py-1.5 rounded bg-white border border-[#9ab3c9] focus:border-[#00a2e8] text-slate-900 text-xs" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-800 mb-1">Type</label>
                        <select name="type" required class="w-full px-3 py-1.5 rounded bg-white border border-[#9ab3c9] focus:border-[#00a2e8] text-slate-900 text-xs">
                            <option value="customer">Customer</option>
                            <option value="supplier">Supplier</option>
                            <option value="both">Both</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-800 mb-1">Phone</label>
                            <input type="text" name="phone" placeholder="0300-1234567" class="w-full px-3 py-1.5 rounded bg-white border border-[#9ab3c9] focus:border-[#00a2e8] text-slate-900 text-xs font-mono" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-800 mb-1">City</label>
                            <input type="text" name="city" placeholder="Lahore" class="w-full px-3 py-1.5 rounded bg-white border border-[#9ab3c9] focus:border-[#00a2e8] text-slate-900 text-xs" />
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-slate-800 mb-1">Opening Bal (Rs.)</label>
                            <input type="number" step="0.01" name="opening_balance" value="0" class="w-full px-2.5 py-1.5 rounded bg-white border border-[#9ab3c9] focus:border-[#00a2e8] text-slate-900 text-xs font-mono text-emerald-700 font-bold" />
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-slate-800 mb-1">Credit Limit (Rs.)</label>
                            <input type="number" step="0.01" name="credit_limit" value="0" placeholder="0 = Unlimited" class="w-full px-2.5 py-1.5 rounded bg-white border border-[#9ab3c9] focus:border-[#00a2e8] text-slate-900 text-xs font-mono text-amber-700 font-bold" />
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-slate-800 mb-1">Time Limit (Days)</label>
                            <input type="number" name="credit_days_limit" value="30" class="w-full px-2.5 py-1.5 rounded bg-white border border-[#9ab3c9] focus:border-[#00a2e8] text-slate-900 text-xs font-mono text-[#007cb5] font-bold" />
                        </div>
                    </div>
                    <div class="pt-3 flex justify-end gap-2 border-t border-[#cbd8e4]">
                        <button type="button" @click="showModal = false" class="px-4 py-1.5 bg-slate-200 hover:bg-slate-300 text-slate-800 rounded text-xs font-bold">Cancel</button>
                        <button type="submit" class="px-5 py-1.5 bg-[#00a2e8] hover:bg-[#008ecb] text-white rounded text-xs font-black shadow-sm">Save Party</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
