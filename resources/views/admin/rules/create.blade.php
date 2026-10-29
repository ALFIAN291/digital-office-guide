@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0084f8]">Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.rules.index') }}" class="hover:text-[#0084f8]">Dos & Don'ts</a>
        <span>/</span>
        <span class="text-[#0f2e54]">Tambah Pasangan Pedoman</span>
    </div>

    <div>
        <h1 class="text-2xl font-extrabold text-[#0f2e54]">Tambah Pedoman Dos & Don'ts</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
            Pedoman dikelola sebagai satu kesatuan kartu: foto situasi, sisi kiri DO (anjuran), dan sisi kanan DON'T (larangan).
        </p>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-xs sm:text-sm font-semibold">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.rules.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-xs space-y-6">
        @csrf

        <!-- General Info (Kategori & Urutan & Foto) -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1">Kategori Pedoman:</label>
                <select name="category" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden font-semibold">
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Urutan Tampil (Sort Order):</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 1) }}" min="0"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden font-semibold">
            </div>
        </div>

        <!-- Upload Foto Thumbnail -->
        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Foto Ilustrasi / Situasi (Thumbnail Kiri Kartu):</label>
            <input type="file" name="image_file" accept="image/*"
                   class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-sky-50 file:text-[#0084f8] hover:file:bg-sky-100">
            <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, WEBP (Maksimal 5MB). Jika dikosongkan, foto default kantor akan digunakan.</p>
        </div>

        <!-- Paired Dos & Don'ts Grid (Satu Kesatuan: Kiri DO, Kanan DON'T) -->
        <div class="pt-2">
            <div class="text-xs font-extrabold uppercase tracking-wider text-slate-400 mb-3">
                Isi Pedoman Berpasangan (Satu Kesatuan)
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                
                <!-- Sisi Kiri: DO (Hijau Pastel) -->
                <div class="bg-[#eaf8ee] p-5 rounded-2xl border border-emerald-200/80 space-y-4">
                    <div class="flex items-center gap-1.5 text-emerald-800 font-extrabold text-xs sm:text-sm tracking-wider uppercase">
                        <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-600 text-white text-xs font-black">✓</span>
                        <span>SISI KIRI: DO (Yang Dianjurkan / Wajib)</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-emerald-950 mb-1">Teks Utama DO (Judul Tebal):</label>
                        <input type="text" name="do_text" value="{{ old('do_text') }}" required placeholder="Contoh: Keep shared spaces clean."
                               class="w-full px-3.5 py-2.5 rounded-xl border border-emerald-300 bg-white text-xs sm:text-sm font-bold text-slate-800 focus:border-emerald-500 focus:outline-hidden">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-emerald-950 mb-1">Penjelasan Singkat DO:</label>
                        <textarea name="do_sub" rows="2" placeholder="Contoh: Rapikan area kerja dan jaga kebersihan fasilitas bersama."
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-emerald-300 bg-white text-xs sm:text-sm text-slate-700 focus:border-emerald-500 focus:outline-hidden">{{ old('do_sub') }}</textarea>
                    </div>
                </div>

                <!-- Sisi Kanan: DON'T (Merah Pastel) -->
                <div class="bg-[#feeff0] p-5 rounded-2xl border border-rose-200/80 space-y-4">
                    <div class="flex items-center gap-1.5 text-rose-700 font-extrabold text-xs sm:text-sm tracking-wider uppercase">
                        <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-rose-600 text-white text-xs font-black">✕</span>
                        <span>SISI KANAN: DON'T (Yang Dilarang / Hindari)</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-rose-950 mb-1">Teks Utama DON'T (Judul Tebal):</label>
                        <input type="text" name="dont_text" value="{{ old('dont_text') }}" required placeholder="Contoh: Leave personal items behind."
                               class="w-full px-3.5 py-2.5 rounded-xl border border-rose-300 bg-white text-xs sm:text-sm font-bold text-slate-800 focus:border-rose-500 focus:outline-hidden">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-rose-950 mb-1">Penjelasan Singkat DON'T:</label>
                        <textarea name="dont_sub" rows="2" placeholder="Contoh: Jangan meninggalkan barang pribadi atau sampah di area umum."
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-rose-300 bg-white text-xs sm:text-sm text-slate-700 focus:border-rose-500 focus:outline-hidden">{{ old('dont_sub') }}</textarea>
                    </div>
                </div>

            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route('admin.rules.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800">Batal</a>
            <button type="submit" class="px-6 py-2.5 bg-[#0084f8] hover:bg-[#0070d6] text-white text-xs font-bold rounded-xl shadow-md transition flex items-center gap-1.5">
                <span>Simpan Pasangan Pedoman Baru</span>
                <span>→</span>
            </button>
        </div>
    </form>

</div>
@endsection
