@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0084f8]">Dashboard</a>
                <span>/</span>
                <span class="text-[#0f2e54]">Dos & Don'ts</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0f2e54] tracking-tight">Kelola Aturan Dos & Don'ts</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Atur pedoman keselamatan kerja (K3), budaya 5S, keamanan informasi, dan etiket kantor</p>
        </div>
        <a href="{{ route('admin.rules.create') }}" class="px-4 py-2.5 bg-[#0084f8] hover:bg-[#0070d6] text-white text-xs font-bold rounded-xl shadow-xs transition flex items-center gap-1.5 w-fit">
            <span>+ Tambah Aturan Baru</span>
        </a>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        <th class="py-3.5 px-4 sm:px-6">Jenis</th>
                        <th class="py-3.5 px-4">Kategori & Judul Aturan</th>
                        <th class="py-3.5 px-4">Konsekuensi / Tips</th>
                        <th class="py-3.5 px-4 sm:px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($rules as $rule)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-3.5 px-4 sm:px-6">
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase {{ $rule->type === 'do' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    {{ $rule->type === 'do' ? '✓ DO' : '✕ DON\'T' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="text-[10px] uppercase font-bold text-slate-400">{{ $rule->category }}</div>
                                <div class="font-bold text-slate-800 text-sm mt-0.5">{{ $rule->title }}</div>
                                <div class="text-[11px] text-slate-500 mt-0.5 line-clamp-1">{{ $rule->description }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600 max-w-xs">
                                <div class="text-[11px] italic truncate">{{ $rule->tip_or_consequence ?? '-' }}</div>
                            </td>
                            <td class="py-3.5 px-4 sm:px-6 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.rules.edit', $rule->id) }}" class="p-1.5 text-[#0084f8] hover:bg-sky-50 rounded-lg transition">
                                        ✏️ Edit
                                    </a>
                                    <form action="{{ route('admin.rules.delete', $rule->id) }}" method="POST" onsubmit="return confirm('Hapus aturan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400">Belum ada aturan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

