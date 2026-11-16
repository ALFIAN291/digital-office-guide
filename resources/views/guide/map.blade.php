@extends('layouts.app')

@section('content')
@php
    /** @var string $floor */
    /** @var array<string, mixed> $blueprints */
    $floorKey = is_string($floor ?? null) ? $floor : 'Lantai 2';
    $blueprint = $blueprints[$floorKey] ?? $blueprints['Lantai 2'];
    $hasVisualMap = !empty($blueprint['map_image']);
    $defaultRoom = collect($blueprint['rooms'])->firstWhere('code', 'MO-205')
        ?? collect($blueprint['rooms'])->firstWhere('code', 'MR-05')
        ?? ($blueprint['rooms'][0] ?? null);

    $floorPills = [
        ['key' => 'Lantai 1', 'short' => 'Lt. 1', 'building' => 'Gedung Utama'],
        ['key' => 'Lantai 2', 'short' => 'Lt. 2', 'building' => 'Gedung Utama'],
        ['key' => 'Ground Floor', 'short' => 'Pabrik', 'building' => 'Pabrik 1 & 2'],
    ];

    $bottomLegends = [
        ['key' => 'all', 'label' => 'Pintu Masuk', 'bg' => 'bg-[#2b7de9] text-white', 'icon' => '⬆️'],
        ['key' => 'Jalur Darurat', 'label' => 'Jalur Darurat', 'bg' => 'bg-[#16a34a] text-white', 'icon' => '🏃'],
        ['key' => 'all', 'label' => 'APAR', 'bg' => 'bg-[#e11d48] text-white', 'icon' => '🧯'],
        ['key' => 'Ruang Direksi', 'label' => 'Ruang Direksi', 'bg' => 'bg-[#f8bbd0] text-[#9d174d]', 'icon' => '👤'],
        ['key' => 'Ruang Rapat', 'label' => 'Ruang Rapat', 'bg' => 'bg-[#fed7aa] text-[#9a3412]', 'icon' => '👥'],
        ['key' => 'Area Kerja', 'label' => 'Area Kerja', 'bg' => 'bg-[#bae6fd] text-[#0369a1]', 'icon' => '💺'],
        ['key' => 'Pantry / Santai', 'label' => 'Pantry / Santai', 'bg' => 'bg-[#bbf7d0] text-[#15803d]', 'icon' => '☕'],
        ['key' => 'Ruang Penunjang', 'label' => 'Ruang Penunjang', 'bg' => 'bg-[#e9d5ff] text-[#6b21a8]', 'icon' => '🖨️'],
        ['key' => 'Toilet', 'label' => 'Toilet', 'bg' => 'bg-[#cbd5e1] text-[#1e293b]', 'icon' => '🚻'],
    ];
@endphp

<div class="max-w-7xl mx-auto px-3 sm:px-5 pt-2 sm:pt-3 pb-6 space-y-3.5"
     x-data="{
        currentFloor: {{ Js::from($floorKey) }},
        viewMode: 'floor',
        showLabels: false,
        searchQuery: '',
        activeFilter: 'all',
        showRoute: false,
        blueprint: {{ Js::from($blueprint) }},
        dbZones: {{ Js::from($zones) }},
        selectedItem: {{ Js::from($defaultRoom) }},
        selectedIsZone: false,

        get activeRooms() {
            return this.blueprint.rooms || [];
        },

        switchViewMode(mode) {
            this.viewMode = mode;
        },

        selectRoom(room) {
            this.selectedItem = room;
            this.selectedIsZone = false;
        },
        triggerDirection() {
            this.showRoute = true;
            if (this.viewMode === 'list') {
                this.viewMode = 'floor';
            }
        },
        selectDbZone(zone) {
            this.selectedItem = {
                code: zone.code || zone.type.toUpperCase(),
                name: zone.name,
                group: zone.area_group || zone.type,
                cx: parseFloat(zone.coord_x) || 50,
                cy: parseFloat(zone.coord_y) || 50,
                capacity: zone.capacity || '8–10 orang',
                facilities: zone.facilities_list || zone.description,
                usage: zone.usage_info || zone.description,
                book: zone.how_to_book || (zone.contact_person ? 'Hubungi ' + zone.contact_person : 'Melalui Sistem Ruang Rapat (Outlook / Portal Web)'),
                image: (zone.image_path && zone.image_path.startsWith('data:'))
                    ? '/media/zone/' + zone.id + '/image_path'
                    : (zone.image_path || '/images/meeting-room.jpg'),
                contact_person: zone.contact_person,
            };
            this.selectedIsZone = true;
            this.showRoute = true;
        },
        matchesSearch(item) {
            const q = this.searchQuery.toLowerCase().trim();
            const filterOk = this.activeFilter === 'all' || (item.group && item.group.toLowerCase().includes(this.activeFilter.toLowerCase()));
            if (!q) return filterOk;
            return filterOk && (
                (item.name && item.name.toLowerCase().includes(q)) ||
                (item.code && item.code.toLowerCase().includes(q)) ||
                (item.group && item.group.toLowerCase().includes(q)) ||
                (item.facilities && item.facilities.toLowerCase().includes(q))
            );
        },
        get routePoints() {
            if (!this.selectedItem) return '';
            const tx = this.selectedItem.cx;
            const ty = this.selectedItem.cy;
            const sx = this.blueprint.start.x;
            const sy = this.blueprint.start.y;

            if (this.blueprint.map_image) {
                if (tx >= 78) {
                    return `${sx},${sy} ${sx},50 ${tx},50 ${tx},${ty}`;
                }
                if (ty <= 35) {
                    return `${sx},${sy} ${sx},46 64,46 64,37 ${tx},37 ${tx},${ty}`;
                }
                return `${sx},${sy} ${sx},58 ${tx},58 ${tx},${ty}`;
            }

            // Orthogonal corridor route for Plant schematic
            if (tx <= 20) {
                return `${sx},${sy} ${sx},85 20,85 20,${ty} ${tx},${ty}`;
            }
            if (ty <= 28) {
                return `${sx},${sy} ${sx},30 ${tx},30 ${tx},${ty}`;
            }
            return `${sx},${sy} ${sx},85 ${tx},85 ${tx},${ty}`;
        },
        get distanceMeters() {
            if (!this.selectedItem) return 0;
            const origin = this.blueprint.start;
            const dx = Math.abs(this.selectedItem.cx - origin.x);
            const dy = Math.abs(this.selectedItem.cy - origin.y);
            return Math.max(12, Math.round((dx * 0.72) + (dy * 0.55)));
        },
        get walkMinutes() {
            return Math.max(1, Math.round(this.distanceMeters / 45));
        }
     }">

    <!-- Top Context Bar: Breadcrumb + Lt.1/Lt.2/Pabrik Switcher + Building Selector -->
    <div class="flex flex-wrap items-center justify-between gap-2.5 bg-white/90 backdrop-blur-xs rounded-2xl px-3.5 py-2 soft-shadow border border-slate-200/80">
        <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
            <a href="{{ route('guide.index') }}" class="hover:text-[#0066dc] font-bold text-[#0f2e54]">PANDUAN KANTOR KARAWANG 2026</a>
            <span class="text-slate-300">|</span>
            <span class="text-slate-500 hidden sm:inline">Denah Kantor & Pabrik Karawang</span>
        </div>

        <div class="flex items-center gap-2 sm:gap-3 ml-auto">
            <!-- Lt. 1 / Lt. 2 / Pabrik Pills -->
            <div class="inline-flex items-center bg-slate-100 p-1 rounded-xl border border-slate-200/80">
                @foreach($floorPills as $fp)
                    <a href="{{ route('guide.map', ['floor' => $fp['key']]) }}"
                       class="px-3.5 py-1 rounded-lg text-xs font-extrabold transition {{ $floorKey === $fp['key'] ? 'bg-[#0066dc] text-white shadow-xs' : 'text-slate-600 hover:text-[#0f2e54]' }}">
                        {{ $fp['short'] }}
                    </a>
                @endforeach
            </div>

            <!-- Building Dropdown Pill -->
            <div class="relative" x-data="{ openBldg: false }">
                <button type="button" @click="openBldg = !openBldg"
                        class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200/90 text-xs font-extrabold text-[#0f2e54] cursor-pointer transition">
                    <svg class="w-4 h-4 text-[#0066dc]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>{{ $blueprint['building'] }}</span>
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="openBldg" @click.outside="openBldg = false" x-cloak
                     class="absolute right-0 mt-1.5 w-52 bg-white rounded-2xl shadow-xl border border-slate-200 py-1.5 z-40">
                    <a href="{{ route('guide.map', ['floor' => 'Lantai 2']) }}" class="flex items-center justify-between px-3.5 py-2 text-xs font-bold text-slate-700 hover:bg-sky-50 hover:text-[#0066dc]">
                        <span>🏢 Gedung Utama (Lt. 2)</span>
                        @if($floorKey === 'Lantai 2') <span class="text-[#0066dc]">✓</span> @endif
                    </a>
                    <a href="{{ route('guide.map', ['floor' => 'Lantai 1']) }}" class="flex items-center justify-between px-3.5 py-2 text-xs font-bold text-slate-700 hover:bg-sky-50 hover:text-[#0066dc]">
                        <span>🏢 Gedung Utama (Lt. 1)</span>
                        @if($floorKey === 'Lantai 1') <span class="text-[#0066dc]">✓</span> @endif
                    </a>
                    <a href="{{ route('guide.map', ['floor' => 'Ground Floor']) }}" class="flex items-center justify-between px-3.5 py-2 text-xs font-bold text-slate-700 hover:bg-sky-50 hover:text-[#0066dc]">
                        <span>🏭 Pabrik 1 & Pabrik 2</span>
                        @if($floorKey === 'Ground Floor') <span class="text-[#0066dc]">✓</span> @endif
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Interactive Container Card -->
    <div class="bg-white/95 rounded-3xl p-3.5 sm:p-5 soft-shadow border border-slate-200/90 space-y-4">

        <!-- Title Row + View Mode Switcher -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-[#dbeafe] text-[#1d4ed8] flex items-center justify-center shrink-0 shadow-2xs border border-blue-200">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4 3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6h3a1 1 0 0 1 1 1v11h1a1 1 0 1 1 0 2H3a1 1 0 1 1 0-2h1V3zm3 3v2h2V6H7zm0 4v2h2v-2H7zm0 4v2h2v-2H7zm4-8v2h2V6h-2zm0 4v2h2v-2h-2zm0 4v2h2v-2h-2zm5 2v5h2v-5h-2z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg sm:text-2xl font-extrabold text-[#0f2e54] tracking-tight leading-tight">{{ $blueprint['title'] }}</h1>
                    <p class="text-xs sm:text-sm text-slate-500">{{ $blueprint['subtitle'] }}</p>
                </div>
            </div>

            <div class="flex items-center gap-2 self-start md:self-auto">
                <div class="inline-flex items-center bg-slate-100 p-1 rounded-xl border border-slate-200/80 text-xs font-extrabold">
                    <button type="button" @click="switchViewMode('floor')"
                            :class="viewMode === 'floor' ? 'bg-[#0066dc] text-white shadow-xs' : 'text-slate-600 hover:text-[#0f2e54]'"
                            class="px-3.5 py-1.5 rounded-lg transition cursor-pointer inline-flex items-center gap-1.5">
                        <span>🗺️</span>
                        <span>Denah Lantai</span>
                    </button>
                    <button type="button" @click="switchViewMode('3d')"
                            :class="viewMode === '3d' ? 'bg-[#0066dc] text-white shadow-xs' : 'text-slate-600 hover:text-[#0f2e54]'"
                            class="px-3.5 py-1.5 rounded-lg transition cursor-pointer inline-flex items-center gap-1.5">
                        <span>🧊</span>
                        <span>Tampilan 3D</span>
                    </button>
                    <button type="button" @click="switchViewMode('list')"
                            :class="viewMode === 'list' ? 'bg-[#0066dc] text-white shadow-xs' : 'text-slate-600 hover:text-[#0f2e54]'"
                            class="px-3.5 py-1.5 rounded-lg transition cursor-pointer inline-flex items-center gap-1.5">
                        <span>≣</span>
                        <span>Daftar Ruangan</span>
                    </button>
                </div>

                <!-- Circular North Compass (▲ U) -->
                <div class="w-9 h-9 rounded-full border border-slate-200 bg-white shadow-2xs flex flex-col items-center justify-center leading-none text-[#0f2e54]" title="Arah Utara">
                    <span class="text-[9px] text-[#0066dc] font-black">▲</span>
                    <span class="text-[9px] font-black">U</span>
                </div>
            </div>
        </div>

        <!-- Center Split: 2D Architectural Floor Plan (Left 8) + Room Detail Card (Right 4) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-stretch">

            <!-- Left 8 Cols: Real 3D Architectural Map (1F/2F) or Plant Schematic + List View -->
            <div class="lg:col-span-8 flex flex-col">
                @if($hasVisualMap)
                    <!-- Real Uploaded 1F / 2F Floor Map Stage (Both Denah Lantai & Tampilan 3D) -->
                    <div x-show="viewMode !== 'list'"
                         class="relative w-full sm:min-h-[430px] rounded-2xl overflow-hidden border border-slate-200 shadow-md bg-white select-none flex items-center justify-center">

                        <!-- Top-Left Controls (Only in interactive Denah Lantai mode) -->
                        <div x-show="viewMode === 'floor'" class="absolute top-2.5 left-2.5 z-30 flex items-center gap-2">
                            <button type="button" @click="showLabels = !showLabels"
                                    class="px-2.5 py-1 rounded-full bg-white/95 hover:bg-white border border-slate-200 shadow-xs text-[10px] sm:text-xs font-extrabold text-[#0f2e54] cursor-pointer transition flex items-center gap-1">
                                <span x-text="showLabels ? '🏷️ Sembunyikan Label' : '🏷️ Tampilkan Label'"></span>
                            </button>
                            <span class="hidden sm:inline-flex px-2.5 py-1 rounded-full bg-[#0f2e54]/85 text-white text-[10px] font-bold shadow-xs">
                                Ketuk ikon ruangan pada peta
                            </span>
                        </div>

                        <div x-show="viewMode === '3d'" x-cloak class="absolute top-2.5 left-2.5 z-30">
                            <span class="inline-flex px-3 py-1 rounded-full bg-[#0f2e54]/85 text-white text-[10px] sm:text-xs font-bold shadow-xs">
                                Mode Tampilan Bersih 3D — Klik "Denah Lantai" untuk pin ruangan
                            </span>
                        </div>

                        <!-- Exact 1024x571 Stage so percentage hotspot coordinates never drift with screen height -->
                        <div class="relative w-full aspect-[1024/571] transition-transform duration-500"
                             :class="viewMode === '3d' ? 'scale-[1.03]' : ''">
                            <img src="{{ asset($blueprint['map_image']) }}"
                                 :src="blueprint.map_image"
                                 :alt="blueprint.title"
                                 class="w-full h-full object-fill pointer-events-none block">

                            <!-- Animated Walking Route Overlay -->
                            <svg x-show="showRoute && selectedItem" x-cloak
                                 class="absolute inset-0 w-full h-full pointer-events-none z-20"
                                 viewBox="0 0 100 100" preserveAspectRatio="none">
                                <polyline :points="routePoints"
                                          fill="none"
                                          stroke="#0066dc"
                                          stroke-width="1.05"
                                          stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-dasharray="2,1.3" />
                                <circle :cx="blueprint.start.x"
                                        :cy="blueprint.start.y"
                                        r="1.5" fill="#0066dc" stroke="#ffffff" stroke-width="0.5" />
                                <circle x-show="selectedItem"
                                        :cx="selectedItem ? selectedItem.cx : 50"
                                        :cy="selectedItem ? selectedItem.cy : 50"
                                        r="1.8" fill="#e11d48" stroke="#ffffff" stroke-width="0.5" />
                            </svg>

                            <!-- Entrance Badge -->
                            <div x-show="viewMode === 'floor' && blueprint.start"
                                 :style="`left: ${blueprint.start ? blueprint.start.x : 70.5}%; top: ${blueprint.start ? blueprint.start.y : 66}%;`"
                                 class="absolute -translate-x-1/2 translate-y-1.5 px-2.5 py-0.5 rounded-full bg-[#0066dc] text-white text-[8px] sm:text-[10px] font-black uppercase tracking-wide shadow-md border border-white pointer-events-none z-25 whitespace-nowrap">
                                ⬆️ Pintu Masuk
                            </div>

                            <!-- Interactive Room Hotspot Pins Overlay (Interactive Denah Lantai) -->
                            <template x-for="room in blueprint.rooms" :key="room.code">
                                <button type="button"
                                        x-show="viewMode === 'floor' && matchesSearch(room)"
                                        @click="selectRoom(room)"
                                        :style="`left: ${room.x}%; top: ${room.y}%;`"
                                        :title="room.name"
                                        class="group absolute -translate-x-1/2 -translate-y-1/2 cursor-pointer transition-all duration-150 focus:outline-hidden"
                                        :class="selectedItem && selectedItem.code === room.code ? 'z-30 scale-110' : 'z-20 hover:z-30 hover:scale-110'">
                                    <span class="w-6 h-6 sm:w-7 sm:h-7 rounded-full flex items-center justify-center shadow-md border-2 transition-colors"
                                          :class="selectedItem && selectedItem.code === room.code
                                              ? 'bg-[#0066dc] text-white border-white ring-3 ring-[#0066dc]/35'
                                              : 'bg-white/95 text-[#0f2e54] border-slate-300 group-hover:bg-[#0066dc] group-hover:text-white group-hover:border-white'">
                                        <span class="text-[11px] sm:text-xs leading-none" x-text="room.icon || '📍'"></span>
                                    </span>
                                    <span x-show="showLabels || (selectedItem && selectedItem.code === room.code)"
                                          x-cloak
                                          class="absolute left-1/2 -translate-x-1/2 bottom-full mb-1 px-2 py-0.5 rounded-full text-[9px] sm:text-[10px] font-extrabold whitespace-nowrap shadow-md border pointer-events-none"
                                          :class="selectedItem && selectedItem.code === room.code
                                              ? 'bg-[#0f2e54] text-white border-white'
                                              : 'bg-white/95 text-[#0f2e54] border-slate-200 hidden md:inline-block'"
                                          x-text="room.label"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                @else
                    <!-- Plant Complex Schematic View (Only when floor has no architectural image render) -->
                    <div x-show="viewMode !== 'list'" x-cloak
                         class="relative w-full aspect-[16/10] min-h-[340px] sm:min-h-[430px] rounded-2xl overflow-hidden border-2 border-slate-300 shadow-md bg-[#4d5966] select-none transition-transform duration-500"
                         :style="viewMode === '3d' ? 'transform: perspective(1100px) rotateX(24deg) rotateZ(-3deg) scale(0.96); box-shadow: 0 24px 40px -12px rgba(15,46,84,0.32);' : ''">

                        <svg class="absolute inset-0 w-full h-full pointer-events-none" viewBox="0 0 100 100" preserveAspectRatio="none">
                            <rect x="0" y="0" width="100" height="100" fill="#64748b" />
                            <rect x="4.5" y="5.5" width="91.3" height="83" rx="0.8" fill="#f3efe6" stroke="#334155" stroke-width="0.7" />
                            <rect x="39" y="87.2" width="10" height="3.2" fill="#e2e8f0" stroke="#475569" stroke-width="0.35" />
                            <rect x="41" y="88" width="6" height="1.5" fill="#0284c7" />
                        </svg>

                        <template x-for="room in blueprint.rooms" :key="room.code">
                            <button type="button"
                                    @click="selectRoom(room)"
                                    x-show="matchesSearch(room)"
                                    :style="`left: ${room.x}%; top: ${room.y}%; width: ${room.w}%; height: ${room.h}%;`"
                                    :class="[
                                        room.color,
                                        selectedItem && selectedItem.code === room.code
                                            ? 'ring-3 ring-[#0066dc] shadow-xl scale-[1.015] z-20'
                                            : 'opacity-95 hover:opacity-100 hover:ring-2 hover:ring-[#0066dc]/70 z-10'
                                    ]"
                                    class="absolute rounded-sm border-2 flex flex-col items-center justify-center p-1 text-center transition cursor-pointer overflow-hidden shadow-xs">
                                <template x-if="room.icon">
                                    <span class="text-xs sm:text-base leading-none mb-0.5 drop-shadow-2xs" x-text="room.icon"></span>
                                </template>
                                <span class="text-[7px] sm:text-[9.5px] font-black leading-tight whitespace-pre-line tracking-tight uppercase" x-text="room.label"></span>
                            </button>
                        </template>

                        <svg x-show="showRoute && selectedItem" x-cloak class="absolute inset-0 w-full h-full pointer-events-none z-30" viewBox="0 0 100 100" preserveAspectRatio="none">
                            <polyline :points="routePoints"
                                      fill="none"
                                      stroke="#0066dc"
                                      stroke-width="1.2"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-dasharray="2,1.4" />
                            <circle :cx="blueprint.start.x" :cy="blueprint.start.y" r="1.7" fill="#0066dc" stroke="#ffffff" stroke-width="0.6" />
                            <circle x-show="selectedItem" :cx="selectedItem ? selectedItem.cx : 50" :cy="selectedItem ? selectedItem.cy : 50" r="2.0" fill="#e11d48" stroke="#ffffff" stroke-width="0.6" />
                        </svg>

                        <div class="absolute bottom-1.5 left-[44%] -translate-x-1/2 px-3 py-1 rounded-lg bg-[#0066dc] text-white text-[8px] sm:text-[10px] font-black tracking-wider uppercase shadow-lg border border-white/80 pointer-events-none z-30">
                            PINTU MASUK UTAMA
                        </div>
                    </div>
                @endif

                <!-- List View Mode -->
                <div x-show="viewMode === 'list'" x-cloak class="p-3 sm:p-4 bg-slate-50 rounded-2xl border border-slate-200 space-y-2 max-h-[430px] overflow-y-auto">
                    <div class="mb-2">
                        <input type="text" x-model="searchQuery" placeholder="Cari ruangan atau area..."
                               class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:outline-hidden focus:border-[#0066dc]">
                    </div>
                    <template x-for="room in activeRooms" :key="room.code">
                        <div x-show="matchesSearch(room)"
                             @click="selectRoom(room); viewMode = 'floor';"
                             class="p-3 rounded-xl bg-white border border-slate-200 hover:border-[#0066dc] cursor-pointer transition flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="w-8 h-8 rounded-lg bg-sky-50 text-[#0066dc] flex items-center justify-center text-sm shrink-0" x-text="room.icon || '📍'"></span>
                                <div class="min-w-0">
                                    <div class="text-xs sm:text-sm font-extrabold text-[#0f2e54] truncate" x-text="room.name"></div>
                                    <div class="text-[11px] text-slate-500 truncate" x-text="room.group + ' • ' + room.capacity"></div>
                                </div>
                            </div>
                            <span class="px-3 py-1 rounded-lg bg-sky-50 text-[#0066dc] text-[11px] font-bold shrink-0">Lihat di Denah →</span>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Right 4 Cols: Selected Room Detail Card -->
            <div class="lg:col-span-4 flex flex-col">
                <template x-if="selectedItem">
                    <div class="bg-white rounded-2xl soft-shadow border border-slate-200/90 overflow-hidden flex flex-col justify-between h-full">
                        <div>
                            <!-- Top Room Photo with Close '✕' Button -->
                            <div class="relative h-36 sm:h-40 bg-slate-100 overflow-hidden">
                                <img :src="selectedItem.image" :alt="selectedItem.name" class="w-full h-full object-cover">
                                <button type="button" @click="selectedItem = null; showRoute = false;"
                                        class="absolute top-2.5 right-2.5 w-7 h-7 rounded-full bg-white/95 hover:bg-white text-slate-700 flex items-center justify-center text-xs font-extrabold shadow-md cursor-pointer">
                                    ✕
                                </button>
                            </div>

                            <div class="p-3.5 sm:p-4 space-y-3.5">
                                <!-- Soft Pink Room Header Banner -->
                                <div class="p-2.5 sm:p-3 rounded-2xl bg-rose-50/90 border border-rose-100 flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-rose-400 text-white flex items-center justify-center text-lg shadow-2xs shrink-0">
                                        <span x-text="selectedItem.icon || '👥'"></span>
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="text-sm sm:text-base font-extrabold text-[#0f2e54] leading-tight truncate" x-text="selectedItem.name"></h3>
                                        <div class="text-[11px] font-semibold text-slate-500 mt-0.5" x-text="(blueprint.code === 'Lt. 2' ? 'Lantai 2' : (blueprint.code === 'Lt. 1' ? 'Lantai 1' : blueprint.code)) + ' • ' + selectedItem.group"></div>
                                    </div>
                                </div>

                                <!-- 4 Metadata Rows with Blue Icons -->
                                <div class="space-y-2.5 text-xs">
                                    <!-- Kapasitas -->
                                    <div class="flex items-start gap-3">
                                        <div class="w-7 h-7 rounded-lg bg-sky-50 text-[#0066dc] flex items-center justify-center shrink-0 mt-0.5">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-extrabold text-[#0f2e54]">Kapasitas</div>
                                            <div class="text-slate-600" x-text="selectedItem.capacity"></div>
                                        </div>
                                    </div>

                                    <!-- Fasilitas -->
                                    <div class="flex items-start gap-3">
                                        <div class="w-7 h-7 rounded-lg bg-sky-50 text-[#0066dc] flex items-center justify-center shrink-0 mt-0.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                                <line x1="8" y1="21" x2="16" y2="21"></line>
                                                <line x1="12" y1="17" x2="12" y2="21"></line>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-extrabold text-[#0f2e54]">Fasilitas</div>
                                            <div class="text-slate-600 leading-snug" x-text="selectedItem.facilities"></div>
                                        </div>
                                    </div>

                                    <!-- Kegunaan -->
                                    <div class="flex items-start gap-3">
                                        <div class="w-7 h-7 rounded-lg bg-sky-50 text-[#0066dc] flex items-center justify-center shrink-0 mt-0.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-extrabold text-[#0f2e54]">Kegunaan</div>
                                            <div class="text-slate-600 leading-snug" x-text="selectedItem.usage"></div>
                                        </div>
                                    </div>

                                    <!-- Cara Pemesanan -->
                                    <div class="flex items-start gap-3">
                                        <div class="w-7 h-7 rounded-lg bg-sky-50 text-[#0066dc] flex items-center justify-center shrink-0 mt-0.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                                <line x1="3" y1="10" x2="21" y2="10"></line>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-extrabold text-[#0f2e54]">Cara Pemesanan</div>
                                            <div class="text-slate-600 leading-snug" x-text="selectedItem.book"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom CTA Button: Petunjuk Arah -->
                        <div class="p-3.5 sm:p-4 pt-0 space-y-2">
                            <button type="button" @click="triggerDirection()"
                                    class="w-full py-2.5 px-4 rounded-full bg-gradient-to-r from-[#0055c4] to-[#0078f0] hover:from-[#0046a3] hover:to-[#0066d6] text-white text-xs sm:text-sm font-extrabold shadow-md flex items-center justify-center gap-2 transition cursor-pointer">
                                <svg class="w-4 h-4 -rotate-45" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                                </svg>
                                <span>Petunjuk Arah</span>
                            </button>

                            <template x-if="selectedItem.facility_slug">
                                <a :href="'/facilities/' + selectedItem.facility_slug"
                                   class="block w-full text-center py-2 px-4 rounded-full bg-sky-50 hover:bg-sky-100 text-[#0066dc] text-[11px] font-extrabold border border-sky-200 transition">
                                    Lihat Detail & Perlengkapan Ruangan →
                                </a>
                            </template>
                        </div>
                    </div>
                </template>

                <template x-if="!selectedItem">
                    <div class="bg-white rounded-2xl soft-shadow border border-slate-200/80 p-6 text-center flex flex-col items-center justify-center h-full space-y-2">
                        <div class="text-3xl">🗺️</div>
                        <h3 class="text-sm font-extrabold text-[#0f2e54]">Pilih Area pada Denah</h3>
                        <p class="text-xs text-slate-500">Ketuk ruangan berwarna di denah untuk melihat kapasitas, perlengkapan, cara pemesanan, dan petunjuk arah.</p>
                    </div>
                </template>
            </div>
        </div>

        <!-- Bottom 9-Item Icon Legend Strip (Matching Screenshot 1 Bottom Bar) -->
        <div class="pt-2 border-t border-slate-100">
            <div class="grid grid-cols-3 sm:grid-cols-5 lg:grid-cols-9 gap-2">
                @foreach($bottomLegends as $lg)
                    <button type="button"
                            @click="activeFilter = (activeFilter === '{{ $lg['key'] }}' && '{{ $lg['key'] }}' !== 'all') ? 'all' : '{{ $lg['key'] }}'"
                            :class="activeFilter === '{{ $lg['key'] }}' && '{{ $lg['key'] }}' !== 'all' ? 'ring-2 ring-[#0066dc] bg-sky-50/70' : 'hover:bg-slate-50'"
                            class="flex flex-col items-center justify-center py-2 px-1.5 rounded-2xl transition cursor-pointer text-center group">
                        <span class="w-9 h-9 rounded-xl {{ $lg['bg'] }} flex items-center justify-center text-base shadow-2xs mb-1.5 group-hover:scale-105 transition">
                            {{ $lg['icon'] }}
                        </span>
                        <span class="text-[10px] sm:text-[11px] font-bold text-slate-600 leading-tight">{{ $lg['label'] }}</span>
                    </button>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection
