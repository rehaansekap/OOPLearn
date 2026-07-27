<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assessment – OOP Learn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-gray-50">

<div class="flex min-h-screen" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">

    @include('sidebar-siswa')

    <main class="flex-1 flex flex-col overflow-hidden min-w-0">

        @include('_navbar', ['navTitle' => 'Assessment'])

        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">

            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-1">Tes Kemampuan</h2>
                <p class="text-sm text-gray-500">
                    Kerjakan pretest sebelum belajar dan posttest setelah menyelesaikan semua fase pembelajaran.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Pretest Card --}}
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden flex flex-col">

                    {{-- Gradient Header --}}
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 px-6 py-5 flex items-start gap-4">
                        <div class="shrink-0 w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-white">Pretest</h3>
                            <p class="text-sm text-blue-100 mt-0.5">Tes kemampuan awal sebelum pembelajaran</p>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="p-5 flex flex-col flex-1 gap-4">
                        <ul class="space-y-2.5">
                            <li class="flex items-start gap-2.5 text-sm text-gray-600">
                                <span class="shrink-0 mt-0.5 w-4 h-4 rounded-full bg-blue-500 flex items-center justify-center">
                                    <svg class="w-2.5 h-2.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </span>
                                Dikerjakan sebelum memulai materi pembelajaran
                            </li>
                            <li class="flex items-start gap-2.5 text-sm text-gray-600">
                                <span class="shrink-0 mt-0.5 w-4 h-4 rounded-full bg-blue-500 flex items-center justify-center">
                                    <svg class="w-2.5 h-2.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </span>
                                Jawab setiap pertanyaan dengan jujur
                            </li>
                            <li class="flex items-start gap-2.5 text-sm text-gray-600">
                                <span class="shrink-0 mt-0.5 w-4 h-4 rounded-full bg-blue-500 flex items-center justify-center">
                                    <svg class="w-2.5 h-2.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </span>
                                Hasil digunakan untuk mengukur perkembangan belajar
                            </li>
                        </ul>

                        <div class="mt-auto">
                            @if(auth()->user()->score?->pretest !== null)
                                <div class="flex items-center justify-between px-4 py-3 bg-blue-50 rounded-lg border border-blue-100">
                                    <p class="text-sm text-blue-700 font-medium">Sudah dikerjakan</p>
                                    <p class="text-xl font-bold text-blue-800">{{ auth()->user()->score->pretest }}</p>
                                </div>
                            @else
                                <a href="{{ route('pretest') }}"
                                   class="flex items-center justify-center w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm py-2.5 rounded-lg transition">
                                    Mulai Pretest →
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Posttest Card --}}
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden flex flex-col">

                    {{-- Gradient Header --}}
                    <div class="bg-gradient-to-br from-green-500 to-green-600 px-6 py-5 flex items-start gap-4">
                        <div class="shrink-0 w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-white">Posttest</h3>
                            <p class="text-sm text-green-100 mt-0.5">Tes kemampuan akhir setelah pembelajaran</p>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="p-5 flex flex-col flex-1 gap-4">
                        <ul class="space-y-2.5">
                            <li class="flex items-start gap-2.5 text-sm text-gray-600">
                                <span class="shrink-0 mt-0.5 w-4 h-4 rounded-full bg-green-500 flex items-center justify-center">
                                    <svg class="w-2.5 h-2.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </span>
                                Dikerjakan setelah menyelesaikan semua fase
                            </li>
                            <li class="flex items-start gap-2.5 text-sm text-gray-600">
                                <span class="shrink-0 mt-0.5 w-4 h-4 rounded-full bg-green-500 flex items-center justify-center">
                                    <svg class="w-2.5 h-2.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </span>
                                Mengukur peningkatan pemahaman OOP
                            </li>
                        </ul>

                        <div class="mt-auto">
                            @if(auth()->user()->score?->posttest !== null)
                                <div class="flex items-center justify-between px-4 py-3 bg-green-50 rounded-lg border border-green-100">
                                    <p class="text-sm text-green-700 font-medium">Sudah dikerjakan</p>
                                    <p class="text-xl font-bold text-green-800">{{ auth()->user()->score->posttest }}</p>
                                </div>
                            @else
                                <a href="{{ route('posttest') }}"
                                   class="flex items-center justify-center w-full bg-green-600 hover:bg-green-700 text-white font-semibold text-sm py-2.5 rounded-lg transition">
                                    Mulai Posttest →
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            {{-- Info Box --}}
            <div class="mt-5 bg-amber-50 border border-amber-200 rounded-lg px-4 py-4">
                <p class="text-sm font-semibold text-amber-800 mb-1">Petunjuk Penting</p>
                <p class="text-xs text-amber-700 leading-relaxed">
                    Kerjakan pretest terlebih dahulu sebelum memulai materi pembelajaran. Posttest hanya dapat dikerjakan setelah seluruh fase pembelajaran selesai.
                </p>
            </div>

        </div>
    </main>
</div>

</body>
</html>
