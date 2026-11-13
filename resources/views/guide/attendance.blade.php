@extends('layouts.app')

@section('content')
<div class="max-w-5xl lg:max-w-none mx-auto px-4 sm:px-6 pt-5 space-y-6">

    <div>
        <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-2">
            <a href="{{ route('guide.index') }}" class="hover:text-[#0084f8]">Beranda</a>
            <span>/</span>
            <span class="text-[#0f2e54]">Attendance Guide</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0f2e54] tracking-tight">Attendance & Working Hours Guide</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Panduan absensi RFID / Face Recognition di gerbang akses, jam kerja Office & Shift Plant, serta pengajuan izin</p>
    </div>

    <!-- Working Hours Schedule Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white rounded-3xl soft-shadow border border-slate-200/80 p-5 sm:p-6 space-y-3">
            <div class="flex items-center justify-between">
                <span class="px-2.5 py-1 rounded-full bg-sky-100 text-[#0084f8] text-xs font-bold">Main Office (Non-Shift)</span>
                <span class="text-xs font-bold text-slate-400">Senin – Jumat</span>
            </div>
            <div class="text-2xl font-black text-[#0f2e54]">07:30 – 16:30 WIB</div>
            <div class="text-xs text-slate-600 space-y-1.5 pt-2 border-t border-slate-100">
                <p>• <strong>Jam Istirahat:</strong> 11:45 – 12:45 WIB (Jumat: 11:30 – 13:00 WIB)</p>
                <p>• <strong>Toleransi Check-In:</strong> Pastikan tap ID / Face Gate sebelum pukul 07:30 WIB.</p>
                <p>• <strong>Akses Lantai 2:</strong> Menggunakan kartu RFID pegawai di pintu lift & tangga darurat.</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl soft-shadow border border-slate-200/80 p-5 sm:p-6 space-y-3">
            <div class="flex items-center justify-between">
                <span class="px-2.5 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">Plant 1 & Plant 2 (3 Shift)</span>
                <span class="text-xs font-bold text-slate-400">24 Jam Operasional</span>
            </div>
            <div class="grid grid-cols-3 gap-2 pt-1 text-center">
                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200">
                    <div class="text-[10px] font-bold text-slate-400">SHIFT 1</div>
                    <div class="text-xs font-extrabold text-[#0f2e54] mt-0.5">07:00 - 15:30</div>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200">
                    <div class="text-[10px] font-bold text-slate-400">SHIFT 2</div>
                    <div class="text-xs font-extrabold text-[#0f2e54] mt-0.5">15:00 - 23:30</div>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200">
                    <div class="text-[10px] font-bold text-slate-400">SHIFT 3</div>
                    <div class="text-xs font-extrabold text-[#0f2e54] mt-0.5">23:00 - 07:30</div>
                </div>
            </div>
            <p class="text-xs text-slate-600 pt-1">Pergantian shift wajib melakukan handover 5S & briefing keselamatan (Kiken Yochi) selama 10 menit sebelum memulai lini produksi.</p>
        </div>
    </div>

    <!-- Step-by-step Attendance Gate & Portal Guide -->
    <div class="bg-white rounded-3xl soft-shadow border border-slate-200/80 p-5 sm:p-7 space-y-4">
        <h2 class="text-base sm:text-lg font-extrabold text-[#0f2e54]">Prosedur Check-In, Izin & Lembur (HR Portal)</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 text-xs">
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1.5">
                <span class="w-7 h-7 rounded-full bg-[#0084f8] text-white font-extrabold inline-flex items-center justify-center">1</span>
                <div class="font-extrabold text-[#0f2e54]">Tap ID / Face Recognition Gate</div>
                <p class="text-slate-600 leading-relaxed">Lakukan tap kartu karyawan atau pindai wajah di gerbang Lobi Barat / Pos Plant saat datang dan sebelum pulang.</p>
            </div>
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1.5">
                <span class="w-7 h-7 rounded-full bg-[#0084f8] text-white font-extrabold inline-flex items-center justify-center">2</span>
                <div class="font-extrabold text-[#0f2e54]">Pengajuan Cuti / Koreksi Absen</div>
                <p class="text-slate-600 leading-relaxed">Ajukan cuti tahunan, izin sakit, atau koreksi lupa tap melalui Company SSO / HRIS paling lambat H+2 kerja dengan persetujuan atasan.</p>
            </div>
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1.5">
                <span class="w-7 h-7 rounded-full bg-[#0084f8] text-white font-extrabold inline-flex items-center justify-center">3</span>
                <div class="font-extrabold text-[#0f2e54]">Kartu Hilang / Rusak</div>
                <p class="text-slate-600 leading-relaxed">Segera laporkan ke HRD & Security Pos Utama untuk pemblokiran akses kartu lama dan penerbitan ID Card pengganti.</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3 pt-2 border-t border-slate-100">
            <a href="{{ route('guide.support') }}" class="px-5 py-2.5 bg-[#0084f8] hover:bg-[#0070d6] text-white text-xs font-bold rounded-full shadow-sm transition">
                Hubungi HR / Helpdesk Absensi →
            </a>
            <a href="{{ route('guide.facilities') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-full transition">
                Lihat Info Parkir & Fasilitas →
            </a>
        </div>
    </div>
</div>
@endsection
