<x-app-layout>
    <div class="py-4" x-data="{
        mode: '{{ isset($currentSalesman) ? 'view' : 'new' }}',
        hasRecord: {{ isset($currentSalesman) ? 'true' : 'false' }},
        showFindModal: false,
        searchQuery: '',
        tableFilter: '',
        
        form: {
            id: '{{ $currentSalesman->id ?? '' }}',
            name: '{{ old('name', $currentSalesman ? addslashes($currentSalesman->name) : '') }}',
            phone: '{{ old('phone', $currentSalesman ? addslashes($currentSalesman->phone) : '') }}',
            commission_rate: '{{ old('commission_rate', $currentSalesman ? $currentSalesman->commission_rate : 0) }}'
        },

        startNew() {
            this.mode = 'new';
            this.hasRecord = false;
            this.form.id = '';
            this.form.name = '';
            this.form.phone = '';
            this.form.commission_rate = 0;
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
                window.location.href = '{{ route('salesmen.index') }}?id=' + this.form.id;
            } else {
                window.location.href = '{{ route('salesmen.index') }}';
            }
        },

        focusNext(targetId) {
            const el = document.getElementById(targetId);
            if (el) {
                el.focus();
                if (el.select) el.select();
            }
        },

        saveRecord() {
            if (this.mode === 'view') {
                this.startEdit();
                return;
            }
            if (!this.form.name || this.form.name.trim() === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Salesman Name Required',
                    text: 'Please enter the salesman name before saving.',
                    confirmButtonColor: '#00a2e8'
                }).then(() => {
                    this.focusNext('field-name');
                });
                return;
            }
            document.getElementById('erp-salesmen-form').submit();
        },

        confirmDelete() {
            if (!this.hasRecord) return;
            Swal.fire({
                title: 'Delete Salesman?',
                html: `Are you sure you want to delete <b>${this.form.name}</b>?<br><span style='color:#dc2626; font-size:12px;'>Salesmen with linked sale invoices cannot be deleted.</span>`,
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
                this.saveRecord();
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
                
                <!-- DAWN Header Component for Salesmen -->
                <x-dawn-header 
                    title="4 Salesmen" 
                    icon="salesman" 
                    formId="erp-salesmen-form"
                    :exitRoute="route('dashboard')"
                />

                <!-- Form Area: Desktop ERP Form Layout with Enter Key Progression -->
                <form id="erp-salesmen-form" method="POST" action="{{ route('salesmen.store') }}" @submit.prevent="saveRecord()" class="p-6 bg-[#eaf0f6] min-h-[300px] flex flex-col justify-between">
                    @csrf
                    
                    <input type="hidden" name="id" x-model="form.id" />

                    <!-- Core Form Fields (Enter Key Navigation Flow) -->
                    <div class="space-y-4 max-w-2xl">
                        
                        <!-- 1. Salesman Name (Enter -> Phone) -->
                        <div class="flex items-center gap-4">
                            <label class="w-40 shrink-0 text-sm font-black text-slate-900">
                                Salesman Name <span class="text-red-500">*</span>
                            </label>
                            <div class="w-full max-w-md">
                                <input type="text" 
                                       name="name" 
                                       id="field-name"
                                       x-model="form.name"
                                       :readonly="mode === 'view'"
                                       :class="mode === 'view' ? 'bg-[#f0f4f8] text-slate-700 cursor-not-allowed' : 'bg-white text-slate-900'"
                                       @keydown.enter.prevent="focusNext('field-phone')"
                                       placeholder="e.g. Asif Ali, Kamran Akmal"
                                       required 
                                       autofocus
                                       class="w-full h-[38px] px-3 py-1.5 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-sm font-bold shadow-sm" />
                            </div>
                        </div>

                        <!-- 2. Phone / Contact (Enter -> Commission) -->
                        <div class="flex items-center gap-4">
                            <label class="w-40 shrink-0 text-sm font-black text-slate-900">
                                Contact No
                            </label>
                            <div class="w-full max-w-md">
                                <input type="text" 
                                       name="phone" 
                                       id="field-phone"
                                       x-model="form.phone"
                                       :readonly="mode === 'view'"
                                       :class="mode === 'view' ? 'bg-[#f0f4f8] text-slate-700 cursor-not-allowed' : 'bg-white text-slate-900'"
                                       @keydown.enter.prevent="focusNext('field-commission')"
                                       placeholder="e.g. 0321-4567890"
                                       class="w-full h-[38px] px-3 py-1.5 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-sm font-semibold shadow-sm" />
                            </div>
                        </div>

                        <!-- 3. Commission Rate % (Enter -> Save) -->
                        <div class="flex items-center gap-4">
                            <label class="w-40 shrink-0 text-sm font-black text-slate-900">
                                Commission (%)
                            </label>
                            <div class="w-full max-w-md">
                                <input type="number" 
                                       step="0.01" 
                                       min="0" 
                                       max="100" 
                                       name="commission_rate" 
                                       id="field-commission"
                                       x-model="form.commission_rate"
                                       :readonly="mode === 'view'"
                                       :class="mode === 'view' ? 'bg-[#f0f4f8] text-slate-700 cursor-not-allowed' : 'bg-white text-slate-900'"
                                       @keydown.enter.prevent="saveRecord()"
                                       placeholder="0.00"
                                       class="w-full h-[38px] px-3 py-1.5 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-sm font-bold shadow-sm font-mono" />
                            </div>
                        </div>

                    </div>

                    <!-- Keyboard navigation footer hint -->
                    <div class="mt-8 pt-4 border-t border-[#c8d8e6] flex flex-wrap items-center justify-between gap-3 text-xs text-slate-700">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center gap-1 font-mono bg-white px-2 py-0.5 rounded border border-[#cbd8e4]">
                                <kbd class="font-bold text-[#007cb5]">Alt+N</kbd> New
                            </span>
                            <span class="inline-flex items-center gap-1 font-mono bg-white px-2 py-0.5 rounded border border-[#cbd8e4]">
                                <kbd class="font-bold text-[#007cb5]">Alt+F</kbd> Find
                            </span>
                            <span class="inline-flex items-center gap-1 font-mono bg-white px-2 py-0.5 rounded border border-[#cbd8e4]">
                                <kbd class="font-bold text-[#007cb5]">Alt+E</kbd> Edit
                            </span>
                            <span class="inline-flex items-center gap-1 font-mono bg-white px-2 py-0.5 rounded border border-[#cbd8e4]">
                                <kbd class="font-bold text-[#007cb5]">Alt+S</kbd> Save
                            </span>
                            <span class="inline-flex items-center gap-1 font-mono bg-white px-2 py-0.5 rounded border border-[#cbd8e4]">
                                <kbd class="font-bold text-[#007cb5]">Alt+D</kbd> Delete
                            </span>
                        </div>
                        <div class="text-[11px] text-slate-500 font-semibold italic">
                            Press <kbd class="bg-white px-1 border border-slate-300 rounded text-slate-800 font-bold">Enter</kbd> to step to next field, then Save.
                        </div>
                    </div>
                </form>

            </div>

            <!-- Salesmen Directory Table with Live Search Filter -->
            <div class="bg-white border-2 border-[#cbd8e4] rounded-lg shadow-sm p-4 space-y-3 font-sans">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-2 border-b border-[#cbd8e4]">
                    <div>
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-wide">Registered Sales Force / Salesmen</h3>
                        <p class="text-xs text-slate-600 font-medium">Click any salesman to load into desktop window for editing</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="relative w-64">
                            <input type="text" 
                                   x-model="tableFilter" 
                                   placeholder="Filter salesmen..." 
                                   class="w-full text-xs h-[32px] pl-8 pr-3 py-1 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded shadow-inner" />
                            <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="8" stroke-width="2"/>
                                <line x1="21" y1="21" x2="16.65" y2="16.65" stroke-width="2"/>
                            </svg>
                        </div>
                        <span class="text-xs font-mono text-[#007cb5] bg-[#eaf4fa] border border-[#00a2e8] px-2.5 py-1 rounded font-bold whitespace-nowrap">
                            Total: {{ count($salesmen) }}
                        </span>
                    </div>
                </div>

                <div class="overflow-x-auto rounded border border-[#cbd8e4]">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead class="bg-[#eaf1f7] text-slate-900 uppercase font-mono font-black border-b border-[#cbd8e4]">
                            <tr>
                                <th class="p-2.5 border-r border-[#cbd8e4] text-center w-16">#</th>
                                <th class="p-2.5 border-r border-[#cbd8e4]">Salesman Name</th>
                                <th class="p-2.5 border-r border-[#cbd8e4]">Contact No</th>
                                <th class="p-2.5 border-r border-[#cbd8e4] text-right">Commission Rate</th>
                                <th class="p-2.5 text-right w-28">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#cbd8e4] font-medium text-slate-800">
                            @forelse($salesmen as $sm)
                                <tr class="hover:bg-[#f0f7fd] transition-colors cursor-pointer {{ (isset($currentSalesman) && $currentSalesman->id === $sm->id) ? 'bg-[#d8edff] font-bold' : '' }}"
                                    x-show="!tableFilter || '{{ strtolower(addslashes($sm->name . ' ' . $sm->phone)) }}'.includes(tableFilter.toLowerCase())"
                                    @click="window.location.href = '{{ route('salesmen.index') }}?id={{ $sm->id }}'">
                                    <td class="p-2.5 border-r border-[#cbd8e4] text-center font-mono text-slate-500 font-bold">
                                        {{ $sm->id }}
                                    </td>
                                    <td class="p-2.5 border-r border-[#cbd8e4] font-black text-slate-900">
                                        {{ $sm->name }}
                                    </td>
                                    <td class="p-2.5 border-r border-[#cbd8e4] font-mono">
                                        {{ $sm->phone ?: '—' }}
                                    </td>
                                    <td class="p-2.5 border-r border-[#cbd8e4] text-right font-mono font-bold text-[#007cb5]">
                                        {{ number_format($sm->commission_rate, 2) }}%
                                    </td>
                                    <td class="p-2.5 text-right">
                                        <a href="{{ route('salesmen.index') }}?id={{ $sm->id }}" 
                                           class="px-2.5 py-1 bg-[#00a2e8] hover:bg-[#008ecb] text-white rounded text-[11px] font-bold shadow-sm transition-all inline-block">
                                            Load & Edit →
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-slate-500 italic bg-slate-50">
                                        No salesmen recorded yet. Fill the form above and click Save to add your first salesman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Hidden Delete Form -->
        <form id="delete-form" method="POST" :action="'{{ url('/salesmen') }}/' + form.id" class="hidden">
            @csrf
            @method('DELETE')
        </form>

        <!-- Find / Search Modal (Alt+F) -->
        <div x-show="showFindModal" 
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="bg-white rounded-lg border-2 border-[#0092d0] shadow-2xl w-full max-w-xl overflow-hidden font-sans"
                 @click.away="showFindModal = false"
                 @keydown.escape.window="showFindModal = false">
                
                <div class="bg-[#00a2e8] text-white px-4 py-2.5 flex items-center justify-between border-b border-[#008ecb]">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                        <h3 class="text-sm font-black uppercase tracking-wider">Find Salesman (Alt+F)</h3>
                    </div>
                    <button type="button" @click="showFindModal = false" class="text-white hover:text-red-200 text-lg font-black leading-none focus:outline-none">✕</button>
                </div>

                <div class="p-4 bg-[#eaf0f6] border-b border-[#cbd8e4]">
                    <input type="text" 
                           x-model="searchQuery" 
                           id="modal-search-input"
                           placeholder="Type salesman name or phone to search..." 
                           class="w-full h-[38px] px-3 border border-[#9ab3c9] focus:border-[#00a2e8] focus:ring-1 focus:ring-[#00a2e8] rounded text-sm font-bold bg-white shadow-inner"
                           x-init="$watch('showFindModal', value => { if (value) setTimeout(() => document.getElementById('modal-search-input').focus(), 50); })" />
                </div>

                <div class="max-h-80 overflow-y-auto divide-y divide-[#cbd8e4] text-xs">
                    @forelse($salesmen as $sm)
                        <div class="p-3 hover:bg-[#e1f2fc] cursor-pointer flex items-center justify-between transition-colors"
                             x-show="!searchQuery || '{{ strtolower(addslashes($sm->name . ' ' . $sm->phone)) }}'.includes(searchQuery.toLowerCase())"
                             @click="window.location.href = '{{ route('salesmen.index') }}?id={{ $sm->id }}'">
                            <div>
                                <span class="font-black text-slate-900 text-sm">{{ $sm->name }}</span>
                                <div class="text-[11px] text-slate-600 flex items-center gap-3 mt-0.5">
                                    <span>Phone: <b class="font-mono">{{ $sm->phone ?: '—' }}</b></span>
                                    <span>•</span>
                                    <span>Commission: <b class="font-mono text-[#007cb5]">{{ number_format($sm->commission_rate, 2) }}%</b></span>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 bg-[#00a2e8] text-white rounded font-bold text-[10px]">Select</span>
                        </div>
                    @empty
                        <div class="p-6 text-center text-slate-500 italic">No salesmen found.</div>
                    @endforelse
                </div>

                <div class="bg-[#f0f4f8] px-4 py-2 text-right border-t border-[#cbd8e4]">
                    <button type="button" @click="showFindModal = false" class="px-3 py-1 bg-slate-200 hover:bg-slate-300 text-slate-800 rounded text-xs font-bold transition-all">Close (Esc)</button>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
