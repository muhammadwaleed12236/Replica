<x-app-layout>
    <div class="py-4">
        <div class="max-w-7xl mx-auto px-2 sm:px-4 space-y-4 font-sans">

            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: '{{ session('success') }}',
                            timer: 2500,
                            timerProgressBar: true,
                            confirmButtonColor: '#00a2e8'
                        });
                    });
                </script>
            @endif

            <!-- Module Navigation Bar -->
            <x-module-nav active="settings" />

            <!-- DAWN Top Header Banner -->
            <div class="w-full bg-[#00a2e8] select-none shadow-md rounded-lg overflow-hidden border border-[#008ecb]">
                <div class="px-4 py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-2 bg-[#008cc9]/70 border border-white/50 px-3 py-1.5 rounded-lg text-black">
                            <span class="text-xl">⚙️</span>
                            <h1 class="text-lg font-black tracking-normal font-sans">System Settings & Security</h1>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('settings.backup') }}" class="px-3.5 py-1.5 rounded bg-white hover:bg-[#f0f4f8] text-slate-900 text-xs font-black flex items-center gap-1.5 shadow-sm border border-white/60 transition-all">
                            <svg class="w-4 h-4 text-[#007cb5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>Download DB Backup</span>
                        </a>
                        <a href="{{ route('dashboard') }}" class="px-3 py-1.5 rounded bg-white/20 hover:bg-white/30 text-black text-xs font-bold border border-white/40 transition-all">
                            ← Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <!-- Settings Form Grid -->
            <form method="POST" action="{{ route('settings.update') }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- 1. DATE LOCK & ADMIN PASSWORD CARD -->
                    <div class="bg-white rounded-lg border-2 border-[#cbd8e4] p-5 shadow-md space-y-4">
                        <div class="flex items-center gap-2 pb-2 border-b border-[#cbd8e4]">
                            <span class="text-lg">🔒</span>
                            <h2 class="text-sm font-black text-slate-900 uppercase tracking-wide">Date Lock & Admin Security</h2>
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-800 mb-1">Date Lock (Lock Transactions Prior to Date)</label>
                            <input type="date" name="date_lock_date" value="{{ $dateLockDate }}" class="w-full px-3 py-2 rounded bg-white border border-[#9ab3c9] focus:border-[#00a2e8] text-slate-900 text-xs font-mono font-bold shadow-sm" />
                            <p class="text-[11px] text-slate-600 mt-1">Users will be prevented from altering sales/purchases prior to this lock date.</p>
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-800 mb-1">Change Admin Security Password</label>
                            <input type="password" name="new_admin_password" placeholder="Enter new admin password" class="w-full px-3 py-2 rounded bg-white border border-[#9ab3c9] focus:border-[#00a2e8] text-slate-900 text-xs font-mono shadow-sm" />
                            <p class="text-[11px] text-slate-600 mt-1">Used to authorize protected actions (override limits, unlock dates).</p>
                        </div>
                    </div>

                    <!-- 2. WHATSAPP TEMPLATE & BACKUP PREFERENCES -->
                    <div class="bg-white rounded-lg border-2 border-[#cbd8e4] p-5 shadow-md space-y-4">
                        <div class="flex items-center gap-2 pb-2 border-b border-[#cbd8e4]">
                            <span class="text-lg">📱</span>
                            <h2 class="text-sm font-black text-slate-900 uppercase tracking-wide">WhatsApp Message & Backup Settings</h2>
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-800 mb-1">WhatsApp Message Template</label>
                            <textarea name="whatsapp_template" rows="3" class="w-full px-3 py-2 rounded bg-white border border-[#9ab3c9] focus:border-[#00a2e8] text-slate-900 text-xs font-mono shadow-sm">{{ $whatsappTemplate }}</textarea>
                            <p class="text-[11px] text-slate-600 mt-1">Placeholders: <code class="text-[#007cb5] font-bold">{customer_name}</code>, <code class="text-[#007cb5] font-bold">{invoice_no}</code>, <code class="text-[#007cb5] font-bold">{amount}</code>, <code class="text-[#007cb5] font-bold">{date}</code></p>
                        </div>

                        <div class="flex items-center gap-2.5 pt-1">
                            <input type="checkbox" id="auto_backup" name="auto_backup_enabled" value="1" {{ $autoBackupEnabled === '1' ? 'checked' : '' }} class="rounded border-[#9ab3c9] text-[#00a2e8] focus:ring-[#00a2e8]" />
                            <label for="auto_backup" class="text-xs font-black text-slate-800 cursor-pointer">Enable Auto-Backup Reminders & Data Export</label>
                        </div>
                    </div>
                </div>

                <!-- SAVE SETTINGS BUTTON -->
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2.5 rounded bg-[#00a2e8] hover:bg-[#008ecb] text-white text-xs font-black flex items-center gap-2 shadow-md transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Save All Security & System Settings</span>
                    </button>
                </div>
            </form>

            <!-- 3. WHATSAPP AUTOMATED BOT & QR CODE CONNECTION CARD -->
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
                    Swal.fire({
                        title: 'Disconnect WhatsApp?',
                        text: 'Are you sure you want to unlink this WhatsApp number?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e11d48',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Yes, Disconnect'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch('{{ route('settings.whatsapp_logout') }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                                .then(() => this.fetchStatus());
                        }
                    });
                }
            }" x-init="fetchStatus(); setInterval(() => fetchStatus(), 3000)" class="bg-white rounded-lg border-2 border-[#cbd8e4] p-5 shadow-md space-y-4">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-[#cbd8e4] gap-2">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded bg-[#e8f8f0] text-emerald-700 border border-emerald-300 flex items-center justify-center font-bold text-lg">💬</div>
                        <div>
                            <h2 class="text-sm font-black text-slate-900 uppercase">Automated Direct WhatsApp API Bot</h2>
                            <p class="text-xs text-slate-600">Background Invoice & Voucher Messaging (No WhatsApp Web tabs required)</p>
                        </div>
                    </div>

                    <!-- Connection Status Badge -->
                    <template x-if="status === 'connected'">
                        <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 border border-emerald-300 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                            🟢 Connected: +<span x-text="phone"></span>
                        </span>
                    </template>
                    <template x-if="status === 'qr_required'">
                        <span class="px-3 py-1 rounded-full text-xs font-black bg-amber-100 text-amber-800 border border-amber-300 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                            🟡 Scan QR Code Below
                        </span>
                    </template>
                    <template x-if="status === 'offline'">
                        <span class="px-3 py-1 rounded-full text-xs font-black bg-rose-100 text-rose-800 border border-rose-300">
                            🔴 API Offline
                        </span>
                    </template>
                </div>

                <!-- QR CODE & CONNECTION INSTRUCTIONS -->
                <div class="flex flex-col sm:flex-row items-center gap-6 p-4 rounded-lg bg-[#f6f9fc] border border-[#cbd8e4]">
                    
                    <!-- QR Image View -->
                    <div class="w-44 h-44 bg-white p-2 rounded-lg shadow flex items-center justify-center border border-[#9ab3c9]">
                        <template x-if="status === 'connected'">
                            <div class="text-center p-3">
                                <span class="text-4xl block mb-1">✅</span>
                                <span class="text-xs font-black text-slate-900 block">WhatsApp Paired!</span>
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
                    <div class="space-y-2 text-xs text-slate-700 flex-grow">
                        <h3 class="font-black text-slate-900 text-sm">How to Connect Your WhatsApp Number:</h3>
                        <ol class="list-decimal list-inside space-y-1 text-slate-600 text-xs font-medium">
                            <li>Open <strong>WhatsApp</strong> on your mobile phone.</li>
                            <li>Tap <strong>Menu / Settings</strong> (3 dots on Android, Settings gear on iPhone).</li>
                            <li>Select <strong>Linked Devices</strong> ➔ Tap <strong>Link a Device</strong>.</li>
                            <li>Point your phone camera at the <strong>QR Code</strong> on the left.</li>
                        </ol>

                        <p class="text-xs text-[#007cb5] pt-1 font-bold">
                            ✨ Once paired, sales invoice confirmations will automatically dispatch in background without opening browser tabs!
                        </p>

                        <template x-if="status === 'connected'">
                            <button type="button" @click="logout()" class="mt-3 px-3.5 py-1.5 rounded bg-rose-600 hover:bg-rose-700 text-white font-black shadow-sm text-xs transition-all">
                                🔌 Disconnect / Pair New Number
                            </button>
                        </template>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
