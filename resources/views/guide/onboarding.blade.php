@extends('layouts.app')

@section('content')
@php
    $dbScannedProfile = isset($scannedDesk) && $scannedDesk ? [
        'name' => $scannedDesk->name,
        'dept' => $scannedDesk->department,
        'team' => $scannedDesk->sub_team ?? '',
        'desk' => $scannedDesk->desk_number,
        'floor' => $scannedDesk->floor,
        'area' => $scannedDesk->area,
    ] : null;
@endphp

<div class="max-w-5xl mx-auto px-4 sm:px-6 pt-3 pb-12 space-y-6"
     x-data="{
        deskProfile: {{ Js::from($dbScannedProfile) }},
        init() {
            localStorage.removeItem('akebono_desk_profile');
            if (this.deskProfile) {
                localStorage.setItem('akebono_scanned_desk_v2', JSON.stringify(this.deskProfile));
            } else {
                try {
                    const raw = localStorage.getItem('akebono_scanned_desk_v2');
                    if (raw) {
                        const parsed = JSON.parse(raw);
                        if (parsed && parsed.name && parsed.name !== 'Bran') {
                            this.deskProfile = parsed;
                        }
                    }
                } catch (e) {}
            }
        }
     }">

    <!-- Breadcrumb & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                <a href="{{ route('guide.index') }}" class="hover:text-[#0084f8] font-medium">Beranda</a>
                <span>/</span>
                <span class="text-slate-800 font-bold">Onboarding Journey</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0f2e54] tracking-tight">
                Your Onboarding Journey
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Panduan orientasi karyawan & daftar periksa fasilitas kantor baru Akebono Karawang
            </p>
        </div>

        @auth
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.desks.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-[#0f2e54] hover:bg-[#163d6e] text-white text-xs font-extrabold shadow-sm transition">
                <span>🪪</span>
                <span>Kelola & Print Desk QR di Admin →</span>
            </a>
        </div>
        @endauth
    </div>

    <!-- Personalized Employee Desk Card Banner (if scanned via QR) -->
    <template x-if="deskProfile">
        <div class="bg-gradient-to-r from-[#0f2e54] via-[#133b6e] to-[#0084f8] rounded-3xl p-5 sm:p-6 text-white shadow-md flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-white/15 text-sky-200 text-[10px] font-extrabold uppercase tracking-wider">
                    <span>🪪</span>
                    <span>Personalized Desk Pass</span>
                </div>
                <h2 class="text-xl sm:text-2xl font-black" x-text="'Welcome, ' + deskProfile.name + ' 👋'"></h2>
                <p class="text-xs sm:text-sm text-sky-100" x-text="deskProfile.dept + (deskProfile.team ? ' • ' + deskProfile.team : '')"></p>
            </div>
            <div class="grid grid-cols-3 gap-3 bg-white/10 backdrop-blur-xs rounded-2xl p-3.5 border border-white/15 text-center shrink-0">
                <div class="px-2">
                    <div class="text-[10px] text-sky-200 uppercase font-bold">Desk</div>
                    <div class="text-sm font-black" x-text="deskProfile.desk"></div>
                </div>
                <div class="px-2 border-x border-white/15">
                    <div class="text-[10px] text-sky-200 uppercase font-bold">Floor</div>
                    <div class="text-sm font-black" x-text="deskProfile.floor"></div>
                </div>
                <div class="px-2">
                    <div class="text-[10px] text-sky-200 uppercase font-bold">Area</div>
                    <div class="text-sm font-black" x-text="deskProfile.area"></div>
                </div>
            </div>
        </div>
    </template>

    <!-- 4-Step QR Onboarding Flow Explanation -->
    <div class="bg-white rounded-3xl border border-slate-200/90 p-5 sm:p-6 soft-shadow">
        <h3 class="text-sm font-extrabold text-[#0f2e54] mb-3.5">Cara Kerja QR Desk Onboarding (4 Langkah)</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70">
                <div class="w-7 h-7 rounded-full bg-[#0084f8] text-white text-xs font-extrabold flex items-center justify-center mb-2">1</div>
                <div class="text-xs font-extrabold text-[#0f2e54]">Scan QR Code</div>
                <p class="text-[11px] text-slate-500 mt-0.5 leading-snug">Scan QR Tent Card yang terpasang di meja kerja Anda.</p>
            </div>
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70">
                <div class="w-7 h-7 rounded-full bg-[#0084f8] text-white text-xs font-extrabold flex items-center justify-center mb-2">2</div>
                <div class="text-xs font-extrabold text-[#0f2e54]">Personalized Page</div>
                <p class="text-[11px] text-slate-500 mt-0.5 leading-snug">Portal menyapa nama, nomor meja, lantai, & departemen Anda.</p>
            </div>
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70">
                <div class="w-7 h-7 rounded-full bg-[#0084f8] text-white text-xs font-extrabold flex items-center justify-center mb-2">3</div>
                <div class="text-xs font-extrabold text-[#0f2e54]">Explore Content</div>
                <p class="text-[11px] text-slate-500 mt-0.5 leading-snug">Checklist interaktif 01–06 melacak progres orientasi Anda.</p>
            </div>
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70">
                <div class="w-7 h-7 rounded-full bg-[#0084f8] text-white text-xs font-extrabold flex items-center justify-center mb-2">4</div>
                <div class="text-xs font-extrabold text-[#0f2e54]">Find Your Way</div>
                <p class="text-[11px] text-slate-500 mt-0.5 leading-snug">Navigasi denah interaktif 2D, ruang rapat, kantin, & K3.</p>
            </div>
        </div>
    </div>

    <!-- Interactive 6-Step Onboarding Journey Checklist -->
    <div class="bg-white rounded-3xl border border-slate-200/90 p-5 sm:p-6 soft-shadow space-y-4">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h3 class="text-base font-extrabold text-[#0f2e54]">Checklist Orientasi Karyawan (01 – 06)</h3>
                <p class="text-xs text-slate-500">Klik tahapan untuk mengunjungi halaman atau tandai selesai</p>
            </div>
            <span class="px-3 py-1 rounded-full bg-sky-50 text-[#0084f8] border border-sky-200 text-xs font-extrabold"
                  x-text="Math.min(100, Math.round((completedSteps.length / 6) * 100)) + '% Selesai'"></span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($onboardingSteps as $step)
                <div class="p-4 rounded-2xl border border-slate-200/80 bg-slate-50/70 flex flex-col justify-between gap-3">
                    <div class="flex items-start justify-between gap-2.5">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <span class="w-8 h-8 rounded-xl flex items-center justify-center text-xs font-extrabold shrink-0 transition"
                                  :class="isMilestoneDone('{{ $step['key'] }}') ? 'bg-emerald-500 text-white' : 'bg-[#0084f8] text-white'">
                                {{ $step['number'] }}
                            </span>
                            <div class="min-w-0">
                                <div class="text-xs font-extrabold text-[#0f2e54] truncate">{{ $step['title'] }}</div>
                                <div class="text-[11px] text-slate-500 truncate">{{ $step['subtitle'] }}</div>
                            </div>
                        </div>
                        <button type="button" @click="toggleStep('{{ $step['key'] }}')"
                                class="px-2 py-1 rounded-lg text-[10px] font-bold border transition cursor-pointer shrink-0"
                                :class="isMilestoneDone('{{ $step['key'] }}') ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-white text-slate-500 border-slate-200'">
                            <span x-text="isMilestoneDone('{{ $step['key'] }}') ? '✓ Done' : 'Tandai'"></span>
                        </button>
                    </div>
                    <a href="{{ route($step['route']) }}"
                       class="w-full py-2 px-3 rounded-xl bg-white hover:bg-sky-50 border border-slate-200 text-[#0084f8] text-xs font-bold text-center transition">
                        Buka Panduan →
                    </a>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
