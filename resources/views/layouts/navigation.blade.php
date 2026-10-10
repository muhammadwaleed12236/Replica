<nav x-data="{ open: false }" class="prowave-glass border-b border-gray-200 dark:border-slate-800 sticky top-0 z-50 transition-colors">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            
            <div class="flex items-center gap-4">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 rounded-xl bg-blue-600 p-0.5 shadow-lg group-hover:shadow-blue-500/40 transition-all duration-300">
                        <div class="w-full h-full bg-white dark:bg-slate-900 rounded-[9px] flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <span class="text-base font-extrabold tracking-tight text-gray-900 dark:text-white font-['Outfit']">Pro<span class="text-blue-600 dark:text-blue-400">Wave</span></span>
                        <span class="block text-[8px] font-semibold tracking-widest text-blue-600 dark:text-blue-400 uppercase">ERP Engine</span>
                    </div>
                </a>

                <!-- Licenced To DAWN Badge in Header -->
                <div class="hidden sm:inline-flex items-center gap-2 px-3 py-1 rounded-xl bg-gradient-to-r from-sky-600/30 to-indigo-600/30 border border-cyan-400/40 text-xs font-bold text-white shadow-sm">
                    <svg class="w-3.5 h-3.5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    <span>Licenced To <span class="text-cyan-300 font-extrabold">DAWN</span></span>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 md:flex items-center ml-2">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-3 py-1.5 text-xs font-bold transition-colors rounded-lg {{ request()->routeIs('dashboard') ? 'bg-cyan-500/10 text-cyan-400 border border-cyan-500/30' : 'text-slate-300 hover:text-white' }}">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        Main Menu Grid
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown & Node Indicator -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                <!-- Theme Toggle Button -->
                <button @click="darkMode = !darkMode" class="p-2 rounded-full text-gray-500 hover:bg-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 focus:outline-none transition-colors">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    <svg x-show="darkMode" x-cloak class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </button>

                <!-- System Status Indicator Badge -->
                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-100 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-[11px] font-semibold text-emerald-700 dark:text-emerald-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Node Online
                </div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-slate-700/60 text-xs leading-4 font-semibold rounded-xl text-gray-700 dark:text-slate-200 bg-white dark:bg-slate-900/80 hover:bg-gray-50 dark:hover:bg-slate-800 focus:outline-none transition duration-150">
                            <div class="w-5 h-5 rounded-full bg-blue-600 flex items-center justify-center text-[10px] font-bold text-white mr-1.5">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1.5">
                                <svg class="fill-current h-3.5 w-3.5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden shadow-2xl">
                            <div class="px-4 py-3 border-b border-slate-800 text-xs text-slate-400">
                                Logged in as <span class="font-bold text-white block truncate">{{ Auth::user()->email }}</span>
                            </div>
                            <x-dropdown-link :href="route('profile.edit')" class="text-slate-300 hover:bg-slate-800 hover:text-cyan-400">
                                {{ __('Profile Settings') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        class="text-rose-400 hover:bg-rose-500/10 hover:text-rose-300"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 focus:outline-none transition duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-slate-900 border-b border-slate-800">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-slate-200">
                {{ __('Main Menu Grid') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-3 border-t border-slate-800 px-4">
            <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
            <div class="font-medium text-sm text-slate-400">{{ Auth::user()->email }}</div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-slate-300">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            class="text-rose-400"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
