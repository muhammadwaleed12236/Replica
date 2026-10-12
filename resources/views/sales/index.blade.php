<x-app-layout>
    <div class="py-4" x-data="{
        mode: '{{ isset($currentSale) ? 'view' : 'new' }}',
        hasRecord: {{ isset($currentSale) ? 'true' : 'false' }},
        showFindModal: false,
        searchQuery: '',
        
        // Parties Combobox
        partiesList: [
            @foreach($parties as $p)
                { id: '{{ $p->id }}', name: '{{ addslashes($p->name) }}', type: '{{ ucfirst($p->type) }}', balance: '{{ number_format($p->current_balance, 0) }}' },
            @endforeach
        ],
        partySearchText: '{{ $currentSale && $currentSale->party ? addslashes($currentSale->party->name) : '' }}',
        partyFilterQuery: '',
        partyOpen: false,
        highlightedIndex: 0,

        // Products Combobox
        productList: [
            @foreach($products as $prod)
                '{{ addslashes($prod) }}',
            @endforeach
        ],
        productSearchText: '{{ $currentSale && $currentSale->items->count() > 0 ? addslashes($currentSale->items->first()->item_name) : '' }}',
        productFilterQuery: '',
        productOpen: false,
        highlightedProductIndex: 0,

        form: {
            id: '{{ $currentSale->id ?? '' }}',
            date: '{{ old('date', $currentSale ? $currentSale->date : date('Y-m-d')) }}',
            party_id: '{{ old('party_id', $currentSale ? $currentSale->party_id : '') }}',
            product_name: '{{ old('product_name', $currentSale && $currentSale->items->count() > 0 ? addslashes($currentSale->items->first()->item_name) : '') }}',
            invoice_no: '{{ old('invoice_no', $currentSale ? $currentSale->invoice_no : $nextInvoiceNo) }}',
            amount: '{{ old('amount', $currentSale ? $currentSale->amount : 0) }}',
            remarks: '{{ old('remarks', $currentSale ? $currentSale->remarks : '') }}'
        },

        get filteredParties() {
            if (!this.partyFilterQuery || this.partyFilterQuery.trim() === '') {
                return this.partiesList;
            }
            const q = this.partyFilterQuery.toLowerCase();
            return this.partiesList.filter(p => p.name.toLowerCase().includes(q) || p.type.toLowerCase().includes(q));
        },

        get filteredProducts() {
            if (!this.productFilterQuery || this.productFilterQuery.trim() === '') {
                return this.productList;
            }
            const q = this.productFilterQuery.toLowerCase();
            return this.productList.filter(p => p.toLowerCase().includes(q));
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
                this.focusProduct();
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
                this.focusProduct();
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

        // Product Dropdown Methods
        openProductDropdown() {
            if (this.mode === 'view') return;
            this.productOpen = true;
            this.productFilterQuery = '';
            const idx = this.productList.findIndex(p => p.toLowerCase() === (this.form.product_name || '').toLowerCase());
            this.highlightedProductIndex = idx >= 0 ? idx : 0;
            this.scrollHighlightedProduct();
        },

        focusProduct() {
            const el = document.getElementById('field-product-input');
            if (el) {
                el.focus();
                if (el.select) el.select();
            }
        },

        selectProduct(prodName) {
            this.form.product_name = prodName;
            this.productSearchText = prodName;
            this.productFilterQuery = '';
            this.productOpen = false;
            this.$nextTick(() => {
                this.focusNext('field-invoice-no');
            });
        },

        onProductEnter() {
            if (this.productOpen && this.filteredProducts.length > 0) {
                const selected = this.filteredProducts[this.highlightedProductIndex] || this.filteredProducts[0];
                this.selectProduct(selected);
            } else {
                this.form.product_name = this.productSearchText;
                this.productOpen = false;
                this.focusNext('field-invoice-no');
            }
        },

        onProductArrowDown() {
            if (!this.productOpen) {
                this.openProductDropdown();
            } else if (this.highlightedProductIndex < this.filteredProducts.length - 1) {
                this.highlightedProductIndex++;
                this.scrollHighlightedProduct();
            }
        },

        onProductArrowUp() {
            if (this.highlightedProductIndex > 0) {
                this.highlightedProductIndex--;
                this.scrollHighlightedProduct();
            }
        },

        scrollHighlightedProduct() {
            this.$nextTick(() => {
                const el = document.getElementById('product-opt-' + this.highlightedProductIndex);
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
            this.form.product_name = '';
            this.productSearchText = '';
            this.productFilterQuery = '';
            this.productOpen = false;
            this.form.invoice_no = '{{ $nextInvoiceNo }}';
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
                window.location.href = '{{ route('sales.index') }}?id=' + this.form.id;
            } else {
                window.location.href = '{{ route('sales.index') }}';
            }
        },

        focusNext(targetId) {
            const el = document.getElementById(targetId);
            if (el) {
                el.focus();
                if (el.select) {
                    el.select();
                }
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
                    title: 'Customer Required',
                    text: 'Please select a Customer / Party before saving.',
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
                    text: 'Please enter a valid sale amount greater than 0.',
                    confirmButtonColor: '#00a2e8'
                }).then(() => {
                    this.focusNext('field-amount');
                });
                return;
            }
            document.getElementById('erp-sales-voucher-form').submit();
        },

        confirmDelete() {
            if (!this.hasRecord) return;
            Swal.fire({
                title: 'Delete Sale Invoice?',
                html: `Are you sure you want to delete <b>${this.form.invoice_no}</b> for <b style='color:#007cb5'>Rs. ${parseFloat(this.form.amount || 0).toLocaleString()}</b>?<br><span style='color:#dc2626; font-size:12px;'>This will reverse the customer ledger balance.</span>`,
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
                } else if (this.productOpen) {
                    this.productOpen = false;
                } else if (this.showFindModal) {
                    this.showFindModal = false;
                }
            }
        }
    }" @keydown.window="handleKey($event)">
        
        <div class="max-w-6xl mx-auto px-2 sm:px-4 space-y-3">

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

            @if(session('credit_warning'))
                <div class="p-4 rounded-lg bg-amber-500/15 border border-amber-500/40 text-amber-800 text-xs font-bold flex flex-col sm:flex-row items-center justify-between gap-3 shadow-sm">
                    <div class="flex items-center gap-2">
                        <span class="text-base">⚠️</span>
                        <span>{{ session('credit_warning') }}</span>
                    </div>
                    <form method="POST" action="{{ route('sales.store') }}" class="inline">
                        @csrf
                        <input type="hidden" name="admin_override" value="1" />
                        <input type="hidden" name="id" x-model="form.id" />
                        <input type="hidden" name="date" x-model="form.date" />
                        <input type="hidden" name="party_id" x-model="form.party_id" />
                        <input type="hidden" name="product_name" x-model="form.product_name" />
                        <input type="hidden" name="invoice_no" x-model="form.invoice_no" />
                        <input type="hidden" name="amount" x-model="form.amount" />
                        <input type="hidden" name="remarks" x-model="form.remarks" />
                        <button type="submit" class="px-3 py-1.5 rounded bg-amber-600 text-white font-extrabold hover:bg-amber-700 transition-all text-xs shadow-sm">
                            Override & Force Save
                        </button>
                    </form>
                </div>
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

            <!-- Module Navigation Bar -->
            <x-module-nav active="sales" />

            <!-- Main ERP Form Window Card matching Reference Image -->
            <div class="bg-white border-2 border-[#0092d0] rounded-lg shadow-xl overflow-hidden font-sans">
                
                <!-- DAWN Header Component for Sales -->
                <x-dawn-header 
                    title="Sales" 
                    icon="cart" 
                    formId="erp-sales-voucher-form"
                    :exitRoute="route('dashboard')"
                />

                <!-- Form Area: Pure Ledger Entry matching Reference Image with Enter Key Jumping -->
                <form id="erp-sales-voucher-form" method="POST" action="{{ route('sales.store') }}" @submit.prevent="saveVoucher()" class="p-6 bg-[#eaf0f6] min-h-[380px] flex flex-col justify-between">
                    @csrf
                    
                    <input type="hidden" name="id" x-model="form.id" />

                    <!-- Top 4 Core Fields (Exact match to reference image with Enter Key Navigation) -->
                    <div class="space-y-4 max-w-xl">
                        
                        <!-- 1. Date // (Enter -> Party) -->
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                            <label class="w-28 text-sm font-bold text-slate-900 flex items-center justify-between">
                                <span>Date</span>
                                <span class="text-[#00a2e8] font-mono font-bold text-base mr-2">//</span>
                            </label>
                            <div class="flex-1 max-w-xs">
                                <input type="date" 
                                       name="date" 
                                       id="field-date"
                                       x-model="form.date"
                                       :readonly="mode === 'view'"
                                       :class="mode === 'view' ? 'bg-[#f0f4f8] text-slate-700 cursor-not-allowed' : 'bg-white text-slate-900'"
                                       @keydown.enter.prevent="focusParty()"
                                       required 
                                       class="w-full px-3 py-1.5 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-sm font-semibold shadow-sm font-mono" />
                            </div>
                        </div>

                        <!-- 2. Party (Enter opens dropdown or moves to Product) -->
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 relative" @click.away="partyOpen = false">
                            <label class="w-28 text-sm font-bold text-slate-900">
                                Party
                            </label>
                            <div class="flex-1 max-w-md relative">
                                <input type="hidden" name="party_id" :value="form.party_id" required />

                                <div class="relative">
                                    <input type="text"
                                           id="field-party-input"
                                           x-model="partySearchText"
                                           :readonly="mode === 'view'"
                                           :class="mode === 'view' ? 'bg-[#f0f4f8] text-slate-700 cursor-not-allowed' : 'bg-white text-slate-900'"
                                           placeholder="-- Type or Select Customer --"
                                           autocomplete="off"
                                           @input="partyFilterQuery = partySearchText; partyOpen = true; highlightedIndex = 0;"
                                           @click="if(mode !== 'view') openPartyDropdown()"
                                           @keydown.enter.prevent="onPartyEnter()"
                                           @keydown.arrow-down.prevent="onPartyArrowDown()"
                                           @keydown.arrow-up.prevent="onPartyArrowUp()"
                                           @keydown.escape="partyOpen = false"
                                           class="w-full px-3 py-1.5 pr-8 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-sm font-semibold shadow-sm" />
                                    
                                    <button type="button" 
                                            @click="if(mode !== 'view') { if(!partyOpen) { openPartyDropdown(); } else { partyOpen = false; } }"
                                            tabindex="-1"
                                            class="absolute right-2.5 top-2.5 text-slate-400 hover:text-slate-700">
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
                                            <span class="font-mono text-[11px] font-semibold opacity-90" x-text="'Bal: Rs. ' + party.balance"></span>
                                        </div>
                                    </template>
                                    <div x-show="filteredParties.length === 0" class="p-3 text-center text-xs text-slate-400">
                                        No matching customer found.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Product (Enter opens dropdown or moves to Invoice#) -->
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 relative" @click.away="productOpen = false">
                            <label class="w-28 text-sm font-bold text-slate-900">
                                Product
                            </label>
                            <div class="flex-1 max-w-md relative">
                                <input type="hidden" name="product_name" :value="form.product_name" />

                                <div class="relative">
                                    <input type="text"
                                           id="field-product-input"
                                           x-model="productSearchText"
                                           :readonly="mode === 'view'"
                                           :class="mode === 'view' ? 'bg-[#f0f4f8] text-slate-700 cursor-not-allowed' : 'bg-white text-slate-900'"
                                           placeholder="-- Type or Select Product (Optional) --"
                                           autocomplete="off"
                                           @input="form.product_name = productSearchText; productFilterQuery = productSearchText; productOpen = true; highlightedProductIndex = 0;"
                                           @click="if(mode !== 'view') openProductDropdown()"
                                           @keydown.enter.prevent="onProductEnter()"
                                           @keydown.arrow-down.prevent="onProductArrowDown()"
                                           @keydown.arrow-up.prevent="onProductArrowUp()"
                                           @keydown.escape="productOpen = false"
                                           class="w-full px-3 py-1.5 pr-8 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-sm font-semibold shadow-sm" />
                                    
                                    <button type="button" 
                                            @click="if(mode !== 'view') { if(!productOpen) { openProductDropdown(); } else { productOpen = false; } }"
                                            tabindex="-1"
                                            class="absolute right-2.5 top-2.5 text-slate-400 hover:text-slate-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </button>
                                </div>

                                <!-- Custom Searchable Product Dropdown List -->
                                <div x-show="productOpen && mode !== 'view'" 
                                     x-cloak 
                                     style="display: none;"
                                     class="absolute left-0 top-full mt-1 w-full bg-white border border-[#9ab3c9] rounded shadow-2xl z-50 max-h-56 overflow-y-auto">
                                    <template x-for="(prod, idx) in filteredProducts" :key="idx">
                                        <div :id="'product-opt-' + idx"
                                             @click="selectProduct(prod)"
                                             :class="highlightedProductIndex === idx ? 'bg-[#00a2e8] text-white' : 'hover:bg-[#eaf4fa] text-slate-900'"
                                             class="px-3 py-2 cursor-pointer text-xs flex items-center justify-between border-b border-slate-100 last:border-b-0">
                                            <span class="font-bold" x-text="prod"></span>
                                            <span class="text-[10px] opacity-75 font-mono">Select</span>
                                        </div>
                                    </template>
                                    <div x-show="filteredProducts.length === 0" class="p-3 text-center text-xs text-slate-400">
                                        <span>Press <kbd class="font-bold text-slate-600">Enter</kbd> to use "</span><span class="font-semibold text-slate-700" x-text="productSearchText || 'None'"></span><span>"</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Invoice# (Enter -> Amount) -->
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                            <label class="w-28 text-sm font-bold text-slate-900">
                                Invoice#
                            </label>
                            <div class="flex-1 max-w-xs">
                                <input type="text" 
                                       name="invoice_no" 
                                       id="field-invoice-no"
                                       x-model="form.invoice_no"
                                       :readonly="mode === 'view'"
                                       :class="mode === 'view' ? 'bg-[#f0f4f8] text-slate-700 cursor-not-allowed' : 'bg-white text-slate-900'"
                                       @keydown.enter.prevent="focusNext('field-amount')"
                                       required 
                                       class="w-full px-3 py-1.5 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-sm font-bold shadow-sm font-mono" />
                            </div>
                        </div>

                        <!-- 4. Amount 0 (Enter -> Remarks / Save) -->
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                            <label class="w-28 text-sm font-bold text-slate-900">
                                Amount
                            </label>
                            <div class="flex-1 max-w-xs">
                                <input type="number" 
                                       step="0.01" 
                                       min="0"
                                       name="amount" 
                                       id="field-amount"
                                       x-model="form.amount"
                                       :readonly="mode === 'view'"
                                       :class="mode === 'view' ? 'bg-[#f0f4f8] text-slate-700 cursor-not-allowed' : 'bg-white text-[#007cb5] font-black'"
                                       @keydown.enter.prevent="focusNext('field-remarks')"
                                       required 
                                       class="w-full px-3 py-1.5 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-base shadow-sm font-mono" />
                            </div>
                        </div>

                        <!-- Remarks (Enter -> Save) -->
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 pt-1">
                            <label class="w-28 text-xs font-semibold text-slate-600">
                                Narration
                            </label>
                            <div class="flex-1 max-w-md">
                                <input type="text" 
                                       name="remarks" 
                                       id="field-remarks"
                                       x-model="form.remarks"
                                       :readonly="mode === 'view'"
                                       :class="mode === 'view' ? 'bg-[#f0f4f8] text-slate-700 cursor-not-allowed' : 'bg-white text-slate-900'"
                                       @keydown.enter.prevent="saveVoucher()"
                                       placeholder="Optional customer invoice note (Press Enter to Save)"
                                       class="w-full px-3 py-1 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-xs shadow-sm" />
                            </div>
                        </div>

                    </div>

                    <!-- Bottom Status Strip matching Desktop ERP -->
                    <div class="pt-6 border-t border-[#c3d1df] flex flex-col sm:flex-row items-center justify-between text-xs text-slate-600 gap-2">
                        <div class="flex items-center gap-2 font-mono">
                            <span class="px-2 py-0.5 rounded bg-white border border-[#cbd8e4] font-bold text-[#007cb5]">DESKTOP KEYBOARD ENGINE ACTIVE</span>
                            <span>Press <kbd class="px-1 py-0.5 bg-white border border-slate-300 rounded font-bold font-mono">Enter ↵</kbd> in Party dropdown to select option & jump to Invoice#</span>
                        </div>

                        <div class="flex items-center gap-3">
                            @if(isset($currentSale) && $currentSale->party && !empty($currentSale->party->phone))
                                @php
                                    $phone = preg_replace('/[^0-9]/', '', $currentSale->party->phone);
                                    $tmpl = \App\Models\Setting::get('whatsapp_template', 'Invoice #{invoice_no} amount Rs. {amount}');
                                    $msg = str_replace(
                                        ['{customer_name}', '{invoice_no}', '{amount}', '{date}'],
                                        [$currentSale->party->name, $currentSale->invoice_no, number_format($currentSale->net_amount, 2), $currentSale->date],
                                        $tmpl
                                    );
                                @endphp
                                <button type="button" 
                                        onclick="sendDirectWA('{{ $phone }}', '{{ addslashes($msg) }}', this)" 
                                        class="px-2.5 py-1 rounded bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center gap-1 shadow-sm">
                                    <span>💬 Send WA</span>
                                </button>
                            @endif

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

        </div>

        <!-- Hidden Delete Form -->
        @if(isset($currentSale))
            <form id="delete-form" method="POST" action="{{ route('sales.destroy', $currentSale->id) }}" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endif

        <!-- FIND / SEARCH SALES INVOICES MODAL -->
        <div x-show="showFindModal" x-cloak style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
            <div @click.away="showFindModal = false" class="bg-white rounded-lg max-w-2xl w-full border-2 border-[#0092d0] shadow-2xl max-h-[85vh] flex flex-col overflow-hidden">
                <!-- Header -->
                <div class="bg-[#00a2e8] text-white p-3.5 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <h3 class="text-base font-extrabold font-sans">Find / Search Sales Invoices</h3>
                    </div>
                    <button type="button" @click="showFindModal = false" class="text-white hover:text-slate-200 font-bold text-lg leading-none">✕</button>
                </div>

                <!-- Search Input Bar -->
                <div class="p-3 bg-[#eaf1f7] border-b border-[#cbd8e4]">
                    <div class="relative">
                        <input type="text" 
                               x-model="searchQuery" 
                               placeholder="Type Invoice#, Customer Name, or Date to filter..."
                               class="w-full px-3.5 py-2 pl-9 bg-white border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-xs font-semibold" />
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>

                <!-- Invoices List -->
                <div class="p-3 overflow-y-auto flex-grow space-y-2 bg-[#f4f7fa]">
                    @forelse($allSales as $sale)
                        <div x-show="!searchQuery || '{{ strtolower($sale->invoice_no . ' ' . ($sale->party->name ?? '') . ' ' . ($sale->items->first()?->item_name ?? '') . ' ' . $sale->date . ' ' . $sale->amount) }}'.includes(searchQuery.toLowerCase())">
                            <a href="{{ route('sales.index', ['id' => $sale->id]) }}" 
                               class="flex items-center justify-between p-3 rounded bg-white border border-[#cbd8e4] hover:border-[#00a2e8] hover:bg-[#eaf4fa] transition-all shadow-sm group">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono font-bold text-[#007cb5] text-sm group-hover:underline">{{ $sale->invoice_no }}</span>
                                        @if($sale->items->first())
                                            <span class="text-[11px] font-semibold text-slate-600 bg-slate-100 px-1.5 py-0.5 rounded border border-slate-200">📦 {{ $sale->items->first()->item_name }}</span>
                                        @endif
                                    </div>
                                    <span class="text-xs text-slate-700 font-semibold">{{ $sale->party->name ?? 'N/A' }}</span>
                                    <span class="text-[11px] text-slate-500 ml-2 font-mono">• Date: {{ $sale->date }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="font-mono font-black text-slate-900 text-base">Rs. {{ number_format($sale->net_amount, 2) }}</span>
                                    <span class="block text-[11px] text-[#007cb5] font-bold">Click to Load & View →</span>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-500 text-xs">No sales invoices recorded yet.</div>
                    @endforelse
                </div>

                <div class="bg-[#eaeff5] p-3 border-t border-[#cbd8e4] flex items-center justify-between text-xs text-slate-600">
                    <span>Total Invoices: {{ count($allSales) }}</span>
                    <button type="button" @click="showFindModal = false" class="px-4 py-1.5 bg-slate-700 hover:bg-slate-800 text-white rounded font-bold">
                        Close
                    </button>
                </div>
            </div>
        </div>

    </div>

    <script>
    function sendDirectWA(phone, message, btnEl) {
        if (!phone) {
            Swal.fire({
                icon: 'warning',
                title: 'No Phone',
                text: 'Customer has no phone number entered!',
                confirmButtonColor: '#00a2e8'
            });
            return;
        }
        const origText = btnEl.innerHTML;
        btnEl.innerText = 'Sending...';
        btnEl.disabled = true;

        fetch('{{ route("settings.send_whatsapp") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ phone: phone, message: message })
        })
        .then(res => res.json())
        .then(data => {
            btnEl.disabled = false;
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Sent!',
                    text: 'WhatsApp message delivered successfully.',
                    timer: 2000,
                    showConfirmButton: false
                });
                btnEl.innerHTML = '✅ Sent!';
                setTimeout(() => { btnEl.innerHTML = origText; }, 3000);
            } else {
                btnEl.innerHTML = origText;
                const cleanPhone = phone.replace(/[^0-9]/g, '');
                window.open(`https://api.whatsapp.com/send/?phone=${cleanPhone}&text=${encodeURIComponent(message)}`, '_blank');
            }
        })
        .catch(err => {
            btnEl.disabled = false;
            btnEl.innerHTML = origText;
            const cleanPhone = phone.replace(/[^0-9]/g, '');
            window.open(`https://api.whatsapp.com/send/?phone=${cleanPhone}&text=${encodeURIComponent(message)}`, '_blank');
        });
    }
    </script>
</x-app-layout>
