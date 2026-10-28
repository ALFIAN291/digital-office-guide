@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0084f8]">Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.rules.index') }}" class="hover:text-[#0084f8]">Dos & Don'ts</a>
        <span>/</span>
        <span class="text-[#0f2e54]">Tambah Aturan Baru</span>
    </div>

    <h1 class="text-2xl font-extrabold text-[#0f2e54]">Tambah Pedoman Dos / Don'ts</h1>

    <form action="{{ route('admin.rules.store') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-xs space-y-5">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Jenis Pedoman:</label>
                <select name="type" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden font-bold">
                    <option value="do">✓ DO (Yang Dianjurkan / Wajib)</option>
                    <option value="dont">✕ DON'T (Yang Dilarang / Hindari)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Kategori Pedoman:</label>
                <select name="category" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
                    <option value="HSE & Keselamatan">HSE & Keselamatan Kerja (K3)</option>
                    <option value="Etiket Kerja & Lingkungan">Etiket Kerja & Budaya 5S</option>
                    <option value="Keamanan Informasi & TI">Keamanan Informasi & TI</option>
                    <option value="Penggunaan Fasilitas">Penggunaan Fasilitas & Ruangan</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Judul Ringkas Aturan:</label>
            <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Selalu Gunakan Helm Pelindung di Area Casting"
                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden font-semibold">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Penjelasan Detail:</label>
            <textarea name="description" rows="3" required placeholder="Jelaskan alasan dan tata cara kepatuhannya..."
                      class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Tips / Alasan / Konsekuensi (Muncul di Bawah Aturan):</label>
            <input type="text" name="tip_or_consequence" value="{{ old('tip_or_consequence') }}" placeholder="Contoh: Menghindari cedera kepala akibat benda jatuh."
                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route('admin.rules.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800">Batal</a>
            <button type="submit" class="px-6 py-2.5 bg-[#0084f8] hover:bg-[#0070d6] text-white text-xs font-bold rounded-xl shadow-md transition">
                Simpan Pedoman Baru
            </button>
        </div>
    </form>

</div>
@endsection

