@props([
    'title' => 'Purchases',
    'icon' => 'truck',
    'formId' => 'erp-voucher-form',
    'exitRoute' => null,
])

<div class="w-full bg-[#00a2e8] select-none shadow-md rounded-t-lg overflow-hidden border-t border-l border-r border-[#008ecb]">
    <!-- Section Banner (Matching the rounded bar in reference image) -->
    <div class="p-2.5">
        <div class="bg-[#008cc9]/70 border border-white/50 rounded-xl px-4 py-2 flex items-center justify-between shadow-inner">
            <div class="flex items-center gap-3">
                <!-- Icon based on module -->
                <div class="text-black shrink-0">
                    @if($icon === 'truck')
                        <!-- Delivery Truck Icon for Purchases (matches reference image) -->
                        <svg class="w-8 h-8 text-black" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 7h15v14H3z" />
                            <path d="M18 12h6l4 4v5h-10z" />
                            <circle cx="8" cy="23" r="2.5" />
                            <circle cx="23" cy="23" r="2.5" />
                            <line x1="10.5" y1="23" x2="20.5" y2="23" />
                        </svg>
                    @elseif($icon === 'cart')
                        <!-- Shopping Cart / Sales Icon -->
                        <svg class="w-8 h-8 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1.5" />
                            <circle cx="20" cy="21" r="1.5" />
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                        </svg>
                    @elseif($icon === 'users')
                        <!-- Parties / Accounts Icon -->
                        <svg class="w-8 h-8 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    @elseif($icon === 'cash')
                        <!-- Cash / Receipts / Payments Icon -->
                        <svg class="w-8 h-8 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="6" width="20" height="12" rx="2" />
                            <circle cx="12" cy="12" r="2" />
                            <path d="M6 12h.01M18 12h.01" />
                        </svg>
                    @elseif($icon === 'medical')
                        <!-- Medical Rep Icon -->
                        <svg class="w-8 h-8 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z" />
                            <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z" />
                            <path d="M9 12H4s.5-1 1-2 2-2 4-2" />
                        </svg>
                    @elseif($icon === 'company')
                        <!-- Companies Icon -->
                        <svg class="w-8 h-8 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 21h18M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16M9 9h1M9 13h1M9 17h1M14 9h1M14 13h1M14 17h1" />
                        </svg>
                    @elseif($icon === 'salesman')
                        <!-- Salesmen Icon -->
                        <svg class="w-8 h-8 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    @elseif($icon === 'bank')
                        <!-- Bank Icon -->
                        <svg class="w-8 h-8 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 21h18M3 10h18M5 10v11M9 10v11M15 10v11M19 10v11M12 2L2 7h20L12 2z" />
                        </svg>
                    @elseif($icon === 'expense')
                        <!-- Expense Icon -->
                        <svg class="w-8 h-8 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="16" y1="13" x2="8" y2="13" />
                            <line x1="16" y1="17" x2="8" y2="17" />
                            <line x1="10" y1="9" x2="8" y2="9" />
                        </svg>
                    @elseif($icon === 'amanat')
                        <!-- Amanat / Trust Vault Icon -->
                        <svg class="w-8 h-8 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                    @elseif($icon === 'lottery')
                        <!-- Lottery / Prize Icon -->
                        <svg class="w-8 h-8 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                    @else
                        <!-- Generic Module Icon -->
                        <svg class="w-8 h-8 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                            <path d="M9 3v18M15 3v18M3 9h18M3 15h18" />
                        </svg>
                    @endif
                </div>

                <!-- Title (Bold black sans-serif font matching reference) -->
                <h1 class="text-2xl font-black text-black tracking-normal font-sans">
                    {{ $title }}
                </h1>
            </div>

            <!-- Current Record Status indicator -->
            <div class="text-right flex items-center gap-2">
                <div class="hidden md:flex items-center gap-2 text-xs font-bold text-slate-900 bg-white/40 backdrop-blur-sm px-3 py-1 rounded-full border border-white/50">
                    <span class="w-2 h-2 rounded-full bg-emerald-700 animate-pulse"></span>
                    <span x-text="mode === 'new' ? 'New Entry' : (mode === 'edit' ? 'Editing Record' : 'Record View')"></span>
                </div>
                <template x-if="hasRecord">
                    <span class="text-xs font-bold text-black bg-white/50 px-2.5 py-1 rounded-md border border-white/60">
                        <span x-text="form.code ? 'Party Code:' : (form.voucher_no ? 'Voucher:' : (form.invoice_no ? 'Invoice:' : 'Record ID:'))"></span> <span class="font-mono font-black" x-text="form.code || form.voucher_no || form.invoice_no || ('#' + form.id)"></span>
                    </span>
                </template>
            </div>
        </div>
    </div>

    <!-- Desktop Action Toolbar Strip (Exact match with reference image) -->
    <div class="bg-[#f2f4f8] border-t border-b border-[#c8d1dc] px-3 py-1.5 flex items-center gap-1.5 overflow-x-auto shadow-sm">
        
        <!-- 1. + New Button (Selected box state when in new mode) -->
        <button type="button" 
                @click="startNew()"
                :class="mode === 'new' ? 'border-[#00a2e8] bg-white ring-1 ring-[#00a2e8]' : 'border-transparent hover:border-[#b4c3d4] hover:bg-white'"
                class="group flex flex-col items-center justify-center min-w-[56px] h-[52px] px-2 py-1 rounded border shadow-sm transition-all focus:outline-none cursor-pointer"
                title="Create New (Alt+N)">
            <div class="text-black font-bold">
                <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" stroke-width="2.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <span class="text-[11px] font-bold text-black leading-tight mt-0.5">
                <span class="underline">N</span>ew
            </span>
        </button>

        <!-- 2. Find Button (Search existing records) -->
        <button type="button" 
                @click="showFindModal = true"
                class="group flex flex-col items-center justify-center min-w-[56px] h-[52px] px-2 py-1 rounded border border-transparent hover:border-[#b4c3d4] hover:bg-white text-black transition-all focus:outline-none cursor-pointer"
                title="Find / Search Records (Alt+F)">
            <div class="text-black">
                <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="7" />
                    <line x1="21" y1="21" x2="16" y2="16" stroke-width="2.8" />
                </svg>
            </div>
            <span class="text-[11px] font-bold text-black leading-tight mt-0.5">
                <span class="underline">F</span>ind
            </span>
        </button>

        <!-- 3. Edit Button (Active without cross when record loaded; Disabled with Red Cross otherwise) -->
        <button type="button"
                @click="startEdit()"
                :disabled="!hasRecord || mode === 'edit'"
                :class="{
                    'opacity-60 cursor-not-allowed': !hasRecord,
                    'hover:border-[#b4c3d4] hover:bg-white cursor-pointer': hasRecord && mode !== 'edit',
                    'border-[#00a2e8] bg-white ring-1 ring-[#00a2e8] cursor-default': mode === 'edit'
                }"
                class="group relative flex flex-col items-center justify-center min-w-[56px] h-[52px] px-2 py-1 rounded border border-transparent transition-all focus:outline-none"
                title="Edit Loaded Record (Alt+E)">
            <div class="relative text-slate-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z" />
                </svg>
                <!-- Red Cross Badge shown when disabled (no record loaded) -->
                <span x-show="!hasRecord" class="absolute -bottom-1 -right-1 text-red-600 font-extrabold text-xs leading-none drop-shadow">✕</span>
            </div>
            <span class="text-[11px] font-bold text-slate-700 leading-tight mt-0.5">
                <span class="underline">E</span>dit
            </span>
        </button>

        <!-- 4. Save Button (Active without cross in New or Edit mode; Disabled with Red Cross in View mode) -->
        <button type="submit"
                form="{{ $formId }}"
                :disabled="mode === 'view'"
                :class="{
                    'border-[#00a2e8] bg-white hover:bg-[#e1f2fc] cursor-pointer shadow-sm text-black': mode === 'new' || mode === 'edit',
                    'opacity-60 cursor-not-allowed text-slate-400': mode === 'view'
                }"
                class="group relative flex flex-col items-center justify-center min-w-[56px] h-[52px] px-2 py-1 rounded border border-transparent transition-all focus:outline-none"
                title="Save Record (Alt+S)">
            <div class="relative text-slate-800">
                <!-- 3.5" Floppy Disk SVG -->
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                    <polyline points="17 21 17 13 7 13 7 21" />
                    <polyline points="7 3 7 8 15 8" />
                </svg>
                <!-- Red Cross Badge shown when disabled in view mode -->
                <span x-show="mode === 'view'" class="absolute -bottom-1 -right-1 text-red-600 font-extrabold text-xs leading-none drop-shadow">✕</span>
            </div>
            <span class="text-[11px] font-bold leading-tight mt-0.5" :class="mode === 'view' ? 'text-slate-500' : 'text-black'">
                <span class="underline">S</span>ave
            </span>
        </button>

        <!-- 5. Delete Button (Active without cross when record loaded; Disabled with Red Cross when new) -->
        <button type="button" 
                @click="confirmDelete()"
                :disabled="!hasRecord"
                :class="{
                    'opacity-60 cursor-not-allowed text-slate-400': !hasRecord,
                    'hover:border-red-400 hover:bg-white cursor-pointer text-slate-800': hasRecord
                }"
                class="group relative flex flex-col items-center justify-center min-w-[56px] h-[52px] px-2 py-1 rounded border border-transparent transition-all focus:outline-none"
                title="Delete Record (Alt+D)">
            <div class="relative text-slate-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                <!-- Red Cross Badge shown when disabled (no record) -->
                <span x-show="!hasRecord" class="absolute -bottom-1 -right-1 text-red-600 font-extrabold text-xs leading-none drop-shadow">✕</span>
            </div>
            <span class="text-[11px] font-bold leading-tight mt-0.5" :class="!hasRecord ? 'text-slate-500' : 'text-slate-700'">
                <span class="underline">D</span>elete
            </span>
        </button>

        <!-- 6. Refresh Button -->
        <button type="button" 
                @click="refreshForm()"
                class="group flex flex-col items-center justify-center min-w-[56px] h-[52px] px-2 py-1 rounded border border-transparent hover:border-[#b4c3d4] hover:bg-white text-black transition-all focus:outline-none cursor-pointer"
                title="Refresh Form / Cancel Changes (Alt+R)">
            <div class="text-black">
                <svg class="w-5 h-5 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67" />
                </svg>
            </div>
            <span class="text-[11px] font-bold text-black leading-tight mt-0.5">
                <span class="underline">R</span>efresh
            </span>
        </button>

        <!-- 7. Exit Button -->
        <a href="{{ $exitRoute ?? route('dashboard') }}" 
           class="group flex flex-col items-center justify-center min-w-[56px] h-[52px] px-2 py-1 rounded border border-transparent hover:border-red-400 hover:bg-red-50 text-black transition-all focus:outline-none cursor-pointer"
           title="Exit to Dashboard (Alt+E)">
            <div class="text-black group-hover:text-red-600">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
            </div>
            <span class="text-[11px] font-bold text-black group-hover:text-red-600 leading-tight mt-0.5">
                <span class="underline">E</span>xit
            </span>
        </a>

    </div>
</div>
