<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin Panel' }} - Akebono Karawang Guide</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full text-slate-800 antialiased flex flex-col md:flex-row bg-slate-100" x-data="{ sidebarOpen: false }">

    <!-- Mobile Header -->
    <div class="md:hidden bg-white border-b border-slate-200 px-4 py-3 flex items-center justify-between sticky top-0 z-40">
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/akebono.png') }}" alt="Akebono" class="h-6 w-auto">
            <span class="text-xs font-bold text-[#0f2e54] uppercase tracking-wider">Admin Panel</span>
        </div>
        <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-slate-600 hover:bg-slate-100 rounded-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <!-- Sidebar Navigation -->
    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 flex flex-col justify-between transition-transform duration-300 md:static md:translate-x-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
        
        <div>
            <!-- Sidebar Header -->
            <div class="p-5 border-b border-slate-800 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-white p-1.5 rounded-lg">
                        <img src="{{ asset('images/akebono.png') }}" alt="Akebono" class="h-5 w-auto">
                    </div>
                    <div>
                        <div class="text-xs font-extrabold text-white uppercase tracking-wider">ADMIN CMS</div>
                        <div class="text-[10px] text-slate-400">Office Guide 2026</div>
                    </div>
                </div>
                <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-white">✕</button>
            </div>

            <!-- Current User Badge -->
            <div class="px-5 py-3 bg-slate-800/60 border-b border-slate-800 flex items-center gap-2.5 text-xs">
                <div class="w-7 h-7 rounded-full bg-[#0084f8] text-white flex items-center justify-center font-bold text-xs">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="truncate">
                    <div class="font-bold text-white truncate">{{ Auth::user()->name ?? 'Admin' }}</div>
                    <div class="text-[10px] text-slate-400 truncate">{{ Auth::user()->email ?? '' }}</div>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="p-3 space-y-1 text-xs font-semibold">
                
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition {{ Route::is('admin.dashboard*') ? 'bg-[#0084f8] text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                    <span class="text-base">📊</span>
                    <span>Dashboard Utama</span>
                </a>

                <div class="pt-3 pb-1 px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">
                    Pengaturan Tampilan
                </div>

                <a href="{{ route('admin.home.edit') }}" 
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition {{ Route::is('admin.home.edit') ? 'bg-[#0084f8] text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                    <span class="text-base">🪄</span>
                    <span>Edit Konten Beranda</span>
                </a>

                <a href="{{ route('admin.message.edit') }}" 
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition {{ Route::is('admin.message.edit') ? 'bg-[#0084f8] text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                    <span class="text-base">📝</span>
                    <span>Pesan Manajemen</span>
                </a>

                <div class="pt-3 pb-1 px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">
                    Kelola Database
                </div>

                <a href="{{ route('admin.facilities.index') }}" 
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition {{ Route::is('admin.facilities*') ? 'bg-[#0084f8] text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                    <span class="text-base">🏢</span>
                    <span>Kelola Fasilitas</span>
                </a>

                <a href="{{ route('admin.rules.index') }}" 
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition {{ Route::is('admin.rules*') ? 'bg-[#0084f8] text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                    <span class="text-base">📋</span>
                    <span>Kelola Dos & Don'ts</span>
                </a>

                <a href="{{ route('admin.emergency.index') }}" 
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition {{ Route::is('admin.emergency*') ? 'bg-[#0084f8] text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                    <span class="text-base">🚨</span>
                    <span>Kontak Darurat</span>
                </a>

                <div class="pt-3 pb-1 px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">
                    Akun & Akses
                </div>

                <a href="{{ route('admin.password.edit') }}" 
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition {{ Route::is('admin.password*') ? 'bg-[#0084f8] text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                    <span class="text-base">🔐</span>
                    <span>Ganti Password</span>
                </a>

            </nav>
        </div>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-slate-800 space-y-2">
            <a href="{{ route('guide.index') }}" target="_blank" 
               class="w-full flex items-center justify-center gap-2 py-2 px-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold transition">
                <span>👁️</span>
                <span>Lihat Situs Web ↗</span>
            </a>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" 
                        class="w-full flex items-center justify-center gap-2 py-2 px-3 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 text-xs font-bold transition">
                    <span>🚪</span>
                    <span>Logout Keluar</span>
                </button>
            </form>
        </div>

    </aside>

    <!-- Main Content Panel -->
    <main class="flex-1 overflow-y-auto min-h-screen p-4 sm:p-6 md:p-8">
        
        <!-- Flash Alert Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <span class="text-base">✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm font-semibold flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <span class="text-base">✕</span>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm font-semibold shadow-xs">
                <div class="font-bold mb-1">Terdapat kesalahan pada isian formulir:</div>
                <ul class="list-disc list-inside space-y-0.5 text-xs font-normal">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>

