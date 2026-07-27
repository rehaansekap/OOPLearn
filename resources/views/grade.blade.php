<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Belajar – OOP Learn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-gray-50">

<div class="flex min-h-screen" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">

    @include('sidebar-siswa')

    <main class="flex-1 flex flex-col overflow-hidden min-w-0">

        @include('_navbar', ['navTitle' => 'Hasil Belajar'])

        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">

            @if(session('success'))
                <div class="mb-5 text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            @php
                $score    = auth()->user()->score;
                $pretest  = $score?->pretest  ?? null;
                $posttest = $score?->posttest ?? null;
                $gain     = ($pretest !== null && $posttest !== null) ? ($posttest - $pretest) : null;
            @endphp

            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-1">Rekap Hasil Belajar</h2>
                <p class="text-sm text-gray-500">Ringkasan nilai pretest, posttest, dan peningkatan pemahamanmu.</p>
            </div>

            {{-- Score Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">

                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Pretest</p>
                    @if($pretest !== null)
                        <p class="text-5xl font-black text-blue-600 leading-none">{{ $pretest }}</p>
                        <div class="mt-3">
                            <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-blue-400 rounded-full" style="width: {{ $pretest }}%"></div>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">{{ $pretest }} / 100</p>
                        </div>
                    @else
                        <p class="text-4xl font-black text-gray-200 leading-none">–</p>
                        <p class="text-xs text-gray-400 mt-2">Belum dikerjakan</p>
                    @endif
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Posttest</p>
                    @if($posttest !== null)
                        <p class="text-5xl font-black text-green-600 leading-none">{{ $posttest }}</p>
                        <div class="mt-3">
                            <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-green-500 rounded-full" style="width: {{ $posttest }}%"></div>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">{{ $posttest }} / 100</p>
                        </div>
                    @else
                        <p class="text-4xl font-black text-gray-200 leading-none">–</p>
                        <p class="text-xs text-gray-400 mt-2">Belum dikerjakan</p>
                    @endif
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Selisih Nilai</p>
                    @if($gain !== null)
                        <p class="text-5xl font-black leading-none {{ $gain >= 0 ? 'text-green-600' : 'text-red-500' }}">
                            {{ $gain >= 0 ? '+' : '' }}{{ $gain }}
                        </p>
                        <p class="text-xs text-gray-400 mt-3">Poin dari pretest ke posttest</p>
                    @else
                        <p class="text-4xl font-black text-gray-200 leading-none">–</p>
                        <p class="text-xs text-gray-400 mt-2">Data belum lengkap</p>
                    @endif
                </div>

            </div>

            <a href="{{ route('dashboard.siswa') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-900 bg-white border border-gray-200 px-5 py-2.5 rounded-lg hover:border-gray-300 transition">
                ← Kembali ke Dashboard
            </a>

        </div>
    </main>
</div>

</body>
</html>
