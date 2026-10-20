<nav x-data="{ open: false }" class="bg-[#00a2e8] border-b border-[#008ecb] sticky top-0 z-50 shadow-md">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="flex justify-between h-13 py-1.5 items-center">
            
            <div class="flex items-center gap-3">
                <!-- DevoAccounts Brand -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-1.5 text-white font-black text-sm tracking-tight hover:opacity-95 transition-opacity">
                    <svg class="w-5 h-5 text-amber-300 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                        <polyline points="16 7 22 7 22 13"></polyline>
                    </svg>
                    <span class="text-white font-extrabold tracking-tight font-sans">DevoAccounts</span>
                </a>

                <!-- Licensed To DAWN Green Banner matching Screenshot -->
                <div class="flex items-center gap-2 px-3 py-1 bg-[#15803d] text-white rounded shadow-inner border border-emerald-400/40 select-none">
                    <svg class="w-5 h-5 text-emerald-200 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="20" x2="18" y2="10"></line>
                        <line x1="12" y1="20" x2="12" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="14"></line>
                        <polyline points="4 8 10 3 16 7 22 2"></polyline>
                    </svg>
                    <div class="leading-tight flex flex-col">
                        <span class="text-[8px] uppercase tracking-wider font-semibold text-emerald-200">Licensed To</span>
                        <span class="text-xs font-black tracking-widest uppercase text-white font-mono">DAWN</span>
                    </div>
                </div>
            </div>

            <!-- Center/Right Developer Credit matching Reference Image -->
            <div class="hidden md:flex items-center text-[11px] font-medium text-white/95 bg-black/15 px-3 py-1 rounded border border-white/20 select-none">
                <span>Developed by <strong class="text-white font-bold">Muhammad Majid Ali Attari</strong>, Senior IT Consultant, DevoTech</span>
            </div>

            <!-- Right Controls: Home (if inside module), User Profile & Settings -->
            <div class="flex items-center gap-2">
                @if(!request()->routeIs('dashboard'))
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded bg-white text-slate-900 shadow-sm hover:bg-slate-100 transition-all" title="Return to Main Menu (Home)">
                        <svg class="w-3.5 h-3.5 text-[#007cb5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>Home</span>
                    </a>
                @endif

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-2.5 py-1 border border-white/40 text-xs font-bold rounded text-white bg-white/20 hover:bg-white/30 transition duration-150">
                            <div class="w-5 h-5 rounded-full bg-slate-900 text-white flex items-center justify-center text-[10px] font-black mr-1.5">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden sm:block truncate max-w-[100px]">{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-3.5 w-3.5 text-white" viewBox="0 0 20 20">
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
                                👤 {{ __('Profile Settings') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        class="text-rose-600 hover:bg-rose-50 font-bold"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    🚪 {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
