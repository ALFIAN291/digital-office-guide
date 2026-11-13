@extends('layouts.app')

@section('content')
<div class="max-w-5xl lg:max-w-none mx-auto px-4 sm:px-6 pt-5 space-y-6">

    <!-- Header & Breadcrumb -->
    <div>
        <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-2">
            <a href="{{ route('guide.index') }}" class="hover:text-[#0084f8]">Beranda</a>
            <span>/</span>
            <span class="text-[#0f2e54]">Office & Plant Karawang</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0f2e54] tracking-tight">Kawasan Kantor & Pabrik Karawang</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Integrasi fasilitas manufaktur komponen rem terdepan dan lingkungan kantor modern berstandar global</p>
    </div>

    <!-- Campus Banner Card -->
    <div class="bg-white rounded-3xl soft-shadow border border-slate-200/80 overflow-hidden">
        <div class="relative h-64 sm:h-80 w-full overflow-hidden">
            <img src="{{ asset('images/plant-exterior.jpg') }}" alt="Akebono Plant Exterior" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
            <div class="absolute bottom-6 left-6 right-6 text-white">
                <span class="px-3 py-1 rounded-full bg-[#0084f8] text-xs font-bold text-white uppercase tracking-wider mb-2 inline-block">
                    Kawasan Industri Karawang
                </span>
                <h2 class="text-xl sm:text-3xl font-extrabold">PT Akebono Brake Astra Indonesia</h2>
                <p class="text-xs sm:text-sm text-sky-100 mt-1">Pusat Keunggulan Teknologi Sistem Pengereman Otomotif Indonesia</p>
            </div>
        </div>

        <div class="p-6 sm:p-8 space-y-6">
            <p class="text-sm sm:text-base text-slate-600 leading-relaxed font-normal">
                Komplek Karawang dirancang khusus untuk memadukan proses manufaktur presisi tinggi dengan kenyamanan ruang kerja modern. Kawasan ini terdiri dari Gedung Utama (Main Office) tiga lantai, fasilitas pabrik Plant 1 (Machining & Foundry), Plant 2 (Automated Assembly Line), serta Gudang Logistik Terintegrasi.
            </p>

            <!-- 4 Zones Breakdown -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100">
                    <div class="flex items-center gap-2.5 mb-2">
                        <span class="w-8 h-8 rounded-xl bg-sky-100 text-[#0084f8] flex items-center justify-center font-bold text-sm">🏢</span>
                        <h4 class="text-base font-extrabold text-slate-800">Gedung Utama (Main Office)</h4>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Lobi registrasi tamu, ruang kerja open-plan engineering, HR, Finance, Executive Boardroom, serta fasilitas Kantin dan Musholla utama.
                    </p>
                </div>

                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100">
                    <div class="flex items-center gap-2.5 mb-2">
                        <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-sm">⚙️</span>
                        <h4 class="text-base font-extrabold text-slate-800">Plant 1: Foundry & Machining</h4>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Pengecoran presisi dan permesinan disc brake caliper, rotor, dan drum brake dengan robotika otomatis berkecepatan tinggi.
                    </p>
                </div>

                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100">
                    <div class="flex items-center gap-2.5 mb-2">
                        <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">🔧</span>
                        <h4 class="text-base font-extrabold text-slate-800">Plant 2: Automated Assembly</h4>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Lini perakitan bersih (clean assembly), pengujian kualitas inline 100% (leak test & durability), dan pemasangan brake pad.
                    </p>
                </div>

                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100">
                    <div class="flex items-center gap-2.5 mb-2">
                        <span class="w-8 h-8 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-sm">🚚</span>
                        <h4 class="text-base font-extrabold text-slate-800">Logistics & Dispatch Center</h4>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Penerimaan raw material inbound, sistem pergudangan otomatis, dan dermaga pengiriman (loading dock) ke pabrik APM kendaraan.
                    </p>
                </div>

            </div>

            <!-- Mandatory Plant Entry Checklist -->
            <div class="p-6 rounded-2xl bg-amber-50/70 border border-amber-200">
                <h3 class="text-base font-extrabold text-amber-900 flex items-center gap-2">
                    <span>⚠️</span>
                    <span>Protokol Wajib Masuk Area Pabrik (Plant Entry)</span>
                </h3>
                <p class="text-xs text-amber-800 mt-1 mb-4">Setiap karyawan dan tamu yang memasuki area workshop wajib mematuhi standar berikut:</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs font-semibold text-amber-900">
                    <div class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-amber-200 flex items-center justify-center font-bold">1</span>
                        <span>Wajib mengenakan Safety Shoes baja (Steel Toe)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-amber-200 flex items-center justify-center font-bold">2</span>
                        <span>Mengenakan Safety Glasses & Helm Pelindung</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-amber-200 flex items-center justify-center font-bold">3</span>
                        <span>Berjalan HANYA di jalur hijau (Green Walkway)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-amber-200 flex items-center justify-center font-bold">4</span>
                        <span>Didampingi PIC / Supervisor bagi pengunjung</span>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="pt-2 flex flex-wrap items-center justify-between gap-3">
                <a href="{{ route('guide.map', ['floor' => 'Ground Floor']) }}" class="px-5 py-2.5 bg-[#0084f8] hover:bg-[#0070d6] text-white font-bold text-xs rounded-full shadow-md transition">
                    Buka Denah Kawasan Pabrik →
                </a>
                <a href="{{ route('guide.dos-and-donts', ['category' => 'Safety']) }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-full transition">
                    Lihat Aturan Lengkap K3 →
                </a>
            </div>
        </div>
    </div>

    <!-- Concept Slide 6: Building Layout & Movement (6 Key Movement Rules) -->
    <div class="bg-white rounded-3xl soft-shadow border border-slate-200/80 p-5 sm:p-8 space-y-5">
        <div>
            <div class="text-[11px] font-bold uppercase tracking-wider text-[#0084f8]">05 / Facility Socialization</div>
            <h2 class="text-xl sm:text-2xl font-extrabold text-[#0f2e54] mt-0.5">Building Layout & Movement</h2>
            <p class="text-xs sm:text-sm font-semibold text-slate-500 mt-0.5">Know where to enter, where to go and where not to go.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5">
            @php
                $movementPillars = [
                    ['num' => 1, 'title' => 'Entrance / Exit', 'desc' => 'Main employee and visitor flow.', 'route' => route('guide.attendance')],
                    ['num' => 2, 'title' => 'Office Areas', 'desc' => 'Department locations and common spaces.', 'route' => route('guide.map', ['floor' => 'Lantai 2'])],
                    ['num' => 3, 'title' => 'Meeting Rooms', 'desc' => 'Room numbers, booking and equipment.', 'route' => route('guide.facilities', ['category' => 'meeting'])],
                    ['num' => 4, 'title' => 'Canteen', 'desc' => 'Access, ordering and usage rules.', 'route' => route('guide.canteen')],
                    ['num' => 5, 'title' => 'Emergency Route', 'desc' => 'Evacuation path and assembly point.', 'route' => route('guide.emergency')],
                    ['num' => 6, 'title' => 'Visitor Area', 'desc' => 'Registration and visitor access flow.', 'route' => route('guide.visitor')],
                ];
            @endphp
            @foreach($movementPillars as $mp)
                <a href="{{ $mp['route'] }}"
                   class="group p-4 rounded-2xl bg-slate-50 hover:bg-sky-50/60 border border-slate-200/80 hover:border-sky-300 transition flex items-start gap-3">
                    <span class="w-8 h-8 rounded-full bg-[#0084f8] text-white font-extrabold text-xs flex items-center justify-center shrink-0 shadow-2xs group-hover:scale-105 transition">
                        {{ $mp['num'] }}
                    </span>
                    <div class="min-w-0">
                        <div class="text-sm font-extrabold text-[#0f2e54] group-hover:text-[#0084f8] transition">{{ $mp['title'] }} →</div>
                        <div class="text-xs text-slate-500 mt-0.5 leading-snug">{{ $mp['desc'] }}</div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Concept Slide 8: How to Use the New Facilities (6 Smart Systems) -->
    <div class="bg-white rounded-3xl soft-shadow border border-slate-200/80 p-5 sm:p-8 space-y-5">
        <div>
            <div class="text-[11px] font-bold uppercase tracking-wider text-[#0084f8]">05 / Facility Socialization</div>
            <h2 class="text-xl sm:text-2xl font-extrabold text-[#0f2e54] mt-0.5">How to Use the New Facilities & Systems</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Ringkasan pengoperasian teknologi gedung baru Akebono Karawang</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
            @php
                $smartSystems = [
                    ['num' => 1, 'title' => 'Meeting Room Multimedia', 'desc' => 'Display • camera • microphone • room control', 'link' => route('guide.facility.detail', 'ruang-rapat-sakura')],
                    ['num' => 2, 'title' => 'Building Management System', 'desc' => 'Building systems, smart HVAC, lighting & access doors', 'link' => route('guide.map', ['floor' => 'Lantai 2'])],
                    ['num' => 3, 'title' => 'Visitor Management', 'desc' => 'Registration • host notification • visitor access', 'link' => route('guide.visitor')],
                    ['num' => 4, 'title' => 'Virtual Reception', 'desc' => 'Visitor assistance and digital self-check-in flow', 'link' => route('guide.visitor') . '#virtual-reception'],
                    ['num' => 5, 'title' => 'Auditorium Multimedia', 'desc' => 'Presentation • audio • wireless microphone', 'link' => route('guide.facility.detail', 'lobi-utama-dan-resepsionis')],
                    ['num' => 6, 'title' => 'Canteen System', 'desc' => 'Ordering • cashless Tap ID payment • 5S tray rules', 'link' => route('guide.canteen')],
                ];
            @endphp
            @foreach($smartSystems as $sys)
                <a href="{{ $sys['link'] }}"
                   class="group p-4 rounded-2xl bg-white hover:bg-sky-50/40 border border-slate-200 hover:border-sky-300 transition flex items-center justify-between gap-3 shadow-2xs">
                    <div class="flex items-center gap-3 min-w-0">
                        <span class="w-9 h-9 rounded-full bg-[#0084f8] text-white font-extrabold text-sm flex items-center justify-center shrink-0">
                            {{ $sys['num'] }}
                        </span>
                        <div class="min-w-0">
                            <div class="text-sm font-extrabold text-[#0f2e54] group-hover:text-[#0084f8] truncate">{{ $sys['title'] }}</div>
                            <div class="text-xs text-slate-500 truncate mt-0.5">{{ $sys['desc'] }}</div>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-[#0084f8] shrink-0">Guide →</span>
                </a>
            @endforeach
        </div>
    </div>

</div>
@endsection

