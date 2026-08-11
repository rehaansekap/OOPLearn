<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pertemuan 3 – Fase 3 – Penstrukturan Ide</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        @keyframes ring-out {
            0%, 100% { box-shadow: 0 0 0 0 rgba(147,51,234,0.45); }
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

        /* Mapping modal (pola sama dgn fase3.blade.php P1 / fase3-inheritance.blade.php P2) */
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

        @include('_navbar', ['navTitle' => 'Pertemuan 3 – Fase 3 – Penstrukturan Ide'])
        <div class="flex-1 overflow-y-auto p-8">

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8 lg:p-10 min-h-[80vh] relative" data-aos="fade-up">

            {{-- Phase badge + Pertemuan badge + Materi link --}}
            <div class="flex items-center justify-between gap-3 mb-5 flex-wrap">
                <div class="flex items-center gap-3 flex-wrap">
                    <span class="inline-flex items-center gap-1.5 bg-purple-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Fase 3 dari 5
                    </span>
                    <span class="text-xs text-gray-400 font-medium">Model Needham Lima Fase</span>
                    <span class="inline-flex items-center gap-1.5 bg-purple-50 text-purple-700 border border-purple-200 text-xs font-semibold px-3 py-1 rounded-full">
                        Pertemuan 3 · Enkapsulasi & Inheritance
                    </span>
                </div>
                <a href="{{ route('lesson') }}" target="_blank" onclick="tandaiMateriDibuka(3)"
                   class="inline-flex items-center gap-2 text-xs font-semibold text-purple-700 bg-purple-50 border border-purple-200
                          px-3 py-1.5 rounded-full hover:bg-purple-100 hover:border-purple-300 transition">
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
                <span class="text-purple-600">— Sistem Akun Sekolah</span>
            </h2>
            <p class="text-sm text-gray-500 mb-6">
                Susun blok kode untuk membuat class Guru yang mewarisi AkunSekolah, dengan password tetap aman.
                Butuh referensi?
                <a href="{{ route('lesson') }}" target="_blank" onclick="tandaiMateriDibuka(3)" class="text-purple-600 font-medium hover:underline">Buka halaman Materi</a>.
            </p>

            {{-- Needham stepper (inline, tema ungu Pertemuan 3) --}}
            <div class="flex items-center mb-8 overflow-x-auto pb-1">
                @php
                $_steps = [1 => 'Orientasi', 2 => 'Pencetusan Ide', 3 => 'Penstrukturan', 4 => 'Aplikasi', 5 => 'Refleksi'];
                @endphp
                @foreach($_steps as $n => $nama)
                <div class="flex items-center">
                    <div class="flex flex-col items-center gap-1 px-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold border-2 transition-all"
                             style="{{ $n <= 3 ? 'background:#9333ea;border-color:#9333ea;color:white;' : 'background:white;border-color:#e5e7eb;color:#9ca3af;' }}">
                            {{ $n < 3 ? '✓' : $n }}
                        </div>
                        <span class="text-xs font-medium whitespace-nowrap"
                              style="{{ $n === 3 ? 'color:#7e22ce;font-weight:700;' : 'color:#9ca3af;' }}">
                            {{ $nama }}
                        </span>
                    </div>
                    @if($n < 5)
                    <div class="h-0.5 w-8 flex-shrink-0" style="{{ $n < 3 ? 'background:#9333ea;' : 'background:#e5e7eb;' }}"></div>
                    @endif
                </div>
                @endforeach
            </div>

            {{-- Tujuan Pembelajaran --}}
            <div class="bg-purple-50 border border-purple-100 rounded-2xl p-5 mb-6 flex gap-4">
                <div class="shrink-0 w-9 h-9 rounded-xl bg-purple-100 flex items-center justify-center text-purple-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-wide text-purple-700 mb-2">Tujuan Pembelajaran</p>
                    <ul class="space-y-1 text-sm text-purple-900">
                        <li class="flex gap-2"><span class="text-purple-400 font-bold shrink-0">✓</span> Menyusun class Guru yang mewarisi AkunSekolah dengan menggunakan block programming</li>
                        <li class="flex gap-2"><span class="text-purple-400 font-bold shrink-0">✓</span> Memahami bahwa atribut private tetap terkunci meski diwariskan, dan hanya bisa diakses lewat getter/setter</li>
                    </ul>
                </div>
            </div>

            {{-- ═══════════════════════════════════════════════════════════
                 ATURAN CARDS (dipindahkan dari pertemuan-fase.blade.php,
                 blok @elseif($pertemuan==3 && $fase==3) lama)
            ═══════════════════════════════════════════════════════════ --}}
            <div class="space-y-8 pb-10" data-aos="fade-up" data-aos-duration="550">

                <div class="flex items-start gap-4">
                    <div class="text-4xl leading-none mt-0.5 select-none">🏗️</div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">
                            Penstrukturan Ide: Aturan Gabungan OOP
                        </h3>
                        <p class="text-sm text-purple-600 font-medium">Enkapsulasi + Inheritance · Aturan krusial yang harus dipahami</p>
                    </div>
                </div>

                <p class="text-gray-700 text-base leading-relaxed">
                    Saat menggabungkan dua konsep ini, ada aturan penting yang
                    <strong class="text-gray-900">wajib kamu ingat</strong> agar sistem bekerja dengan benar:
                </p>

                <div class="space-y-4">

                    {{-- Aturan 1 --}}
                    <div class="bg-white border border-gray-200 rounded-2xl p-5 flex gap-4 shadow-sm">
                        <div class="w-10 h-10 bg-rose-100 rounded-xl flex items-center justify-center shrink-0 mt-0.5">
                            <span class="text-rose-700 font-black text-lg leading-none">1</span>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-bold text-gray-900">Private Tetap Private</span>
                                <span class="text-xs bg-rose-50 border border-rose-200 text-rose-600 font-semibold px-2 py-0.5 rounded-full">Aturan Enkapsulasi</span>
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                Meski diturunkan melalui Inheritance, class anak
                                <strong class="text-rose-700">tidak bisa langsung menyentuh</strong>
                                atribut <code class="bg-gray-100 text-gray-700 font-mono text-xs px-1 rounded">private</code>
                                milik class induk.
                                "Brankas" tetap terkunci rapat meski sudah diwariskan.
                            </p>
                            <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 font-mono text-xs space-y-0.5">
                                <p class="text-purple-600 font-semibold">class Guru(AkunSekolah):</p>
                                <p class="ml-4 text-gray-400"># ❌ INI AKAN ERROR!</p>
                                <p class="ml-4"><span class="text-red-500">print(self.__password)</span>  <span class="text-gray-400"># tidak bisa diakses</span></p>
                            </div>
                        </div>
                    </div>

                    {{-- Aturan 2 --}}
                    <div class="bg-white border border-gray-200 rounded-2xl p-5 flex gap-4 shadow-sm">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center shrink-0 mt-0.5">
                            <span class="text-green-700 font-black text-lg leading-none">2</span>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-bold text-gray-900">Akses via Method Resmi</span>
                                <span class="text-xs bg-green-50 border border-green-200 text-green-600 font-semibold px-2 py-0.5 rounded-full">Solusi yang Benar</span>
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                Class anak <strong class="text-green-700">hanya bisa</strong> membaca atau mengubah
                                password induknya melalui method
                                <code class="bg-gray-100 text-gray-700 font-mono text-xs px-1 rounded">Getter</code>
                                dan
                                <code class="bg-gray-100 text-gray-700 font-mono text-xs px-1 rounded">Setter</code>
                                yang berstatus <strong>public</strong> — pintu resmi yang sudah disediakan class induk.
                            </p>
                            <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 font-mono text-xs space-y-0.5">
                                <p class="text-purple-600 font-semibold">class Guru(AkunSekolah):</p>
                                <p class="ml-4 text-gray-400"># ✅ CARA YANG BENAR</p>
                                <p class="ml-4"><span class="text-blue-600">pw</span> = <span class="text-green-600">self.get_password()</span>  <span class="text-gray-400"># lewat getter</span></p>
                                <p class="ml-4"><span class="text-green-600">self.set_password(</span><span class="text-orange-500">"baru123"</span><span class="text-green-600">)</span>  <span class="text-gray-400"># lewat setter</span></p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="bg-purple-600 rounded-2xl p-5 flex gap-4">
                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-purple-100 uppercase tracking-wider mb-1.5">Inti dari Gabungan Ini</p>
                        <p class="text-white text-sm leading-relaxed">
                            Inheritance membuat struktur class lebih <strong>efisien dan logis</strong>,
                            sementara Enkapsulasi menjamin bahwa data sensitif tetap
                            <strong>terlindungi</strong> — bahkan dari class-class turunannya sendiri.
                        </p>
                    </div>
                </div>

                <p class="text-gray-700 text-sm leading-relaxed">
                    Sekarang saatnya mempraktikkan kedua aturan ini. Susun blok kode di bawah untuk membuat
                    <strong class="text-gray-900">class Guru</strong> yang mewarisi
                    <strong class="text-gray-900">class AkunSekolah</strong>, dengan password yang tetap aman!
                </p>

            </div>

            {{-- Gerbang Materi — wajib dibuka dulu sebelum toolbox praktik aktif --}}
            @if(!$materiDibuka)
            <div id="materiGateBox" class="bg-amber-50 border-2 border-dashed border-amber-300 rounded-2xl p-8 text-center mb-6">
                <div class="text-4xl mb-3 select-none">📖</div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Pahami Materi Dulu, Baru Susun Kode</h3>
                <p class="text-sm text-gray-600 max-w-md mx-auto mb-5">
                    Sebelum menyusun blok kode di bawah, buka dan baca dulu halaman Materi supaya konsepnya
                    benar-benar matang — bukan cuma coba-coba blok.
                </p>
                <a href="{{ route('lesson') }}" target="_blank" onclick="tandaiMateriDibuka(3)"
                   class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-bold px-6 py-3 rounded-xl transition shadow-sm">
                    📖 Buka Materi Sekarang
                </a>
            </div>
            @endif

            <div id="toolboxWrap" style="{{ $materiDibuka ? '' : 'display:none;' }}">
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

                            <button class="cat-btn" id="cat-pewarisan" onclick="setCategory('pewarisan')"
                                    style="color:rgba(255,255,255,0.45);background:transparent;">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/>
                                </svg>
                                Pewarisan
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
                            <span style="margin-left:8px;color:#475569;font-size:11px;font-weight:600;font-family:monospace;">akun_sekolah.py</span>
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
                                Gabungan berhasil!<br>
                                <span style="font-size:10px;font-weight:500;opacity:.75;">Guru mewarisi AkunSekolah, password tetap aman.</span>
                            </p>
                        </div>

                        <div id="outFail" style="display:none;text-align:center;width:100%;">
                            <div style="font-size:28px;margin-bottom:8px;">❌</div>
                            <p id="outFailMsg" style="color:#f87171;font-size:11px;font-weight:700;line-height:1.5;">
                                Belum lengkap!
                            </p>
                        </div>

                    </div>

                </div>

            </div><!-- end flex row -->
            </div><!-- /toolboxWrap -->

            {{-- ── NAVIGASI LANJUT (muncul setelah Run berhasil) ──────────── --}}
            <div id="lanjutBox"
                 style="display:none;"
                 class="mt-5 flex items-center justify-between gap-4 bg-purple-50 border border-purple-200 rounded-2xl px-6 py-4">

                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-purple-500 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-purple-800">Penstrukturan Ide selesai!</p>
                        <p class="text-xs text-purple-600">Class Guru berhasil mewarisi AkunSekolah dengan aman. Lanjutkan ke Fase 4 untuk mempraktikkannya.</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" onclick="openMappingView()"
                            class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2.5 rounded-xl font-semibold text-sm transition shadow-sm whitespace-nowrap">
                        🔍 Lihat Kode Python
                    </button>

                    <form method="POST" action="{{ route('p3.fase3.complete') }}">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition shadow-sm whitespace-nowrap">
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
                            <div class="mapping-item" data-map-id="pewarisan"
                                 onmouseenter="highlightPair('pewarisan')" onmouseleave="clearHighlight()">
                                🧬 Pewarisan
                            </div>
                            <div class="mapping-item" data-map-id="akses-data"
                                 onmouseenter="highlightPair('akses-data')" onmouseleave="clearHighlight()">
                                🔒 Akses Data
                            </div>
                            <div class="mapping-item" data-map-id="method"
                                 onmouseenter="highlightPair('method')" onmouseleave="clearHighlight()">
                                💬 Method
                            </div>
                        </div>

                        {{-- Kolom kanan: kode Python acuan --}}
                        <div style="flex:1;min-width:0;background:#0a101e;border-radius:10px;padding:14px 16px;overflow-y:auto;">
                            <pre style="margin:0;font-family:'Courier New',monospace;font-size:12.5px;line-height:1.9;color:#e2e8f0;"><code
><span class="code-line" data-map-id="struktur-class" onmouseenter="highlightPair('struktur-class')" onmouseleave="clearHighlight()">class AkunSekolah:</span>
<span class="code-line" data-map-id="struktur-class" onmouseenter="highlightPair('struktur-class')" onmouseleave="clearHighlight()">    def __init__(self, nama, password):</span>
<span class="code-line" data-map-id="struktur-class" onmouseenter="highlightPair('struktur-class')" onmouseleave="clearHighlight()">        self.nama = nama</span>
<span class="code-line" data-map-id="akses-data" onmouseenter="highlightPair('akses-data')" onmouseleave="clearHighlight()">        self.__password = password</span>
<span class="code-line" data-map-id="method" onmouseenter="highlightPair('method')" onmouseleave="clearHighlight()">    def get_password(self):</span>
<span class="code-line" data-map-id="akses-data" onmouseenter="highlightPair('akses-data')" onmouseleave="clearHighlight()">        return self.__password</span>
<span class="code-line" data-map-id="method" onmouseenter="highlightPair('method')" onmouseleave="clearHighlight()">    def set_password(self, password_baru):</span>
<span class="code-line" data-map-id="akses-data" onmouseenter="highlightPair('akses-data')" onmouseleave="clearHighlight()">        self.__password = password_baru</span>
<span class="code-line" data-map-id="pewarisan" onmouseenter="highlightPair('pewarisan')" onmouseleave="clearHighlight()">class Guru(AkunSekolah):</span>
<span class="code-line" data-map-id="pewarisan" onmouseenter="highlightPair('pewarisan')" onmouseleave="clearHighlight()">    def __init__(self, nama, password, mata_pelajaran):</span>
<span class="code-line" data-map-id="pewarisan" onmouseenter="highlightPair('pewarisan')" onmouseleave="clearHighlight()">        super().__init__(nama, password)</span>
<span class="code-line" data-map-id="struktur-class" onmouseenter="highlightPair('struktur-class')" onmouseleave="clearHighlight()">        self.mata_pelajaran = mata_pelajaran</span>
<span class="code-line" data-map-id="method" onmouseenter="highlightPair('method')" onmouseleave="clearHighlight()">    def info(self):</span>
<span class="code-line" data-map-id="method" onmouseenter="highlightPair('method')" onmouseleave="clearHighlight()">        print("Guru:", self.nama, "- Mapel:", self.mata_pelajaran)</span></code></pre>
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
// GERBANG MATERI — tandai "sudah buka Materi" ke server, lalu buka toolbox
// tanpa perlu reload halaman.
// ═════════════════════════════════════════════════════════════════════════════
function tandaiMateriDibuka(pertemuan) {
  fetch('{{ route("materi.tandai-dibuka") }}', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    body: JSON.stringify({ pertemuan: pertemuan })
  }).then(() => {
    const gate = document.getElementById('materiGateBox');
    const wrap = document.getElementById('toolboxWrap');
    if (gate) gate.style.display = 'none';
    if (wrap) wrap.style.display = '';
  }).catch(() => {});
}

// ═════════════════════════════════════════════════════════════════════════════
// BLOCK SHAPE ENGINE  (Scratch-style puzzle-piece SVG path generation)
// Disalin persis dari fase3.blade.php Pertemuan 1 — generik, tidak spesifik domain
// ═════════════════════════════════════════════════════════════════════════════

const BH = 36;   // block body height (px)
const NH = 7;    // notch / bump height (depth)
const NX = 18;   // notch start x
const NW = 20;   // notch width
const CR = 5;    // corner radius

function scratchPath(W, top, bot) {
    const H = BH;
    let d = '';

    d += `M ${CR} 0 `;
    if (top) {
        d += `L ${NX} 0 `;
        d += `L ${NX} ${NH} `;
        d += `L ${NX + NW} ${NH} `;
        d += `L ${NX + NW} 0 `;
    }
    d += `L ${W - CR} 0 Q ${W} 0 ${W} ${CR} `;

    d += `L ${W} ${H - CR} Q ${W} ${H} ${W - CR} ${H} `;

    if (bot) {
        d += `L ${NX + NW} ${H} `;
        d += `L ${NX + NW} ${H + NH} `;
        d += `L ${NX} ${H + NH} `;
        d += `L ${NX} ${H} `;
    }
    d += `L ${CR} ${H} Q 0 ${H} 0 ${H - CR} `;

    d += `L 0 ${CR} Q 0 0 ${CR} 0 Z`;

    return d;
}

function makeBlockEl(blk, W, hasTop, hasBot, rmId = null) {
    const totalH = BH + (hasBot ? NH : 0);
    const d      = scratchPath(W, hasTop, hasBot);

    const shade  = 'rgba(0,0,0,0.28)';
    const shine  = 'rgba(255,255,255,0.18)';

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

    const shineLine = document.createElementNS(svgNS, 'path');
    const shineTop  = hasTop ? NH + 1 : 2;
    shineLine.setAttribute('d',      `M ${CR + 2} ${shineTop} L ${W - CR - 2} ${shineTop}`);
    shineLine.setAttribute('stroke', shine);
    shineLine.setAttribute('stroke-width', '1.5');
    shineLine.setAttribute('stroke-linecap', 'round');
    svg.appendChild(shineLine);

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
// BLOCK DATA — domain AkunSekolah / Guru / Siswa (Enkapsulasi + Inheritance)
// Opsi B: TIDAK ada kategori Kondisi — fokus murni private+getter/setter+pewarisan
// ═════════════════════════════════════════════════════════════════════════════

const BLOCKS = {
    struktur: [
        { id:'class', label:'class AkunSekolah:',                 icon:'📦', color:'#4C97FF', tag:'Class' },
        { id:'init',  label:'def __init__(self, nama, password):', icon:'⚙️', color:'#3d82e0', tag:'Init'  },
        { id:'pass',  label:'pass',                                  icon:'–',  color:'#475569', tag:'Pass'  },
    ],
    pewarisan: [
        { id:'extends', label:'class Guru(AkunSekolah):',        icon:'🧬', color:'#db2777', tag:'ChildClass' },
        { id:'super',   label:'super().__init__(nama, password)', icon:'🔗', color:'#be185d', tag:'SuperInit'  },
    ],
    akses: [
        { id:'private', label:'self.__password = password', icon:'🔒', color:'#9333ea', tag:'Private' },
    ],
    method: [
        { id:'getter', label:'def get_password(self):',            icon:'⬅️', color:'#ea580c', tag:'Getter' },
        { id:'setter', label:'def set_password(self, password_baru):', icon:'➡️', color:'#dc4e08', tag:'Setter' },
        { id:'info',   label:'def info(self):',                    icon:'💬', color:'#c2410c', tag:'Method' },
    ],
};

const CAT_COLORS = {
    struktur:'#4C97FF', pewarisan:'#db2777', akses:'#9333ea', method:'#ea580c',
};

let wsItems    = [];
let currentCat = 'struktur';

const PW = 240;
let wsBlockW = 380;

// ═════════════════════════════════════════════════════════════════════════════
// CATEGORY / PALETTE — disalin persis dari fase3.blade.php Pertemuan 1
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
        const wrap = makeBlockEl(blk, PW, true, true);
        wrap.classList.add('s-block-wrap');
        wrap.style.marginBottom = '10px';

        wrap.onclick     = () => addBlock(blk);
        wrap.draggable   = true;
        wrap.ondragstart = e  => e.dataTransfer.setData('blockKey', `${currentCat}::${blk.id}`);

        palette.appendChild(wrap);
    });
}

// ═════════════════════════════════════════════════════════════════════════════
// WORKSPACE — disalin persis dari fase3.blade.php Pertemuan 1
// ═════════════════════════════════════════════════════════════════════════════

function calcWsBlockW() {
    const zone = document.getElementById('wsDropZone');
    if (zone && zone.clientWidth > 60) {
        wsBlockW = Math.max(180, zone.clientWidth - 48);
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
        const row = document.createElement('div');
        row.style.cssText = `
            display: flex;
            align-items: flex-start;
            gap: 6px;
            height: ${BH}px;
            overflow: visible;
        `;
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

// ═════════════════════════════════════════════════════════════════════════════
// RUN — validasi Gabungan Enkapsulasi+Inheritance (deteksi kelengkapan tag,
// bukan urutan/kebenaran). Opsi B: TIDAK mewajibkan tag Kondisi/If.
// ═════════════════════════════════════════════════════════════════════════════

function runProgram() {
    const tags          = wsItems.map(b => b.tag);
    const hasClass      = tags.includes('Class');
    const hasPriv       = tags.includes('Private');
    const hasGetter     = tags.includes('Getter');
    const hasSetter     = tags.includes('Setter');
    const hasChildClass = tags.includes('ChildClass');
    const hasSuperInit  = tags.includes('SuperInit');

    document.getElementById('outEmpty').style.display = 'none';

    if (hasClass && hasPriv && hasGetter && hasSetter && hasChildClass && hasSuperInit) {
        document.getElementById('outSuccess').style.display = 'block';
        document.getElementById('outFail').style.display    = 'none';
        document.getElementById('lanjutBox').style.display  = 'block';
        document.querySelector('#lanjutBox button[type="submit"]').classList.add('btn-pulse');
    } else {
        const missing = [];
        if (!hasClass)      missing.push('class induk (AkunSekolah)');
        if (!hasPriv)       missing.push('atribut private (__password)');
        if (!hasGetter)     missing.push('getter');
        if (!hasSetter)     missing.push('setter');
        if (!hasChildClass) missing.push('class anak yang mewarisi (Guru)');
        if (!hasSuperInit)  missing.push('pemanggilan super().__init__()');

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
// Disalin persis dari fase3.blade.php Pertemuan 1
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
