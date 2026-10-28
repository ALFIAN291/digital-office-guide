@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0084f8]">Dashboard</a>
                <span>/</span>
                <span class="text-[#0f2e54]">Fasilitas</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0f2e54] tracking-tight">Kelola Fasilitas Kantor</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Tambah atau perbarui daftar fasilitas, ruang rapat, kantin, dan musholla</p>
        </div>
        <a href="{{ route('admin.facilities.create') }}" class="px-4 py-2.5 bg-[#0084f8] hover:bg-[#0070d6] text-white text-xs font-bold rounded-xl shadow-xs transition flex items-center gap-1.5 w-fit">
            <span>+ Tambah Fasilitas Baru</span>
        </a>
    </div>

    <!-- Facilities Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        <th class="py-3.5 px-4 sm:px-6">Fasilitas</th>
                        <th class="py-3.5 px-4">Kategori & Lantai</th>
                        <th class="py-3.5 px-4">Kapasitas & Jam</th>
                        <th class="py-3.5 px-4 sm:px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($facilities as $facility)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-3.5 px-4 sm:px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-10 rounded-lg overflow-hidden bg-slate-100 shrink-0 border border-slate-200">
                                        <img src="{{ asset($facility->image_path ?: 'images/facilities-office.jpg') }}" alt="" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 text-sm">{{ $facility->name }}</div>
                                        <div class="text-[11px] text-slate-400 truncate max-w-xs">{{ $facility->location_detail }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded bg-sky-50 text-[#0084f8] font-bold text-[10px] uppercase">{{ $facility->category }}</span>
                                <div class="text-slate-600 font-semibold mt-1">{{ $facility->floor }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                <div>👥 {{ $facility->capacity ?? '-' }}</div>
                                <div class="text-[11px] text-slate-400">🕒 {{ $facility->operating_hours ?? '24 Jam' }}</div>
                            </td>
                            <td class="py-3.5 px-4 sm:px-6 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.facilities.edit', $facility->id) }}" class="p-1.5 text-[#0084f8] hover:bg-sky-50 rounded-lg transition" title="Edit">
                                        ✏️ Edit
                                    </a>
                                    <form action="{{ route('admin.facilities.delete', $facility->id) }}" method="POST" onsubmit="return confirm('Hapus fasilitas ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400">Belum ada fasilitas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

