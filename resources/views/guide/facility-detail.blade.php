@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 pt-5 space-y-6">

    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
        <a href="{{ route('guide.index') }}" class="hover:text-[#0084f8]">Beranda</a>
        <span>/</span>
        <a href="{{ route('guide.facilities') }}" class="hover:text-[#0084f8]">Fasilitas</a>
        <span>/</span>
        <span class="text-[#0f2e54] truncate max-w-xs">{{ $facility->name }}</span>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl soft-shadow border border-slate-200/80 overflow-hidden">
        <!-- Photo Header -->
        <div class="relative h-64 sm:h-80 w-full overflow-hidden bg-slate-100">
            <img src="{{ office_image($facility->image_path, 'images/facilities-office.jpg') }}" alt="{{ $facility->name }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent"></div>
            
            <div class="absolute bottom-6 left-6 right-6 text-white">
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-2.5 py-1 rounded-full bg-[#0084f8] text-xs font-bold uppercase tracking-wider">
                        {{ $facility->floor }}
                    </span>
                    <span class="px-2.5 py-1 rounded-full bg-white/25 backdrop-blur-md text-xs font-bold uppercase tracking-wider">
                        {{ $facility->category }}
                    </span>
                </div>
                <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight">
                    {{ $facility->name }}
                </h1>
            </div>
        </div>

        <!-- Body Content -->
        <div class="p-6 sm:p-10 space-y-6">
            <!-- Key Details Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Lantai</div>
                    <div class="text-sm font-extrabold text-[#0f2e54] mt-0.5">{{ $facility->floor }}</div>
                </div>
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kapasitas</div>
                    <div class="text-sm font-extrabold text-[#0f2e54] mt-0.5">{{ $facility->capacity ?? '-' }}</div>
                </div>
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Jam Operasional</div>
                    <div class="text-sm font-extrabold text-[#0f2e54] mt-0.5">{{ $facility->operating_hours ?? '24 Jam' }}</div>
                </div>
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Lokasi</div>
                    <div class="text-sm font-extrabold text-[#0f2e54] mt-0.5 truncate">{{ $facility->location_detail ?? '-' }}</div>
                </div>
            </div>

            <!-- Description -->
            <div>
                <h3 class="text-base font-extrabold text-[#0f2e54] mb-2">Tentang Fasilitas</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    {{ $facility->description }}
                </p>
            </div>

            <!-- Guidelines / Rules -->
            @if($facility->guidelines)
                <div class="p-5 bg-sky-50 rounded-2xl border border-sky-100">
                    <div class="flex items-center gap-2 text-[#0084f8] font-bold text-sm mb-1.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Aturan & Panduan Penggunaan</span>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium">
                        {{ $facility->guidelines }}
                    </p>
                </div>
            @endif

            <!-- Amenities -->
            @if(!empty($facility->amenities))
                <div>
                    <h3 class="text-base font-extrabold text-[#0f2e54] mb-3">Fasilitas & Perlengkapan yang Tersedia</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        @foreach($facility->amenities as $amenity)
                            <div class="flex items-center gap-2.5 p-3 rounded-xl bg-slate-50 border border-slate-100 text-xs sm:text-sm font-semibold text-slate-700">
                                <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs shrink-0 font-bold">✓</span>
                                <span>{{ $amenity }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Navigation back & Map button -->
            <div class="pt-6 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
                <a href="{{ route('guide.facilities') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-full transition">
                    ← Kembali ke Semua Fasilitas
                </a>
                <a href="{{ route('guide.map', ['floor' => $facility->floor]) }}" class="px-5 py-2.5 bg-[#0084f8] hover:bg-[#0070d6] text-white font-bold text-xs rounded-full shadow-md transition">
                    Lihat di Denah Kantor →
                </a>
            </div>

        </div>
    </div>

</div>
@endsection

