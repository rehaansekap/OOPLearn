<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pertemuan {{ $pertemuan }} – Fase {{ $fase }} – {{ $topikNama }}</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }

        @keyframes ring-out {
            0%, 100% { box-shadow: 0 0 0 0 var(--ring-color, rgba(37,99,235,0.4)); }
            60%       { box-shadow: 0 0 0 11px transparent; }
        }
        .btn-pulse-blue   { --ring-color: rgba(37,99,235,0.4);  animation: ring-out 2s ease-in-out infinite; }
        .btn-pulse-purple { --ring-color: rgba(147,51,234,0.4); animation: ring-out 2s ease-in-out infinite; }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

<div class="flex min-h-screen" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">

    @include('sidebar-siswa')

    <main class="flex-1 flex flex-col overflow-hidden">

        @include('_navbar', ['navTitle' => 'Pertemuan ' . $pertemuan . ' – Fase ' . $fase . ' – ' . $faseNama])

        <div class="flex-1 overflow-y-auto p-8">
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8 lg:p-10 min-h-[80vh] relative">

            {{-- Phase badge + Pertemuan badge --}}
            <div class="flex items-center justify-between gap-3 mb-5 flex-wrap">
                <div class="flex items-center gap-3 flex-wrap">
                    {{-- Fase badge --}}
                    @if($warna === 'blue')
                    <span class="inline-flex items-center gap-1.5 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                    @else
                    <span class="inline-flex items-center gap-1.5 bg-purple-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                    @endif
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Fase {{ $fase }} dari 5
                    </span>
                    <span class="text-xs text-gray-400 font-medium">Model Needham Lima Fase</span>
                    {{-- Pertemuan badge --}}
                    @if($warna === 'blue')
                    <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 border border-blue-200 text-xs font-semibold px-3 py-1 rounded-full">
                    @else
                    <span class="inline-flex items-center gap-1.5 bg-purple-50 text-purple-700 border border-purple-200 text-xs font-semibold px-3 py-1 rounded-full">
                    @endif
                        Pertemuan {{ $pertemuan }} · {{ $topikNama }}
                    </span>
                </div>
            </div>

            {{-- Title --}}
            <h2 class="text-2xl font-extrabold text-gray-900 mb-1">
                {{ $faseNama }}
                @if($warna === 'blue')
                <span class="text-blue-600">— {{ $topikNama }}</span>
                @else
                <span class="text-purple-600">— {{ $topikNama }}</span>
                @endif
            </h2>
            <p class="text-sm text-gray-500 mb-10">
                Pertemuan {{ $pertemuan }} · Pemrograman Berorientasi Objek
            </p>

            {{-- Needham Phase Steps (visual indicator) --}}
            <div class="flex items-center gap-0 mb-10 overflow-x-auto pb-2">
                @php
                $faseList = [
                    1 => 'Orientasi',
                    2 => 'Pencetusan Ide',
                    3 => 'Penstrukturan',
                    4 => 'Aplikasi',
                    5 => 'Refleksi',
                ];
                $activeColor = $warna === 'blue' ? '#2563eb' : '#9333ea';
                $lightColor  = $warna === 'blue' ? '#eff6ff' : '#faf5ff';
                $textColor   = $warna === 'blue' ? '#1d4ed8' : '#7e22ce';
                @endphp
                @foreach($faseList as $num => $nama)
                <div class="flex items-center">
                    <div class="flex flex-col items-center gap-1 px-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold border-2 transition-all"
                             style="{{ $num <= $fase
                                 ? "background:{$activeColor};border-color:{$activeColor};color:white;"
                                 : 'background:white;border-color:#e5e7eb;color:#9ca3af;' }}">
                            {{ $num <= $fase ? '✓' : $num }}
                        </div>
                        <span class="text-[10px] font-medium whitespace-nowrap"
                              style="{{ $num === $fase ? "color:{$textColor};" : 'color:#9ca3af;' }}">
                            {{ $nama }}
                        </span>
                    </div>
                    @if($num < 5)
                    <div class="h-0.5 w-8 flex-shrink-0"
                         style="{{ $num < $fase ? "background:{$activeColor};" : 'background:#e5e7eb;' }}"></div>
                    @endif
                </div>
                @endforeach
            </div>

            {{-- Fase 1 Pertemuan 2 diekstrak ke resources/views/fase1-inheritance.blade.php
                 — lihat route p2.fase1 di routes/web.php --}}
            {{-- Fase 2 Pertemuan 2 diekstrak ke resources/views/fase2-inheritance.blade.php
                 (quiz interaktif) — lihat route p2.fase2 di routes/web.php --}}
            {{-- Fase 3 Pertemuan 2 diekstrak ke resources/views/fase3-inheritance.blade.php
                 (sistem block programming Inheritance) — lihat route p2.fase3 di routes/web.php --}}
            {{-- Fase 5 Pertemuan 2 diekstrak ke resources/views/fase5-inheritance.blade.php
                 (form refleksi interaktif) — lihat route p2.fase5 di routes/web.php --}}

            {{-- ═══════════════════════════════════════════════════════════
                 PERTEMUAN 3 · FASE 1 — Orientasi: Proyek Akhir
            ═══════════════════════════════════════════════════════════ --}}
            @if($pertemuan == 3 && $fase == 1)

            <div class="space-y-8 pb-20" data-aos="fade-up" data-aos-duration="550">

                {{-- Section title --}}
                <div class="flex items-start gap-4">
                    <div class="text-4xl leading-none mt-0.5 select-none">🏫</div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">
                            Studi Kasus: Sistem Manajemen Akun Sekolah
                        </h3>
                        <p class="text-sm text-purple-600 font-medium">Apersepsi · Menggabungkan Enkapsulasi & Inheritance</p>
                    </div>
                </div>

                {{-- Opening paragraph --}}
                <p class="text-gray-700 text-base leading-relaxed">
                    Kamu ditugaskan merancang <strong class="text-gray-900">pondasi keamanan</strong> untuk
                    portal web sekolah. Sistem ini akan dipakai oleh
                    <strong class="text-gray-900">Guru</strong> dan <strong class="text-gray-900">Siswa</strong>.
                    Keduanya butuh fitur login (password), tapi data profesinya berbeda.
                </p>

                {{-- Problem illustration --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-5">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-2xl select-none">👩‍🏫</span>
                            <span class="font-bold text-indigo-800">Guru</span>
                        </div>
                        <p class="text-[11px] text-indigo-500 font-bold uppercase tracking-widest mb-3">Data Khusus:</p>
                        <ul class="space-y-2">
                            <li class="flex items-center gap-2.5">
                                <code class="text-xs bg-white border border-indigo-200 px-2 py-0.5 rounded-md text-indigo-700 font-mono">mata_pelajaran</code>
                                <span class="text-sm text-gray-600">yang diajar</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <code class="text-xs bg-white border border-indigo-200 px-2 py-0.5 rounded-md text-indigo-700 font-mono">nip</code>
                                <span class="text-sm text-gray-600">nomor induk pegawai</span>
                            </li>
                        </ul>
                    </div>
                    <div class="bg-purple-50 border border-purple-100 rounded-2xl p-5">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-2xl select-none">🧑‍🎓</span>
                            <span class="font-bold text-purple-800">Siswa</span>
                        </div>
                        <p class="text-[11px] text-purple-500 font-bold uppercase tracking-widest mb-3">Data Khusus:</p>
                        <ul class="space-y-2">
                            <li class="flex items-center gap-2.5">
                                <code class="text-xs bg-white border border-purple-200 px-2 py-0.5 rounded-md text-purple-700 font-mono">kelas</code>
                                <span class="text-sm text-gray-600">kelas yang diikuti</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <code class="text-xs bg-white border border-purple-200 px-2 py-0.5 rounded-md text-purple-700 font-mono">nis</code>
                                <span class="text-sm text-gray-600">nomor induk siswa</span>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Problem statement --}}
                <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5 flex gap-4">
                    <div class="w-8 h-8 bg-gray-400 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                        <span class="text-white font-black text-base leading-none">?</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Poin Masalah</p>
                        <p class="text-gray-700 text-sm leading-relaxed">
                            Bagaimana cara membuat sistem yang kodenya <strong>efisien</strong>
                            (tidak menulis ulang fitur login), tapi
                            <strong>password</strong> setiap pengguna tetap
                            <strong>aman</strong> dan tidak bisa dibobol dari luar?
                        </p>
                    </div>
                </div>

                {{-- Clue highlight box --}}
                <div class="bg-purple-600 rounded-2xl p-5 flex gap-4">
                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center shrink-0 mt-0.5 text-lg select-none">
                        💡
                    </div>
                    <div>
                        <p class="text-xs font-bold text-purple-100 uppercase tracking-wider mb-1.5">Clue</p>
                        <p class="text-white text-sm leading-relaxed">
                            Kita butuh <strong>efisiensi dari Inheritance</strong> untuk menghindari kode berulang,
                            dan <strong>keamanan mutlak dari Enkapsulasi</strong> untuk mengunci password
                            agar tidak bisa diakses dari luar class!
                        </p>
                    </div>
                </div>

                <p class="text-gray-400 italic text-sm">Pikirkan solusinya sebelum melanjutkan ke fase berikutnya.</p>

            </div>

            {{-- Navigation --}}
            @include('partials._tombol-lanjut-fase', ['completeRoute' => 'p3.fase1.complete', 'label' => 'Selanjutnya: Fase 2 – Pencetusan Ide', 'warna' => $warna])

            {{-- ═══════════════════════════════════════════════════════════
                 PERTEMUAN 3 · FASE 2 — Pencetusan Ide: Proyek Akhir
            ═══════════════════════════════════════════════════════════ --}}
            @elseif($pertemuan == 3 && $fase == 2)

            <div class="space-y-8 pb-20" data-aos="fade-up" data-aos-duration="550">

                {{-- Section title --}}
                <div class="flex items-start gap-4">
                    <div class="text-4xl leading-none mt-0.5 select-none">💡</div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">
                            Pencetusan Ide: Merakit Fondasi Ganda
                        </h3>
                        <p class="text-sm text-purple-600 font-medium">Dua senjata OOP dalam satu sistem</p>
                    </div>
                </div>

                <p class="text-gray-700 text-base leading-relaxed">
                    Untuk memecahkan masalah ini, kita tidak bisa hanya mengandalkan satu konsep.
                    Kita perlu <strong class="text-gray-900">dua alat OOP sekaligus</strong>, masing-masing punya peran berbeda:
                </p>

                {{-- Grid 2 kolom --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                    {{-- Kiri: Enkapsulasi (Tameng Keamanan) --}}
                    <div class="bg-rose-50 border border-rose-200 rounded-2xl p-5 flex flex-col gap-3">
                        <div class="flex items-center gap-2.5">
                            <span class="text-2xl select-none">🛡️</span>
                            <span class="font-bold text-rose-800">Tameng Keamanan</span>
                        </div>
                        <p class="text-[11px] text-rose-500 font-bold uppercase tracking-widest">Enkapsulasi</p>
                        <p class="text-sm text-gray-700 leading-relaxed">
                            Gunakan <strong>Enkapsulasi</strong> untuk mengunci atribut
                            <code class="bg-rose-100 border border-rose-200 text-rose-700 font-mono text-xs px-1.5 py-0.5 rounded">__password</code>
                            di dalam brankas <span class="font-semibold text-rose-700">(private)</span>,
                            lalu buatkan pintu akses resmi berupa
                            <strong>Getter</strong> dan <strong>Setter</strong>.
                        </p>
                        <div class="bg-white border border-rose-100 rounded-xl px-4 py-3 font-mono text-xs text-gray-700 space-y-0.5 mt-auto">
                            <p><span class="text-gray-400"># dikunci rapat</span></p>
                            <p><span class="text-rose-600">self.__password</span> = <span class="text-orange-500">"****"</span></p>
                            <p class="mt-1"><span class="text-gray-400"># pintu resmi</span></p>
                            <p><span class="text-purple-600">def</span> <span class="text-blue-600">get_password</span>(self):</p>
                            <p class="ml-4">...</p>
                        </div>
                    </div>

                    {{-- Kanan: Inheritance (Pohon Silsilah) --}}
                    <div class="bg-green-50 border border-green-200 rounded-2xl p-5 flex flex-col gap-3">
                        <div class="flex items-center gap-2.5">
                            <span class="text-2xl select-none">🌳</span>
                            <span class="font-bold text-green-800">Pohon Silsilah</span>
                        </div>
                        <p class="text-[11px] text-green-500 font-bold uppercase tracking-widest">Inheritance</p>
                        <p class="text-sm text-gray-700 leading-relaxed">
                            Gunakan <strong>Inheritance</strong> dengan membuat class induk
                            <code class="bg-green-100 border border-green-200 text-green-700 font-mono text-xs px-1.5 py-0.5 rounded">AkunSekolah</code>,
                            lalu wariskan "brankas" tadi ke class anak
                            <code class="bg-green-100 border border-green-200 text-green-700 font-mono text-xs px-1.5 py-0.5 rounded">Guru</code>
                            dan
                            <code class="bg-green-100 border border-green-200 text-green-700 font-mono text-xs px-1.5 py-0.5 rounded">Siswa</code>.
                        </p>
                        <div class="flex flex-col items-center gap-1.5 mt-auto py-1">
                            <div class="w-full bg-white border-2 border-green-400 rounded-xl px-4 py-2 text-center">
                                <p class="font-mono text-xs font-bold text-green-700">AkunSekolah</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">nama, __password</p>
                            </div>
                            <div class="flex gap-6">
                                <div class="flex flex-col items-center"><div class="w-px h-4 bg-green-400"></div><svg class="w-2.5 h-2.5 text-green-500" viewBox="0 0 10 10" fill="currentColor"><path d="M5 10L0 3h10z"/></svg></div>
                                <div class="flex flex-col items-center"><div class="w-px h-4 bg-green-400"></div><svg class="w-2.5 h-2.5 text-green-500" viewBox="0 0 10 10" fill="currentColor"><path d="M5 10L0 3h10z"/></svg></div>
                            </div>
                            <div class="flex gap-3 w-full">
                                <div class="flex-1 bg-white border border-green-300 rounded-xl px-2 py-2 text-center">
                                    <p class="font-mono text-[11px] font-bold text-indigo-700">Guru</p>
                                    <p class="text-[9px] text-gray-400">+ mata_pelajaran</p>
                                </div>
                                <div class="flex-1 bg-white border border-green-300 rounded-xl px-2 py-2 text-center">
                                    <p class="font-mono text-[11px] font-bold text-purple-700">Siswa</p>
                                    <p class="text-[9px] text-gray-400">+ kelas</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Kesimpulan --}}
                <div class="bg-purple-50 border border-purple-200 rounded-2xl p-5 flex gap-4">
                    <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        Dengan menggabungkan keduanya, kita mendapat sistem yang
                        <strong class="text-purple-700">tidak membuang-buang kode</strong> (Inheritance)
                        sekaligus <strong class="text-rose-700">tidak bisa ditembus dari luar</strong> (Enkapsulasi).
                        Inilah fondasi sistem keamanan profesional.
                    </p>
                </div>

            </div>

            {{-- Navigation --}}
            @include('partials._tombol-lanjut-fase', ['completeRoute' => 'p3.fase2.complete', 'label' => 'Selanjutnya: Fase 3 – Penstrukturan Ide', 'warna' => $warna])

            {{-- Fase 3 Pertemuan 3 diekstrak ke resources/views/fase3-gabungan.blade.php
                 (sistem block programming Gabungan Enkapsulasi+Inheritance) — lihat route p3.fase3 di routes/web.php --}}

            {{-- ═══════════════════════════════════════════════════════════
                 PERTEMUAN 3 · FASE 5 — Refleksi: Proyek Akhir
            ═══════════════════════════════════════════════════════════ --}}
            @elseif($pertemuan == 3 && $fase == 5)

            <div class="space-y-8 pb-20" data-aos="fade-up" data-aos-duration="550">

                {{-- Section title --}}
                <div class="flex items-start gap-4">
                    <div class="text-4xl leading-none mt-0.5 select-none">🏆</div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">
                            Refleksi: Kamu Sudah Menjadi Programmer PBO!
                        </h3>
                        <p class="text-sm text-purple-600 font-medium">Evaluasi akhir · Pencapaianmu selama ini</p>
                    </div>
                </div>

                {{-- Ucapan selamat --}}
                <div class="bg-gradient-to-r from-purple-50 to-indigo-50 border border-purple-100 rounded-2xl p-6 text-center">
                    <p class="text-4xl mb-3 select-none">🎉</p>
                    <p class="text-lg font-bold text-gray-900 mb-2">Selamat, kamu telah menyelesaikan semua materi!</p>
                    <p class="text-sm text-gray-600 leading-relaxed max-w-md mx-auto">
                        Kamu berhasil mempelajari dan mempraktikkan dua pilar utama OOP —
                        Enkapsulasi dan Inheritance — lalu menggabungkannya dalam satu proyek nyata.
                    </p>
                </div>

                {{-- Checklist keberhasilan --}}
                <div class="space-y-3">

                    <div class="bg-green-50 border border-green-200 rounded-2xl p-5 flex gap-4">
                        <div class="w-8 h-8 bg-green-500 rounded-xl flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-green-800 mb-1">
                                Mampu mengamankan data rahasia
                                <span class="font-mono text-xs bg-green-100 border border-green-300 px-1.5 py-0.5 rounded text-green-700">Enkapsulasi</span>
                            </p>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                Kamu tahu cara mengunci atribut dengan
                                <code class="bg-gray-100 text-gray-700 font-mono text-xs px-1 rounded">private</code>
                                dan membuat akses terkontrol lewat Getter & Setter.
                                Password tidak bisa dibobol sembarangan.
                            </p>
                        </div>
                    </div>

                    <div class="bg-green-50 border border-green-200 rounded-2xl p-5 flex gap-4">
                        <div class="w-8 h-8 bg-green-500 rounded-xl flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-green-800 mb-1">
                                Mampu mendesain hierarki class yang efisien
                                <span class="font-mono text-xs bg-green-100 border border-green-300 px-1.5 py-0.5 rounded text-green-700">Inheritance</span>
                            </p>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                Kamu bisa membuat class induk yang mewariskan properti ke banyak class anak,
                                menghindari penulisan kode yang berulang.
                            </p>
                        </div>
                    </div>

                    <div class="bg-green-50 border border-green-200 rounded-2xl p-5 flex gap-4">
                        <div class="w-8 h-8 bg-green-500 rounded-xl flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-green-800 mb-1">
                                Mampu menggabungkan keduanya dalam sistem nyata
                                <span class="font-mono text-xs bg-green-100 border border-green-300 px-1.5 py-0.5 rounded text-green-700">Proyek Akhir</span>
                            </p>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                Kamu merancang sistem akun sekolah yang efisien sekaligus aman —
                                bukti nyata bahwa kamu sudah berpikir seperti programmer profesional.
                            </p>
                        </div>
                    </div>

                </div>

                {{-- Penutup --}}
                <div class="bg-gray-50 border border-gray-100 rounded-2xl p-6 text-center">
                    <p class="text-gray-700 font-semibold mb-1">Semua materi Pemrograman Berorientasi Objek selesai!</p>
                    <p class="text-gray-500 text-sm">Kembali ke dashboard untuk melihat progres belajarmu.</p>
                </div>

            </div>

            {{-- Navigation --}}
            <div class="absolute bottom-8 right-8">
                <form method="POST" action="{{ route('p3.fase5.complete') }}">
                    @csrf
                    <button type="submit"
                            class="btn-pulse-purple inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-6 py-2.5 rounded-xl font-semibold text-sm transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                        </svg>
                        Selesai · Kembali ke Dashboard
                    </button>
                </form>
            </div>

            {{-- ═══════════════════════════════════════════════════════════
                 SEMUA HALAMAN LAIN — placeholder "Segera Hadir"
            ═══════════════════════════════════════════════════════════ --}}
            @else

            <div class="flex flex-col items-center justify-center py-16 text-center">

                @if($warna === 'blue')
                <div class="w-24 h-24 rounded-3xl bg-blue-50 flex items-center justify-center mb-8 shadow-sm">
                    <svg class="w-12 h-12 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/>
                    </svg>
                </div>
                @else
                <div class="w-24 h-24 rounded-3xl bg-purple-50 flex items-center justify-center mb-8 shadow-sm">
                    <svg class="w-12 h-12 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z"/>
                    </svg>
                </div>
                @endif

                <h3 class="text-xl font-bold text-gray-700 mb-3">Konten Segera Hadir</h3>
                <p class="text-gray-500 text-sm max-w-md leading-relaxed mb-2">
                    Materi untuk <strong>Pertemuan {{ $pertemuan }}</strong> ·
                    <strong>Fase {{ $fase }} — {{ $faseNama }}</strong>
                    sedang dalam tahap pengembangan.
                </p>
                <p class="text-gray-400 text-xs mb-8">
                    Topik: <span class="font-semibold" style="color:{{ $warnaHex }};">{{ $topikNama }}</span>
                    · Model Needham Lima Fase
                </p>

                <div class="bg-gray-50 border border-gray-100 rounded-2xl p-6 max-w-md text-left space-y-3 mb-8">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">
                        Yang akan dipelajari di fase ini:
                    </p>
                    @php
                    $descriptions = [
                        1 => [
                            'Mengenal konsep ' . $topikNama . ' dalam OOP',
                            'Identifikasi permasalahan dalam kode',
                            'Memahami mengapa ' . $topikNama . ' diperlukan',
                        ],
                        2 => [
                            'Eksplorasi ide tentang ' . $topikNama,
                            'Quiz interaktif untuk mengukur pemahaman awal',
                            'Menghubungkan konsep dengan dunia nyata',
                        ],
                        3 => [
                            'Menyusun struktur kode ' . $topikNama,
                            'Block programming untuk ' . $topikNama,
                            'Membangun pemahaman yang terstruktur',
                        ],
                        4 => [
                            'Menulis kode ' . $topikNama . ' dengan Blockly',
                            'Praktik implementasi dalam konteks nyata',
                            'Uji coba dan debug kode',
                        ],
                        5 => [
                            'Refleksi pemahaman tentang ' . $topikNama,
                            'Evaluasi hasil pembelajaran',
                            'Menjawab pertanyaan reflektif',
                        ],
                    ];
                    @endphp
                    @foreach($descriptions[$fase] as $point)
                    <div class="flex items-start gap-2.5">
                        <span class="w-4 h-4 rounded-full flex-shrink-0 flex items-center justify-center mt-0.5"
                              style="background:{{ $warnaHex }}1a;">
                            <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="{{ $warnaHex }}" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                        </span>
                        <span class="text-sm text-gray-600">{{ $point }}</span>
                    </div>
                    @endforeach
                </div>

                <a href="{{ route('dashboard.siswa') }}"
                   class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-xl text-sm font-semibold transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>

            @endif

        </div>
        </div>
    </main>

</div>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init({ once: true, duration: 550, offset: 20 });</script>
</body>
</html>
