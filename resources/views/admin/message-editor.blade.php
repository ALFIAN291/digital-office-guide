@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0084f8]">Dashboard</a>
                <span>/</span>
                <span class="text-[#0f2e54]">Edit Pesan Manajemen</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0f2e54] tracking-tight">Editor Sambutan Manajemen</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Edit teks kartu <i>"A Message from Management"</i> yang berada di halaman beranda</p>
        </div>
        <div>
            <a href="{{ route('guide.message') }}" target="_blank" class="px-4 py-2 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-xs font-bold rounded-xl shadow-xs transition flex items-center gap-1.5">
                <span>Lihat Halaman Pesan ↗</span>
            </a>
        </div>
    </div>

    <!-- Main Form -->
    <form action="{{ route('admin.message.update') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-xs space-y-5">
        @csrf

        <!-- Photo & Preview -->
        <div>
            <label class="block text-xs font-bold text-slate-700 mb-2">Foto Workspace / Latar Pesan Manajemen:</label>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <div class="w-full sm:w-48 h-28 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shrink-0">
                    <img src="{{ office_image($message->image_path, 'images/management-office.jpg') }}" alt="Preview" class="w-full h-full object-cover">
                </div>
                <div class="space-y-1.5">
                    <input type="file" name="image_file" accept="image/*" class="text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sky-50 file:text-[#0084f8] hover:file:bg-sky-100 cursor-pointer">
                    <p class="text-[11px] text-slate-400">Pilih foto kantor/manajemen baru jika ingin mengganti tampilan kartu (JPG, PNG, WebP maks 5MB).</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Judul Kartu Sambutan:</label>
                <input type="text" name="title" value="{{ old('title', $message->title ?? 'A Message from Management') }}" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden font-bold">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Slogan Kutipan (Quote):</label>
                <input type="text" name="quote" value="{{ old('quote', $message->quote ?? 'Moving Together. Working Better. Growing Stronger.') }}"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Pimpinan / Dewan Pengirim:</label>
                <input type="text" name="sender_name" value="{{ old('sender_name', $message->sender_name ?? 'Board of Management Akebono Brake Astra Indonesia') }}" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Jabatan / Role Pengirim:</label>
                <input type="text" name="sender_role" value="{{ old('sender_role', $message->sender_role ?? 'President Director & Executive Committee') }}" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden">
            </div>
        </div>

        <!-- Summary (Displayed on Home Card) -->
        <div class="p-4 bg-sky-50/70 rounded-2xl border border-sky-100 space-y-1.5">
            <div class="flex items-center justify-between">
                <label class="block text-xs font-extrabold text-[#0b3c6d]">
                    Teks Ringkasan Kartu di Beranda (Summary):
                </label>
                <span class="text-[10px] bg-white px-2 py-0.5 rounded font-bold text-[#0084f8]">Tampil di Kartu Depan</span>
            </div>
            <textarea name="summary" rows="3" required
                      class="w-full px-3.5 py-2.5 bg-white rounded-xl border border-sky-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden text-slate-700 leading-relaxed">{{ old('summary', $message->summary) }}</textarea>
            <p class="text-[11px] text-slate-500">Paragraf ini adalah teks yang langsung terbaca pada kartu di halaman beranda.</p>
        </div>

        <!-- Model Tampilan & Ketebalan Pesan Manajemen di Beranda -->
        <div class="p-5 bg-sky-50/70 rounded-2xl border border-sky-100 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <label class="block text-xs font-extrabold text-[#0b3c6d]">
                        Model Tampilan Pesan di Halaman Beranda:
                    </label>
                    <p class="text-[11px] text-slate-500">Pilih apakah pesan tampil sebagai popup hemat tempat atau kartu penuh</p>
                </div>
                <span class="text-[10px] bg-white px-2 py-0.5 rounded font-bold text-[#0084f8]">Tampilan Beranda</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <label class="relative flex items-start gap-3 p-3.5 rounded-xl border cursor-pointer transition {{ old('message_display_mode', $settings->message_display_mode ?? 'popup') === 'popup' ? 'bg-white border-[#0084f8] shadow-xs ring-2 ring-[#0084f8]/20' : 'bg-white/80 border-slate-200 hover:bg-white' }}">
                    <input type="radio" name="message_display_mode" value="popup" {{ old('message_display_mode', $settings->message_display_mode ?? 'popup') === 'popup' ? 'checked' : '' }} class="mt-0.5 text-[#0084f8] focus:ring-[#0084f8]">
                    <div>
                        <div class="text-xs font-extrabold text-slate-800 flex items-center gap-1.5">
                            <span>💬 Mode Popup / Banner Ramping</span>
                            <span class="text-[10px] bg-emerald-100 text-emerald-700 px-1.5 py-0.2 rounded font-bold">Hemat Tempat</span>
                        </div>
                        <div class="text-[11px] text-slate-500 mt-0.5 leading-relaxed">
                            Hanya baris ramping di beranda. Begitu diklik, pesan terbuka penuh dalam jendela popup modal.
                        </div>
                    </div>
                </label>

                <label class="relative flex items-start gap-3 p-3.5 rounded-xl border cursor-pointer transition {{ old('message_display_mode', $settings->message_display_mode ?? 'popup') === 'card' ? 'bg-white border-[#0084f8] shadow-xs ring-2 ring-[#0084f8]/20' : 'bg-white/80 border-slate-200 hover:bg-white' }}">
                    <input type="radio" name="message_display_mode" value="card" {{ old('message_display_mode', $settings->message_display_mode ?? 'popup') === 'card' ? 'checked' : '' }} class="mt-0.5 text-[#0084f8] focus:ring-[#0084f8]">
                    <div>
                        <div class="text-xs font-extrabold text-slate-800">
                            🗂️ Mode Kartu Beranda Penuh
                        </div>
                        <div class="text-[11px] text-slate-500 mt-0.5 leading-relaxed">
                            Tampilkan sebagai kartu 2 kolom berdampingan di halaman beranda.
                        </div>
                    </div>
                </label>
            </div>

            <!-- Auto-Popup Checkbox -->
            <div class="pt-3 border-t border-sky-100 flex items-center gap-3">
                <input type="checkbox" id="message_auto_popup" name="message_auto_popup" value="1" {{ old('message_auto_popup', $settings->message_auto_popup ?? false) ? 'checked' : '' }}
                       class="w-4 h-4 text-[#0084f8] border-slate-300 rounded focus:ring-[#0084f8] cursor-pointer">
                <label for="message_auto_popup" class="text-xs text-slate-700 font-semibold cursor-pointer">
                    Otomatis tampilkan popup sambutan saat pengunjung pertama kali membuka web.
                </label>
            </div>

            <!-- Ukuran / Ketebalan Kartu di Beranda (Jika Memilih Mode Kartu) -->
            <div class="pt-3 border-t border-sky-100 space-y-2">
                <div class="text-[11px] font-bold text-slate-700">
                    Ukuran Ketebalan Kartu (Berlaku jika memilih Mode Kartu):
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <label class="relative flex items-center gap-2.5 p-2.5 rounded-xl border cursor-pointer transition {{ old('message_height', $settings->message_height ?? 'pendek') === 'pendek' ? 'bg-white border-[#0084f8] shadow-xs ring-2 ring-[#0084f8]/20' : 'bg-white/80 border-slate-200 hover:bg-white' }}">
                        <input type="radio" name="message_height" value="pendek" {{ old('message_height', $settings->message_height ?? 'pendek') === 'pendek' ? 'checked' : '' }} class="text-[#0084f8] focus:ring-[#0084f8]">
                        <div>
                            <div class="text-xs font-extrabold text-slate-800">Pendek</div>
                            <div class="text-[10px] text-slate-500">Ramping, teks ringkas 2 baris</div>
                        </div>
                    </label>

                    <label class="relative flex items-center gap-2.5 p-2.5 rounded-xl border cursor-pointer transition {{ old('message_height', $settings->message_height ?? 'pendek') === 'sedang' ? 'bg-white border-[#0084f8] shadow-xs ring-2 ring-[#0084f8]/20' : 'bg-white/80 border-slate-200 hover:bg-white' }}">
                        <input type="radio" name="message_height" value="sedang" {{ old('message_height', $settings->message_height ?? 'pendek') === 'sedang' ? 'checked' : '' }} class="text-[#0084f8] focus:ring-[#0084f8]">
                        <div>
                            <div class="text-xs font-extrabold text-slate-800">Sedang</div>
                            <div class="text-[10px] text-slate-500">Standar proporsional</div>
                        </div>
                    </label>

                    <label class="relative flex items-center gap-2.5 p-2.5 rounded-xl border cursor-pointer transition {{ old('message_height', $settings->message_height ?? 'pendek') === 'besar' ? 'bg-white border-[#0084f8] shadow-xs ring-2 ring-[#0084f8]/20' : 'bg-white/80 border-slate-200 hover:bg-white' }}">
                        <input type="radio" name="message_height" value="besar" {{ old('message_height', $settings->message_height ?? 'pendek') === 'besar' ? 'checked' : '' }} class="text-[#0084f8] focus:ring-[#0084f8]">
                        <div>
                            <div class="text-xs font-extrabold text-slate-800">Besar</div>
                            <div class="text-[10px] text-slate-500">Lega & teks lengkap</div>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Full Content -->
        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">
                Isi Lengkap Sambutan Manajemen (Tampil Saat Tombol "Read Message" Diklik):
            </label>
            <textarea name="content" rows="8" required
                      class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs sm:text-sm focus:border-[#0084f8] focus:outline-hidden font-normal text-slate-700 leading-relaxed">{{ old('content', $message->content) }}</textarea>
        </div>

        <!-- Save Button -->
        <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
            <button type="submit" class="px-6 py-2.5 bg-[#0084f8] hover:bg-[#0070d6] text-white text-xs sm:text-sm font-bold rounded-xl shadow-md transition flex items-center gap-1.5">
                <span>💾 Simpan Perubahan Pesan</span>
            </button>
        </div>

    </form>

</div>
@endsection

