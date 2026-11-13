@extends('layouts.app')

@section('content')
<div class="max-w-5xl lg:max-w-none mx-auto px-4 sm:px-6 pt-5 space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-2">
                <a href="{{ route('guide.index') }}" class="hover:text-[#0084f8]">Beranda</a>
                <span>/</span>
                <span class="text-[#0f2e54]">Support & Contact</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0f2e54] tracking-tight">Support & Internal Contact Center</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Bantuan cepat IT Helpdesk, General Affairs (Fasilitas Gedung), HR Services, dan Layanan Darurat Karawang</p>
        </div>
        <a href="{{ route('guide.emergency') }}" class="px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-extrabold rounded-xl shadow-xs transition w-fit">
            🚨 Mode Darurat (SOS)
        </a>
    </div>

    <!-- Quick Desk Support Directory -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-3xl soft-shadow border border-slate-200/80 p-5 space-y-2.5">
            <div class="w-10 h-10 rounded-2xl bg-sky-100 text-[#0084f8] flex items-center justify-center text-lg font-bold">💻</div>
            <h3 class="text-base font-extrabold text-[#0f2e54]">IT Helpdesk & Network</h3>
            <p class="text-xs text-slate-500 leading-relaxed">Kendala Wi-Fi, koneksi ruang meeting (HDMI/VC), akun SSO, printer lantai 2, atau perangkat desk baru.</p>
            <div class="text-xs font-bold text-[#0084f8] pt-1">Lokasi: R. Server Lt. 2 • Ext. 200</div>
        </div>
        <div class="bg-white rounded-3xl soft-shadow border border-slate-200/80 p-5 space-y-2.5">
            <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-lg font-bold">🛠️</div>
            <h3 class="text-base font-extrabold text-[#0f2e54]">General Affairs (GA)</h3>
            <p class="text-xs text-slate-500 leading-relaxed">Loker, kantin, kebersihan pantry, AC/lampu gedung, kendaraan dinas, dan reservasi auditorium.</p>
            <div class="text-xs font-bold text-amber-700 pt-1">Lokasi: GA Office Lt. 1 • Ext. 104</div>
        </div>
        <div class="bg-white rounded-3xl soft-shadow border border-slate-200/80 p-5 space-y-2.5">
            <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-lg font-bold">🪪</div>
            <h3 class="text-base font-extrabold text-[#0f2e54]">HR & Onboarding Desk</h3>
            <p class="text-xs text-slate-500 leading-relaxed">Kartu akses RFID karyawan baru, QR Desk Tent Card, panduan absensi, serta layanan kesehatan klinik.</p>
            <div class="text-xs font-bold text-emerald-700 pt-1">Lokasi: HR Wing Lt. 1 • Ext. 108</div>
        </div>
    </div>

    <!-- All Active Database Contacts with Direct WhatsApp & Tel -->
    <div class="bg-white rounded-3xl soft-shadow border border-slate-200/80 p-5 sm:p-6 space-y-4">
        <h2 class="text-base sm:text-lg font-extrabold text-[#0f2e54]">Direktori Kontak Langsung (WhatsApp & Telepon)</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
            @foreach($contacts as $contact)
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col justify-between gap-3">
                    <div>
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full {{ $contact->is_hotline ? 'bg-rose-100 text-rose-700' : 'bg-sky-100 text-[#0084f8]' }}">
                                {{ $contact->is_hotline ? 'Siaga 24 Jam' : ($contact->operating_hours ?? 'Jam Kerja') }}
                            </span>
                            <span class="text-[11px] font-semibold text-slate-400">📍 {{ $contact->location }}</span>
                        </div>
                        <h3 class="text-sm sm:text-base font-extrabold text-[#0f2e54] mt-2">{{ $contact->name }}</h3>
                        <div class="text-sm font-black font-mono text-slate-700 mt-1">
                            {{ $contact->phone }}
                            @if($contact->extension)
                                <span class="text-xs font-sans font-semibold text-slate-400"> / {{ $contact->extension }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pt-2 border-t border-slate-200/60">
                        <a href="{{ $contact->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                           class="flex-1 py-2 px-3 bg-[#25D366] hover:bg-[#20bd5a] text-white font-bold text-xs rounded-xl text-center transition">
                            💬 Chat WhatsApp
                        </a>
                        <a href="{{ $contact->tel_url }}"
                           class="py-2 px-3.5 bg-white hover:bg-slate-100 text-[#0f2e54] border border-slate-200 font-bold text-xs rounded-xl transition">
                            📞 Panggil
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
