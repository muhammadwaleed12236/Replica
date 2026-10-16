<x-app-layout>
    <div class="py-4" x-data="{
        mode: '{{ isset($currentParty) ? 'view' : 'new' }}',
        hasRecord: {{ isset($currentParty) ? 'true' : 'false' }},
        showFindModal: false,
        searchQuery: '',
        tableFilter: '',
        
        form: {
            id: '{{ $currentParty->id ?? '' }}',
            code: '{{ old('code', $currentParty ? $currentParty->code : $nextCode) }}',
            name: '{{ old('name', $currentParty ? addslashes($currentParty->name) : '') }}',
            type: '{{ old('type', $currentParty ? $currentParty->type : 'customer') }}',
            phone: '{{ old('phone', $currentParty ? addslashes($currentParty->phone) : '') }}',
            city: '{{ old('city', $currentParty ? addslashes($currentParty->city) : '') }}',
            opening_balance: '{{ old('opening_balance', $currentParty ? $currentParty->opening_balance : 0) }}',
            credit_limit: '{{ old('credit_limit', $currentParty ? $currentParty->credit_limit : 0) }}',
            credit_days_limit: '{{ old('credit_days_limit', $currentParty ? $currentParty->credit_days_limit : 30) }}',
            current_balance: '{{ $currentParty ? number_format($currentParty->current_balance, 2) : '0.00' }}'
        },

        startNew() {
            this.mode = 'new';
            this.hasRecord = false;
            this.form.id = '';
            this.form.code = '{{ $nextCode }}';
            this.form.name = '';
            this.form.type = 'customer';
            this.form.phone = '';
            this.form.city = '';
            this.form.opening_balance = 0;
            this.form.credit_limit = 0;
            this.form.credit_days_limit = 30;
            this.form.current_balance = '0.00';
            this.$nextTick(() => {
                this.focusNext('field-name');
            });
        },

        startEdit() {
            if (!this.hasRecord) return;
            this.mode = 'edit';
            this.$nextTick(() => {
                this.focusNext('field-name');
            });
        },

        refreshForm() {
            if (this.hasRecord && this.form.id) {
                window.location.href = '{{ route('parties.index') }}?id=' + this.form.id;
            } else {
                window.location.href = '{{ route('parties.index') }}';
            }
        },

        focusNext(targetId) {
            const el = document.getElementById(targetId);
            if (el) {
                el.focus();
                if (el.select) el.select();
            }
        },

        saveParty() {
            if (this.mode === 'view') {
                this.startEdit();
                return;
            }
            if (!this.form.name || this.form.name.trim() === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Party Name Required',
                    text: 'Please enter a party / account name before saving.',
                    confirmButtonColor: '#00a2e8'
                }).then(() => {
                    this.focusNext('field-name');
                });
                return;
            }
            document.getElementById('erp-parties-form').submit();
        },

        confirmDelete() {
            if (!this.hasRecord) return;
            Swal.fire({
                title: 'Delete Party Ledger?',
                html: `Are you sure you want to delete <b>${this.form.name}</b> (<b>${this.form.code}</b>)?<br><span style='color:#dc2626; font-size:12px;'>This will remove this party from your accounts ledger.</span>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, Delete It',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form').submit();
                }
            });
        },

        handleKey(e) {
            if (e.altKey && e.key.toLowerCase() === 'n') {
                e.preventDefault();
                this.startNew();
            } else if (e.altKey && e.key.toLowerCase() === 'f') {
                e.preventDefault();
                this.showFindModal = true;
            } else if (e.altKey && e.key.toLowerCase() === 'e') {
                e.preventDefault();
                this.startEdit();
            } else if (e.altKey && e.key.toLowerCase() === 's') {
                e.preventDefault();
                this.saveParty();
            } else if (e.altKey && e.key.toLowerCase() === 'r') {
                e.preventDefault();
                this.refreshForm();
            } else if (e.altKey && e.key.toLowerCase() === 'd') {
                e.preventDefault();
                this.confirmDelete();
            } else if (e.key === 'Escape') {
                if (this.showFindModal) {
                    this.showFindModal = false;
                }
            }
        }
    }" @keydown.window="handleKey($event)">
        
        <div class="max-w-6xl mx-auto px-2 sm:px-4 space-y-4">

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

            @if(isset($errors) && $errors->any())
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Action Blocked',
                            text: '{{ $errors->first() }}',
                            confirmButtonColor: '#dc2626'
                        });
                    });
                </script>
            @endif

            <!-- Main ERP Form Window Card matching Sales & Purchases Reference -->
            <div class="bg-white border-2 border-[#0092d0] rounded-lg shadow-xl overflow-hidden font-sans">
                
                <!-- DAWN Header Component for Parties -->
                <x-dawn-header 
                    title="1 Parties & Accounts" 
                    icon="users" 
                    formId="erp-parties-form"
                    :exitRoute="route('dashboard')"
                />

                <!-- Form Area: Desktop ERP Form Layout with Enter Key Progression -->
                <form id="erp-parties-form" method="POST" action="{{ route('parties.store') }}" @submit.prevent="saveParty()" class="p-6 bg-[#eaf0f6] min-h-[380px] flex flex-col justify-between">
                    @csrf
                    
                    <input type="hidden" name="id" x-model="form.id" />

                    <!-- Core Form Fields (Enter Key Navigation Flow) -->
                    <div class="space-y-4 max-w-2xl">
                        
                        <!-- 1. Party Code // (Enter -> Party Name) -->
                        <div class="flex items-center gap-4">
                            <label class="w-40 shrink-0 text-sm font-black text-slate-900 flex items-center justify-between">
                                <span>Party Code</span>
                                <span class="text-[#00a2e8] font-mono font-black text-base mr-3">//</span>
                            </label>
                            <div class="w-full max-w-md">
                                <input type="text" 
                                       name="code" 
                                       id="field-code"
                                       x-model="form.code"
                                       :readonly="mode === 'view'"
                                       :class="mode === 'view' ? 'bg-[#f0f4f8] text-slate-700 cursor-not-allowed' : 'bg-white text-[#007cb5] font-black'"
                                       @keydown.enter.prevent="focusNext('field-name')"
                                       required 
                                       class="w-full h-[38px] px-3 py-1.5 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-sm font-bold shadow-sm font-mono uppercase" />
                            </div>
                        </div>

                        <!-- 2. Party Name (Enter -> Type) -->
                        <div class="flex items-center gap-4">
                            <label class="w-40 shrink-0 text-sm font-black text-slate-900">
                                Party Name <span class="text-red-500">*</span>
                            </label>
                            <div class="w-full max-w-md">
                                <input type="text" 
                                       name="name" 
                                       id="field-name"
                                       x-model="form.name"
                                       :readonly="mode === 'view'"
                                       :class="mode === 'view' ? 'bg-[#f0f4f8] text-slate-700 cursor-not-allowed' : 'bg-white text-slate-900'"
                                       @keydown.enter.prevent="focusNext('field-type')"
                                       placeholder="e.g. Dawn Pharmacy, Apex Traders"
                                       required 
                                       class="w-full h-[38px] px-3 py-1.5 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-sm font-bold shadow-sm" />
                            </div>
                        </div>

                        <!-- 3. Account Type (Enter -> Phone) -->
                        <div class="flex items-center gap-4">
                            <label class="w-40 shrink-0 text-sm font-black text-slate-900">
                                Account Type
                            </label>
                            <div class="w-full max-w-md">
                                <select name="type" 
                                        id="field-type"
                                        x-model="form.type"
                                        :disabled="mode === 'view'"
                                        :class="mode === 'view' ? 'bg-[#f0f4f8] text-slate-700 cursor-not-allowed' : 'bg-white text-slate-900'"
                                        @keydown.enter.prevent="focusNext('field-phone')"
                                        required 
                                        class="w-full h-[38px] px-3 py-1.5 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-sm font-semibold shadow-sm">
                                    <option value="customer">Customer (Client / Buyer)</option>
                                    <option value="supplier">Supplier (Vendor / Distributor)</option>
                                    <option value="both">Both (Customer & Supplier)</option>
                                </select>
                            </div>
                        </div>

                        <!-- 4. Phone / WhatsApp (Enter -> City) -->
                        <div class="flex items-center gap-4">
                            <label class="w-40 shrink-0 text-sm font-black text-slate-900">
                                Phone / Mobile
                            </label>
                            <div class="w-full max-w-md">
                                <input type="text" 
                                       name="phone" 
                                       id="field-phone"
                                       x-model="form.phone"
                                       :readonly="mode === 'view'"
                                       :class="mode === 'view' ? 'bg-[#f0f4f8] text-slate-700 cursor-not-allowed' : 'bg-white text-slate-900'"
                                       @keydown.enter.prevent="focusNext('field-city')"
                                       placeholder="e.g. 0300-1234567"
                                       class="w-full h-[38px] px-3 py-1.5 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-sm font-semibold shadow-sm font-mono" />
                            </div>
                        </div>

                        <!-- 5. City / Town (Enter -> Opening Balance) -->
                        <div class="flex items-center gap-4">
                            <label class="w-40 shrink-0 text-sm font-black text-slate-900">
                                City / Area
                            </label>
                            <div class="w-full max-w-md">
                                <input type="text" 
                                       name="city" 
                                       id="field-city"
                                       x-model="form.city"
                                       :readonly="mode === 'view'"
                                       :class="mode === 'view' ? 'bg-[#f0f4f8] text-slate-700 cursor-not-allowed' : 'bg-white text-slate-900'"
                                       @keydown.enter.prevent="focusNext('field-opening-balance')"
                                       placeholder="e.g. Lahore, Karachi, Islamabad"
                                       class="w-full h-[38px] px-3 py-1.5 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-sm font-semibold shadow-sm" />
                            </div>
                        </div>

                        <!-- 6. Opening Balance (Enter -> Credit Limit) -->
                        <div class="flex items-center gap-4">
                            <label class="w-40 shrink-0 text-sm font-black text-slate-900">
                                Opening Bal (Rs.)
                            </label>
                            <div class="w-full max-w-md">
                                <input type="number" 
                                       step="0.01" 
                                       name="opening_balance" 
                                       id="field-opening-balance"
                                       x-model="form.opening_balance"
                                       :readonly="mode === 'view'"
                                       :class="mode === 'view' ? 'bg-[#f0f4f8] text-slate-700 cursor-not-allowed' : 'bg-white text-slate-900'"
                                       @keydown.enter.prevent="focusNext('field-credit-limit')"
                                       class="w-full h-[38px] px-3 py-1.5 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-sm font-bold shadow-sm font-mono" />
                            </div>
                        </div>

                        <!-- 7. Credit Limit (Enter -> Time Limit) -->
                        <div class="flex items-center gap-4">
                            <label class="w-40 shrink-0 text-sm font-black text-slate-900">
                                Credit Limit (Rs.)
                            </label>
                            <div class="w-full max-w-md">
                                <input type="number" 
                                       step="0.01" 
                                       min="0"
                                       name="credit_limit" 
                                       id="field-credit-limit"
                                       x-model="form.credit_limit"
                                       :readonly="mode === 'view'"
                                       :class="mode === 'view' ? 'bg-[#f0f4f8] text-slate-700 cursor-not-allowed' : 'bg-white text-slate-900'"
                                       placeholder="0 = No Limit"
                                       @keydown.enter.prevent="focusNext('field-credit-days')"
                                       class="w-full h-[38px] px-3 py-1.5 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-sm font-semibold shadow-sm font-mono text-amber-800" />
                            </div>
                        </div>

                        <!-- 8. Time Limit Days (Enter -> Save) -->
                        <div class="flex items-center gap-4">
                            <label class="w-40 shrink-0 text-sm font-black text-slate-900">
                                Time Limit (Days)
                            </label>
                            <div class="w-full max-w-md">
                                <input type="number" 
                                       min="0"
                                       name="credit_days_limit" 
                                       id="field-credit-days"
                                       x-model="form.credit_days_limit"
                                       :readonly="mode === 'view'"
                                       :class="mode === 'view' ? 'bg-[#f0f4f8] text-slate-700 cursor-not-allowed' : 'bg-white text-slate-900'"
                                       placeholder="30"
                                       @keydown.enter.prevent="saveParty()"
                                       class="w-full h-[38px] px-3 py-1.5 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-sm font-semibold shadow-sm font-mono" />
                            </div>
                        </div>

                        <!-- Live Ledger Balance Callout (When viewing loaded party) -->
                        <template x-if="hasRecord">
                            <div class="pt-2">
                                <div class="p-3 bg-white border border-[#9ab3c9] rounded-lg shadow-sm flex items-center justify-between max-w-md">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xl">💰</span>
                                        <div>
                                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Current Ledger Balance</span>
                                            <span class="text-[11px] text-slate-600 font-semibold" x-text="form.type === 'supplier' ? 'Payable to Vendor' : 'Receivable from Customer'"></span>
                                        </div>
                                    </div>
                                    <span class="text-lg font-black font-mono text-emerald-700">Rs. <span x-text="form.current_balance"></span></span>
                                </div>
                            </div>
                        </template>

                    </div>

                    <!-- Bottom Status Strip matching Desktop ERP -->
                    <div class="pt-6 border-t border-[#c3d1df] flex flex-col sm:flex-row items-center justify-between text-xs text-slate-600 gap-2">
                        <div class="flex items-center gap-2 font-mono">
                            <span class="px-2 py-0.5 rounded bg-white border border-[#cbd8e4] font-bold text-[#007cb5]">DESKTOP KEYBOARD ENGINE ACTIVE</span>
                            <span>Shortcuts: <kbd class="px-1 py-0.5 bg-white border border-slate-300 rounded font-bold">Alt+N</kbd> New • <kbd class="px-1 py-0.5 bg-white border border-slate-300 rounded font-bold">Alt+F</kbd> Find • <kbd class="px-1 py-0.5 bg-white border border-slate-300 rounded font-bold">Alt+E</kbd> Edit • <kbd class="px-1 py-0.5 bg-white border border-slate-300 rounded font-bold">Alt+S</kbd> Save</span>
                        </div>

                        <div class="flex items-center gap-3">
                            <template x-if="mode === 'new'">
                                <span class="bg-emerald-100 text-emerald-800 border border-emerald-300 font-bold px-3 py-1 rounded">
                                    ● New Mode: Fill fields & Press [Enter ↵] to save
                                </span>
                            </template>
                            <template x-if="mode === 'view'">
                                <span class="bg-sky-100 text-sky-800 border border-sky-300 font-bold px-3 py-1 rounded">
                                    ● Loaded: Press [Alt+E] to Edit or [Alt+D] to Delete
                                </span>
                            </template>
                            <template x-if="mode === 'edit'">
                                <span class="bg-amber-100 text-amber-800 border border-amber-300 font-bold px-3 py-1 rounded animate-pulse">
                                    ● Editing: Update fields & Press [Alt+S] or [Enter ↵]
                                </span>
                            </template>
                        </div>
                    </div>

                </form>

            </div>

            <!-- REGISTERED ACCOUNTS DIRECTORY TABLE (Below Form Window) -->
            <div class="bg-white border-2 border-[#0092d0] rounded-lg shadow-xl overflow-hidden font-sans">
                <!-- Directory Header Strip -->
                <div class="bg-[#eaf1f7] p-3 border-b border-[#cbd8e4] flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div class="flex items-center gap-2">
                        <span class="text-base">📋</span>
                        <span class="text-xs font-black text-slate-800 uppercase tracking-wider">Registered Accounts Directory</span>
                        <span class="px-2 py-0.5 bg-[#00a2e8] text-white rounded text-[11px] font-bold font-mono">{{ count($parties) }} Parties</span>
                    </div>

                    <!-- Fast Live Filter Input -->
                    <div class="w-full sm:w-72 relative">
                        <input type="text" 
                               x-model="tableFilter" 
                               placeholder="Quick search code, name, city..."
                               class="w-full px-3 py-1.5 pl-8 bg-white border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-xs font-semibold shadow-inner" />
                        <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead class="bg-[#f2f6fa] text-slate-800 uppercase font-mono font-bold border-b border-[#cbd8e4]">
                            <tr>
                                <th class="p-2.5 border-r border-[#cbd8e4]">Party Code</th>
                                <th class="p-2.5 border-r border-[#cbd8e4]">Party Name</th>
                                <th class="p-2.5 border-r border-[#cbd8e4]">Type</th>
                                <th class="p-2.5 border-r border-[#cbd8e4]">Phone / City</th>
                                <th class="p-2.5 border-r border-[#cbd8e4] text-right">Credit Limit</th>
                                <th class="p-2.5 border-r border-[#cbd8e4] text-center">Time Limit</th>
                                <th class="p-2.5 border-r border-[#cbd8e4] text-right">Current Balance</th>
                                <th class="p-2.5 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#e2ebf3]">
                            @forelse($parties as $p)
                                <tr x-show="!tableFilter || '{{ strtolower($p->code . ' ' . $p->name . ' ' . $p->type . ' ' . $p->phone . ' ' . $p->city) }}'.includes(tableFilter.toLowerCase())"
                                    class="hover:bg-[#eaf4fa] transition-colors cursor-pointer group {{ isset($currentParty) && $currentParty->id === $p->id ? 'bg-[#d8eef9] font-bold' : '' }}"
                                    @click="window.location.href = '{{ route('parties.index', ['id' => $p->id]) }}'">
                                    <td class="p-2.5 border-r border-[#e2ebf3] font-mono text-[#007cb5] font-bold group-hover:underline">
                                        {{ $p->code }}
                                    </td>
                                    <td class="p-2.5 border-r border-[#e2ebf3] font-bold text-slate-900">
                                        {{ $p->name }}
                                        @if(isset($currentParty) && $currentParty->id === $p->id)
                                            <span class="ml-1.5 px-1.5 py-0.5 rounded bg-[#00a2e8] text-white text-[9px] font-mono uppercase">Active</span>
                                        @endif
                                    </td>
                                    <td class="p-2.5 border-r border-[#e2ebf3]">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $p->type == 'customer' ? 'bg-[#e8f4fa] text-[#007cb5] border border-[#00a2e8]' : ($p->type == 'supplier' ? 'bg-amber-50 text-amber-800 border border-amber-300' : 'bg-purple-50 text-purple-800 border border-purple-300') }}">
                                            {{ $p->type }}
                                        </span>
                                    </td>
                                    <td class="p-2.5 border-r border-[#e2ebf3]">
                                        <span class="font-mono block text-slate-800">{{ $p->phone ?: 'N/A' }}</span>
                                        <span class="text-[10px] text-slate-500">{{ $p->city ?: 'N/A' }}</span>
                                    </td>
                                    <td class="p-2.5 border-r border-[#e2ebf3] text-right font-mono text-amber-800 font-bold">
                                        {{ $p->credit_limit > 0 ? 'Rs. ' . number_format($p->credit_limit, 2) : 'No Limit' }}
                                    </td>
                                    <td class="p-2.5 border-r border-[#e2ebf3] text-center font-mono text-slate-700">
                                        {{ $p->credit_days_limit ?? 30 }} Days
                                    </td>
                                    <td class="p-2.5 border-r border-[#e2ebf3] text-right font-mono font-bold text-emerald-700">
                                        Rs. {{ number_format($p->current_balance, 2) }}
                                    </td>
                                    <td class="p-2.5 text-center" @click.stop>
                                        <a href="{{ route('parties.index', ['id' => $p->id]) }}" 
                                           class="px-2 py-1 rounded bg-[#00a2e8] hover:bg-[#008ecb] text-white font-bold text-[11px] shadow-sm inline-block">
                                            Load / Edit →
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-8 text-center text-slate-500 text-xs">No registered accounts found. Press [Alt+N] to create a new party.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Hidden Delete Form -->
        @if(isset($currentParty))
            <form id="delete-form" method="POST" action="{{ route('parties.destroy', $currentParty->id) }}" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endif

        <!-- FIND / SEARCH PARTIES MODAL -->
        <div x-show="showFindModal" x-cloak style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
            <div @click.away="showFindModal = false" class="bg-white rounded-lg max-w-2xl w-full border-2 border-[#0092d0] shadow-2xl max-h-[85vh] flex flex-col overflow-hidden">
                <!-- Header -->
                <div class="bg-[#00a2e8] text-white p-3.5 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <h3 class="text-base font-extrabold font-sans">Find / Search Parties & Accounts</h3>
                    </div>
                    <button type="button" @click="showFindModal = false" class="text-white hover:text-slate-200 font-bold text-lg leading-none">✕</button>
                </div>

                <!-- Search Input Bar -->
                <div class="p-3 bg-[#eaf1f7] border-b border-[#cbd8e4]">
                    <div class="relative">
                        <input type="text" 
                               x-model="searchQuery" 
                               placeholder="Type Party Code, Name, Phone, or City to filter..."
                               class="w-full px-3.5 py-2 pl-9 bg-white border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-xs font-semibold" />
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>

                <!-- Invoices List -->
                <div class="p-3 overflow-y-auto flex-grow space-y-2 bg-[#f4f7fa]">
                    @forelse($parties as $p)
                        <div x-show="!searchQuery || '{{ strtolower($p->code . ' ' . $p->name . ' ' . $p->type . ' ' . $p->phone . ' ' . $p->city) }}'.includes(searchQuery.toLowerCase())">
                            <a href="{{ route('parties.index', ['id' => $p->id]) }}" 
                               class="flex items-center justify-between p-3 rounded bg-white border border-[#cbd8e4] hover:border-[#00a2e8] hover:bg-[#eaf4fa] transition-all shadow-sm group">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono font-bold text-[#007cb5] text-sm group-hover:underline">{{ $p->code }}</span>
                                        <span class="px-1.5 py-0.5 rounded text-[10px] font-bold uppercase {{ $p->type == 'customer' ? 'bg-[#e8f4fa] text-[#007cb5] border border-[#00a2e8]' : 'bg-amber-50 text-amber-800 border border-amber-300' }}">
                                            {{ $p->type }}
                                        </span>
                                    </div>
                                    <span class="text-xs text-slate-900 font-bold block mt-0.5">{{ $p->name }}</span>
                                    <span class="text-[11px] text-slate-500 font-mono">{{ $p->phone ?: 'No Phone' }} • {{ $p->city ?: 'No City' }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="font-mono font-black text-slate-900 text-base">Rs. {{ number_format($p->current_balance, 2) }}</span>
                                    <span class="block text-[11px] text-[#007cb5] font-bold">Click to Load & View →</span>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-500 text-xs">No registered accounts recorded yet.</div>
                    @endforelse
                </div>

                <div class="bg-[#eaeff5] p-3 border-t border-[#cbd8e4] flex items-center justify-between text-xs text-slate-600">
                    <span>Total Parties: {{ count($parties) }}</span>
                    <button type="button" @click="showFindModal = false" class="px-4 py-1.5 bg-slate-700 hover:bg-slate-800 text-white rounded font-bold">
                        Close
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
