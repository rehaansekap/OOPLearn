<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/driver.js@1.3.1/dist/driver.js.iife.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/driver.js@1.3.1/dist/driver.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

{{-- x-data di sini agar page bisa diakses oleh sidebar (scope inheritance Alpine.js) --}}
<div class="flex min-h-screen"
     x-data="{ page: 'dashboard', sidebarOpen: window.innerWidth >= 1024 }"
     x-init="() => { const s = new URLSearchParams(window.location.search).get('section'); if(s) page = s; }">

    @include('sidebar-guru')

    <main class="flex-1 flex flex-col overflow-hidden">

        {{-- ── HEADER ── --}}
        <header class="bg-white border-b border-gray-100 h-14 px-4 sm:px-6 flex items-center justify-between shrink-0">

            <div class="flex items-center gap-3 min-w-0">
                <button @click="$dispatch('toggle-sidebar')"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100 active:scale-95 transition shrink-0">
                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <h1 class="font-semibold text-gray-800 text-sm truncate"
                    x-text="{
                        'dashboard':  'Dashboard Guru',
                        'data-siswa': 'Data Siswa',
                        'data-nilai': 'Data Nilai',
                        'materi':     'Materi Pembelajaran',
                        'assessment': 'Kelola Assessment',
                        'akun':       'Akun Guru'
                    }[page]">Dashboard Guru</h1>
            </div>

            <div class="flex items-center gap-2.5 shrink-0">
                <div class="text-right hidden sm:block">
                    <p class="text-gray-800 font-semibold text-xs leading-none">{{ auth()->user()->name }}</p>
                    <p class="text-gray-400 text-[10px] leading-none mt-0.5">Guru</p>
                </div>
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=e0e7ff&color=4338ca&size=32"
                     alt="User" class="w-8 h-8 rounded-full border border-gray-100 shrink-0">
            </div>

        </header>

        {{-- ── CONTENT AREA ── --}}
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">

            {{-- ════════════════════════════════════════
                 PAGE: DASHBOARD
            ════════════════════════════════════════ --}}
            <div x-show="page === 'dashboard'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0">

                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-extrabold text-gray-800">Statistik Pembelajaran</h2>
                    <button type="button" onclick="startTour()"
                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-indigo-700 hover:bg-indigo-50 px-2.5 py-1.5 rounded-lg transition">
                        ❓ Tour
                    </button>
                </div>

                @php
                    $avgPct = $siswas->count()
                        ? round($siswas->avg(function ($s) {
                            $lp = $s->learningProgress;
                            return collect(['fase1','fase2','fase3','fase4','fase5'])
                                ->filter(fn($f) => $lp?->$f)->count() * 20;
                        }))
                        : 0;
                    $selesai = $siswas->filter(function ($s) {
                        $lp = $s->learningProgress;
                        return collect(['fase1','fase2','fase3','fase4','fase5'])
                            ->every(fn($f) => $lp?->$f);
                    })->count();
                @endphp

                <div id="tour-stats" class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Total Siswa</p>
                            <p class="text-2xl font-extrabold text-gray-800">{{ $totalSiswa }}</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Progress Rata-rata</p>
                            <p class="text-2xl font-extrabold text-gray-800">{{ $avgPct }}%</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Siswa Selesai</p>
                            <p class="text-2xl font-extrabold text-gray-800">{{ $selesai }}</p>
                        </div>
                    </div>

                </div>

                {{-- Ringkasan progress per siswa --}}
                <div id="tour-siswa-list" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-700 text-sm mb-4">Ringkasan Progress Siswa</h3>
                    <div class="space-y-3">
                        @forelse($siswas as $siswa)
                            @php
                                $lp   = $siswa->learningProgress;
                                $done = collect(['fase1','fase2','fase3','fase4','fase5'])->filter(fn($f) => $lp?->$f)->count();
                                $pct  = $done * 20;
                            @endphp
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->name) }}&background=e0e7ff&color=4338ca&size=28"
                                     class="w-7 h-7 rounded-full shrink-0">
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-sm font-medium text-gray-700 truncate">{{ $siswa->name }}</span>
                                        <span class="text-xs font-semibold {{ $pct === 100 ? 'text-green-600' : 'text-gray-400' }} ml-2 shrink-0">{{ $pct }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                        <div class="h-1.5 rounded-full {{ $pct === 100 ? 'bg-green-500' : 'bg-indigo-400' }}"
                                             style="width:{{ $pct }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-400 text-sm">Belum ada data siswa.</p>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- ════════════════════════════════════════
                 PAGE: DATA SISWA
            ════════════════════════════════════════ --}}
            <div x-show="page === 'data-siswa'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0">

                <h2 class="text-2xl font-extrabold text-gray-800 mb-6">Data Siswa</h2>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-gray-500">
                                    <th class="text-left px-4 py-3 rounded-l-xl font-semibold text-xs uppercase tracking-wide">No</th>
                                    <th class="text-left px-4 py-3 font-semibold text-xs uppercase tracking-wide">Nama</th>
                                    <th class="text-left px-4 py-3 font-semibold text-xs uppercase tracking-wide">Email</th>
                                    <th class="text-center px-4 py-3 font-semibold text-xs uppercase tracking-wide">Progress</th>
                                    <th class="text-center px-4 py-3 rounded-r-xl font-semibold text-xs uppercase tracking-wide">%</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($siswas as $i => $siswa)
                                    @php
                                        $lp   = $siswa->learningProgress;
                                        $done = collect(['fase1','fase2','fase3','fase4','fase5'])->filter(fn($f) => $lp?->$f)->count();
                                        $pct  = $done * 20;
                                    @endphp
                                    <tr class="hover:bg-gray-50/70 transition">
                                        <td class="px-4 py-3 text-gray-400 text-sm">{{ $i + 1 }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-2.5">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->name) }}&background=e0e7ff&color=4338ca&size=28"
                                                     class="w-7 h-7 rounded-full shrink-0">
                                                <span class="font-medium text-gray-800">{{ $siswa->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-gray-400 text-xs">{{ $siswa->email }}</td>
                                        <td class="px-4 py-3">
                                            <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                                <div class="h-1.5 rounded-full {{ $pct === 100 ? 'bg-green-500' : ($pct > 0 ? 'bg-indigo-400' : 'bg-gray-100') }}"
                                                     style="width:{{ $pct }}%"></div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold
                                                         {{ $pct === 100 ? 'bg-green-50 text-green-700' : ($pct > 0 ? 'bg-indigo-50 text-indigo-600' : 'bg-gray-100 text-gray-400') }}">
                                                {{ $pct }}%
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center py-10 text-gray-300 text-sm">Belum ada data siswa.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            {{-- ════════════════════════════════════════
                 PAGE: DATA NILAI
            ════════════════════════════════════════ --}}
            <div x-show="page === 'data-nilai'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0">

                <div class="flex items-center justify-between gap-4 mb-6 flex-wrap">
                    <h2 class="text-2xl font-extrabold text-gray-800">Data Nilai Siswa</h2>
                    <a href="{{ route('guru.export.nilai') }}"
                       class="inline-flex items-center gap-2 bg-violet-600 hover:bg-violet-700 active:scale-95
                              text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm shrink-0">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Export ke Excel (CSV)
                    </a>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-gray-500">
                                    <th class="text-left px-4 py-3 rounded-l-xl font-semibold text-xs uppercase tracking-wide">Nama</th>
                                    <th class="text-center px-4 py-3 font-semibold text-xs uppercase tracking-wide">Pretest</th>
                                    <th class="text-center px-4 py-3 font-semibold text-xs uppercase tracking-wide">Posttest</th>
                                    <th class="text-center px-4 py-3 font-semibold text-xs uppercase tracking-wide">Selisih</th>
                                    @foreach(['Fase 1','Fase 2','Fase 3','Fase 4','Fase 5'] as $f)
                                        <th class="text-center px-4 py-3 font-semibold text-xs uppercase tracking-wide {{ $loop->last ? 'rounded-r-xl' : '' }}">{{ $f }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($siswas as $siswa)
                                    @php
                                        $lp   = $siswa->learningProgress;
                                        $sc   = $siswa->score;
                                        $pre  = $sc?->pretest  ?? 0;
                                        $post = $sc?->posttest ?? 0;
                                        $gain = $post - $pre;
                                    @endphp
                                    <tr class="hover:bg-gray-50/70 transition">
                                        <td class="px-4 py-3 font-medium text-gray-800">{{ $siswa->name }}</td>
                                        <td class="px-4 py-3 text-center font-semibold text-indigo-600">{{ $pre }}</td>
                                        <td class="px-4 py-3 text-center font-semibold text-green-600">{{ $post }}</td>
                                        <td class="px-4 py-3 text-center font-semibold {{ $gain > 0 ? 'text-green-600' : ($gain < 0 ? 'text-red-400' : 'text-gray-400') }}">
                                            {{ $gain > 0 ? '+' : '' }}{{ $gain }}
                                        </td>
                                        @foreach(['fase1','fase2','fase3','fase4','fase5'] as $fase)
                                            <td class="px-4 py-3 text-center">
                                                @if($lp?->$fase)
                                                    <svg class="w-4 h-4 text-green-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                @else
                                                    <span class="text-gray-200 text-sm">–</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr><td colspan="9" class="text-center py-10 text-gray-300 text-sm">Belum ada data nilai.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            {{-- ════════════════════════════════════════
                 PAGE: KELOLA MATERI
            ════════════════════════════════════════ --}}
            <div x-show="page === 'materi'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-data="{
                     showModal: false,
                     editingMateri: null,
                     editData: { title:'', content:'', color:'green' },
                     openAdd() { this.editingMateri=null; this.editData={title:'',content:'',color:'green'}; this.showModal=true; },
                     openEdit(m) { this.editingMateri=m; this.editData={title:m.title,content:m.content||'',color:m.color}; this.showModal=true; },
                     closeModal() { this.showModal=false; },
                 }">

                {{-- Modal --}}
                <div x-show="showModal" x-cloak
                     class="fixed inset-0 z-50 bg-black/30 flex items-center justify-center p-4"
                     @keydown.escape.window="closeModal()">
                    <div class="bg-white rounded-xl shadow-lg w-full max-w-lg" @click.stop>

                        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                            <h3 class="text-sm font-semibold text-gray-800"
                                x-text="editingMateri ? 'Edit Materi' : 'Tambah Materi'"></h3>
                            <button @click="closeModal()" class="text-gray-400 hover:text-gray-600 transition text-lg leading-none">&times;</button>
                        </div>

                        {{-- ADD form --}}
                        <div x-show="!editingMateri" class="p-6">
                            <form method="POST" action="{{ route('guru.materi.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Judul Materi <span class="text-red-400">*</span></label>
                                    <input type="text" name="title" x-model="editData.title" required placeholder="Contoh: Enkapsulasi"
                                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-indigo-400 bg-white">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Isi Materi</label>
                                    <textarea name="content" x-model="editData.content" rows="5" placeholder="Tuliskan penjelasan materi..."
                                              class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-indigo-400 bg-white resize-none leading-relaxed"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Warna</label>
                                    <select name="color" x-model="editData.color"
                                            class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-indigo-400 bg-white">
                                        <option value="green">Hijau</option>
                                        <option value="blue">Biru</option>
                                        <option value="purple">Ungu</option>
                                        <option value="indigo">Indigo</option>
                                        <option value="amber">Kuning</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Link YouTube</label>
                                    <input type="url" name="video_url" placeholder="https://www.youtube.com/watch?v=..."
                                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-indigo-400 bg-white">
                                    <p class="text-[11px] text-gray-400 mt-1">Kalau diisi, ini yang akan ditampilkan (lebih diprioritaskan daripada upload file di bawah).</p>
                                </div>
                                <div class="mb-5">
                                    <label class="block text-xs font-medium text-gray-600 mb-1">atau Upload Video</label>
                                    <input type="file" name="video" accept="video/mp4,video/webm,video/ogg,video/quicktime"
                                           class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded file:border file:border-gray-200 file:text-xs file:font-medium file:bg-gray-50 file:text-gray-600 hover:file:bg-gray-100 file:transition cursor-pointer">
                                    <p class="text-[11px] text-gray-400 mt-1">MP4, WebM, MOV · Maks. 200 MB</p>
                                </div>
                                <div class="flex gap-2">
                                    <button type="submit"
                                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
                                        Simpan
                                    </button>
                                    <button type="button" @click="closeModal()"
                                            class="bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium px-4 py-2 rounded-lg transition">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- EDIT forms --}}
                        @foreach($materis as $m)
                        <div x-show="editingMateri && editingMateri.id === {{ $m->id }}" class="p-6">
                            <form method="POST" action="{{ route('guru.materi.update', $m) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Judul Materi <span class="text-red-400">*</span></label>
                                    <input type="text" name="title" x-model="editData.title" required
                                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-indigo-400 bg-white">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Isi Materi</label>
                                    <textarea name="content" x-model="editData.content" rows="5"
                                              class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-indigo-400 bg-white resize-none leading-relaxed"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Warna</label>
                                    <select name="color" x-model="editData.color"
                                            class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-indigo-400 bg-white">
                                        <option value="green">Hijau</option>
                                        <option value="blue">Biru</option>
                                        <option value="purple">Ungu</option>
                                        <option value="indigo">Indigo</option>
                                        <option value="amber">Kuning</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Link YouTube</label>
                                    <input type="url" name="video_url" value="{{ $m->video_url }}" placeholder="https://www.youtube.com/watch?v=..."
                                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-indigo-400 bg-white">
                                    <p class="text-[11px] text-gray-400 mt-1">Kalau diisi, ini yang akan ditampilkan (lebih diprioritaskan daripada upload file di bawah). Kosongkan untuk menghapus link YouTube.</p>
                                </div>
                                <div class="mb-5">
                                    <label class="block text-xs font-medium text-gray-600 mb-1">atau Upload Video</label>
                                    @if($m->video_path)
                                    <p class="text-xs text-gray-500 mb-1.5">Video saat ini: <span class="font-medium">{{ basename($m->video_path) }}</span></p>
                                    <label class="inline-flex items-center gap-1.5 text-xs text-gray-500 mb-2 cursor-pointer">
                                        <input type="checkbox" name="remove_video" value="1"> Hapus video yang ada
                                    </label><br>
                                    @endif
                                    <input type="file" name="video" accept="video/mp4,video/webm,video/ogg,video/quicktime"
                                           class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded file:border file:border-gray-200 file:text-xs file:font-medium file:bg-gray-50 file:text-gray-600 hover:file:bg-gray-100 file:transition cursor-pointer">
                                    <p class="text-[11px] text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti video. MP4, WebM, MOV · Maks. 200 MB</p>
                                </div>
                                <div class="flex gap-2">
                                    <button type="submit"
                                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
                                        Simpan
                                    </button>
                                    <button type="button" @click="closeModal()"
                                            class="bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium px-4 py-2 rounded-lg transition">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                        @endforeach

                    </div>
                </div>

                {{-- Header --}}
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-2xl font-extrabold text-gray-800">Kelola Materi</h2>
                    <button @click="openAdd()"
                            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Materi
                    </button>
                </div>

                @if(session('materi_success'))
                <div class="mb-4 text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg px-4 py-3">
                    {{ session('materi_success') }}
                </div>
                @endif

                {{-- Table --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-gray-500">
                                    <th class="text-left px-4 py-3 rounded-l-xl font-semibold text-xs uppercase tracking-wide w-10">No</th>
                                    <th class="text-left px-4 py-3 font-semibold text-xs uppercase tracking-wide">Judul</th>
                                    <th class="text-left px-4 py-3 font-semibold text-xs uppercase tracking-wide">Isi Materi</th>
                                    <th class="text-center px-4 py-3 font-semibold text-xs uppercase tracking-wide">Video</th>
                                    <th class="text-right px-4 py-3 rounded-r-xl font-semibold text-xs uppercase tracking-wide">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($materis as $i => $materi)
                                @php
                                    $dot = ['green'=>'bg-green-500','blue'=>'bg-blue-500','purple'=>'bg-purple-600','indigo'=>'bg-indigo-600','amber'=>'bg-amber-500'][$materi->color] ?? 'bg-gray-400';
                                @endphp
                                <tr class="hover:bg-gray-50/60 transition">
                                    <td class="px-4 py-3 text-gray-400">{{ $i + 1 }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full {{ $dot }} shrink-0"></span>
                                            <span class="font-medium text-gray-800">{{ $materi->title }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-gray-400 max-w-xs">
                                        @if($materi->content)
                                            <span class="line-clamp-2 text-xs leading-relaxed">{{ Str::limit(str_replace("\n"," ",$materi->content), 100) }}</span>
                                        @else
                                            <span class="text-xs italic">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if($materi->video_url)
                                            <span class="text-xs text-green-600 font-medium">YouTube</span>
                                        @elseif($materi->video_path)
                                            <span class="text-xs text-green-600 font-medium">Ada</span>
                                        @else
                                            <span class="text-xs text-gray-300">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="inline-flex items-center gap-3">
                                            <button @click="openEdit({ id: {{ $materi->id }}, title: {{ Js::from($materi->title) }}, content: {{ Js::from($materi->content ?? '') }}, color: '{{ $materi->color }}' })"
                                                    class="text-indigo-600 hover:text-indigo-800 text-xs font-medium transition">
                                                Edit
                                            </button>
                                            <form method="POST" action="{{ route('guru.materi.destroy', $materi) }}" onsubmit="return confirm('Hapus materi ini?')">
                                                @csrf
                                                <button type="submit" class="text-red-400 hover:text-red-600 text-xs font-medium transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-10 text-center text-gray-300 text-sm">
                                        Belum ada materi. Klik <span class="font-semibold text-indigo-500">Tambah Materi</span> untuk mulai menambahkan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            {{-- ════════════════════════════════════════
                 PAGE: AKUN GURU
            ════════════════════════════════════════ --}}
            <div x-show="page === 'akun'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0">

                <h2 class="text-2xl font-extrabold text-gray-800 mb-6">Akun Guru</h2>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 max-w-md">

                    <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-50">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=e0e7ff&color=4338ca&size=64"
                             class="w-14 h-14 rounded-2xl shrink-0" alt="avatar">
                        <div>
                            <p class="font-bold text-gray-900">{{ auth()->user()->name }}</p>
                            <span class="inline-block mt-1 bg-indigo-50 text-indigo-600 text-xs font-semibold px-2.5 py-1 rounded-full capitalize">
                                {{ auth()->user()->role }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <div>
                                <p class="text-[10px] text-gray-400 font-medium">Nama Lengkap</p>
                                <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <div>
                                <p class="text-[10px] text-gray-400 font-medium">Email</p>
                                <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            {{-- ════════════════════════════════════════
                 PAGE: KELOLA ASSESSMENT
            ════════════════════════════════════════ --}}
            <div x-show="page === 'assessment'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-data="{
                     tab: '{{ request('tab', 'pretest') }}',
                     editingId: null,
                     editData: {},
                     adding: false,
                     startEdit(q) { this.editingId = q.id; this.editData = Object.assign({}, q); this.adding = false; },
                     cancelEdit() { this.editingId = null; this.editData = {}; },
                 }">

                <h2 class="text-2xl font-extrabold text-gray-800 mb-6">Kelola Assessment</h2>

                @if(session('assessment_success'))
                <div class="mb-5 bg-green-50 border border-green-200 text-green-800 px-5 py-3.5 rounded-2xl text-sm font-semibold flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('assessment_success') }}
                </div>
                @endif

                {{-- Tab switcher --}}
                <div class="flex gap-2 mb-6 bg-gray-100 p-1 rounded-xl w-fit">
                    <button @click="tab='pretest'; adding=false; editingId=null"
                            class="px-5 py-2 rounded-lg text-sm font-semibold transition-all"
                            :class="tab==='pretest' ? 'bg-white text-indigo-700 shadow-sm' : 'text-gray-500 hover:text-gray-700'">
                        Pretest
                    </button>
                    <button @click="tab='posttest'; adding=false; editingId=null"
                            class="px-5 py-2 rounded-lg text-sm font-semibold transition-all"
                            :class="tab==='posttest' ? 'bg-white text-indigo-700 shadow-sm' : 'text-gray-500 hover:text-gray-700'">
                        Posttest
                    </button>
                </div>

                {{-- ── PRETEST TAB ── --}}
                <div x-show="tab==='pretest'">

                    {{-- Time limit --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-5 flex flex-wrap items-center gap-4">
                        <div class="flex items-center gap-2 shrink-0">
                            <div class="w-8 h-8 rounded-xl bg-indigo-50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Batas Waktu Pretest</span>
                        </div>
                        <form method="POST" action="{{ route('guru.assessment.settings') }}" class="flex items-center gap-3 flex-1 min-w-0">
                            @csrf
                            <input type="hidden" name="type" value="pretest">
                            <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 w-40">
                                <input type="number" name="time_limit" value="{{ $pretestTime }}" min="1" max="180"
                                       class="w-16 bg-transparent text-sm font-bold text-gray-800 outline-none">
                                <span class="text-xs text-gray-400 shrink-0">menit</span>
                            </div>
                            <button type="submit"
                                    class="inline-flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition active:scale-95">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan
                            </button>
                        </form>
                    </div>

                    {{-- Questions list --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-5">
                        <div class="px-5 pt-5 pb-3 border-b border-gray-50">
                            <p class="text-sm font-bold text-gray-700">Daftar Soal Pretest
                                <span class="ml-2 text-xs font-semibold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full">{{ $pretestQuestions->count() }} soal</span>
                            </p>
                        </div>

                        @forelse($pretestQuestions as $q)
                        <div class="border-b border-gray-50 last:border-0">
                            {{-- View row --}}
                            <div class="px-5 py-4 flex items-start gap-4" x-show="editingId !== {{ $q->id }}">
                                <span class="w-7 h-7 rounded-lg bg-indigo-50 text-indigo-600 text-xs font-black flex items-center justify-center shrink-0 mt-0.5">{{ $q->number }}</span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 mb-2 leading-snug">{{ $q->question }}</p>
                                    <div class="grid grid-cols-2 gap-x-6 gap-y-0.5">
                                        @foreach(['A' => $q->option_a, 'B' => $q->option_b, 'C' => $q->option_c, 'D' => $q->option_d] as $key => $opt)
                                        <span class="text-xs {{ $q->answer === $key ? 'text-green-700 font-bold' : 'text-gray-500' }}">
                                            @if($q->answer === $key)
                                            <span class="inline-block w-4 h-4 rounded-full bg-green-500 text-white text-[9px] font-black text-center leading-4 mr-1">{{ $key }}</span>
                                            @else
                                            <span class="inline-block w-4 h-4 rounded-full border border-gray-300 text-gray-400 text-[9px] font-bold text-center leading-[14px] mr-1">{{ $key }}</span>
                                            @endif
                                            {{ $opt }}
                                        </span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <button @click="startEdit({ id: {{ $q->id }}, question: {{ Js::from($q->question) }}, option_a: {{ Js::from($q->option_a) }}, option_b: {{ Js::from($q->option_b) }}, option_c: {{ Js::from($q->option_c) }}, option_d: {{ Js::from($q->option_d) }}, answer: '{{ $q->answer }}' }); adding=false"
                                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('guru.assessment.destroy', $q) }}" onsubmit="return confirm('Hapus soal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-500 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- Inline edit form --}}
                            <div class="px-5 py-4 bg-indigo-50/40 border-t border-indigo-100" x-show="editingId === {{ $q->id }}" x-cloak>
                                <form method="POST" action="{{ route('guru.assessment.update', $q) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Pertanyaan</label>
                                            <input type="text" name="question" x-model="editData.question"
                                                   class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm bg-white outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition">
                                        </div>
                                        <div class="grid grid-cols-2 gap-3">
                                            @foreach(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D'] as $lc => $uc)
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-600 mb-1">Pilihan {{ $uc }}</label>
                                                <input type="text" name="option_{{ $lc }}" x-model="editData.option_{{ $lc }}"
                                                       class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm bg-white outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition">
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-600 mb-1">Kunci Jawaban</label>
                                                <select name="answer" x-model="editData.answer"
                                                        class="px-3 py-2 rounded-xl border border-gray-200 text-sm bg-white outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition font-bold">
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                </select>
                                            </div>
                                            <div class="flex gap-2 mt-5">
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition active:scale-95">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                    Simpan
                                                </button>
                                                <button type="button" @click="cancelEdit()"
                                                        class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold px-4 py-2 rounded-xl transition">
                                                    Batal
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @empty
                        <div class="px-5 py-10 text-center text-gray-300 text-sm">Belum ada soal. Tambahkan soal pertama.</div>
                        @endforelse
                    </div>

                    {{-- Add question --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                        <button @click="adding=!adding; editingId=null"
                                class="w-full flex items-center gap-2.5 px-5 py-4 text-sm font-semibold text-indigo-600 hover:bg-indigo-50 transition rounded-2xl">
                            <svg class="w-4 h-4 transition-transform" :class="adding ? 'rotate-45' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span x-text="adding ? 'Batal Tambah Soal' : '+ Tambah Soal Pretest'"></span>
                        </button>
                        <div x-show="adding" x-cloak class="px-5 pb-5 border-t border-gray-50">
                            <form method="POST" action="{{ route('guru.assessment.store') }}" class="pt-4 space-y-3">
                                @csrf
                                <input type="hidden" name="type" value="pretest">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Pertanyaan</label>
                                    <input type="text" name="question" required placeholder="Tulis pertanyaan di sini..."
                                           class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm bg-gray-50 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition">
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    @foreach(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D'] as $lc => $uc)
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Pilihan {{ $uc }}</label>
                                        <input type="text" name="option_{{ $lc }}" required placeholder="Pilihan {{ $uc }}"
                                               class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm bg-gray-50 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition">
                                    </div>
                                    @endforeach
                                </div>
                                <div class="flex items-center gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Kunci Jawaban</label>
                                        <select name="answer" required
                                                class="px-3 py-2 rounded-xl border border-gray-200 text-sm bg-gray-50 outline-none focus:bg-white focus:border-indigo-400 transition font-bold">
                                            <option value="">Pilih...</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="mt-5 inline-flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-5 py-2 rounded-xl transition active:scale-95">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                        Tambah Soal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>{{-- end pretest tab --}}

                {{-- ── POSTTEST TAB ── --}}
                <div x-show="tab==='posttest'">

                    {{-- Time limit --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-5 flex flex-wrap items-center gap-4">
                        <div class="flex items-center gap-2 shrink-0">
                            <div class="w-8 h-8 rounded-xl bg-green-50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Batas Waktu Posttest</span>
                        </div>
                        <form method="POST" action="{{ route('guru.assessment.settings') }}" class="flex items-center gap-3 flex-1 min-w-0">
                            @csrf
                            <input type="hidden" name="type" value="posttest">
                            <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 w-40">
                                <input type="number" name="time_limit" value="{{ $posttestTime }}" min="1" max="180"
                                       class="w-16 bg-transparent text-sm font-bold text-gray-800 outline-none">
                                <span class="text-xs text-gray-400 shrink-0">menit</span>
                            </div>
                            <button type="submit"
                                    class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition active:scale-95">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan
                            </button>
                        </form>
                    </div>

                    {{-- Questions list --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-5">
                        <div class="px-5 pt-5 pb-3 border-b border-gray-50">
                            <p class="text-sm font-bold text-gray-700">Daftar Soal Posttest
                                <span class="ml-2 text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">{{ $posttestQuestions->count() }} soal</span>
                            </p>
                        </div>

                        @forelse($posttestQuestions as $q)
                        <div class="border-b border-gray-50 last:border-0">
                            {{-- View row --}}
                            <div class="px-5 py-4 flex items-start gap-4" x-show="editingId !== {{ $q->id }}">
                                <span class="w-7 h-7 rounded-lg bg-green-50 text-green-700 text-xs font-black flex items-center justify-center shrink-0 mt-0.5">{{ $q->number }}</span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 mb-2 leading-snug">{{ $q->question }}</p>
                                    <div class="grid grid-cols-2 gap-x-6 gap-y-0.5">
                                        @foreach(['A' => $q->option_a, 'B' => $q->option_b, 'C' => $q->option_c, 'D' => $q->option_d] as $key => $opt)
                                        <span class="text-xs {{ $q->answer === $key ? 'text-green-700 font-bold' : 'text-gray-500' }}">
                                            @if($q->answer === $key)
                                            <span class="inline-block w-4 h-4 rounded-full bg-green-500 text-white text-[9px] font-black text-center leading-4 mr-1">{{ $key }}</span>
                                            @else
                                            <span class="inline-block w-4 h-4 rounded-full border border-gray-300 text-gray-400 text-[9px] font-bold text-center leading-[14px] mr-1">{{ $key }}</span>
                                            @endif
                                            {{ $opt }}
                                        </span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <button @click="startEdit({ id: {{ $q->id }}, question: {{ Js::from($q->question) }}, option_a: {{ Js::from($q->option_a) }}, option_b: {{ Js::from($q->option_b) }}, option_c: {{ Js::from($q->option_c) }}, option_d: {{ Js::from($q->option_d) }}, answer: '{{ $q->answer }}' }); adding=false"
                                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-green-700 bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-lg transition">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('guru.assessment.destroy', $q) }}" onsubmit="return confirm('Hapus soal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-500 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- Inline edit form --}}
                            <div class="px-5 py-4 bg-green-50/40 border-t border-green-100" x-show="editingId === {{ $q->id }}" x-cloak>
                                <form method="POST" action="{{ route('guru.assessment.update', $q) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Pertanyaan</label>
                                            <input type="text" name="question" x-model="editData.question"
                                                   class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm bg-white outline-none focus:border-green-400 focus:ring-2 focus:ring-green-100 transition">
                                        </div>
                                        <div class="grid grid-cols-2 gap-3">
                                            @foreach(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D'] as $lc => $uc)
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-600 mb-1">Pilihan {{ $uc }}</label>
                                                <input type="text" name="option_{{ $lc }}" x-model="editData.option_{{ $lc }}"
                                                       class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm bg-white outline-none focus:border-green-400 focus:ring-2 focus:ring-green-100 transition">
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-600 mb-1">Kunci Jawaban</label>
                                                <select name="answer" x-model="editData.answer"
                                                        class="px-3 py-2 rounded-xl border border-gray-200 text-sm bg-white outline-none focus:border-green-400 focus:ring-2 focus:ring-green-100 transition font-bold">
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                </select>
                                            </div>
                                            <div class="flex gap-2 mt-5">
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition active:scale-95">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                    Simpan
                                                </button>
                                                <button type="button" @click="cancelEdit()"
                                                        class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold px-4 py-2 rounded-xl transition">
                                                    Batal
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @empty
                        <div class="px-5 py-10 text-center text-gray-300 text-sm">Belum ada soal. Tambahkan soal pertama.</div>
                        @endforelse
                    </div>

                    {{-- Add question --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                        <button @click="adding=!adding; editingId=null"
                                class="w-full flex items-center gap-2.5 px-5 py-4 text-sm font-semibold text-green-700 hover:bg-green-50 transition rounded-2xl">
                            <svg class="w-4 h-4 transition-transform" :class="adding ? 'rotate-45' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span x-text="adding ? 'Batal Tambah Soal' : '+ Tambah Soal Posttest'"></span>
                        </button>
                        <div x-show="adding" x-cloak class="px-5 pb-5 border-t border-gray-50">
                            <form method="POST" action="{{ route('guru.assessment.store') }}" class="pt-4 space-y-3">
                                @csrf
                                <input type="hidden" name="type" value="posttest">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Pertanyaan</label>
                                    <input type="text" name="question" required placeholder="Tulis pertanyaan di sini..."
                                           class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm bg-gray-50 outline-none focus:bg-white focus:border-green-400 focus:ring-2 focus:ring-green-100 transition">
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    @foreach(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D'] as $lc => $uc)
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Pilihan {{ $uc }}</label>
                                        <input type="text" name="option_{{ $lc }}" required placeholder="Pilihan {{ $uc }}"
                                               class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm bg-gray-50 outline-none focus:bg-white focus:border-green-400 focus:ring-2 focus:ring-green-100 transition">
                                    </div>
                                    @endforeach
                                </div>
                                <div class="flex items-center gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Kunci Jawaban</label>
                                        <select name="answer" required
                                                class="px-3 py-2 rounded-xl border border-gray-200 text-sm bg-gray-50 outline-none focus:bg-white focus:border-green-400 transition font-bold">
                                            <option value="">Pilih...</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="mt-5 inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-5 py-2 rounded-xl transition active:scale-95">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                        Tambah Soal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>{{-- end posttest tab --}}

            </div>{{-- end assessment page --}}

        </div>{{-- end content area --}}

    </main>

</div>

<script>
    function buildGuruTour() {
        return window.driver.js.driver({
            showProgress: true,
            nextBtnText: 'Lanjut',
            prevBtnText: 'Kembali',
            doneBtnText: 'Selesai',
            steps: [
                { element: '#tour-stats', popover: {
                    title: '📊 Statistik Ringkas',
                    description: 'Ringkasan performa seluruh siswa: total siswa, progress rata-rata, dan yang sudah selesai belajar.',
                    side: 'bottom' } },
                { element: '#tour-siswa-list', popover: {
                    title: '📋 Ringkasan Progress Siswa',
                    description: 'Lihat progress belajar tiap siswa secara individual di sini.',
                    side: 'top' } },
                { element: '#tour-menu-data-siswa', popover: {
                    title: '👥 Data Siswa',
                    description: 'Lihat detail semua siswa dalam bentuk tabel.',
                    side: 'right' } },
                { element: '#tour-menu-data-nilai', popover: {
                    title: '📈 Data Nilai',
                    description: 'Pantau nilai pretest, posttest, dan gain tiap siswa — bisa juga di-export ke Excel/CSV.',
                    side: 'right' } },
                { element: '#tour-menu-materi', popover: {
                    title: '📖 Kelola Materi',
                    description: 'Tambah atau ubah materi pembelajaran OOP di sini.',
                    side: 'right' } },
                { element: '#tour-menu-assessment', popover: {
                    title: '📝 Kelola Assessment',
                    description: 'Atur soal pretest/posttest dan batas waktu pengerjaan.',
                    side: 'right' } },
                { element: '#tour-menu-akun', popover: {
                    title: '👤 Akun Guru',
                    description: 'Kelola profil akun kamu di sini.',
                    side: 'right' } },
            ],
            onDestroyed: () => markTourSeen(),
        });
    }

    function markTourSeen() {
        fetch("{{ route('tour.complete') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
        });
    }

    function startTour() {
        buildGuruTour().drive();
    }

    @if(!auth()->user()->has_seen_tour)
    document.addEventListener('DOMContentLoaded', () => startTour());
    @endif
</script>

</body>
</html>
