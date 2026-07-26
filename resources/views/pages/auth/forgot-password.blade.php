<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Media Pembelajaran OOP</title>
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
            <a href="{{ route('login') }}"
               class="inline-flex items-center text-green-600 hover:text-green-700 mb-4 font-medium">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="ml-2">Kembali ke Login</span>
            </a>

            <div class="flex items-center gap-3 mb-3">
                <div class="w-11 h-11 rounded-xl bg-green-100 flex items-center justify-center text-xl">
                    🔑
                </div>
                <h1 class="text-3xl font-bold text-gray-900">Lupa Password?</h1>
            </div>
            <p class="text-gray-500 text-sm leading-relaxed">
                Masukkan email yang terdaftar. Kami akan mengirimkan link untuk mengatur ulang password kamu.
            </p>
        </div>

        {{-- Status setelah kirim email --}}
        @if (session('status'))
            <div class="mb-6 flex items-start gap-3 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('status') }}
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            {{-- Email --}}
            <div>
                <label for="email" class="block mb-1.5 font-semibold text-gray-700 text-sm">
                    Alamat Email
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-base pointer-events-none">
                        📧
                    </span>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email kamu"
                        required
                        autofocus
                        class="w-full rounded-xl border-2 border-gray-300 pl-12 pr-4 py-3 text-gray-900 placeholder-gray-400
                               focus:border-green-600 focus:outline-none transition-colors">
                </div>
                @error('email')
                    <p class="mt-2 text-sm text-red-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Submit --}}
            <button
                type="submit"
                class="w-full rounded-xl bg-green-600 py-3 text-base font-bold tracking-wide text-white
                       transition hover:bg-green-700 shadow-md flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Kirim Link Reset Password
            </button>

        </form>

        {{-- Footer --}}
        <p class="mt-8 text-center text-sm text-gray-500">
            Sudah ingat password?
            <a href="{{ route('login') }}" class="font-semibold text-green-600 hover:underline">
                Masuk sekarang
            </a>
        </p>

    </div>
</div>

</body>
</html>
