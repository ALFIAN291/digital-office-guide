@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0084f8]">Dashboard</a>
                <span>/</span>
                <span class="text-[#0f2e54]">Edit Konten Beranda</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0f2e54] tracking-tight">Editor Konten Beranda (Tampilan Awal)</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Ubah teks judul, slogan, foto hero, judul kartu 4 kotak, dan catatan kaki secara dinamis</p>
        </div>
        <div>
            <a href="{{ route('guide.index') }}" target="_blank" class="px-4 py-2 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-xs font-bold rounded-xl shadow-xs transition flex items-center gap-1.5">
                <span>Pratinjau Web ↗</span>
            </a>
        </div>
    </div>

    <!-- Main Form -->
    <form action="{{ route('admin.home.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- 1. Header & Branding Section -->
        <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                <span class="text-xl">🏷️</span>
                <div>
                    <h2 class="text-base font-extrabold text-[#0f2e54]">Identitas Header Atas (Sebelah Logo)</h2>
                    <p class="text-xs text-slate-400">Teks 2 baris yang muncul di sebelah logo Akebono pada navbar atas</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Baris 1 (Nama Lokasi / Kota):</label>
                    <input type="text" name="office_title" value="{{ old('office_title', $settings->office_title) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden font-bold text-slate-800">
                    <span class="text-[10px] text-slate-400">Contoh default: KARAWANG</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Baris 2 (Nama Panduan):</label>
                    <input type="text" name="office_subtitle" value="{{ old('office_subtitle', $settings->office_subtitle) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden font-bold text-slate-800">
                    <span class="text-[10px] text-slate-400">Contoh default: OFFICE GUIDE 2026</span>
                </div>
            </div>
        </div>

        <!-- 2. Hero Section Settings -->
        <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200/80 shadow-xs space-y-5">
            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                <span class="text-xl">✨</span>
                <div>
                    <h2 class="text-base font-extrabold text-[#0f2e54]">Hero Banner Utama ("Welcome to Your New Workplace")</h2>
                    <p class="text-xs text-slate-400">Bagian banner besar yang berada di paling atas layar utama</p>
                </div>
            </div>

            <!-- Current Hero Image Preview & Upload -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-2">Foto Background Hero Banner:</label>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <div class="w-full sm:w-48 h-28 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shrink-0">
                        <img src="{{ asset($settings->hero_image) }}" alt="Preview Hero" class="w-full h-full object-cover">
                    </div>
                    <div class="space-y-1.5">
                        <input type="file" name="hero_image_file" accept="image/*" class="text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sky-50 file:text-[#0084f8] hover:file:bg-sky-100 cursor-pointer">
                        <p class="text-[11px] text-slate-400">Pilih berkas gambar baru (JPG, PNG, WebP maks 5MB) jika ingin mengganti latar lobi kantor.</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Badge Atas Hero:</label>
                    <input type="text" name="hero_badge" value="{{ old('hero_badge', $settings->hero_badge) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Judul Baris 1:</label>
                    <input type="text" name="hero_title_line1" value="{{ old('hero_title_line1', $settings->hero_title_line1) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Judul Baris 2 (Teks Utama):</label>
                    <input type="text" name="hero_title_line2" value="{{ old('hero_title_line2', $settings->hero_title_line2) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden font-bold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Slogan / Tagline Subtitle:</label>
                    <input type="text" name="hero_tagline" value="{{ old('hero_tagline', $settings->hero_tagline) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
                </div>
            </div>
        </div>

        <!-- 3. Explore Workplace & 4 Grid Cards -->
        <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200/80 shadow-xs space-y-6">
            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                <span class="text-xl">🗂️</span>
                <div>
                    <h2 class="text-base font-extrabold text-[#0f2e54]">Bagian "Explore Your Workplace" (4 Kartu Utama)</h2>
                    <p class="text-xs text-slate-400">Atur judul dan foto pada 4 grid kartu navigasi di halaman awal</p>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Judul Section Grid:</label>
                <input type="text" name="explore_title" value="{{ old('explore_title', $settings->explore_title) }}" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden font-bold">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                
                <!-- Card 1: Office & Plant -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-[#0084f8]">Kartu 1 (Kiri Atas)</span>
                        <img src="{{ asset($settings->card_office_image) }}" alt="Card 1" class="w-12 h-8 object-cover rounded-md border">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Judul Kartu:</label>
                        <input type="text" name="card_office_title" value="{{ old('card_office_title', $settings->card_office_title) }}" required
                               class="w-full px-3 py-2 bg-white rounded-lg border border-slate-200 text-xs font-semibold">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Badge Label:</label>
                        <input type="text" name="card_office_badge" value="{{ old('card_office_badge', $settings->card_office_badge) }}" required
                               class="w-full px-3 py-2 bg-white rounded-lg border border-slate-200 text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Ganti Foto:</label>
                        <input type="file" name="card_office_image_file" accept="image/*" class="text-xs text-slate-500 w-full">
                    </div>
                </div>

                <!-- Card 2: Facilities -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-[#0084f8]">Kartu 2 (Kanan Atas)</span>
                        <img src="{{ asset($settings->card_facilities_image) }}" alt="Card 2" class="w-12 h-8 object-cover rounded-md border">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Judul Kartu:</label>
                        <input type="text" name="card_facilities_title" value="{{ old('card_facilities_title', $settings->card_facilities_title) }}" required
                               class="w-full px-3 py-2 bg-white rounded-lg border border-slate-200 text-xs font-semibold">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Badge Label:</label>
                        <input type="text" name="card_facilities_badge" value="{{ old('card_facilities_badge', $settings->card_facilities_badge) }}" required
                               class="w-full px-3 py-2 bg-white rounded-lg border border-slate-200 text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Ganti Foto:</label>
                        <input type="file" name="card_facilities_image_file" accept="image/*" class="text-xs text-slate-500 w-full">
                    </div>
                </div>

                <!-- Card 3: Office Map -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-[#0084f8]">Kartu 3 (Kiri Bawah)</span>
                        <img src="{{ asset($settings->card_map_image) }}" alt="Card 3" class="w-12 h-8 object-cover rounded-md border">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Judul Kartu:</label>
                        <input type="text" name="card_map_title" value="{{ old('card_map_title', $settings->card_map_title) }}" required
                               class="w-full px-3 py-2 bg-white rounded-lg border border-slate-200 text-xs font-semibold">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Badge Label:</label>
                        <input type="text" name="card_map_badge" value="{{ old('card_map_badge', $settings->card_map_badge) }}" required
                               class="w-full px-3 py-2 bg-white rounded-lg border border-slate-200 text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Ganti Foto:</label>
                        <input type="file" name="card_map_image_file" accept="image/*" class="text-xs text-slate-500 w-full">
                    </div>
                </div>

                <!-- Card 4: Dos & Don'ts -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-[#0084f8]">Kartu 4 (Kanan Bawah)</span>
                        <img src="{{ asset($settings->card_rules_image) }}" alt="Card 4" class="w-12 h-8 object-cover rounded-md border">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Judul Kartu:</label>
                        <input type="text" name="card_rules_title" value="{{ old('card_rules_title', $settings->card_rules_title) }}" required
                               class="w-full px-3 py-2 bg-white rounded-lg border border-slate-200 text-xs font-semibold">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Badge Label:</label>
                        <input type="text" name="card_rules_badge" value="{{ old('card_rules_badge', $settings->card_rules_badge) }}" required
                               class="w-full px-3 py-2 bg-white rounded-lg border border-slate-200 text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Ganti Foto:</label>
                        <input type="file" name="card_rules_image_file" accept="image/*" class="text-xs text-slate-500 w-full">
                    </div>
                </div>

            </div>

            <!-- Footnote input -->
            <div class="pt-2">
                <label class="block text-xs font-bold text-slate-700 mb-1">Catatan Kaki Di Bawah 4 Kartu:</label>
                <input type="text" name="footnote_text" value="{{ old('footnote_text', $settings->footnote_text) }}" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
                <span class="text-[10px] text-slate-400">Contoh: Visual kantor merupakan ilustrasi konseptual. Ganti dengan foto aktual setelah tersedia.</span>
            </div>
        </div>

        <!-- 4. Save Button Bar -->
        <div class="sticky bottom-4 z-30 bg-white p-4 rounded-2xl shadow-xl border border-slate-200 flex items-center justify-between">
            <span class="text-xs text-slate-500">Perubahan akan langsung tampil di halaman depan.</span>
            <button type="submit" class="px-6 py-2.5 bg-[#0084f8] hover:bg-[#0070d6] text-white text-xs sm:text-sm font-bold rounded-xl shadow-md transition flex items-center gap-1.5">
                <span>💾 Simpan Perubahan Beranda</span>
            </button>
        </div>

    </form>

</div>
@endsection

