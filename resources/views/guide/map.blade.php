@extends('layouts.app')

@section('content')
@php
    /** @var string $floor */
    /** @var array<string, mixed> $blueprints */
    $floorKey = is_string($floor ?? null) ? $floor : 'Lantai 2';
    $blueprint = $blueprints[$floorKey] ?? $blueprints['Lantai 2'];
    $defaultRoom = collect($blueprint['rooms'])->firstWhere('code', 'MR-05') ?? ($blueprint['rooms'][0] ?? null);
@endphp

<div class="max-w-6xl lg:max-w-none mx-auto px-4 sm:px-6 pt-3 sm:pt-4 space-y-4"
     x-data="{
        currentFloor: {{ Js::from($floorKey) }},
        viewMode: 'floor',
        searchQuery: '',
        activeFilter: 'all',
        showRoute: true,
        blueprint: {{ Js::from($blueprint) }},
        dbZones: {{ Js::from($zones) }},
        selectedItem: {{ Js::from($defaultRoom) }},
        selectedIsZone: false,

        selectRoom(room) {
            this.selectedItem = room;
            this.selectedIsZone = false;
            this.showRoute = true;
        },
        selectDbZone(zone) {
            this.selectedItem = {
                code: zone.code || zone.type.toUpperCase(),
                name: zone.name,
                group: zone.area_group || zone.type,
                cx: parseFloat(zone.coord_x) || 50,
                cy: parseFloat(zone.coord_y) || 50,
                capacity: zone.capacity || 'Sesuai Standar Ruangan',
                facilities: zone.facilities_list || zone.description,
                usage: zone.usage_info || zone.description,
                book: zone.how_to_book || (zone.contact_person ? 'Hubungi ' + zone.contact_person : 'Via Portal / GA'),
                image: zone.image_path || '/images/facilities-office.jpg',
                contact_person: zone.contact_person,
            };
            this.selectedIsZone = true;
            this.showRoute = true;
        },
        matchesSearch(item) {
            const q = this.searchQuery.toLowerCase().trim();
            const filterOk = this.activeFilter === 'all' || this.activeFilter === 'route' || this.activeFilter === 'here' || (item.group && item.group.toLowerCase().includes(this.activeFilter.toLowerCase()));
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
            const sx = this.blueprint.start.x;
            const sy = this.blueprint.start.y;
            const tx = this.selectedItem.cx;
            const ty = this.selectedItem.cy;
            const cy = this.blueprint.corridor_y || 34;
            const cx = this.blueprint.corridor_x || 39;

            // Orthogonal architectural path via corridor spine
            if (Math.abs(ty - sy) < 12) {
                return `${sx},${sy} ${sx},${cy} ${tx},${cy} ${tx},${ty}`;
            }
            if (tx < cx && ty < cy) {
                return `${sx},${sy} ${sx},${sy - 14} ${cx},${sy - 14} ${cx},${cy} ${tx},${cy} ${tx},${ty}`;
            }
            return `${sx},${sy} ${sx},${sy - 14} ${tx},${sy - 14} ${tx},${ty}`;
        },
        get distanceMeters() {
            if (!this.selectedItem) return 0;
            const dx = Math.abs(this.selectedItem.cx - this.blueprint.start.x);
            const dy = Math.abs(this.selectedItem.cy - this.blueprint.start.y);
            return Math.max(12, Math.round((dx * 0.72) + (dy * 0.55)));
        },
        get walkMinutes() {
            return Math.max(1, Math.round(this.distanceMeters / 45));
        }
     }">

    <!-- Header & Concept Map Toolbar (Slide 4 & Slide 7) -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3">
        <div>
            <div class="flex items-center gap-2 text-[11px] font-semibold text-slate-500 mb-1">
                <a href="{{ route('guide.index') }}" class="hover:text-[#0084f8]">Beranda</a>
                <span>/</span>
                <span class="text-[#0f2e54]">Interactive Map</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-[#0f2e54] tracking-tight">Denah Kantor & Pabrik Karawang</h1>
            <p class="text-xs text-slate-500 mt-0.5">{{ $blueprint['title'] }} — {{ $blueprint['subtitle'] }}</p>
        </div>

        <!-- Floor Switcher Tabs (1F / 2F / Plant) -->
        <div class="bg-white rounded-2xl p-1 soft-shadow border border-slate-200/80 flex flex-wrap gap-1 w-full lg:w-auto">
            @foreach($floors as $key => $title)
                <a href="{{ route('guide.map', ['floor' => $key]) }}"
                   class="flex-1 lg:flex-initial py-2 px-3 text-center text-xs font-bold rounded-xl transition whitespace-nowrap {{ $floorKey === $key ? 'bg-[#0084f8] text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                    {{ $title }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Search + View Switcher Bar (Floor Plan / 3D View / List View + Compass) -->
    <div class="bg-white rounded-2xl p-2.5 sm:p-3 soft-shadow border border-slate-200/80 flex flex-wrap items-center justify-between gap-2.5">
        <div class="relative flex-1 min-w-[200px]">
            <input type="text"
                   x-model="searchQuery"
                   placeholder="Search room, facility, or department..."
                   class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-hidden focus:border-[#0084f8] transition">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>

        <div class="flex items-center gap-1.5">
            <div class="inline-flex bg-slate-100 p-1 rounded-xl border border-slate-200/70 text-[11px] font-bold">
                <button type="button" @click="viewMode = 'floor'"
                        :class="viewMode === 'floor' ? 'bg-[#0084f8] text-white shadow-2xs' : 'text-slate-600 hover:text-[#0f2e54]'"
                        class="px-3 py-1.5 rounded-lg transition cursor-pointer">Floor Plan</button>
                <button type="button" @click="viewMode = '3d'"
                        :class="viewMode === '3d' ? 'bg-[#0084f8] text-white shadow-2xs' : 'text-slate-600 hover:text-[#0f2e54]'"
                        class="px-3 py-1.5 rounded-lg transition cursor-pointer">3D View</button>
                <button type="button" @click="viewMode = 'list'"
                        :class="viewMode === 'list' ? 'bg-[#0084f8] text-white shadow-2xs' : 'text-slate-600 hover:text-[#0f2e54]'"
                        class="px-3 py-1.5 rounded-lg transition cursor-pointer">List View</button>
            </div>
            <!-- North Compass Badge -->
            <div class="hidden sm:flex w-9 h-9 rounded-full border border-slate-200 bg-slate-50 items-center justify-center text-[10px] font-extrabold text-[#0f2e54]" title="North Orientation">
                ▲ N
            </div>
        </div>
    </div>

    <!-- Main Interactive Grid: Architectural Map (Left 8) + Selected Room Detail Drawer (Right 4) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start">

        <!-- Left Canvas Column -->
        <div class="lg:col-span-8 bg-white rounded-3xl soft-shadow border border-slate-200/80 overflow-hidden">
            <!-- Canvas Status Strip -->
            <div class="px-4 py-2.5 bg-slate-50 border-b border-slate-100 flex items-center justify-between gap-2 text-xs">
                <div class="flex items-center gap-2 font-bold text-[#0f2e54]">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#0084f8] animate-pulse"></span>
                    <span>{{ $blueprint['building'] }} • {{ $blueprint['code'] }}</span>
                </div>
                <div class="flex items-center gap-3 text-[11px]">
                    <button type="button" @click="showRoute = !showRoute"
                            class="px-2.5 py-1 rounded-lg border font-bold transition cursor-pointer"
                            :class="showRoute ? 'bg-sky-50 border-sky-300 text-[#0084f8]' : 'bg-white border-slate-200 text-slate-500'">
                        <span x-text="showRoute ? '✓ Route Shown' : 'Show Route'"></span>
                    </button>
                </div>
            </div>

            <!-- Floor Plan & 3D Architectural View -->
            <div x-show="viewMode !== 'list'" class="p-3 sm:p-4 bg-[#e9eff6]">
                <div class="relative w-full aspect-[16/10] sm:aspect-[16/9] min-h-[290px] bg-[#f8fafc] rounded-2xl border-2 border-slate-300 overflow-hidden shadow-inner transition-transform duration-500 select-none"
                     :style="viewMode === '3d' ? 'transform: perspective(1100px) rotateX(28deg) rotateZ(-4deg) scale(0.95); box-shadow: 0 24px 40px -12px rgba(15,46,84,0.28);' : ''">

                    <!-- Architectural CAD Grid & Corridors -->
                    <svg class="absolute inset-0 w-full h-full pointer-events-none" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <defs>
                            <pattern id="archGrid" width="5" height="5" patternUnits="userSpaceOnUse">
                                <path d="M 5 0 L 0 0 0 5" fill="none" stroke="#e2e8f0" stroke-width="0.2" />
                            </pattern>
                        </defs>
                        <rect width="100" height="100" fill="url(#archGrid)" />
                        <!-- Perimeter Greenery Strip -->
                        <rect x="2" y="91" width="96" height="7" rx="2" fill="#dcfce7" opacity="0.7" />
                        <!-- Building Outer Wall -->
                        <rect x="6" y="6" width="88" height="88" rx="2" fill="#ffffff" stroke="#64748b" stroke-width="0.6" />
                        <!-- Inner Hallway Spine -->
                        <rect x="22" y="30" width="66" height="5" fill="#f1f5f9" stroke="#cbd5e1" stroke-width="0.25" stroke-dasharray="1,1" />
                        <rect x="22" y="71" width="66" height="5" fill="#f1f5f9" stroke="#cbd5e1" stroke-width="0.25" stroke-dasharray="1,1" />
                    </svg>

                    <!-- Architectural Color-Coded Rooms -->
                    <template x-for="room in blueprint.rooms" :key="room.code">
                        <button type="button"
                                @click="selectRoom(room)"
                                x-show="matchesSearch(room)"
                                :style="`left: ${room.x}%; top: ${room.y}%; width: ${room.w}%; height: ${room.h}%;`"
                                :class="[
                                    room.color,
                                    selectedItem && selectedItem.code === room.code ? 'ring-3 ring-[#0084f8] shadow-lg scale-[1.02] z-20' : 'opacity-95 hover:opacity-100 hover:ring-2 hover:ring-sky-400 z-10'
                                ]"
                                class="absolute rounded-md border flex flex-col items-center justify-center p-1 text-center transition cursor-pointer overflow-hidden">
                            <span class="text-[8px] sm:text-[10px] font-extrabold leading-tight whitespace-pre-line tracking-tight" x-text="room.label"></span>
                            <template x-if="room.group === 'Office Area'">
                                <span class="hidden sm:inline-block mt-1 px-1.5 py-0.2 rounded bg-white/80 text-[7px] font-bold text-slate-600" x-text="room.capacity"></span>
                            </template>
                        </button>
                    </template>

                    <!-- Safety & Facility Overlay Icons (Exit, APAR, Restroom, Stairs, Elevator) -->
                    <template x-for="(ic, i) in blueprint.icons" :key="i">
                        <div class="absolute -translate-x-1/2 -translate-y-1/2 z-20 pointer-events-auto"
                             :style="`left: ${ic.x}%; top: ${ic.y}%;`"
                             :title="ic.label">
                            <span class="w-4 h-4 sm:w-5 sm:h-5 rounded-md flex items-center justify-center text-[9px] sm:text-[10px] font-bold shadow-xs border border-white"
                                  :class="{
                                    'bg-emerald-600 text-white': ic.type === 'exit',
                                    'bg-rose-600 text-white': ic.type === 'apar',
                                    'bg-sky-600 text-white': ic.type === 'restroom',
                                    'bg-purple-600 text-white': ic.type === 'stairs',
                                    'bg-slate-600 text-white': ic.type === 'elevator',
                                  }">
                                <span x-text="ic.type === 'exit' ? '🏃' : (ic.type === 'apar' ? '🧯' : (ic.type === 'restroom' ? '🚻' : (ic.type === 'stairs' ? '🪜' : '🛗')))"></span>
                            </span>
                        </div>
                    </template>

                    <!-- SVG Animated Route Wayfinding Overlay (Concept Slide 7 Dotted Blue Route) -->
                    <svg x-show="showRoute && selectedItem" class="absolute inset-0 w-full h-full pointer-events-none z-[25]" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <polyline :points="routePoints"
                                  fill="none"
                                  stroke="#0084f8"
                                  stroke-width="1.15"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-dasharray="2.2,1.6" />
                        <!-- Start Circle -->
                        <circle :cx="blueprint.start.x" :cy="blueprint.start.y" r="1.8" fill="#0084f8" stroke="#ffffff" stroke-width="0.6" />
                        <!-- Destination Pin Dot -->
                        <circle x-show="selectedItem" :cx="selectedItem ? selectedItem.cx : 50" :cy="selectedItem ? selectedItem.cy : 50" r="2.1" fill="#e11d48" stroke="#ffffff" stroke-width="0.6" />
                    </svg>

                    <!-- "YOU ARE HERE" Pin Badge -->
                    <div class="absolute -translate-x-1/2 -translate-y-1/2 z-30 pointer-events-none"
                         :style="`left: ${blueprint.start.x}%; top: ${blueprint.start.y}%;`">
                        <div class="flex flex-col items-center">
                            <span class="px-2 py-0.5 rounded-full bg-[#0f2e54] text-white text-[8px] sm:text-[9px] font-extrabold tracking-wide shadow-md border border-white whitespace-nowrap">
                                ● YOU ARE HERE
                            </span>
                        </div>
                    </div>

                    <!-- Database Zones Overlay Markers -->
                    @foreach($zones as $zone)
                        <button type="button"
                                @click="selectDbZone({{ Js::from($zone) }})"
                                style="left: {{ $zone->coord_x }}%; top: {{ $zone->coord_y }}%;"
                                class="absolute -translate-x-1/2 -translate-y-1/2 z-30 group cursor-pointer"
                                title="{{ $zone->name }}">
                            <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full flex items-center justify-center text-[10px] border-2 border-white shadow-md transition group-hover:scale-125 {{ $zone->type === 'emergency' ? 'bg-rose-600 text-white' : 'bg-[#0f2e54] text-white' }}">
                                {{ $zone->type === 'emergency' ? '⚠️' : ($zone->type === 'meeting' ? '👥' : ($zone->type === 'canteen' ? '☕' : '📍')) }}
                            </span>
                        </button>
                    @endforeach

                    <!-- Main Entrance Bottom Pill (Slide 4 & 7) -->
                    <div class="absolute bottom-1 left-1/2 -translate-x-1/2 px-2.5 py-0.5 rounded-t-lg bg-[#0084f8] text-white text-[8px] sm:text-[9px] font-extrabold tracking-wider uppercase shadow-sm pointer-events-none z-20">
                        ▲ MAIN ENTRANCE
                    </div>
                </div>
            </div>

            <!-- List View Mode -->
            <div x-show="viewMode === 'list'" x-cloak class="p-4 sm:p-5 space-y-2.5 max-h-[450px] overflow-y-auto">
                <template x-for="room in blueprint.rooms" :key="room.code">
                    <div x-show="matchesSearch(room)"
                         @click="selectRoom(room); viewMode = 'floor';"
                         class="p-3.5 rounded-2xl border border-slate-200 hover:border-[#0084f8] hover:bg-sky-50/40 cursor-pointer transition flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <span class="px-2 py-1 rounded-lg bg-slate-100 text-[10px] font-extrabold text-[#0f2e54]" x-text="room.code"></span>
                            <div class="min-w-0">
                                <div class="text-xs sm:text-sm font-extrabold text-[#0f2e54] truncate" x-text="room.name"></div>
                                <div class="text-[11px] text-slate-500 truncate" x-text="room.group + ' • ' + room.capacity"></div>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-xl bg-sky-50 text-[#0084f8] text-[11px] font-bold shrink-0">Get Direction →</span>
                    </div>
                </template>
            </div>

            <!-- Interactive Legend & Area Filter Strip (Slide 4 & 7 Bottom Bar) -->
            <div class="px-3 sm:px-4 py-2.5 bg-slate-50 border-t border-slate-100 flex items-center gap-1.5 overflow-x-auto scrollbar-none">
                @php
                    $legendFilters = [
                        ['key' => 'all', 'label' => 'All Areas', 'dot' => 'bg-[#0084f8]'],
                        ['key' => 'Executive Room', 'label' => 'Executive Room', 'dot' => 'bg-amber-400'],
                        ['key' => 'Meeting Room', 'label' => 'Meeting Room', 'dot' => 'bg-pink-400'],
                        ['key' => 'Office Area', 'label' => 'Office Area', 'dot' => 'bg-slate-400'],
                        ['key' => 'Pantry / Lounge', 'label' => 'Pantry / Lounge', 'dot' => 'bg-amber-500'],
                        ['key' => 'Support Room', 'label' => 'Support Room', 'dot' => 'bg-cyan-500'],
                        ['key' => 'Emergency Exit', 'label' => 'Emergency Exit', 'dot' => 'bg-emerald-500'],
                    ];
                @endphp
                @foreach($legendFilters as $lf)
                    <button type="button" @click="activeFilter = '{{ $lf['key'] }}'"
                            :class="activeFilter === '{{ $lf['key'] }}' ? 'bg-[#0f2e54] text-white border-[#0f2e54]' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-100'"
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg border text-[10px] font-bold whitespace-nowrap transition cursor-pointer shrink-0">
                        <span class="w-2 h-2 rounded-full {{ $lf['dot'] }}"></span>
                        <span>{{ $lf['label'] }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Right Selected Room Detail Card (Concept Slide 4 & Slide 7) -->
        <div class="lg:col-span-4">
            <template x-if="selectedItem">
                <div class="bg-white rounded-3xl soft-shadow border border-slate-200/80 overflow-hidden sticky top-22">
                    <!-- Room Photo -->
                    <div class="relative h-36 sm:h-40 bg-slate-100 overflow-hidden">
                        <img :src="selectedItem.image" :alt="selectedItem.name" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/65 via-transparent to-transparent"></div>
                        <button type="button" @click="selectedItem = null"
                                class="absolute top-2.5 right-2.5 w-7 h-7 rounded-full bg-white/90 hover:bg-white text-slate-700 flex items-center justify-center text-xs font-bold shadow cursor-pointer">
                            ✕
                        </button>
                        <div class="absolute bottom-2.5 left-3 right-3 flex items-center justify-between gap-2 text-white">
                            <span class="px-2 py-0.5 rounded-md bg-[#0084f8] text-[10px] font-extrabold" x-text="selectedItem.code"></span>
                            <span class="px-2 py-0.5 rounded-md bg-slate-900/70 text-[10px] font-bold" x-text="walkMinutes + ' min walk • ' + distanceMeters + ' m'"></span>
                        </div>
                    </div>

                    <!-- Room Specs Body -->
                    <div class="p-4 sm:p-5 space-y-3.5">
                        <div>
                            <div class="text-[11px] font-bold uppercase tracking-wider text-[#0084f8]" x-text="blueprint.code + ' • ' + selectedItem.group"></div>
                            <h3 class="text-lg font-extrabold text-[#0f2e54] leading-snug mt-0.5" x-text="selectedItem.name"></h3>
                        </div>

                        <div class="space-y-2.5 pt-2 border-t border-slate-100 text-xs">
                            <div class="flex items-start gap-2.5">
                                <span class="w-6 h-6 rounded-lg bg-slate-100 flex items-center justify-center shrink-0">👥</span>
                                <div>
                                    <div class="font-bold text-slate-800">Capacity</div>
                                    <div class="text-slate-500" x-text="selectedItem.capacity"></div>
                                </div>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <span class="w-6 h-6 rounded-lg bg-slate-100 flex items-center justify-center shrink-0">🖥️</span>
                                <div>
                                    <div class="font-bold text-slate-800">Facilities</div>
                                    <div class="text-slate-500 leading-snug" x-text="selectedItem.facilities"></div>
                                </div>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <span class="w-6 h-6 rounded-lg bg-slate-100 flex items-center justify-center shrink-0">🧭</span>
                                <div>
                                    <div class="font-bold text-slate-800">Usage</div>
                                    <div class="text-slate-500 leading-snug" x-text="selectedItem.usage"></div>
                                </div>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <span class="w-6 h-6 rounded-lg bg-slate-100 flex items-center justify-center shrink-0">📅</span>
                                <div>
                                    <div class="font-bold text-slate-800">How to Book / Access</div>
                                    <div class="text-slate-500 leading-snug" x-text="selectedItem.book"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Get Direction Primary Button (Slide 7) -->
                        <div class="pt-2 space-y-2">
                            <button type="button" @click="showRoute = true; viewMode = 'floor';"
                                    class="w-full py-2.5 px-4 bg-[#0084f8] hover:bg-[#0070d6] text-white rounded-xl text-xs font-extrabold shadow-md flex items-center justify-center gap-2 transition cursor-pointer">
                                <span>➤</span>
                                <span>Get Direction (<span x-text="walkMinutes + ' min walk • ' + distanceMeters + ' m'"></span>)</span>
                            </button>
                            <template x-if="selectedItem.facility_slug">
                                <a :href="'/facilities/' + selectedItem.facility_slug"
                                   class="block w-full text-center py-2 px-4 bg-sky-50 hover:bg-sky-100 text-[#0084f8] rounded-xl text-xs font-bold border border-sky-200 transition">
                                    View Equipment & 5-Step How-To →
                                </a>
                            </template>
                        </div>
                    </div>
                </div>
            </template>

            <template x-if="!selectedItem">
                <div class="bg-white rounded-3xl soft-shadow border border-slate-200/80 p-6 text-center space-y-2">
                    <div class="text-2xl">🗺️</div>
                    <h3 class="text-sm font-extrabold text-[#0f2e54]">Select a Room on the Map</h3>
                    <p class="text-xs text-slate-500">Tap any colored room or pin on the floor plan to view photo, equipment, booking guide, and walking directions.</p>
                </div>
            </template>
        </div>
    </div>

    <!-- Database Zones Quick List for this Floor -->
    @if($zones->isNotEmpty())
        <div class="bg-white rounded-3xl p-4 sm:p-6 soft-shadow border border-slate-200/80">
            <h3 class="text-sm sm:text-base font-extrabold text-[#0f2e54] mb-3">Daftar Titik & Ruangan Terdaftar ({{ $floor }})</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2.5">
                @foreach($zones as $z)
                    <button type="button" @click="selectDbZone({{ Js::from($z) }})"
                            class="text-left p-3 rounded-2xl border border-slate-100 hover:border-sky-300 hover:bg-sky-50/50 bg-slate-50 cursor-pointer transition flex items-center justify-between gap-2 group">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <span class="w-7 h-7 rounded-xl bg-white text-slate-700 font-bold flex items-center justify-center text-xs shadow-2xs shrink-0">
                                {{ $loop->iteration }}
                            </span>
                            <div class="min-w-0">
                                <div class="text-xs font-extrabold text-[#0f2e54] group-hover:text-[#0084f8] truncate">{{ $z->name }}</div>
                                <div class="text-[10px] text-slate-400 truncate">{{ $z->code }} • {{ $z->contact_person }}</div>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-[#0084f8] shrink-0">Rute →</span>
                    </button>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
