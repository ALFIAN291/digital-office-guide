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
            <div class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center font-bold text-xl shrink-0">
                🚨
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0f2e54] tracking-tight">Kontak Darurat & Hotline Layanan</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Layanan bantuan cepat, keamanan, medis, HSE, dan pemadam kebakaran 24 Jam</p>
            </div>
        </div>

        <!-- Quick WA Hint Callout -->
        <div class="mt-4 p-3 bg-emerald-50/80 border border-emerald-200/80 rounded-2xl flex items-center gap-2.5 text-xs text-emerald-900">
            <span class="text-base">💬</span>
            <p>
                <strong>Langsung ke WhatsApp:</strong> Klik tombol hijau <strong>Chat WhatsApp</strong> pada unit yang ingin Anda hubungi untuk percakapan atau laporan cepat, atau tombol <strong>Panggil</strong> untuk panggilan telepon langsung.
            </p>
        </div>
    </div>

    <!-- Emergency Contacts Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @foreach($contacts as $contact)
            <div class="bg-white rounded-3xl p-5 soft-shadow border {{ $contact->is_hotline ? 'border-rose-200 bg-linear-to-b from-white to-rose-50/20' : 'border-slate-200/80' }} flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full {{ $contact->is_hotline ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $contact->is_hotline ? 'Siaga 24 Jam' : 'Jam Kerja' }}
                        </span>
                        <span class="text-xs text-slate-400 font-semibold">📍 {{ $contact->location }}</span>
                    </div>

                    <h3 class="text-base sm:text-lg font-extrabold text-[#0f2e54] mt-2.5 leading-snug">
                        {{ $contact->name }}
                    </h3>

                    <div class="text-2xl font-black text-[#0f2e54] mt-2 font-mono tracking-tight flex items-center gap-2">
                        <a href="{{ $contact->whatsapp_url }}" target="_blank" rel="noopener noreferrer" 
                           class="hover:underline flex items-center gap-2 group text-[#0f2e54] hover:text-emerald-600 transition" 
                           title="Klik untuk Chat WhatsApp">
                            <span>{{ $contact->phone }}</span>
                            <span class="text-xs font-sans font-bold px-1.5 py-0.5 rounded-md bg-emerald-100 text-emerald-700 opacity-0 group-hover:opacity-100 transition">WA ↗</span>
                        </a>
                    </div>

                    @if($contact->extension)
                        <div class="text-xs font-semibold text-slate-500 mt-0.5">
                            Internal: <span class="text-slate-800 font-bold">{{ $contact->extension }}</span>
                        </div>
                    @endif
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center gap-2">
                    <a href="{{ $contact->whatsapp_url }}" target="_blank" rel="noopener noreferrer" 
                       class="flex-1 py-2.5 px-3 bg-[#25D366] hover:bg-[#20bd5a] active:scale-[0.98] text-white font-bold text-xs rounded-xl flex items-center justify-center gap-2 shadow-xs transition"
                       title="Buka Chat WhatsApp">
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.06-2.12-.531-1.822-.754-2.98-2.617-3.07-2.738-.09-.12-1.245-1.657-1.245-3.16 0-1.503.784-2.242 1.062-2.528.278-.285.606-.356.808-.356.202 0 .405.002.583.01.19.009.444-.072.695.531.259.621.884 2.158.961 2.315.077.157.129.34.026.545-.103.204-.155.331-.309.51-.154.179-.324.4-.463.537-.154.152-.315.318-.135.627.18.308.8 1.319 1.717 2.136 1.18 1.05 2.175 1.376 2.483 1.53.308.154.489.13.67-.078.18-.208.775-.905.981-1.214.206-.308.411-.257.695-.153.285.103 1.808.853 2.117 1.008.309.154.515.231.592.36.077.13.077.75-.067 1.155z"/>
                        </svg>
                        <span>Chat WhatsApp</span>
                    </a>

                    <a href="{{ $contact->tel_url }}" 
                       class="py-2.5 px-3.5 bg-rose-50 hover:bg-rose-100 active:scale-[0.98] text-rose-700 font-bold text-xs rounded-xl flex items-center justify-center gap-1.5 border border-rose-200 transition shrink-0" 
                       title="Panggil Telepon Langsung">
                        <span>📞</span>
                        <span>Panggil</span>
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
