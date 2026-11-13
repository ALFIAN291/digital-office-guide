@extends('layouts.app')

@section('content')
@php
    /** @var string $floor */
    /** @var array<string, mixed> $blueprints */
    $floorKey = is_string($floor ?? null) ? $floor : 'Lantai 2';
    $blueprint = $blueprints[$floorKey] ?? $blueprints['Lantai 2'];
    $defaultRoom = collect($blueprint['rooms'])->firstWhere('code', 'MR-05') ?? ($blueprint['rooms'][0] ?? null);

    $floorPills = [
        ['key' => 'Lantai 1', 'short' => '1F', 'building' => 'Main Office'],
        ['key' => 'Lantai 2', 'short' => '2F', 'building' => 'Main Office'],
        ['key' => 'Ground Floor', 'short' => '3F', 'building' => 'Plant & Complex'],
    ];

    $bottomLegends = [
        ['key' => 'all', 'label' => 'Main Entrance', 'bg' => 'bg-[#2b7de9] text-white', 'icon' => '⬆️'],
        ['key' => 'Emergency Exit', 'label' => 'Emergency Exit', 'bg' => 'bg-[#16a34a] text-white', 'icon' => '🏃'],
        ['key' => 'all', 'label' => 'Fire Extinguisher', 'bg' => 'bg-[#e11d48] text-white', 'icon' => '🧯'],
        ['key' => 'Executive Room', 'label' => 'Executive Room', 'bg' => 'bg-[#f8bbd0] text-[#9d174d]', 'icon' => '👤'],
        ['key' => 'Meeting Room', 'label' => 'Meeting Room', 'bg' => 'bg-[#fed7aa] text-[#9a3412]', 'icon' => '👥'],
        ['key' => 'Office Area', 'label' => 'Office Area', 'bg' => 'bg-[#bae6fd] text-[#0369a1]', 'icon' => '💺'],
        ['key' => 'Pantry / Lounge', 'label' => 'Pantry / Lounge', 'bg' => 'bg-[#bbf7d0] text-[#15803d]', 'icon' => '☕'],
        ['key' => 'Support Room', 'label' => 'Support Room', 'bg' => 'bg-[#e9d5ff] text-[#6b21a8]', 'icon' => '🖨️'],
        ['key' => 'Restroom', 'label' => 'Restroom', 'bg' => 'bg-[#cbd5e1] text-[#1e293b]', 'icon' => '🚻'],
    ];
@endphp

<div class="max-w-7xl mx-auto px-3 sm:px-5 pt-2 sm:pt-3 pb-6 space-y-3.5"
     x-data="{
        currentFloor: {{ Js::from($floorKey) }},
        viewMode: 'floor',
        searchQuery: '',
        activeFilter: 'all',
        showRoute: false,
        blueprint: {{ Js::from($blueprint) }},
        dbZones: {{ Js::from($zones) }},
        selectedItem: {{ Js::from($defaultRoom) }},
        selectedIsZone: false,

        selectRoom(room) {
            this.selectedItem = room;
            this.selectedIsZone = false;
        },
        triggerDirection() {
            this.showRoute = true;
            this.viewMode = 'floor';
        },
        selectDbZone(zone) {
            this.selectedItem = {
                code: zone.code || zone.type.toUpperCase(),
                name: zone.name,
                group: zone.area_group || zone.type,
                cx: parseFloat(zone.coord_x) || 50,
                cy: parseFloat(zone.coord_y) || 50,
                capacity: zone.capacity || '8–10 people',
                facilities: zone.facilities_list || zone.description,
                usage: zone.usage_info || zone.description,
                book: zone.how_to_book || (zone.contact_person ? 'Hubungi ' + zone.contact_person : 'Via Meeting Room System (Outlook / Web Portal)'),
                image: zone.image_path || '/images/meeting-room.jpg',
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
            const sx = this.blueprint.start.x;
            const sy = this.blueprint.start.y;
            const tx = this.selectedItem.cx;
            const ty = this.selectedItem.cy;

            // Orthogonal corridor route from Main Entrance (44, 92)
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
            const dx = Math.abs(this.selectedItem.cx - this.blueprint.start.x);
            const dy = Math.abs(this.selectedItem.cy - this.blueprint.start.y);
            return Math.max(12, Math.round((dx * 0.72) + (dy * 0.55)));
        },
        get walkMinutes() {
            return Math.max(1, Math.round(this.distanceMeters / 45));
        }
     }">

    <!-- Top Context Bar: Breadcrumb + 1F/2F/3F Switcher + Main Office Selector -->
    <div class="flex flex-wrap items-center justify-between gap-2.5 bg-white/90 backdrop-blur-xs rounded-2xl px-3.5 py-2 soft-shadow border border-slate-200/80">
        <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
            <a href="{{ route('guide.index') }}" class="hover:text-[#0066dc] font-bold text-[#0f2e54]">KARAWANG OFFICE GUIDE 2026</a>
            <span class="text-slate-300">|</span>
            <span class="text-slate-500 hidden sm:inline">Denah Kantor & Pabrik Karawang</span>
        </div>

        <div class="flex items-center gap-2 sm:gap-3 ml-auto">
            <!-- 1F / 2F / 3F Pills (Matching Screenshot 1 Top Bar) -->
            <div class="inline-flex items-center bg-slate-100 p-1 rounded-xl border border-slate-200/80">
                @foreach($floorPills as $fp)
                    <a href="{{ route('guide.map', ['floor' => $fp['key']]) }}"
                       class="px-3.5 py-1 rounded-lg text-xs font-extrabold transition {{ $floorKey === $fp['key'] ? 'bg-[#0066dc] text-white shadow-xs' : 'text-slate-600 hover:text-[#0f2e54]' }}">
                        {{ $fp['short'] }}
                    </a>
                @endforeach
            </div>

            <!-- Building Dropdown Pill (🏢 Main Office ⌄) -->
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
                     class="absolute right-0 mt-1.5 w-48 bg-white rounded-2xl shadow-xl border border-slate-200 py-1.5 z-40">
                    <a href="{{ route('guide.map', ['floor' => 'Lantai 2']) }}" class="flex items-center justify-between px-3.5 py-2 text-xs font-bold text-slate-700 hover:bg-sky-50 hover:text-[#0066dc]">
                        <span>🏢 Main Office (2F)</span>
                        @if($floorKey === 'Lantai 2') <span class="text-[#0066dc]">✓</span> @endif
                    </a>
                    <a href="{{ route('guide.map', ['floor' => 'Lantai 1']) }}" class="flex items-center justify-between px-3.5 py-2 text-xs font-bold text-slate-700 hover:bg-sky-50 hover:text-[#0066dc]">
                        <span>🏢 Main Office (1F)</span>
                        @if($floorKey === 'Lantai 1') <span class="text-[#0066dc]">✓</span> @endif
                    </a>
                    <a href="{{ route('guide.map', ['floor' => 'Ground Floor']) }}" class="flex items-center justify-between px-3.5 py-2 text-xs font-bold text-slate-700 hover:bg-sky-50 hover:text-[#0066dc]">
                        <span>🏭 Plant 1 & Plant 2 (3F)</span>
                        @if($floorKey === 'Ground Floor') <span class="text-[#0066dc]">✓</span> @endif
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Interactive Container Card (Matching Screenshot 1) -->
    <div class="bg-white/95 rounded-3xl p-3.5 sm:p-5 soft-shadow border border-slate-200/90 space-y-4">

        <!-- Title Row + View Mode Switcher (Floor Plan | 3D View | List View + North Compass) -->
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
                    <button type="button" @click="viewMode = 'floor'"
                            :class="viewMode === 'floor' ? 'bg-[#0066dc] text-white shadow-xs' : 'text-slate-600 hover:text-[#0f2e54]'"
                            class="px-3.5 py-1.5 rounded-lg transition cursor-pointer">
                        Floor Plan
                    </button>
                    <button type="button" @click="viewMode = '3d'"
                            :class="viewMode === '3d' ? 'bg-[#0066dc] text-white shadow-xs' : 'text-slate-600 hover:text-[#0f2e54]'"
                            class="px-3.5 py-1.5 rounded-lg transition cursor-pointer inline-flex items-center gap-1.5">
                        <span>🧊</span>
                        <span>3D View</span>
                    </button>
                    <button type="button" @click="viewMode = 'list'"
                            :class="viewMode === 'list' ? 'bg-[#0066dc] text-white shadow-xs' : 'text-slate-600 hover:text-[#0f2e54]'"
                            class="px-3.5 py-1.5 rounded-lg transition cursor-pointer inline-flex items-center gap-1.5">
                        <span>≣</span>
                        <span>List View</span>
                    </button>
                </div>

                <!-- Circular North Compass (▲ N) -->
                <div class="w-9 h-9 rounded-full border border-slate-200 bg-white shadow-2xs flex flex-col items-center justify-center leading-none text-[#0f2e54]" title="North Orientation">
                    <span class="text-[9px] text-[#0066dc] font-black">▲</span>
                    <span class="text-[9px] font-black">N</span>
                </div>
            </div>
        </div>

        <!-- Center Split: 2D Architectural Floor Plan (Left 8) + Room Detail Card (Right 4) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-stretch">

            <!-- Left 8 Cols: Architectural Floor Plan Canvas -->
            <div class="lg:col-span-8 flex flex-col">
                <div x-show="viewMode !== 'list'" class="relative w-full aspect-[16/10] min-h-[340px] sm:min-h-[430px] rounded-2xl overflow-hidden border-2 border-slate-300 shadow-md bg-[#4d5966] select-none transition-transform duration-500"
                     :style="viewMode === '3d' ? 'transform: perspective(1100px) rotateX(24deg) rotateZ(-3deg) scale(0.96); box-shadow: 0 24px 40px -12px rgba(15,46,84,0.32);' : ''">

                    <!-- Architectural SVG Floor Plan Base (Landscaping, Walls, Desks, Spiral Stairs, Restroom, Entrance) -->
                    <svg class="absolute inset-0 w-full h-full pointer-events-none" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <defs>
                            <pattern id="openOfficeGrid" width="2.5" height="2.5" patternUnits="userSpaceOnUse">
                                <path d="M 2.5 0 L 0 0 0 2.5" fill="none" stroke="#e5dec9" stroke-width="0.18" />
                            </pattern>
                            <pattern id="stairTileGrid" width="2" height="2" patternUnits="userSpaceOnUse">
                                <path d="M 2 0 L 0 0 0 2" fill="none" stroke="#94a3b8" stroke-width="0.25" />
                            </pattern>
                            <pattern id="woodFloor" width="1.5" height="4" patternUnits="userSpaceOnUse">
                                <rect width="1.5" height="4" fill="#d89b52"/>
                                <path d="M 0 0 L 0 4" stroke="#b97a32" stroke-width="0.25"/>
                            </pattern>
                        </defs>

                        <!-- Exterior Pavement / Lot Background -->
                        <rect x="0" y="0" width="100" height="100" fill="#64748b" />

                        <!-- Perimeter Green Planter Strips & Trees (Matching Screenshot 1) -->
                        <rect x="1" y="1" width="98" height="4.5" fill="#2e7d32" />
                        <rect x="1" y="1" width="3.8" height="92" fill="#2e7d32" />
                        <rect x="95.8" y="1" width="3.2" height="92" fill="#2e7d32" />
                        <!-- Bottom Planters Left & Right of Main Entrance -->
                        <rect x="12" y="88.5" width="26" height="9.5" rx="1" fill="#2e7d32" />
                        <rect x="52" y="88.5" width="44" height="9.5" rx="1" fill="#2e7d32" />

                        <!-- Decorative Lush Bushes / Trees Around Perimeter -->
                        @foreach([6, 13, 21, 29, 37, 46, 55, 64, 73, 82, 91] as $tx)
                            <circle cx="{{ $tx }}" cy="3" r="2.1" fill="#4caf50" />
                            <circle cx="{{ $tx + 0.6 }}" cy="2.7" r="1.2" fill="#81c784" />
                        @endforeach
                        @foreach([10, 20, 32, 44, 56, 68, 80] as $ty)
                            <circle cx="2.6" cy="{{ $ty }}" r="2.2" fill="#4caf50" />
                            <circle cx="2.4" cy="{{ $ty - 0.5 }}" r="1.3" fill="#81c784" />
                            <circle cx="97.4" cy="{{ $ty }}" r="2.1" fill="#4caf50" />
                            <circle cx="97.2" cy="{{ $ty - 0.5 }}" r="1.2" fill="#81c784" />
                        @endforeach
                        @foreach([16, 22, 29, 35, 56, 63, 70, 77, 84, 91] as $bx)
                            <circle cx="{{ $bx }}" cy="93.5" r="3.2" fill="#4caf50" />
                            <circle cx="{{ $bx - 0.5 }}" cy="92.8" r="1.8" fill="#a5d6a7" />
                        @endforeach

                        <!-- Main Building Interior Floor Slab -->
                        <rect x="4.5" y="5.5" width="91.3" height="83" rx="0.8" fill="#f3efe6" stroke="#334155" stroke-width="0.7" />
                        <rect x="18" y="28" width="66.5" height="59.5" fill="url(#openOfficeGrid)" />

                        @if($floorKey === 'Lantai 2')
                            <!-- Left-Bottom Tiled Emergency Stairwell Box (Below Meeting 5) -->
                            <rect x="5" y="72.5" width="13" height="15" fill="#cbd5e1" stroke="#475569" stroke-width="0.5" />
                            <rect x="6" y="73.5" width="11" height="13" fill="url(#stairTileGrid)" />

                            <!-- Open Office Workstation Pods: Top Row (5 Double Desk Pods) -->
                            @foreach([23.5, 31, 38.5, 46, 53.5] as $dx)
                                <!-- Chairs Left -->
                                <rect x="{{ $dx - 1.1 }}" y="36.2" width="1.1" height="2.2" rx="0.3" fill="#334155" />
                                <rect x="{{ $dx - 1.1 }}" y="40.0" width="1.1" height="2.2" rx="0.3" fill="#334155" />
                                <rect x="{{ $dx - 1.1 }}" y="43.8" width="1.1" height="2.2" rx="0.3" fill="#334155" />
                                <rect x="{{ $dx - 1.1 }}" y="47.6" width="1.1" height="2.2" rx="0.3" fill="#334155" />
                                <!-- Chairs Right -->
                                <rect x="{{ $dx + 3.0 }}" y="36.2" width="1.1" height="2.2" rx="0.3" fill="#334155" />
                                <rect x="{{ $dx + 3.0 }}" y="40.0" width="1.1" height="2.2" rx="0.3" fill="#334155" />
                                <rect x="{{ $dx + 3.0 }}" y="43.8" width="1.1" height="2.2" rx="0.3" fill="#334155" />
                                <rect x="{{ $dx + 3.0 }}" y="47.6" width="1.1" height="2.2" rx="0.3" fill="#334155" />
                                <!-- White Desk Cluster Table -->
                                <rect x="{{ $dx }}" y="35.2" width="3.0" height="15.5" rx="0.4" fill="#ffffff" stroke="#94a3b8" stroke-width="0.3" />
                                <line x1="{{ $dx + 1.5 }}" y1="35.5" x2="{{ $dx + 1.5 }}" y2="50.4" stroke="#cbd5e1" stroke-width="0.3" />
                                <!-- Small Green Planter Dots on Desk Ends -->
                                <circle cx="{{ $dx + 1.5 }}" cy="35.5" r="0.6" fill="#22c55e" />
                                <circle cx="{{ $dx + 1.5 }}" cy="50.5" r="0.6" fill="#22c55e" />
                            @endforeach

                            <!-- Open Office Workstation Pods: Bottom Row (5 Double Desk Pods) -->
                            @foreach([23.5, 31, 38.5, 46, 53.5] as $dx)
                                <!-- Chairs Left -->
                                <rect x="{{ $dx - 1.1 }}" y="63.2" width="1.1" height="2.2" rx="0.3" fill="#334155" />
                                <rect x="{{ $dx - 1.1 }}" y="67.0" width="1.1" height="2.2" rx="0.3" fill="#334155" />
                                <rect x="{{ $dx - 1.1 }}" y="70.8" width="1.1" height="2.2" rx="0.3" fill="#334155" />
                                <rect x="{{ $dx - 1.1 }}" y="74.6" width="1.1" height="2.2" rx="0.3" fill="#334155" />
                                <!-- Chairs Right -->
                                <rect x="{{ $dx + 3.0 }}" y="63.2" width="1.1" height="2.2" rx="0.3" fill="#334155" />
                                <rect x="{{ $dx + 3.0 }}" y="67.0" width="1.1" height="2.2" rx="0.3" fill="#334155" />
                                <rect x="{{ $dx + 3.0 }}" y="70.8" width="1.1" height="2.2" rx="0.3" fill="#334155" />
                                <rect x="{{ $dx + 3.0 }}" y="74.6" width="1.1" height="2.2" rx="0.3" fill="#334155" />
                                <!-- White Desk Cluster Table -->
                                <rect x="{{ $dx }}" y="62.2" width="3.0" height="15.5" rx="0.4" fill="#ffffff" stroke="#94a3b8" stroke-width="0.3" />
                                <line x1="{{ $dx + 1.5 }}" y1="62.5" x2="{{ $dx + 1.5 }}" y2="77.4" stroke="#cbd5e1" stroke-width="0.3" />
                                <circle cx="{{ $dx + 1.5 }}" cy="62.5" r="0.6" fill="#22c55e" />
                                <circle cx="{{ $dx + 1.5 }}" cy="77.5" r="0.6" fill="#22c55e" />
                            @endforeach

                            <!-- East Wing Wooden Feature Floor & Spiral Staircase Area (x=68..84, y=56..86) -->
                            <rect x="68" y="56" width="16" height="30" fill="url(#woodFloor)" stroke="#78350f" stroke-width="0.4" />
                            <!-- Spiral Staircase Circle -->
                            <circle cx="77" cy="67.5" r="6.2" fill="#f8fafc" stroke="#64748b" stroke-width="0.45" />
                            @for($deg = 0; $deg < 360; $deg += 24)
                                @php
                                    $rad = deg2rad($deg);
                                    $x2 = round(77 + 6.0 * cos($rad), 2);
                                    $y2 = round(67.5 + 6.0 * sin($rad), 2);
                                @endphp
                                <line x1="77" y1="67.5" x2="{{ $x2 }}" y2="{{ $y2 }}" stroke="#94a3b8" stroke-width="0.3" />
                            @endfor
                            <circle cx="77" cy="67.5" r="1.8" fill="#d89b52" stroke="#64748b" stroke-width="0.4" />
                            <!-- Lounge Sofa & Coffee Table under Spiral Staircase -->
                            <rect x="69.2" y="79.5" width="6.5" height="4.2" rx="0.8" fill="#0f535c" />
                            <circle cx="78.5" cy="81.5" r="1.8" fill="#fde68a" stroke="#b45309" stroke-width="0.3" />
                        @endif

                        <!-- Bottom Main Entrance Doorway & Blue Up Arrow -->
                        <rect x="39" y="87.2" width="10" height="3.2" fill="#e2e8f0" stroke="#475569" stroke-width="0.35" />
                        <rect x="41" y="88" width="6" height="1.5" fill="#0284c7" />
                        <path d="M 44 93.5 L 44 90.2 M 42.6 91.5 L 44 89.8 L 45.4 91.5" stroke="#0066dc" stroke-width="0.7" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                    <!-- Interactive Color-Coded Rooms -->
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

                    <!-- Fire Extinguisher (🧯) & Emergency Exit (🏃) Badges on Floor Plan -->
                    <template x-for="(ic, i) in blueprint.icons" :key="i">
                        <div class="absolute -translate-x-1/2 -translate-y-1/2 z-25 pointer-events-auto"
                             :style="`left: ${ic.x}%; top: ${ic.y}%;`"
                             :title="ic.label">
                            <span class="w-4 h-4 sm:w-5 sm:h-5 rounded-md flex items-center justify-center text-[8px] sm:text-[10px] font-bold shadow-md border border-white"
                                  :class="{
                                    'bg-[#16a34a] text-white': ic.type === 'exit',
                                    'bg-[#e11d48] text-white': ic.type === 'apar',
                                    'bg-[#0284c7] text-white': ic.type === 'restroom',
                                    'bg-[#7c3aed] text-white': ic.type === 'stairs',
                                    'bg-[#475569] text-white': ic.type === 'elevator',
                                  }">
                                <span x-text="ic.type === 'exit' ? '🏃' : (ic.type === 'apar' ? '🧯' : (ic.type === 'restroom' ? '🚻' : (ic.type === 'stairs' ? '🪜' : '🛗')))"></span>
                            </span>
                        </div>
                    </template>

                    <!-- Animated Walking Route Overlay (When Get Direction is clicked) -->
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

                    <!-- Bottom Center "MAIN ENTRANCE" Blue Pill (Matching Screenshot 1) -->
                    <div class="absolute bottom-1.5 left-[44%] -translate-x-1/2 px-3 py-1 rounded-lg bg-[#0066dc] text-white text-[8px] sm:text-[10px] font-black tracking-wider uppercase shadow-lg border border-white/80 pointer-events-none z-30">
                        MAIN ENTRANCE
                    </div>
                </div>

                <!-- List View Mode -->
                <div x-show="viewMode === 'list'" x-cloak class="p-3 sm:p-4 bg-slate-50 rounded-2xl border border-slate-200 space-y-2 max-h-[430px] overflow-y-auto">
                    <div class="mb-2">
                        <input type="text" x-model="searchQuery" placeholder="Search room or area..."
                               class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:outline-hidden focus:border-[#0066dc]">
                    </div>
                    <template x-for="room in blueprint.rooms" :key="room.code">
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
                            <span class="px-3 py-1 rounded-lg bg-sky-50 text-[#0066dc] text-[11px] font-bold shrink-0">View on Map →</span>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Right 4 Cols: Selected Room Detail Card (Matching Screenshot 1) -->
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
                                <!-- Soft Pink Room Header Banner (Matching Screenshot 1) -->
                                <div class="p-2.5 sm:p-3 rounded-2xl bg-rose-50/90 border border-rose-100 flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-rose-400 text-white flex items-center justify-center text-lg shadow-2xs shrink-0">
                                        <span x-text="selectedItem.icon || '👥'"></span>
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="text-sm sm:text-base font-extrabold text-[#0f2e54] leading-tight truncate" x-text="selectedItem.name"></h3>
                                        <div class="text-[11px] font-semibold text-slate-500 mt-0.5" x-text="(blueprint.code === '2F' ? '2nd Floor' : blueprint.code) + ' • ' + selectedItem.group"></div>
                                    </div>
                                </div>

                                <!-- 4 Metadata Rows with Blue Icons (Capacity, Facilities, Usage, How to Book) -->
                                <div class="space-y-2.5 text-xs">
                                    <!-- Capacity -->
                                    <div class="flex items-start gap-3">
                                        <div class="w-7 h-7 rounded-lg bg-sky-50 text-[#0066dc] flex items-center justify-center shrink-0 mt-0.5">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-extrabold text-[#0f2e54]">Capacity</div>
                                            <div class="text-slate-600" x-text="selectedItem.capacity"></div>
                                        </div>
                                    </div>

                                    <!-- Facilities -->
                                    <div class="flex items-start gap-3">
                                        <div class="w-7 h-7 rounded-lg bg-sky-50 text-[#0066dc] flex items-center justify-center shrink-0 mt-0.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                                <line x1="8" y1="21" x2="16" y2="21"></line>
                                                <line x1="12" y1="17" x2="12" y2="21"></line>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-extrabold text-[#0f2e54]">Facilities</div>
                                            <div class="text-slate-600 leading-snug" x-text="selectedItem.facilities"></div>
                                        </div>
                                    </div>

                                    <!-- Usage -->
                                    <div class="flex items-start gap-3">
                                        <div class="w-7 h-7 rounded-lg bg-sky-50 text-[#0066dc] flex items-center justify-center shrink-0 mt-0.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-extrabold text-[#0f2e54]">Usage</div>
                                            <div class="text-slate-600 leading-snug" x-text="selectedItem.usage"></div>
                                        </div>
                                    </div>

                                    <!-- How to Book -->
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
                                            <div class="font-extrabold text-[#0f2e54]">How to Book</div>
                                            <div class="text-slate-600 leading-snug" x-text="selectedItem.book"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom CTA Button: Get Direction -->
                        <div class="p-3.5 sm:p-4 pt-0 space-y-2">
                            <button type="button" @click="triggerDirection()"
                                    class="w-full py-2.5 px-4 rounded-full bg-gradient-to-r from-[#0055c4] to-[#0078f0] hover:from-[#0046a3] hover:to-[#0066d6] text-white text-xs sm:text-sm font-extrabold shadow-md flex items-center justify-center gap-2 transition cursor-pointer">
                                <svg class="w-4 h-4 -rotate-45" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                                </svg>
                                <span>Get Direction</span>
                            </button>

                            <template x-if="selectedItem.facility_slug">
                                <a :href="'/facilities/' + selectedItem.facility_slug"
                                   class="block w-full text-center py-2 px-4 rounded-full bg-sky-50 hover:bg-sky-100 text-[#0066dc] text-[11px] font-extrabold border border-sky-200 transition">
                                    View Facility Details & Equipment →
                                </a>
                            </template>
                        </div>
                    </div>
                </template>

                <template x-if="!selectedItem">
                    <div class="bg-white rounded-2xl soft-shadow border border-slate-200/80 p-6 text-center flex flex-col items-center justify-center h-full space-y-2">
                        <div class="text-3xl">🗺️</div>
                        <h3 class="text-sm font-extrabold text-[#0f2e54]">Select an Area on the Floor Plan</h3>
                        <p class="text-xs text-slate-500">Tap any colored room on the map to see its capacity, equipment, booking method, and walking directions.</p>
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
