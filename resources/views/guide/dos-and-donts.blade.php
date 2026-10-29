@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 pt-2 pb-16 space-y-5 sm:space-y-6" 
     x-data="{
        activeTab: '{{ $initialCategory ?? 'General' }}',
        searchQuery: '{{ $initialQuery ?? '' }}',
        categoryTitles: {
            'General': 'General Etiquette',
            'Meeting Room': 'Meeting Room Etiquette',
            'Workspace': 'Workspace Etiquette',
            'Canteen': 'Canteen Etiquette',
            'Safety': 'Safety Etiquette'
        },
        items: {{ Js::from($pairs) }},
        
        setTab(tab) {
            this.activeTab = tab;
            this.updateUrl();
        },
        
        updateUrl() {
            const url = new URL(window.location);
            if (this.activeTab && this.activeTab !== 'General') {
                url.searchParams.set('category', this.activeTab);
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
        
        matches(item) {
            const matchesCat = (!this.activeTab || this.activeTab === 'all' || item.category === this.activeTab);
            const q = this.searchQuery.toLowerCase().trim();
            if (!q) return matchesCat;
            
            const matchesSearch = item.do.toLowerCase().includes(q) || 
                                  item.dont.toLowerCase().includes(q) || 
                                  (item.do_sub && item.do_sub.toLowerCase().includes(q)) ||
                                  (item.dont_sub && item.dont_sub.toLowerCase().includes(q)) ||
                                  item.category.toLowerCase().includes(q);
                                  
            return (this.searchQuery.trim() !== '') ? matchesSearch : (matchesCat && matchesSearch);
        },
        
        get visibleCount() {
            return this.items.filter(item => this.matches(item)).length;
        }
     }">

    <!-- Top Blue Hero Banner (Matching Mockup) -->
    <div class="relative overflow-hidden rounded-3xl p-6 sm:p-8 text-white shadow-md"
         style="background: radial-gradient(135% 120% at 85% 15%, #38bdf8 0%, #0084f8 45%, #0056b3 100%);">
        
        <!-- Subtle decorative glow rings -->
        <div class="absolute -right-12 -bottom-12 w-64 h-64 rounded-full border-[28px] border-white/10 pointer-events-none"></div>
        <div class="absolute right-16 -top-24 w-80 h-80 rounded-full border-[36px] border-white/10 pointer-events-none"></div>
        
        <div class="relative z-10 max-w-xl">
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight drop-shadow-xs">Office Dos & Don'ts</h1>
            <p class="text-white/95 text-xs sm:text-sm md:text-base font-medium mt-1.5 tracking-normal">
                Simple habits for a better workplace.
            </p>
        </div>
    </div>

    <!-- Featured Office Photo Card with Pill Overlay (Matching Mockup) -->
    <div class="relative rounded-2xl sm:rounded-3xl overflow-hidden shadow-xs border border-slate-200/70 group">
        <img src="{{ asset('images/hero-office.jpg') }}" 
             alt="Office Environment" 
             class="w-full h-44 sm:h-56 md:h-64 object-cover transition-transform duration-500 group-hover:scale-[1.01]">
        
        <!-- Frosted Glass Pill Badge: Respect · Safety · 5S -->
        <div class="absolute bottom-3.5 left-3.5 sm:bottom-4 sm:left-4 bg-white/90 backdrop-blur-md px-3.5 py-1.5 rounded-full text-slate-800 text-xs sm:text-sm font-semibold shadow-xs flex items-center gap-1.5 border border-white/60">
            <span class="text-emerald-600 font-bold">✓</span>
            <span>Respect · Safety · 5S</span>
        </div>
    </div>

    <!-- Search Guidelines Bar (Matching Mockup) -->
    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
        <input type="text" 
               x-model="searchQuery" 
               @input.debounce.200ms="updateUrl()"
               placeholder="Search guidelines..." 
               class="w-full pl-11 pr-4 py-3 sm:py-3.5 bg-white text-slate-800 rounded-full text-sm sm:text-base border border-slate-200/90 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-[#0084f8] focus:border-[#0084f8] placeholder-slate-400 transition-all">
        
        <button x-show="searchQuery" 
                @click="searchQuery = ''; updateUrl()" 
                type="button" 
                class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Category Tabs Filter Pills (Matching Mockup: General, Meeting Room, Workspace, Canteen, Safety) -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
        @foreach($categories as $catKey => $catTitle)
            <button type="button"
                    @click="setTab('{{ $catKey }}')"
                    :class="activeTab === '{{ $catKey }}' ? 'bg-[#008ef7] text-white shadow-xs font-semibold' : 'bg-white text-slate-600 hover:text-slate-900 border border-slate-200/80 font-medium'"
                    class="px-5 py-2 rounded-full text-xs sm:text-sm whitespace-nowrap transition cursor-pointer select-none">
                {{ $catKey }}
            </button>
        @endforeach
    </div>

    <!-- Dynamic Section Title (Matching Mockup: e.g. "General Etiquette") -->
    <div class="pt-2">
        <h2 class="text-xl sm:text-2xl font-extrabold text-[#0f2e54] tracking-tight"
            x-text="searchQuery ? ('Hasil Pencarian (' + visibleCount + ')') : (categoryTitles[activeTab] || (activeTab + ' Etiquette'))">
            {{ $categories[$initialCategory ?? 'General'] ?? 'General Etiquette' }}
        </h2>
    </div>

    <!-- Guideline Cards (3-Part Layout: [ Photo Thumbnail ] | [ ✓ DO ] | [ ✕ DON'T ]) -->
    <div class="space-y-4">
        @foreach($pairs as $item)
            <div x-show="matches({{ Js::from($item) }})"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 transform translate-y-1"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 class="bg-white rounded-2xl sm:rounded-3xl p-3 sm:p-4 shadow-xs border border-slate-200/80 flex flex-col md:flex-row items-stretch gap-3 sm:gap-4 transition-all hover:shadow-md">
                
                <!-- 1. Left: Photo Thumbnail -->
                <div class="w-full md:w-56 h-36 md:h-auto rounded-xl sm:rounded-2xl overflow-hidden shrink-0 bg-slate-100 relative">
                    <img src="{{ $item['image'] }}" 
                         alt="{{ $item['category'] }}" 
                         class="w-full h-full object-cover">
                </div>

                <!-- 2. Center: DO Box (Pastel Green) -->
                <div class="flex-1 bg-[#eaf8ee] rounded-xl sm:rounded-2xl p-4 sm:p-5 flex flex-col justify-center border border-emerald-100/70">
                    <div class="flex items-center gap-1.5 text-emerald-700 font-extrabold text-xs sm:text-sm tracking-wider uppercase mb-1.5">
                        <span class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-emerald-600 text-white text-[10px] font-black">✓</span>
                        <span>DO</span>
                    </div>
                    <p class="text-slate-800 text-sm sm:text-[15px] font-bold leading-relaxed">
                        {{ $item['do'] }}
                    </p>
                    @if(!empty($item['do_sub']))
                        <p class="text-xs text-slate-600 mt-1 font-normal leading-normal">
                            {{ $item['do_sub'] }}
                        </p>
                    @endif
                </div>

                <!-- 3. Right: DON'T Box (Pastel Red/Pink) -->
                <div class="flex-1 bg-[#feeff0] rounded-xl sm:rounded-2xl p-4 sm:p-5 flex flex-col justify-center border border-rose-100/70">
                    <div class="flex items-center gap-1.5 text-rose-600 font-extrabold text-xs sm:text-sm tracking-wider uppercase mb-1.5">
                        <span class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-rose-600 text-white text-[10px] font-black">✕</span>
                        <span>DON'T</span>
                    </div>
                    <p class="text-slate-800 text-sm sm:text-[15px] font-bold leading-relaxed">
                        {{ $item['dont'] }}
                    </p>
                    @if(!empty($item['dont_sub']))
                        <p class="text-xs text-slate-600 mt-1 font-normal leading-normal">
                            {{ $item['dont_sub'] }}
                        </p>
                    @endif
                </div>

            </div>
        @endforeach

        <!-- Empty State if search or filter returns no items -->
        <div x-show="visibleCount === 0" x-cloak class="bg-white rounded-3xl p-10 text-center shadow-xs border border-slate-200">
            <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center text-xl font-bold mb-3">
                ⌕
            </div>
            <p class="text-sm font-semibold text-slate-700">Tidak ada pedoman yang cocok dengan kriteria pencarian ini.</p>
            <p class="text-xs text-slate-500 mt-1">Coba gunakan kata kunci lain atau pilih kategori yang berbeda.</p>
            <button type="button" 
                    @click="activeTab = 'General'; searchQuery = ''; updateUrl()" 
                    class="mt-4 inline-block px-5 py-2 bg-[#008ef7] hover:bg-[#007cdb] text-white text-xs font-bold rounded-full transition shadow-xs cursor-pointer">
                Reset ke General
            </button>
        </div>
    </div>

</div>
@endsection
