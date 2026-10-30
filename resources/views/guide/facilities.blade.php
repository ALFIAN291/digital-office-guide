@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 pt-5 space-y-6" 
     x-data="{ 
        activeCategory: '{{ request('category', 'all') }}',
        activeFloor: '{{ request('floor', 'all') }}',
        searchQuery: '{{ request('q', '') }}',
        
        setCategory(cat) {
            this.activeCategory = cat;
            this.updateUrl();
        },
        
        setFloor(fl) {
            this.activeFloor = fl;
            this.updateUrl();
        },
        
        updateUrl() {
            const url = new URL(window.location);
            if (this.activeCategory && this.activeCategory !== 'all') {
                url.searchParams.set('category', this.activeCategory);
            } else {
                url.searchParams.delete('category');
            }
            if (this.activeFloor && this.activeFloor !== 'all') {
                url.searchParams.set('floor', this.activeFloor);
            } else {
                url.searchParams.delete('floor');
            }
            if (this.searchQuery && this.searchQuery.trim() !== '') {
                url.searchParams.set('q', this.searchQuery);
            } else {
                url.searchParams.delete('q');
            }
            window.history.replaceState({}, '', url);
        },
        
        matches(category, floor, name, desc, loc) {
            const catMatch = (this.activeCategory === 'all' || category === this.activeCategory);
            const floorMatch = (this.activeFloor === 'all' || floor === this.activeFloor);
            const searchMatch = !this.searchQuery || 
                name.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                desc.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                loc.toLowerCase().includes(this.searchQuery.toLowerCase());
            return catMatch && floorMatch && searchMatch;
        },
        
        get visibleCount() {
            return this.facilitiesData.filter(f => this.matches(f.category, f.floor, f.name, f.description, f.location)).length;
        },
        
        facilitiesData: {{ Js::from($facilities->map(fn($f) => ['category' => $f->category, 'floor' => $f->floor, 'name' => $f->name, 'description' => $f->description, 'location' => $f->location_detail])) }}
     }">

    <!-- Header & Breadcrumb -->
    <div>
        <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-2">
            <a href="{{ route('guide.index') }}" class="hover:text-[#0084f8]">Beranda</a>
            <span>/</span>
            <span class="text-[#0f2e54]">Fasilitas Kantor</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0f2e54] tracking-tight">Fasilitas Kantor & Pabrik</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Panduan lengkap ruangan, kapasitas, dan jam operasional di Akebono Karawang</p>
            </div>
            <span class="px-3 py-1 bg-sky-50 text-[#0084f8] text-xs font-bold rounded-full w-fit">
                <span x-text="visibleCount">{{ $facilities->count() }}</span> Fasilitas Ditampilkan
            </span>
        </div>
    </div>

    <!-- Filters & Search Form (Instant Client-side Reactive) -->
    <div class="bg-white rounded-3xl p-4 sm:p-5 soft-shadow border border-slate-200/80 space-y-4">
        <!-- Search bar -->
        <div class="relative">
            <input type="text" 
                   x-model="searchQuery" 
                   @input.debounce.250ms="updateUrl()" 
                   placeholder="Cari nama fasilitas, ruangan, atau perlengkapan..."
                   class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs sm:text-sm focus:bg-white focus:outline-hidden focus:border-[#0084f8] transition">
            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>

        <!-- Filter Row -->
        <div class="flex flex-wrap items-center justify-between gap-3 pt-1">
            <!-- Category Pills (Instant Filter without Loading) -->
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 max-w-full scrollbar-none">
                @foreach($categories as $key => $label)
                    <button type="button"
                            @click="setCategory('{{ $key }}')" 
                            :class="activeCategory === '{{ $key }}' ? 'bg-[#0084f8] text-white shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600'"
                            class="px-3 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition cursor-pointer select-none">
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            <!-- Floor Selector -->
            <div class="flex items-center gap-2">
                <label for="floorSelect" class="text-xs font-bold text-slate-500 whitespace-nowrap">Lantai:</label>
                <select id="floorSelect" 
                        x-model="activeFloor" 
                        @change="setFloor($event.target.value)" 
                        class="text-xs font-semibold bg-slate-50 border border-slate-200 rounded-xl px-2.5 py-1.5 focus:outline-hidden text-slate-700 cursor-pointer">
                    @foreach($floors as $fKey => $fVal)
                        <option value="{{ $fKey }}">{{ $fVal }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Search Query Status Banner -->
    <div x-show="searchQuery && searchQuery.trim() !== ''" x-cloak class="flex items-center justify-between p-3.5 bg-sky-50 rounded-2xl border border-sky-200">
        <div class="text-xs text-sky-900">
            Hasil pencarian untuk: <span class="font-extrabold text-[#0084f8]" x-text="'&quot;' + searchQuery + '&quot;'"></span> 
            (<span x-text="visibleCount"></span> fasilitas ditemukan)
        </div>
        <button type="button" @click="searchQuery = ''; updateUrl()" class="text-xs font-bold text-slate-500 hover:text-slate-800 cursor-pointer">
            ✕ Hapus Pencarian
        </button>
    </div>

    <!-- Facilities Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-6">
        @foreach($facilities as $facility)
            <a href="{{ route('guide.facility.detail', $facility->slug) }}"
               x-show="matches('{{ $facility->category }}', '{{ $facility->floor }}', {{ Js::from($facility->name) }}, {{ Js::from($facility->description) }}, {{ Js::from($facility->location_detail) }})"
               x-transition:enter="transition ease-out duration-150"
               x-transition:enter-start="opacity-0 transform translate-y-1"
               x-transition:enter-end="opacity-100 transform translate-y-0"
               class="group bg-white rounded-2xl sm:rounded-3xl soft-shadow border border-slate-200/80 overflow-hidden card-hover flex flex-col justify-between cursor-pointer">
                
                <!-- Photo Header -->
                <div class="relative h-36 sm:h-48 w-full bg-slate-100 overflow-hidden">
                    <img src="{{ office_image($facility->image_path, 'images/facilities-office.jpg') }}" alt="{{ $facility->name }}" class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-300">
                    <div class="absolute top-2.5 sm:top-3 left-2.5 sm:left-3 flex items-center gap-1.5">
                        <span class="px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-full bg-white/95 backdrop-blur-xs text-[10px] sm:text-[11px] font-bold text-slate-700 shadow-xs">
                            {{ $facility->floor }}
                        </span>
                        @if($facility->is_featured)
                            <span class="px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-full bg-[#0084f8] text-white text-[10px] sm:text-[11px] font-bold shadow-xs">
                                ★ Populer
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Details Body -->
                <div class="p-3.5 sm:p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="text-[10px] sm:text-[11px] font-bold uppercase tracking-wider text-[#0084f8] mb-0.5 sm:mb-1">
                            {{ strtoupper($facility->category) }}
                        </div>
                        <h3 class="text-sm sm:text-lg font-extrabold text-[#0f2e54] leading-snug group-hover:text-[#0084f8] transition-colors line-clamp-1 sm:line-clamp-none">
                            {{ $facility->name }}
                        </h3>

                        <!-- Description (Hanya di layar desktop/tablet agar di mobile ringkas & cepat di-scan) -->
                        <p class="hidden sm:block text-xs text-slate-500 mt-1.5 line-clamp-2 leading-relaxed">
                            {{ $facility->description }}
                        </p>

                        <!-- Meta Chips (Desktop Only) -->
                        <div class="hidden sm:flex mt-3.5 pt-3 border-t border-slate-100 flex-wrap items-center gap-2 text-[11px] text-slate-600 font-medium">
                            @if($facility->capacity)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-50 border border-slate-100">
                                    👥 {{ $facility->capacity }}
                                </span>
                            @endif
                            @if($facility->operating_hours)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-50 border border-slate-100">
                                    🕒 {{ $facility->operating_hours }}
                                </span>
                            @endif
                        </div>

                        <!-- Amenities Tags (Desktop Only) -->
                        @if(!empty($facility->amenities))
                            <div class="hidden sm:flex mt-2.5 flex-wrap gap-1.5">
                                @foreach(array_slice($facility->amenities, 0, 3) as $amenity)
                                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded bg-sky-50 text-[#0b3c6d]">
                                        ✓ {{ $amenity }}
                                    </span>
                                @endforeach
                                @if(count($facility->amenities) > 3)
                                    <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded bg-slate-100 text-slate-500">
                                        +{{ count($facility->amenities) - 3 }} lainnya
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Card Footer Action -->
                    <div class="mt-2.5 sm:mt-4 pt-2.5 sm:pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                        <span class="text-[10px] sm:text-[11px] text-slate-400 font-medium truncate max-w-[170px] sm:max-w-[200px]">
                            📍 {{ $facility->location_detail }}
                        </span>
                        <span class="inline-flex items-center gap-1 px-3 sm:px-3.5 py-1 sm:py-1.5 bg-sky-50 text-[#0084f8] group-hover:bg-[#0084f8] group-hover:text-white text-[11px] sm:text-xs font-bold rounded-full transition shadow-2xs shrink-0">
                            <span>Detail</span>
                            <span>→</span>
                        </span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Empty State if no facilities match -->
    <div x-show="visibleCount === 0" x-cloak class="bg-white rounded-3xl p-12 text-center soft-shadow border border-slate-200">
        <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl">
            🔍
        </div>
        <h3 class="text-lg font-bold text-slate-800">Fasilitas Tidak Ditemukan</h3>
        <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">Tidak ada fasilitas yang cocok dengan filter atau kata kunci pencarian Anda.</p>
        <button type="button" @click="activeCategory = 'all'; activeFloor = 'all'; searchQuery = ''; updateUrl()" class="mt-4 inline-block px-5 py-2 bg-sky-50 text-[#0084f8] text-xs font-bold rounded-full hover:bg-sky-100 transition cursor-pointer">
            Reset Filter
        </button>
    </div>

</div>
@endsection
