<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OOP Learn – Media Pembelajaran Enkapsulasi &amp; Inheritance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        html { scroll-behavior: smooth; }
    </style>
</head>

<body class="bg-white text-gray-900 antialiased">

    {{-- ── NAVBAR ── --}}
    <nav class="fixed top-0 w-full bg-white/95 backdrop-blur-sm border-b border-gray-100 z-50">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">

            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-green-600 flex items-center justify-center shrink-0">
                    <svg class="w-4.5 h-4.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <span class="font-bold text-gray-900 text-sm leading-none block">OOP Learn</span>
                    <span class="text-[10px] text-gray-400 font-medium leading-none">Media Pembelajaran</span>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-8">
                <a href="#fitur" class="text-sm text-gray-500 hover:text-gray-900 font-medium transition">Fitur</a>
                <a href="#fase" class="text-sm text-gray-500 hover:text-gray-900 font-medium transition">Tahapan</a>
                <a href="#tentang" class="text-sm text-gray-500 hover:text-gray-900 font-medium transition">Tentang</a>
            </div>

            <a href="{{ route('login') }}"
               class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition active:scale-95">
                Masuk
            </a>

        </div>
    </nav>

    {{-- ── HERO ── --}}
    <section class="pt-28 pb-20 bg-gradient-to-b from-green-50/70 via-green-50/30 to-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-16 items-center">

                {{-- Kiri --}}
                <div>
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-green-700 bg-green-100 px-3 py-1.5 rounded-full mb-6">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                        Model Pembelajaran Needham Lima Fase
                    </span>

                    <h1 class="text-4xl lg:text-[2.75rem] font-black leading-tight text-gray-900 mb-5">
                        Kuasai Konsep <span class="text-green-600">OOP</span> dengan Cara yang Lebih Efektif
                    </h1>

                    <p class="text-base text-gray-500 leading-relaxed mb-8 max-w-lg">
                        Platform pembelajaran interaktif untuk memahami <strong class="text-gray-700">Enkapsulasi</strong>
                        dan <strong class="text-gray-700">Inheritance</strong> — dilengkapi visualisasi, latihan, kuis,
                        dan refleksi terstruktur untuk siswa SMK.
                    </p>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('login') }}"
                           class="bg-green-600 hover:bg-green-700 text-white font-semibold text-sm px-6 py-3 rounded-xl transition active:scale-95 shadow-sm shadow-green-200">
                            Mulai Belajar Sekarang
                        </a>
                        <a href="#fitur"
                           class="text-gray-700 font-semibold text-sm px-6 py-3 rounded-xl border border-gray-200 hover:bg-gray-50 hover:border-gray-300 transition">
                            Lihat Fitur
                        </a>
                    </div>

                    {{-- Stats row --}}
                    <div class="flex items-center gap-6 mt-10 pt-8 border-t border-gray-100">
                        <div>
                            <p class="text-2xl font-black text-gray-900">5</p>
                            <p class="text-xs text-gray-500 font-medium">Fase Pembelajaran</p>
                        </div>
                        <div class="w-px h-8 bg-gray-200"></div>
                        <div>
                            <p class="text-2xl font-black text-gray-900">2</p>
                            <p class="text-xs text-gray-500 font-medium">Topik Utama OOP</p>
                        </div>
                        <div class="w-px h-8 bg-gray-200"></div>
                        <div>
                            <p class="text-2xl font-black text-gray-900">2</p>
                            <p class="text-xs text-gray-500 font-medium">Role Pengguna</p>
                        </div>
                    </div>
                </div>

                {{-- Kanan: Ilustrasi / Preview card --}}
                <div class="relative">
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl p-6 space-y-4">

                        {{-- Mock sidebar + content preview --}}
                        <div class="flex gap-4">
                            {{-- Sidebar mock --}}
                            <div class="w-28 shrink-0 space-y-2">
                                <div class="h-6 bg-green-100 rounded-lg"></div>
                                <div class="h-6 bg-gray-100 rounded-lg"></div>
                                <div class="h-6 bg-gray-100 rounded-lg"></div>
                                <div class="h-6 bg-gray-100 rounded-lg"></div>
                                <div class="h-6 bg-gray-100 rounded-lg"></div>
                            </div>
                            {{-- Content mock --}}
                            <div class="flex-1 space-y-3">
                                <div class="h-3 bg-gray-200 rounded-full w-3/4"></div>
                                <div class="h-3 bg-gray-100 rounded-full w-full"></div>
                                <div class="h-3 bg-gray-100 rounded-full w-5/6"></div>
                                {{-- Phase grid mock --}}
                                <div class="grid grid-cols-3 gap-2 pt-2">
                                    <div class="h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <div class="h-12 bg-green-500 rounded-xl flex items-center justify-center">
                                        <span class="text-white text-xs font-bold">2</span>
                                    </div>
                                    <div class="h-12 bg-gray-100 rounded-xl"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Progress bar mock --}}
                        <div class="pt-2">
                            <div class="flex justify-between text-xs text-gray-500 mb-1.5">
                                <span class="font-medium">Progress Belajar</span>
                                <span class="font-bold text-green-600">40%</span>
                            </div>
                            <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full w-2/5 bg-green-500 rounded-full"></div>
                            </div>
                        </div>

                    </div>

                    {{-- Floating badge --}}
                    <div class="absolute -top-4 -right-4 bg-white border border-gray-100 shadow-lg rounded-2xl px-4 py-3">
                        <p class="text-xs text-gray-500 font-medium">Nilai Pretest</p>
                        <p class="text-2xl font-black text-gray-900">75</p>
                    </div>
                    <div class="absolute -bottom-4 -left-4 bg-green-600 shadow-lg rounded-2xl px-4 py-3">
                        <p class="text-xs text-green-200 font-medium">Posttest</p>
                        <p class="text-2xl font-black text-white">92</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ── FITUR ── --}}
    <section id="fitur" class="py-24 bg-white">
        <div class="max-w-6xl mx-auto px-6">

            <div class="text-center mb-16">
                <span class="text-xs font-semibold text-green-600 uppercase tracking-widest">Fitur Unggulan</span>
                <h2 class="text-3xl font-black text-gray-900 mt-3 mb-4">Semua yang Kamu Butuhkan</h2>
                <p class="text-gray-500 max-w-lg mx-auto">Dirancang untuk pengalaman belajar yang terstruktur, terukur, dan menyenangkan.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">

                <div class="group p-7 rounded-2xl border border-gray-100 hover:border-green-200 hover:shadow-md transition bg-white">
                    <div class="w-11 h-11 rounded-xl bg-green-50 group-hover:bg-green-100 flex items-center justify-center mb-5 transition">
                        <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-base mb-2">Video Pembelajaran</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Materi Enkapsulasi dan Inheritance dijelaskan melalui video yang ringkas dan mudah dipahami.</p>
                </div>

                <div class="group p-7 rounded-2xl border border-gray-100 hover:border-blue-200 hover:shadow-md transition bg-white">
                    <div class="w-11 h-11 rounded-xl bg-blue-50 group-hover:bg-blue-100 flex items-center justify-center mb-5 transition">
                        <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-base mb-2">Visualisasi Interaktif</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Membantu siswa memahami hubungan antar class, objek, dan pewarisan melalui diagram visual.</p>
                </div>

                <div class="group p-7 rounded-2xl border border-gray-100 hover:border-purple-200 hover:shadow-md transition bg-white">
                    <div class="w-11 h-11 rounded-xl bg-purple-50 group-hover:bg-purple-100 flex items-center justify-center mb-5 transition">
                        <svg class="w-5 h-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-base mb-2">Pretest & Posttest</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Evaluasi kemampuan awal dan akhir untuk mengukur peningkatan pemahamanmu.</p>
                </div>

                <div class="group p-7 rounded-2xl border border-gray-100 hover:border-amber-200 hover:shadow-md transition bg-white">
                    <div class="w-11 h-11 rounded-xl bg-amber-50 group-hover:bg-amber-100 flex items-center justify-center mb-5 transition">
                        <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-base mb-2">Fase Aktivitas Needham</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Lima fase pembelajaran: Orientasi, Pencetusan Ide, Penstrukturan, Aplikasi, dan Refleksi.</p>
                </div>

                <div class="group p-7 rounded-2xl border border-gray-100 hover:border-teal-200 hover:shadow-md transition bg-white">
                    <div class="w-11 h-11 rounded-xl bg-teal-50 group-hover:bg-teal-100 flex items-center justify-center mb-5 transition">
                        <svg class="w-5 h-5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-base mb-2">Dashboard Guru</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Guru dapat memantau progress, nilai, dan aktivitas seluruh siswa dari satu tempat.</p>
                </div>

                <div class="group p-7 rounded-2xl border border-gray-100 hover:border-rose-200 hover:shadow-md transition bg-white">
                    <div class="w-11 h-11 rounded-xl bg-rose-50 group-hover:bg-rose-100 flex items-center justify-center mb-5 transition">
                        <svg class="w-5 h-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-base mb-2">Refleksi & Simpulan</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Siswa menuliskan refleksi pembelajaran untuk memperkuat pemahaman konsep OOP.</p>
                </div>

            </div>

            {{-- ── Cara Penggunaan ── --}}
            <div class="max-w-2xl mx-auto mt-16 bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Cara Penggunaan Sistem</h3>
                </div>

                <ol class="space-y-3">
                    @foreach([
                        ['Kerjakan Pretest terlebih dahulu melalui menu Assessment untuk mengukur pengetahuan awal sebelum pembelajaran.', 'Assessment'],
                        ['Ikuti Activity Model Needham untuk Pertemuan 1–3 secara berurutan: Fase 1 Orientasi, Fase 2 Pencetusan Ide, Fase 3 Penstrukturan (materi pembelajaran tersedia di sini), Fase 4 Aplikasi, dan Fase 5 Refleksi.', 'Activity'],
                        ['Setelah menyelesaikan semua pertemuan, kerjakan Posttest melalui menu Assessment.', 'Assessment'],
                        ['Pantau perkembangan nilaimu melalui menu Hasil Belajar.', 'Hasil Belajar'],
                    ] as $i => [$step, $menu])
                    <li class="flex items-start gap-3">
                        <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 text-[11px] font-bold flex items-center justify-center shrink-0 mt-0.5">{{ $i + 1 }}</span>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            {{ $step }}
                            <span class="inline-block ml-1 text-[10px] font-semibold text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded-md">{{ $menu }}</span>
                        </p>
                    </li>
                    @endforeach
                </ol>
            </div>

        </div>
    </section>

    {{-- ── FASE PEMBELAJARAN ── --}}
    <section id="fase" class="py-24 bg-gray-50/70">
        <div class="max-w-6xl mx-auto px-6">

            <div class="text-center mb-16">
                <span class="text-xs font-semibold text-green-600 uppercase tracking-widest">Alur Belajar</span>
                <h2 class="text-3xl font-black text-gray-900 mt-3 mb-4">Lima Fase Pembelajaran Needham</h2>
                <p class="text-gray-500 max-w-lg mx-auto">Setiap siswa melewati lima tahap yang dirancang untuk membangun pemahaman konsep secara bertahap.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-5 gap-4">
                @foreach([
                    ['1','Orientasi','Identifikasi pengetahuan awal dan konsep dasar OOP','bg-green-100 text-green-700'],
                    ['2','Pencetusan Ide','Eksplorasi konsep baru melalui diskusi dan observasi','bg-blue-100 text-blue-700'],
                    ['3','Penstrukturan Ide','Menyusun dan membangun pemahaman konsep secara sistematis','bg-purple-100 text-purple-700'],
                    ['4','Aplikasi Ide','Menerapkan konsep dalam latihan coding menggunakan Blockly','bg-amber-100 text-amber-700'],
                    ['5','Refleksi','Mengevaluasi dan menyimpulkan hasil pembelajaran','bg-rose-100 text-rose-700'],
                ] as [$n, $t, $d, $c])
                <div class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col gap-3 hover:shadow-sm transition">
                    <span class="inline-flex w-9 h-9 rounded-xl {{ $c }} items-center justify-center text-sm font-black shrink-0">{{ $n }}</span>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Fase {{ $n }}</p>
                        <h4 class="font-bold text-gray-800 text-sm mb-2">{{ $t }}</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">{{ $d }}</p>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ── TENTANG ── --}}
    <section id="tentang" class="py-24 bg-white">
        <div class="max-w-3xl mx-auto px-6 text-center">
            <span class="text-xs font-semibold text-green-600 uppercase tracking-widest">Tentang</span>
            <h2 class="text-3xl font-black text-gray-900 mt-3 mb-6">Media Pembelajaran OOP</h2>
            <p class="text-base text-gray-500 leading-relaxed mb-8">
                Media pembelajaran ini dikembangkan sebagai penelitian skripsi untuk membantu peserta didik SMK memahami
                konsep <strong class="text-gray-700">Enkapsulasi</strong> dan <strong class="text-gray-700">Inheritance</strong>
                pada mata pelajaran Pemrograman Berorientasi Objek melalui pendekatan pembelajaran interaktif berbasis model Needham Lima Fase.
            </p>

            <div class="inline-flex items-center gap-3 bg-green-50 border border-green-100 px-6 py-4 rounded-2xl">
                <div class="w-10 h-10 rounded-xl bg-green-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div class="text-left">
                    <p class="font-bold text-gray-800 text-sm">OOP Learn</p>
                    <p class="text-xs text-gray-500">Enkapsulasi &amp; Inheritance — Model Needham Lima Fase</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ── CTA BOTTOM ── --}}
    <section class="py-20 bg-green-600">
        <div class="max-w-2xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-black text-white mb-4">Siap Mulai Belajar?</h2>
            <p class="text-green-100 mb-8">Masuk ke platform dan mulai perjalanan belajar OOP-mu sekarang.</p>
            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-2 bg-white text-green-700 font-bold px-8 py-3.5 rounded-xl hover:bg-green-50 transition active:scale-95 shadow-lg shadow-green-800/20">
                Masuk ke Platform
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>
    </section>

    {{-- ── FOOTER ── --}}
    <footer class="bg-gray-900 text-gray-400">
        <div class="max-w-6xl mx-auto px-6 py-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <div class="w-6 h-6 rounded-md bg-green-600 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <span class="text-sm font-semibold text-gray-300">OOP Learn</span>
            </div>
            <p class="text-xs text-center">© 2025 Media Pembelajaran Enkapsulasi dan Inheritance. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
