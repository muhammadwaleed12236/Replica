<nav x-data="{ open: false }" class="bg-[#00a2e8] border-b border-[#008ecb] sticky top-0 z-50 shadow-md">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-14 items-center">
            
            <div class="flex items-center gap-6">
                <!-- DAWN Logo matching reference image -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                    <x-application-logo />
                </a>

                <!-- ERP System Mode Badge -->
                <div class="hidden sm:inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 border border-white/40 text-xs font-bold text-black shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-700 animate-pulse"></span>
                    <span>ERP System v2.0</span>
                </div>

                <!-- Main Menu Button -->
                <div class="hidden md:flex items-center ml-2">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-black rounded border border-white/40 transition-all {{ request()->routeIs('dashboard') ? 'bg-white text-slate-900 shadow-sm' : 'bg-white/20 text-slate-900 hover:bg-white/40' }}" title="Return to Main Menu (Dashboard)">
                        <svg class="w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <span>Main Menu</span>
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown & User -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-2">
                <a href="{{ route('settings.index') }}" class="px-2.5 py-1 rounded bg-white/20 hover:bg-white/30 border border-white/40 text-black text-xs font-extrabold flex items-center gap-1 transition-all">
                    ⚙️ Settings
                </a>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-2.5 py-1 border border-white/40 text-xs font-bold rounded text-black bg-white/20 hover:bg-white/30 transition duration-150">
                            <div class="w-5 h-5 rounded-full bg-slate-900 text-white flex items-center justify-center text-[10px] font-black mr-1.5">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-3.5 w-3.5 text-black" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-white border border-slate-300 rounded shadow-xl overflow-hidden py-1">
                            <div class="px-4 py-2 border-b border-slate-200 text-xs text-slate-500">
                                Logged in as <span class="font-bold text-slate-900 block truncate">{{ Auth::user()->email }}</span>
                            </div>
                            <x-dropdown-link :href="route('settings.index')" class="text-slate-700 hover:bg-[#eaf4fa] font-bold">
                                ⚙️ {{ __('System Settings') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('profile.edit')" class="text-slate-700 hover:bg-[#eaf4fa]">
                                {{ __('Profile Settings') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        class="text-rose-600 hover:bg-rose-50"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded text-black hover:bg-white/20 focus:outline-none transition duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Docked ERP Module Ribbon Bar (Hidden on Dashboard) -->
    @if(!request()->routeIs('dashboard'))
        <x-module-nav />
    @endif

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#008ecb] border-b border-[#007cb5]">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-black font-bold">
                {{ __('Main Menu Grid') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('parties.index')" :active="request()->routeIs('parties.*')" class="text-black font-bold">
                {{ __('1 Parties') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('medical_reps.index')" :active="request()->routeIs('medical_reps.*')" class="text-black font-bold">
                {{ __('2 Medical Reps') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.*')" class="text-black font-bold">
                {{ __('3 Companies') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('salesmen.index')" :active="request()->routeIs('salesmen.*')" class="text-black font-bold">
                {{ __('4 Salesmen') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('banks.index')" :active="request()->routeIs('banks.*')" class="text-black font-bold">
                {{ __('5 Banks') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('expenses.index')" :active="request()->routeIs('expenses.*')" class="text-black font-bold">
                {{ __('6 Expenses') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('amanats.index')" :active="request()->routeIs('amanats.*')" class="text-black font-bold">
                {{ __('7 Amanats') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('lotteries.index')" :active="request()->routeIs('lotteries.*')" class="text-black font-bold">
                {{ __('8 Lotteries') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.*')" class="text-black font-bold">
                {{ __('9 Sales') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('purchases.index')" :active="request()->routeIs('purchases.*')" class="text-black font-bold">
                {{ __('0 Purchases') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('vouchers.index', 'receipt')" :active="request()->routeIs('vouchers.*') && request()->route('type') === 'receipt'" class="text-black font-bold">
                {{ __('A Receipts') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('vouchers.index', 'payment')" :active="request()->routeIs('vouchers.*') && request()->route('type') === 'payment'" class="text-black font-bold">
                {{ __('B Payments') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')" class="text-black font-bold">
                {{ __('Reports') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-3 border-t border-[#007cb5] px-4 bg-[#007cb5]/40">
            <div class="font-bold text-base text-black">{{ Auth::user()->name }}</div>
            <div class="font-medium text-xs text-slate-900">{{ Auth::user()->email }}</div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('settings.index')" class="text-black font-bold">
                    {{ __('Settings') }}
                </x-responsive-nav-link>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            class="text-rose-900 font-bold"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
