@props(['active' => ''])

<div class="bg-slate-900/90 border border-slate-800 p-2 rounded-2xl shadow-xl flex items-center gap-1.5 overflow-x-auto text-xs font-bold scrollbar-none">
    
    <!-- 1 Parties -->
    <a href="{{ route('parties.index') }}" class="px-3 py-1.5 rounded-xl flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'parties' ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/40 shadow-sm shadow-cyan-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
        <span class="w-4 h-4 rounded bg-cyan-500/20 text-cyan-400 text-[10px] font-mono flex items-center justify-center font-bold">1</span>
        <span>Parties</span>
    </a>

    <!-- 2 Medical Reps -->
    <a href="{{ route('medical_reps.index') }}" class="px-3 py-1.5 rounded-xl flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'medical_reps' ? 'bg-indigo-500/20 text-indigo-300 border border-indigo-500/40 shadow-sm shadow-indigo-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
        <span class="w-4 h-4 rounded bg-indigo-500/20 text-indigo-400 text-[10px] font-mono flex items-center justify-center font-bold">2</span>
        <span>Medical Reps</span>
    </a>

    <!-- 3 Companies -->
    <a href="{{ route('companies.index') }}" class="px-3 py-1.5 rounded-xl flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'companies' ? 'bg-purple-500/20 text-purple-300 border border-purple-500/40 shadow-sm shadow-purple-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
        <span class="w-4 h-4 rounded bg-purple-500/20 text-purple-400 text-[10px] font-mono flex items-center justify-center font-bold">3</span>
        <span>Companies</span>
    </a>

    <!-- 4 Salesmen -->
    <a href="{{ route('salesmen.index') }}" class="px-3 py-1.5 rounded-xl flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'salesmen' ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/40 shadow-sm shadow-cyan-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
        <span class="w-4 h-4 rounded bg-cyan-500/20 text-cyan-400 text-[10px] font-mono flex items-center justify-center font-bold">4</span>
        <span>Salesmen</span>
    </a>

    <!-- 5 Banks -->
    <a href="{{ route('banks.index') }}" class="px-3 py-1.5 rounded-xl flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'banks' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 shadow-sm shadow-emerald-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
        <span class="w-4 h-4 rounded bg-emerald-500/20 text-emerald-400 text-[10px] font-mono flex items-center justify-center font-bold">5</span>
        <span>Banks</span>
    </a>

    <!-- 6 Expenses -->
    <a href="{{ route('expenses.index') }}" class="px-3 py-1.5 rounded-xl flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'expenses' ? 'bg-rose-500/20 text-rose-300 border border-rose-500/40 shadow-sm shadow-rose-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
        <span class="w-4 h-4 rounded bg-rose-500/20 text-rose-400 text-[10px] font-mono flex items-center justify-center font-bold">6</span>
        <span>Expenses</span>
    </a>

    <!-- 7 Amanats -->
    <a href="{{ route('amanats.index') }}" class="px-3 py-1.5 rounded-xl flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'amanats' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/40 shadow-sm shadow-amber-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
        <span class="w-4 h-4 rounded bg-amber-500/20 text-amber-400 text-[10px] font-mono flex items-center justify-center font-bold">7</span>
        <span>Amanats</span>
    </a>

    <!-- 8 Lotteries -->
    <a href="{{ route('lotteries.index') }}" class="px-3 py-1.5 rounded-xl flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'lotteries' ? 'bg-sky-500/20 text-sky-300 border border-sky-500/40 shadow-sm shadow-sky-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
        <span class="w-4 h-4 rounded bg-sky-500/20 text-sky-400 text-[10px] font-mono flex items-center justify-center font-bold">8</span>
        <span>Lotteries</span>
    </a>

    <div class="h-4 w-px bg-slate-800 mx-1"></div>

    <!-- 9 Sales -->
    <a href="{{ route('sales.index') }}" class="px-3 py-1.5 rounded-xl flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'sales' ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/40 shadow-sm shadow-cyan-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
        <span class="w-4 h-4 rounded bg-cyan-400 text-slate-900 text-[10px] font-mono flex items-center justify-center font-extrabold">9</span>
        <span>Sales</span>
    </a>

    <!-- 0 Purchases -->
    <a href="{{ route('purchases.index') }}" class="px-3 py-1.5 rounded-xl flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'purchases' ? 'bg-indigo-500/20 text-indigo-300 border border-indigo-500/40 shadow-sm shadow-indigo-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
        <span class="w-4 h-4 rounded bg-indigo-400 text-slate-900 text-[10px] font-mono flex items-center justify-center font-extrabold">0</span>
        <span>Purchases</span>
    </a>

    <!-- A Receipts -->
    <a href="{{ route('vouchers.index', 'receipt') }}" class="px-3 py-1.5 rounded-xl flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'vouchers_receipt' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 shadow-sm shadow-emerald-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
        <span class="w-4 h-4 rounded bg-emerald-500/20 text-emerald-400 text-[10px] font-mono flex items-center justify-center font-bold">A</span>
        <span>Receipts</span>
    </a>

    <!-- B Payments -->
    <a href="{{ route('vouchers.index', 'payment') }}" class="px-3 py-1.5 rounded-xl flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'vouchers_payment' ? 'bg-rose-500/20 text-rose-300 border border-rose-500/40 shadow-sm shadow-rose-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
        <span class="w-4 h-4 rounded bg-rose-500/20 text-rose-400 text-[10px] font-mono flex items-center justify-center font-bold">B</span>
        <span>Payments</span>
    </a>

    <div class="h-4 w-px bg-slate-800 mx-1"></div>

    <!-- Reports -->
    <a href="{{ route('reports.index') }}" class="px-3 py-1.5 rounded-xl flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'reports' ? 'bg-purple-500/20 text-purple-300 border border-purple-500/40 shadow-sm shadow-purple-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
        <svg class="w-3.5 h-3.5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        <span>Reports</span>
    </a>

</div>
