@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 pt-2 pb-4 space-y-4 sm:space-y-6" 
     x-data="{
        activeTab: '{{ $initialCategory ?? 'General' }}',
        searchQuery: '{{ $initialQuery ?? '' }}',
        categoryTitles: {{ Js::from($categories) }},
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

    <!-- Top Hero Banner (Sleek, Compact & Modern) -->
    <div class="relative overflow-hidden rounded-2xl sm:rounded-3xl p-4 sm:p-6 text-white shadow-xs"
         style="background: radial-gradient(135% 120% at 85% 15%, #38bdf8 0%, #0084f8 45%, #0056b3 100%);">
        
        <!-- Subtle decorative glow rings -->
        <div class="absolute -right-12 -bottom-12 w-48 h-48 rounded-full border-[20px] border-white/10 pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
            <div>
                <h1 class="text-xl sm:text-3xl font-extrabold tracking-tight drop-shadow-xs">Office Dos & Don'ts</h1>
                <p class="text-white/90 text-xs sm:text-sm font-medium mt-0.5">Simple habits for a better workplace.</p>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-[11px] sm:text-xs font-bold text-white border border-white/30 w-fit">
                <span class="text-emerald-300">✓</span>
                <span>Respect · Safety · 5S</span>
            </span>
        </div>
    </div>

    <!-- Search Guidelines Bar (Ramping di Mobile) -->
    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
        <input type="text" 
               x-model="searchQuery" 
               @input.debounce.200ms="updateUrl()"
               placeholder="Search guidelines..." 
               class="w-full pl-10 pr-4 py-2.5 sm:py-3 bg-white text-slate-800 rounded-full text-xs sm:text-sm border border-slate-200/90 shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-[#0084f8] focus:border-[#0084f8] placeholder-slate-400 transition-all">
        
        <button x-show="searchQuery" 
                @click="searchQuery = ''; updateUrl()" 
                type="button" 
                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Category Tabs Filter Pills (Matching Mockup) -->
    <div class="flex items-center gap-1.5 sm:gap-2 overflow-x-auto pb-0.5 scrollbar-none">
        @foreach($categories as $catKey => $catTitle)
            <button type="button"
                    @click="setTab('{{ $catKey }}')"
                    :class="activeTab === '{{ $catKey }}' ? 'bg-[#0084f8] text-white shadow-xs font-bold' : 'bg-white text-slate-600 hover:text-slate-900 border border-slate-200/80 font-medium'"
                    class="px-3.5 sm:px-5 py-1.5 sm:py-2 rounded-full text-xs sm:text-sm whitespace-nowrap transition cursor-pointer select-none">
                {{ $catKey }}
            </button>
        @endforeach
    </div>

    <!-- Dynamic Section Title -->
    <div class="pt-1">
        <h2 class="text-lg sm:text-xl font-extrabold text-[#0f2e54] tracking-tight"
            x-text="searchQuery ? ('Hasil Pencarian (' + visibleCount + ')') : (categoryTitles[activeTab] || (activeTab + ' Etiquette'))">
            {{ $categories[$initialCategory ?? 'General'] ?? 'General Etiquette' }}
        </h2>
    </div>

    <!-- Guideline Cards (Layout: [ Gambar di Kiri ] | [ DO (Atas) & DON'T (Bawah) di Kanan ]) -->
    <div class="space-y-3 sm:space-y-4">
        @foreach($pairs as $item)
            <div x-show="matches({{ Js::from($item) }})"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 transform translate-y-1"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 class="bg-white rounded-2xl sm:rounded-3xl p-2.5 sm:p-4 shadow-xs border border-slate-200/80 hover:border-sky-300 flex flex-row items-stretch gap-2.5 sm:gap-4 transition-all hover:shadow-md">
                
                <!-- 1. Gambar di Kiri (Proporsional & Mengikuti Tinggi Isi) -->
                <div class="w-24 sm:w-44 md:w-52 rounded-xl sm:rounded-2xl overflow-hidden shrink-0 bg-slate-100 relative self-stretch">
                    <img src="{{ $item['image'] }}" 
                         alt="{{ $item['category'] }}" 
                         class="w-full h-full object-cover">
                </div>

                <!-- 2. DO & DON'T di Kanan (Atas-Bawah Rapi & Terstruktur) -->
                <div class="flex-1 flex flex-col justify-between gap-2 sm:gap-2.5 min-w-0">
                    
                    <!-- Atas: DO Box (Pastel Green) -->
                    <div class="bg-[#eaf8ee] rounded-xl sm:rounded-2xl p-2.5 sm:p-3.5 flex flex-col justify-center border border-emerald-100/80 flex-1">
                        <div class="flex items-center gap-1.5 text-emerald-700 font-extrabold text-[11px] sm:text-xs tracking-wider uppercase mb-0.5 sm:mb-1">
                            <span class="inline-flex items-center justify-center w-3.5 h-3.5 rounded-full bg-emerald-600 text-white text-[9px] font-black">✓</span>
                            <span>DO</span>
                        </div>
                        <p class="text-slate-800 text-xs sm:text-sm font-bold leading-snug">
                            {{ $item['do'] }}
                        </p>
                        @if(!empty($item['do_sub']))
                            <p class="text-[10px] sm:text-xs text-slate-600 mt-0.5 sm:mt-1 font-normal leading-relaxed line-clamp-2 sm:line-clamp-none">
                                {{ $item['do_sub'] }}
                            </p>
                        @endif
                    </div>

                    <!-- Bawah: DON'T Box (Pastel Red/Pink) -->
                    <div class="bg-[#feeff0] rounded-xl sm:rounded-2xl p-2.5 sm:p-3.5 flex flex-col justify-center border border-rose-100/80 flex-1">
                        <div class="flex items-center gap-1.5 text-rose-600 font-extrabold text-[11px] sm:text-xs tracking-wider uppercase mb-0.5 sm:mb-1">
                            <span class="inline-flex items-center justify-center w-3.5 h-3.5 rounded-full bg-rose-600 text-white text-[9px] font-black">✕</span>
                            <span>DON'T</span>
                        </div>
                        <p class="text-slate-800 text-xs sm:text-sm font-bold leading-snug">
                            {{ $item['dont'] }}
                        </p>
                        @if(!empty($item['dont_sub']))
                            <p class="text-[10px] sm:text-xs text-slate-600 mt-0.5 sm:mt-1 font-normal leading-relaxed line-clamp-2 sm:line-clamp-none">
                                {{ $item['dont_sub'] }}
                            </p>
                        @endif
                    </div>

                </div>

            </div>
        @endforeach
    </div>

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
