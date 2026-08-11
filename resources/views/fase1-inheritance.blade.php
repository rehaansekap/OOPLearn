<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pertemuan 2 – Fase 1 – Orientasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        @keyframes ring-out {
            0%, 100% { box-shadow: 0 0 0 0 rgba(37,99,235,0.45); }
            60%       { box-shadow: 0 0 0 11px transparent; }
        }
        .btn-pulse { animation: ring-out 2s ease-in-out infinite; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="flex min-h-screen" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">
        @include('sidebar-siswa')

        <main class="flex-1 flex flex-col overflow-hidden">

            @include('_navbar', ['navTitle' => 'Pertemuan 2 – Fase 1 – Orientasi'])
            <div class="flex-1 overflow-y-auto p-8">

            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8 lg:p-10 min-h-[80vh] relative" data-aos="fade-up">

                {{-- Phase badge + Pertemuan badge --}}
                <div class="flex items-center gap-3 mb-5 flex-wrap">
                    <span class="inline-flex items-center gap-1.5 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Fase 1 dari 5
                    </span>
                    <span class="text-xs text-gray-400 font-medium">Model Needham Lima Fase</span>
                    <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 border border-blue-200 text-xs font-semibold px-3 py-1 rounded-full">
                        Pertemuan 2 · Inheritance
                    </span>
                </div>

                <h2 class="text-2xl font-extrabold text-gray-900 mb-1">
                    Orientasi <span class="text-blue-600">— Inheritance</span>
                </h2>
                <p class="text-sm text-gray-500 mb-5">Studi Kasus: Sistem Karakter Gim (RPG)</p>

                {{-- Needham stepper (inline, tema biru Pertemuan 2) --}}
                <div class="flex items-center mb-8 overflow-x-auto pb-1">
                    @php
                    $_steps = [1 => 'Orientasi', 2 => 'Pencetusan Ide', 3 => 'Penstrukturan', 4 => 'Aplikasi', 5 => 'Refleksi'];
                    @endphp
                    @foreach($_steps as $n => $nama)
                    <div class="flex items-center">
                        <div class="flex flex-col items-center gap-1 px-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold border-2 transition-all"
                                 style="{{ $n <= 1 ? 'background:#2563eb;border-color:#2563eb;color:white;' : 'background:white;border-color:#e5e7eb;color:#9ca3af;' }}">
                                {{ $n < 1 ? '✓' : $n }}
                            </div>
                            <span class="text-xs font-medium whitespace-nowrap"
                                  style="{{ $n === 1 ? 'color:#1d4ed8;font-weight:700;' : 'color:#9ca3af;' }}">
                                {{ $nama }}
                            </span>
                        </div>
                        @if($n < 5)
                        <div class="h-0.5 w-8 flex-shrink-0" style="{{ $n < 1 ? 'background:#2563eb;' : 'background:#e5e7eb;' }}"></div>
                        @endif
                    </div>
                    @endforeach
                </div>

                {{-- Tujuan Pembelajaran --}}
                <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5 mb-6 flex gap-4">
                    <div class="shrink-0 w-9 h-9 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wide text-blue-700 mb-2">Tujuan Pembelajaran</p>
                        <ul class="space-y-1 text-sm text-blue-900">
                            <li class="flex gap-2"><span class="text-blue-400 font-bold shrink-0">✓</span> Mengidentifikasi masalah duplikasi kode ketika membuat banyak class dengan data serupa</li>
                            <li class="flex gap-2"><span class="text-blue-400 font-bold shrink-0">✓</span> Menyadari perlunya konsep Inheritance untuk mewariskan data & perilaku umum ke banyak class</li>
                        </ul>
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════════════════
                     Studi Kasus (dipindahkan dari pertemuan-fase.blade.php,
                     blok @if($pertemuan==2 && $fase==1) lama)
                ═══════════════════════════════════════════════════════════ --}}
                <div class="space-y-8 pb-20" data-aos="fade-up" data-aos-duration="550">

                    <div class="flex items-start gap-4">
                        <div class="text-4xl leading-none mt-0.5 select-none">🎮</div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-1">
                                Studi Kasus: Mengembangkan Sistem Karakter Gim (RPG)
                            </h3>
                            <p class="text-sm text-blue-600 font-medium">Apersepsi · Membangun konteks masalah</p>
                        </div>
                    </div>

                    <p class="text-gray-700 text-base leading-relaxed">
                        Bayangkan kamu direkrut menjadi programmer untuk sebuah studio gim besar.
                        Tugas pertamamu adalah membuat dua jenis karakter:
                        <strong class="text-gray-900">Hero</strong> (Pahlawan) dan
                        <strong class="text-gray-900">Monster</strong>.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-2xl select-none">🦸</span>
                                <span class="font-bold text-blue-800">Hero (Pahlawan)</span>
                            </div>
                            <p class="text-[11px] text-blue-500 font-bold uppercase tracking-widest mb-3">
                                Data yang dibutuhkan:
                            </p>
                            <ul class="space-y-2">
                                <li class="flex items-center gap-2.5">
                                    <code class="text-xs bg-white border border-blue-200 px-2 py-0.5 rounded-md text-blue-700 font-mono">nama</code>
                                    <span class="text-sm text-gray-600">nama karakter</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <code class="text-xs bg-white border border-blue-200 px-2 py-0.5 rounded-md text-blue-700 font-mono">nyawa</code>
                                    <span class="text-sm text-gray-600">HP (Health Points)</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <code class="text-xs bg-white border border-blue-200 px-2 py-0.5 rounded-md text-blue-700 font-mono">energi_sihir</code>
                                    <span class="text-sm text-gray-600">Mana Points</span>
                                </li>
                            </ul>
                        </div>

                        <div class="bg-violet-50 border border-violet-100 rounded-2xl p-5">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-2xl select-none">👾</span>
                                <span class="font-bold text-violet-800">Monster</span>
                            </div>
                            <p class="text-[11px] text-violet-500 font-bold uppercase tracking-widest mb-3">
                                Data yang dibutuhkan:
                            </p>
                            <ul class="space-y-2">
                                <li class="flex items-center gap-2.5">
                                    <code class="text-xs bg-white border border-violet-200 px-2 py-0.5 rounded-md text-violet-700 font-mono">nama</code>
                                    <span class="text-sm text-gray-600">nama karakter</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <code class="text-xs bg-white border border-violet-200 px-2 py-0.5 rounded-md text-violet-700 font-mono">nyawa</code>
                                    <span class="text-sm text-gray-600">HP (Health Points)</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <code class="text-xs bg-white border border-violet-200 px-2 py-0.5 rounded-md text-violet-700 font-mono">elemen_serangan</code>
                                    <span class="text-sm text-gray-600">Elemen serangan</span>
                                </li>
                            </ul>
                        </div>

                    </div>

                    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6 flex gap-4">
                        <div class="w-10 h-10 bg-amber-400 rounded-xl flex items-center justify-center shrink-0 mt-0.5">
                            <span class="text-white text-xl font-black leading-none">?</span>
                        </div>
                        <div class="space-y-2">
                            <p class="text-xs font-bold text-amber-700 uppercase tracking-wider">Pertanyaan Pemantik</p>
                            <p class="text-gray-700 text-base leading-relaxed">
                                Keduanya sama-sama memiliki
                                <code class="bg-amber-100 border border-amber-200 text-amber-800 font-mono text-sm px-1.5 py-0.5 rounded">nama</code>
                                dan
                                <code class="bg-amber-100 border border-amber-200 text-amber-800 font-mono text-sm px-1.5 py-0.5 rounded">nyawa</code>.
                                Jika di dalam gim tersebut terdapat
                                <strong class="text-amber-800">100 jenis Hero</strong> dan
                                <strong class="text-amber-800">500 jenis Monster</strong>,
                                apakah kamu sebagai programmer harus mengetik ulang kode untuk variabel
                                <code class="bg-amber-100 border border-amber-200 text-amber-800 font-mono text-sm px-1.5 py-0.5 rounded">nama</code>
                                dan
                                <code class="bg-amber-100 border border-amber-200 text-amber-800 font-mono text-sm px-1.5 py-0.5 rounded">nyawa</code>
                                sebanyak <strong class="text-amber-800">600 kali</strong>?
                            </p>
                        </div>
                    </div>

                    <p class="text-gray-400 italic text-sm">Pikirkan jawabanmu sebelum melanjutkan ke fase berikutnya.</p>

                </div>

                <!-- Navigation Button -->
                <div class="absolute bottom-8 right-8">
                    <!-- PENTING: JANGAN ubah ini kembali jadi <a href> biasa. Tombol ini WAJIB berupa <form method="POST"> ke route p2.fase1.complete, karena tombol inilah satu-satunya cara kolom 'p2_fase1' di database menjadi true. Kalau diubah jadi <a> biasa, middleware EnsureFaseUnlocked akan mengunci siswa dari mengakses Fase 2 Pertemuan 2 selamanya. Pola bug ini sudah terjadi berulang kali di Pertemuan 1 & 2 sebelumnya. -->
                    <form method="POST" action="{{ route('p2.fase1.complete') }}">
                        @csrf
                        <button type="submit" class="btn-pulse inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-semibold text-sm transition shadow-sm">
                            Lanjut
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </form>
                </div>
            </div>
            </div>
        </main>
    </div>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init({ once: true, duration: 600, offset: 20 });</script>
</body>
</html>
