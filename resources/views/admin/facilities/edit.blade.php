@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0084f8]">Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.facilities.index') }}" class="hover:text-[#0084f8]">Fasilitas</a>
        <span>/</span>
        <span class="text-[#0f2e54]">Edit: {{ $facility->name }}</span>
    </div>

    <h1 class="text-2xl font-extrabold text-[#0f2e54]">Edit Fasilitas: {{ $facility->name }}</h1>

    <form action="{{ route('admin.facilities.update', $facility->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-xs space-y-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Fasilitas / Ruangan:</label>
                <input type="text" name="name" value="{{ old('name', $facility->name) }}" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Kategori:</label>
                <select name="category" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
                    <option value="workspace" {{ $facility->category === 'workspace' ? 'selected' : '' }}>Workspace (Area Kerja)</option>
                    <option value="meeting" {{ $facility->category === 'meeting' ? 'selected' : '' }}>Meeting (Ruang Rapat)</option>
                    <option value="dining" {{ $facility->category === 'dining' ? 'selected' : '' }}>Dining (Kantin & Cafeteria)</option>
                    <option value="wellness" {{ $facility->category === 'wellness' ? 'selected' : '' }}>Wellness (Musholla / Relaksasi / Laktasi)</option>
                    <option value="service" {{ $facility->category === 'service' ? 'selected' : '' }}>Service (Parkir / Lobi / Layanan)</option>
                    <option value="safety" {{ $facility->category === 'safety' ? 'selected' : '' }}>Safety (Klinik / P3K / K3)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Lantai / Area:</label>
                <select name="floor" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
                    <option value="Lantai 1" {{ $facility->floor === 'Lantai 1' ? 'selected' : '' }}>Lantai 1</option>
                    <option value="Lantai 2" {{ $facility->floor === 'Lantai 2' ? 'selected' : '' }}>Lantai 2</option>
                    <option value="Plant Area" {{ $facility->floor === 'Plant Area' ? 'selected' : '' }}>Plant Area (Pabrik)</option>
                    <option value="Outdoor" {{ $facility->floor === 'Outdoor' ? 'selected' : '' }}>Outdoor / Halaman</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Detail Lokasi Spesifik:</label>
                <input type="text" name="location_detail" value="{{ old('location_detail', $facility->location_detail) }}"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Kapasitas:</label>
                <input type="text" name="capacity" value="{{ old('capacity', $facility->capacity) }}"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Jam Operasional:</label>
                <input type="text" name="operating_hours" value="{{ old('operating_hours', $facility->operating_hours) }}"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Foto Saat Ini & Penggantian:</label>
            @if($facility->image_path)
                <div class="mb-2 w-32 h-20 rounded-xl overflow-hidden border">
                    <img src="{{ asset($facility->image_path) }}" alt="" class="w-full h-full object-cover">
                </div>
            @endif
            <input type="file" name="image_file" accept="image/*" class="text-xs text-slate-500">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi:</label>
            <textarea name="description" rows="3" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">{{ old('description', $facility->description) }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Panduan & Aturan Penggunaan:</label>
            <textarea name="guidelines" rows="2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">{{ old('guidelines', $facility->guidelines) }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Fasilitas & Perlengkapan (Pisahkan dengan koma):</label>
            <input type="text" name="amenities_text" value="{{ old('amenities_text', is_array($facility->amenities) ? implode(', ', $facility->amenities) : '') }}"
                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
        </div>

        <div class="flex items-center gap-2 pt-2">
            <input type="checkbox" name="is_featured" value="1" id="is_featured" class="w-4 h-4 rounded text-[#0084f8]" {{ $facility->is_featured ? 'checked' : '' }}>
            <label for="is_featured" class="text-xs font-bold text-slate-700 cursor-pointer">Tandai sebagai Fasilitas Unggulan (Featured)</label>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route('admin.facilities.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800">Batal</a>
            <button type="submit" class="px-6 py-2.5 bg-[#0084f8] hover:bg-[#0070d6] text-white text-xs font-bold rounded-xl shadow-md transition">
                Simpan Perubahan Fasilitas
            </button>
        </div>
    </form>

</div>
@endsection

