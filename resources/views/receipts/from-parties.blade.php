@php
    $initId = $currentReceipt ? $currentReceipt->id : '';
    $initDate = $currentReceipt ? ($currentReceipt->date ?? date('Y-m-d')) : date('Y-m-d');
    $initParty = $currentReceipt ? ($currentReceipt->party ?? '') : '';
    $initDetail = $currentReceipt ? ($currentReceipt->detail ?? '') : '';
    $initAmount = $currentReceipt ? ($currentReceipt->amount ?? 0) : 0;
    $hasRecord = !empty($currentReceipt);
    $initialMode = $hasRecord ? 'view' : 'new';
@endphp

<x-app-layout>
    <div class="py-5 px-3 sm:px-6 lg:px-8 font-sans" 
         x-data="{
             mode: '{{ $initialMode }}',
             hasRecord: {{ $hasRecord ? 'true' : 'false' }},
             showFindModal: false,
             searchQuery: '',
             
             form: {
                 id: '{{ $initId }}',
                 date: '{{ $initDate }}',
                 party: '{{ addslashes($initParty) }}',
                 detail: '{{ addslashes($initDetail) }}',
                 amount: '{{ $initAmount }}'
             },

             startNew() {
                 this.mode = 'new';
                 this.hasRecord = false;
                 this.form.id = '';
                 this.form.date = '{{ date('Y-m-d') }}';
                 this.form.party = '';
                 this.form.detail = '';
                 this.form.amount = 0;
                 this.$nextTick(() => {
                     const el = document.getElementById('field-party');
                     if (el) el.focus();
                 });
             },

             startEdit() {
                 if (!this.hasRecord && !this.form.id) {
                     Swal.fire({
                         icon: 'info',
                         title: 'No Receipt Selected',
                         text: 'Please select a receipt via Find first, or enter a new one.',
                         confirmButtonColor: '#0f4c81'
                     });
                     return;
                 }
                 this.mode = 'edit';
                 this.$nextTick(() => {
                     const el = document.getElementById('field-party');
                     if (el) el.focus();
                 });
             },

             selectRecord(record) {
                 this.form.id = record.id;
                 this.form.date = record.date || '{{ date('Y-m-d') }}';
                 this.form.party = record.party || '';
                 this.form.detail = record.detail || '';
                 this.form.amount = record.amount || 0;
                 this.hasRecord = true;
                 this.mode = 'view';
                 this.showFindModal = false;
             },

             saveRecord() {
                 if (this.mode === 'view') {
                     this.startEdit();
                     return;
                 }
                 if (!this.form.party || this.form.party.trim() === '') {
                     Swal.fire({
                         icon: 'warning',
                         title: 'Party Name Required',
                         text: 'Please enter the party name.',
                         confirmButtonColor: '#0f4c81'
                     }).then(() => {
                         document.getElementById('field-party').focus();
                     });
                     return;
                 }
                 if (!this.form.amount || parseFloat(this.form.amount) < 0) {
                     Swal.fire({
                         icon: 'warning',
                         title: 'Valid Amount Required',
                         text: 'Please enter a valid amount (0 or greater).',
                         confirmButtonColor: '#0f4c81'
                     }).then(() => {
                         document.getElementById('field-amount').focus();
                     });
                     return;
                 }
                 document.getElementById('receipt-voucher-form').submit();
             },

             confirmDelete() {
                 if (!this.hasRecord || !this.form.id) {
                     Swal.fire({
                         icon: 'info',
                         title: 'Nothing to Delete',
                         text: 'Please select a record first.',
                         confirmButtonColor: '#0f4c81'
                     });
                     return;
                 }
                 Swal.fire({
                     title: 'Delete this Party Receipt?',
                     html: 'Are you sure you want to delete receipt from <b>' + this.form.party + '</b> (Rs. ' + this.form.amount + ')?<br><span style=\'color:#dc2626; font-size:12px;\'>This action cannot be undone.</span>',
                     icon: 'warning',
                     showCancelButton: true,
                     confirmButtonColor: '#dc2626',
                     cancelButtonColor: '#64748b',
                     confirmButtonText: 'Yes, Delete',
                     cancelButtonText: 'Cancel',
                     reverseButtons: true
                 }).then((result) => {
                     if (result.isConfirmed) {
                         const deleteForm = document.getElementById('receipt-delete-form');
                         let action = '{{ route('receipts-from-parties.destroy', ':id') }}';
                         action = action.replace(':id', this.form.id);
                         deleteForm.action = action;
                         deleteForm.submit();
                     }
                 });
             },

             refreshPage() {
                 window.location.reload();
             },

             exitPage() {
                 window.location.href = '{{ route('receipts.index') }}';
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
                     this.saveRecord();
                 } else if (e.altKey && e.key.toLowerCase() === 'd') {
                     e.preventDefault();
                     this.confirmDelete();
                 } else if (e.altKey && e.key.toLowerCase() === 'r') {
                     e.preventDefault();
                     this.refreshPage();
                 } else if (e.key === 'Escape') {
                     if (this.showFindModal) {
                         this.showFindModal = false;
                     } else {
                         this.exitPage();
                     }
                 }
             }
         }" 
         @keydown.window="handleKey($event)">

        <!-- Hidden Delete Form -->
        <form id="receipt-delete-form" method="POST" action="" style="display: none;">
            @csrf
            @method('DELETE')
        </form>

        <div class="max-w-[1360px] mx-auto space-y-4">
            
            <!-- MAIN WINDOW CARD: Recreated directly from Receipts From Parties Screenshot -->
            <div class="bg-white border-2 border-[#b8cde3] rounded-lg shadow-md overflow-hidden flex flex-col min-h-[580px]">
                
                <!-- 1. SUBHEADER TITLE RIBBON (Matching Screenshot with Banknote Icon) -->
                <div class="bg-gradient-to-r from-[#0c2f55] via-[#0f4c81] to-[#144b84] px-4 py-3 border-b border-[#0a2747] flex items-center justify-between select-none">
                    <div class="flex items-center gap-3">
                        <!-- Banknote Cash Icon matching Screenshot -->
                        <div class="w-8 h-8 rounded bg-white/10 border border-white/20 flex items-center justify-center p-0.5 shrink-0 shadow-inner">
                            <svg class="w-6 h-6 text-sky-200" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="8" y="18" width="48" height="28" rx="2.5" fill="none" stroke="currentColor" stroke-width="2.5" />
                                <rect x="12" y="21.5" width="40" height="21" rx="1.5" stroke="currentColor" stroke-width="1.6" />
                                <circle cx="16" cy="25.5" r="1.5" fill="currentColor" />
                                <circle cx="48" cy="25.5" r="1.5" fill="currentColor" />
                                <circle cx="16" cy="38.5" r="1.5" fill="currentColor" />
                                <circle cx="48" cy="38.5" r="1.5" fill="currentColor" />
                                <ellipse cx="32" cy="32" rx="7.5" ry="6" stroke="currentColor" stroke-width="2" />
                            </svg>
                        </div>
                        <h1 class="text-lg sm:text-xl font-black text-white tracking-tight">Receipts From Parties</h1>
                    </div>

                    <!-- Breadcrumb Indicator -->
                    <div class="flex items-center gap-2 text-xs text-sky-200 font-medium">
                        <span class="hidden sm:inline text-sky-300">Terminal Mode:</span>
                        <span class="px-2 py-0.5 rounded bg-white/15 border border-white/25 text-white font-mono font-bold uppercase text-[11px]" x-text="mode">NEW</span>
                    </div>
                </div>

                <!-- 2. ACTION TOOLBAR: Exact 7 Desktop Toolbar Buttons from Screenshot -->
                <div class="bg-[#f4f7fb] border-b border-[#cbd8e4] px-3 sm:px-4 py-2 flex items-center gap-2 sm:gap-3 flex-wrap select-none">
                    
                    <!-- NEW (+ Icon) -->
                    <button type="button" 
                            @click="startNew()" 
                            :class="mode === 'new' ? 'bg-sky-50 border-sky-400 shadow-2xs' : 'bg-transparent border-transparent hover:bg-slate-200/70 hover:border-slate-300'"
                            class="flex flex-col items-center justify-center min-w-[58px] sm:min-w-[62px] h-[58px] px-2 py-1 rounded border transition-all cursor-pointer group"
                            title="New Receipt [Alt+N]">
                        <div class="w-6 h-6 flex items-center justify-center">
                            <svg class="w-6 h-6 text-slate-800 group-hover:text-[#0f4c81]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                        </div>
                        <span class="text-[11px] font-bold text-slate-800 mt-1">New</span>
                    </button>

                    <!-- FIND (Magnifying Glass) -->
                    <button type="button" 
                            @click="showFindModal = true" 
                            class="flex flex-col items-center justify-center min-w-[58px] sm:min-w-[62px] h-[58px] px-2 py-1 rounded border border-transparent hover:bg-slate-200/70 hover:border-slate-300 transition-all cursor-pointer group"
                            title="Find Receipts [Alt+F]">
                        <div class="w-6 h-6 flex items-center justify-center">
                            <svg class="w-6 h-6 text-slate-800 group-hover:text-[#0f4c81]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="7"></circle>
                                <line x1="21" y1="21" x2="16.5" y2="16.5"></line>
                            </svg>
                        </div>
                        <span class="text-[11px] font-bold text-slate-800 mt-1">Find</span>
                    </button>

                    <!-- EDIT (Pencil with Red Cross badge when disabled) -->
                    <button type="button" 
                            @click="startEdit()" 
                            :disabled="!hasRecord && !form.id"
                            :class="mode === 'edit' ? 'bg-sky-50 border-sky-400' : 'bg-transparent border-transparent hover:bg-slate-200/70 hover:border-slate-300'"
                            class="relative flex flex-col items-center justify-center min-w-[58px] sm:min-w-[62px] h-[58px] px-2 py-1 rounded border transition-all cursor-pointer group disabled:cursor-not-allowed"
                            title="Edit Receipt [Alt+E]">
                        <div class="relative w-6 h-6 flex items-center justify-center">
                            <svg class="w-5 h-5 text-slate-800 group-hover:text-[#0f4c81]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                            <span x-show="mode !== 'edit' && (!hasRecord && !form.id)" class="absolute -bottom-1 -right-1 text-red-600 text-xs font-black">
                                <svg class="w-3.5 h-3.5 text-red-600" viewBox="0 0 24 24" fill="currentColor">
                                    <circle cx="12" cy="12" r="10" fill="#fee2e2" stroke="#dc2626" stroke-width="2"/>
                                    <line x1="8" y1="8" x2="16" y2="16" stroke="#dc2626" stroke-width="3" stroke-linecap="round"/>
                                    <line x1="16" y1="8" x2="8" y2="16" stroke="#dc2626" stroke-width="3" stroke-linecap="round"/>
                                </svg>
                            </span>
                        </div>
                        <span class="text-[11px] font-bold text-slate-800 mt-1">Edit</span>
                    </button>

                    <!-- SAVE (Floppy Disk with Red Cross badge when disabled) -->
                    <button type="button" 
                            @click="saveRecord()" 
                            :disabled="mode === 'view'"
                            :class="mode !== 'view' ? 'hover:bg-emerald-50 hover:border-emerald-300' : 'disabled:cursor-not-allowed'"
                            class="relative flex flex-col items-center justify-center min-w-[58px] sm:min-w-[62px] h-[58px] px-2 py-1 rounded border border-transparent transition-all cursor-pointer group"
                            title="Save Receipt [Alt+S]">
                        <div class="relative w-6 h-6 flex items-center justify-center">
                            <svg class="w-5 h-5 text-slate-800 group-hover:text-emerald-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                <polyline points="7 3 7 8 15 8"></polyline>
                            </svg>
                            <span x-show="mode === 'view'" class="absolute -bottom-1 -right-1 text-red-600 text-xs font-black">
                                <svg class="w-3.5 h-3.5 text-red-600" viewBox="0 0 24 24" fill="currentColor">
                                    <circle cx="12" cy="12" r="10" fill="#fee2e2" stroke="#dc2626" stroke-width="2"/>
                                    <line x1="8" y1="8" x2="16" y2="16" stroke="#dc2626" stroke-width="3" stroke-linecap="round"/>
                                    <line x1="16" y1="8" x2="8" y2="16" stroke="#dc2626" stroke-width="3" stroke-linecap="round"/>
                                </svg>
                            </span>
                        </div>
                        <span class="text-[11px] font-bold text-slate-800 mt-1">Save</span>
                    </button>

                    <!-- DELETE (Trash Can with Red Cross badge when disabled) -->
                    <button type="button" 
                            @click="confirmDelete()" 
                            :disabled="!hasRecord && !form.id"
                            :class="hasRecord || form.id ? 'hover:bg-rose-50 hover:border-rose-300' : 'disabled:cursor-not-allowed'"
                            class="relative flex flex-col items-center justify-center min-w-[58px] sm:min-w-[62px] h-[58px] px-2 py-1 rounded border border-transparent transition-all cursor-pointer group"
                            title="Delete Receipt [Alt+D]">
                        <div class="relative w-6 h-6 flex items-center justify-center">
                            <svg class="w-5 h-5 text-slate-800 group-hover:text-rose-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                            <span x-show="!hasRecord && !form.id" class="absolute -bottom-1 -right-1 text-red-600 text-xs font-black">
                                <svg class="w-3.5 h-3.5 text-red-600" viewBox="0 0 24 24" fill="currentColor">
                                    <circle cx="12" cy="12" r="10" fill="#fee2e2" stroke="#dc2626" stroke-width="2"/>
                                    <line x1="8" y1="8" x2="16" y2="16" stroke="#dc2626" stroke-width="3" stroke-linecap="round"/>
                                    <line x1="16" y1="8" x2="8" y2="16" stroke="#dc2626" stroke-width="3" stroke-linecap="round"/>
                                </svg>
                            </span>
                        </div>
                        <span class="text-[11px] font-bold text-slate-800 mt-1">Delete</span>
                    </button>

                    <!-- REFRESH (Looping Arrows) -->
                    <button type="button" 
                            @click="refreshPage()" 
                            class="flex flex-col items-center justify-center min-w-[58px] sm:min-w-[62px] h-[58px] px-2 py-1 rounded border border-transparent hover:bg-slate-200/70 hover:border-slate-300 transition-all cursor-pointer group"
                            title="Refresh Page [Alt+R]">
                        <div class="w-6 h-6 flex items-center justify-center">
                            <svg class="w-5 h-5 text-slate-800 group-hover:text-[#0f4c81]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="23 4 23 10 17 10"></polyline>
                                <polyline points="1 20 1 14 7 14"></polyline>
                                <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                            </svg>
                        </div>
                        <span class="text-[11px] font-bold text-slate-800 mt-1">Refresh</span>
                    </button>

                    <!-- EXIT (Doorway with Outward Arrow) -->
                    <button type="button" 
                            @click="exitPage()" 
                            class="flex flex-col items-center justify-center min-w-[58px] sm:min-w-[62px] h-[58px] px-2 py-1 rounded border border-transparent hover:bg-slate-200/70 hover:border-slate-300 transition-all cursor-pointer group"
                            title="Exit [Esc]">
                        <div class="w-6 h-6 flex items-center justify-center">
                            <svg class="w-5 h-5 text-slate-800 group-hover:text-rose-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                        </div>
                        <span class="text-[11px] font-bold text-slate-800 mt-1">Exit</span>
                    </button>

                </div>

                <!-- 3. FORM CANVAS: Exact Form Structure, Fields & Alignment from Screenshot -->
                <form id="receipt-voucher-form" 
                      method="POST" 
                      action="{{ route('receipts-from-parties.store') }}" 
                      @submit.prevent="saveRecord()" 
                      class="p-6 sm:p-10 bg-white flex-grow flex flex-col justify-between">
                    @csrf

                    <!-- Hidden inputs for ID -->
                    <input type="hidden" name="id" x-model="form.id">
                    <input type="hidden" name="receipt_id" x-model="form.id">

                    <div class="space-y-6 max-w-4xl">
                        
                        <!-- FIELD 1: Date (Label 'Date', Input with date format slashes '/ /') -->
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-6">
                            <label for="field-date" class="w-28 shrink-0 text-sm font-bold text-slate-800 select-none">
                                Date
                            </label>
                            <div class="w-full sm:w-64">
                                <input type="date" 
                                       id="field-date" 
                                       name="date" 
                                       x-model="form.date"
                                       :readonly="mode === 'view'"
                                       :class="mode === 'view' ? 'bg-[#f1f5f9] text-slate-700 cursor-not-allowed' : 'bg-white text-slate-900 border-[#9ab3c9] focus:border-[#0f4c81]'"
                                       required
                                       class="w-full h-[36px] px-3 border rounded text-sm font-bold shadow-2xs font-mono outline-none" />
                            </div>
                        </div>

                        <!-- FIELD 2: Party (Label 'Party', Wide text input) -->
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-6">
                            <label for="field-party" class="w-28 shrink-0 text-sm font-bold text-slate-800 select-none">
                                Party
                            </label>
                            <div class="w-full max-w-2xl">
                                <input type="text" 
                                       id="field-party" 
                                       name="party" 
                                       x-model="form.party"
                                       :readonly="mode === 'view'"
                                       :class="mode === 'view' ? 'bg-[#f1f5f9] text-slate-700 cursor-not-allowed' : 'bg-white text-slate-900 border-[#9ab3c9] focus:border-[#0f4c81]'"
                                       placeholder="Enter party or customer name"
                                       autocomplete="off"
                                       required
                                       class="w-full h-[36px] px-3 border rounded text-sm font-bold shadow-2xs outline-none" />
                            </div>
                        </div>

                        <!-- FIELD 3: Detail (Label 'Detail', Large multi-line area) -->
                        <div class="flex flex-col sm:flex-row sm:items-start gap-2 sm:gap-6">
                            <label for="field-detail" class="w-28 shrink-0 text-sm font-bold text-slate-800 pt-2 select-none">
                                Detail
                            </label>
                            <div class="w-full max-w-2xl">
                                <textarea id="field-detail" 
                                          name="detail" 
                                          x-model="form.detail"
                                          :readonly="mode === 'view'"
                                          :class="mode === 'view' ? 'bg-[#f1f5f9] text-slate-700 cursor-not-allowed' : 'bg-white text-slate-900 border-[#9ab3c9] focus:border-[#0f4c81]'"
                                          rows="5"
                                          placeholder="Receipt description, invoice references, or notes..."
                                          class="w-full p-3 border rounded text-sm font-medium shadow-2xs outline-none resize-y min-h-[130px]"></textarea>
                            </div>
                        </div>

                        <!-- FIELD 4: Amount (Label 'Amount' at bottom, Number input with initial 0) -->
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-6 pt-2">
                            <label for="field-amount" class="w-28 shrink-0 text-sm font-bold text-slate-800 select-none">
                                Amount
                            </label>
                            <div class="w-full sm:w-52">
                                <input type="number" 
                                       id="field-amount" 
                                       name="amount" 
                                       step="0.01" 
                                       min="0"
                                       x-model="form.amount"
                                       :readonly="mode === 'view'"
                                       :class="mode === 'view' ? 'bg-[#f1f5f9] text-slate-700 cursor-not-allowed' : 'bg-white text-[#0f4c81] border-[#9ab3c9] focus:border-[#0f4c81] font-black'"
                                       required
                                       class="w-full h-[36px] px-3 border rounded text-sm font-mono text-base shadow-2xs outline-none" />
                            </div>
                        </div>

                    </div>

                    <!-- Bottom Helper Hints & Status Bar -->
                    <div class="mt-12 pt-4 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-2 select-none">
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded bg-blue-50 text-[#0f4c81] font-mono font-bold border border-blue-200 text-[11px]">
                                ACTIVE TERMINAL
                            </span>
                            <span>Click <strong>New</strong> to create, <strong>Find</strong> to search existing receipts, or <strong>Save</strong> to commit.</span>
                        </div>
                        <div class="font-mono text-[11px]">
                            {{ date('d-M-Y') }} • DAWN ERP
                        </div>
                    </div>

                </form>

            </div>

            <!-- 4. FIND / SEARCH MODAL: Search & Select from All Existing Receipts -->
            <div x-show="showFindModal" 
                 x-cloak 
                 class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-2xs flex items-center justify-center p-3 sm:p-6"
                 @click.self="showFindModal = false">
                
                <div class="bg-white border-2 border-[#0f4c81] rounded-lg shadow-2xl w-full max-w-3xl overflow-hidden font-sans">
                    
                    <!-- Modal Header -->
                    <div class="bg-[#0f4c81] text-white px-4 py-3 flex items-center justify-between select-none">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-sky-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            <h3 class="font-bold text-sm tracking-wide">Find Receipts From Parties</h3>
                        </div>
                        <button type="button" @click="showFindModal = false" class="text-white/80 hover:text-white text-lg font-black leading-none">
                            ✕
                        </button>
                    </div>

                    <!-- Search Input Bar -->
                    <div class="p-3 bg-slate-50 border-b border-slate-200">
                        <div class="relative">
                            <input type="text" 
                                   x-model="searchQuery" 
                                   placeholder="Search by party name, date, detail or amount..." 
                                   class="w-full pl-9 pr-3 py-1.5 border border-slate-300 rounded text-xs font-bold focus:border-[#0f4c81] outline-none" />
                            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        </div>
                    </div>

                    <!-- Records Table -->
                    <div class="max-h-[380px] overflow-y-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead class="bg-[#e9eff6] text-slate-800 font-bold border-b border-slate-200 sticky top-0">
                                <tr>
                                    <th class="p-2.5">Date</th>
                                    <th class="p-2.5">Party</th>
                                    <th class="p-2.5">Detail</th>
                                    <th class="p-2.5 text-right">Amount</th>
                                    <th class="p-2.5 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium">
                                @forelse($receipts as $rec)
                                    <tr class="hover:bg-blue-50/70 transition-colors cursor-pointer"
                                        x-show="!searchQuery || '{{ strtolower($rec->party . ' ' . $rec->detail . ' ' . $rec->date . ' ' . $rec->amount) }}'.includes(searchQuery.toLowerCase())"
                                        @click="selectRecord({{ json_encode($rec) }})">
                                        <td class="p-2.5 font-mono font-bold text-slate-700 whitespace-nowrap">{{ $rec->date }}</td>
                                        <td class="p-2.5 font-bold text-slate-900">{{ $rec->party }}</td>
                                        <td class="p-2.5 text-slate-600 max-w-xs truncate">{{ $rec->detail ?: '-' }}</td>
                                        <td class="p-2.5 text-right font-mono font-bold text-[#0f4c81] whitespace-nowrap">Rs. {{ number_format($rec->amount, 2) }}</td>
                                        <td class="p-2.5 text-center whitespace-nowrap">
                                            <button type="button" 
                                                    class="px-2.5 py-1 rounded bg-[#0f4c81] text-white text-[11px] font-bold hover:bg-[#144b84] transition-all">
                                                Select
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-6 text-center text-slate-500 font-medium">
                                            No receipts found in database. Click <strong>New</strong> to record the first receipt.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Modal Footer -->
                    <div class="p-3 bg-slate-100 border-t border-slate-200 flex justify-between items-center text-xs text-slate-600 select-none">
                        <span>Total receipts: <strong>{{ count($receipts) }}</strong></span>
                        <button type="button" @click="showFindModal = false" class="px-3 py-1 rounded bg-slate-200 hover:bg-slate-300 font-bold text-slate-700">
                            Close
                        </button>
                    </div>

                </div>

            </div>

        </div>

    </div>
</x-app-layout>
