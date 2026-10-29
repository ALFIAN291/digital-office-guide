@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 pt-2 sm:pt-3 space-y-4 sm:space-y-5 relative" 
     x-data="{ showMessageModal: false }">

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

    <!-- 2. A Message from Management Card (Dynamic Height: pendek, sedang, besar) -->
    <div class="bg-white rounded-2xl sm:rounded-3xl soft-shadow border border-slate-200/80 overflow-hidden relative group">
        
        @auth
            <a href="{{ route('admin.message.edit') }}" title="Edit Pesan Ini" 
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
                    <button @click="showMessageModal = true" 
                            class="inline-flex items-center gap-1.5 sm:gap-2 px-3.5 py-1.5 sm:px-4 sm:py-2 bg-[#0084f8] hover:bg-[#0070d6] text-white text-xs sm:text-sm font-semibold rounded-full shadow-xs hover:shadow-md transition-all transform active:scale-95 cursor-pointer">
                        <span>Read Message</span>
                        <span class="text-sm leading-none">→</span>
                    </button>
                </div>
            </div>

        </div>
    </div>

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

    <!-- Management Message Modal -->
    <div x-show="showMessageModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto p-4 sm:p-6 flex items-center justify-center" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="showMessageModal = false"></div>
        <div class="relative bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 max-h-[85vh] overflow-y-auto">
            
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/akebono.png') }}" alt="Akebono" style="max-height: 24px; width: auto;" class="h-6 w-auto">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sambutan Manajemen</span>
                </div>
                <button @click="showMessageModal = false" class="p-1.5 text-slate-400 hover:text-slate-600 rounded-full hover:bg-slate-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="mt-6 space-y-4">
                <h3 class="text-2xl font-extrabold text-[#0f2e54]">{{ $message->title ?? 'A Message from Management' }}</h3>
                <div class="w-12 h-1 bg-[#0084f8] rounded-full"></div>

                <div class="bg-sky-50 border-l-4 border-[#0084f8] p-4 rounded-r-xl">
                    <p class="text-xs sm:text-sm font-semibold text-[#0b3c6d] italic">
                        "{{ $message->summary ?? 'As we begin a new chapter at our Karawang office, let us build a safer, more collaborative, and future-ready workplace — together.' }}"
                    </p>
                </div>

                <div class="text-slate-700 text-sm leading-relaxed whitespace-pre-line space-y-3 font-normal">
                    {!! nl2br(e($message->content ?? 'Selamat datang di panduan fasilitas kantor Akebono Karawang. Silakan jelajahi area kerja dan fasilitas pendukung untuk produktivitas Anda.')) !!}
                </div>

                <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <div class="text-sm font-bold text-slate-900">{{ $message->sender_name ?? 'Management Board' }}</div>
                        <div class="text-xs text-slate-500">{{ $message->sender_role ?? 'PT Akebono Brake Astra Indonesia' }}</div>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-semibold text-[#0084f8] bg-sky-50 px-3 py-1 rounded-full">Akebono Karawang 2026</span>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100">
                <button @click="showMessageModal = false" class="w-full py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm rounded-xl transition">
                    Tutup
                </button>
            </div>

        </div>
    </div>

</div>
@endsection
