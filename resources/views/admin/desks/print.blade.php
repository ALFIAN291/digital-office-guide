<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Desk Tent Card ({{ $isBatch ? 'Semua Desk' : ($desks->first()?->desk_number ?? 'Desk') }}) — Akebono Karawang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #e2e8f0;
            color: #0f172a;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .tent-card-face {
            width: 150mm;
            height: 70mm;
            margin-left: auto;
            margin-right: auto;
        }
        .tent-sheet {
            page-break-inside: avoid;
            break-inside: avoid;
        }
        @media (max-width: 640px) {
            .tent-card-face {
                width: 100%;
                height: auto;
                aspect-ratio: 150 / 70;
            }
        }
        @media print {
            @page {
                size: A4 portrait;
                margin: 10mm;
            }
            body {
                background: #ffffff !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .tent-sheet {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                margin-bottom: 6mm !important;
                page-break-after: always;
            }
            .tent-sheet:last-child {
                page-break-after: auto;
            }
        }
    </style>
</head>
<body class="min-h-screen py-6 px-4 sm:px-8">

    <!-- Top Action Toolbar (Hidden when printing) -->
    <div class="no-print max-w-5xl mx-auto mb-6 bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.desks.index') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                <span>←</span>
                <span>Kembali ke Admin Desk</span>
            </a>
            <div>
                <h1 class="text-sm sm:text-base font-extrabold text-[#0f2e54]">
                    Print Desk Tent Card (150 mm × 70 mm — Front & Back Side)
                </h1>
                <p class="text-xs text-slate-500">
                    Menampilkan {{ $desks->count() }} set kartu meja siap cetak • Pastikan opsi <strong>"Background graphics"</strong> dicentang pada dialog Print
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2.5">
            <button type="button" onclick="window.print()"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#0084f8] hover:bg-[#006fd6] text-white text-xs font-extrabold shadow-sm transition cursor-pointer">
                <span>🖨️</span>
                <span>Cetak Sekarang (Print / Save PDF)</span>
            </button>
        </div>
    </div>

    <!-- Printable Desk Tent Cards Container -->
    <div class="max-w-5xl mx-auto space-y-8">
        @foreach($desks as $desk)
            @php
                $nameLen = mb_strlen(trim((string) $desk->name));
                if ($nameLen > 28) {
                    $printNameClass = 'text-base leading-snug';
                } elseif ($nameLen > 18) {
                    $printNameClass = 'text-lg leading-tight';
                } else {
                    $printNameClass = 'text-2xl leading-tight';
                }
            @endphp
            <div class="tent-sheet bg-white rounded-3xl border border-slate-300 p-6 shadow-sm space-y-3">

                <div class="no-print flex items-center justify-between text-xs font-bold text-slate-500 pb-2 border-b border-slate-100">
                    <span>🪪 TENT CARD MEJA KARYAWAN — DESK {{ $desk->desk_number }} ({{ $desk->name }})</span>
                    <span>Ukuran Cetak Aktual: 150 mm (W) × 70 mm (H) per sisi • Art Paper / Ivory 300 gsm</span>
                </div>

                <!-- 1. FRONT SIDE (Employee Information) - 150mm x 70mm -->
                <div class="space-y-1">
                    <div class="no-print flex items-center justify-between max-w-[150mm] mx-auto text-[11px] font-bold text-slate-500">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-[#1e4b7a] text-white text-[10px] font-extrabold">
                            Front Side (Employee Information)
                        </span>
                        <span>✂️ Garis Potong Luar</span>
                    </div>

                    <div class="tent-card-face relative bg-gradient-to-br from-white via-[#f8fbff] to-[#eef5fc] border border-dashed border-slate-400 overflow-hidden select-none">

                        <!-- Right-side Angled Geometric Stripes & Building Photo (47% width) -->
                        <div class="absolute inset-y-0 right-0 w-[47%] pointer-events-none overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-b from-[#69a9e8]/45 to-[#0051a8]/20"
                                 style="clip-path: polygon(24% 0, 100% 0, 100% 100%, 0% 100%);"></div>

                            <div class="absolute inset-0 bg-white/90"
                                 style="clip-path: polygon(29% 0, 33% 0, 9% 100%, 5% 100%);"></div>

                            <div class="absolute inset-0 overflow-hidden"
                                 style="clip-path: polygon(34% 0, 100% 0, 100% 82%, 12% 82%);">
                                <img src="{{ $desk->card_image_url }}" alt="Akebono Office"
                                     class="w-full h-full object-cover object-center">
                                <div class="absolute inset-0 bg-gradient-to-r from-white/35 via-transparent to-transparent"></div>
                            </div>

                            <div class="absolute inset-0 bg-gradient-to-r from-[#004b9b] to-[#003775]"
                                 style="clip-path: polygon(14% 74%, 100% 79%, 100% 100%, 24% 100%);"></div>
                        </div>

                        <!-- Left & Bottom Foreground Content (Bounded to 55% width so long names wrap cleanly) -->
                        <div class="relative z-10 h-full flex flex-col justify-between p-5 w-[55%] pr-3">
                            <div>
                                <img src="{{ asset('images/akebono.png') }}" alt="akebono" class="h-5 w-auto object-contain mb-1.5">
                                <div class="text-[11px] font-semibold text-slate-600 tracking-tight">Office Relocation</div>
                                <div class="text-xl font-black text-[#004b9b] uppercase leading-[1.06] tracking-tight mt-0.5">
                                    WELCOME TO<br>YOUR NEW DESK
                                </div>
                            </div>

                            <div class="my-0.5 max-w-full overflow-hidden">
                                <div class="font-black text-slate-900 tracking-tight break-words line-clamp-2 {{ $printNameClass }}">{{ $desk->name }}</div>
                                <div class="text-xs font-semibold text-slate-800 leading-snug mt-0.5 truncate">{{ $desk->department }}</div>
                                <div class="text-[11px] text-slate-600 leading-snug truncate">{{ $desk->sub_team ?: 'Akebono Brake Astra Indonesia' }}</div>
                            </div>

                            <div class="flex items-center gap-4 pt-1">
                                <!-- Desk -->
                                <div class="flex items-center gap-1.5 shrink-0">
                                    <svg class="w-4 h-4 text-[#004b9b] shrink-0" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 10h16M4 14h16M6 10V6a1 1 0 011-1h10a1 1 0 011 1v4M5 10v9m14-9v9"/>
                                    </svg>
                                    <div class="leading-tight">
                                        <div class="text-[9px] font-medium text-slate-500">Desk</div>
                                        <div class="text-xs font-black text-slate-900">{{ $desk->desk_number }}</div>
                                    </div>
                                </div>

                                <!-- Floor -->
                                <div class="flex items-center gap-1.5 shrink-0">
                                    <svg class="w-4 h-4 text-[#004b9b] shrink-0" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1"/>
                                    </svg>
                                    <div class="leading-tight">
                                        <div class="text-[9px] font-medium text-slate-500">Floor</div>
                                        <div class="text-xs font-black text-slate-900">{{ $desk->floor }}</div>
                                    </div>
                                </div>

                                <!-- Area -->
                                <div class="flex items-center gap-1.5 min-w-0">
                                    <svg class="w-4 h-4 text-[#004b9b] shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                                    </svg>
                                    <div class="leading-tight min-w-0">
                                        <div class="text-[9px] font-medium text-slate-500">Area</div>
                                        <div class="text-xs font-black text-slate-900 truncate">{{ $desk->area }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Center Fold Line Indicator -->
                <div class="max-w-[150mm] mx-auto flex items-center gap-2 text-[10px] font-bold text-slate-400 py-0.5">
                    <div class="flex-1 border-t border-dashed border-slate-300"></div>
                    <span>GARIS LIPAT TENGAH (FOLD LINE — 150 mm)</span>
                    <div class="flex-1 border-t border-dashed border-slate-300"></div>
                </div>

                <!-- 2. BACK SIDE (QR Code & Onboarding) - 150mm x 70mm -->
                <div class="space-y-1">
                    <div class="no-print flex items-center justify-between max-w-[150mm] mx-auto text-[11px] font-bold text-slate-500">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-[#1e4b7a] text-white text-[10px] font-extrabold">
                            Back Side (QR Code & Onboarding)
                        </span>
                        <span>✂️ Garis Potong Luar</span>
                    </div>

                    <div class="tent-card-face relative bg-gradient-to-br from-white via-[#f8fbff] to-[#eef5fc] border border-dashed border-slate-400 overflow-hidden select-none">

                        <!-- Top-Right Angled Corporate Blue Ribbon ("A New Workplace / A New Experience") -->
                        <div class="absolute top-0 right-0 w-[44%] h-[26%] bg-gradient-to-r from-[#0051a8] to-[#003b80] flex items-center justify-end pr-6 pointer-events-none"
                             style="clip-path: polygon(18% 0, 100% 0, 100% 100%, 0% 100%);">
                            <div class="text-right text-white italic font-serif text-xs leading-snug tracking-wide">
                                <div>A New Workplace</div>
                                <div>A New Experience</div>
                            </div>
                        </div>

                        <!-- Main Back Side Grid -->
                        <div class="relative z-10 h-full grid grid-cols-12 gap-3 px-5 py-3.5 items-center">

                            <!-- Left 6 Cols: Logo + SCAN TO START + Enlarged QR with centered 'a' logo + Phone Caption -->
                            <div class="col-span-6 flex flex-col justify-between h-full">
                                <div>
                                    <img src="{{ asset('images/akebono.png') }}" alt="akebono" class="h-4.5 w-auto object-contain mb-0.5">
                                    <div class="text-[9.5px] font-semibold text-slate-600 leading-tight">Office Relocation</div>
                                    <div class="text-lg font-black text-[#004b9b] tracking-tight leading-none mt-0.5">SCAN TO START</div>
                                    <div class="text-[9.5px] text-slate-600">Explore your new workplace</div>
                                </div>

                                <!-- Enlarged QR Box (36mm x 36mm) with Centered Akebono 'a' Emblem -->
                                <div class="my-0.5 flex items-center">
                                    <div class="relative w-34 h-34 bg-white p-1.5 rounded-xl border border-slate-200 flex items-center justify-center">
                                        <div class="w-full h-full flex items-center justify-center [&>svg]:w-full [&>svg]:h-full"
                                             data-qr-url="{{ $desk->qr_url }}"></div>
                                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                            <div class="w-6 h-6 bg-white rounded-md border border-slate-200 flex flex-col items-center justify-center leading-none">
                                                <span class="text-[#005bac] font-black text-xs leading-none">a</span>
                                                <span class="w-3.5 h-0.5 bg-[#e60012] mt-0.5"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-1.5 text-[9px] text-slate-600 leading-tight">
                                    <svg class="w-3.5 h-3.5 text-[#004b9b] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <rect x="7" y="2" width="10" height="20" rx="2" ry="2"></rect>
                                        <line x1="12" y1="18" x2="12.01" y2="18"></line>
                                    </svg>
                                    <span>Scan with your phone<br>and start your onboarding journey</span>
                                </div>
                            </div>

                            <!-- Right 6 Cols: 6 Onboarding Feature List Box -->
                            <div class="col-span-6 pt-10">
                                <div class="bg-slate-100/90 border border-slate-200/90 rounded-xl p-3 space-y-1.5">
                                    <div class="flex items-center gap-2 text-[11px] font-semibold text-slate-800">
                                        <span class="w-4 h-4 rounded bg-[#004b9b] text-white flex items-center justify-center text-[9px] shrink-0">🏢</span>
                                        <span>Building Guide</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-[11px] font-semibold text-slate-800">
                                        <span class="w-4 h-4 rounded bg-[#004b9b] text-white flex items-center justify-center text-[9px] shrink-0">⚙️</span>
                                        <span>Facility Information</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-[11px] font-semibold text-slate-800">
                                        <span class="w-4 h-4 rounded bg-[#004b9b] text-white flex items-center justify-center text-[9px] shrink-0">🛡️</span>
                                        <span>Rules & Safety</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-[11px] font-semibold text-slate-800">
                                        <span class="w-4 h-4 rounded bg-[#004b9b] text-white flex items-center justify-center text-[9px] shrink-0">🍴</span>
                                        <span>Canteen & Services</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-[11px] font-semibold text-slate-800">
                                        <span class="w-4 h-4 rounded bg-[#004b9b] text-white flex items-center justify-center text-[9px] shrink-0">👤</span>
                                        <span>Attendance Guide</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-[11px] font-semibold text-slate-800">
                                        <span class="w-4 h-4 rounded bg-[#004b9b] text-white flex items-center justify-center text-[9px] shrink-0">🎧</span>
                                        <span>Support & Contact</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const renderAllQrs = async () => {
                if (!window.QRCode) {
                    setTimeout(renderAllQrs, 120);
                    return;
                }
                const containers = document.querySelectorAll('[data-qr-url]');
                for (const el of containers) {
                    const url = el.getAttribute('data-qr-url');
                    try {
                        el.innerHTML = await window.QRCode.toString(url, {
                            type: 'svg',
                            width: 200,
                            margin: 1,
                            errorCorrectionLevel: 'M',
                            color: { dark: '#0f172a', light: '#ffffff' }
                        });
                    } catch (e) {
                        console.error(e);
                    }
                }
            };
            renderAllQrs();
        });
    </script>
</body>
</html>
