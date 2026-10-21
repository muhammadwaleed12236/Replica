<nav x-data="{ open: false }" class="bg-gradient-to-r from-[#0c2f55] via-[#0f3d6e] to-[#144b84] border-b border-[#0a2747] sticky top-0 z-50 shadow-md select-none font-sans">
    <!-- Primary Navigation Menu -->
    <div class="max-w-[1400px] mx-auto px-3 sm:px-6 lg:px-8">
        <div class="flex justify-between h-14 py-1.5 items-center gap-3">
            
            <!-- Left: DevoAccounts Brand with Chart Icon -->
            <div class="flex items-center gap-4 shrink-0">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-white font-black text-base tracking-tight hover:opacity-95 transition-opacity" title="DevoAccounts Main Terminal">
                    <!-- Ascending 5-bar signal/chart icon matching screenshot -->
                    <div class="w-8 h-8 rounded bg-white/10 border border-white/20 flex items-center justify-center p-1 shadow-inner">
                        <svg class="w-6 h-6 text-sky-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="4" y1="20" x2="4" y2="15"></line>
                            <line x1="8" y1="20" x2="8" y2="12"></line>
                            <line x1="12" y1="20" x2="12" y2="8"></line>
                            <line x1="16" y1="20" x2="16" y2="5"></line>
                            <line x1="20" y1="20" x2="20" y2="2"></line>
                            <polyline points="3 14 8 11 12 7 16 4 21 2" stroke="#38bdf8" stroke-width="2"></polyline>
                        </svg>
                    </div>
                    <span class="text-white font-extrabold text-lg tracking-tight font-sans">DevoAccounts</span>
                </a>

                <!-- Licensed To DAWN Professional Blue Banner matching Screenshot Graphic -->
                <div class="flex items-center gap-2.5 px-3.5 py-1 bg-[#092b4f]/90 text-white rounded-md shadow-inner border border-sky-400/30 select-none">
                    <svg class="w-6 h-6 text-sky-400 shrink-0" viewBox="0 0 28 28" fill="none" stroke="currentColor">
                        <!-- Upward trend bars & arrow matching screenshot -->
                        <rect x="2" y="18" width="3" height="8" fill="#38bdf8" />
                        <rect x="7" y="14" width="3" height="12" fill="#38bdf8" />
                        <rect x="12" y="10" width="3" height="16" fill="#38bdf8" />
                        <rect x="17" y="6" width="3" height="20" fill="#38bdf8" />
                        <rect x="22" y="3" width="3" height="23" fill="#38bdf8" />
                        <polyline points="2 17 8 13 13 9 18 5 24 2" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <polyline points="20 2 25 2 25 7" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <div class="leading-tight flex flex-col justify-center">
                        <span class="text-[9px] uppercase tracking-wider font-semibold text-sky-200">Licenced To</span>
                        <span class="text-sm font-black tracking-widest uppercase text-white font-mono">DAWN</span>
                    </div>
                </div>
            </div>

            <!-- Center/Right Developer Credit matching Reference Image -->
            <div class="hidden lg:flex items-center text-xs font-normal text-white/90 bg-black/20 px-3.5 py-1.5 rounded-md border border-white/15 select-none truncate">
                <span>Developed by <strong class="text-white font-bold">Muhammad Majid Ali Attari</strong>, Senior IT Consultant, DevoTech</span>
            </div>

            <!-- Right Controls: Home (if inside module), User Profile & Settings -->
            <div class="flex items-center gap-2.5 shrink-0">
                @if(!request()->routeIs('dashboard'))
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded bg-white text-[#0f3868] shadow-sm hover:bg-slate-100 transition-all border border-white/50" title="Return to Main Menu (Home)">
                        <svg class="w-3.5 h-3.5 text-[#0f3868]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>Main Menu</span>
                    </a>
                @endif

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-2.5 py-1 border border-white/30 text-xs font-bold rounded-md text-white bg-white/10 hover:bg-white/20 transition duration-150">
                            <div class="w-5 h-5 rounded-full bg-sky-300 text-[#0c2f55] flex items-center justify-center text-[10px] font-black mr-1.5 shadow-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden sm:block truncate max-w-[100px]">{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-3.5 w-3.5 text-white/80" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-white border border-slate-200 rounded-md shadow-xl overflow-hidden py-1">
                            <div class="px-4 py-2 border-b border-slate-100 text-xs text-slate-500">
                                Logged in as <span class="font-bold text-slate-900 block truncate">{{ Auth::user()->email }}</span>
                            </div>
                            <x-dropdown-link :href="route('settings.index')" class="text-slate-700 hover:bg-blue-50 font-medium">
                                ⚙️ {{ __('System Settings') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('profile.edit')" class="text-slate-700 hover:bg-blue-50">
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
