<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">
                Full Name
            </label>
            <input id="name" 
                   type="text" 
                   name="name" 
                   value="{{ old('name') }}" 
                   required 
                   autofocus 
                   autocomplete="name" 
                   placeholder="e.g. Deepak Sharma"
                   class="w-full px-4 py-3 rounded-xl bg-slate-900/80 border border-slate-700/80 text-white placeholder-slate-500 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition-colors text-sm" />
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-rose-400 text-xs" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">
                Work Email Address
            </label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autocomplete="username" 
                   placeholder="name@company.com"
                   class="w-full px-4 py-3 rounded-xl bg-slate-900/80 border border-slate-700/80 text-white placeholder-slate-500 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition-colors text-sm" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-rose-400 text-xs" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">
                Password
            </label>
            <input id="password" 
                   type="password" 
                   name="password" 
                   required 
                   autocomplete="new-password" 
                   placeholder="At least 8 characters"
                   class="w-full px-4 py-3 rounded-xl bg-slate-900/80 border border-slate-700/80 text-white placeholder-slate-500 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition-colors text-sm" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-rose-400 text-xs" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">
                Confirm Password
            </label>
            <input id="password_confirmation" 
                   type="password" 
                   name="password_confirmation" 
                   required 
                   autocomplete="new-password" 
                   placeholder="Repeat password"
                   class="w-full px-4 py-3 rounded-xl bg-slate-900/80 border border-slate-700/80 text-white placeholder-slate-500 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition-colors text-sm" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-rose-400 text-xs" />
        </div>

        <div class="pt-3">
            <button type="submit" class="w-full prowave-btn-primary py-3.5 rounded-xl text-sm font-bold flex items-center justify-center gap-2">
                <span>Create ProWave Account</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </div>

        <div class="text-center pt-2">
            <span class="text-xs text-slate-400">Already registered? </span>
            <a href="{{ route('login') }}" class="text-xs font-bold text-cyan-400 hover:underline">Sign In Instead</a>
        </div>
    </form>
</x-guest-layout>
