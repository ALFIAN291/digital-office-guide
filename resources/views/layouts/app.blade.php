<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>{{ $title ?? 'Akebono - ' . ($settings->office_title ?? 'Karawang') . ' Office Guide 2026' }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            -webkit-tap-highlight-color: transparent;
        }
        [x-cloak] { display: none !important; }
        
        .soft-shadow {
            box-shadow: 0 10px 30px -10px rgba(11, 60, 109, 0.10), 0 4px 6px -4px rgba(11, 60, 109, 0.04);
        }
        .card-hover {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 36px -8px rgba(11, 60, 109, 0.16);
        }

        @media print {
            header, nav {
                position: static !important;
            }
        }
    </style>
</head>
<body class="min-h-screen text-slate-800 antialiased flex flex-col bg-[#eaf3fa]" x-data="{ mobileMenuOpen: false, sosModalOpen: false, activeTab: '{{ Route::currentRouteName() }}' }">

    <!-- Admin Notification Toast if session has success -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
             class="fixed top-20 right-4 z-50 bg-emerald-600 text-white text-xs sm:text-sm font-semibold px-4 py-3 rounded-2xl shadow-xl flex items-center gap-3">
            <span>✓ {{ session('success') }}</span>
            <button @click="show = false" class="text-white/80 hover:text-white">✕</button>
        </div>
    @endif

    <!-- Top Navigation Bar (Header - Matching Mockup) -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-xs transition-all">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 h-16 md:h-18 flex items-center justify-between">
            <!-- Brand Logo & Office Label -->
            <a href="{{ route('guide.index') }}" class="flex items-center gap-3.5 group">
                <img src="{{ asset('images/akebono.png') }}" alt="Akebono Brake" style="max-height: 36px; width: auto;" class="h-8 sm:h-9 w-auto object-contain transition-transform group-hover:scale-105">
                
                <div class="h-7 w-px bg-slate-300"></div>
                
                <div class="flex flex-col text-left">
                    <span class="text-[11px] font-semibold tracking-wider text-slate-500 uppercase leading-none">{{ $settings->office_title ?? 'KARAWANG' }}</span>
                    <span class="text-xs sm:text-[13px] font-bold tracking-tight text-[#0f2e54] uppercase leading-tight mt-0.5">{{ $settings->office_subtitle ?? 'OFFICE GUIDE 2026' }}</span>
                </div>
            </a>

            <!-- Right Controls (Only Hamburger & Admin Mode if logged in) -->
            <div class="flex items-center gap-2 sm:gap-3">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-800 border border-amber-300 rounded-full text-xs font-bold hover:bg-amber-100 transition">
                        <span>⚙️ Admin</span>
                    </a>
                @endauth

                <!-- Hamburger Menu Button (Matching Mockup) -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Menu" class="p-2 text-slate-700 hover:text-[#0084f8] hover:bg-slate-100 rounded-lg transition-colors focus:outline-hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Side Drawer Navigation -->
    <div x-show="mobileMenuOpen" x-cloak class="fixed inset-0 z-50 overflow-hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
        <div x-show="mobileMenuOpen" 
             x-transition:enter="ease-in-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in-out duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileMenuOpen = false" 
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transform transition ease-in-out duration-300"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-300"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 class="w-screen max-w-xs sm:max-w-sm bg-white shadow-2xl flex flex-col justify-between">
                
                <!-- Drawer Header -->
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
                    <div class="flex items-center gap-2.5">
                        <img src="{{ asset('images/akebono.png') }}" alt="Akebono" style="max-height: 24px; width: auto;" class="h-6 w-auto">
                        <span class="text-xs font-bold text-[#0f2e54] uppercase tracking-wider">Office Guide</span>
                    </div>
                    <button @click="mobileMenuOpen = false" class="p-1.5 text-slate-400 hover:text-slate-600 rounded-full hover:bg-slate-200/60 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Navigation Links -->
                <div class="flex-1 overflow-y-auto py-4 px-4 space-y-1.5">
                    
                    @auth
                        <!-- Admin Quick Box -->
                        <div class="p-3 bg-amber-50/80 rounded-2xl border border-amber-200 mb-3">
                            <div class="text-[11px] font-bold text-amber-900 uppercase">Login Sebagai:</div>
                            <div class="text-xs font-extrabold text-amber-800">{{ Auth::user()->name }}</div>
                            <div class="mt-2 flex gap-2">
                                <a href="{{ route('admin.dashboard') }}" class="px-2.5 py-1 bg-amber-600 text-white text-[11px] font-bold rounded-lg hover:bg-amber-700">Dashboard</a>
                                <a href="{{ route('admin.home.edit') }}" class="px-2.5 py-1 bg-white text-amber-900 border border-amber-300 text-[11px] font-bold rounded-lg hover:bg-amber-100">Edit Beranda</a>
                            </div>
                        </div>
                    @endauth

                    <a href="{{ route('guide.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ Route::is('guide.index') ? 'bg-sky-50 text-[#0084f8]' : 'text-slate-700 hover:bg-slate-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>Beranda (Home)</span>
                    </a>

                    <a href="{{ route('guide.message') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ Route::is('guide.message') ? 'bg-sky-50 text-[#0084f8]' : 'text-slate-700 hover:bg-slate-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                        <span>Pesan Manajemen</span>
                    </a>

                    <a href="{{ route('guide.office-and-plant') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ Route::is('guide.office-and-plant') ? 'bg-sky-50 text-[#0084f8]' : 'text-slate-700 hover:bg-slate-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <span>Office & Plant</span>
                    </a>

                    <a href="{{ route('guide.facilities') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ Route::is('guide.facilities*') ? 'bg-sky-50 text-[#0084f8]' : 'text-slate-700 hover:bg-slate-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        <span>Fasilitas (Facilities)</span>
                    </a>

                    <a href="{{ route('guide.map') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ Route::is('guide.map') ? 'bg-sky-50 text-[#0084f8]' : 'text-slate-700 hover:bg-slate-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                        <span>Denah Kantor (Office Map)</span>
                    </a>

                    <a href="{{ route('guide.dos-and-donts') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ Route::is('guide.dos-and-donts') ? 'bg-sky-50 text-[#0084f8]' : 'text-slate-700 hover:bg-slate-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        <span>Dos & Don'ts (Etiket & K3)</span>
                    </a>

                    <a href="{{ route('guide.emergency') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold {{ Route::is('guide.emergency') ? 'bg-rose-50 text-rose-600' : 'text-rose-700 hover:bg-rose-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <span>Kontak Darurat (SOS)</span>
                    </a>
                </div>

                <!-- Drawer Footer (Login / Logout) -->
                <div class="p-4 bg-slate-50 border-t border-slate-100">
                    @auth
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs rounded-xl transition flex items-center justify-center gap-1.5">
                                <span>Logout Admin</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="w-full py-2 bg-slate-200/70 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition flex items-center justify-center gap-1.5">
                            <span>🔒 Login Admin CMS</span>
                        </a>
                    @endauth
                    <p class="text-[11px] text-slate-400 text-center mt-2">&copy; 2026 PT Akebono Brake Astra Indonesia</p>
                </div>
            </div>
        </div>
    </div>

    <!-- SOS Hotline Modal -->
    <div x-show="sosModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto p-4 sm:p-6 flex items-center justify-center" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="sosModalOpen = false"></div>
        <div class="relative bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-rose-100 text-center">
            <div class="w-14 h-14 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900">Kontak Darurat (SOS) Karawang</h3>
            <p class="text-xs text-slate-500 mt-1 mb-5">Hubungi nomor darurat di bawah untuk bantuan segera</p>

            <div class="space-y-2.5 text-left mb-6">
                <a href="tel:02678459001" class="flex items-center justify-between p-3.5 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-2xl transition">
                    <div>
                        <div class="text-xs font-semibold text-rose-800">Security Pos Utama (24 Jam)</div>
                        <div class="text-base font-extrabold text-rose-700">(0267) 845-9001 <span class="text-xs font-normal">/ Ext. 100</span></div>
                    </div>
                    <span class="p-2 bg-rose-600 text-white rounded-xl">📞 Panggil</span>
                </a>

                <a href="tel:02678459002" class="flex items-center justify-between p-3.5 bg-sky-50 hover:bg-sky-100 border border-sky-200 rounded-2xl transition">
                    <div>
                        <div class="text-xs font-semibold text-sky-800">Klinik & First Aid Paramedis</div>
                        <div class="text-base font-extrabold text-sky-700">(0267) 845-9002 <span class="text-xs font-normal">/ Ext. 119</span></div>
                    </div>
                    <span class="p-2 bg-[#0084f8] text-white rounded-xl">📞 Panggil</span>
                </a>

                <a href="tel:02678459003" class="flex items-center justify-between p-3.5 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-2xl transition">
                    <div>
                        <div class="text-xs font-semibold text-amber-800">HSE Safety Officer On Duty</div>
                        <div class="text-base font-extrabold text-amber-700">(0267) 845-9003 <span class="text-xs font-normal">/ Ext. 112</span></div>
                    </div>
                    <span class="p-2 bg-amber-600 text-white rounded-xl">📞 Panggil</span>
                </a>
            </div>

            <button @click="sosModalOpen = false" class="w-full py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                Tutup
            </button>
        </div>
    </div>

    <!-- Main Content Area -->
    <main class="flex-1 pb-8 w-full">
        @yield('content')
    </main>

    <!-- Bottom Navigation Bar (Docked at Bottom, Never Covers Mid-Page Content in Screenshots) -->
    <nav class="sticky bottom-0 z-40 bg-white/95 backdrop-blur-md border-t border-slate-200/90 shadow-md mt-auto w-full">
        <div class="max-w-3xl mx-auto px-4 h-16 sm:h-18 flex items-center justify-around">
            
            <a href="{{ route('guide.index') }}" 
               class="flex flex-col items-center justify-center flex-1 h-full relative transition-colors {{ Route::is('guide.index') ? 'text-[#0084f8] font-bold' : 'text-slate-400 hover:text-slate-700 font-medium' }}">
                @if(Route::is('guide.index'))
                    <span class="absolute top-0 inset-x-4 sm:inset-x-8 h-0.75 bg-[#0084f8] rounded-full"></span>
                @endif
                <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="text-[11px] sm:text-xs tracking-tight">Home</span>
            </a>

            <a href="{{ route('guide.facilities') }}" 
               class="flex flex-col items-center justify-center flex-1 h-full relative transition-colors {{ Route::is('guide.facilities*') ? 'text-[#0084f8] font-bold' : 'text-slate-400 hover:text-slate-700 font-medium' }}">
                @if(Route::is('guide.facilities*'))
                    <span class="absolute top-0 inset-x-4 sm:inset-x-8 h-0.75 bg-[#0084f8] rounded-full"></span>
                @endif
                <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                <span class="text-[11px] sm:text-xs tracking-tight">Facilities</span>
            </a>

            <a href="{{ route('guide.map') }}" 
               class="flex flex-col items-center justify-center flex-1 h-full relative transition-colors {{ Route::is('guide.map') ? 'text-[#0084f8] font-bold' : 'text-slate-400 hover:text-slate-700 font-medium' }}">
                @if(Route::is('guide.map'))
                    <span class="absolute top-0 inset-x-4 sm:inset-x-8 h-0.75 bg-[#0084f8] rounded-full"></span>
                @endif
                <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="1.5"></circle>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l2.5 7.5L22 12l-7.5 2.5L12 22l-2.5-7.5L2 12l7.5-2.5L12 2z"></path>
                </svg>
                <span class="text-[11px] sm:text-xs tracking-tight">Map</span>
            </a>

            <a href="{{ route('guide.dos-and-donts') }}" 
               class="flex flex-col items-center justify-center flex-1 h-full relative transition-colors {{ Route::is('guide.dos-and-donts') ? 'text-[#0084f8] font-bold' : 'text-slate-400 hover:text-slate-700 font-medium' }}">
                @if(Route::is('guide.dos-and-donts'))
                    <span class="absolute top-0 inset-x-4 sm:inset-x-8 h-0.75 bg-[#0084f8] rounded-full"></span>
                @endif
                <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
                <span class="text-[11px] sm:text-xs tracking-tight">Dos & Don'ts</span>
            </a>

        </div>
    </nav>

    <!-- Instant Page Transition Prefetcher (Zero Delay across menus) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const prefetched = new Set();
            const prefetch = (url) => {
                if (!url || prefetched.has(url) || url.startsWith('#') || url.includes('logout') || url.includes('login')) return;
                prefetched.add(url);
                const link = document.createElement('link');
                link.rel = 'prefetch';
                link.href = url;
                document.head.appendChild(link);
            };

            const attachListeners = () => {
                document.querySelectorAll('a[href^="/"], a[href^="' + window.location.origin + '"]').forEach(a => {
                    a.addEventListener('mouseenter', () => prefetch(a.href), { passive: true });
                    a.addEventListener('touchstart', () => prefetch(a.href), { passive: true });
                });
            };

            attachListeners();
        });
    </script>

</body>
</html>
