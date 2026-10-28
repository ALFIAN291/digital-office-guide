@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0084f8]">Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.facilities.index') }}" class="hover:text-[#0084f8]">Fasilitas</a>
        <span>/</span>
        <span class="text-[#0f2e54]">Tambah Fasilitas Baru</span>
    </div>

    <h1 class="text-2xl font-extrabold text-[#0f2e54]">Tambah Fasilitas Kantor Baru</h1>

    <form action="{{ route('admin.facilities.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-xs space-y-5">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Fasilitas / Ruangan:</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Ruang Rapat Lotus"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Kategori:</label>
                <select name="category" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
                    <option value="workspace">Workspace (Area Kerja)</option>
                    <option value="meeting">Meeting (Ruang Rapat)</option>
                    <option value="dining">Dining (Kantin & Cafeteria)</option>
                    <option value="wellness">Wellness (Musholla / Relaksasi / Laktasi)</option>
                    <option value="service">Service (Parkir / Lobi / Layanan)</option>
                    <option value="safety">Safety (Klinik / P3K / K3)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Lantai / Area:</label>
                <select name="floor" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
                    <option value="Lantai 1">Lantai 1</option>
                    <option value="Lantai 2">Lantai 2</option>
                    <option value="Plant Area">Plant Area (Pabrik)</option>
                    <option value="Outdoor">Outdoor / Halaman</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Detail Lokasi Spesifik:</label>
                <input type="text" name="location_detail" value="{{ old('location_detail') }}" placeholder="Contoh: Gedung Utama Lt. 2 Sayap Barat"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Kapasitas:</label>
                <input type="text" name="capacity" value="{{ old('capacity') }}" placeholder="Contoh: 15 Orang"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Jam Operasional:</label>
                <input type="text" name="operating_hours" value="{{ old('operating_hours', '07:30 - 17:30 WIB') }}"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Foto Fasilitas:</label>
            <input type="file" name="image_file" accept="image/*" class="text-xs text-slate-500">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi:</label>
            <textarea name="description" rows="3" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Panduan & Aturan Penggunaan:</label>
            <textarea name="guidelines" rows="2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">{{ old('guidelines') }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Fasilitas & Perlengkapan (Pisahkan dengan koma):</label>
            <input type="text" name="amenities_text" value="{{ old('amenities_text') }}" placeholder="Contoh: Wi-Fi, Proyektor, AC, Whiteboard"
                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
        </div>

        <div class="flex items-center gap-2 pt-2">
            <input type="checkbox" name="is_featured" value="1" id="is_featured" class="w-4 h-4 rounded text-[#0084f8]">
            <label for="is_featured" class="text-xs font-bold text-slate-700 cursor-pointer">Tandai sebagai Fasilitas Unggulan (Featured)</label>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route('admin.facilities.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800">Batal</a>
            <button type="submit" class="px-6 py-2.5 bg-[#0084f8] hover:bg-[#0070d6] text-white text-xs font-bold rounded-xl shadow-md transition">
                Simpan Fasilitas Baru
            </button>
        </div>
    </form>

</div>
@endsection

