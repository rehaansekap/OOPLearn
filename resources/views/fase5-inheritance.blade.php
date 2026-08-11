<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pertemuan 2 – Fase 5 – Refleksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        textarea:focus { outline: none; }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

<div class="flex min-h-screen" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">

    @include('sidebar-siswa')

    <main class="flex-1 flex flex-col overflow-hidden">

        @include('_navbar', ['navTitle' => 'Pertemuan 2 – Fase 5 – Refleksi'])
        <div class="flex-1 overflow-y-auto p-8" x-data="{ jawaban: '', refleksi: '', tingkatKetepatan: '' }">

        {{-- Phase badge + Pertemuan badge --}}
        <div class="flex items-center gap-3 mb-6 flex-wrap">
            <span class="inline-flex items-center gap-1.5 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Fase 5 dari 5
            </span>
            <span class="text-xs text-gray-400 font-medium">Model Needham Lima Fase · Tahap Terakhir</span>
            <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 border border-blue-200 text-xs font-semibold px-3 py-1 rounded-full">
                Pertemuan 2 · Inheritance
            </span>
        </div>

        <h2 class="text-2xl font-extrabold text-gray-900 mb-1">Refleksi <span class="text-blue-600">— Inheritance</span></h2>
        <p class="text-sm text-gray-500 mb-5">Pertemuan 2 · Pemrograman Berorientasi Objek</p>

        {{-- Needham stepper (inline, tema biru Pertemuan 2) --}}
        <div class="flex items-center mb-8 overflow-x-auto pb-1">
            @php
            $_steps = [1 => 'Orientasi', 2 => 'Pencetusan Ide', 3 => 'Penstrukturan', 4 => 'Aplikasi', 5 => 'Refleksi'];
            @endphp
            @foreach($_steps as $n => $nama)
            <div class="flex items-center">
                <div class="flex flex-col items-center gap-1 px-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold border-2 transition-all"
                         style="background:#2563eb;border-color:#2563eb;color:white;">
                        {{ $n < 5 ? '✓' : $n }}
                    </div>
                    <span class="text-xs font-medium whitespace-nowrap"
                          style="{{ $n === 5 ? 'color:#1d4ed8;font-weight:700;' : 'color:#9ca3af;' }}">
                        {{ $nama }}
                    </span>
                </div>
                @if($n < 5)
                <div class="h-0.5 w-8 flex-shrink-0" style="background:#2563eb;"></div>
                @endif
            </div>
            @endforeach
        </div>

        {{-- Tujuan Pembelajaran --}}
        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5 mb-6 flex gap-4">
            <div class="shrink-0 w-9 h-9 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wide text-blue-700 mb-2">Tujuan Pembelajaran</p>
                <ul class="space-y-1 text-sm text-blue-900">
                    <li class="flex gap-2"><span class="text-blue-400 font-bold shrink-0">✓</span> Mengevaluasi pemahaman konsep inheritance melalui satu soal pengecekan pemahaman</li>
                    <li class="flex gap-2"><span class="text-blue-400 font-bold shrink-0">✓</span> Merefleksikan perubahan pemahaman sebelum dan sesudah mengikuti pembelajaran</li>
                </ul>
            </div>
        </div>

        <!-- MAIN FORM -->
        <form method="POST" action="{{ route('p2.fase5.store') }}"
              @submit.prevent="
                  if (!jawaban) { alert('Pilih salah satu jawaban terlebih dahulu.'); return; }
                  if (!refleksi.trim()) { alert('Isi kolom refleksi terlebih dahulu.'); return; }
                  if (!tingkatKetepatan) { alert('Pilih tingkat ketepatan terlebih dahulu.'); return; }
                  $el.submit();
              ">
            @csrf
            <input type="hidden" name="pertemuan" value="2">
            <input type="hidden" name="jawaban"  :value="jawaban">
            <input type="hidden" name="refleksi" :value="refleksi">
            <input type="hidden" name="tingkat_ketepatan" :value="tingkatKetepatan">

            <div class="grid grid-cols-12 gap-6">

                <!-- ======================== KIRI ======================== -->
                <div class="col-span-12 lg:col-span-8 space-y-6">

                    <!-- SOAL -->
                    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">

                        <div class="flex items-center gap-3 mb-5">
                            <span class="bg-blue-600 text-white w-9 h-9 rounded-xl flex items-center justify-center font-black text-base">1</span>
                            <span class="text-gray-400 font-semibold text-xs uppercase tracking-widest">Pertanyaan</span>
                        </div>

                        <h2 class="text-xl font-bold text-gray-800 mb-6 leading-snug">
                            Apa tujuan utama dari inheritance (pewarisan) dalam pemrograman berorientasi objek?
                        </h2>

                        <div class="space-y-3">

                            @php
                            $options = [
                                'A' => 'Mewariskan atribut dan method dari class induk ke class anak agar kode tidak ditulis ulang',
                                'B' => 'Menghapus atribut yang tidak digunakan dari sebuah class',
                                'C' => 'Menggabungkan dua class yang tidak berhubungan menjadi satu class besar',
                                'D' => 'Mengganti nama method agar lebih mudah dibaca programmer lain',
                            ];
                            @endphp

                            @foreach($options as $key => $text)
                            <label class="flex items-center gap-4 border-2 rounded-xl p-4 cursor-pointer transition-all duration-150 select-none"
                                   :class="jawaban === '{{ $key }}'
                                       ? 'border-blue-600 bg-blue-50'
                                       : 'border-gray-200 hover:border-blue-300 hover:bg-gray-50'">

                                <input type="radio" class="hidden" name="_jawaban_visual" value="{{ $key }}"
                                       x-model="jawaban">

                                <span class="w-9 h-9 flex-shrink-0 rounded-lg border-2 flex items-center justify-center font-black text-sm transition-all"
                                      :class="jawaban === '{{ $key }}'
                                          ? 'border-blue-600 bg-blue-600 text-white'
                                          : 'border-gray-300 text-gray-500'">
                                    {{ $key }}
                                </span>

                                <span class="text-gray-800 font-medium leading-snug">{{ $text }}</span>
                            </label>
                            @endforeach

                        </div>

                    </div>

                    <!-- REFLEKSI -->
                    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">

                        <div class="flex items-center gap-3 mb-5">
                            <span class="bg-blue-600 text-white w-9 h-9 rounded-xl flex items-center justify-center font-black text-base">2</span>
                            <span class="text-gray-400 font-semibold text-xs uppercase tracking-widest">Bandingkan dengan Ide Awalmu</span>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-5 mb-5 border border-gray-200">
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">📝 Gagasan Awalmu di Fase 2</p>
                            @if($jawabanFase2)
                                <p class="text-sm text-gray-700 italic mb-1">"{{ $jawabanFase2[2] ?? '-' }}"</p>
                                <p class="text-xs text-gray-400 mt-2">Tingkat keyakinanmu waktu itu: {{ $jawabanFase2[3] ?? '-' }}</p>
                            @else
                                <p class="text-sm text-gray-400 italic">Jawaban Fase 2 tidak ditemukan untuk pertemuan ini</p>
                            @endif
                        </div>

                        <h2 class="text-xl font-bold text-gray-800 mb-2 leading-snug">
                            Setelah menyelesaikan pembelajaran ini, apakah gagasan awalmu itu sudah tepat? Apa yang berubah dari pemahamanmu?
                        </h2>
                        <p class="text-gray-500 text-sm mb-5">
                            Jelaskan dengan kata-katamu sendiri, bandingkan dengan apa yang sudah kamu terapkan di Fase 4.
                        </p>

                        <textarea
                            x-model="refleksi"
                            rows="6"
                            placeholder="Tuliskan jawabanmu di sini..."
                            class="w-full border-2 rounded-xl p-4 text-gray-800 text-base resize-none transition-all duration-150 leading-relaxed"
                            :class="refleksi.trim().length > 0
                                ? 'border-blue-600 bg-blue-50 focus:ring-2 focus:ring-blue-200'
                                : 'border-gray-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100'">
                        </textarea>

                        <div class="flex justify-between mt-2 mb-5">
                            <span class="text-xs text-gray-400" x-text="refleksi.trim().length + ' karakter'"></span>
                            <span class="text-xs text-gray-400">Minimal 20 karakter</span>
                        </div>

                        <p class="text-sm font-semibold text-gray-700 mb-3">Seberapa tepat gagasan awalmu dibanding yang kamu terapkan?</p>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 border-2 rounded-xl p-3 cursor-pointer" :class="tingkatKetepatan === 'sangat_berbeda' ? 'border-blue-600 bg-blue-50' : 'border-gray-200'">
                                <input type="radio" class="hidden" name="_tk_visual" value="sangat_berbeda" x-model="tingkatKetepatan">
                                <span class="text-sm text-gray-700">Sangat berbeda dari yang kubayangkan</span>
                            </label>
                            <label class="flex items-center gap-3 border-2 rounded-xl p-3 cursor-pointer" :class="tingkatKetepatan === 'sebagian_tepat' ? 'border-blue-600 bg-blue-50' : 'border-gray-200'">
                                <input type="radio" class="hidden" name="_tk_visual" value="sebagian_tepat" x-model="tingkatKetepatan">
                                <span class="text-sm text-gray-700">Sebagian sudah tepat, sebagian meleset</span>
                            </label>
                            <label class="flex items-center gap-3 border-2 rounded-xl p-3 cursor-pointer" :class="tingkatKetepatan === 'sangat_tepat' ? 'border-blue-600 bg-blue-50' : 'border-gray-200'">
                                <input type="radio" class="hidden" name="_tk_visual" value="sangat_tepat" x-model="tingkatKetepatan">
                                <span class="text-sm text-gray-700">Sudah sangat sesuai dugaan awalku</span>
                            </label>
                        </div>

                    </div>

                </div>

                <!-- ======================== KANAN ======================== -->
                <div class="col-span-12 lg:col-span-4 flex flex-col gap-6">

                    <!-- INFO INHERITANCE -->
                    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">

                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 font-black text-lg">💡</div>
                            <span class="font-bold text-gray-700 text-sm uppercase tracking-widest">Petunjuk</span>
                        </div>

                        <ul class="space-y-3 text-sm text-gray-600 leading-relaxed">
                            <li class="flex items-start gap-2">
                                <span class="text-blue-600 font-black mt-0.5">✓</span>
                                Pilih <strong>satu jawaban</strong> yang paling tepat pada soal di atas.
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-blue-600 font-black mt-0.5">✓</span>
                                Tuliskan <strong>refleksi</strong> dengan kalimatmu sendiri, bukan copas.
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-blue-600 font-black mt-0.5">✓</span>
                                Tidak ada jawaban benar atau salah di bagian refleksi.
                            </li>
                        </ul>

                    </div>

                    <!-- KESIMPULAN MATERI (tampil setelah pilih jawaban) -->
                    <div x-show="jawaban !== ''" x-cloak
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="bg-blue-50 border border-blue-200 rounded-[2rem] p-6">

                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-lg">📘</span>
                            <span class="font-bold text-blue-700 text-sm uppercase tracking-widest">Kesimpulan Materi</span>
                        </div>

                        <p class="text-gray-700 text-sm leading-relaxed">
                            <strong>Inheritance</strong> memungkinkan class anak mewarisi atribut dan method dari
                            class induknya, sehingga kode yang sama tidak perlu ditulis ulang. Class anak tetap bisa
                            menambahkan atribut/method uniknya sendiri, menjadikan program lebih
                            efisien dan terstruktur.
                        </p>

                    </div>

                    <!-- STATUS & TOMBOL KIRIM -->
                    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6 space-y-4">

                        <!-- Status checklist -->
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center gap-2" :class="jawaban ? 'text-blue-600' : 'text-gray-400'">
                                <span x-text="jawaban ? '✓' : '○'" class="font-black w-5"></span>
                                <span>Jawaban soal dipilih</span>
                            </div>
                            <div class="flex items-center gap-2" :class="refleksi.trim().length >= 20 ? 'text-blue-600' : 'text-gray-400'">
                                <span x-text="refleksi.trim().length >= 20 ? '✓' : '○'" class="font-black w-5"></span>
                                <span>Refleksi tertulis (min. 20 karakter)</span>
                            </div>
                            <div class="flex items-center gap-2" :class="tingkatKetepatan ? 'text-blue-600' : 'text-gray-400'">
                                <span x-text="tingkatKetepatan ? '✓' : '○'" class="font-black w-5"></span>
                                <span>Tingkat ketepatan dipilih</span>
                            </div>
                        </div>

                        <button id="submitBtn" type="submit"
                                class="w-full py-4 rounded-xl font-black text-base transition-all duration-200 shadow-sm"
                                :class="jawaban && refleksi.trim().length >= 20 && tingkatKetepatan
                                    ? 'bg-blue-600 hover:bg-blue-700 text-white shadow-blue-100 hover:shadow-md active:scale-95'
                                    : 'bg-gray-100 text-gray-400 cursor-not-allowed'">
                            Kirim Refleksi →
                        </button>

                    </div>

                </div>

            </div>

        </form>

        </div>
    </main>

</div>

</body>
</html>
