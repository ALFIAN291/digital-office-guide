@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0f2e54] tracking-tight">Dashboard Administrator</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola informasi publik, sambutan manajemen, dan fasilitas kantor Akebono Karawang</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.home.edit') }}" class="px-4 py-2 bg-[#0084f8] hover:bg-[#0070d6] text-white text-xs font-bold rounded-xl shadow-xs transition flex items-center gap-1.5">
                <span>🪄</span>
                <span>Edit Konten Beranda</span>
            </a>
            <a href="{{ route('guide.index') }}" target="_blank" class="px-4 py-2 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-xs font-bold rounded-xl shadow-xs transition flex items-center gap-1.5">
                <span>Lihat Web ↗</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total Fasilitas</div>
            <div class="text-3xl font-black text-[#0f2e54] mt-1">{{ $stats['facilities_count'] }}</div>
            <a href="{{ route('admin.facilities.index') }}" class="text-xs text-[#0084f8] font-semibold mt-2 inline-block hover:underline">Kelola Fasilitas →</a>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Pedoman K3 & Etiket</div>
            <div class="text-3xl font-black text-[#0f2e54] mt-1">{{ $stats['rules_count'] }}</div>
            <div class="text-[11px] text-slate-500 mt-1">
                <span class="text-emerald-600 font-bold">{{ $stats['dos_count'] }} DO</span> • 
                <span class="text-rose-600 font-bold">{{ $stats['donts_count'] }} DON'T</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Titik Denah Kantor</div>
            <div class="text-3xl font-black text-[#0f2e54] mt-1">{{ $stats['zones_count'] }}</div>
            <a href="{{ route('guide.map') }}" target="_blank" class="text-xs text-[#0084f8] font-semibold mt-2 inline-block hover:underline">Cek Denah →</a>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Kontak Darurat (SOS)</div>
            <div class="text-3xl font-black text-rose-600 mt-1">{{ $stats['contacts_count'] }}</div>
            <a href="{{ route('admin.emergency.index') }}" class="text-xs text-rose-600 font-semibold mt-2 inline-block hover:underline">Kelola Kontak →</a>
        </div>
    </div>

    <!-- Main Shortcuts Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Shortcut 1: Edit Beranda ("Isinya yang diawal") -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 rounded-2xl bg-sky-100 text-[#0084f8] flex items-center justify-center text-2xl font-bold mb-4">
                    🪄
                </div>
                <h3 class="text-lg font-extrabold text-[#0f2e54]">Edit Konten Beranda (Tampilan Awal)</h3>
                <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-relaxed">
                    Ubah teks judul Hero (<i>"Welcome to Your New Workplace"</i>), slogan, foto background lobi, judul kartu 4 kotak (Office & Plant, Facilities, Map, Dos & Don'ts), dan catatan kaki.
                </p>

                <!-- Current preview snippet -->
                <div class="mt-4 p-3 bg-slate-50 rounded-xl border border-slate-100 text-xs text-slate-600 space-y-1">
                    <div><b>Judul:</b> {{ $settings->hero_title_line1 }} {{ $settings->hero_title_line2 }}</div>
                    <div><b>Tagline:</b> {{ $settings->hero_tagline }}</div>
                    <div><b>Label Kantor:</b> {{ $settings->office_title }} - {{ $settings->office_subtitle }}</div>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.home.edit') }}" class="w-full py-2.5 bg-[#0084f8] hover:bg-[#0070d6] text-white font-bold text-xs rounded-xl transition flex items-center justify-center gap-1.5 shadow-xs">
                    <span>Buka Editor Beranda</span>
                    <span>→</span>
                </a>
            </div>
        </div>

        <!-- Shortcut 2: Edit Pesan Manajemen -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-2xl font-bold mb-4">
                    📝
                </div>
                <h3 class="text-lg font-extrabold text-[#0f2e54]">Edit Pesan Manajemen (Sambutan)</h3>
                <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-relaxed">
                    Perbarui teks sambutan pada kartu <i>"A Message from Management"</i>, nama pengirim, peran pimpinan, ringkasan kartu, serta foto workspace manajemen.
                </p>

                <div class="mt-4 p-3 bg-slate-50 rounded-xl border border-slate-100 text-xs text-slate-600 space-y-1">
                    <div><b>Judul:</b> {{ $message->title ?? 'A Message from Management' }}</div>
                    <div><b>Pengirim:</b> {{ $message->sender_name ?? '-' }}</div>
                    <div class="line-clamp-1"><b>Ringkasan:</b> {{ $message->summary ?? '-' }}</div>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.message.edit') }}" class="w-full py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs rounded-xl transition flex items-center justify-center gap-1.5 shadow-xs">
                    <span>Buka Editor Pesan Manajemen</span>
                    <span>→</span>
                </a>
            </div>
        </div>

    </div>

    <!-- Direct Management Links Grid -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <h3 class="text-base font-extrabold text-[#0f2e54] mb-4">Pusat Data Master Guide</h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            
            <a href="{{ route('admin.facilities.index') }}" class="p-4 rounded-2xl bg-slate-50 hover:bg-sky-50 border border-slate-200 hover:border-sky-300 transition group">
                <div class="text-xl mb-2">🏢</div>
                <div class="font-bold text-sm text-slate-800 group-hover:text-[#0084f8]">Data Fasilitas Kantor</div>
                <div class="text-xs text-slate-500 mt-0.5">Tambah, edit foto, kapasitas, dan jam buka ruangan</div>
            </a>

            <a href="{{ route('admin.rules.index') }}" class="p-4 rounded-2xl bg-slate-50 hover:bg-sky-50 border border-slate-200 hover:border-sky-300 transition group">
                <div class="text-xl mb-2">📋</div>
                <div class="font-bold text-sm text-slate-800 group-hover:text-[#0084f8]">Aturan Dos & Don'ts</div>
                <div class="text-xs text-slate-500 mt-0.5">Aturan keselamatan kerja K3, budaya 5S, dan etiket kantor</div>
            </a>

            <a href="{{ route('admin.emergency.index') }}" class="p-4 rounded-2xl bg-slate-50 hover:bg-sky-50 border border-slate-200 hover:border-sky-300 transition group">
                <div class="text-xl mb-2">🚨</div>
                <div class="font-bold text-sm text-slate-800 group-hover:text-[#0084f8]">Hotline Darurat SOS</div>
                <div class="text-xs text-slate-500 mt-0.5">Nomor telepon satpam pos barat, klinik, dan damkar</div>
            </a>

        </div>
    </div>

</div>
@endsection

