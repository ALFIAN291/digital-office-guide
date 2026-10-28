@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 pt-5 space-y-6">

    <!-- Header & Breadcrumb -->
    <div>
        <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-2">
            <a href="{{ route('guide.index') }}" class="hover:text-[#0084f8]">Beranda</a>
            <span>/</span>
            <span class="text-[#0f2e54]">Kontak Darurat & Tanggap Bencana</span>
        </div>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center font-bold text-xl">
                🚨
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0f2e54] tracking-tight">Kontak Darurat (Emergency Hotline)</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Layanan bantuan medis, keamanan, keselamatan kerja, dan pemadam kebakaran 24 Jam</p>
            </div>
        </div>
    </div>

    <!-- Emergency Contacts Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @foreach($contacts as $contact)
            <div class="bg-white rounded-3xl p-5 soft-shadow border {{ $contact->is_hotline ? 'border-rose-200 bg-rose-50/20' : 'border-slate-200/80' }} flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full {{ $contact->is_hotline ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $contact->is_hotline ? 'Siaga 24 Jam' : 'Jam Kerja' }}
                        </span>
                        <span class="text-xs text-slate-400 font-semibold">📍 {{ $contact->location }}</span>
                    </div>

                    <h3 class="text-base sm:text-lg font-extrabold text-[#0f2e54] mt-2.5">
                        {{ $contact->name }}
                    </h3>

                    <div class="text-2xl font-black text-rose-600 mt-2 font-mono tracking-tight">
                        {{ $contact->phone }}
                    </div>

                    @if($contact->extension)
                        <div class="text-xs font-semibold text-slate-500 mt-0.5">
                            Internal: <span class="text-slate-800 font-bold">{{ $contact->extension }}</span>
                        </div>
                    @endif
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100">
                    <a href="tel:{{ preg_replace('/[^0-9]/', '', $contact->phone) }}" class="w-full py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl flex items-center justify-center gap-2 shadow-md transition">
                        <span>📞</span>
                        <span>Hubungi Sekarang</span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Evacuation Steps Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 soft-shadow border border-slate-200/80 space-y-4">
        <h3 class="text-lg font-extrabold text-[#0f2e54] flex items-center gap-2">
            <span>🛡️</span>
            <span>Prosedur Evakuasi Kebakaran & Gempa Bumi</span>
        </h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                <span class="w-7 h-7 rounded-full bg-rose-100 text-rose-700 font-extrabold flex items-center justify-center text-xs mb-2">1</span>
                <h4 class="font-bold text-xs sm:text-sm text-slate-800">Tetap Tenang & Jangan Panik</h4>
                <p class="text-xs text-slate-500 mt-1">Segera hentikan pekerjaan, tinggalkan barang bawaan berat, dan ikuti instruksi Floor Warden.</p>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                <span class="w-7 h-7 rounded-full bg-rose-100 text-rose-700 font-extrabold flex items-center justify-center text-xs mb-2">2</span>
                <h4 class="font-bold text-xs sm:text-sm text-slate-800">Gunakan Tangga Darurat</h4>
                <p class="text-xs text-slate-500 mt-1">Dilarang menggunakan lift saat alarm berbunyi. Turun dengan tertib sambil berpegangan pada handrail.</p>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                <span class="w-7 h-7 rounded-full bg-rose-100 text-rose-700 font-extrabold flex items-center justify-center text-xs mb-2">3</span>
                <h4 class="font-bold text-xs sm:text-sm text-slate-800">Menuju Assembly Point</h4>
                <p class="text-xs text-slate-500 mt-1">Berkumpullah di Titik Kumpul (Pelataran Barat/Timur) dan tunggu proses roll-call absensi keselamatan.</p>
            </div>
        </div>

        <div class="pt-4 text-center">
            <a href="{{ route('guide.map', ['floor' => 'Lantai 1']) }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-full transition">
                <span>Lihat Lokasi Assembly Point di Denah</span>
                <span>→</span>
            </a>
        </div>
    </div>

</div>
@endsection

