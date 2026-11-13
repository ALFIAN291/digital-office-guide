@extends('layouts.admin')

@section('title', 'Kelola Desk QR & Tent Card')

@section('content')
@php
    $initialMode = $selectedDesk ? 'edit' : 'create';
    $initialImagePath = old('image_path', $selectedDesk?->image_path ?: 'images/hero-office.jpg');
    $initialData = [
        'id' => $selectedDesk?->id,
        'name' => old('name', $selectedDesk?->name ?? 'Bran'),
        'department' => old('department', $selectedDesk?->department ?? 'IT Department'),
        'sub_team' => old('sub_team', $selectedDesk?->sub_team ?? 'Infrastructure & Security'),
        'desk_number' => old('desk_number', $selectedDesk?->desk_number ?? 'A-023'),
        'floor' => old('floor', $selectedDesk?->floor ?? '2'),
        'area' => old('area', $selectedDesk?->area ?? 'Office Building'),
        'image_path' => $initialImagePath,
        'image_preview' => office_image($initialImagePath, 'images/hero-office.jpg'),
    ];
    $presetImages = [
        ['label' => 'Gedung Utama', 'path' => 'images/hero-office.jpg', 'url' => asset('images/hero-office.jpg')],
        ['label' => 'Open Workspace', 'path' => 'images/facilities-office.jpg', 'url' => asset('images/facilities-office.jpg')],
        ['label' => 'Management Area', 'path' => 'images/management-office.jpg', 'url' => asset('images/management-office.jpg')],
    ];
@endphp

<script>
    window.__DESK_INITIAL_MODE__ = @json($initialMode);
    window.__DESK_INITIAL_DATA__ = @json($initialData);
    window.__DESK_BASE_URL__ = @json(url('/'));
    window.__DESK_STORE_URL__ = @json(route('admin.desks.store'));
    window.__DESK_ADMIN_URL__ = @json(url('/admin/desks'));
    window.__DESK_PRESET_IMAGES__ = @json($presetImages);

    function adminDeskBuilder() {
        return {
            mode: window.__DESK_INITIAL_MODE__ || 'edit',
            deskId: window.__DESK_INITIAL_DATA__.id || null,
            name: window.__DESK_INITIAL_DATA__.name || 'Bran',
            department: window.__DESK_INITIAL_DATA__.department || 'IT Department',
            sub_team: window.__DESK_INITIAL_DATA__.sub_team || 'Infrastructure & Security',
            desk_number: window.__DESK_INITIAL_DATA__.desk_number || 'A-023',
            floor: window.__DESK_INITIAL_DATA__.floor || '2',
            area: window.__DESK_INITIAL_DATA__.area || 'Office Building',
            image_path: window.__DESK_INITIAL_DATA__.image_path || 'images/hero-office.jpg',
            imagePreview: window.__DESK_INITIAL_DATA__.image_preview || '',
            presets: window.__DESK_PRESET_IMAGES__ || [],
            qrSvg: '',
            searchQuery: '',

            init() {
                this.renderQr();
                this.$watch('desk_number', () => this.renderQr());
                this.$watch('name', () => this.renderQr());
            },

            get formAction() {
                if (this.mode === 'edit' && this.deskId) {
                    return window.__DESK_ADMIN_URL__ + '/' + this.deskId;
                }
                return window.__DESK_STORE_URL__;
            },

            get printSingleUrl() {
                if (this.deskId) {
                    return window.__DESK_ADMIN_URL__ + '/' + this.deskId + '/print';
                }
                return window.__DESK_ADMIN_URL__ + '/all/print';
            },

            get qrTargetUrl() {
                const params = new URLSearchParams({
                    desk: this.desk_number || 'A-023'
                });
                return window.__DESK_BASE_URL__ + '/?' + params.toString();
            },

            get nameSizeClass() {
                const len = (this.name || '').trim().length;
                if (len > 28) {
                    return 'text-base sm:text-lg leading-snug';
                }
                if (len > 18) {
                    return 'text-lg sm:text-xl leading-tight';
                }
                return 'text-xl sm:text-3xl leading-tight';
            },

            async renderQr() {
                if (!window.QRCode) {
                    setTimeout(() => this.renderQr(), 150);
                    return;
                }
                try {
                    this.qrSvg = await window.QRCode.toString(this.qrTargetUrl, {
                        type: 'svg',
                        width: 220,
                        margin: 1,
                        errorCorrectionLevel: 'M',
                        color: { dark: '#0f172a', light: '#ffffff' }
                    });
                } catch (e) {
                    console.error(e);
                }
            },

            onFileChange(event) {
                const file = event.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            selectPreset(preset) {
                this.image_path = preset.path;
                this.imagePreview = preset.url;
                if (this.$refs.imageInput) {
                    this.$refs.imageInput.value = '';
                }
            },

            triggerImageUpload() {
                if (this.$refs.imageInput) {
                    this.$refs.imageInput.click();
                }
            },

            switchToCreate() {
                this.mode = 'create';
                this.deskId = null;
                this.name = '';
                this.department = '';
                this.sub_team = '';
                this.desk_number = '';
                this.floor = '2';
                this.area = 'Office Building';
                if (this.$refs.imageInput) {
                    this.$refs.imageInput.value = '';
                }
                this.renderQr();
            },

            selectDesk(desk) {
                this.mode = 'edit';
                this.deskId = desk.id;
                this.name = desk.name;
                this.department = desk.department;
                this.sub_team = desk.sub_team || '';
                this.desk_number = desk.desk_number;
                this.floor = desk.floor;
                this.area = desk.area;
                this.image_path = desk.image_path || 'images/hero-office.jpg';
                if (desk.image_path && (desk.image_path.startsWith('http') || desk.image_path.startsWith('data:'))) {
                    this.imagePreview = desk.image_path;
                } else {
                    this.imagePreview = window.__DESK_BASE_URL__ + '/' + (desk.image_path || 'images/hero-office.jpg').replace(/^\/+/, '');
                }
                if (this.$refs.imageInput) {
                    this.$refs.imageInput.value = '';
                }
                this.renderQr();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            },

            simulateScanAndOpen() {
                const profile = {
                    name: this.name || 'Employee',
                    dept: this.department || 'Department',
                    team: this.sub_team || '',
                    desk: this.desk_number || 'A-023',
                    floor: this.floor || '2',
                    area: this.area || 'Office Building'
                };
                localStorage.setItem('akebono_desk_profile', JSON.stringify(profile));
                window.open(this.qrTargetUrl, '_blank');
            }
        };
    }
</script>

<div class="space-y-6" x-data="adminDeskBuilder()">

    <!-- Header & Print Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-sky-50 border border-sky-200 text-[#0084f8] text-xs font-extrabold mb-2">
                <span>🪪</span>
                <span>ADMIN DESK ONBOARDING GENERATOR</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-[#0f2e54] tracking-tight">Desk QR Onboarding & Tent Card</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola data & foto meja kerja karyawan di database dan cetak Tent Card lipat (150×70×70 mm)</p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <button type="button" @click="switchToCreate()"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-sky-50 hover:bg-sky-100 text-[#0084f8] border border-sky-200 text-xs font-extrabold transition cursor-pointer">
                <span>➕</span>
                <span>Tambah Desk Baru</span>
            </button>

            <a :href="printSingleUrl" target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-[#0f2e54] hover:bg-[#163d6e] text-white text-xs font-extrabold shadow-sm transition">
                <span>🖨️</span>
                <span x-text="deskId ? 'Print Tent Card (' + (desk_number || 'Desk') + ')' : 'Print Tent Card'"></span>
            </a>

            @if($desks->count() > 0)
            <a href="{{ route('admin.desks.print', 'all') }}" target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-extrabold shadow-sm transition">
                <span>🖨️</span>
                <span>Print Semua ({{ $desks->count() }} Desk)</span>
            </a>
            @endif
        </div>
    </div>

    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold space-y-1">
            <div class="font-extrabold">⚠️ Mohon periksa kembali input Anda:</div>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Main Customizer + Tent Card Preview Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Left Column: Database Form (Save / Update + Image Upload) -->
        <div class="lg:col-span-4 bg-white rounded-3xl border border-slate-200/90 p-5 sm:p-6 shadow-xs space-y-4">
            <div class="flex items-center justify-between gap-2 border-b border-slate-100 pb-3">
                <div>
                    <h2 class="text-base font-extrabold text-[#0f2e54]" x-text="mode === 'edit' && deskId ? 'Edit Desk & QR Karyawan' : 'Tambah Desk & QR Baru'"></h2>
                    <p class="text-xs text-slate-500 mt-0.5">Data & foto disimpan ke database dan langsung memperbarui kartu</p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider"
                      :class="mode === 'edit' && deskId ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-emerald-50 text-emerald-700 border border-emerald-200'"
                      x-text="mode === 'edit' && deskId ? 'Mode Edit' : 'Baru'"></span>
            </div>

            <form :action="formAction" method="POST" enctype="multipart/form-data" class="space-y-3.5">
                @csrf
                <template x-if="mode === 'edit' && deskId">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Karyawan: <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" x-model="name" required placeholder="Contoh: Bran"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-800 focus:outline-none focus:border-[#0084f8]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Departemen: <span class="text-rose-500">*</span></label>
                    <input type="text" name="department" x-model="department" required placeholder="Contoh: IT Department"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-800 focus:outline-none focus:border-[#0084f8]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Sub-Team / Seksi:</label>
                    <input type="text" name="sub_team" x-model="sub_team" placeholder="Contoh: Infrastructure & Security"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-800 focus:outline-none focus:border-[#0084f8]">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Desk: <span class="text-rose-500">*</span></label>
                        <input type="text" name="desk_number" x-model="desk_number" required placeholder="A-023"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm font-extrabold text-[#0f2e54] uppercase focus:outline-none focus:border-[#0084f8]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Floor / Lantai: <span class="text-rose-500">*</span></label>
                        <input type="text" name="floor" x-model="floor" required placeholder="2"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-800 focus:outline-none focus:border-[#0084f8]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Area Gedung: <span class="text-rose-500">*</span></label>
                    <input type="text" name="area" x-model="area" required placeholder="Office Building"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-800 focus:outline-none focus:border-[#0084f8]">
                </div>

                <!-- Image Picker & Upload for Front Side Card -->
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2.5">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-extrabold text-[#0f2e54]">🖼️ Gambar Kartu (Front Side):</label>
                        <span class="text-[10px] font-semibold text-slate-400">JPG/PNG/WebP</span>
                    </div>

                    <input type="hidden" name="image_path" :value="image_path">

                    <!-- Upload Custom File -->
                    <input type="file" name="image" x-ref="imageInput" accept="image/*" @change="onFileChange($event)"
                           class="block w-full text-xs text-slate-600 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#0084f8] file:text-white hover:file:bg-[#006fd6] cursor-pointer">

                    <!-- Quick Preset Thumbnails -->
                    <div>
                        <div class="text-[10px] font-bold text-slate-500 mb-1.5">Atau pilih template foto gedung:</div>
                        <div class="grid grid-cols-3 gap-2">
                            <template x-for="preset in presets" :key="preset.path">
                                <button type="button" @click="selectPreset(preset)"
                                        class="group relative rounded-lg overflow-hidden border-2 transition h-12 cursor-pointer"
                                        :class="image_path === preset.path ? 'border-[#0084f8] ring-2 ring-[#0084f8]/25' : 'border-slate-200 hover:border-slate-300'">
                                    <img :src="preset.url" :alt="preset.label" class="w-full h-full object-cover">
                                    <span class="absolute inset-x-0 bottom-0 bg-slate-900/70 text-white text-[9px] font-bold py-0.5 truncate px-1" x-text="preset.label"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <label class="flex items-center gap-2 pt-1 cursor-pointer">
                        <input type="checkbox" name="apply_image_all" value="1" class="rounded border-slate-300 text-[#0084f8] focus:ring-[#0084f8]">
                        <span class="text-[11px] font-semibold text-slate-600">Terapkan gambar ini ke semua kartu desk</span>
                    </label>
                </div>

                <div class="pt-2 space-y-2.5">
                    <button type="submit"
                            class="w-full py-3 px-4 rounded-xl bg-[#0084f8] hover:bg-[#006fd6] text-white font-extrabold text-xs shadow-sm transition flex items-center justify-center gap-2 cursor-pointer">
                        <span>💾</span>
                        <span x-text="mode === 'edit' && deskId ? 'Simpan Perubahan ke Database' : 'Simpan Desk Baru ke Database'"></span>
                    </button>

                    <div class="grid grid-cols-2 gap-2">
                        <a :href="printSingleUrl" target="_blank"
                           class="py-2.5 px-3 rounded-xl bg-[#0f2e54] hover:bg-[#163d6e] text-white font-extrabold text-xs text-center transition flex items-center justify-center gap-1.5">
                            <span>🖨️</span>
                            <span>Print Desk Ini</span>
                        </a>
                        <button type="button" @click="simulateScanAndOpen()"
                                class="py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-sky-50 text-slate-700 hover:text-[#0084f8] border border-slate-200 font-bold text-xs transition flex items-center justify-center gap-1.5 cursor-pointer">
                            <span>📱</span>
                            <span>Tes Scan QR ↗</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Right Column: Live Landscape Tent Card Preview (Front + Back matching Concept Mockup) -->
        <div class="lg:col-span-8 space-y-6">

            <!-- FRONT SIDE LANDSCAPE TENT CARD (150 x 70 mm ratio) -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-[#1e4b7a] text-white text-xs font-extrabold shadow-2xs">
                        Front Side <span class="font-normal text-sky-200">(Employee Information)</span>
                    </span>
                    <button type="button" @click="triggerImageUpload()"
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-sky-50 hover:bg-sky-100 text-[#0084f8] border border-sky-200 text-xs font-bold transition cursor-pointer">
                        <span>📷</span>
                        <span>Ganti Gambar Kartu</span>
                    </button>
                </div>

                <div class="relative w-full aspect-[150/70] min-h-[250px] bg-gradient-to-br from-white via-[#f8fbff] to-[#eef5fc] rounded-2xl border-2 border-slate-200/90 shadow-md overflow-hidden select-none group">

                    <!-- Right-side Angled Geometric Stripes & Editable Building Photo (47% width so long names on left never cross) -->
                    <div class="absolute inset-y-0 right-0 w-[47%] overflow-hidden">
                        <!-- Light sky diagonal accent -->
                        <div class="absolute inset-0 bg-gradient-to-b from-[#69a9e8]/45 to-[#0051a8]/20 pointer-events-none"
                             style="clip-path: polygon(24% 0, 100% 0, 100% 100%, 0% 100%);"></div>

                        <!-- White gap stripe -->
                        <div class="absolute inset-0 bg-white/90 pointer-events-none"
                             style="clip-path: polygon(29% 0, 33% 0, 9% 100%, 5% 100%);"></div>

                        <!-- Building Photo Masked (Clickable to change image) -->
                        <div @click="triggerImageUpload()" title="Klik untuk mengganti gambar"
                             class="absolute inset-0 overflow-hidden cursor-pointer"
                             style="clip-path: polygon(34% 0, 100% 0, 100% 82%, 12% 82%);">
                            <img :src="imagePreview" alt="Akebono Office"
                                 class="w-full h-full object-cover object-center transition-transform duration-300 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-r from-white/35 via-transparent to-transparent"></div>
                            <div class="absolute top-3 right-3 bg-slate-900/70 hover:bg-slate-900 text-white text-[10px] font-bold px-2.5 py-1 rounded-full backdrop-blur-xs opacity-85 group-hover:opacity-100 transition flex items-center gap-1">
                                <span>📷</span>
                                <span>Ubah Foto</span>
                            </div>
                        </div>

                        <!-- Bottom-Right Deep Corporate Blue Polygon Wedge -->
                        <div class="absolute inset-0 bg-gradient-to-r from-[#004b9b] to-[#003775] pointer-events-none"
                             style="clip-path: polygon(14% 74%, 100% 79%, 100% 100%, 24% 100%);"></div>
                    </div>

                    <!-- Left & Bottom Foreground Content (Strictly bounded to 54% width so long names wrap cleanly and never cross into photo) -->
                    <div class="relative z-10 h-full flex flex-col justify-between p-5 sm:p-7 w-[55%] pr-3">
                        <!-- Top Logo + Office Relocation Heading -->
                        <div>
                            <img src="{{ asset('images/akebono.png') }}" alt="akebono" class="h-5 sm:h-6 w-auto object-contain mb-1.5">
                            <div class="text-[11px] sm:text-xs font-semibold text-slate-600 tracking-tight">Office Relocation</div>
                            <div class="text-base sm:text-2xl font-black text-[#004b9b] uppercase leading-[1.08] tracking-tight mt-0.5">
                                WELCOME TO<br>YOUR NEW DESK
                            </div>
                        </div>

                        <!-- Employee Name & Department (Auto-scales font size & wraps within left column) -->
                        <div class="my-1 max-w-full overflow-hidden">
                            <div class="font-black text-slate-900 tracking-tight break-words line-clamp-2"
                                 :class="nameSizeClass"
                                 x-text="name || 'Bran'"></div>
                            <div class="text-xs sm:text-sm font-semibold text-slate-800 leading-snug mt-0.5 truncate" x-text="department || 'IT Department'"></div>
                            <div class="text-[11px] sm:text-xs text-slate-600 leading-snug truncate" x-text="sub_team || 'Infrastructure & Security'"></div>
                        </div>

                        <!-- Bottom Desk / Floor / Area Metadata Bar -->
                        <div class="flex items-center gap-3 sm:gap-5 pt-1">
                            <!-- Desk -->
                            <div class="flex items-center gap-1.5 shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#004b9b] shrink-0" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 10h16M4 14h16M6 10V6a1 1 0 011-1h10a1 1 0 011 1v4M5 10v9m14-9v9"/>
                                </svg>
                                <div class="leading-tight">
                                    <div class="text-[9px] sm:text-[10px] font-medium text-slate-500">Desk</div>
                                    <div class="text-xs sm:text-sm font-black text-slate-900" x-text="desk_number || 'A-023'"></div>
                                </div>
                            </div>

                            <!-- Floor -->
                            <div class="flex items-center gap-1.5 shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#004b9b] shrink-0" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1"/>
                                </svg>
                                <div class="leading-tight">
                                    <div class="text-[9px] sm:text-[10px] font-medium text-slate-500">Floor</div>
                                    <div class="text-xs sm:text-sm font-black text-slate-900" x-text="floor || '2'"></div>
                                </div>
                            </div>

                            <!-- Area -->
                            <div class="flex items-center gap-1.5 min-w-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#004b9b] shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                                </svg>
                                <div class="leading-tight min-w-0">
                                    <div class="text-[9px] sm:text-[10px] font-medium text-slate-500">Area</div>
                                    <div class="text-xs sm:text-sm font-black text-slate-900 truncate" x-text="area || 'Office Building'"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BACK SIDE LANDSCAPE TENT CARD (150 x 70 mm ratio) -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-[#1e4b7a] text-white text-xs font-extrabold shadow-2xs">
                        Back Side <span class="font-normal text-sky-200">(QR Code & Onboarding)</span>
                    </span>
                    <span class="text-[11px] font-bold text-slate-400">150 mm (W) × 70 mm (H)</span>
                </div>

                <div class="relative w-full aspect-[150/70] min-h-[260px] bg-gradient-to-br from-white via-[#f8fbff] to-[#eef5fc] rounded-2xl border-2 border-slate-200/90 shadow-md overflow-hidden select-none">

                    <!-- Top-Right Angled Corporate Blue Ribbon ("A New Workplace / A New Experience") -->
                    <div class="absolute top-0 right-0 w-[44%] h-[26%] bg-gradient-to-r from-[#0051a8] to-[#003b80] flex items-center justify-end pr-6 sm:pr-8 pointer-events-none"
                         style="clip-path: polygon(18% 0, 100% 0, 100% 100%, 0% 100%);">
                        <div class="text-right text-white italic font-serif text-xs sm:text-sm leading-snug tracking-wide drop-shadow-2xs">
                            <div>A New Workplace</div>
                            <div>A New Experience</div>
                        </div>
                    </div>

                    <!-- Main Back Side Grid -->
                    <div class="relative z-10 h-full grid grid-cols-12 gap-4 px-5 sm:px-7 py-4 sm:py-5 items-center">

                        <!-- Left 6 Cols: Logo + SCAN TO START + Large Prominent QR + Phone Caption -->
                        <div class="col-span-6 flex flex-col justify-between h-full">
                            <div>
                                <img src="{{ asset('images/akebono.png') }}" alt="akebono" class="h-5 sm:h-6 w-auto object-contain mb-1">
                                <div class="text-[10px] sm:text-xs font-semibold text-slate-600 leading-tight">Office Relocation</div>
                                <div class="text-lg sm:text-2xl font-black text-[#004b9b] tracking-tight leading-none mt-0.5">SCAN TO START</div>
                                <div class="text-[11px] sm:text-xs text-slate-600">Explore your new workplace</div>
                            </div>

                            <!-- Enlarged QR Box with Centered Akebono 'a' Emblem -->
                            <div class="my-1 flex items-center">
                                <div class="relative w-36 h-36 sm:w-44 sm:h-44 bg-white p-2 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-center">
                                    <div class="w-full h-full flex items-center justify-center [&>svg]:w-full [&>svg]:h-full" x-html="qrSvg"></div>
                                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                        <div class="w-7 h-7 sm:w-8 sm:h-8 bg-white rounded-md shadow-xs border border-slate-200 flex flex-col items-center justify-center leading-none">
                                            <span class="text-[#005bac] font-black text-sm sm:text-base leading-none">a</span>
                                            <span class="w-4 sm:w-5 h-0.5 bg-[#e60012] mt-0.5"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Scan with your phone caption -->
                            <div class="flex items-center gap-2 text-[10px] sm:text-[11px] text-slate-600 leading-tight">
                                <svg class="w-4 h-4 text-[#004b9b] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="7" y="2" width="10" height="20" rx="2" ry="2"></rect>
                                    <line x1="12" y1="18" x2="12.01" y2="18"></line>
                                </svg>
                                <span>Scan with your phone<br>and start your onboarding journey</span>
                            </div>
                        </div>

                        <!-- Right 6 Cols: 6 Onboarding Feature List Box -->
                        <div class="col-span-6 pt-10 sm:pt-12">
                            <div class="bg-slate-100/85 border border-slate-200/80 rounded-2xl p-3 sm:p-4 space-y-1.5 sm:space-y-2 shadow-2xs">
                                <div class="flex items-center gap-2.5 text-xs sm:text-[13px] font-semibold text-slate-800">
                                    <span class="w-5 h-5 rounded-md bg-[#004b9b] text-white flex items-center justify-center text-[11px] shrink-0">🏢</span>
                                    <span>Building Guide</span>
                                </div>
                                <div class="flex items-center gap-2.5 text-xs sm:text-[13px] font-semibold text-slate-800">
                                    <span class="w-5 h-5 rounded-md bg-[#004b9b] text-white flex items-center justify-center text-[11px] shrink-0">⚙️</span>
                                    <span>Facility Information</span>
                                </div>
                                <div class="flex items-center gap-2.5 text-xs sm:text-[13px] font-semibold text-slate-800">
                                    <span class="w-5 h-5 rounded-md bg-[#004b9b] text-white flex items-center justify-center text-[11px] shrink-0">🛡️</span>
                                    <span>Rules & Safety</span>
                                </div>
                                <div class="flex items-center gap-2.5 text-xs sm:text-[13px] font-semibold text-slate-800">
                                    <span class="w-5 h-5 rounded-md bg-[#004b9b] text-white flex items-center justify-center text-[11px] shrink-0">🍴</span>
                                    <span>Canteen & Services</span>
                                </div>
                                <div class="flex items-center gap-2.5 text-xs sm:text-[13px] font-semibold text-slate-800">
                                    <span class="w-5 h-5 rounded-md bg-[#004b9b] text-white flex items-center justify-center text-[11px] shrink-0">👤</span>
                                    <span>Attendance Guide</span>
                                </div>
                                <div class="flex items-center gap-2.5 text-xs sm:text-[13px] font-semibold text-slate-800">
                                    <span class="w-5 h-5 rounded-md bg-[#004b9b] text-white flex items-center justify-center text-[11px] shrink-0">🎧</span>
                                    <span>Support & Contact</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Saved Database Table of Employee Desks -->
            <div class="bg-white rounded-3xl border border-slate-200/90 p-5 sm:p-6 shadow-xs space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="text-sm sm:text-base font-extrabold text-[#0f2e54]">Daftar Desk Karyawan di Database ({{ $desks->count() }})</h3>
                        <p class="text-xs text-slate-500">Klik <strong>Edit / Preview</strong> untuk memuat ke kartu di atas atau klik <strong>Print</strong> untuk mencetak</p>
                    </div>
                    <div class="relative w-full sm:w-64">
                        <input type="text" x-model="searchQuery" placeholder="Cari nama, desk, departemen..."
                               class="w-full pl-8 pr-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 focus:outline-none focus:border-[#0084f8]">
                        <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs">🔍</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">
                                <th class="py-3 px-3">Desk</th>
                                <th class="py-3 px-3">Nama Karyawan</th>
                                <th class="py-3 px-3">Departemen & Seksi</th>
                                <th class="py-3 px-3">Lokasi</th>
                                <th class="py-3 px-3 text-right">Aksi & Cetak</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            @forelse($desks as $desk)
                                <tr class="hover:bg-slate-50/80 transition"
                                    x-show="!searchQuery || {{ Js::from(strtolower($desk->desk_number . ' ' . $desk->name . ' ' . $desk->department . ' ' . $desk->sub_team . ' ' . $desk->area)) }}.includes(searchQuery.toLowerCase())">
                                    <td class="py-3 px-3 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-[#0f2e54] text-white font-extrabold text-xs">
                                            {{ $desk->desk_number }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-3 font-extrabold text-slate-800">
                                        {{ $desk->name }}
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="font-bold text-slate-700">{{ $desk->department }}</div>
                                        @if($desk->sub_team)
                                            <div class="text-[11px] text-slate-400">{{ $desk->sub_team }}</div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3 text-slate-600 font-semibold whitespace-nowrap">
                                        Floor {{ $desk->floor }} • {{ $desk->area }}
                                    </td>
                                    <td class="py-3 px-3 text-right whitespace-nowrap">
                                        <div class="inline-flex items-center gap-1.5">
                                            <button type="button"
                                                    @click="selectDesk({{ Js::from($desk) }})"
                                                    class="px-2.5 py-1.5 rounded-lg bg-sky-50 hover:bg-sky-100 text-[#0084f8] border border-sky-200 font-bold text-[11px] transition cursor-pointer">
                                                ✏️ Edit / Preview
                                            </button>

                                            <a href="{{ route('admin.desks.print', $desk->id) }}" target="_blank"
                                               class="px-2.5 py-1.5 rounded-lg bg-[#0f2e54] hover:bg-[#163d6e] text-white font-bold text-[11px] transition">
                                                🖨️ Print
                                            </a>

                                            <form action="{{ route('admin.desks.delete', $desk->id) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Hapus data desk {{ $desk->desk_number }} ({{ $desk->name }})?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="px-2.5 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 font-bold text-[11px] transition cursor-pointer">
                                                    🗑️
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-400 font-semibold">
                                        Belum ada data meja kerja. Silakan isi form di samping untuk menyimpan ke database.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
