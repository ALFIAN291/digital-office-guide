@extends('layouts.app')

@section('content')
<div class="max-w-5xl lg:max-w-none mx-auto px-4 sm:px-6 pt-5 space-y-6">

    <!-- Breadcrumb & Title -->
    <div>
        <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-2">
            <a href="{{ route('guide.index') }}" class="hover:text-[#0084f8]">Beranda</a>
            <span>/</span>
            <span class="text-[#0f2e54]">Canteen & Services</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0f2e54] tracking-tight">Canteen & Dining Services Guide</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Panduan jadwal makan shift, transaksi Tap Kartu Pegawai (Cashless), dan aturan kebersihan 5S di Kantin Karawang</p>
    </div>

    <!-- Hero Banner -->
    <div class="bg-white rounded-3xl soft-shadow border border-slate-200/80 overflow-hidden">
        <div class="relative h-52 sm:h-64 w-full overflow-hidden">
            <img src="{{ asset('images/management-office.jpg') }}" alt="Kantin Utama Karawang" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-900/35 to-transparent"></div>
            <div class="absolute bottom-5 left-6 right-6 text-white">
                <span class="px-3 py-1 rounded-full bg-amber-500 text-xs font-bold text-white uppercase tracking-wider mb-2 inline-block">
                    Gedung Utama • Lantai 1
                </span>
                <h2 class="text-xl sm:text-2xl font-extrabold">Kantin Utama & Cafeteria Akebono Karawang</h2>
                <p class="text-xs text-sky-100 mt-1">Kapasitas 350 kursi ber-AC • Sistem Cashless Tap ID • Higienis & Bergizi</p>
            </div>
        </div>

        <div class="p-5 sm:p-7 space-y-6">
            <!-- Meal Shifts Grid -->
            <div>
                <h3 class="text-base font-extrabold text-[#0f2e54] mb-3">Jadwal Operasional & Pembagian Shift Makan</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="p-4 rounded-2xl bg-sky-50 border border-sky-100">
                        <div class="text-xs font-extrabold text-[#0084f8] uppercase">Shift 1 / Office</div>
                        <div class="text-lg font-black text-[#0f2e54] mt-1">11:30 - 13:30 WIB</div>
                        <p class="text-[11px] text-slate-600 mt-1">Produksi 11:30–12:15 • Staff Office 12:15–13:15</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-amber-50 border border-amber-100">
                        <div class="text-xs font-extrabold text-amber-700 uppercase">Shift 2 (Sore/Malam)</div>
                        <div class="text-lg font-black text-[#0f2e54] mt-1">17:30 - 19:30 WIB</div>
                        <p class="text-[11px] text-slate-600 mt-1">Makan malam shift produksi & tim lembur terjadwal</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-indigo-50 border border-indigo-100">
                        <div class="text-xs font-extrabold text-indigo-700 uppercase">Shift 3 (Dini Hari)</div>
                        <div class="text-lg font-black text-[#0f2e54] mt-1">01:30 - 03:00 WIB</div>
                        <p class="text-[11px] text-slate-600 mt-1">Menu hangat shift malam + coffee & tea corner 24 jam</p>
                    </div>
                </div>
            </div>

            <!-- 5-Step How to Use Canteen System (Concept Slide 8 & 10) -->
            <div>
                <h3 class="text-base font-extrabold text-[#0f2e54] mb-3">5 Langkah Menggunakan Sistem Kantin Baru</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                    @foreach($canteenSteps as $step)
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

            <!-- 5S Canteen Etiquette -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 space-y-1.5">
                    <div class="text-xs font-extrabold text-emerald-800">✔ DO — Budaya Tertib Kantin</div>
                    <ul class="text-xs text-emerald-900 space-y-1 list-disc list-inside">
                        <li>Cuci tangan sebelum dan sesudah makan di wastafel sensor.</li>
                        <li>Antre dengan tertib di counter sesuai lajur lantai.</li>
                        <li>Kembalikan baki dan pilah sisa makanan (Organik vs Anorganik).</li>
                    </ul>
                </div>
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 space-y-1.5">
                    <div class="text-xs font-extrabold text-rose-800">✕ DON'T — Hal yang Dihindari</div>
                    <ul class="text-xs text-rose-900 space-y-1 list-disc list-inside">
                        <li>Dilarang membawa makanan berat atau berbau menyengat ke meja kerja.</li>
                        <li>Jangan menandai (booking) kursi dengan barang sebelum mengambil makan.</li>
                        <li>Jangan meninggalkan alat makan kotor di atas meja makan.</li>
                    </ul>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-3 pt-2 border-t border-slate-100">
                <a href="{{ route('guide.map', ['floor' => 'Lantai 1']) }}" class="px-5 py-2.5 bg-[#0084f8] hover:bg-[#0070d6] text-white text-xs font-bold rounded-full shadow-sm transition">
                    Lihat Lokasi Kantin di Denah 1F →
                </a>
                @if($diningFacility)
                    <a href="{{ route('guide.facility.detail', $diningFacility->slug) }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-full transition">
                        Detail Lengkap Fasilitas Kantin →
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
