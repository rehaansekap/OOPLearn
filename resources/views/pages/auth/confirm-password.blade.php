<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Password - Media Pembelajaran OOP</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}?v=2" sizes="any">
    <link rel="icon" href="{{ asset('favicon.svg') }}?v=2" type="image/svg+xml">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #e5e7eb; }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">

<div class="bg-white rounded-3xl shadow-xl overflow-hidden w-full max-w-5xl flex flex-col md:flex-row">

    {{-- GAMBAR (kiri) --}}
    <div class="hidden md:flex md:w-1/2 items-center justify-center bg-white p-10">
        <img
            src="{{ asset('images/security-illustration.svg') }}"
            alt="Ilustrasi"
            class="w-full max-w-md">
    </div>

    {{-- FORM (kanan) --}}
    <div class="w-full md:w-1/2 px-8 py-10 md:px-14 md:py-16">

        {{-- Header --}}
        <div class="mb-8 text-center md:text-left">
            <a href="{{ route('home') }}"
               class="inline-flex items-center text-green-600 hover:text-green-700 mb-4 font-medium">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="ml-2">Kembali ke Beranda</span>
            </a>

            <div class="flex items-center gap-3 mb-3">
                <div class="w-11 h-11 rounded-xl bg-green-100 flex items-center justify-center text-xl">
                    🛡️
                </div>
                <h1 class="text-3xl font-bold text-gray-900">Konfirmasi Password</h1>
            </div>
            <p class="text-gray-500 text-sm leading-relaxed">
                Ini adalah area aman. Konfirmasi password kamu sebelum melanjutkan.
            </p>
        </div>

        {{-- Status --}}
        @if (session('status'))
            <div class="mb-6 flex items-start gap-3 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('status') }}
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('password.confirm.store') }}" class="space-y-5">
            @csrf

            {{-- Password --}}
            <div>
                <label for="password" class="block mb-1.5 font-semibold text-gray-700 text-sm">Password</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">🔒</span>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Masukkan password kamu"
                        required
                        autocomplete="current-password"
                        class="w-full rounded-xl border-2 border-gray-300 pl-12 pr-4 py-3 text-gray-900
                               focus:border-green-600 focus:outline-none transition-colors">
                </div>
                @error('password')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <button
                type="submit"
                class="w-full rounded-xl bg-green-600 py-3 text-base font-bold tracking-wide text-white
                       transition hover:bg-green-700 shadow-md">
                Konfirmasi
            </button>

        </form>

    </div>
</div>

</body>
</html>
