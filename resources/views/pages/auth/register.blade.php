<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Sistem Keamanan</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}?v=2" sizes="any">
    <link rel="icon" href="{{ asset('favicon.svg') }}?v=2" type="image/svg+xml">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #e5e7eb;
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen p-4">

    <div class="bg-white rounded-3xl shadow-lg flex flex-col md:flex-row max-w-4xl w-full overflow-hidden">

        <!-- KIRI -->
        <div class="hidden md:flex md:w-1/2 items-center justify-center p-8 bg-white">
            <img src="{{ asset('images/security-illustration.svg') }}"
                 alt="Security Illustration"
                 class="w-full max-w-sm">
        </div>

        <!-- KANAN -->
        <div class="w-full md:w-1/2 p-10 md:p-16">

            <!-- HEADER -->
            <div class="mb-8 text-center md:text-left">
                <h1 class="text-3xl font-bold text-gray-900">
                    Daftar
                </h1>

                <p class="mt-2 text-gray-500">
                    Silahkan daftar untuk membuat akun
                </p>
            </div>

            <!-- FORM -->
            <form action="{{ route('register.store') }}" method="POST">
                @csrf

                <!-- Nama -->
                <div class="mb-4">
                    <label class="block text-black font-bold mb-1">Nama Lengkap:</label>
                    <input type="text" name="name"
                        placeholder="Masukkan Nama Lengkap"
                        class="w-full px-4 py-3 border-2 border-gray-400 rounded-xl italic focus:outline-none focus:border-green-600 transition">
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-black font-bold mb-1">Email:</label>
                    <input type="email" name="email"
                        placeholder="Masukkan Email"
                        class="w-full px-4 py-3 border-2 border-gray-400 rounded-xl italic focus:outline-none focus:border-green-600 transition">
                </div>
                <div class="mb-4">
                    <label class="block text--black font-bold mb-1">
                        Daftar Sebagai:
                    </label>

                    <select
                        name="role"
                        class="w-full px-4 py-3 border-2 border-gray-400 rounded-xl italic focus:outline-none focus:border-green-600 transition">
                        <option value="siswa">Siswa</option>
                        <option value="guru">Guru</option>


                </div>
                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-black font-bold mb-1">Password:</label>
                    <input type="password" name="password"
                        placeholder="Buat Password"
                        class="w-full px-4 py-3 border-2 border-gray-400 rounded-xl italic focus:outline-none focus:border-green-600 transition">
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label class="block text-black font-bold mb-1">Konfirmasi Password:</label>
                    <input type="password" name="password_confirmation"
                        placeholder="Ulangi Password"
                        class="w-full px-4 py-3 border-2 border-gray-400 rounded-xl italic focus:outline-none focus:border-green-600 transition">
                </div>

                <!-- BUTTON -->
                <button type="submit"
                    class="w-full bg-[#388e3c] hover:bg-green-700 text-white font-black text-2xl py-3 rounded-lg transition duration-300 uppercase tracking-wider">
                    DAFTAR
                </button>
            </form>

            <!-- FOOTER -->
            <div class="mt-8 text-center">
                <p class="font-bold text-black">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-[#388e3c] hover:underline">
                        Login Disini
                    </a>
                </p>
            </div>

        </div>
    </div>

</body>
</html>
