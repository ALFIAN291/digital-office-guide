@extends('layouts.app')

@section('content')
<div class="max-w-5xl lg:max-w-none mx-auto px-4 sm:px-6 pt-5 space-y-6"
     x-data="{
        visitorType: 'business',
        checkInPreview: false
     }">

    <div>
        <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-2">
            <a href="{{ route('guide.index') }}" class="hover:text-[#0084f8]">Beranda</a>
            <span>/</span>
            <span class="text-[#0f2e54]">Visitor Guide & Virtual Reception</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0f2e54] tracking-tight">Visitor Management & Virtual Reception</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Alur registrasi tamu digital, notifikasi host otomatis, dan standar keselamatan kunjungan di Akebono Karawang</p>
    </div>

    <!-- 5-Step Visitor Access Flow (Concept Slide 6, 8 & 10) -->
    <div class="bg-white rounded-3xl soft-shadow border border-slate-200/80 p-5 sm:p-7 space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h2 class="text-base sm:text-lg font-extrabold text-[#0f2e54]">Alur Registrasi Tamu (5 Langkah)</h2>
                <p class="text-xs text-slate-500">Berlaku untuk tamu bisnis, vendor, audit, maupun kunjungan ke area plant</p>
            </div>
            <span class="px-3 py-1 rounded-full bg-sky-50 text-[#0084f8] text-[11px] font-bold w-fit">Lobi Utama Lt. 1</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            @foreach($visitorSteps as $step)
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-[#0084f8] text-white text-xs font-extrabold flex items-center justify-center shrink-0">{{ $step['step'] }}</span>
                        <span class="text-xs font-extrabold text-[#0f2e54]">{{ $step['title'] }}</span>
                    </div>
                    <p class="text-[11px] text-slate-600 leading-relaxed">{{ $step['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Virtual Reception Interactive Guide (Concept Slide 8) -->
    <div id="virtual-reception" class="bg-white rounded-3xl soft-shadow border border-slate-200/80 p-5 sm:p-7 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <span class="px-2.5 py-0.5 rounded bg-sky-100 text-[#0084f8] text-[10px] font-extrabold uppercase tracking-wider">Virtual Reception Kiosk</span>
                <h2 class="text-base sm:text-lg font-extrabold text-[#0f2e54] mt-1">Simulasi Bantuan Resepsionis Virtual</h2>
                <p class="text-xs text-slate-500">Pilih tipe kunjungan tamu untuk melihat dokumen, APD, dan akses yang diizinkan</p>
            </div>
            <div class="inline-flex bg-slate-100 p-1 rounded-xl border border-slate-200/80 text-xs font-bold">
                <button type="button" @click="visitorType = 'business'"
                        :class="visitorType === 'business' ? 'bg-[#0084f8] text-white' : 'text-slate-600'"
                        class="px-3 py-1.5 rounded-lg transition cursor-pointer">Tamu Bisnis / Meeting</button>
                <button type="button" @click="visitorType = 'plant'"
                        :class="visitorType === 'plant' ? 'bg-[#0084f8] text-white' : 'text-slate-600'"
                        class="px-3 py-1.5 rounded-lg transition cursor-pointer">Vendor / Area Plant</button>
            </div>
        </div>

        <div x-show="visitorType === 'business'" class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
            <div class="p-4 rounded-2xl bg-sky-50 border border-sky-100 space-y-1">
                <div class="font-extrabold text-[#0f2e54]">1. Check-In & Host Alert</div>
                <p class="text-slate-600">Masukkan nama & pilih PIC tujuan di kiosk resepsionis. Notifikasi otomatis dikirim ke Microsoft Teams / email host.</p>
            </div>
            <div class="p-4 rounded-2xl bg-sky-50 border border-sky-100 space-y-1">
                <div class="font-extrabold text-[#0f2e54]">2. Guest Wi-Fi & Lounge</div>
                <p class="text-slate-600">Gunakan QR voucher Wi-Fi tamu di lobi sambil menunggu PIC menjemput ke Ruang Rapat / VIP Room.</p>
            </div>
            <div class="p-4 rounded-2xl bg-sky-50 border border-sky-100 space-y-1">
                <div class="font-extrabold text-[#0f2e54]">3. Visitor Pass Biru</div>
                <p class="text-slate-600">Kenakan lanyard Visitor Pass dengan jelas selama di Gedung Utama dan kembalikan di resepsionis saat keluar.</p>
            </div>
        </div>

        <div x-show="visitorType === 'plant'" x-cloak class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 space-y-1">
                <div class="font-extrabold text-amber-900">1. Safety Induction Briefing</div>
                <p class="text-amber-800">Tamu area Plant wajib menonton briefing K3 singkat (3 menit) dan menandatangani Safety Pledge di Kiosk.</p>
            </div>
            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 space-y-1">
                <div class="font-extrabold text-amber-900">2. APD Wajib (Safety Shoes & Helm)</div>
                <p class="text-amber-800">Wajib mengenakan Safety Shoes, Safety Glasses, dan Rompi Tamu sebelum melintasi koridor Plant 1 & 2.</p>
            </div>
            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 space-y-1">
                <div class="font-extrabold text-amber-900">3. Wajib Didampingi PIC</div>
                <p class="text-amber-800">Dilarang berjalan di luar garis hijau atau mengambil foto mesin produksi tanpa izin tertulis HSE.</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3 pt-2 border-t border-slate-100">
            <a href="{{ route('guide.map', ['floor' => 'Lantai 1']) }}" class="px-5 py-2.5 bg-[#0084f8] hover:bg-[#0070d6] text-white text-xs font-bold rounded-full shadow-sm transition">
                Lihat Lobi & Reception di Denah 1F →
            </a>
            @if($lobbyFacility)
                <a href="{{ route('guide.facility.detail', $lobbyFacility->slug) }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-full transition">
                    Detail Fasilitas Lobi Utama →
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
