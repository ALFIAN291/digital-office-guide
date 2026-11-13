@extends('layouts.app')

@section('content')
@php
    $gallery = $facility->gallery_list;
    $steps = $facility->usage_steps;
    $guidelineItems = collect(preg_split('/[\r\n.]+/', (string) $facility->guidelines))
        ->map(fn ($s) => trim($s))
        ->filter()
        ->values();

    $floorLabel = match ($facility->floor) {
        'Lantai 2' => '2nd Floor',
        'Lantai 1' => '1st Floor',
        default => $facility->floor,
    };

    $categoryLabel = match ($facility->category) {
        'meeting' => 'Meeting Room',
        'workspace' => 'Office Area',
        'dining' => 'Canteen & Dining',
        'wellness' => 'Wellness & Prayer',
        'safety' => 'Safety & Medical',
        default => ucfirst((string) $facility->category),
    };

    $defaultMeetingEquipments = [
        ['title' => 'Display', 'sub' => '(4K)', 'type' => 'display'],
        ['title' => 'Camera', 'sub' => '(VC)', 'type' => 'camera'],
        ['title' => 'Microphone', 'sub' => '(Beamforming)', 'type' => 'mic'],
        ['title' => 'Speaker', 'sub' => '(Audio)', 'type' => 'speaker'],
        ['title' => 'Video', 'sub' => 'Conference', 'type' => 'vc'],
    ];

    $sidebarCategories = [
        ['label' => 'Meeting Room', 'icon' => '👥', 'cat' => 'meeting'],
        ['label' => 'Executive Meeting', 'icon' => '🏛️', 'cat' => 'meeting'],
        ['label' => 'Auditorium & Hall', 'icon' => '📽️', 'cat' => 'service'],
        ['label' => 'Visitor & Reception', 'icon' => '🪪', 'cat' => 'service'],
        ['label' => 'Canteen & Dining', 'icon' => '🍽️', 'cat' => 'dining'],
        ['label' => 'Office & Common', 'icon' => '💻', 'cat' => 'workspace'],
        ['label' => 'Building & Safety', 'icon' => '🛡️', 'cat' => 'safety'],
    ];
@endphp

<div class="max-w-5xl mx-auto px-3.5 sm:px-6 pt-3 sm:pt-4 pb-8 space-y-5"
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

    <!-- Top Breadcrumb (< Facilities > Meeting Room 5) Matching Screenshot 2 -->
    <div class="flex items-center justify-between gap-2">
        <div class="flex items-center gap-2 text-xs sm:text-sm font-semibold text-slate-500">
            <a href="{{ route('guide.facilities') }}" class="inline-flex items-center gap-1.5 text-[#0066dc] hover:underline font-bold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                <span class="text-slate-600">Facilities</span>
            </a>
            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="font-extrabold text-[#0f2e54] truncate">{{ $facility->name }}</span>
        </div>

        <a href="{{ route('guide.map', ['floor' => $facility->floor]) }}" class="hidden sm:inline-flex items-center gap-1 text-xs font-extrabold text-[#0066dc] hover:underline">
            <span>📍 View on Floor Plan</span>
            <span>→</span>
        </a>
    </div>

    <!-- Main Facility Card Matching Screenshot 2 -->
    <div class="bg-white/95 rounded-3xl p-4 sm:p-6 soft-shadow border border-slate-200/90 space-y-5 max-w-2xl mx-auto lg:max-w-none">

        <!-- 1. Hero Photo Carousel at the Very Top of the Card -->
        <div class="relative h-52 sm:h-80 w-full rounded-2xl overflow-hidden bg-slate-100 shadow-sm">
            <template x-for="(img, idx) in images" :key="idx">
                <img x-show="currentIndex === idx"
                     :src="img"
                     alt="{{ $facility->name }}"
                     class="w-full h-full object-cover transition-opacity duration-300">
            </template>

            <!-- Left '<' Arrow Button -->
            <button type="button" @click="prevImage()" aria-label="Previous Photo"
                    class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-white/95 hover:bg-white text-[#0066dc] shadow-lg flex items-center justify-center transition cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.6" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            <!-- Right '>' Arrow Button -->
            <button type="button" @click="nextImage()" aria-label="Next Photo"
                    class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-white/95 hover:bg-white text-[#0066dc] shadow-lg flex items-center justify-center transition cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.6" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <!-- Bottom-Right Counter Badge (1/4) -->
            <div class="absolute bottom-3 right-3 px-3 py-1 rounded-full bg-slate-900/80 text-white text-xs font-extrabold tracking-wide backdrop-blur-xs">
                <span x-text="(currentIndex + 1) + ' / ' + images.length">1 / 4</span>
            </div>
        </div>

        <!-- 2. Facility Title Header Below Photo (Icon Box + Title + Floor • Category) -->
        <div class="flex items-center gap-3.5 pt-1">
            <div class="w-13 h-13 sm:w-14 sm:h-14 rounded-2xl bg-[#eef6ff] border border-sky-100 text-[#0066dc] flex items-center justify-center shrink-0 shadow-2xs">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-[#0f2e54] tracking-tight leading-tight">{{ $facility->name }}</h1>
                <div class="text-xs sm:text-sm font-semibold text-slate-500 mt-0.5 flex items-center gap-1.5">
                    <span>{{ $floorLabel }}</span>
                    <span class="text-[#0066dc]">•</span>
                    <span>{{ $categoryLabel }}</span>
                </div>
            </div>
        </div>

        <!-- 3. Two-Column Divided Metadata Box (Capacity | Location) Matching Screenshot 2 -->
        <div class="grid grid-cols-2 divide-x divide-slate-200/90 bg-slate-50/70 border border-slate-200/80 rounded-2xl p-3.5 sm:p-4">
            <!-- Left: Capacity -->
            <div class="flex items-center gap-3 pr-2">
                <div class="w-9 h-9 rounded-xl bg-sky-50 text-[#0066dc] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <div class="text-xs sm:text-sm font-extrabold text-[#0f2e54]">Capacity</div>
                    <div class="text-xs sm:text-sm font-semibold text-slate-600 truncate">{{ $facility->capacity ?? '8 – 10 people' }}</div>
                </div>
            </div>

            <!-- Right: Location -->
            <div class="flex items-center gap-3 pl-3 sm:pl-5">
                <div class="w-9 h-9 rounded-xl bg-sky-50 text-[#0066dc] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <div class="text-xs sm:text-sm font-extrabold text-[#0f2e54]">Location</div>
                    <div class="text-xs sm:text-sm font-semibold text-slate-600 truncate">{{ $facility->location_detail ?? '2nd Floor (East Wing)' }}</div>
                </div>
            </div>
        </div>

        <!-- 4. Facilities & Equipment (5 Vertical Icon Cards in a 5-Column Grid Matching Screenshot 2) -->
        <div class="space-y-3">
            <h2 class="text-base sm:text-lg font-extrabold text-[#0f2e54]">Facilities & Equipment</h2>

            <div class="grid grid-cols-5 gap-1.5 sm:gap-3">
                @foreach($defaultMeetingEquipments as $eq)
                    <div class="rounded-2xl bg-[#f0f7ff] border border-sky-100/90 py-3 px-1.5 sm:p-3.5 text-center flex flex-col items-center justify-start gap-1.5 shadow-2xs">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-white text-[#0066dc] flex items-center justify-center shadow-2xs border border-sky-100">
                            @if($eq['type'] === 'display')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="2" y="3" width="20" height="14" rx="2"></rect>
                                    <path stroke-linecap="round" d="M8 21h8M12 17v4"/>
                                </svg>
                            @elseif($eq['type'] === 'camera')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="10" r="6"></circle>
                                    <circle cx="12" cy="10" r="2.2"></circle>
                                    <path stroke-linecap="round" d="M6 20h12M9 16l-2 4M15 16l2 4"/>
                                </svg>
                            @elseif($eq['type'] === 'mic')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="9" y="2" width="6" height="11" rx="3"></rect>
                                    <path stroke-linecap="round" d="M19 10v1a7 7 0 01-14 0v-1M12 18v4M8 22h8"/>
                                </svg>
                            @elseif($eq['type'] === 'speaker')
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="2" y="3" width="20" height="14" rx="2"></rect>
                                    <path stroke-linecap="round" d="M8 21h8M12 17v4"/>
                                </svg>
                            @endif
                        </div>
                        <div class="leading-tight">
                            <div class="text-[10px] sm:text-xs font-extrabold text-[#0f2e54]">{{ $eq['title'] }}</div>
                            <div class="text-[9px] sm:text-[11px] font-bold text-slate-600">{{ $eq['sub'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 5. Two Full-Width Pill Action Buttons Matching Screenshot 2 -->
        <div class="space-y-2.5 pt-1">
            @if($facility->booking_url)
                <a href="{{ $facility->booking_url }}" target="_blank" rel="noopener noreferrer"
                   class="w-full py-3 sm:py-3.5 px-5 rounded-full bg-gradient-to-r from-[#0055c4] to-[#0078f0] hover:from-[#0046a3] hover:to-[#0066d6] text-white shadow-md flex items-center justify-between transition">
                    <span class="w-5"></span>
                    <span class="flex items-center gap-2.5 text-center">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span class="leading-tight text-left">
                            <span class="block text-xs sm:text-sm font-extrabold">Book This Room</span>
                            <span class="block text-[10px] sm:text-xs font-semibold text-sky-100">(via SSO Portal)</span>
                        </span>
                    </span>
                    <svg class="w-4 h-4 shrink-0 text-white/90" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
            @else
                <button type="button" @click="bookingModalOpen = true"
                        class="w-full py-3 sm:py-3.5 px-5 rounded-full bg-gradient-to-r from-[#0055c4] to-[#0078f0] hover:from-[#0046a3] hover:to-[#0066d6] text-white shadow-md flex items-center justify-between transition cursor-pointer">
                    <span class="w-5"></span>
                    <span class="flex items-center gap-2.5 text-center">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span class="leading-tight text-left">
                            <span class="block text-xs sm:text-sm font-extrabold">Book This Room</span>
                            <span class="block text-[10px] sm:text-xs font-semibold text-sky-100">(via SSO Portal) • Book via SSO Portal</span>
                        </span>
                    </span>
                    <svg class="w-4 h-4 shrink-0 text-white/90" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </button>
            @endif

            <!-- Outlined Pill Button: View How to Use -->
            <a href="#how-to-use"
               class="w-full py-3 px-5 rounded-full bg-white hover:bg-sky-50 text-[#0066dc] border-2 border-[#0066dc]/35 font-extrabold text-xs sm:text-sm flex items-center justify-center gap-2 transition">
                <svg class="w-5 h-5 text-[#0066dc]" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9"></circle>
                    <polygon points="10 8 16 12 10 16 10 8" fill="currentColor"></polygon>
                </svg>
                <span>View How to Use</span>
            </a>
        </div>
    </div>

    <!-- How to Use 5-Step Guide & Rules Section (Below Main Card) -->
    <div id="how-to-use" class="bg-white/95 rounded-3xl soft-shadow border border-slate-200/80 p-5 sm:p-6 space-y-5 max-w-2xl mx-auto lg:max-w-none">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h3 class="text-base sm:text-lg font-extrabold text-[#0f2e54] flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-sky-100 text-[#0066dc] flex items-center justify-center text-xs">▶</span>
                    <span>How to Use the {{ $facility->name }}</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Step-by-step guide to booking, connecting, and using this facility properly.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            @foreach($steps as $s)
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col justify-between space-y-3">
                    <div class="space-y-2.5">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-[#0066dc] text-white text-xs font-extrabold flex items-center justify-center shrink-0">
                                {{ $s['step'] }}
                            </span>
                            <div class="text-xs font-extrabold text-[#0f2e54] leading-tight">
                                {{ $s['title'] }}
                            </div>
                        </div>

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

        <!-- Rules & Guidelines Checklist -->
        <div class="pt-4 border-t border-slate-100 space-y-2.5">
            <h4 class="text-sm font-extrabold text-[#0f2e54]">Rules & Guidelines</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                @forelse($guidelineItems as $ruleText)
                    <div class="flex items-start gap-2.5 text-xs font-semibold text-slate-700">
                        <span class="w-4 h-4 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-[10px] font-bold shrink-0 mt-0.5">✓</span>
                        <span>{{ $ruleText }}.</span>
                    </div>
                @empty
                    <div class="flex items-start gap-2.5 text-xs font-semibold text-slate-700">
                        <span class="w-4 h-4 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-[10px] font-bold shrink-0">✓</span>
                        <span>Terapkan budaya 5S dan jaga kebersihan fasilitas.</span>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- SSO Portal Booking Helper Modal -->
    <div x-show="bookingModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="bookingModalOpen = false"></div>
        <div class="relative bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-extrabold text-[#0f2e54]">Book via Company SSO Portal</h3>
                <button type="button" @click="bookingModalOpen = false" class="text-slate-400 hover:text-slate-700 font-bold cursor-pointer">✕</button>
            </div>
            <div class="p-4 rounded-2xl bg-sky-50 border border-sky-100 text-xs text-slate-700 space-y-2">
                <p><strong>Facility:</strong> {{ $facility->name }} ({{ $floorLabel }})</p>
                <p><strong>Location:</strong> {{ $facility->location_detail ?? '2nd Floor (East Wing)' }}</p>
                <p class="text-slate-600">Sign in with your Akebono SSO / Microsoft Outlook Calendar account to reserve <strong>{{ $facility->name }}</strong>.</p>
            </div>
            <div class="flex items-center justify-end gap-2">
                <button type="button" @click="bookingModalOpen = false" class="px-4 py-2 rounded-xl bg-[#0066dc] text-white text-xs font-bold cursor-pointer">
                    Got It
                </button>
            </div>
        </div>
    </div>

</div>
@endsection
