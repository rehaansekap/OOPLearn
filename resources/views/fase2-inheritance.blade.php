<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pertemuan 2 – Fase 2 – Pencetusan Ide</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }

        .option-card { transition: all 0.25s ease; }
        .option-card:hover { transform: translateY(-3px); }
        .option-card.active { background-color: #2563eb; color: white; border-color: #2563eb; }

        @keyframes ring-out {
            0%, 100% { box-shadow: 0 0 0 0 rgba(37,99,235,0.45); }
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

            @include('_navbar', ['navTitle' => 'Pertemuan 2 – Fase 2 – Pencetusan Ide'])
            <div class="flex-1 overflow-y-auto p-8">

            <!-- Content Card -->
            <div id="quiz-box"
                class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8 lg:p-10 min-h-[80vh] relative">

                {{-- Phase badge + Pertemuan badge --}}
                <div class="flex items-center gap-3 mb-5 flex-wrap">
                    <span class="inline-flex items-center gap-1.5 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Fase 2 dari 5
                    </span>
                    <span class="text-xs text-gray-400 font-medium">Model Needham Lima Fase</span>
                    <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 border border-blue-200 text-xs font-semibold px-3 py-1 rounded-full">
                        Pertemuan 2 · Inheritance
                    </span>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900 mb-1">Pencetusan Ide <span class="text-blue-600">— Inheritance</span></h2>
                <p class="text-sm text-gray-500 mb-5">Studi Kasus: Sistem Karakter Gim (RPG)</p>

                {{-- Needham stepper (inline, tema biru Pertemuan 2) --}}
                <div class="flex items-center mb-8 overflow-x-auto pb-1">
                    @php
                    $_steps = [1 => 'Orientasi', 2 => 'Pencetusan Ide', 3 => 'Penstrukturan', 4 => 'Aplikasi', 5 => 'Refleksi'];
                    @endphp
                    @foreach($_steps as $n => $nama)
                    <div class="flex items-center">
                        <div class="flex flex-col items-center gap-1 px-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold border-2 transition-all"
                                 style="{{ $n <= 2 ? 'background:#2563eb;border-color:#2563eb;color:white;' : 'background:white;border-color:#e5e7eb;color:#9ca3af;' }}">
                                {{ $n < 2 ? '✓' : $n }}
                            </div>
                            <span class="text-xs font-medium whitespace-nowrap"
                                  style="{{ $n === 2 ? 'color:#1d4ed8;font-weight:700;' : 'color:#9ca3af;' }}">
                                {{ $nama }}
                            </span>
                        </div>
                        @if($n < 5)
                        <div class="h-0.5 w-8 flex-shrink-0" style="{{ $n < 2 ? 'background:#2563eb;' : 'background:#e5e7eb;' }}"></div>
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
                            <li class="flex gap-2"><span class="text-blue-400 font-bold shrink-0">✓</span> Mengungkapkan gagasan awal tentang cara menghindari duplikasi kode antar-class</li>
                            <li class="flex gap-2"><span class="text-blue-400 font-bold shrink-0">✓</span> Menganalisis kenapa pewarisan data umum ke satu tempat itu penting</li>
                        </ul>
                    </div>
                </div>

                <!-- QUESTION -->
                <div class="mb-8" data-aos="fade-up">

                    <p class="text-gray-500 font-semibold mb-4">
                        Pertanyaan
                        <span id="question-number">1</span> / 4
                    </p>

                    <h1 id="question-title"
                        class="text-4xl font-extrabold leading-tight max-w-4xl">

                        Bagaimana caranya supaya kamu tidak perlu menulis ulang nama dan nyawa di setiap class Hero, Monster, dan karakter lain yang mungkin ditambahkan nanti?

                    </h1>

                </div>

                <!-- OPTIONS -->
                <div id="options-container"
                    class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                </div>

                <!-- FEEDBACK -->
                <div id="feedback-box"
                    class="hidden rounded-2xl p-5 text-lg leading-relaxed mb-10">
                </div>

                <!-- Navigation Button -->
                <div class="absolute bottom-8 right-8">
                    <button id="next-btn" disabled
                        class="inline-flex items-center gap-2 bg-gray-300 text-white px-6 py-2.5 rounded-xl font-semibold text-sm transition">
                        Lanjut
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>

            </div>

            </div>
        </main>

    </div>

    <script>

        const questions = [

            {
                type: "text",
                question: "Bagaimana caranya supaya kamu tidak perlu menulis ulang nama dan nyawa di setiap class Hero, Monster, dan karakter lain yang mungkin ditambahkan nanti?",
                placeholder: "Tulis gagasanmu di sini... "
            },

            {
                type: "text",
                question: "Menurutmu, kenapa menulis atribut yang sama (nama, nyawa) berulang-ulang di banyak class itu berisiko untuk tim programmer besar?",
                placeholder: "Tulis dugaanmu..."
            },

            {
                type: "text",
                question: "Kalau kamu jadi lead programmer studio gim itu, bagaimana rancangan class-mu supaya menambah jenis karakter baru (misal NPC) jadi gampang tanpa menulis ulang kode?",
                placeholder: "Tulis solusi menurut versimu..."
            },

            {
                type: "single",
                question: "Seberapa yakin kamu dengan jawabanmu tadi?",
                options: [
                    "Yakin",
                    "Ragu-ragu",
                    "Cuma menebak"
                ]
            }

        ];

        let currentQuestion = 0;

        let jawabanSiswa = [];

        const questionTitle = document.getElementById('question-title');

        const optionsContainer = document.getElementById('options-container');

        const feedbackBox = document.getElementById('feedback-box');

        const nextBtn = document.getElementById('next-btn');

        const questionNumber = document.getElementById('question-number');

        const quizBox = document.getElementById('quiz-box');

        function loadQuestion() {

            const q = questions[currentQuestion];

            questionTitle.innerText = q.question;

            questionNumber.innerText = currentQuestion + 1;

            optionsContainer.innerHTML = "";

            feedbackBox.classList.add('hidden');

            nextBtn.disabled = true;

            nextBtn.className =
                "bg-gray-300 text-white px-10 py-4 rounded-xl font-bold text-xl flex items-center gap-3 transition-all";

            if (q.type === 'text') {

                optionsContainer.className = "mb-10";

                const wrap = document.createElement('div');
                wrap.className = "relative";

                const label = document.createElement('p');
                label.className = "flex items-center gap-2 text-sm font-bold text-gray-500 mb-2";
                label.innerHTML = `<span>💭</span> Jawabanmu`;

                const textarea = document.createElement('textarea');
                textarea.rows = 6;
                textarea.placeholder = q.placeholder;
                textarea.className =
                    "w-full bg-gray-50 border-2 border-gray-200 rounded-2xl p-6 pb-10 text-lg leading-relaxed placeholder:text-gray-400 focus:outline-none focus:bg-white focus:border-[#2563eb] focus:ring-4 focus:ring-[#2563eb]/10 transition resize-none";

                const counter = document.createElement('span');
                counter.className =
                    "absolute bottom-4 right-5 text-xs font-bold px-2.5 py-1 rounded-full bg-gray-200 text-gray-500 transition-colors";
                counter.innerText = "0 / 10";

                textarea.oninput = () => {
                    const len = textarea.value.trim().length;
                    counter.innerText = `${len} / 10`;
                    counter.className =
                        "absolute bottom-4 right-5 text-xs font-bold px-2.5 py-1 rounded-full transition-colors " +
                        (len >= 10 ? "bg-blue-100 text-blue-700" : "bg-gray-200 text-gray-500");
                    handleTextInput(textarea.value);
                };

                wrap.appendChild(label);
                wrap.appendChild(textarea);
                wrap.appendChild(counter);
                optionsContainer.appendChild(wrap);

            } else {

                optionsContainer.className = "grid grid-cols-1 md:grid-cols-2 gap-8 mb-10";

                q.options.forEach(option => {

                    const card = document.createElement('button');

                    card.className =
                        "option-card border border-gray-200 rounded-2xl h-40 text-2xl font-bold bg-white hover:bg-blue-50";

                    card.innerText = option;

                    card.onclick = () => selectSingleOption(card, option);

                    optionsContainer.appendChild(card);
                });
            }
        }

        function showRecordedFeedback() {

            feedbackBox.classList.remove('hidden');

            feedbackBox.className =
                "bg-blue-50 border-l-4 border-blue-400 rounded-2xl p-5 text-lg leading-relaxed mb-10";

            feedbackBox.innerHTML =
                "📝 Jawabanmu sudah dicatat. Nanti kita akan bahas bersama di fase berikutnya!";

            nextBtn.disabled = false;

            nextBtn.className =
                "btn-pulse bg-[#2563eb] hover:bg-blue-700 text-white px-10 py-4 rounded-xl font-bold text-xl flex items-center gap-3 transition-all shadow-lg";
        }

        function handleTextInput(value) {

            jawabanSiswa[currentQuestion] = value;

            if (value.trim().length >= 10) {

                showRecordedFeedback();

            } else {

                feedbackBox.classList.add('hidden');

                nextBtn.disabled = true;

                nextBtn.className =
                    "bg-gray-300 text-white px-10 py-4 rounded-xl font-bold text-xl flex items-center gap-3 transition-all";
            }
        }

        function selectSingleOption(card, selected) {

            document.querySelectorAll('.option-card')
                .forEach(btn => btn.classList.remove('active'));

            card.classList.add('active');

            jawabanSiswa[currentQuestion] = selected;

            showRecordedFeedback();
        }

        nextBtn.onclick = () => {

    currentQuestion++;

    if(currentQuestion < questions.length){

        loadQuestion();

    }else{

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('p2.fase2.complete') }}";

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = "{{ csrf_token() }}";

        const jawabanInput = document.createElement('input');
        jawabanInput.type = 'hidden';
        jawabanInput.name = 'jawaban';
        jawabanInput.value = JSON.stringify(jawabanSiswa);

        form.appendChild(csrfInput);
        form.appendChild(jawabanInput);
        document.body.appendChild(form);
        form.submit();

    }

};

loadQuestion();

    </script>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init({ once: true, duration: 600, offset: 20 });</script>
</body>
</html>
