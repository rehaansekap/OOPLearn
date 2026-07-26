<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fase 3 - Penstrukturan Ide</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        @keyframes ring-out {
            0%, 100% { box-shadow: 0 0 0 0 rgba(22,163,74,0.45); }
            60%       { box-shadow: 0 0 0 12px transparent; }
        }
        .btn-pulse { animation: ring-out 2s ease-in-out infinite; }

        /* Block wrapper hover lift */
        .s-block-wrap {
            transition: transform 0.12s, filter 0.12s;
            cursor: pointer;
            user-select: none;
        }
        .s-block-wrap:hover {
            transform: translateY(-2px);
            filter: brightness(1.08);
        }
        .s-block-wrap:active {
            transform: translateY(1px);
            filter: brightness(0.95);
        }

        /* Category button */
        .cat-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 12px;
            font-weight: 700;
            text-align: left;
            width: 100%;
            transition: background 0.15s, color 0.15s;
        }

        /* Workspace drop zone */
        .ws-inner {
            background-color: #111827;
            background-image: radial-gradient(circle, #1e2a3a 1px, transparent 1px);
            background-size: 22px 22px;
        }

        @keyframes snapIn {
            from { opacity:0; transform: translateX(-10px) scale(0.96); }
            to   { opacity:1; transform: translateX(0)      scale(1);    }
        }
        .snap-in { animation: snapIn 0.2s ease; }

        /* Mapping modal (pola sama dgn .acc-modal di blueprint/builder.blade.php) */
        @keyframes fadeSlide {
            from { opacity:0; transform: translateY(8px) scale(0.98); }
            to   { opacity:1; transform: translateY(0)    scale(1);    }
        }
        .mapping-modal {
            display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.72);
            z-index: 500; align-items: center; justify-content: center; padding: 20px;
        }
        .mapping-modal.open { display: flex; }
        .mapping-modal-box {
            background: #0f172a; border: 1px solid rgba(255,255,255,0.08); border-radius: 16px;
            padding: 20px; width: 100%; max-width: 720px; max-height: 85vh;
            animation: fadeSlide 0.2s ease;
        }
        .mapping-item {
            display: flex; align-items: center; gap: 8px; padding: 10px 12px;
            border-radius: 8px; border-left: 3px solid transparent;
            color: rgba(255,255,255,0.6); font-size: 12px; font-weight: 700; cursor: default;
            transition: background 0.15s, border-color 0.15s, color 0.15s;
        }
        .mapping-item.active {
            background: rgba(255,171,25,0.12); border-left-color: #FFAB19; color: #FFAB19;
        }
        .code-line {
            display: block; padding: 1px 8px; border-radius: 4px; border-left: 3px solid transparent;
            transition: background 0.15s, border-color 0.15s;
        }
        .code-line.active {
            background: rgba(255,171,25,0.12); border-left-color: #FFAB19;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

{{-- Hidden SVG defs for drop shadow filter --}}
<svg width="0" height="0" style="position:absolute;" xmlns="http://www.w3.org/2000/svg">
    <defs>
        <filter id="blk-shadow" x="-5%" y="-5%" width="115%" height="130%">
            <feDropShadow dx="0" dy="2" stdDeviation="2" flood-color="rgba(0,0,0,0.4)"/>
        </filter>
    </defs>
</svg>

<div class="flex min-h-screen" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">

    @include('sidebar-siswa')

    <main class="flex-1 flex flex-col overflow-hidden">

        @include('_navbar', ['navTitle' => 'Fase 3 – Penstrukturan Ide'])
        <div class="flex-1 overflow-y-auto p-8">

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8 lg:p-10 min-h-[80vh] relative" data-aos="fade-up">

            {{-- Phase badge + Materi link --}}
            <div class="flex items-center justify-between gap-3 mb-5 flex-wrap">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-1.5 bg-green-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Fase 3 dari 5
                    </span>
                    <span class="text-xs text-gray-400 font-medium">Model Needham Lima Fase</span>
                </div>
                <a href="{{ route('lesson') }}" target="_blank"
                   class="inline-flex items-center gap-2 text-xs font-semibold text-green-700 bg-green-50 border border-green-200
                          px-3 py-1.5 rounded-full hover:bg-green-100 hover:border-green-300 transition">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Buka Materi
                    <svg class="w-3 h-3 opacity-60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
            </div>

            <h2 class="text-2xl font-extrabold text-gray-900 mb-1">
                Penstrukturan Ide
                <span class="text-green-600">— Class BankAccount</span>
            </h2>
            <p class="text-sm text-gray-500 mb-6">
                Susun blok kode untuk membuat class enkapsulasi yang benar.
                Butuh referensi?
                <a href="{{ route('lesson') }}" target="_blank" class="text-green-600 font-medium hover:underline">Buka halaman Materi</a>.
            </p>

            @include('_needham-stepper', ['currentFase' => 3])

            {{-- Tujuan Pembelajaran --}}
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5 mb-6 flex gap-4">
                <div class="shrink-0 w-9 h-9 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-wide text-blue-700 mb-2">Tujuan Pembelajaran</p>
                    <ul class="space-y-1 text-sm text-blue-900">
                        <li class="flex gap-2"><span class="text-blue-400 font-bold shrink-0">✓</span> Menyusun struktur class BankAccount dengan enkapsulasi yang benar menggunakan block programming</li>
                        <li class="flex gap-2"><span class="text-blue-400 font-bold shrink-0">✓</span> Memahami perbedaan atribut public, protected (<code class="bg-blue-100 px-1 rounded text-xs">_</code>), dan private (<code class="bg-blue-100 px-1 rounded text-xs">__</code>) di Python</li>
                    </ul>
                </div>
            </div>

            {{-- Studi Kasus --}}
            <div class="mb-6" data-aos="fade-up">
                <div class="flex items-start gap-4 mb-4">
                    <div class="text-4xl leading-none mt-0.5 select-none">🏦</div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Studi Kasus: Sistem Rekening Bank Digital</h3>
                        <p class="text-sm text-orange-600 font-medium">Ingat masalah di Fase 1?</p>
                    </div>
                </div>

                <p class="text-gray-700 text-sm leading-relaxed mb-4">
                    Pada Fase 1, kamu melihat bagaimana saldo rekening bisa diubah sembarangan menjadi
                    <code class="bg-gray-100 px-1.5 py-0.5 rounded text-red-600 font-mono text-xs">akun1.saldo = -1000</code>
                    karena atributnya bersifat publik. Sekarang saatnya memperbaikinya!
                    Bank tempatmu bekerja meminta kamu menyusun class <strong class="text-gray-900">BankAccount</strong>
                    yang aman, dengan ketentuan berikut:
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="bg-purple-50 border border-purple-100 rounded-xl p-4">
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="text-lg">🔒</span>
                            <span class="text-xs font-bold text-purple-800">Saldo bersifat private</span>
                        </div>
                        <p class="text-xs text-purple-600 leading-relaxed">Tidak boleh diubah langsung dari luar class, harus lewat method khusus.</p>
                    </div>
                    <div class="bg-orange-50 border border-orange-100 rounded-xl p-4">
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="text-lg">🔁</span>
                            <span class="text-xs font-bold text-orange-800">Sediakan getter &amp; setter</span>
                        </div>
                        <p class="text-xs text-orange-600 leading-relaxed"><code class="text-[11px]">get_saldo()</code> untuk membaca, <code class="text-[11px]">set_saldo()</code> untuk mengubah nilai saldo dengan aman.</p>
                    </div>
                    <div class="bg-green-50 border border-green-100 rounded-xl p-4">
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="text-lg">✅</span>
                            <span class="text-xs font-bold text-green-800">Data terlindungi</span>
                        </div>
                        <p class="text-xs text-green-600 leading-relaxed">Kasus saldo -1000 seperti di Fase 1 tidak akan terjadi lagi.</p>
                    </div>
                </div>
            </div>

            <!-- ══ SCRATCH-LIKE BLOCK PROGRAMMING ═════════════════════════════ -->
            <div class="flex gap-4" style="min-height:520px;">

                <!-- ── TOOLBOX ──────────────────────────────────────────────── -->
                <div style="width:264px;flex-shrink:0;background:#0f172a;border-radius:16px;overflow:hidden;display:flex;flex-direction:column;">

                    <!-- Category tabs -->
                    <div style="padding:12px 12px 10px;background:#0a101e;border-bottom:1px solid rgba(255,255,255,0.05);">
                        <p style="color:#475569;font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:10px;">
                            Blok Tersedia
                        </p>
                        <div style="display:flex;flex-direction:column;gap:3px;">

                            <button class="cat-btn" id="cat-struktur" onclick="setCategory('struktur')"
                                    style="color:white;background:#4C97FF;">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h7"/>
                                </svg>
                                Struktur Class
                            </button>

                            <button class="cat-btn" id="cat-akses" onclick="setCategory('akses')"
                                    style="color:rgba(255,255,255,0.45);background:transparent;">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5A2.25 2.25 0 0021 18v-6.75a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 11.25V18a2.25 2.25 0 002.25 2.25z"/>
                                </svg>
                                Akses Data
                            </button>

                            <button class="cat-btn" id="cat-method" onclick="setCategory('method')"
                                    style="color:rgba(255,255,255,0.45);background:transparent;">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
                                </svg>
                                Method
                            </button>

                            <button class="cat-btn" id="cat-nilai" onclick="setCategory('nilai')"
                                    style="color:rgba(255,255,255,0.45);background:transparent;">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/>
                                </svg>
                                Nilai / Return
                            </button>

                            <button class="cat-btn" id="cat-kondisi" onclick="setCategory('kondisi')"
                                    style="color:rgba(255,255,255,0.45);background:transparent;">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v4m0 0l-5 5m5-5l5 5M7 13v4a2 2 0 002 2h6a2 2 0 002-2v-4"/>
                                </svg>
                                Kondisi
                            </button>

                        </div>
                    </div>

                    <!-- Block palette -->
                    <div id="blockPalette"
                         style="flex:1;padding:16px 12px 12px;overflow-y:auto;background:#0d1424;">
                    </div>
                </div>

                <!-- ── WORKSPACE ────────────────────────────────────────────── -->
                <div id="workspacePanel"
                     style="flex:1;min-width:0;background:#0f172a;border-radius:16px;overflow:hidden;display:flex;flex-direction:column;">

                    <!-- Title bar -->
                    <div style="padding:10px 16px;background:#0a101e;border-bottom:1px solid rgba(255,255,255,0.05);display:flex;align-items:center;justify-content:space-between;flex-shrink:0;">
                        <div style="display:flex;align-items:center;gap:7px;">
                            <span style="width:11px;height:11px;border-radius:50%;background:#ff5f56;display:inline-block;"></span>
                            <span style="width:11px;height:11px;border-radius:50%;background:#ffbd2e;display:inline-block;"></span>
                            <span style="width:11px;height:11px;border-radius:50%;background:#27c93f;display:inline-block;"></span>
                            <span style="margin-left:8px;color:#475569;font-size:11px;font-weight:600;font-family:monospace;">enkapsulasi.py</span>
                        </div>
                        <button onclick="resetWorkspace()"
                                style="font-size:11px;color:#475569;background:transparent;border:1px solid rgba(255,255,255,0.1);border-radius:6px;padding:3px 10px;cursor:pointer;font-weight:600;"
                                onmouseover="this.style.color='white';this.style.borderColor='rgba(255,255,255,0.3)';"
                                onmouseout="this.style.color='#475569';this.style.borderColor='rgba(255,255,255,0.1)';">
                            ↺ Reset
                        </button>
                    </div>

                    <!-- Drop zone -->
                    <div class="ws-inner" id="wsDropZone"
                         style="flex:1;padding:20px;overflow-y:auto;"
                         ondragover="event.preventDefault()"
                         ondrop="handleDrop(event)">

                        <div id="wsPlaceholder"
                             style="height:100%;min-height:200px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;text-align:center;">
                            <svg width="38" height="38" fill="none" viewBox="0 0 24 24" stroke="#1e3a5f" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span style="font-size:13px;font-weight:600;color:#1e3a5f;line-height:1.6;">
                                Klik blok di toolbox<br>
                                <span style="font-size:11px;font-weight:500;color:#172040;">atau seret ke sini</span>
                            </span>
                        </div>

                        <div id="wsBlocks" style="display:none;flex-direction:column;overflow:visible;"></div>
                    </div>

                    <!-- Run button -->
                    <div style="padding:10px 16px;background:#0a101e;border-top:1px solid rgba(255,255,255,0.05);display:flex;justify-content:flex-end;flex-shrink:0;">
                        <button onclick="runProgram()"
                                style="display:inline-flex;align-items:center;gap:7px;background:#4C97FF;color:white;padding:8px 22px;border-radius:10px;font-size:13px;font-weight:700;border:none;cursor:pointer;box-shadow:0 3px 0 #2563cc;transition:transform .1s,box-shadow .1s;"
                                onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 5px 0 #2563cc';"
                                onmouseout="this.style.transform='';this.style.boxShadow='0 3px 0 #2563cc';">
                            <svg width="13" height="13" fill="white" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            Run
                        </button>
                    </div>
                </div>

                <!-- ── OUTPUT ────────────────────────────────────────────────── -->
                <div style="width:192px;flex-shrink:0;background:#0f172a;border-radius:16px;overflow:hidden;display:flex;flex-direction:column;">

                    <div style="padding:10px 14px;background:#0a101e;border-bottom:1px solid rgba(255,255,255,0.05);">
                        <p style="color:#475569;font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;">Output</p>
                    </div>

                    <div style="flex:1;padding:14px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;">

                        <div id="outEmpty" style="text-align:center;">
                            <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="#1e3a5f" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.347a1.125 1.125 0 010 1.972l-11.54 6.347c-.75.412-1.667-.13-1.667-.986V5.653z"/>
                            </svg>
                            <p style="font-size:11px;margin-top:8px;line-height:1.6;color:#2a4a6b;">
                                Klik <strong style="color:#4C97FF;">Run</strong><br>untuk melihat hasil
                            </p>
                        </div>

                        <div id="outSuccess" style="display:none;text-align:center;">
                            <div style="font-size:28px;margin-bottom:8px;">✅</div>
                            <p style="color:#4ade80;font-size:12px;font-weight:700;line-height:1.5;">
                                Data terlindungi!<br>
                                <span style="font-size:10px;font-weight:500;opacity:.75;">Enkapsulasi berhasil.</span>
                            </p>
                        </div>

                        <div id="outFail" style="display:none;text-align:center;width:100%;">
                            <div style="font-size:28px;margin-bottom:8px;">❌</div>
                            <p id="outFailMsg" style="color:#f87171;font-size:11px;font-weight:700;line-height:1.5;">
                                Belum lengkap!
                            </p>
                        </div>

                    </div>

                    {{-- lanjutBox dipindah ke bawah panel utama --}}
                </div>

            </div><!-- end flex row -->

            {{-- ── NAVIGASI LANJUT (muncul setelah Run berhasil) ──────────── --}}
            <div id="lanjutBox"
                 style="display:none;"
                 class="mt-5 flex items-center justify-between gap-4 bg-green-50 border border-green-200 rounded-2xl px-6 py-4">

                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-green-500 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-green-800">Penstrukturan Ide selesai!</p>
                        <p class="text-xs text-green-600">Enkapsulasi berhasil disusun. Lanjutkan ke Fase 4 untuk mempraktikkannya.</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" onclick="openMappingView()"
                            class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2.5 rounded-xl font-semibold text-sm transition shadow-sm whitespace-nowrap">
                        🔍 Lihat Kode Python
                    </button>

                    <form method="POST" action="{{ route('fase3.complete') }}">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition shadow-sm whitespace-nowrap">
                            Selanjutnya: Fase 4 – Aplikasi
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            {{-- ── MODAL: Pemetaan Blok ke Sintaks Python ──────────────────── --}}
            <div id="mappingModal" class="mapping-modal" onclick="if(event.target===this) closeMappingView()">
                <div class="mapping-modal-box" style="overflow:hidden;display:flex;flex-direction:column;">

                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;flex-shrink:0;">
                        <div>
                            <p style="color:white;font-size:15px;font-weight:800;">🔍 Pemetaan Blok ke Sintaks Python</p>
                            <p style="color:#64748b;font-size:11.5px;margin-top:2px;">Arahkan kursor ke kategori atau baris kode untuk melihat pasangannya</p>
                        </div>
                        <button onclick="closeMappingView()"
                                style="font-size:13px;color:#475569;background:transparent;border:1px solid rgba(255,255,255,0.1);border-radius:6px;padding:4px 10px;cursor:pointer;font-weight:600;">
                            ✕ Tutup
                        </button>
                    </div>

                    <div style="display:flex;gap:16px;overflow:hidden;">

                        {{-- Kolom kiri: kategori blok --}}
                        <div style="width:200px;flex-shrink:0;display:flex;flex-direction:column;gap:4px;">
                            <div class="mapping-item" data-map-id="struktur-class"
                                 onmouseenter="highlightPair('struktur-class')" onmouseleave="clearHighlight()">
                                📦 Struktur Class
                            </div>
                            <div class="mapping-item" data-map-id="akses-data"
                                 onmouseenter="highlightPair('akses-data')" onmouseleave="clearHighlight()">
                                🔒 Akses Data
                            </div>
                            <div class="mapping-item" data-map-id="method"
                                 onmouseenter="highlightPair('method')" onmouseleave="clearHighlight()">
                                ⚡ Method
                            </div>
                            <div class="mapping-item" data-map-id="nilai-return"
                                 onmouseenter="highlightPair('nilai-return')" onmouseleave="clearHighlight()">
                                ↩️ Nilai / Return
                            </div>
                        </div>

                        {{-- Kolom kanan: kode Python acuan --}}
                        <div style="flex:1;min-width:0;background:#0a101e;border-radius:10px;padding:14px 16px;overflow-y:auto;">
                            <pre style="margin:0;font-family:'Courier New',monospace;font-size:12.5px;line-height:1.9;color:#e2e8f0;"><code
><span class="code-line" data-map-id="struktur-class" onmouseenter="highlightPair('struktur-class')" onmouseleave="clearHighlight()">class BankAccount:</span>
<span class="code-line" data-map-id="struktur-class" onmouseenter="highlightPair('struktur-class')" onmouseleave="clearHighlight()">    def __init__(self):</span>
<span class="code-line" data-map-id="akses-data" onmouseenter="highlightPair('akses-data')" onmouseleave="clearHighlight()">        self.__saldo = 0</span>
<span class="code-line" data-map-id="method" onmouseenter="highlightPair('method')" onmouseleave="clearHighlight()">    def get_saldo(self):</span>
<span class="code-line" data-map-id="nilai-return" onmouseenter="highlightPair('nilai-return')" onmouseleave="clearHighlight()">        return self.__saldo</span>
<span class="code-line" data-map-id="method" onmouseenter="highlightPair('method')" onmouseleave="clearHighlight()">    def set_saldo(self, jumlah):</span>
<span class="code-line" data-map-id="akses-data" onmouseenter="highlightPair('akses-data')" onmouseleave="clearHighlight()">        self.__saldo = jumlah</span></code></pre>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        </div>
    </main>

</div>

<script>
// ═════════════════════════════════════════════════════════════════════════════
// BLOCK SHAPE ENGINE  (Scratch-style puzzle-piece SVG path generation)
// ═════════════════════════════════════════════════════════════════════════════

const BH = 36;   // block body height (px)
const NH = 7;    // notch / bump height (depth)
const NX = 18;   // notch start x
const NW = 20;   // notch width
const CR = 5;    // corner radius

/**
 * Generate the SVG path data for one Scratch-style block.
 * @param {number} W      - block width
 * @param {boolean} top   - include top notch (female connector)
 * @param {boolean} bot   - include bottom bump (male connector)
 */
function scratchPath(W, top, bot) {
    const H = BH;
    let d = '';

    // ── Top edge ──────────────────────────────────────────────────────────
    d += `M ${CR} 0 `;
    if (top) {
        // top notch: indent DOWN into block
        d += `L ${NX} 0 `;
        d += `L ${NX} ${NH} `;
        d += `L ${NX + NW} ${NH} `;
        d += `L ${NX + NW} 0 `;
    }
    d += `L ${W - CR} 0 Q ${W} 0 ${W} ${CR} `;

    // ── Right edge ────────────────────────────────────────────────────────
    d += `L ${W} ${H - CR} Q ${W} ${H} ${W - CR} ${H} `;

    // ── Bottom edge ───────────────────────────────────────────────────────
    if (bot) {
        // bottom bump: protrude DOWN below block
        d += `L ${NX + NW} ${H} `;
        d += `L ${NX + NW} ${H + NH} `;
        d += `L ${NX} ${H + NH} `;
        d += `L ${NX} ${H} `;
    }
    d += `L ${CR} ${H} Q 0 ${H} 0 ${H - CR} `;

    // ── Left edge back to start ───────────────────────────────────────────
    d += `L 0 ${CR} Q 0 0 ${CR} 0 Z`;

    return d;
}

/**
 * Render a block as an HTML element with SVG background + HTML content overlay.
 * @param {object} blk       - block data object
 * @param {number} W         - pixel width of block
 * @param {boolean} hasTop   - whether to show top notch
 * @param {boolean} hasBot   - whether to show bottom bump
 * @param {string|null} rmId - if set, renders a remove button calling removeBlock(rmId)
 */
function makeBlockEl(blk, W, hasTop, hasBot, rmId = null) {
    const totalH = BH + (hasBot ? NH : 0);
    const d      = scratchPath(W, hasTop, hasBot);

    // darken shade for block bottom highlight
    const shade  = 'rgba(0,0,0,0.28)';
    const shine  = 'rgba(255,255,255,0.18)';

    // SVG element (background shape)
    const svgNS  = 'http://www.w3.org/2000/svg';
    const svg    = document.createElementNS(svgNS, 'svg');
    svg.setAttribute('width',   W);
    svg.setAttribute('height',  totalH);
    svg.setAttribute('viewBox', `0 0 ${W} ${totalH}`);
    svg.style.cssText = 'position:absolute;top:0;left:0;display:block;overflow:visible;pointer-events:none;';

    const pathEl = document.createElementNS(svgNS, 'path');
    pathEl.setAttribute('d',            d);
    pathEl.setAttribute('fill',         blk.color);
    pathEl.setAttribute('stroke',       shade);
    pathEl.setAttribute('stroke-width', '1.8');
    pathEl.setAttribute('filter',       'url(#blk-shadow)');
    svg.appendChild(pathEl);

    // Shine line (top inner highlight)
    const shineLine = document.createElementNS(svgNS, 'path');
    const shineTop  = hasTop ? NH + 1 : 2;
    shineLine.setAttribute('d',      `M ${CR + 2} ${shineTop} L ${W - CR - 2} ${shineTop}`);
    shineLine.setAttribute('stroke', shine);
    shineLine.setAttribute('stroke-width', '1.5');
    shineLine.setAttribute('stroke-linecap', 'round');
    svg.appendChild(shineLine);

    // Content overlay (HTML, positioned on top of SVG)
    const content = document.createElement('div');
    const topPad  = hasTop ? NH : 0;
    content.style.cssText = `
        position: absolute;
        top: ${topPad}px;
        left: 0;
        width: 100%;
        height: ${BH}px;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0 ${rmId !== null ? 10 : 12}px;
        color: white;
        font-size: 12px;
        font-family: 'Courier New', monospace;
        font-weight: 700;
        box-sizing: border-box;
    `;

    const icon = document.createElement('span');
    icon.style.cssText = 'font-size:14px;flex-shrink:0;';
    icon.textContent   = blk.icon;

    const label = document.createElement('span');
    label.style.cssText = 'flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;';
    label.textContent   = blk.label;

    content.appendChild(icon);
    content.appendChild(label);

    if (rmId !== null) {
        const rmBtn = document.createElement('button');
        rmBtn.textContent = '✕';
        rmBtn.style.cssText = `
            background: rgba(0,0,0,0.28);
            border: none;
            border-radius: 4px;
            padding: 2px 6px;
            cursor: pointer;
            color: rgba(255,255,255,0.6);
            font-size: 11px;
            flex-shrink: 0;
            transition: background .12s;
        `;
        rmBtn.onmouseover = () => rmBtn.style.background = 'rgba(0,0,0,0.5)';
        rmBtn.onmouseout  = () => rmBtn.style.background = 'rgba(0,0,0,0.28)';
        rmBtn.onclick     = e  => { e.stopPropagation(); removeBlock(rmId); };
        content.appendChild(rmBtn);
    }

    // Wrapper (positioned container for SVG + content)
    const wrap = document.createElement('div');
    wrap.style.cssText = `
        position: relative;
        width: ${W}px;
        height: ${totalH}px;
        overflow: visible;
    `;
    wrap.appendChild(svg);
    wrap.appendChild(content);

    return wrap;
}

// ═════════════════════════════════════════════════════════════════════════════
// BLOCK DATA
// ═════════════════════════════════════════════════════════════════════════════

const BLOCKS = {
    struktur: [
        { id:'class', label:'class BankAccount:',  icon:'📦', color:'#4C97FF', tag:'Class'  },
        { id:'init',  label:'def __init__(self):', icon:'⚙️', color:'#3d82e0', tag:'Init'   },
        { id:'pass',  label:'pass',                 icon:'–',  color:'#475569', tag:'Pass'   },
    ],
    akses: [
        { id:'private',   label:'self.__saldo = 0',   icon:'🔒', color:'#9333ea', tag:'Private'   },
        { id:'protected', label:'self._pemilik = ""', icon:'🛡️', color:'#7c3aed', tag:'Protected' },
        { id:'public',    label:'self.nama = ""',     icon:'🔓', color:'#6d28d9', tag:'Public'    },
    ],
    method: [
        { id:'getter', label:'def get_saldo(self):',    icon:'⬅️', color:'#ea580c', tag:'Getter' },
        { id:'setter', label:'def set_saldo(self, v):', icon:'➡️', color:'#dc4e08', tag:'Setter' },
        { id:'method', label:'def info(self):',          icon:'💬', color:'#c2410c', tag:'Method' },
    ],
    nilai: [
        { id:'return', label:'return self.__saldo', icon:'↩️', color:'#16a34a', tag:'Return' },
        { id:'assign', label:'self.__saldo = v',    icon:'✏️', color:'#15803d', tag:'Assign' },
        { id:'print',  label:'print(self.__saldo)', icon:'🖨️', color:'#166534', tag:'Print'  },
    ],
    kondisi: [
        { id:'if',   label:'if v < 0:', icon:'🔀', color:'#FFAB19', tag:'If'   },
        { id:'else', label:'else:',     icon:'↪️', color:'#E6960E', tag:'Else' },
    ],
};

const CAT_COLORS = {
    struktur:'#4C97FF', akses:'#9333ea', method:'#ea580c', nilai:'#16a34a', kondisi:'#FFAB19',
};

let wsItems    = [];
let currentCat = 'struktur';

// Width of palette blocks (toolbox inner width - 2*12px padding)
const PW = 240;

// Width of workspace blocks (computed after first render)
let wsBlockW = 380;

// ═════════════════════════════════════════════════════════════════════════════
// CATEGORY / PALETTE
// ═════════════════════════════════════════════════════════════════════════════

function setCategory(cat) {
    currentCat = cat;
    Object.keys(BLOCKS).forEach(c => {
        const btn = document.getElementById('cat-' + c);
        btn.style.background = c === cat ? CAT_COLORS[c] : 'transparent';
        btn.style.color      = c === cat ? 'white' : 'rgba(255,255,255,0.45)';
    });
    renderPalette();
}

function renderPalette() {
    const palette = document.getElementById('blockPalette');
    palette.innerHTML = '';

    BLOCKS[currentCat].forEach(blk => {
        const wrap = makeBlockEl(blk, PW, true, true); // notch + bump
        wrap.classList.add('s-block-wrap');
        wrap.style.marginBottom = '10px'; // gap between palette blocks

        wrap.onclick     = () => addBlock(blk);
        wrap.draggable   = true;
        wrap.ondragstart = e  => e.dataTransfer.setData('blockKey', `${currentCat}::${blk.id}`);

        palette.appendChild(wrap);
    });
}

// ═════════════════════════════════════════════════════════════════════════════
// WORKSPACE
// ═════════════════════════════════════════════════════════════════════════════

function calcWsBlockW() {
    const zone = document.getElementById('wsDropZone');
    if (zone && zone.clientWidth > 60) {
        wsBlockW = Math.max(180, zone.clientWidth - 48); // 20px padding + 22px lineNo + 6px gap
    }
}

function addBlock(blk) {
    calcWsBlockW();
    wsItems.push({ ...blk });
    renderWorkspace();
    clearOutput();
}

function handleDrop(e) {
    e.preventDefault();
    const key = e.dataTransfer.getData('blockKey');
    if (!key) return;
    const [cat, id] = key.split('::');
    const blk = BLOCKS[cat]?.find(b => b.id === id);
    if (blk) addBlock(blk);
}

function removeBlock(idx) {
    wsItems.splice(idx, 1);
    renderWorkspace();
    clearOutput();
}

function resetWorkspace() {
    wsItems = [];
    renderWorkspace();
    clearOutput();
}

function renderWorkspace() {
    const placeholder = document.getElementById('wsPlaceholder');
    const blocksEl    = document.getElementById('wsBlocks');

    if (wsItems.length === 0) {
        placeholder.style.display = 'flex';
        blocksEl.style.display    = 'none';
        return;
    }

    placeholder.style.display = 'none';
    blocksEl.style.display    = 'flex';
    blocksEl.innerHTML        = '';

    const W = wsBlockW;

    wsItems.forEach((blk, i) => {
        // Row container: height = body only, bump protrudes below via overflow:visible
        const row = document.createElement('div');
        row.style.cssText = `
            display: flex;
            align-items: flex-start;
            gap: 6px;
            height: ${BH}px;
            overflow: visible;
        `;
        // All rows after the first shift up by NH so block bumps slot into next block's notch
        if (i > 0) row.style.marginTop = `-${NH}px`;

        const lineNo = document.createElement('span');
        lineNo.textContent   = i + 1;
        lineNo.style.cssText = `
            width: 18px;
            text-align: right;
            color: #1e3a5f;
            font-size: 10px;
            font-family: monospace;
            flex-shrink: 0;
            margin-top: ${NH + 10}px;
        `;

        const bWrap = document.createElement('div');
        bWrap.style.cssText = 'flex:1;overflow:visible;position:relative;';

        const inner = makeBlockEl(blk, W, true, true, i);
        inner.classList.add('snap-in');
        bWrap.appendChild(inner);

        row.appendChild(lineNo);
        row.appendChild(bWrap);
        blocksEl.appendChild(row);
    });
}

// ═════════════════════════════════════════════════════════════════════════════
// OUTPUT
// ═════════════════════════════════════════════════════════════════════════════

function clearOutput() {
    document.getElementById('outEmpty').style.display   = 'block';
    document.getElementById('outSuccess').style.display = 'none';
    document.getElementById('outFail').style.display    = 'none';
    document.getElementById('lanjutBox').style.display  = 'none';
}

function runProgram() {
    const tags      = wsItems.map(b => b.tag);
    const hasClass  = tags.includes('Class');
    const hasPriv   = tags.includes('Private');
    const hasGetter = tags.includes('Getter');
    const hasSetter = tags.includes('Setter');

    document.getElementById('outEmpty').style.display = 'none';

    if (hasClass && hasPriv && hasGetter && hasSetter) {
        document.getElementById('outSuccess').style.display = 'block';
        document.getElementById('outFail').style.display    = 'none';
        document.getElementById('lanjutBox').style.display  = 'block';
        document.querySelector('#lanjutBox button[type="submit"]').classList.add('btn-pulse');
    } else {
        const missing = [];
        if (!hasClass)  missing.push('class');
        if (!hasPriv)   missing.push('atribut private');
        if (!hasGetter) missing.push('getter');
        if (!hasSetter) missing.push('setter');

        document.getElementById('outFail').style.display    = 'block';
        document.getElementById('outFailMsg').innerHTML     =
            `Belum lengkap!<br>
             <span style="font-size:10px;font-weight:500;opacity:.8;">
               Perlu: ${missing.join(', ')}
             </span>`;
        document.getElementById('outSuccess').style.display = 'none';
        document.getElementById('lanjutBox').style.display  = 'none';
    }
}

// ═════════════════════════════════════════════════════════════════════════════
// MAPPING VIEW (Blok ↔ Sintaks Python — visualisasi statis, bukan generator)
// ═════════════════════════════════════════════════════════════════════════════

function openMappingView() {
    document.getElementById('mappingModal').classList.add('open');
}

function closeMappingView() {
    document.getElementById('mappingModal').classList.remove('open');
    clearHighlight();
}

function highlightPair(mapId) {
    document.querySelectorAll(`[data-map-id="${mapId}"]`)
        .forEach(el => el.classList.add('active'));
}

function clearHighlight() {
    document.querySelectorAll('.mapping-item.active, .code-line.active')
        .forEach(el => el.classList.remove('active'));
}

// ═════════════════════════════════════════════════════════════════════════════
// INIT
// ═════════════════════════════════════════════════════════════════════════════
setCategory('struktur');
window.addEventListener('resize', () => { calcWsBlockW(); if (wsItems.length) renderWorkspace(); });
</script>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init({ once: true, duration: 600, offset: 20 });</script>
</body>
</html>
