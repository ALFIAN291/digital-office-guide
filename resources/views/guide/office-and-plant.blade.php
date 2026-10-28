@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 pt-5 space-y-6">

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
            <div class="pt-4 flex flex-wrap items-center justify-between gap-3">
                <a href="{{ route('guide.map', ['floor' => 'Ground Floor']) }}" class="px-5 py-2.5 bg-[#0084f8] hover:bg-[#0070d6] text-white font-bold text-xs rounded-full shadow-md transition">
                    Buka Denah Kawasan Pabrik →
                </a>
                <a href="{{ route('guide.dos-and-donts', ['category' => 'HSE & Keselamatan']) }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-full transition">
                    Lihat Aturan Lengkap K3 →
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

