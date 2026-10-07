<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Module Navigation Bar -->
            <x-module-nav active="settings" />

            <!-- Header -->
            <div class="prowave-glass-card rounded-2xl border border-slate-800 p-4 flex items-center justify-between shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/20 border border-amber-400/30 flex items-center justify-center text-amber-300 font-bold">
                        ⚙️
                    </div>
                    <div>
                        <h1 class="text-lg font-extrabold text-white font-['Outfit']">System Settings & Security</h1>
                        <p class="text-xs text-slate-400">Date Lock, Admin Password, WhatsApp Templates & Auto Backup</p>
                    </div>
                </div>

                <a href="{{ route('settings.backup') }}" class="prowave-btn-primary px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Download DB Backup</span>
                </a>
            </div>

            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-xs font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('settings.update') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf

                <!-- 1. DATE LOCK & ADMIN PASSWORD CARD -->
                <div class="prowave-glass-card rounded-2xl border border-slate-800 p-5 shadow-xl space-y-4">
                    <div class="flex items-center gap-2 pb-3 border-b border-slate-800">
                        <span class="text-lg">🔒</span>
                        <h2 class="text-sm font-extrabold text-white uppercase font-['Outfit']">Date Lock & Admin Security</h2>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">Date Lock (Lock Entries Prior to Date)</label>
                        <input type="date" name="date_lock_date" value="{{ $dateLockDate }}" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-mono" />
                        <p class="text-[11px] text-slate-400 mt-1">Users will be blocked from creating, editing or deleting sales/purchases on or before this date.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">Change Admin Security Password</label>
                        <input type="password" name="new_admin_password" placeholder="Enter new admin password" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-mono" />
                        <p class="text-[11px] text-slate-400 mt-1">Used to authorize protected actions (override credit limits, edit locked dates).</p>
                    </div>
                </div>

                <!-- 2. WHATSAPP MESSAGE CUSTOMIZATION & BACKUP CARD -->
                <div class="prowave-glass-card rounded-2xl border border-slate-800 p-5 shadow-xl space-y-4">
                    <div class="flex items-center gap-2 pb-3 border-b border-slate-800">
                        <span class="text-lg">📱</span>
                        <h2 class="text-sm font-extrabold text-white uppercase font-['Outfit']">WhatsApp & Auto-Backup Settings</h2>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">WhatsApp Message Template</label>
                        <textarea name="whatsapp_template" rows="4" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-mono">{{ $whatsappTemplate }}</textarea>
                        <p class="text-[11px] text-slate-400 mt-1">Available placeholders: <code class="text-cyan-400">{customer_name}</code>, <code class="text-cyan-400">{invoice_no}</code>, <code class="text-cyan-400">{amount}</code>, <code class="text-cyan-400">{date}</code></p>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <input type="checkbox" id="auto_backup" name="auto_backup_enabled" value="1" {{ $autoBackupEnabled === '1' ? 'checked' : '' }} class="rounded bg-slate-900 border-slate-700 text-cyan-500 focus:ring-cyan-500" />
                        <label for="auto_backup" class="text-xs font-bold text-white">Enable Auto Backup Reminders & Export</label>
                    </div>
                </div>

                <!-- SAVE BUTTON -->
                <div class="md:col-span-2">
                    <button type="submit" class="prowave-btn-primary px-6 py-2.5 rounded-xl text-xs font-bold flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Save All Security & System Settings</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
