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
            <x-module-nav active="expenses" />

            <!-- DAWN Top Header Banner -->
            <div class="w-full bg-[#00a2e8] select-none shadow-md rounded-lg overflow-hidden border border-[#008ecb]">
                <div class="px-4 py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-2 bg-[#008cc9]/70 border border-white/50 px-3 py-1.5 rounded-lg text-black">
                            <span class="text-xl">🧾</span>
                            <h1 class="text-lg font-black tracking-normal font-sans">6 Expenses Tracker</h1>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" @click="showModal = true" class="px-3.5 py-1.5 rounded bg-white hover:bg-[#f0f4f8] text-slate-900 text-xs font-black flex items-center gap-1.5 shadow-sm border border-white/60 transition-all">
                            <span class="text-base leading-none text-[#007cb5] font-black">+</span>
                            <span>Record Expense</span>
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
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-wide">Expense Vouchers Log</h3>
                        <p class="text-xs text-slate-600 font-medium">Record and review office and operational utility/general expenses</p>
                    </div>
                    <span class="text-xs font-mono text-[#007cb5] bg-[#eaf4fa] border border-[#00a2e8] px-2.5 py-1 rounded font-bold">
                        Total: {{ count($expenses) }} Expenses
                    </span>
                </div>

                <div class="overflow-x-auto rounded border border-[#cbd8e4]">
                    <table class="w-full text-left text-xs border border-[#cbd8e4]">
                        <thead class="bg-[#eaf1f7] text-slate-900 uppercase font-mono font-black border-b-2 border-[#cbd8e4]">
                            <tr>
                                <th class="p-2.5 border-r border-[#cbd8e4]">Date</th>
                                <th class="p-2.5 border-r border-[#cbd8e4]">Expense Title</th>
                                <th class="p-2.5 border-r border-[#cbd8e4]">Category</th>
                                <th class="p-2.5 border-r border-[#cbd8e4]">Remarks</th>
                                <th class="p-2.5 text-right font-black">Amount (Rs.)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#e2ebf3]">
                            @forelse($expenses as $exp)
                                <tr class="hover:bg-[#f6f9fc] transition-colors">
                                    <td class="p-2.5 border-r border-[#e2ebf3] font-mono text-slate-700 font-semibold">{{ $exp->date }}</td>
                                    <td class="p-2.5 border-r border-[#e2ebf3] font-bold text-slate-900">{{ $exp->title }}</td>
                                    <td class="p-2.5 border-r border-[#e2ebf3]">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-amber-100 border border-amber-300 text-amber-900">
                                            {{ $exp->category }}
                                        </span>
                                    </td>
                                    <td class="p-2.5 border-r border-[#e2ebf3] text-slate-700">{{ $exp->remarks ?? 'N/A' }}</td>
                                    <td class="p-2.5 text-right font-mono font-black text-sm text-rose-700">
                                        Rs. {{ number_format($exp->amount, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-6 text-center text-slate-500">No expenses recorded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Add Expense Modal -->
        <div x-show="showModal" x-cloak style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
            <div @click.away="showModal = false" class="bg-white rounded-lg max-w-lg w-full border-2 border-[#0092d0] shadow-2xl overflow-hidden font-sans">
                <div class="bg-[#00a2e8] text-white p-3.5 flex items-center justify-between">
                    <h3 class="text-base font-extrabold font-sans">Record New Expense</h3>
                    <button type="button" @click="showModal = false" class="text-white hover:text-slate-200 font-bold text-lg leading-none">✕</button>
                </div>

                <form method="POST" action="{{ route('expenses.store') }}" class="p-5 space-y-4 bg-[#f6f9fc]">
                    @csrf
                    <div>
                        <label class="block text-xs font-black uppercase text-slate-800 mb-1">Expense Title / Description</label>
                        <input type="text" name="title" required placeholder="e.g. Office Electricity Bill" class="w-full px-3 py-2 rounded bg-white border border-[#9ab3c9] focus:border-[#00a2e8] text-slate-900 text-xs font-bold shadow-sm" />
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-black uppercase text-slate-800 mb-1">Amount (Rs.)</label>
                            <input type="number" step="0.01" name="amount" required placeholder="0.00" class="w-full px-3 py-2 rounded bg-white border border-[#9ab3c9] focus:border-[#00a2e8] text-slate-900 text-xs font-mono font-black text-rose-700 shadow-sm" />
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase text-slate-800 mb-1">Date</label>
                            <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-2 rounded bg-white border border-[#9ab3c9] focus:border-[#00a2e8] text-slate-900 text-xs font-mono font-bold shadow-sm" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase text-slate-800 mb-1">Category</label>
                        <input type="text" name="category" placeholder="Utilities, Refreshment, Rent..." class="w-full px-3 py-2 rounded bg-white border border-[#9ab3c9] focus:border-[#00a2e8] text-slate-900 text-xs font-bold shadow-sm" />
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase text-slate-800 mb-1">Remarks</label>
                        <textarea name="remarks" rows="2" placeholder="Optional notes..." class="w-full px-3 py-2 rounded bg-white border border-[#9ab3c9] focus:border-[#00a2e8] text-slate-900 text-xs font-medium shadow-sm"></textarea>
                    </div>

                    <div class="pt-3 flex justify-end gap-2 border-t border-[#cbd8e4]">
                        <button type="button" @click="showModal = false" class="px-4 py-1.5 bg-slate-200 hover:bg-slate-300 text-slate-800 rounded text-xs font-bold">Cancel</button>
                        <button type="submit" class="px-5 py-1.5 bg-[#00a2e8] hover:bg-[#008ecb] text-white rounded text-xs font-black shadow-sm">Save Expense</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
