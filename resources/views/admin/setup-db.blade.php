<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} - Setup Database Akebono Guide</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        code, pre { font-family: 'JetBrains Mono', monospace; }
    </style>
</head>
<body class="min-h-full flex items-center justify-center p-4 sm:p-6 bg-gradient-to-br from-slate-100 via-sky-50 to-slate-200">

    <div class="max-w-2xl w-full bg-white rounded-3xl shadow-xl border border-slate-200/80 p-6 sm:p-8 space-y-6">
        
        <!-- Header -->
        <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
            <img src="{{ asset('images/akebono.png') }}" alt="Akebono" class="h-8 object-contain">
            <div class="h-6 w-px bg-slate-300"></div>
            <div>
                <h1 class="text-base font-extrabold text-[#0f2e54]">Status Database Neon Postgres</h1>
                <p class="text-xs text-slate-500">Akebono Karawang Digital Office Guide</p>
            </div>
        </div>

        @if($status === 'success')
            <!-- Success Banner -->
            <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-start gap-3">
                <span class="text-2xl leading-none">✅</span>
                <div class="space-y-1">
                    <h2 class="text-sm font-bold text-emerald-900">{{ $title }}</h2>
                    <p class="text-xs text-emerald-700 leading-relaxed">{{ $message }}</p>
                </div>
            </div>

            <!-- Credentials Reminder -->
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 text-xs space-y-2">
                <div class="font-bold text-slate-800">Akun Login Administrator Tersedia:</div>
                <div class="font-mono text-slate-700 bg-white p-3 rounded-xl border border-slate-200">
                    <div>Email: <strong class="text-blue-600">admin@akebono.co.id</strong></div>
                    <div>Password: <strong class="text-blue-600">password123</strong></div>
                </div>
            </div>

            <!-- Action -->
            <div class="pt-2">
                <a href="{{ route('login') }}" class="block text-center w-full py-3 bg-[#0084f8] hover:bg-[#0070d6] text-white text-sm font-bold rounded-xl shadow-md transition">
                    Buka Halaman Login Admin →
                </a>
            </div>
        @else
            <!-- Error Banner -->
            <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl flex items-start gap-3">
                <span class="text-2xl leading-none">⚠️</span>
                <div class="space-y-1 flex-1">
                    <h2 class="text-sm font-bold text-rose-900">{{ $title }}</h2>
                    <p class="text-xs text-rose-700 leading-relaxed">{{ $message }}</p>
                </div>
            </div>

            <!-- Step-by-Step Instructions -->
            <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200 text-xs text-amber-900 space-y-2">
                <div class="font-bold text-amber-800 flex items-center gap-1.5">
                    <span>📌</span> Cara Menyambungkan Database di Vercel:
                </div>
                <div class="whitespace-pre-line text-[12px] leading-relaxed pl-2 text-slate-700 font-medium">
{{ $details }}
                </div>
            </div>

            <!-- Retry button -->
            <div class="flex items-center gap-3 pt-2">
                <a href="{{ route('admin.setup-db') }}" class="flex-1 text-center py-2.5 bg-[#0084f8] hover:bg-[#0070d6] text-white text-xs font-bold rounded-xl shadow-sm transition">
                    🔄 Coba Cek Lagi (Refresh)
                </a>
                <a href="{{ route('guide.index') }}" class="py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                    Ke Beranda
                </a>
            </div>
        @endif

        <!-- Diagnostic Info Accordion -->
        <div class="pt-3 border-t border-slate-100">
            <details class="text-[11px] text-slate-500">
                <summary class="cursor-pointer font-bold hover:text-slate-700">Informasi Teknis Driver & Koneksi (Klik untuk melihat)</summary>
                <div class="mt-2 p-3 bg-slate-900 text-slate-200 rounded-xl font-mono text-[11px] space-y-1 overflow-x-auto">
                    @foreach($envInfo as $k => $v)
                        <div><span class="text-sky-400">{{ $k }}</span>: {{ $v }}</div>
                    @endforeach
                </div>
            </details>
        </div>

    </div>

</body>
</html>

