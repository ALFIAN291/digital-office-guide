<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Administrator - Akebono Karawang Guide</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="h-full flex items-center justify-center p-4 bg-gradient-to-br from-slate-100 via-sky-50/50 to-slate-200">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border border-slate-200/80 p-6 sm:p-8 space-y-6">
        
        <!-- Header & Logo -->
        <div class="text-center space-y-2">
            <a href="{{ route('guide.index') }}" class="inline-block group">
                <img src="{{ asset('images/akebono.png') }}" alt="Akebono Brake" class="h-9 mx-auto object-contain transition-transform group-hover:scale-105">
            </a>
            
            <div class="pt-2">
                <h1 class="text-xl sm:text-2xl font-extrabold text-[#0f2e54] tracking-tight">Login Administrator</h1>
                <p class="text-xs text-slate-500 mt-1">Masuk untuk mengedit konten, foto fasilitas, dan panduan kantor</p>
            </div>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
            <div class="p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold">
                {{ $errors->first() }}
            </div>
        @endif

        @if(session('success'))
            <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">
                    Alamat Email
                </label>
                <div class="relative">
                    <input type="email" id="email" name="email" value="{{ old('email', 'admin@akebono.co.id') }}" required autofocus
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-[#0084f8] focus:ring-2 focus:ring-sky-100 focus:outline-hidden transition text-slate-800 font-medium">
                </div>
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Kata Sandi (Password)
                    </label>
                </div>
                <div class="relative">
                    <input type="password" id="password" name="password" value="password123" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-[#0084f8] focus:ring-2 focus:ring-sky-100 focus:outline-hidden transition text-slate-800 font-medium">
                </div>
            </div>

            <!-- Remember me -->
            <div class="flex items-center justify-between pt-1">
                <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-600">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded text-[#0084f8] focus:ring-[#0084f8] border-slate-300" checked>
                    <span>Ingat Saya di Perangkat Ini</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full py-3 bg-[#0084f8] hover:bg-[#0070d6] text-white text-sm font-bold rounded-xl shadow-md hover:shadow-lg transition transform active:scale-98">
                Masuk ke Dashboard Admin →
            </button>

        </form>

        <!-- Demo Credentials Helper Box -->
        <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200/80 text-xs text-slate-600 space-y-1">
            <div class="font-bold text-slate-700 flex items-center gap-1.5">
                <span>🔑</span>
                <span>Akun Default Administrator:</span>
            </div>
            <div class="text-[11px] font-mono text-slate-500">
                Email: <span class="font-bold text-slate-800">admin@akebono.co.id</span><br>
                Password: <span class="font-bold text-slate-800">password123</span>
            </div>
        </div>

        <!-- Back to Website Link -->
        <div class="text-center pt-2">
            <a href="{{ route('guide.index') }}" class="text-xs font-semibold text-slate-500 hover:text-[#0084f8] transition">
                ← Kembali ke Situs Karawang Office Guide
            </a>
        </div>

    </div>

</body>
</html>

