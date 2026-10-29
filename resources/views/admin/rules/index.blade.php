@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0084f8]">Dashboard</a>
                <span>/</span>
                <span class="text-[#0f2e54]">Dos & Don'ts</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0f2e54] tracking-tight">Kelola Pedoman Dos & Don'ts</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Setiap pedoman merupakan satu kesatuan kartu: <b>Foto Area/Aktivitas</b> + <b>Sisi Kiri (✓ DO)</b> + <b>Sisi Kanan (✕ DON'T)</b>
            </p>
        </div>
        <a href="{{ route('admin.rules.create') }}" class="px-4 py-2.5 bg-[#0084f8] hover:bg-[#0070d6] text-white text-xs font-bold rounded-xl shadow-xs transition flex items-center gap-1.5 w-fit shrink-0">
            <span>+ Tambah Pasangan Aturan Baru</span>
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs sm:text-sm font-semibold flex items-center gap-2 shadow-xs">
            <span class="text-emerald-600 text-base">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Info Banner -->
    <div class="bg-sky-50 border border-sky-100 p-4 rounded-2xl flex items-start gap-3">
        <span class="text-sky-600 text-lg">💡</span>
        <div class="text-xs text-sky-950 leading-relaxed">
            <b>Panduan Tampilan Berpasangan:</b> Pada halaman publik (<code>/dos-and-donts</code>), setiap kartu menyandingkan anjuran/kewajiban (<b>✓ DO</b> hijau) dan larangan/hindari (<b>✕ DON'T</b> merah) dalam satu baris kartu yang sama lengkap dengan foto situasi. Perubahan yang Anda simpan di sini akan langsung tampil secara real-time.
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        <th class="py-3.5 px-4 text-center w-20">Foto</th>
                        <th class="py-3.5 px-4 w-32">Kategori</th>
                        <th class="py-3.5 px-4">✓ Anjuran (DO)</th>
                        <th class="py-3.5 px-4">✕ Larangan (DON'T)</th>
                        <th class="py-3.5 px-3 text-center w-20">Urutan</th>
                        <th class="py-3.5 px-4 sm:px-6 text-right w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($rules as $rule)
                        <tr class="hover:bg-slate-50/60 transition">
                            <!-- Foto Thumbnail -->
                            <td class="py-3.5 px-4 text-center">
                                <div class="w-14 h-10 rounded-lg overflow-hidden bg-slate-100 mx-auto border border-slate-200/70 shadow-xs">
                                    <img src="{{ office_image($rule->image_path, 'images/hero-office.jpg') }}" 
                                         alt="Foto Pedoman" 
                                         class="w-full h-full object-cover">
                                </div>
                            </td>

                            <!-- Kategori -->
                            <td class="py-3.5 px-4">
                                <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase bg-slate-100 text-slate-700 border border-slate-200/60 whitespace-nowrap">
                                    {{ $rule->category }}
                                </span>
                            </td>

                            <!-- DO (Hijau) -->
                            <td class="py-3.5 px-4">
                                <div class="p-2.5 rounded-xl bg-emerald-50/80 border border-emerald-100">
                                    <div class="text-[10px] font-extrabold uppercase text-emerald-700 flex items-center gap-1 mb-0.5">
                                        <span>✓</span> DO
                                    </div>
                                    <div class="font-bold text-slate-800 text-xs">{{ $rule->do_text ?: ($rule->title ?: '-') }}</div>
                                    @if($rule->do_sub || $rule->description)
                                        <div class="text-[11px] text-slate-600 mt-0.5 line-clamp-2">
                                            {{ $rule->do_sub ?: $rule->description }}
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- DON'T (Merah) -->
                            <td class="py-3.5 px-4">
                                <div class="p-2.5 rounded-xl bg-rose-50/80 border border-rose-100">
                                    <div class="text-[10px] font-extrabold uppercase text-rose-600 flex items-center gap-1 mb-0.5">
                                        <span>✕</span> DON'T
                                    </div>
                                    <div class="font-bold text-slate-800 text-xs">{{ $rule->dont_text ?: '-' }}</div>
                                    @if($rule->dont_sub)
                                        <div class="text-[11px] text-slate-600 mt-0.5 line-clamp-2">
                                            {{ $rule->dont_sub }}
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Sort Order -->
                            <td class="py-3.5 px-3 text-center">
                                <span class="px-2 py-0.5 rounded-md text-[11px] font-bold bg-slate-100 text-slate-600">
                                    {{ $rule->sort_order }}
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="py-3.5 px-4 sm:px-6 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.rules.edit', $rule->id) }}" 
                                       class="px-2.5 py-1 text-xs font-bold text-[#0084f8] hover:bg-sky-50 rounded-lg transition border border-sky-100">
                                        ✏️ Edit
                                    </a>
                                    <form action="{{ route('admin.rules.delete', $rule->id) }}" method="POST" onsubmit="return confirm('Hapus pasangan pedoman ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="px-2.5 py-1 text-xs font-bold text-rose-600 hover:bg-rose-50 rounded-lg transition border border-rose-100">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                Belum ada pedoman tersimpan di database.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
