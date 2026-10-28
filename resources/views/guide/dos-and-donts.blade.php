@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 pt-5 space-y-6" 
     x-data="{
        activeType: '{{ $initialType ?? request('type', 'all') }}',
        activeCategory: '{{ $initialCategory ?? request('category', 'all') }}',
        searchQuery: '{{ $initialQuery ?? request('q', '') }}',
        
        setType(type) {
            this.activeType = type;
            this.updateUrl();
        },
        
        setCategory(cat) {
            this.activeCategory = cat;
            this.updateUrl();
        },
        
        updateUrl() {
            const url = new URL(window.location);
            if (this.activeType && this.activeType !== 'all') {
                url.searchParams.set('type', this.activeType);
            } else {
                url.searchParams.delete('type');
            }
            if (this.activeCategory && this.activeCategory !== 'all') {
                url.searchParams.set('category', this.activeCategory);
            } else {
                url.searchParams.delete('category');
            }
            if (this.searchQuery && this.searchQuery.trim() !== '') {
                url.searchParams.set('q', this.searchQuery);
            } else {
                url.searchParams.delete('q');
            }
            window.history.replaceState({}, '', url);
        },
        
        matches(ruleType, ruleCat, title, desc) {
            const matchType = (this.activeType === 'all' || ruleType === this.activeType);
            const matchCat = (this.activeCategory === 'all' || ruleCat === this.activeCategory);
            const matchSearch = !this.searchQuery || 
                title.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                desc.toLowerCase().includes(this.searchQuery.toLowerCase());
            return matchType && matchCat && matchSearch;
        },
        
        get visibleCount() {
            return this.rulesData.filter(r => this.matches(r.type, r.category, r.title, r.description)).length;
        },
        
        rulesData: {{ Js::from($rules->map(fn($r) => ['id' => $r->id, 'type' => $r->type, 'category' => $r->category, 'title' => $r->title, 'description' => $r->description])) }}
     }">

    <!-- Header & Breadcrumb -->
    <div>
        <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-2">
            <a href="{{ route('guide.index') }}" class="hover:text-[#0084f8]">Beranda</a>
            <span>/</span>
            <span class="text-[#0f2e54]">Dos & Don'ts</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0f2e54] tracking-tight">Pedoman Dos & Don'ts</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Etiket kerja, budaya 5S, dan standar keselamatan kerja (K3) di Akebono Karawang</p>
            </div>
            <div class="flex items-center gap-2 text-xs font-bold shrink-0">
                <span class="px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full border border-emerald-200">
                    ✓ {{ $counts['dos'] }} DOs
                </span>
                <span class="px-3 py-1 bg-rose-50 text-rose-700 rounded-full border border-rose-200">
                    ✕ {{ $counts['donts'] }} DON'Ts
                </span>
            </div>
        </div>
    </div>

    <!-- Filters & Instant Tabs (Zero Loading / Tanpa Reload) -->
    <div class="bg-white rounded-3xl p-4 sm:p-5 soft-shadow border border-slate-200/80 space-y-4">
        
        <!-- DO / DONT Instant Toggle Buttons -->
        <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
            <button type="button"
                    @click="setType('all')" 
                    :class="activeType === 'all' ? 'bg-[#0084f8] text-white shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600'"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition cursor-pointer select-none">
                Semua ({{ $counts['total'] }})
            </button>
            <button type="button"
                    @click="setType('do')" 
                    :class="activeType === 'do' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-emerald-50 hover:bg-emerald-100 text-emerald-800'"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition cursor-pointer select-none">
                ✓ Yang Harus Dilakukan (DO)
            </button>
            <button type="button"
                    @click="setType('dont')" 
                    :class="activeType === 'dont' ? 'bg-rose-600 text-white shadow-xs' : 'bg-rose-50 hover:bg-rose-100 text-rose-800'"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition cursor-pointer select-none">
                ✕ Yang Dilarang (DON'T)
            </button>
        </div>

        <!-- Category Row (Instant Filter without Loading) -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
            @foreach($categories as $catKey => $catLabel)
                <button type="button"
                        @click="setCategory('{{ $catKey }}')" 
                        :class="activeCategory === '{{ $catKey }}' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600'"
                        class="px-3.5 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition cursor-pointer select-none">
                    {{ $catLabel }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Rules List Cards (Instant Reactive Display) -->
    <div class="space-y-4">
        @foreach($rules as $rule)
            <div x-show="matches('{{ $rule->type }}', '{{ $rule->category }}', {{ Js::from($rule->title) }}, {{ Js::from($rule->description) }})"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 transform translate-y-1"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 class="bg-white rounded-3xl p-5 sm:p-6 soft-shadow border {{ $rule->type === 'do' ? 'border-emerald-100 hover:border-emerald-300' : 'border-rose-100 hover:border-rose-300' }} card-hover transition-all">
                <div class="flex items-start gap-4">
                    <!-- Icon / Badge -->
                    <div class="w-12 h-12 rounded-2xl {{ $rule->type === 'do' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }} flex items-center justify-center shrink-0 font-extrabold text-xl shadow-xs">
                        {{ $rule->type === 'do' ? '✓' : '✕' }}
                    </div>

                    <!-- Rule Body -->
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <span class="text-[11px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-md {{ $rule->type === 'do' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-rose-50 text-rose-800 border border-rose-200' }}">
                                {{ $rule->type === 'do' ? 'DIANJURKAN (DO)' : 'DILARANG (DON\'T)' }}
                            </span>
                            <span class="text-xs font-semibold text-slate-400">
                                {{ $rule->category }}
                            </span>
                        </div>

                        <h3 class="text-base sm:text-lg font-extrabold text-[#0f2e54] mt-2 leading-snug">
                            {{ $rule->title }}
                        </h3>

                        <p class="text-xs sm:text-sm text-slate-600 mt-1.5 leading-relaxed font-normal">
                            {{ $rule->description }}
                        </p>

                        @if($rule->tip_or_consequence)
                            <div class="mt-3.5 pt-3 border-t border-slate-100 flex items-start gap-2 text-xs {{ $rule->type === 'do' ? 'text-emerald-800 bg-emerald-50/60' : 'text-rose-800 bg-rose-50/60' }} p-2.5 rounded-xl">
                                <span class="font-bold shrink-0">{{ $rule->type === 'do' ? '💡 Alasan/Manfaat:' : '⚠️ Konsekuensi/Peringatan:' }}</span>
                                <span class="font-medium">{{ $rule->tip_or_consequence }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Empty State if no rules match filter -->
        <div x-show="visibleCount === 0" x-cloak class="bg-white rounded-3xl p-12 text-center soft-shadow border border-slate-200">
            <p class="text-sm text-slate-500">Tidak ada pedoman yang cocok dengan pilihan filter ini.</p>
            <button type="button" @click="setType('all'); setCategory('all'); searchQuery = ''" class="mt-3 inline-block px-4 py-2 bg-sky-50 hover:bg-sky-100 text-[#0084f8] text-xs font-bold rounded-full transition cursor-pointer">
                Tampilkan Semua
            </button>
        </div>
    </div>

</div>
@endsection
