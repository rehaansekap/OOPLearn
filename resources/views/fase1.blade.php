<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fase 1 - Orientasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        @keyframes ring-out {
            0%, 100% { box-shadow: 0 0 0 0 rgba(22,163,74,0.45); }
            60%       { box-shadow: 0 0 0 11px transparent; }
        }
        .btn-pulse { animation: ring-out 2s ease-in-out infinite; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="flex min-h-screen" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">
        @include('sidebar-siswa')

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden">

            @include('_navbar', ['navTitle' => 'Fase 1 – Orientasi'])
            <div class="flex-1 overflow-y-auto p-8">

            <!-- Content Card -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8 lg:p-10 min-h-[80vh] relative">
                {{-- Phase badge --}}
                <div class="flex items-center gap-3 mb-5">
                    <span class="inline-flex items-center gap-1.5 bg-green-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Fase 1 dari 5
                    </span>
                    <span class="text-xs text-gray-400 font-medium">Model Needham Lima Fase</span>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900 mb-1">Orientasi</h2>
                <p class="text-sm text-gray-500 mb-5">Permasalahan Keamanan Data</p>

                @include('_needham-stepper', ['currentFase' => 1])

                {{-- Tujuan Pembelajaran --}}
                <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5 mb-6 flex gap-4">
                    <div class="shrink-0 w-9 h-9 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wide text-blue-700 mb-2">Tujuan Pembelajaran</p>
                        <ul class="space-y-1 text-sm text-blue-900">
                            <li class="flex gap-2"><span class="text-blue-400 font-bold shrink-0">✓</span> Mengidentifikasi masalah keamanan data akibat akses langsung ke atribut class</li>
                            <li class="flex gap-2"><span class="text-blue-400 font-bold shrink-0">✓</span> Menyadari perlunya proteksi data dalam pemrograman berorientasi objek</li>
                        </ul>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
                    <!-- Left Column: Problem Description -->
                    <div class="space-y-6" data-aos="fade-up" data-aos-delay="100">
                        <p class="text-lg font-medium">Perhatikan ilustrasi berikut:</p>

                        <!-- Code Block -->
                        <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 font-mono text-xl shadow-inner">
                            <p class="text-gray-800">akun1 = new BankAccount();</p>
                            <p class="text-gray-800">akun1.saldo = <span class="text-red-600 font-bold">-1000</span>;</p>
                        </div>

                        <!-- Question Box -->
                        <div class="bg-orange-50 border-l-4 border-orange-400 p-5 rounded-r-2xl flex gap-4">
                            <div class="bg-orange-400 text-white rounded-full w-6 h-6 flex items-center justify-center shrink-0 mt-1 font-bold">!</div>
                            <div>
                                <p class="font-bold text-orange-800">Mengapa saldo bisa berubah menjadi -1000?</p>
                                <p class="font-bold text-orange-800">Apa yang salah dengan program di atas?</p>
                            </div>
                        </div>

                        <p class="text-gray-500 italic mt-8 font-medium">Pikirkan jawabanmu sebelum melanjutkan ke fase berikutnya.</p>
                    </div>

                    <!-- Right Column: Illustration -->
                    <div class="flex justify-center items-start pt-4" data-aos="fade-up" data-aos-delay="250">
                        <div class="relative w-full max-w-sm">
                            <!-- Alert bubble -->
                            <div class="absolute -top-8 right-0 bg-white px-4 py-2.5 rounded-2xl shadow-lg border border-red-100 flex items-center gap-2 z-10">
                                <span class="text-2xl">❗</span>
                                <div class="text-xs font-black text-red-600 uppercase tracking-tight leading-tight">Saldo Berubah!<br>-1000</div>
                            </div>
                            <!-- Inline illustration: computer with warning -->
                            <svg viewBox="0 0 320 260" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
                                <rect x="30" y="30" width="260" height="175" rx="12" fill="#1e293b"/>
                                <rect x="42" y="42" width="236" height="151" rx="7" fill="#0f172a"/>
                                <!-- Code lines -->
                                <rect x="56" y="58"  width="50"  height="6" rx="3" fill="#ff7a8a"/>
                                <rect x="112" y="58" width="35"  height="6" rx="3" fill="#818cf8"/>
                                <rect x="66"  y="72"  width="60"  height="5" rx="2.5" fill="#6ad6e8"/>
                                <rect x="132" y="72"  width="25"  height="5" rx="2.5" fill="#fbbf24"/>
                                <rect x="56"  y="85"  width="80"  height="5" rx="2.5" fill="#7ee08a"/>
                                <rect x="66"  y="98"  width="55"  height="5" rx="2.5" fill="#b794f6"/>
                                <rect x="56"  y="111" width="70"  height="5" rx="2.5" fill="#ff7a8a"/>
                                <!-- Warning block (akun1.saldo = -1000) -->
                                <rect x="50"  y="128" width="220" height="28" rx="5" fill="rgba(220,38,38,.15)" stroke="#ef4444" stroke-width="1"/>
                                <rect x="58"  y="136" width="8"   height="12" rx="2" fill="#ef4444"/>
                                <rect x="72"  y="138" width="40"  height="5" rx="2.5" fill="#fca5a5"/>
                                <rect x="118" y="138" width="10"  height="5" rx="2.5" fill="#e2e8f0"/>
                                <rect x="132" y="138" width="40"  height="5" rx="2.5" fill="#ef4444"/>
                                <!-- Output -->
                                <rect x="42"  y="168" width="236" height="1" fill="#1e3a5f"/>
                                <rect x="56"  y="178" width="80"  height="5" rx="2.5" fill="#ef4444" opacity="0.7"/>
                                <rect x="140" y="178" width="50"  height="5" rx="2.5" fill="#94a3b8" opacity="0.5"/>
                                <!-- Laptop base -->
                                <path d="M18 205 L302 205 L316 218 H4 Z" fill="#374151"/>
                                <rect x="130" y="205" width="60" height="4" rx="2" fill="#4b5563"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Navigation Button -->
                <div class="absolute bottom-8 right-8">
                    <!-- PENTING: JANGAN ubah ini kembali jadi <a href> biasa. Tombol ini WAJIB berupa <form method="POST"> ke route fase1.complete, karena tombol inilah satu-satunya cara kolom 'fase1' di database menjadi true. Kalau diubah jadi <a> biasa, middleware EnsureFaseUnlocked akan mengunci SEMUA siswa baru dari mengakses Fase 2 selamanya. Sudah terjadi 3× (lihat riwayat git jika ada). -->
                    <form method="POST" action="{{ route('fase1.complete') }}">
                        @csrf
                        <button type="submit" class="btn-pulse inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-xl font-semibold text-sm transition shadow-sm">
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
