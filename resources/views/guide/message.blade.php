@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 pt-5 space-y-6">

    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
        <a href="{{ route('guide.index') }}" class="hover:text-[#0084f8]">Beranda</a>
        <span>/</span>
        <span class="text-[#0f2e54]">Pesan Manajemen</span>
    </div>

    <!-- Main Message Container -->
    <div class="bg-white rounded-3xl soft-shadow border border-slate-200/80 overflow-hidden">
        <!-- Hero Header -->
        <div class="relative h-64 sm:h-80 w-full overflow-hidden">
            <img src="{{ asset('images/management-office.jpg') }}" alt="Karawang Office" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-900/30 to-transparent"></div>
            <div class="absolute bottom-6 left-6 right-6 text-white">
                <span class="px-3 py-1 rounded-full bg-[#0084f8] text-xs font-bold text-white uppercase tracking-wider mb-2 inline-block">
                    Official Statement
                </span>
                <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight">
                    {{ $message->title }}
                </h1>
                <p class="text-xs sm:text-sm text-sky-200 mt-1">
                    {{ $message->sender_role }}
                </p>
            </div>
        </div>

        <!-- Content Body -->
        <div class="p-6 sm:p-10 space-y-6">
            <!-- Quote Block -->
            <div class="p-5 sm:p-6 rounded-2xl bg-sky-50/80 border-l-4 border-[#0084f8] flex items-start gap-4">
                <div class="text-[#0084f8] text-3xl font-serif">“</div>
                <div>
                    <p class="text-sm sm:text-base font-bold text-[#0b3c6d] leading-relaxed">
                        {{ $message->summary }}
                    </p>
                    <div class="text-xs text-slate-500 font-semibold mt-2">
                        {{ $message->sender_name }}
                    </div>
                </div>
            </div>

            <!-- Full Article -->
            <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed text-sm sm:text-base space-y-4">
                {!! nl2br(e($message->content)) !!}
            </div>

            <!-- 3 Core Pillars -->
            <div class="pt-6 border-t border-slate-200/80">
                <h3 class="text-lg font-extrabold text-[#0f2e54] mb-4">Nilai Utama di Kantor & Pabrik Karawang</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="w-10 h-10 rounded-xl bg-sky-100 text-[#0084f8] flex items-center justify-center font-bold text-lg mb-3">
                            🛡️
                        </div>
                        <h4 class="font-bold text-slate-800 text-sm">Zero Accident Safety</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            Keselamatan tanpa kompromi melalui kepatuhan APD dan jalur hijau.
                        </p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-lg mb-3">
                            🤝
                        </div>
                        <h4 class="font-bold text-slate-800 text-sm">Collaborative Culture</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            Kerjasama lintas divisi yang terbuka dan saling mendukung inovasi.
                        </p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-lg mb-3">
                            🌱
                        </div>
                        <h4 class="font-bold text-slate-800 text-sm">Green & 5S Workplace</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            Penerapan 5R secara konsisten, efisiensi energi, dan pelestarian lingkungan.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer Sign-off -->
            <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <p class="text-xs text-slate-400">Diterbitkan oleh:</p>
                    <p class="text-sm font-bold text-slate-800">{{ $message->sender_name }}</p>
                    <p class="text-xs text-slate-500">{{ $message->sender_role }}</p>
                </div>
                <a href="{{ route('guide.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-full transition">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

