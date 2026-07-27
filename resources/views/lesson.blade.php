<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materi Pembelajaran – OOP Learn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .materi-content { white-space: pre-line; }
    </style>
</head>

<body class="bg-gray-50">

<div class="flex min-h-screen" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">

    @include('sidebar-siswa')

    <main class="flex-1 flex flex-col overflow-hidden">

        @include('_navbar', ['navTitle' => 'Materi Pembelajaran'])

        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">

            @if(session('pretest_score'))
            <div class="mb-8">
                <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-3xl p-8 shadow-xl">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full bg-white text-green-600 flex items-center justify-center text-3xl font-bold">🎉</div>
                        <div>
                            <h2 class="text-2xl font-extrabold">Pretest Berhasil Diselesaikan</h2>
                            <p class="opacity-90">Kemampuan awal Anda telah berhasil direkam.</p>
                        </div>
                    </div>
                    <div class="mt-6 bg-white/20 rounded-2xl p-6">
                        <p class="text-lg">Nilai Pretest Anda</p>
                        <h1 class="text-6xl font-black mt-2">{{ session('pretest_score') }}</h1>
                        <p class="mt-2 text-sm opacity-90">Pelajari materi berikut untuk meningkatkan pemahaman Anda sebelum mengerjakan aktivitas pembelajaran.</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Page header --}}
            <div class="mb-6">
                <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-green-700 bg-green-50 px-3 py-1.5 rounded-full mb-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                    Modul Pembelajaran
                </span>
                <h2 class="text-xl font-bold text-gray-900 mb-1">Materi Pemrograman Berorientasi Objek</h2>
                <p class="text-sm text-gray-500">Pelajari materi berikut sebelum memulai aktivitas fase pembelajaran Needham.</p>
            </div>

            {{-- Capaian & Tujuan Pembelajaran --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center shrink-0 text-green-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Capaian &amp; Tujuan Pembelajaran</h3>
                </div>

                <div class="mb-5">
                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400 mb-2">Capaian Pembelajaran (CP)</p>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Menerapkan konsep dasar pemrograman berorientasi objek pada proyek sederhana pengembangan perangkat lunak dan gim, serta menganalisis dan memecahkan masalah dengan memanfaatkan prinsip enkapsulasi, pewarisan dan polimorfisme untuk menghasilkan solusi pemrograman yang tepat.
                    </p>
                </div>

                <div>
                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400 mb-2">Tujuan Pembelajaran (TP)</p>
                    <ol class="space-y-2">
                        @foreach([
                            'Peserta didik mampu menjelaskan definisi enkapsulasi dan fungsi access modifier (Public, private, protected) dalam pemrograman.',
                            'Peserta didik mampu mengidentifikasi perbedaan antara data yang disembunyikan (private) dan data yang dapat diakses publik.',
                            'Peserta didik mengimplementasikan metode getter setter untuk mengakses atribut yang terproteksi pada sebuah kelas sederhana.',
                        ] as $i => $tp)
                        <li class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-green-100 text-green-700 text-[10px] font-bold flex items-center justify-center shrink-0 mt-0.5">{{ $i + 1 }}</span>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $tp }}</p>
                        </li>
                        @endforeach
                    </ol>
                </div>
            </div>

            @php
            $iconColors = [
                'green'  => 'bg-green-600',
                'blue'   => 'bg-blue-500',
                'purple' => 'bg-purple-600',
                'indigo' => 'bg-indigo-600',
                'amber'  => 'bg-amber-500',
            ];
            $borderHover = [
                'green'  => 'hover:border-green-100',
                'blue'   => 'hover:border-blue-100',
                'purple' => 'hover:border-purple-100',
                'indigo' => 'hover:border-indigo-100',
                'amber'  => 'hover:border-amber-100',
            ];
            @endphp

            @forelse($materis as $materi)
            @php
                $bg  = $iconColors[$materi->color]  ?? 'bg-gray-500';
                $hov = $borderHover[$materi->color] ?? '';
            @endphp
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-4 {{ $hov }} transition-all">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 {{ $bg }} rounded-xl flex items-center justify-center text-white shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">{{ $materi->title }}</h3>
                </div>

                {{-- Video --}}
                @if($materi->embedUrl())
                <div class="mb-5 rounded-xl overflow-hidden bg-black">
                    <iframe class="w-full" style="aspect-ratio:16/9"
                            src="{{ $materi->embedUrl() }}"
                            title="{{ $materi->title }}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen></iframe>
                </div>
                @elseif($materi->video_path)
                <div class="mb-5 rounded-xl overflow-hidden bg-black">
                    <video controls class="w-full max-h-72" style="aspect-ratio:16/9">
                        <source src="{{ Storage::url($materi->video_path) }}" type="video/mp4">
                        Browser Anda tidak mendukung pemutaran video.
                    </video>
                </div>
                @else
                <div class="bg-gray-50 border border-dashed border-gray-200 rounded-xl h-48 flex flex-col items-center justify-center mb-5 text-gray-400">
                    <svg class="w-10 h-10 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z"/>
                    </svg>
                    <p class="text-sm font-medium">Video belum tersedia</p>
                </div>
                @endif

                {{-- Content --}}
                @if($materi->content)
                <div class="text-sm text-gray-600 leading-relaxed materi-content">{{ $materi->content }}</div>
                @endif
            </div>
            @empty
            <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-12 text-center text-gray-400 mb-4">
                <svg class="w-12 h-12 mx-auto mb-3 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <p class="text-sm font-medium">Materi belum tersedia.</p>
                <p class="text-xs mt-1">Guru akan segera menambahkan materi pembelajaran.</p>
            </div>
            @endforelse

            {{-- Ringkasan --}}
            @if($materis->isNotEmpty())
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
                <h3 class="text-sm font-bold text-gray-800 mb-4">Ringkasan Materi</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach([
                        ['Class','adalah blueprint untuk membuat object'],
                        ['Object','merupakan instansiasi dari class'],
                        ['Enkapsulasi','digunakan untuk melindungi data'],
                        ['Inheritance','digunakan untuk pewarisan sifat antar class'],
                    ] as [$term, $def])
                    <div class="flex items-start gap-2.5 p-3 bg-gray-50 rounded-xl">
                        <svg class="w-4 h-4 text-green-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        <p class="text-sm text-gray-600"><span class="font-semibold text-gray-800">{{ $term }}</span> {{ $def }}.</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="flex justify-end pt-4 border-t border-gray-100">
                <a href="{{ route('fase1') }}"
                   class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold text-sm px-6 py-3 rounded-xl transition active:scale-95 shadow-sm">
                    Mulai Aktivitas
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>

        </div>
    </main>

</div>

</body>
</html>
