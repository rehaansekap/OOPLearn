
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Media Pembelajaran OOP</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}?v=2" sizes="any">
    <link rel="icon" href="{{ asset('favicon.svg') }}?v=2" type="image/svg+xml">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body{
            background-color:#e5e7eb;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">

<div class="bg-white rounded-3xl shadow-xl overflow-hidden w-full max-w-5xl flex flex-col md:flex-row">

    <!-- ILUSTRASI -->
    <div class="hidden md:flex md:w-1/2 items-center justify-center bg-gradient-to-br from-green-50 to-emerald-100 p-10">
        <svg viewBox="0 0 440 380" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full max-w-md">
            <!-- Background circles -->
            <circle cx="220" cy="195" r="165" fill="#f0fdf4"/>
            <circle cx="375" cy="58" r="38" fill="#bbf7d0" opacity="0.7"/>
            <circle cx="65" cy="310" r="28" fill="#86efac" opacity="0.5"/>
            <circle cx="405" cy="290" r="18" fill="#dcfce7" opacity="0.8"/>
            <!-- Laptop screen -->
            <rect x="90" y="78" width="240" height="165" rx="12" fill="#1e293b"/>
            <rect x="100" y="88" width="220" height="145" rx="7" fill="#0f172a"/>
            <!-- Code: class BankAccount: -->
            <rect x="114" y="103" width="26" height="6" rx="3" fill="#818cf8"/>
            <rect x="145" y="103" width="68" height="6" rx="3" fill="#fbbf24"/>
            <rect x="217" y="103" width="4"  height="6" rx="3" fill="#e2e8f0"/>
            <!-- __saldo = 0 -->
            <rect x="124" y="116" width="42" height="5" rx="2.5" fill="#ff7a8a"/>
            <rect x="171" y="116" width="26" height="5" rx="2.5" fill="#94a3b8"/>
            <!-- def get_saldo(self): -->
            <rect x="114" y="129" width="22" height="5" rx="2.5" fill="#818cf8"/>
            <rect x="141" y="129" width="54" height="5" rx="2.5" fill="#7ee08a"/>
            <rect x="199" y="129" width="30" height="5" rx="2.5" fill="#e2e8f0"/>
            <!-- return self.__saldo -->
            <rect x="124" y="142" width="28" height="5" rx="2.5" fill="#818cf8"/>
            <rect x="157" y="142" width="50" height="5" rx="2.5" fill="#ff7a8a"/>
            <!-- class Tabungan(BankAccount): -->
            <rect x="114" y="158" width="26" height="5" rx="2.5" fill="#818cf8"/>
            <rect x="145" y="158" width="46" height="5" rx="2.5" fill="#6ad6e8"/>
            <rect x="195" y="158" width="30" height="5" rx="2.5" fill="#fbbf24"/>
            <!-- super().__init__() -->
            <rect x="124" y="171" width="36" height="5" rx="2.5" fill="#b794f6"/>
            <rect x="165" y="171" width="54" height="5" rx="2.5" fill="#e2e8f0"/>
            <!-- cursor -->
            <rect x="114" y="184" width="2" height="10" rx="1" fill="#fbbf24" opacity="0.9"/>
            <!-- Console divider -->
            <rect x="100" y="198" width="220" height="1" fill="#1e3a5f"/>
            <!-- Console output -->
            <circle cx="112" cy="210" r="3" fill="#7ee08a"/>
            <rect x="120" y="207" width="70" height="5" rx="2.5" fill="#4ade80" opacity="0.7"/>
            <!-- Run button -->
            <rect x="254" y="203" width="56" height="17" rx="5" fill="#16a34a"/>
            <polygon points="266,208 266,215 272,211.5" fill="white"/>
            <rect x="277" y="208" width="24" height="4" rx="2" fill="white" opacity="0.8"/>
            <!-- Laptop base -->
            <path d="M72 243 L368 243 L382 260 H58 Z" fill="#374151"/>
            <rect x="158" y="243" width="104" height="5" rx="2" fill="#4b5563"/>

            <!-- Floating card: Enkapsulasi -->
            <rect x="320" y="90" width="110" height="62" rx="10" fill="white"
                  style="filter:drop-shadow(0 4px 14px rgba(0,0,0,.13))"/>
            <circle cx="342" cy="121" r="14" fill="#dcfce7"/>
            <text x="342" y="126" text-anchor="middle" font-size="15">🔒</text>
            <text x="362" y="110" font-family="system-ui,sans-serif" font-size="9.5" fill="#166534" font-weight="700">Enkapsulasi</text>
            <rect x="360" y="115" width="52" height="4" rx="2" fill="#bbf7d0"/>
            <rect x="360" y="123" width="40" height="4" rx="2" fill="#bbf7d0"/>
            <rect x="360" y="131" width="46" height="4" rx="2" fill="#bbf7d0"/>
            <rect x="360" y="139" width="34" height="4" rx="2" fill="#bbf7d0"/>

            <!-- Floating card: Inheritance -->
            <rect x="16" y="218" width="110" height="62" rx="10" fill="white"
                  style="filter:drop-shadow(0 4px 14px rgba(0,0,0,.13))"/>
            <circle cx="38" cy="249" r="14" fill="#ede9fe"/>
            <text x="38" y="254" text-anchor="middle" font-size="15">📐</text>
            <text x="58" y="237" font-family="system-ui,sans-serif" font-size="9.5" fill="#5b21b6" font-weight="700">Inheritance</text>
            <rect x="56" y="243" width="54" height="4" rx="2" fill="#ddd6fe"/>
            <rect x="56" y="251" width="44" height="4" rx="2" fill="#ddd6fe"/>
            <rect x="56" y="259" width="50" height="4" rx="2" fill="#ddd6fe"/>
            <rect x="56" y="267" width="36" height="4" rx="2" fill="#ddd6fe"/>

            <!-- Brand badge -->
            <rect x="148" y="30" width="144" height="30" rx="15" fill="#16a34a"/>
            <text x="220" y="50" text-anchor="middle" font-family="system-ui,sans-serif" font-size="12" fill="white" font-weight="700">🎓 Media Pembelajaran OOP</text>

            <!-- Progress indicator (5 dots) -->
            <circle cx="190" cy="328" r="5" fill="#16a34a"/>
            <circle cx="206" cy="328" r="5" fill="#16a34a"/>
            <circle cx="222" cy="328" r="5" fill="#bbf7d0"/>
            <circle cx="238" cy="328" r="5" fill="#bbf7d0"/>
            <circle cx="254" cy="328" r="5" fill="#bbf7d0"/>

            <!-- Sparkles -->
            <circle cx="402" cy="210" r="4"   fill="#fbbf24" opacity="0.85"/>
            <circle cx="413" cy="224" r="2.5" fill="#fbbf24" opacity="0.5"/>
            <circle cx="392" cy="226" r="2.5" fill="#fbbf24" opacity="0.5"/>
            <circle cx="30"  cy="130" r="4"   fill="#86efac" opacity="0.8"/>
            <circle cx="42"  cy="144" r="2.5" fill="#86efac" opacity="0.5"/>
        </svg>
    </div>

    <!-- FORM LOGIN -->
    <div class="w-full md:w-1/2 px-8 py-10 md:px-14 md:py-16">

        <!-- HEADER -->
        <div class="mb-8 text-center md:text-left">
        <a href="/"
            class="inline-flex items-center text-green-600 hover:text-green-700 mb-4 font-medium">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="ml-2">Kembali ke Beranda</span>
        </a>
            <h1 class="text-3xl font-bold text-gray-900">
                Selamat Datang
            </h1>

            <p class="mt-2 text-gray-500">
                Masuk untuk melanjutkan pembelajaran Enapsulasi dan Inheritance
            </p>

        </div>

        <!-- STATUS -->
        @if (session('status'))
            <div class="mb-6 rounded-xl bg-green-100 px-4 py-3 text-sm text-green-700">
                {{ session('status') }}
            </div>
        @endif

        <!-- FORM -->
        <form action="{{ route('login.store') }}" method="POST" class="space-y-5">

            @csrf

            <!-- ROLE -->
            <div>

                <label class="block mb-3 font-semibold text-gray-700">
                    Masuk Sebagai
                </label>

                <div class="flex gap-3">

                    <button
                        type="button"
                        id="btnSiswa"
                        onclick="setRole('siswa')"
                        class="flex-1 rounded-xl bg-green-600 text-white py-3 font-semibold shadow-sm">

                        🎓 Siswa

                    </button>

                    <button
                        type="button"
                        id="btnGuru"
                        onclick="setRole('guru')"
                        class="flex-1 rounded-xl border-2 border-gray-300 py-3 font-semibold hover:bg-gray-50">

                        👨‍🏫 Guru

                    </button>

                </div>

                <input
                    type="hidden"
                    name="role"
                    id="role"
                    value="siswa">

            </div>

            <!-- EMAIL -->
            <div>

                <div class="relative">
                    <span class="absolute left-4 top-4 text-gray-400">
                        📧
                    </span>
                </div>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Masukkan Email"
                    required
                    autofocus
                    class="w-full rounded-xl border-2 border-gray-300 pl-12 pr-4 py-3 focus:border-green-600 focus:outline-none">

                @error('email')
                    <p class="mt-2 text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <!-- PASSWORD -->
            <div>

                <div class="relative">
                    <span class="absolute left-4 top-4 text-gray-400">
                        🔒
                    </span>
                </div>
                <input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="Masukkan Password"
                    required
                    class="w-full rounded-xl border-2 border-gray-300 pl-12 pr-4 py-3 focus:border-green-600 focus:outline-none">

                @error('password')
                    <p class="mt-2 text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <!-- REMEMBER -->
            <div class="flex items-center justify-between text-sm">

                <label class="flex items-center gap-2 text-gray-600">

                    <input
                        type="checkbox"
                        name="remember">

                    Ingat saya

                </label>

                @if (Route::has('password.request'))
                    <a
                        href="{{ route('password.request') }}"
                        class="font-medium text-green-600 hover:underline">

                        Lupa Password?

                    </a>
                @endif

            </div>

            <!-- BUTTON LOGIN -->
            <button
                type="submit"
                class="w-full rounded-xl bg-green-600 py-3 text-lg font-bold tracking-wide text-white transition hover:bg-green-700 shadow-md">

                LOGIN

            </button>

        </form>

        <!-- REGISTER -->
        @if (Route::has('register'))

            <div class="mt-8 text-center text-sm text-gray-700">

                Belum punya akun?

                <a
                    href="{{ route('register') }}"
                    class="font-semibold text-green-600 hover:underline">

                    Daftar Disini

                </a>

            </div>

        @endif

    </div>

</div>

<script>

function setRole(role){

    document.getElementById('role').value = role;

    const siswa = document.getElementById('btnSiswa');
    const guru = document.getElementById('btnGuru');

    siswa.classList.remove(
        'bg-green-600',
        'text-white'
    );

    guru.classList.remove(
        'bg-green-600',
        'text-white'
    );

    siswa.classList.add(
        'border-2',
        'border-gray-300'
    );

    guru.classList.add(
        'border-2',
        'border-gray-300'
    );

    if(role === 'siswa'){

        siswa.classList.remove(
            'border-2',
            'border-gray-300'
        );

        siswa.classList.add(
            'bg-green-600',
            'text-white'
        );

    }else{

        guru.classList.remove(
            'border-2',
            'border-gray-300'
        );

        guru.classList.add(
            'bg-green-600',
            'text-white'
        );

    }
}

</script>

</body>
</html>

