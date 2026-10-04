<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                Work Email Address
            </label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus 
                   autocomplete="username" 
                   placeholder="e.g. user@domain.com"
                   class="w-full px-4 py-3 rounded-xl bg-slate-900/80 border border-slate-700/80 text-white placeholder-slate-500 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition-colors text-sm" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-400 text-xs" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
                    Account Password
                </label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-cyan-400 hover:text-cyan-300 transition-colors" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>

            <input id="password" 
                   type="password" 
                   name="password" 
                   required 
                   autocomplete="current-password" 
                   placeholder="••••••••"
                   class="w-full px-4 py-3 rounded-xl bg-slate-900/80 border border-slate-700/80 text-white placeholder-slate-500 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition-colors text-sm" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-400 text-xs" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-700 bg-slate-900 text-cyan-500 shadow-sm focus:ring-cyan-400" name="remember">
                <span class="ms-2 text-xs text-slate-300">Keep me logged in</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full prowave-btn-primary py-3.5 rounded-xl text-sm font-bold flex items-center justify-center gap-2">
                <span>Sign In to Dashboard</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </div>

        <div class="text-center pt-2">
            <span class="text-xs text-slate-400">Don't have an account? </span>
            <a href="{{ route('register') }}" class="text-xs font-bold text-cyan-400 hover:underline">Create an Enterprise Account</a>
        </div>
    </form>
</x-guest-layout>
