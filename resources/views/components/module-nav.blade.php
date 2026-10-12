@props(['active' => ''])

<div class="bg-white border border-[#cbd8e4] p-1.5 rounded-lg shadow-sm flex items-center gap-1 overflow-x-auto text-xs font-bold scrollbar-none select-none">
    
    <!-- 1 Parties -->
    <a href="{{ route('parties.index') }}" class="px-2.5 py-1 rounded flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'parties' ? 'bg-[#00a2e8] text-white shadow-sm font-extrabold' : 'text-slate-700 hover:bg-[#eaf4fa] hover:text-[#007cb5]' }}">
        <span class="w-4 h-4 rounded {{ $active === 'parties' ? 'bg-white text-slate-900' : 'bg-slate-200 text-slate-800' }} text-[10px] font-mono flex items-center justify-center font-black">1</span>
        <span>Parties</span>
    </a>

    <!-- 2 Medical Reps -->
    <a href="{{ route('medical_reps.index') }}" class="px-2.5 py-1 rounded flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'medical_reps' ? 'bg-[#00a2e8] text-white shadow-sm font-extrabold' : 'text-slate-700 hover:bg-[#eaf4fa] hover:text-[#007cb5]' }}">
        <span class="w-4 h-4 rounded {{ $active === 'medical_reps' ? 'bg-white text-slate-900' : 'bg-slate-200 text-slate-800' }} text-[10px] font-mono flex items-center justify-center font-black">2</span>
        <span>Medical Reps</span>
    </a>

    <!-- 3 Companies -->
    <a href="{{ route('companies.index') }}" class="px-2.5 py-1 rounded flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'companies' ? 'bg-[#00a2e8] text-white shadow-sm font-extrabold' : 'text-slate-700 hover:bg-[#eaf4fa] hover:text-[#007cb5]' }}">
        <span class="w-4 h-4 rounded {{ $active === 'companies' ? 'bg-white text-slate-900' : 'bg-slate-200 text-slate-800' }} text-[10px] font-mono flex items-center justify-center font-black">3</span>
        <span>Companies</span>
    </a>

    <!-- 4 Salesmen -->
    <a href="{{ route('salesmen.index') }}" class="px-2.5 py-1 rounded flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'salesmen' ? 'bg-[#00a2e8] text-white shadow-sm font-extrabold' : 'text-slate-700 hover:bg-[#eaf4fa] hover:text-[#007cb5]' }}">
        <span class="w-4 h-4 rounded {{ $active === 'salesmen' ? 'bg-white text-slate-900' : 'bg-slate-200 text-slate-800' }} text-[10px] font-mono flex items-center justify-center font-black">4</span>
        <span>Salesmen</span>
    </a>

    <!-- 5 Banks -->
    <a href="{{ route('banks.index') }}" class="px-2.5 py-1 rounded flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'banks' ? 'bg-[#00a2e8] text-white shadow-sm font-extrabold' : 'text-slate-700 hover:bg-[#eaf4fa] hover:text-[#007cb5]' }}">
        <span class="w-4 h-4 rounded {{ $active === 'banks' ? 'bg-white text-slate-900' : 'bg-slate-200 text-slate-800' }} text-[10px] font-mono flex items-center justify-center font-black">5</span>
        <span>Banks</span>
    </a>

    <!-- 6 Expenses -->
    <a href="{{ route('expenses.index') }}" class="px-2.5 py-1 rounded flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'expenses' ? 'bg-[#00a2e8] text-white shadow-sm font-extrabold' : 'text-slate-700 hover:bg-[#eaf4fa] hover:text-[#007cb5]' }}">
        <span class="w-4 h-4 rounded {{ $active === 'expenses' ? 'bg-white text-slate-900' : 'bg-slate-200 text-slate-800' }} text-[10px] font-mono flex items-center justify-center font-black">6</span>
        <span>Expenses</span>
    </a>

    <!-- 7 Amanats -->
    <a href="{{ route('amanats.index') }}" class="px-2.5 py-1 rounded flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'amanats' ? 'bg-[#00a2e8] text-white shadow-sm font-extrabold' : 'text-slate-700 hover:bg-[#eaf4fa] hover:text-[#007cb5]' }}">
        <span class="w-4 h-4 rounded {{ $active === 'amanats' ? 'bg-white text-slate-900' : 'bg-slate-200 text-slate-800' }} text-[10px] font-mono flex items-center justify-center font-black">7</span>
        <span>Amanats</span>
    </a>

    <!-- 8 Lotteries -->
    <a href="{{ route('lotteries.index') }}" class="px-2.5 py-1 rounded flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'lotteries' ? 'bg-[#00a2e8] text-white shadow-sm font-extrabold' : 'text-slate-700 hover:bg-[#eaf4fa] hover:text-[#007cb5]' }}">
        <span class="w-4 h-4 rounded {{ $active === 'lotteries' ? 'bg-white text-slate-900' : 'bg-slate-200 text-slate-800' }} text-[10px] font-mono flex items-center justify-center font-black">8</span>
        <span>Lotteries</span>
    </a>

    <div class="h-4 w-px bg-slate-300 mx-0.5"></div>

    <!-- 9 Sales -->
    <a href="{{ route('sales.index') }}" class="px-2.5 py-1 rounded flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'sales' ? 'bg-[#00a2e8] text-white shadow-sm font-black' : 'text-slate-800 hover:bg-[#eaf4fa] hover:text-[#007cb5]' }}">
        <span class="w-4 h-4 rounded {{ $active === 'sales' ? 'bg-white text-slate-900' : 'bg-[#00a2e8] text-white' }} text-[10px] font-mono flex items-center justify-center font-black">9</span>
        <span>Sales</span>
    </a>

    <!-- 0 Purchases -->
    <a href="{{ route('purchases.index') }}" class="px-2.5 py-1 rounded flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'purchases' ? 'bg-[#00a2e8] text-white shadow-sm font-black' : 'text-slate-800 hover:bg-[#eaf4fa] hover:text-[#007cb5]' }}">
        <span class="w-4 h-4 rounded {{ $active === 'purchases' ? 'bg-white text-slate-900' : 'bg-[#00a2e8] text-white' }} text-[10px] font-mono flex items-center justify-center font-black">0</span>
        <span>Purchases</span>
    </a>

    <!-- A Receipts -->
    <a href="{{ route('vouchers.index', 'receipt') }}" class="px-2.5 py-1 rounded flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'vouchers_receipt' ? 'bg-[#00a2e8] text-white shadow-sm font-extrabold' : 'text-slate-700 hover:bg-[#eaf4fa] hover:text-[#007cb5]' }}">
        <span class="w-4 h-4 rounded {{ $active === 'vouchers_receipt' ? 'bg-white text-slate-900' : 'bg-slate-200 text-slate-800' }} text-[10px] font-mono flex items-center justify-center font-black">A</span>
        <span>Receipts</span>
    </a>

    <!-- B Payments -->
    <a href="{{ route('vouchers.index', 'payment') }}" class="px-2.5 py-1 rounded flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'vouchers_payment' ? 'bg-[#00a2e8] text-white shadow-sm font-extrabold' : 'text-slate-700 hover:bg-[#eaf4fa] hover:text-[#007cb5]' }}">
        <span class="w-4 h-4 rounded {{ $active === 'vouchers_payment' ? 'bg-white text-slate-900' : 'bg-slate-200 text-slate-800' }} text-[10px] font-mono flex items-center justify-center font-black">B</span>
        <span>Payments</span>
    </a>

    <div class="h-4 w-px bg-slate-300 mx-0.5"></div>

    <!-- Reports -->
    <a href="{{ route('reports.index') }}" class="px-2.5 py-1 rounded flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'reports' ? 'bg-[#00a2e8] text-white shadow-sm font-extrabold' : 'text-slate-700 hover:bg-[#eaf4fa] hover:text-[#007cb5]' }}">
        <span>📊 Reports</span>
    </a>

    <!-- Settings -->
    <a href="{{ route('settings.index') }}" class="px-2.5 py-1 rounded flex items-center gap-1.5 transition-all whitespace-nowrap {{ $active === 'settings' ? 'bg-[#00a2e8] text-white shadow-sm font-extrabold' : 'text-slate-700 hover:bg-[#eaf4fa] hover:text-[#007cb5]' }}">
        <span>⚙️ Settings</span>
    </a>

</div>
