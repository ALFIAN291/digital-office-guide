@extends('layouts.app')

@section('content')
@php
    $gallery = $facility->gallery_list;
    $steps = $facility->usage_steps;
    $guidelineItems = collect(preg_split('/[\r\n.]+/', (string) $facility->guidelines))
        ->map(fn ($s) => trim($s))
        ->filter()
        ->values();
    $sidebarCategories = [
        ['label' => 'Meeting Room', 'icon' => '👥', 'cat' => 'meeting'],
        ['label' => 'Executive Meeting', 'icon' => '🏛️', 'cat' => 'meeting'],
        ['label' => 'Auditorium & Hall', 'icon' => '📽️', 'cat' => 'service'],
        ['label' => 'Visitor & Reception', 'icon' => '🪪', 'cat' => 'service'],
        ['label' => 'Canteen & Dining', 'icon' => '🍽️', 'cat' => 'dining'],
        ['label' => 'Office & Common', 'icon' => '💻', 'cat' => 'workspace'],
        ['label' => 'Building & Safety', 'icon' => '🛡️', 'cat' => 'safety'],
    ];
    $equipmentIcon = function (string $item): string {
        $lower = strtolower($item);
        return match (true) {
            str_contains($lower, 'screen'), str_contains($lower, 'display'), str_contains($lower, 'tv') => '🖥️',
            str_contains($lower, 'camera'), str_contains($lower, 'webex'), str_contains($lower, 'teams'), str_contains($lower, 'video') => '📹',
            str_contains($lower, 'mic') => '🎙️',
            str_contains($lower, 'speaker'), str_contains($lower, 'audio'), str_contains($lower, 'adzan') => '🔊',
            str_contains($lower, 'wi-fi'), str_contains($lower, 'wifi') => '📶',
            str_contains($lower, 'power'), str_contains($lower, 'usb'), str_contains($lower, 'charging') => '🔌',
            str_contains($lower, 'coffee'), str_contains($lower, 'air'), str_contains($lower, 'pantry') => '☕',
            str_contains($lower, 'dokter'), str_contains($lower, 'aed'), str_contains($lower, 'ambulans') => '🚑',
            default => '✓',
        };
    };
@endphp

<div class="max-w-6xl lg:max-w-none mx-auto px-4 sm:px-6 pt-4 space-y-5"
     x-data="{
        images: {{ Js::from($gallery) }},
        currentIndex: 0,
        bookingModalOpen: false,
        nextImage() {
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
        },
        prevImage() {
            this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
        }
     }">

    <!-- Breadcrumb -->
    <div class="flex items-center justify-between gap-2 flex-wrap">
        <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
            <a href="{{ route('guide.index') }}" class="hover:text-[#0084f8]">Beranda</a>
            <span>/</span>
            <a href="{{ route('guide.facilities') }}" class="hover:text-[#0084f8]">Fasilitas</a>
            <span>/</span>
            <span class="text-[#0f2e54] truncate max-w-xs">{{ $facility->name }}</span>
        </div>
        <a href="{{ route('guide.map', ['floor' => $facility->floor]) }}" class="text-xs font-bold text-[#0084f8] hover:underline">
            📍 Lihat di Denah Kantor →
        </a>
    </div>

    <!-- Desktop 2-Column Concept Slide 10 Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">

        <!-- Left Category Switcher Sidebar (Desktop Concept Slide 10) -->
        <div class="hidden lg:block lg:col-span-3 bg-white rounded-3xl soft-shadow border border-slate-200/80 p-4 space-y-3 sticky top-22">
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-[#0084f8]">05 / Facility Socialization</div>
                <h2 class="text-lg font-extrabold text-[#0f2e54] mt-0.5 leading-tight">{{ ucfirst($facility->category) }} Guide</h2>
                <p class="text-[11px] text-slate-500 mt-1">Modern spaces, equipment overview, and step-by-step usage guide.</p>
            </div>

            <div class="space-y-1 pt-2 border-t border-slate-100">
                @foreach($sidebarCategories as $sc)
                    @php
                        $isCurrentCat = $sc['cat'] === $facility->category;
                    @endphp
                    <a href="{{ route('guide.facilities', ['category' => $sc['cat']]) }}"
                       class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold transition {{ $isCurrentCat ? 'bg-[#0084f8] text-white shadow-xs' : 'bg-slate-50 text-slate-600 hover:bg-sky-50 hover:text-[#0f2e54]' }}">
                        <span>{{ $sc['icon'] }}</span>
                        <span class="truncate">{{ $sc['label'] }}</span>
                    </a>
                @endforeach
            </div>

            @if(isset($allFacilities) && $allFacilities->isNotEmpty())
                <div class="pt-3 border-t border-slate-100 space-y-1.5">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">All Facilities</div>
                    <div class="space-y-1 max-h-52 overflow-y-auto pr-1">
                        @foreach($allFacilities as $item)
                            <a href="{{ route('guide.facility.detail', $item->slug) }}"
                               class="block px-2.5 py-1.5 rounded-lg text-[11px] font-semibold truncate transition {{ $item->id === $facility->id ? 'bg-sky-50 text-[#0084f8] font-extrabold' : 'text-slate-600 hover:bg-slate-50' }}">
                                • {{ $item->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Main Facility Detail Column -->
        <div class="lg:col-span-9 space-y-5">

            <!-- Top Facility Card: Title Header + Carousel + Metadata Strip -->
            <div class="bg-white rounded-3xl soft-shadow border border-slate-200/80 overflow-hidden">
                <!-- Header Row with Book via SSO CTA (Concept Slide 10 Top Bar) -->
                <div class="p-4 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-sky-50 border border-sky-200 text-[#0084f8] flex items-center justify-center text-xl shrink-0">
                            {{ $facility->category === 'meeting' ? '👥' : ($facility->category === 'dining' ? '🍽️' : ($facility->category === 'safety' ? '🏥' : '🏢')) }}
                        </div>
                        <div>
                            <h1 class="text-xl sm:text-2xl font-extrabold text-[#0f2e54] tracking-tight leading-snug">{{ $facility->name }}</h1>
                            <div class="text-xs font-semibold text-slate-500 mt-0.5">
                                {{ $facility->floor }} • <span class="uppercase text-[#0084f8]">{{ $facility->category }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0 flex-wrap">
                        @if($facility->booking_url)
                            <a href="{{ $facility->booking_url }}" target="_blank" rel="noopener noreferrer"
                               class="px-4 py-2.5 bg-[#0084f8] hover:bg-[#0070d6] text-white font-extrabold text-xs rounded-xl shadow-sm transition inline-flex items-center gap-1.5">
                                <span>📅 Book via SSO Portal</span>
                                <span>↗</span>
                            </a>
                        @else
                            <button type="button" @click="bookingModalOpen = true"
                                    class="px-4 py-2.5 bg-[#0084f8] hover:bg-[#0070d6] text-white font-extrabold text-xs rounded-xl shadow-sm transition inline-flex items-center gap-1.5 cursor-pointer">
                                <span>📅 Book via SSO Portal</span>
                                <span>↗</span>
                            </button>
                        @endif
                        <a href="#how-to-use"
                           class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
                            ▶ View How to Use
                        </a>
                    </div>
                </div>

                <!-- Image Carousel Header (Matching Slide 10 < > and 1/4 Counter) -->
                <div class="relative h-56 sm:h-72 w-full overflow-hidden bg-slate-100">
                    <template x-for="(img, idx) in images" :key="idx">
                        <img x-show="currentIndex === idx"
                             :src="img"
                             alt="{{ $facility->name }}"
                             class="w-full h-full object-cover transition-opacity duration-300">
                    </template>
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent pointer-events-none"></div>

                    <!-- Carousel Arrows -->
                    <button type="button" @click="prevImage()" aria-label="Previous Photo"
                            class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/90 hover:bg-white text-slate-800 shadow-md flex items-center justify-center font-extrabold transition cursor-pointer">
                        ‹
                    </button>
                    <button type="button" @click="nextImage()" aria-label="Next Photo"
                            class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/90 hover:bg-white text-slate-800 shadow-md flex items-center justify-center font-extrabold transition cursor-pointer">
                        ›
                    </button>

                    <!-- Photo Counter Badge (1 / 4) -->
                    <div class="absolute bottom-3 right-3 px-2.5 py-1 rounded-lg bg-slate-900/75 text-white text-xs font-bold backdrop-blur-xs">
                        <span x-text="(currentIndex + 1) + ' / ' + images.length">1 / 1</span>
                    </div>

                    <div class="absolute bottom-3 left-4 flex items-center gap-2">
                        <span class="px-2.5 py-1 rounded-full bg-[#0084f8] text-white text-[11px] font-bold uppercase tracking-wider">
                            {{ $facility->floor }}
                        </span>
                        <span class="px-2.5 py-1 rounded-full bg-white/25 backdrop-blur-md text-white text-[11px] font-bold">
                            🕒 {{ $facility->operating_hours ?? '24 Jam' }}
                        </span>
                    </div>
                </div>

                <!-- 4 Metadata Strips (Capacity, Location, Availability, Usage - Slide 10) -->
                <div class="p-4 sm:p-6 space-y-5">
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div>
                            <div class="text-[11px] font-bold text-[#0084f8] uppercase tracking-wider">👥 Capacity</div>
                            <div class="text-xs sm:text-sm font-extrabold text-[#0f2e54] mt-1">{{ $facility->capacity ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="text-[11px] font-bold text-[#0084f8] uppercase tracking-wider">📍 Location</div>
                            <div class="text-xs sm:text-sm font-extrabold text-[#0f2e54] mt-1">{{ $facility->location_detail ?? $facility->floor }}</div>
                        </div>
                        <div>
                            <div class="text-[11px] font-bold text-[#0084f8] uppercase tracking-wider">🕒 Availability</div>
                            <div class="text-xs sm:text-sm font-extrabold text-[#0f2e54] mt-1">{{ $facility->availability_note ?? ($facility->operating_hours ?? '24 Jam') }}</div>
                        </div>
                        <div>
                            <div class="text-[11px] font-bold text-[#0084f8] uppercase tracking-wider">🗓️ Usage</div>
                            <div class="text-xs sm:text-sm font-extrabold text-[#0f2e54] mt-1">{{ $facility->usage_purpose ?? 'Operational & Employee Support' }}</div>
                        </div>
                    </div>

                    <!-- Tentang Fasilitas -->
                    <div>
                        <h3 class="text-sm sm:text-base font-extrabold text-[#0f2e54] mb-1.5">Tentang Fasilitas</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            {{ $facility->description }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Middle Split Row: Facilities & Equipment Tiles (Left) + Rules & Guidelines Checklist (Right) -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <!-- Facilities & Equipment Visual Tiles (Slide 10) -->
                <div class="md:col-span-7 bg-white rounded-3xl soft-shadow border border-slate-200/80 p-5 space-y-3.5">
                    <h3 class="text-sm sm:text-base font-extrabold text-[#0f2e54] flex items-center gap-2">
                        <span>🖥️</span>
                        <span>Facilities & Equipment</span>
                    </h3>
                    @if(!empty($facility->amenities))
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                            @foreach($facility->amenities as $amenity)
                                <div class="p-3 rounded-2xl bg-sky-50/70 border border-sky-100 text-center flex flex-col items-center justify-center gap-1.5">
                                    <span class="text-xl">{{ $equipmentIcon($amenity) }}</span>
                                    <span class="text-[11px] sm:text-xs font-bold text-[#0f2e54] leading-tight">{{ $amenity }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-slate-500">Standar fasilitas Akebono Karawang tersedia di lokasi.</p>
                    @endif
                </div>

                <!-- Rules & Guidelines Green Checkmarks (Slide 10) -->
                <div class="md:col-span-5 bg-white rounded-3xl soft-shadow border border-slate-200/80 p-5 space-y-3.5">
                    <h3 class="text-sm sm:text-base font-extrabold text-[#0f2e54] flex items-center gap-2">
                        <span>📋</span>
                        <span>Rules & Guidelines</span>
                    </h3>
                    <div class="space-y-2.5">
                        @forelse($guidelineItems as $ruleText)
                            <div class="flex items-start gap-2.5 text-xs font-semibold text-slate-700 leading-relaxed">
                                <span class="w-4 h-4 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-[10px] font-bold shrink-0 mt-0.5">✓</span>
                                <span>{{ $ruleText }}.</span>
                            </div>
                        @empty
                            <div class="flex items-start gap-2.5 text-xs font-semibold text-slate-700">
                                <span class="w-4 h-4 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-[10px] font-bold shrink-0">✓</span>
                                <span>Terapkan budaya 5S dan jaga kebersihan fasilitas.</span>
                            </div>
                        @endforelse
                        <div class="flex items-start gap-2.5 text-xs font-semibold text-slate-700">
                            <span class="w-4 h-4 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-[10px] font-bold shrink-0 mt-0.5">✓</span>
                            <span>Matikan seluruh perangkat listrik dan rapikan kembali setelah selesai digunakan.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Section: 5-Step "How to Use" Visual Flow (Concept Slide 10) -->
            <div id="how-to-use" class="bg-white rounded-3xl soft-shadow border border-slate-200/80 p-5 sm:p-6 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <h3 class="text-base sm:text-lg font-extrabold text-[#0f2e54] flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-sky-100 text-[#0084f8] flex items-center justify-center text-xs">▶</span>
                            <span>How to Use the {{ $facility->name }}</span>
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Panduan praktis 5 langkah agar penggunaan fasilitas berjalan lancar dan tertib.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                    @foreach($steps as $s)
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col justify-between space-y-3 relative">
                            <div class="space-y-2.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-full bg-[#0084f8] text-white text-xs font-extrabold flex items-center justify-center shrink-0">
                                        {{ $s['step'] }}
                                    </span>
                                    <div class="text-xs font-extrabold text-[#0f2e54] leading-tight">
                                        {{ $s['title'] }}
                                    </div>
                                </div>

                                <!-- Mini Screen / UI Illustration Card matching Slide 10 -->
                                <div class="rounded-xl p-2.5 bg-gradient-to-br from-[#0f2e54] to-[#0056b3] text-white text-center space-y-1 shadow-xs">
                                    <div class="text-[9px] font-bold text-sky-200 uppercase tracking-wider">{{ $s['badge'] ?? '' }}</div>
                                    <div class="text-xs font-extrabold leading-tight">{{ $s['preview_title'] ?? $s['title'] }}</div>
                                    <span class="inline-block px-2 py-0.5 rounded bg-white/15 text-[9px] font-bold">
                                        {{ $s['preview_status'] ?? 'Ready' }}
                                    </span>
                                </div>

                                <p class="text-[11px] text-slate-600 leading-relaxed">
                                    {{ $s['desc'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Bottom Action Buttons -->
                <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
                    <a href="{{ route('guide.facilities') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-full transition">
                        ← Kembali ke Semua Fasilitas
                    </a>
                    <a href="{{ route('guide.map', ['floor' => $facility->floor]) }}" class="px-5 py-2.5 bg-[#0084f8] hover:bg-[#0070d6] text-white font-bold text-xs rounded-full shadow-md transition">
                        Get Direction di Denah Kantor →
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- SSO Portal Booking Helper Modal (When no external SSO link configured) -->
    <div x-show="bookingModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="bookingModalOpen = false"></div>
        <div class="relative bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-extrabold text-[#0f2e54]">Booking via Company SSO Portal</h3>
                <button type="button" @click="bookingModalOpen = false" class="text-slate-400 hover:text-slate-700 font-bold cursor-pointer">✕</button>
            </div>
            <div class="p-4 rounded-2xl bg-sky-50 border border-sky-100 text-xs text-slate-700 space-y-2">
                <p><strong>Fasilitas:</strong> {{ $facility->name }} ({{ $facility->floor }})</p>
                <p><strong>Status & Ketersediaan:</strong> {{ $facility->availability_note ?? ($facility->operating_hours ?? 'Check on room tablet / SSO') }}</p>
                <p class="text-slate-500">Login menggunakan akun Akebono SSO / Microsoft Outlook Calendar di jaringan internal kantor, lalu pilih ruangan <strong>{{ $facility->name }}</strong>.</p>
            </div>
            <div class="flex items-center justify-end gap-2">
                <button type="button" @click="bookingModalOpen = false" class="px-4 py-2 rounded-xl bg-[#0084f8] text-white text-xs font-bold cursor-pointer">
                    Mengerti
                </button>
            </div>
        </div>
    </div>

</div>
@endsection
