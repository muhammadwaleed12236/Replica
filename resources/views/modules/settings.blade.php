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
            <!-- WHATSAPP AUTOMATED BOT & QR CODE CONNECTION CARD -->
            <div x-data="{
                status: 'connecting',
                qr: null,
                phone: null,
                error: null,
                fetchStatus() {
                    fetch('{{ route('settings.whatsapp_status') }}')
                        .then(res => res.json())
                        .then(data => {
                            this.status = data.status;
                            this.qr = data.qr;
                            this.phone = data.phone;
                            this.error = data.error || null;
                        })
                        .catch(err => {
                            this.status = 'offline';
                            this.error = 'WhatsApp Node.js Service Offline';
                        });
                },
                logout() {
                    if (!confirm('Disconnect WhatsApp Number?')) return;
                    fetch('{{ route('settings.whatsapp_logout') }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                        .then(() => this.fetchStatus());
                }
            }" x-init="fetchStatus(); setInterval(() => fetchStatus(), 3000)" class="prowave-glass-card rounded-2xl border border-emerald-500/30 p-6 shadow-2xl space-y-4">
                
                <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 flex items-center justify-center font-bold text-lg">💬</div>
                        <div>
                            <h2 class="text-sm font-extrabold text-white font-['Outfit'] uppercase">Automated Direct WhatsApp API Bot</h2>
                            <p class="text-[11px] text-slate-400">Background Messaging (No WhatsApp Web tabs required)</p>
                        </div>
                    </div>

                    <!-- Connection Status Badge -->
                    <template x-if="status === 'connected'">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            🟢 Connected: +<span x-text="phone"></span>
                        </span>
                    </template>
                    <template x-if="status === 'qr_required'">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/40 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                            🟡 Scan QR Code Below
                        </span>
                    </template>
                    <template x-if="status === 'offline'">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-500/20 text-rose-300 border border-rose-500/40">
                            🔴 API Offline
                        </span>
                    </template>
                </div>

                <!-- QR CODE & CONNECTION INSTRUCTIONS -->
                <div class="flex flex-col sm:flex-row items-center gap-6 p-4 rounded-xl bg-slate-900/80 border border-slate-800">
                    
                    <!-- QR Image View -->
                    <div class="w-44 h-44 bg-white p-2 rounded-xl shadow-lg flex items-center justify-center border border-slate-700">
                        <template x-if="status === 'connected'">
                            <div class="text-center p-3">
                                <span class="text-4xl block mb-1">✅</span>
                                <span class="text-xs font-extrabold text-slate-900 block">WhatsApp Paired!</span>
                                <span class="text-[10px] text-slate-600 block mt-0.5">Ready for Direct Messaging</span>
                            </div>
                        </template>

                        <template x-if="status === 'qr_required' && qr">
                            <img :src="qr" alt="WhatsApp QR Code" class="w-full h-full object-contain" />
                        </template>

                        <template x-if="status === 'connecting' || (status === 'qr_required' && !qr)">
                            <div class="text-center text-slate-500 text-xs">
                                <span class="animate-spin text-lg block mb-1">⏳</span>
                                Generating QR...
                            </div>
                        </template>

                        <template x-if="status === 'offline'">
                            <div class="text-center text-rose-600 text-xs">
                                <span class="text-2xl block mb-1">⚠️</span>
                                Node.js Offline
                            </div>
                        </template>
                    </div>

                    <!-- Instructions Text -->
                    <div class="space-y-2 text-xs text-slate-300 flex-grow">
                        <h3 class="font-extrabold text-white text-sm font-['Outfit']">How to Connect Your WhatsApp Number:</h3>
                        <ol class="list-decimal list-inside space-y-1 text-slate-400 text-[11px]">
                            <li>Open **WhatsApp** on your phone.</li>
                            <li>Tap **Menu / Settings** (3 dots on Android or Settings on iPhone).</li>
                            <li>Select **Linked Devices** ➔ Tap **Link a Device**.</li>
                            <li>Point your phone camera at the **QR Code** on the left.</li>
                        </ol>

                        <p class="text-[11px] text-cyan-300 pt-1 font-semibold">
                            ✨ Once scanned, all Sales Invoices & Vouchers will be sent directly in the background without opening WhatsApp Web tabs!
                        </p>

                        <template x-if="status === 'connected'">
                            <button type="button" @click="logout()" class="mt-3 px-3.5 py-1.5 rounded-lg bg-rose-500/20 hover:bg-rose-500/30 text-rose-300 font-bold border border-rose-500/40 text-xs">
                                🔌 Disconnect / Pair New Number
                            </button>
                        </template>
                    </div>
                </div>

            </div>
    </div>
</x-app-layout>
