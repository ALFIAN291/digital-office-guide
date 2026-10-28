@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 pt-5 space-y-6" 
     x-data="{ 
        currentFloor: '{{ $floor }}', 
        selectedZone: {{ $zones->first() ? json_encode($zones->first()) : 'null' }},
        selectZone(zone) {
            this.selectedZone = zone;
        }
     }">

    <!-- Header & Breadcrumb -->
    <div>
        <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-2">
            <a href="{{ route('guide.index') }}" class="hover:text-[#0084f8]">Beranda</a>
            <span>/</span>
            <span class="text-[#0f2e54]">Denah Kantor (Office Map)</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0f2e54] tracking-tight">Denah Kantor & Pabrik Karawang</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Navigasi interaktif ruangan, ruang rapat, fasilitas, dan jalur evakuasi</p>
            </div>
        </div>
    </div>

    <!-- Floor Selector Tabs -->
    <div class="bg-white rounded-2xl p-1.5 soft-shadow border border-slate-200/80 flex flex-wrap gap-1">
        @foreach($floors as $key => $title)
            <a href="{{ route('guide.map', ['floor' => $key]) }}" 
               class="flex-1 min-w-[130px] py-2.5 px-3 text-center text-xs font-bold rounded-xl transition {{ $floor === $key ? 'bg-[#0084f8] text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                {{ $title }}
            </a>
        @endforeach
    </div>

    <!-- Interactive Map Canvas Card -->
    <div class="bg-white rounded-3xl soft-shadow border border-slate-200/80 overflow-hidden">
        
        <!-- Map Canvas Controls -->
        <div class="p-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">{{ $floor }}</span>
            </div>
            <div class="flex items-center gap-3 text-xs text-slate-500">
                <span class="inline-flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-[#0084f8]"></span> Pin Ruangan</span>
                <span class="inline-flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-rose-500"></span> Evakuasi</span>
            </div>
        </div>

        <!-- SVG Map Container -->
        <div class="relative w-full h-[360px] sm:h-[420px] bg-[#f8fafc] overflow-hidden select-none border-b border-slate-100">
            
            <!-- Floor Plan SVG Grid & Architectural Floor -->
            <svg class="absolute inset-0 w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="30" height="30" patternUnits="userSpaceOnUse">
                        <path d="M 30 0 L 0 0 0 30" fill="none" stroke="#e2e8f0" stroke-width="0.8"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />

                @if($floor === 'Lantai 1')
                    <!-- Outline Building 1 -->
                    <rect x="8%" y="15%" width="84%" height="70%" rx="16" fill="#ffffff" stroke="#cbd5e1" stroke-width="2.5" />
                    <!-- Corridor -->
                    <rect x="12%" y="46%" width="76%" height="10%" fill="#f1f5f9" stroke="#e2e8f0" stroke-dasharray="4" />
                    <!-- Room Blocks -->
                    <rect x="12%" y="18%" width="26%" height="25%" rx="8" fill="#e0f2fe" stroke="#38bdf8" stroke-width="1.5" />
                    <text x="25%" y="31%" font-size="11" font-weight="bold" fill="#0369a1" text-anchor="middle">LOBI UTAMA</text>

                    <rect x="62%" y="18%" width="26%" height="25%" rx="8" fill="#fef3c7" stroke="#fbbf24" stroke-width="1.5" />
                    <text x="75%" y="31%" font-size="11" font-weight="bold" fill="#b45309" text-anchor="middle">KANTIN UTAMA</text>

                    <rect x="36%" y="58%" width="22%" height="24%" rx="8" fill="#f3e8ff" stroke="#c084fc" stroke-width="1.5" />
                    <text x="47%" y="71%" font-size="11" font-weight="bold" fill="#7e22ce" text-anchor="middle">MUSHOLLA</text>

                    <rect x="62%" y="58%" width="26%" height="24%" rx="8" fill="#ffe4e6" stroke="#fb7185" stroke-width="1.5" />
                    <text x="75%" y="71%" font-size="11" font-weight="bold" fill="#be123c" text-anchor="middle">KLINIK / FIRST AID</text>

                    <!-- Green Walkway -->
                    <line x1="8%" y1="51%" x2="92%" y2="51%" stroke="#22c55e" stroke-width="3" stroke-linecap="round" stroke-dasharray="8,6" />
                @elseif($floor === 'Lantai 2')
                    <!-- Outline Building 2 -->
                    <rect x="8%" y="15%" width="84%" height="70%" rx="16" fill="#ffffff" stroke="#cbd5e1" stroke-width="2.5" />
                    <rect x="12%" y="18%" width="32%" height="28%" rx="8" fill="#e0f2fe" stroke="#0084f8" stroke-width="1.5" />
                    <text x="28%" y="33%" font-size="11" font-weight="bold" fill="#0369a1" text-anchor="middle">BOARDROOM SAKURA</text>

                    <rect x="48%" y="18%" width="40%" height="45%" rx="8" fill="#ecfdf5" stroke="#34d399" stroke-width="1.5" />
                    <text x="68%" y="41%" font-size="11" font-weight="bold" fill="#047857" text-anchor="middle">OPEN WORKSPACE</text>

                    <rect x="12%" y="52%" width="32%" height="30%" rx="8" fill="#fdf2f8" stroke="#f472b6" stroke-width="1.5" />
                    <text x="28%" y="68%" font-size="11" font-weight="bold" fill="#be185d" text-anchor="middle">RUANG LAKTASI</text>

                    <rect x="48%" y="68%" width="40%" height="15%" rx="8" fill="#fef3c7" stroke="#f59e0b" stroke-width="1.5" />
                    <text x="68%" y="77%" font-size="10" font-weight="bold" fill="#b45309" text-anchor="middle">COLLAB LOUNGE</text>
                @else
                    <!-- Plant Floor -->
                    <rect x="8%" y="15%" width="84%" height="70%" rx="16" fill="#ffffff" stroke="#94a3b8" stroke-width="2.5" />
                    <rect x="12%" y="18%" width="36%" height="64%" rx="8" fill="#f1f5f9" stroke="#64748b" stroke-width="1.5" />
                    <text x="30%" y="51%" font-size="12" font-weight="bold" fill="#334155" text-anchor="middle">PLANT 1: MACHINING</text>

                    <rect x="52%" y="18%" width="40%" height="40%" rx="8" fill="#e0e7ff" stroke="#6366f1" stroke-width="1.5" />
                    <text x="72%" y="39%" font-size="12" font-weight="bold" fill="#4338ca" text-anchor="middle">PLANT 2: ASSEMBLY</text>

                    <rect x="52%" y="62%" width="40%" height="20%" rx="8" fill="#fef9c3" stroke="#eab308" stroke-width="1.5" />
                    <text x="72%" y="73%" font-size="11" font-weight="bold" fill="#854d0e" text-anchor="middle">LOGISTICS & LOADING</text>

                    <line x1="12%" y1="84%" x2="92%" y2="84%" stroke="#22c55e" stroke-width="4" stroke-dasharray="10,6" />
                @endif
            </svg>

            <!-- Interactive Pin Markers -->
            @foreach($zones as $zone)
                <div class="absolute -translate-x-1/2 -translate-y-1/2 cursor-pointer transition-transform hover:scale-125 z-20 group"
                     style="left: {{ $zone->coord_x }}%; top: {{ $zone->coord_y }}%;"
                     @click="selectZone({{ json_encode($zone) }})">
                    
                    <div class="relative flex items-center justify-center">
                        <span class="animate-ping absolute inline-flex h-7 w-7 rounded-full opacity-75"
                              :class="selectedZone && selectedZone.id === {{ $zone->id }} ? 'bg-[#0084f8]' : 'bg-slate-400'"></span>
                        
                        <div class="w-8 h-8 rounded-full shadow-lg flex items-center justify-center border-2 border-white transition-all text-white text-xs font-bold"
                             :class="selectedZone && selectedZone.id === {{ $zone->id }} ? 'bg-[#0084f8] scale-110 ring-4 ring-sky-300' : '{{ $zone->type === 'emergency' ? 'bg-rose-500' : 'bg-slate-800 hover:bg-[#0084f8]' }}'">
                            @if($zone->type === 'emergency')
                                ⚠️
                            @elseif($zone->type === 'meeting')
                                👥
                            @elseif($zone->type === 'canteen')
                                ☕
                            @elseif($zone->type === 'clinic')
                                🏥
                            @elseif($zone->type === 'musholla')
                                🕌
                            @else
                                📍
                            @endif
                        </div>
                    </div>

                    <!-- Tooltip label -->
                    <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-1.5 hidden group-hover:block whitespace-nowrap bg-slate-900 text-white text-[10px] font-semibold px-2 py-1 rounded shadow-md pointer-events-none z-30">
                        {{ $zone->name }}
                    </div>
                </div>
            @endforeach

        </div>

        <!-- Selected Room Detail Box -->
        <template x-if="selectedZone">
            <div class="p-5 sm:p-6 bg-white border-t border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-md bg-sky-100 text-[#0084f8] font-bold text-xs" x-text="selectedZone.code || selectedZone.type.toUpperCase()"></span>
                        <span class="text-xs text-slate-400 font-medium" x-text="selectedZone.floor + ' • ' + selectedZone.building"></span>
                    </div>
                    <h3 class="text-lg font-extrabold text-[#0f2e54] mt-1" x-text="selectedZone.name"></h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-xl" x-text="selectedZone.description"></p>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <template x-if="selectedZone.contact_person">
                        <span class="text-xs font-semibold px-3 py-1.5 bg-slate-100 rounded-xl text-slate-700" x-text="'📞 ' + selectedZone.contact_person"></span>
                    </template>
                </div>
            </div>
        </template>
    </div>

    <!-- Room List for this Floor -->
    <div class="bg-white rounded-3xl p-5 sm:p-6 soft-shadow border border-slate-200/80">
        <h3 class="text-base font-extrabold text-[#0f2e54] mb-4">Daftar Titik & Ruangan di {{ $floor }}</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach($zones as $z)
                <div @click="selectZone({{ json_encode($z) }})" 
                     class="p-3.5 rounded-2xl border border-slate-100 hover:border-sky-300 hover:bg-sky-50/50 cursor-pointer transition flex items-center justify-between group"
                     :class="selectedZone && selectedZone.id === {{ $z->id }} ? 'bg-sky-50 border-sky-400' : 'bg-slate-50'">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-white text-slate-700 font-bold flex items-center justify-center text-xs shadow-xs">
                            {{ $loop->iteration }}
                        </span>
                        <div>
                            <div class="text-xs font-extrabold text-[#0f2e54] group-hover:text-[#0084f8]">{{ $z->name }}</div>
                            <div class="text-[11px] text-slate-400">{{ $z->code }} • {{ $z->contact_person }}</div>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-[#0084f8] opacity-0 group-hover:opacity-100 transition">Pilih →</span>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection

