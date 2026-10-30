@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0084f8]">Dashboard</a>
        <span>/</span>
        <span class="text-[#0f2e54]">Kontak Darurat (SOS)</span>
    </div>

    <div>
        <h1 class="text-2xl font-extrabold text-[#0f2e54]">Kelola Kontak Darurat & Hotline</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Edit nomor telepon darurat, extension internal, dan lokasi pos tanggap bencana</p>
    </div>

    <div class="space-y-4">
        @foreach($contacts as $contact)
            <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-xs">
                <form action="{{ route('admin.emergency.update', $contact->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Unit #{{ $loop->iteration }}</span>
                        <label class="flex items-center gap-1.5 cursor-pointer text-xs font-bold text-rose-700">
                            <input type="checkbox" name="is_hotline" value="1" {{ $contact->is_hotline ? 'checked' : '' }} class="rounded text-rose-600">
                            <span>Status Siaga 24 Jam</span>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Nama Layanan:</label>
                            <input type="text" name="name" value="{{ old('name', $contact->name) }}" required
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-[#0084f8] focus:outline-hidden font-bold">
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1 flex items-center justify-between">
                                <span>Nomor Telepon & WhatsApp:</span>
                                @if($contact->whatsapp_url !== '#')
                                    <a href="{{ $contact->whatsapp_url }}" target="_blank" rel="noopener noreferrer" class="text-[10px] text-emerald-600 hover:underline font-bold flex items-center gap-1">
                                        <span>Test WA</span>
                                        <span>↗</span>
                                    </a>
                                @endif
                            </label>
                            <input type="text" name="phone" value="{{ old('phone', $contact->phone) }}" required
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-[#0084f8] focus:outline-hidden font-mono font-bold text-rose-600">
                            <span class="text-[10px] text-slate-400 mt-0.5 block">Nomor ini digunakan sekaligus untuk tombol WhatsApp dan panggilan telepon langsung.</span>
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Extension Internal:</label>
                            <input type="text" name="extension" value="{{ old('extension', $contact->extension) }}"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-[#0084f8] focus:outline-hidden">
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Lokasi Pos / Ruangan:</label>
                            <input type="text" name="location" value="{{ old('location', $contact->location) }}"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-[#0084f8] focus:outline-hidden">
                        </div>
                    </div>

                    <div class="text-right pt-2">
                        <button type="submit" class="px-4 py-2 bg-[#0084f8] hover:bg-[#0070d6] text-white text-xs font-bold rounded-xl transition">
                            Simpan Perubahan Unit
                        </button>
                    </div>
                </form>
            </div>
        @endforeach
    </div>

</div>
@endsection

