<x-app-layout>
    <div class="py-4" x-data="{ showModal: false }">
        <div class="max-w-7xl mx-auto px-2 sm:px-4 space-y-3 font-sans">

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
            <x-module-nav active="banks" />

            <!-- DAWN Top Header Banner -->
            <div class="w-full bg-[#00a2e8] select-none shadow-md rounded-lg overflow-hidden border border-[#008ecb]">
                <div class="px-4 py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-2 bg-[#008cc9]/70 border border-white/50 px-3 py-1.5 rounded-lg text-black">
                            <span class="text-xl">🏦</span>
                            <h1 class="text-lg font-black tracking-normal font-sans">5 Bank Accounts & Liquidity</h1>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" @click="showModal = true" class="px-3.5 py-1.5 rounded bg-white hover:bg-[#f0f4f8] text-slate-900 text-xs font-black flex items-center gap-1.5 shadow-sm border border-white/60 transition-all">
                            <span class="text-base leading-none text-[#007cb5] font-black">+</span>
                            <span>Add Bank Account</span>
                        </button>
                        <a href="{{ route('dashboard') }}" class="px-3 py-1.5 rounded bg-white/20 hover:bg-white/30 text-black text-xs font-bold border border-white/40 transition-all">
                            ← Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-lg border-2 border-[#cbd8e4] p-4 shadow-md space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-[#cbd8e4]">
                    <div>
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-wide">Registered Commercial Bank Accounts</h3>
                        <p class="text-xs text-slate-600 font-medium">Bank accounts roster, titles, and live book liquidity balances</p>
                    </div>
                    <span class="text-xs font-mono text-[#007cb5] bg-[#eaf4fa] border border-[#00a2e8] px-2.5 py-1 rounded font-bold">
                        Total: {{ count($banks) }} Accounts
                    </span>
                </div>

                <div class="overflow-x-auto rounded border border-[#cbd8e4]">
                    <table class="w-full text-left text-xs border border-[#cbd8e4]">
                        <thead class="bg-[#eaf1f7] text-slate-900 uppercase font-mono font-black border-b-2 border-[#cbd8e4]">
                            <tr>
                                <th class="p-2.5 border-r border-[#cbd8e4] w-12 text-center">#</th>
                                <th class="p-2.5 border-r border-[#cbd8e4]">Bank Name</th>
                                <th class="p-2.5 border-r border-[#cbd8e4]">Account Title</th>
                                <th class="p-2.5 border-r border-[#cbd8e4]">Account Number</th>
                                <th class="p-2.5 text-right font-black">Current Balance (Rs.)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#e2ebf3]">
                            @forelse($banks as $index => $b)
                                <tr class="hover:bg-[#f6f9fc] transition-colors">
                                    <td class="p-2.5 border-r border-[#e2ebf3] text-center font-mono text-slate-500">{{ $index + 1 }}</td>
                                    <td class="p-2.5 border-r border-[#e2ebf3] font-bold text-slate-900">{{ $b->bank_name }}</td>
                                    <td class="p-2.5 border-r border-[#e2ebf3] font-semibold text-slate-800">{{ $b->account_title }}</td>
                                    <td class="p-2.5 border-r border-[#e2ebf3] font-mono text-[#007cb5] font-bold">{{ $b->account_number }}</td>
                                    <td class="p-2.5 text-right font-mono font-black text-sm text-emerald-700">Rs. {{ number_format($b->balance, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-6 text-center text-slate-500">No bank accounts registered yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Add Bank Modal -->
        <div x-show="showModal" x-cloak style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
            <div @click.away="showModal = false" class="bg-white rounded-lg max-w-lg w-full border-2 border-[#0092d0] shadow-2xl overflow-hidden font-sans">
                <div class="bg-[#00a2e8] text-white p-3.5 flex items-center justify-between">
                    <h3 class="text-base font-extrabold font-sans">Add Bank Account</h3>
                    <button type="button" @click="showModal = false" class="text-white hover:text-slate-200 font-bold text-lg leading-none">✕</button>
                </div>

                <form method="POST" action="{{ route('banks.store') }}" class="p-5 space-y-4 bg-[#f6f9fc]">
                    @csrf
                    <div>
                        <label class="block text-xs font-black uppercase text-slate-800 mb-1">Bank Name</label>
                        <input type="text" name="bank_name" required placeholder="e.g. Meezan Bank / HBL / MCB" class="w-full px-3 py-2 rounded bg-white border border-[#9ab3c9] focus:border-[#00a2e8] text-slate-900 text-xs font-bold shadow-sm" />
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase text-slate-800 mb-1">Account Title</label>
                        <input type="text" name="account_title" required placeholder="e.g. DAWN Pharmacy Main" class="w-full px-3 py-2 rounded bg-white border border-[#9ab3c9] focus:border-[#00a2e8] text-slate-900 text-xs font-bold shadow-sm" />
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-black uppercase text-slate-800 mb-1">Account Number / IBAN</label>
                            <input type="text" name="account_number" placeholder="PK00MEZN00..." class="w-full px-3 py-2 rounded bg-white border border-[#9ab3c9] focus:border-[#00a2e8] text-slate-900 text-xs font-mono font-bold shadow-sm" />
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase text-slate-800 mb-1">Initial Balance (Rs.)</label>
                            <input type="number" step="0.01" name="balance" value="0.00" class="w-full px-3 py-2 rounded bg-white border border-[#9ab3c9] focus:border-[#00a2e8] text-slate-900 text-xs font-mono font-bold text-emerald-700 shadow-sm" />
                        </div>
                    </div>

                    <div class="pt-3 flex justify-end gap-2 border-t border-[#cbd8e4]">
                        <button type="button" @click="showModal = false" class="px-4 py-1.5 bg-slate-200 hover:bg-slate-300 text-slate-800 rounded text-xs font-bold">Cancel</button>
                        <button type="submit" class="px-5 py-1.5 bg-[#00a2e8] hover:bg-[#008ecb] text-white rounded text-xs font-black shadow-sm">Save Bank Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
