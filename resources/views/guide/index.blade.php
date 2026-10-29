@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 pt-2 sm:pt-3 space-y-4 sm:space-y-5 relative" 
     x-data="{ 
        showMessageModal: false,
        autoPopup: {{ ($settings->message_auto_popup ?? true) ? 'true' : 'false' }},
        init() {
            if (this.autoPopup) {
                setTimeout(() => {
                    this.showMessageModal = true;
                }, 250);
            }
        },
        closeModal() {
            this.showMessageModal = false;
        }
     }">

    <!-- Admin Floating Quick Edit Buttons (Matching Design Mockup when Logged In) -->
    @auth
        <div class="fixed right-3 sm:right-6 top-28 z-40 flex flex-col gap-3">
            <a href="{{ route('admin.home.edit') }}" title="Edit Tampilan & Konten Awal" 
               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/95 backdrop-blur-md text-slate-700 hover:text-[#0084f8] text-xs font-bold rounded-full shadow-lg border border-slate-200/90 hover:scale-105 transition-all">
                <span class="text-sm">🪄</span>
                <span>Edit situs</span>
            </a>
            <a href="{{ route('admin.message.edit') }}" title="Edit Pesan Manajemen" 
               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/95 backdrop-blur-md text-slate-700 hover:text-[#0084f8] text-xs font-bold rounded-full shadow-lg border border-slate-200/90 hover:scale-105 transition-all">
                <span class="text-sm">📝</span>
                <span>Edit pesan</span>
            </a>
        </div>
    @endauth

    <!-- 1. Hero Section (Dynamic Height: pendek, sedang, besar) -->
    @php
        $heroHeightMode = $settings->hero_height ?? 'pendek';
        $messageHeightMode = $settings->message_height ?? 'pendek';

        // 1. Hero Height Classes (default 'pendek' is slim and space-saving)
        $heroHeightClass = match($heroHeightMode) {
            'besar' => 'h-52 sm:h-60 md:h-68',
            'sedang' => 'h-38 sm:h-44 md:h-48',
            default => 'h-28 sm:h-32 md:h-36', // pendek
        };
        $heroPaddingClass = match($heroHeightMode) {
            'besar' => 'p-5 sm:p-7',
            'sedang' => 'p-4 sm:p-5',
            default => 'p-3 sm:p-4',
        };
        $heroTitleClass = match($heroHeightMode) {
            'besar' => 'text-2xl sm:text-3xl md:text-4xl',
            'sedang' => 'text-xl sm:text-2xl md:text-3xl',
            default => 'text-lg sm:text-xl md:text-2xl',
        };

        // 2. Message from Management Height Classes
        $msgImgClass = match($messageHeightMode) {
            'besar' => 'h-48 sm:h-56 md:h-auto min-h-[220px]',
            'sedang' => 'h-36 sm:h-42 md:h-auto min-h-[160px]',
            default => 'h-28 sm:h-32 md:h-auto min-h-[120px]', // pendek
        };
        $msgPaddingClass = match($messageHeightMode) {
            'besar' => 'p-5 sm:p-7 md:p-8',
            'sedang' => 'p-4 sm:p-5 md:p-6',
            default => 'p-3.5 sm:p-4 md:p-4.5',
        };
        $msgTitleClass = match($messageHeightMode) {
            'besar' => 'text-xl sm:text-2xl md:text-3xl',
            'sedang' => 'text-lg sm:text-xl md:text-2xl',
            default => 'text-base sm:text-lg md:text-xl',
        };
        $msgMarginClass = match($messageHeightMode) {
            'besar' => 'mb-4',
            'sedang' => 'mb-3',
            default => 'mb-2 sm:mb-2.5',
        };
        $msgClampClass = match($messageHeightMode) {
            'besar' => '',
            'sedang' => 'line-clamp-3',
            default => 'line-clamp-2',
        };
    @endphp

    <div class="relative rounded-2xl sm:rounded-3xl overflow-hidden shadow-xs {{ $heroHeightClass }} flex items-end">
        <!-- Hero Background Image -->
        <img src="{{ office_image($settings->hero_image ?? null, 'images/hero-office.jpg') }}" alt="Akebono Karawang Workplace" class="absolute inset-0 w-full h-full object-cover">
        
        <!-- Subtle Gradient Overlay for Text Readability -->
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-900/35 to-transparent"></div>

        <!-- Hero Text -->
        <div class="relative z-10 {{ $heroPaddingClass }} text-white w-full">
            <h1 class="{{ $heroTitleClass }} font-extrabold tracking-tight leading-tight drop-shadow-xs">
                {{ $settings->hero_title_line1 ?? 'Welcome to' }}
                <span>{{ $settings->hero_title_line2 ?? 'Your New Workplace' }}</span>
            </h1>
            
            <p class="text-white/90 text-xs sm:text-sm font-medium mt-0.5 max-w-xl drop-shadow-xs line-clamp-1">
                {{ $settings->hero_tagline ?? 'Moving Together. Working Better. Growing Stronger.' }}
            </p>
        </div>
    </div>

    <!-- 2. A Message from Management (Mode Popup / Mode Kartu) -->
    @php
        $displayMode = $settings->message_display_mode ?? 'popup';
    @endphp

    @if($displayMode === 'popup')
        <!-- Mode Popup: Banner Ramping & Hemat Tempat (Klik untuk Buka Modal Popup) -->
        <div @click="showMessageModal = true"
             class="bg-gradient-to-r from-sky-50 via-white to-sky-50/70 hover:from-sky-100 hover:to-white border border-sky-200/90 rounded-2xl p-2.5 sm:p-3.5 flex items-center justify-between gap-3 shadow-xs hover:shadow-md cursor-pointer transition-all duration-200 group">
            
            <div class="flex items-center gap-3 sm:gap-3.5 min-w-0">
                <!-- Avatar Thumbnail -->
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl overflow-hidden bg-sky-500 shrink-0 border border-sky-200 shadow-xs relative">
                    <img src="{{ office_image($message->image_path ?? null, 'images/management-office.jpg') }}" alt="Management" class="w-full h-full object-cover">
                </div>

                <div class="min-w-0">
                    <div class="flex items-center gap-1.5">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-[#0084f8] bg-sky-100 px-2 py-0.5 rounded-full">
                            {{ $message->badge_label ?? 'Official Announcement' }}
                        </span>
                        @if(!empty($message->subtitle))
                            <span class="text-[10px] text-slate-500 hidden sm:inline">• {{ $message->subtitle }}</span>
                        @else
                            <span class="text-[10px] text-slate-400 hidden sm:inline">• Klik untuk baca popup</span>
                        @endif
                    </div>
                    <p class="text-xs sm:text-sm font-bold text-slate-800 truncate mt-0.5 group-hover:text-[#0084f8] transition">
                        {{ $message->summary ?? 'As we begin a new chapter at our Karawang office, let us build a safer, more collaborative workplace.' }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                @auth
                    <a href="{{ route('admin.message.edit') }}" @click.stop="" title="Edit Pesan" 
                       class="p-1.5 text-slate-400 hover:text-slate-700 hover:bg-white rounded-lg transition text-xs">
                        ✏️
                    </a>
                @endauth
                <div class="px-3 py-1.5 bg-[#0084f8] group-hover:bg-[#0070d6] text-white text-xs font-bold rounded-full shadow-xs flex items-center gap-1 transition-all">
                    <span>Buka Pesan</span>
                    <span class="text-xs leading-none">↗</span>
                </div>
            </div>
        </div>
    @else
        <!-- Mode Kartu Penuh (Klik Seluruh Kartu untuk Buka Popup) -->
        <div @click="showMessageModal = true"
             class="bg-white rounded-2xl sm:rounded-3xl soft-shadow border border-slate-200/80 overflow-hidden relative group cursor-pointer transition-all hover:shadow-md">
            
            @auth
                <a href="{{ route('admin.message.edit') }}" @click.stop="" title="Edit Pesan Ini" 
                   class="absolute top-2.5 right-2.5 sm:top-3 sm:right-3 z-20 px-2.5 py-1 bg-white/90 hover:bg-white text-[11px] font-bold text-slate-700 shadow-xs rounded-full border border-slate-200 flex items-center gap-1">
                    <span>✏️ Edit Pesan</span>
                </a>
            @endauth

            <div class="grid grid-cols-1 md:grid-cols-2 gap-0 items-stretch">
                
                <!-- Left Image (Workstation interior) -->
                <div class="relative {{ $msgImgClass }} overflow-hidden">
                    <img src="{{ office_image($message->image_path ?? null, 'images/management-office.jpg') }}" alt="Karawang Workplace Interior" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/25 via-transparent to-transparent md:hidden"></div>
                </div>

                <!-- Right Message Content -->
                <div class="{{ $msgPaddingClass }} flex flex-col justify-center">
                    <h2 class="{{ $msgTitleClass }} font-extrabold text-[#0f2e54] tracking-tight leading-snug">
                        {{ $message->title ?? 'A Message from Management' }}
                    </h2>
                    
                    <div class="w-8 sm:w-10 h-0.75 bg-[#0084f8] rounded-full mt-1 mb-2"></div>
                    
                    <p class="text-slate-600 text-xs sm:text-sm leading-relaxed {{ $msgMarginClass }} {{ $msgClampClass }} font-normal">
                        {{ $message->summary ?? 'As we begin a new chapter at our Karawang office, let us build a safer, more collaborative, and future-ready workplace — together.' }}
                    </p>

                    <div>
                        <button type="button"
                                class="inline-flex items-center gap-1.5 sm:gap-2 px-3.5 py-1.5 sm:px-4 sm:py-2 bg-[#0084f8] hover:bg-[#0070d6] text-white text-xs sm:text-sm font-semibold rounded-full shadow-xs hover:shadow-md transition-all transform active:scale-95 cursor-pointer">
                            <span>Read Message</span>
                            <span class="text-sm leading-none">→</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    @endif

    <!-- 3. Explore Your Workplace Section (Matching Mockup) -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl sm:text-[26px] font-extrabold text-[#0f2e54] tracking-tight">
                {{ $settings->explore_title ?? 'Explore Your Workplace' }}
            </h2>
            @auth
                <a href="{{ route('admin.home.edit') }}" class="text-xs font-bold text-[#0084f8] hover:underline">
                    ⚙️ Edit Kartu
                </a>
            @endauth
        </div>

        <!-- 4 Grid Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
            
            <!-- Card 1: Office & Plant -->
            <a href="{{ route('guide.office-and-plant') }}" class="group bg-white rounded-3xl soft-shadow border border-slate-200/80 overflow-hidden card-hover flex flex-col">
                <div class="h-44 sm:h-52 w-full overflow-hidden bg-slate-100">
                    <img src="{{ office_image($settings->card_office_image ?? null, 'images/plant-exterior.jpg') }}" alt="{{ $settings->card_office_title ?? 'Office & Plant' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-4 sm:p-5 flex items-center justify-between mt-auto">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-sky-50 text-[#0084f8] flex items-center justify-center shrink-0 group-hover:bg-[#0084f8] group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <span class="text-base sm:text-lg font-bold text-[#0f2e54] group-hover:text-[#0084f8] transition-colors">
                            {{ $settings->card_office_title ?? 'Office & Plant' }}
                        </span>
                    </div>
                    <span class="text-[#0084f8] text-xl font-bold group-hover:translate-x-1 transition-transform">
                        →
                    </span>
                </div>
            </a>

            <!-- Card 2: Facilities -->
            <a href="{{ route('guide.facilities') }}" class="group bg-white rounded-3xl soft-shadow border border-slate-200/80 overflow-hidden card-hover flex flex-col">
                <div class="h-44 sm:h-52 w-full overflow-hidden bg-slate-100">
                    <img src="{{ office_image($settings->card_facilities_image ?? null, 'images/facilities-office.jpg') }}" alt="{{ $settings->card_facilities_title ?? 'Facilities' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-4 sm:p-5 flex items-center justify-between mt-auto">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-sky-50 text-[#0084f8] flex items-center justify-center shrink-0 group-hover:bg-[#0084f8] group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <span class="text-base sm:text-lg font-bold text-[#0f2e54] group-hover:text-[#0084f8] transition-colors">
                            {{ $settings->card_facilities_title ?? 'Facilities' }}
                        </span>
                    </div>
                    <span class="text-[#0084f8] text-xl font-bold group-hover:translate-x-1 transition-transform">
                        →
                    </span>
                </div>
            </a>

            <!-- Card 3: Office Map -->
            <a href="{{ route('guide.map') }}" class="group bg-white rounded-3xl soft-shadow border border-slate-200/80 overflow-hidden card-hover flex flex-col">
                <div class="h-44 sm:h-52 w-full overflow-hidden bg-slate-100">
                    <img src="{{ office_image($settings->card_map_image ?? null, 'images/plant-exterior.jpg') }}" alt="{{ $settings->card_map_title ?? 'Office Map' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-4 sm:p-5 flex items-center justify-between mt-auto">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-sky-50 text-[#0084f8] flex items-center justify-center shrink-0 group-hover:bg-[#0084f8] group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="1.5"></circle>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l2.5 7.5L22 12l-7.5 2.5L12 22l-2.5-7.5L2 12l7.5-2.5L12 2z"></path>
                            </svg>
                        </div>
                        <span class="text-base sm:text-lg font-bold text-[#0f2e54] group-hover:text-[#0084f8] transition-colors">
                            {{ $settings->card_map_title ?? 'Office Map' }}
                        </span>
                    </div>
                    <span class="text-[#0084f8] text-xl font-bold group-hover:translate-x-1 transition-transform">
                        →
                    </span>
                </div>
            </a>

            <!-- Card 4: Dos & Don'ts -->
            <a href="{{ route('guide.dos-and-donts') }}" class="group bg-white rounded-3xl soft-shadow border border-slate-200/80 overflow-hidden card-hover flex flex-col">
                <div class="h-44 sm:h-52 w-full overflow-hidden bg-slate-100">
                    <img src="{{ office_image($settings->card_rules_image ?? null, 'images/meeting-room.jpg') }}" alt="{{ $settings->card_rules_title ?? "Dos & Don'ts" }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-4 sm:p-5 flex items-center justify-between mt-auto">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-sky-50 text-[#0084f8] flex items-center justify-center shrink-0 group-hover:bg-[#0084f8] group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <span class="text-base sm:text-lg font-bold text-[#0f2e54] group-hover:text-[#0084f8] transition-colors">
                            {{ $settings->card_rules_title ?? "Dos & Don'ts" }}
                        </span>
                    </div>
                    <span class="text-[#0084f8] text-xl font-bold group-hover:translate-x-1 transition-transform">
                        →
                    </span>
                </div>
            </a>

        </div>

        <!-- Footnote matching image -->
        <p class="text-xs text-slate-400 font-normal pt-1">
            {{ $settings->footnote_text ?? 'Visual kantor merupakan ilustrasi konseptual. Ganti dengan foto aktual setelah tersedia.' }}
        </p>
    </div>

    <!-- Management Message Modal (Executive Popup) -->
    <div x-show="showMessageModal" 
         x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto p-3 sm:p-6 flex items-center justify-center" 
         role="dialog" 
         aria-modal="true"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/65 backdrop-blur-xs transition-opacity" @click="closeModal()"></div>

        <!-- Modal Box -->
        <div class="relative bg-white rounded-3xl max-w-2xl w-full shadow-2xl border border-slate-200/90 overflow-hidden max-h-[90vh] flex flex-col z-10"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 scale-95">
            
            <!-- Top Header (Clean Executive Light Header - Fixed at Top) -->
            <div class="p-4 sm:p-5 pb-3 border-b border-slate-100 shrink-0 bg-white">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2 flex-wrap">
                        <img src="{{ asset('images/akebono.png') }}" alt="Akebono" style="max-height: 20px; width: auto;" class="h-5 w-auto">
                        <div class="h-3.5 w-px bg-slate-200"></div>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] sm:text-xs font-extrabold uppercase tracking-wider bg-sky-50 text-[#0084f8] border border-sky-100 shadow-2xs">
                            <span>📢</span>
                            <span>{{ $message->badge_label ?? 'Official Announcement' }}</span>
                        </span>
                        @if(!empty($message->subtitle))
                            <span class="text-xs text-slate-500 font-semibold">• {{ $message->subtitle }}</span>
                        @endif
                    </div>
                    
                    <!-- Close Button (Clean & Highly Visible) -->
                    <button type="button" 
                            @click="closeModal()" 
                            class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-all cursor-pointer shrink-0"
                            title="Tutup Popup">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="mt-2.5">
                    <h3 class="text-lg sm:text-xl font-black text-[#0f2e54] tracking-tight">
                        {{ $message->title ?? 'A Message from Management' }}
                    </h3>
                    <div class="w-8 h-1 bg-[#0084f8] rounded-full mt-1"></div>
                </div>
            </div>

            <!-- Scrollable Modal Body (Teks & Nilai Utama) -->
            <div class="p-4 sm:p-5 overflow-y-auto space-y-3.5 text-slate-700 flex-1">
                
                <!-- Quote Box -->
                <div class="bg-gradient-to-r from-sky-50 via-blue-50/50 to-white border-l-4 border-[#0084f8] p-3 sm:p-3.5 rounded-r-xl shadow-xs">
                    <div class="flex items-start gap-2">
                        <span class="text-xl text-[#0084f8] font-serif leading-none select-none">“</span>
                        <p class="text-xs sm:text-sm font-semibold text-[#0b3c6d] leading-relaxed italic">
                            {{ $message->summary ?? 'As we begin a new chapter at our Karawang office, let us build a safer, more collaborative, and future-ready workplace — together.' }}
                        </p>
                    </div>
                </div>

                <!-- Main Speech Content -->
                <div class="text-slate-600 text-xs sm:text-sm leading-relaxed space-y-2 font-normal whitespace-pre-line">
                    {!! nl2br(e($message->content ?? 'Selamat datang di panduan fasilitas kantor Akebono Karawang. Silakan jelajahi area kerja dan fasilitas pendukung untuk produktivitas Anda.')) !!}
                </div>

                <!-- 3 Pillars / Core Workplace Values -->
                <div class="pt-1">
                    <div class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-2">
                        Nilai Utama Lingkungan Kerja Kita:
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                        <div class="bg-slate-50 border border-slate-200/80 rounded-xl p-2.5">
                            <div class="text-sm mb-0.5">🛡️</div>
                            <div class="text-xs font-bold text-slate-900">Safety First</div>
                            <div class="text-[10px] text-slate-500 leading-snug mt-0.5">Prioritas keselamatan tanpa kompromi.</div>
                        </div>
                        <div class="bg-slate-50 border border-slate-200/80 rounded-xl p-2.5">
                            <div class="text-sm mb-0.5">🤝</div>
                            <div class="text-xs font-bold text-slate-900">Kolaboratif</div>
                            <div class="text-[10px] text-slate-500 leading-snug mt-0.5">Ruang terbuka sinergi tim.</div>
                        </div>
                        <div class="bg-slate-50 border border-slate-200/80 rounded-xl p-2.5">
                            <div class="text-sm mb-0.5">🌿</div>
                            <div class="text-xs font-bold text-slate-900">5S & Green</div>
                            <div class="text-[10px] text-slate-500 leading-snug mt-0.5">Disiplin 5S & ramah lingkungan.</div>
                        </div>
                    </div>
                </div>

                <!-- Sign-off Section -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-3">
                    <div>
                        <div class="text-xs font-extrabold text-slate-900">{{ $message->sender_name ?? 'Management Board' }}</div>
                        <div class="text-[10px] text-slate-500">{{ $message->sender_role ?? 'PT Akebono Brake Astra Indonesia' }}</div>
                    </div>
                    <div class="text-right">
                        <span class="inline-block text-[10px] font-semibold text-[#0084f8] bg-sky-50 border border-sky-100 px-2.5 py-0.5 rounded-full">
                            {{ $message->subtitle ?? 'Akebono Karawang 2026' }}
                        </span>
                    </div>
                </div>

            </div>

            <!-- Bottom Photo Section (Docked Langsung di Bawah Popup - Tidak Perlu Scroll!) -->
            <div class="shrink-0 border-t border-slate-200/80 bg-slate-900 relative overflow-hidden">
                <div class="relative h-36 sm:h-44 w-full">
                    <img src="{{ office_image($message->image_path ?? null, 'images/management-office.jpg') }}" 
                         alt="Management & Team" 
                         class="w-full h-full object-cover object-[center_20%]">
                    <!-- Subtle caption strip at bottom of photo -->
                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-950/85 via-slate-900/40 to-transparent px-4 py-2 flex items-center justify-between text-white">
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            <span class="text-xs font-bold text-white drop-shadow-xs">Tim Manajemen & Karyawan</span>
                        </div>
                        <span class="text-[11px] text-white/90 font-medium drop-shadow-xs">{{ $message->subtitle ?? 'Akebono Karawang 2026' }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
