<x-app-layout>
    <div class="py-4" x-data="{
        mode: '{{ isset($currentVoucher) ? 'view' : 'new' }}',
        hasRecord: {{ isset($currentVoucher) ? 'true' : 'false' }},
        showFindModal: false,
        searchQuery: '',
        tableFilter: '',
        voucherType: '{{ $type }}',

        // Parties Combobox
        partiesList: [
            @foreach($parties as $p)
                { 
                    id: '{{ $p->id }}', 
                    name: '{{ addslashes($p->name) }}', 
                    type: '{{ ucfirst($p->type) }}', 
                    balance: {{ (float) $p->current_balance }},
                    formattedBalance: '{{ number_format($p->current_balance, 2) }}' 
                },
            @endforeach
        ],
        partySearchText: '{{ $currentVoucher && $currentVoucher->party ? addslashes($currentVoucher->party->name) : '' }}',
        partyFilterQuery: '',
        partyOpen: false,
        highlightedIndex: 0,

        form: {
            id: '{{ $currentVoucher->id ?? '' }}',
            type: '{{ $type }}',
            date: '{{ old('date', $currentVoucher ? $currentVoucher->date : date('Y-m-d')) }}',
            party_id: '{{ old('party_id', $currentVoucher ? $currentVoucher->party_id : '') }}',
            voucher_no: '{{ old('voucher_no', $currentVoucher ? $currentVoucher->voucher_no : $nextVoucherNo) }}',
            payment_mode: '{{ old('payment_mode', $currentVoucher ? $currentVoucher->payment_mode : 'Cash') }}',
            reference_no: '{{ old('reference_no', $currentVoucher ? $currentVoucher->reference_no : '') }}',
            amount: '{{ old('amount', $currentVoucher ? $currentVoucher->amount : 0) }}',
            remarks: '{{ old('remarks', $currentVoucher ? $currentVoucher->remarks : '') }}'
        },

        get currentParty() {
            if (!this.form.party_id) return null;
            return this.partiesList.find(p => p.id == this.form.party_id) || null;
        },

        get filteredParties() {
            if (!this.partyFilterQuery || this.partyFilterQuery.trim() === '') {
                return this.partiesList;
            }
            const q = this.partyFilterQuery.toLowerCase();
            return this.partiesList.filter(p => p.name.toLowerCase().includes(q) || p.type.toLowerCase().includes(q));
        },

        openPartyDropdown() {
            if (this.mode === 'view') return;
            this.partyOpen = true;
            this.partyFilterQuery = '';
            const idx = this.partiesList.findIndex(p => p.id == this.form.party_id);
            this.highlightedIndex = idx >= 0 ? idx : 0;
            this.scrollHighlightedIntoView();
        },

        focusParty() {
            const el = document.getElementById('field-party-input');
            if (el) {
                el.focus();
                if (el.select) el.select();
            }
        },

        selectParty(party) {
            if (!party) return;
            this.form.party_id = party.id;
            this.partySearchText = party.name;
            this.partyFilterQuery = '';
            this.partyOpen = false;
            this.$nextTick(() => {
                this.focusNext('field-payment-mode');
            });
        },

        onPartyEnter() {
            if (this.partyOpen && this.filteredParties.length > 0) {
                const selected = this.filteredParties[this.highlightedIndex] || this.filteredParties[0];
                this.selectParty(selected);
            } else if (!this.partyOpen && !this.form.party_id) {
                this.openPartyDropdown();
            } else {
                this.partyOpen = false;
                this.focusNext('field-payment-mode');
            }
        },

        onPartyArrowDown() {
            if (!this.partyOpen) {
                this.openPartyDropdown();
            } else if (this.highlightedIndex < this.filteredParties.length - 1) {
                this.highlightedIndex++;
                this.scrollHighlightedIntoView();
            }
        },

        onPartyArrowUp() {
            if (this.highlightedIndex > 0) {
                this.highlightedIndex--;
                this.scrollHighlightedIntoView();
            }
        },

        scrollHighlightedIntoView() {
            this.$nextTick(() => {
                const el = document.getElementById('party-opt-' + this.highlightedIndex);
                if (el) el.scrollIntoView({ block: 'nearest' });
            });
        },

        startNew() {
            this.mode = 'new';
            this.hasRecord = false;
            this.form.id = '';
            this.form.date = '{{ date('Y-m-d') }}';
            this.form.party_id = '';
            this.partySearchText = '';
            this.partyFilterQuery = '';
            this.partyOpen = false;
            this.form.voucher_no = '{{ $nextVoucherNo }}';
            this.form.payment_mode = 'Cash';
            this.form.reference_no = '';
            this.form.amount = 0;
            this.form.remarks = '';
            this.$nextTick(() => {
                this.focusParty();
            });
        },

        startEdit() {
            if (!this.hasRecord) return;
            this.mode = 'edit';
            this.$nextTick(() => {
                this.focusParty();
            });
        },

        refreshForm() {
            if (this.hasRecord && this.form.id) {
                window.location.href = '{{ route('vouchers.index', $type) }}?id=' + this.form.id;
            } else {
                window.location.href = '{{ route('vouchers.index', $type) }}';
            }
        },

        focusNext(targetId) {
            const el = document.getElementById(targetId);
            if (el) {
                el.focus();
                if (el.select) el.select();
            }
        },

        saveVoucher() {
            if (this.mode === 'view') {
                this.startEdit();
                return;
            }
            if (!this.form.party_id) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Party Required',
                    text: 'Please select a Party / Account before saving.',
                    confirmButtonColor: '#00a2e8'
                }).then(() => {
                    this.focusParty();
                });
                return;
            }
            if (parseFloat(this.form.amount) <= 0 || isNaN(parseFloat(this.form.amount))) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Amount Required',
                    text: 'Please enter a valid voucher amount greater than 0.',
                    confirmButtonColor: '#00a2e8'
                }).then(() => {
                    this.focusNext('field-amount');
                });
                return;
            }
            document.getElementById('erp-voucher-form').submit();
        },

        confirmDelete() {
            if (!this.hasRecord) return;
            Swal.fire({
                title: 'Delete {{ ucfirst($type) }} Voucher?',
                html: `Are you sure you want to delete voucher <b>${this.form.voucher_no}</b> for <b style='color:#007cb5'>Rs. ${parseFloat(this.form.amount || 0).toLocaleString()}</b>?<br><span style='color:#dc2626; font-size:12px;'>This will reverse the ledger entry and recalculate party balance.</span>`,
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
                this.saveVoucher();
            } else if (e.altKey && e.key.toLowerCase() === 'r') {
                e.preventDefault();
                this.refreshForm();
            } else if (e.altKey && e.key.toLowerCase() === 'd') {
                e.preventDefault();
                this.confirmDelete();
            } else if (e.key === 'Escape') {
                if (this.partyOpen) {
                    this.partyOpen = false;
                } else if (this.showFindModal) {
                    this.showFindModal = false;
                }
            }
        }
    }" @keydown.window="handleKey($event)">
        
        <div class="max-w-6xl mx-auto px-2 sm:px-4 space-y-3 font-sans">

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

            @if($errors->any())
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

            <!-- Main ERP Form Window Card matching Reference Image -->
            <div class="bg-white border-2 border-[#0092d0] rounded-lg shadow-xl overflow-hidden font-sans">
                
                <!-- DAWN Header Component matching Reference Image -->
                <x-dawn-header 
                    title="{{ $type === 'receipt' ? 'A Receipts Voucher' : 'B Payments Voucher' }}" 
                    icon="cash" 
                    formId="erp-voucher-form"
                    :exitRoute="route('dashboard')"
                />

                <!-- Form Area: Classic Desktop ERP Layout with Intelligent Enter Key Progression -->
                <form id="erp-voucher-form" method="POST" action="{{ route('vouchers.store') }}" @submit.prevent="saveVoucher()" class="p-6 bg-[#eaf0f6] min-h-[380px] flex flex-col justify-between">
                    @csrf
                    
                    <input type="hidden" name="id" x-model="form.id" />
                    <input type="hidden" name="type" value="{{ $type }}" />

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                        
                        <!-- Left: Core Voucher Fields (Enter-Key Progression) -->
                        <div class="lg:col-span-8 space-y-4 max-w-xl">
                            
                            <!-- 1. Date // (Enter -> Party) -->
                            <div class="flex items-center gap-4">
                                <label class="w-40 shrink-0 text-sm font-black text-slate-900 flex items-center justify-between">
                                    <span>Date</span>
                                    <span class="text-[#00a2e8] font-mono font-black text-base mr-3">//</span>
                                </label>
                                <div class="w-full max-w-md">
                                    <input type="date" 
                                           name="date" 
                                           id="field-date"
                                           x-model="form.date"
                                           :readonly="mode === 'view'"
                                           :class="mode === 'view' ? 'bg-[#f0f4f8] text-slate-700 cursor-not-allowed' : 'bg-white text-slate-900'"
                                           @keydown.enter.prevent="focusParty()"
                                           required 
                                           class="w-full h-[38px] px-3 py-1.5 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-sm font-semibold shadow-sm font-mono" />
                                </div>
                            </div>

                            <!-- 2. Party (Enter opens dropdown or moves to Payment Mode) -->
                            <div class="flex items-center gap-4 relative" @click.away="partyOpen = false">
                                <label class="w-40 shrink-0 text-sm font-black text-slate-900">
                                    Party / Account
                                </label>
                                <div class="w-full max-w-md relative">
                                    <input type="hidden" name="party_id" :value="form.party_id" required />

                                    <div class="relative">
                                        <input type="text"
                                               id="field-party-input"
                                               x-model="partySearchText"
                                               :readonly="mode === 'view'"
                                               :class="mode === 'view' ? 'bg-[#f0f4f8] text-slate-700 cursor-not-allowed' : 'bg-white text-slate-900'"
                                               placeholder="-- Type or Select Party Account --"
                                               autocomplete="off"
                                               @input="partyFilterQuery = partySearchText; partyOpen = true; highlightedIndex = 0;"
                                               @click="if(mode !== 'view') openPartyDropdown()"
                                               @keydown.enter.prevent="onPartyEnter()"
                                               @keydown.arrow-down.prevent="onPartyArrowDown()"
                                               @keydown.arrow-up.prevent="onPartyArrowUp()"
                                               @keydown.escape="partyOpen = false"
                                               class="w-full h-[38px] px-3 py-1.5 pr-8 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-sm font-semibold shadow-sm" />
                                        
                                        <button type="button" 
                                                @click="if(mode !== 'view') { if(!partyOpen) { openPartyDropdown(); } else { partyOpen = false; } }"
                                                tabindex="-1"
                                                class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                        </button>
                                    </div>

                                    <!-- Custom Searchable Dropdown List -->
                                    <div x-show="partyOpen && mode !== 'view'" 
                                         x-cloak 
                                         style="display: none;"
                                         class="absolute left-0 top-full mt-1 w-full bg-white border border-[#9ab3c9] rounded shadow-2xl z-50 max-h-56 overflow-y-auto">
                                        <template x-for="(party, idx) in filteredParties" :key="party.id">
                                            <div :id="'party-opt-' + idx"
                                                 @click="selectParty(party)"
                                                 :class="highlightedIndex === idx ? 'bg-[#00a2e8] text-white' : 'hover:bg-[#eaf4fa] text-slate-900'"
                                                 class="px-3 py-2 cursor-pointer text-xs flex items-center justify-between border-b border-slate-100 last:border-b-0">
                                                <div>
                                                    <span class="font-bold" x-text="party.name"></span>
                                                    <span class="text-[10px] opacity-75 ml-1.5" x-text="'(' + party.type + ')'"></span>
                                                </div>
                                                <span class="font-mono text-[11px] font-semibold opacity-90" x-text="'Bal: Rs. ' + party.formattedBalance"></span>
                                            </div>
                                        </template>
                                        <div x-show="filteredParties.length === 0" class="p-3 text-center text-xs text-slate-400">
                                            No matching party found.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Voucher# -->
                            <div class="flex items-center gap-4">
                                <label class="w-40 shrink-0 text-sm font-black text-slate-900">
                                    Voucher#
                                </label>
                                <div class="w-full max-w-md">
                                    <input type="text" 
                                           name="voucher_no" 
                                           id="field-voucher-no"
                                           x-model="form.voucher_no"
                                           :readonly="mode === 'view'"
                                           :class="mode === 'view' ? 'bg-[#f0f4f8] text-slate-700 cursor-not-allowed' : 'bg-white text-slate-900'"
                                           required 
                                           class="w-full h-[38px] px-3 py-1.5 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-sm font-bold shadow-sm font-mono" />
                                </div>
                            </div>

                            <!-- 4. Payment Mode (Enter -> Amount) -->
                            <div class="flex items-center gap-4">
                                <label class="w-40 shrink-0 text-sm font-black text-slate-900">
                                    Payment Mode
                                </label>
                                <div class="w-full max-w-md">
                                    <select name="payment_mode"
                                            id="field-payment-mode"
                                            x-model="form.payment_mode"
                                            :disabled="mode === 'view'"
                                            @keydown.enter.prevent="focusNext('field-amount')"
                                            class="w-full h-[38px] px-3 py-1.5 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-sm font-semibold shadow-sm bg-white">
                                        <option value="Cash">Cash In Hand</option>
                                        <option value="Bank Transfer">Bank Transfer / Online</option>
                                        <option value="Cheque">Bank Cheque</option>
                                        <option value="Pay Order">Pay Order / Demand Draft</option>
                                    </select>
                                </div>
                            </div>

                            <!-- 5. Amount (Enter -> Reference No) -->
                            <div class="flex items-center gap-4">
                                <label class="w-40 shrink-0 text-sm font-black text-slate-900">
                                    Amount
                                </label>
                                <div class="w-full max-w-md">
                                    <input type="number" 
                                           step="0.01" 
                                           min="0"
                                           name="amount" 
                                           id="field-amount"
                                           x-model="form.amount"
                                           :readonly="mode === 'view'"
                                           :class="mode === 'view' ? 'bg-[#f0f4f8] text-slate-700 cursor-not-allowed' : '{{ $type === 'receipt' ? 'bg-white text-emerald-700 font-black' : 'bg-white text-rose-700 font-black' }}'"
                                           @keydown.enter.prevent="focusNext('field-reference-no')"
                                           required 
                                           class="w-full h-[38px] px-3 py-1.5 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-base shadow-sm font-mono" />
                                </div>
                            </div>

                            <!-- 6. Reference / Cheque # (Enter -> Remarks) -->
                            <div class="flex items-center gap-4">
                                <label class="w-40 shrink-0 text-sm font-black text-slate-900">
                                    Ref / Cheque #
                                </label>
                                <div class="w-full max-w-md">
                                    <input type="text" 
                                           name="reference_no" 
                                           id="field-reference-no"
                                           x-model="form.reference_no"
                                           :readonly="mode === 'view'"
                                           :class="mode === 'view' ? 'bg-[#f0f4f8] text-slate-700 cursor-not-allowed' : 'bg-white text-slate-900'"
                                           @keydown.enter.prevent="focusNext('field-remarks')"
                                           placeholder="Optional Cheque #, Transaction ID, or Slip Ref"
                                           class="w-full h-[38px] px-3 py-1.5 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-xs shadow-sm font-mono" />
                                </div>
                            </div>

                            <!-- 7. Remarks (Enter -> Save) -->
                            <div class="flex items-center gap-4">
                                <label class="w-40 shrink-0 text-sm font-black text-slate-900">
                                    Narration / Note
                                </label>
                                <div class="w-full max-w-md">
                                    <input type="text" 
                                           name="remarks" 
                                           id="field-remarks"
                                           x-model="form.remarks"
                                           :readonly="mode === 'view'"
                                           :class="mode === 'view' ? 'bg-[#f0f4f8] text-slate-700 cursor-not-allowed' : 'bg-white text-slate-900'"
                                           @keydown.enter.prevent="saveVoucher()"
                                           placeholder="Optional voucher remarks / payment details (Press Enter to Save)"
                                           class="w-full h-[38px] px-3 py-1.5 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-xs shadow-sm" />
                                </div>
                            </div>

                        </div>

                        <!-- Right: Live Party Balance Card & Financial Audit -->
                        <div class="lg:col-span-4 bg-white border-2 border-[#cbd8e4] rounded-lg p-4 shadow-sm space-y-3">
                            <div class="flex items-center justify-between pb-2 border-b border-[#e2ebf3]">
                                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Party Ledger Impact</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase {{ $type === 'receipt' ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-rose-100 text-rose-800 border border-rose-300' }}">
                                    {{ $type === 'receipt' ? 'Cash Received (Cr)' : 'Cash Paid (Dr)' }}
                                </span>
                            </div>

                            <template x-if="currentParty">
                                <div class="space-y-3">
                                    <div>
                                        <h4 class="text-base font-black text-slate-900" x-text="currentParty.name"></h4>
                                        <span class="text-xs text-slate-500 font-semibold" x-text="'Account Type: ' + currentParty.type"></span>
                                    </div>

                                    <div class="bg-[#f4f8fb] border border-[#cbd8e4] rounded p-3">
                                        <span class="text-[11px] font-bold text-slate-600 uppercase block">Current Ledger Balance</span>
                                        <span class="text-xl font-black font-mono text-[#007cb5]" x-text="'Rs. ' + currentParty.formattedBalance"></span>
                                    </div>

                                    <div class="bg-slate-50 border border-slate-200 rounded p-2.5 text-xs text-slate-700 space-y-1 font-mono">
                                        <div class="flex justify-between">
                                            <span>Voucher Amount:</span>
                                            <span class="font-bold text-slate-900" x-text="'Rs. ' + (parseFloat(form.amount) || 0).toLocaleString()"></span>
                                        </div>
                                        <div class="flex justify-between pt-1 border-t border-slate-200">
                                            <span>Est. New Balance:</span>
                                            <span class="font-black {{ $type === 'receipt' ? 'text-emerald-700' : 'text-slate-900' }}" 
                                                  x-text="'Rs. ' + ((currentParty.balance - (parseFloat(form.amount) || 0))).toLocaleString()"></span>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <template x-if="!currentParty">
                                <div class="py-6 text-center text-slate-400 text-xs">
                                    <svg class="w-8 h-8 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    <span>Select a Party / Account on the left to view live ledger balance & impact.</span>
                                </div>
                            </template>
                        </div>

                    </div>

                    <!-- Bottom Status Strip matching Desktop ERP -->
                    <div class="pt-6 border-t border-[#c3d1df] flex flex-col sm:flex-row items-center justify-between text-xs text-slate-600 gap-2 mt-4">
                        <div class="flex items-center gap-2 font-mono">
                            <span class="px-2 py-0.5 rounded bg-white border border-[#cbd8e4] font-bold text-[#007cb5]">DESKTOP KEYBOARD ENGINE ACTIVE</span>
                            <span>Press <kbd class="px-1 py-0.5 bg-white border border-slate-300 rounded font-bold font-mono">Enter ↵</kbd> in Party dropdown to select option & jump to next field</span>
                        </div>

                        <div>
                            <template x-if="mode === 'new'">
                                <span class="bg-emerald-100 text-emerald-800 border border-emerald-300 font-bold px-3 py-1 rounded">
                                    ● New Mode: Enter fields & Press [Enter ↵] to save
                                </span>
                            </template>
                            <template x-if="mode === 'view'">
                                <span class="bg-sky-100 text-sky-800 border border-sky-300 font-bold px-3 py-1 rounded">
                                    ● Loaded: Press [Alt+E] to Edit or [Alt+D] to Delete
                                </span>
                            </template>
                            <template x-if="mode === 'edit'">
                                <span class="bg-amber-100 text-amber-800 border border-amber-300 font-bold px-3 py-1 rounded animate-pulse">
                                    ● Editing: Update Amount & Press [Enter ↵]
                                </span>
                            </template>
                        </div>
                    </div>

                </form>

            </div>

            <!-- REGISTERED VOUCHERS DIRECTORY TABLE (Below Form, Matching Parties / Sales) -->
            <div class="bg-white rounded-lg border-2 border-[#cbd8e4] p-4 shadow-md space-y-3 font-sans">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-2 border-b border-[#cbd8e4]">
                    <div>
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-wide">
                            Registered {{ ucfirst($type) }} Vouchers Directory
                        </h3>
                        <p class="text-xs text-slate-600 font-medium">Click any voucher to load into the desktop window for review or modification</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="text" 
                               x-model="tableFilter" 
                               placeholder="Filter table by Voucher#, Party, or Ref..." 
                               class="px-3 py-1 text-xs border border-[#9ab3c9] focus:border-[#00a2e8] rounded shadow-sm w-64" />
                        <span class="text-xs font-mono text-[#007cb5] bg-[#eaf4fa] border border-[#00a2e8] px-2.5 py-1 rounded font-bold">
                            Total: {{ count($allVouchers) }} Vouchers
                        </span>
                    </div>
                </div>

                <div class="overflow-x-auto rounded border border-[#cbd8e4]">
                    <table class="w-full text-left text-xs border border-[#cbd8e4]">
                        <thead class="bg-[#eaf1f7] text-slate-900 uppercase font-mono font-black border-b-2 border-[#cbd8e4]">
                            <tr>
                                <th class="p-2.5 border-r border-[#cbd8e4]">Voucher #</th>
                                <th class="p-2.5 border-r border-[#cbd8e4]">Date</th>
                                <th class="p-2.5 border-r border-[#cbd8e4]">Party Name</th>
                                <th class="p-2.5 border-r border-[#cbd8e4]">Payment Mode</th>
                                <th class="p-2.5 border-r border-[#cbd8e4]">Ref #</th>
                                <th class="p-2.5 border-r border-[#cbd8e4] text-right font-black">Amount (Rs.)</th>
                                <th class="p-2.5 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#e2ebf3]">
                            @forelse($allVouchers as $v)
                                <tr x-show="!tableFilter || '{{ strtolower($v->voucher_no . ' ' . ($v->party->name ?? '') . ' ' . $v->payment_mode . ' ' . $v->reference_no . ' ' . $v->date) }}'.includes(tableFilter.toLowerCase())"
                                    class="hover:bg-[#f6f9fc] transition-colors {{ isset($currentVoucher) && $currentVoucher->id === $v->id ? 'bg-[#eaf4fa] font-semibold' : '' }}">
                                    <td class="p-2.5 border-r border-[#e2ebf3] font-mono font-bold text-[#007cb5]">{{ $v->voucher_no }}</td>
                                    <td class="p-2.5 border-r border-[#e2ebf3] font-mono text-slate-700 font-semibold">{{ $v->date }}</td>
                                    <td class="p-2.5 border-r border-[#e2ebf3] font-bold text-slate-900">{{ $v->party->name ?? 'N/A' }}</td>
                                    <td class="p-2.5 border-r border-[#e2ebf3]">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-slate-100 border border-slate-300 text-slate-800">
                                            {{ $v->payment_mode }}
                                        </span>
                                    </td>
                                    <td class="p-2.5 border-r border-[#e2ebf3] font-mono text-slate-600">{{ $v->reference_no ?? '-' }}</td>
                                    <td class="p-2.5 border-r border-[#e2ebf3] text-right font-mono font-black text-sm {{ $type === 'receipt' ? 'text-emerald-700' : 'text-rose-700' }}">
                                        Rs. {{ number_format($v->amount, 2) }}
                                    </td>
                                    <td class="p-2.5 text-center">
                                        <a href="{{ route('vouchers.index', ['type' => $type, 'id' => $v->id]) }}" 
                                           class="px-2.5 py-1 rounded bg-[#e8f4fa] hover:bg-[#d0ebf8] text-[#007cb5] text-xs font-bold border border-[#00a2e8] transition-all">
                                            Load & Edit →
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-6 text-center text-slate-500">No {{ $type }} vouchers recorded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Hidden Delete Form -->
        @if(isset($currentVoucher))
            <form id="delete-form" method="POST" action="{{ route('vouchers.destroy', $currentVoucher->id) }}" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endif

        <!-- FIND / SEARCH VOUCHERS MODAL -->
        <div x-show="showFindModal" x-cloak style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
            <div @click.away="showFindModal = false" class="bg-white rounded-lg max-w-2xl w-full border-2 border-[#0092d0] shadow-2xl max-h-[85vh] flex flex-col overflow-hidden font-sans">
                <!-- Header -->
                <div class="bg-[#00a2e8] text-white p-3.5 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <h3 class="text-base font-extrabold font-sans">Find / Search {{ ucfirst($type) }} Vouchers</h3>
                    </div>
                    <button type="button" @click="showFindModal = false" class="text-white hover:text-slate-200 font-bold text-lg leading-none">✕</button>
                </div>

                <!-- Search Input Bar -->
                <div class="p-3 bg-[#eaf1f7] border-b border-[#cbd8e4]">
                    <div class="relative">
                        <input type="text" 
                               x-model="searchQuery" 
                               placeholder="Type Voucher#, Party Name, Ref, or Amount to filter..."
                               class="w-full px-3.5 py-2 pl-9 bg-white border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-xs font-semibold" />
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>

                <!-- Vouchers List -->
                <div class="p-3 overflow-y-auto flex-grow space-y-2 bg-[#f4f7fa]">
                    @forelse($allVouchers as $v)
                        <div x-show="!searchQuery || '{{ strtolower($v->voucher_no . ' ' . ($v->party->name ?? '') . ' ' . $v->payment_mode . ' ' . $v->reference_no . ' ' . $v->date . ' ' . $v->amount) }}'.includes(searchQuery.toLowerCase())">
                            <a href="{{ route('vouchers.index', ['type' => $type, 'id' => $v->id]) }}" 
                               class="flex items-center justify-between p-3 rounded bg-white border border-[#cbd8e4] hover:border-[#00a2e8] hover:bg-[#eaf4fa] transition-all shadow-sm group">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono font-bold text-[#007cb5] text-sm group-hover:underline">{{ $v->voucher_no }}</span>
                                        <span class="text-[10px] font-bold text-slate-600 bg-slate-100 px-1.5 py-0.5 rounded border border-slate-200">{{ $v->payment_mode }}</span>
                                    </div>
                                    <span class="text-xs text-slate-700 font-semibold">{{ $v->party->name ?? 'N/A' }}</span>
                                    <span class="text-[11px] text-slate-500 ml-2 font-mono">• Date: {{ $v->date }}</span>
                                    @if($v->reference_no)
                                        <span class="text-[11px] text-slate-500 ml-2 font-mono">• Ref: {{ $v->reference_no }}</span>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <span class="font-mono font-black text-base {{ $type === 'receipt' ? 'text-emerald-700' : 'text-rose-700' }}">Rs. {{ number_format($v->amount, 2) }}</span>
                                    <span class="block text-[11px] text-[#007cb5] font-bold">Click to Load & View →</span>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-500 text-xs">No {{ $type }} vouchers recorded yet.</div>
                    @endforelse
                </div>

                <div class="bg-[#eaeff5] p-3 border-t border-[#cbd8e4] flex items-center justify-between text-xs text-slate-600">
                    <span>Total Vouchers: {{ count($allVouchers) }}</span>
                    <button type="button" @click="showFindModal = false" class="px-4 py-1.5 bg-slate-700 hover:bg-slate-800 text-white rounded font-bold">
                        Close
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
