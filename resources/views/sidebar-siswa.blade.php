{{-- Mobile backdrop --}}
<div x-show="sidebarOpen" x-cloak
     @click="sidebarOpen = false"
     class="fixed inset-0 bg-gray-900/40 z-40 lg:hidden"
     x-transition:enter="transition-opacity duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
</div>

<aside @toggle-sidebar.window="sidebarOpen = !sidebarOpen"
       :class="{
           'translate-x-0 shadow-xl lg:shadow-none': sidebarOpen,
           '-translate-x-full lg:translate-x-0 lg:w-[3.75rem]': !sidebarOpen
       }"
       class="fixed lg:sticky top-0 h-screen z-50 lg:z-auto w-60
              bg-white border-r border-gray-100 flex flex-col
              transition-all duration-300 ease-in-out overflow-hidden">

    {{-- Brand --}}
    <div class="flex items-center h-14 px-3 border-b border-gray-100 shrink-0 gap-2.5">
        <div class="w-8 h-8 rounded-lg bg-green-600 flex items-center justify-center shrink-0">
            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
        </div>
        <div x-show="sidebarOpen" x-cloak class="min-w-0 flex-1"
             x-transition:enter="transition-opacity duration-150 delay-75"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100">
            <p class="font-bold text-gray-900 text-sm leading-tight truncate">OOP Learn</p>
            <p class="text-[10px] text-gray-400 leading-none truncate">Media Pembelajaran</p>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-2 py-3 space-y-0.5 overflow-y-auto overflow-x-hidden">

        @php
        $navItems = [
            [
                'route'  => 'dashboard.siswa',
                'routes' => ['dashboard.siswa'],
                'label'  => 'Dashboard',
                'icon'   => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
            ],
            [
                'route'  => 'informasi',
                'routes' => ['informasi'],
                'label'  => 'Informasi',
                'icon'   => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            ],
            [
                'route'  => 'assessment',
                'routes' => ['assessment', 'pretest', 'posttest'],
                'label'  => 'Assessment',
                'icon'   => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4',
                'tourId' => 'tour-nav-assessment',
            ],
            [
                'route'  => 'lesson',
                'routes' => ['lesson'],
                'label'  => 'Materi',
                'icon'   => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                'tourId' => 'tour-nav-materi',
            ],

        ];
        @endphp

        @foreach($navItems as $item)
            @php $active = request()->routeIs(...$item['routes']); @endphp
            <a href="{{ route($item['route']) }}"
               id="{{ $item['tourId'] ?? '' }}"
               class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-sm font-medium transition-all duration-150 group
                      {{ $active
                          ? 'bg-green-50 text-green-700'
                          : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
               :class="sidebarOpen ? '' : 'justify-center px-0'"
               title="{{ $item['label'] }}">
                <svg class="w-4 h-4 shrink-0 {{ $active ? 'text-green-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                </svg>
                <span x-show="sidebarOpen" x-cloak class="truncate flex-1 text-[13px]">{{ $item['label'] }}</span>
                @if($active)
                <span x-show="sidebarOpen" x-cloak class="w-1 h-1 rounded-full bg-green-500 shrink-0"></span>
                @endif
            </a>
        @endforeach

        {{-- Activity collapsible (3 Pertemuan) --}}
        @php
            $anyP1  = request()->routeIs('fase1','fase2','fase3','fase4','fase5');
            $anyP2  = request()->routeIs('p2.fase1','p2.fase2','p2.fase3','p2.fase4','p2.fase5');
            $anyP3  = request()->routeIs('p3.fase1','p3.fase2','p3.fase3','p3.fase4','p3.fase5');
            $anyAct = $anyP1 || $anyP2 || $anyP3;
        @endphp
        <details {{ $anyAct ? 'open' : '' }} class="group/act">
            <summary id="tour-nav-activity"
                     class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-sm font-medium cursor-pointer list-none transition-all duration-150
                            {{ $anyAct ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                     :class="sidebarOpen ? '' : 'justify-center px-0'"
                     title="Activity">
                <svg class="w-4 h-4 shrink-0 {{ $anyAct ? 'text-green-600' : 'text-gray-400' }}"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                <span x-show="sidebarOpen" x-cloak class="flex-1 text-[13px] truncate">Activity</span>
                <svg x-show="sidebarOpen" x-cloak
                     class="w-3 h-3 text-gray-400 shrink-0 transition-transform duration-200 group-open/act:rotate-90"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </summary>

            {{-- Pertemuan list --}}
            <div x-show="sidebarOpen" x-cloak class="mt-0.5 ml-5 space-y-0.5 pr-1">

                {{-- ── Pertemuan 1: Enkapsulasi ── --}}
                <details {{ $anyP1 ? 'open' : '' }} class="group/p1">
                    <summary class="flex items-center gap-2 px-2 py-1.5 rounded-lg text-[12px] font-semibold cursor-pointer list-none transition
                                    {{ $anyP1 ? 'text-green-700' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50' }}">
                        <svg class="w-3 h-3 flex-shrink-0 transition-transform duration-150 group-open/p1:rotate-90
                                    {{ $anyP1 ? 'text-green-500' : 'text-gray-400' }}"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                        <span class="flex-1">Pertemuan 1</span>
                        <span class="text-[10px] font-medium {{ $anyP1 ? 'text-green-500' : 'text-gray-400' }}">Enkapsulasi</span>
                    </summary>
                    <div class="mt-0.5 ml-4 space-y-0.5">
                        @foreach([
                            ['fase1','Fase 1 – Orientasi'],
                            ['fase2','Fase 2 – Pencetusan Ide'],
                            ['fase3','Fase 3 – Penstrukturan'],
                            ['fase4','Fase 4 – Aplikasi'],
                            ['fase5','Fase 5 – Refleksi'],
                        ] as [$r, $l])
                        <a href="{{ route($r) }}"
                           class="flex items-center gap-1.5 text-[11.5px] py-1 px-2 rounded-lg transition truncate
                                  {{ request()->routeIs($r)
                                      ? 'bg-green-50 text-green-700 font-semibold'
                                      : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }}">
                            <span class="w-1 h-1 rounded-full flex-shrink-0
                                         {{ request()->routeIs($r) ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                            {{ $l }}
                        </a>
                        @endforeach
                    </div>
                </details>

                {{-- ── Pertemuan 2: Inheritance ── --}}
                <details {{ $anyP2 ? 'open' : '' }} class="group/p2">
                    <summary class="flex items-center gap-2 px-2 py-1.5 rounded-lg text-[12px] font-semibold cursor-pointer list-none transition
                                    {{ $anyP2 ? 'text-blue-700' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50' }}">
                        <svg class="w-3 h-3 flex-shrink-0 transition-transform duration-150 group-open/p2:rotate-90
                                    {{ $anyP2 ? 'text-blue-500' : 'text-gray-400' }}"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                        <span class="flex-1">Pertemuan 2</span>
                        <span class="text-[10px] font-medium {{ $anyP2 ? 'text-blue-500' : 'text-gray-400' }}">Inheritance</span>
                    </summary>
                    <div class="mt-0.5 ml-4 space-y-0.5">
                        @foreach([
                            ['p2.fase1','Fase 1 – Orientasi'],
                            ['p2.fase2','Fase 2 – Pencetusan Ide'],
                            ['p2.fase3','Fase 3 – Penstrukturan'],
                            ['p2.fase4','Fase 4 – Aplikasi'],
                            ['p2.fase5','Fase 5 – Refleksi'],
                        ] as [$r, $l])
                        <a href="{{ route($r) }}"
                           class="flex items-center gap-1.5 text-[11.5px] py-1 px-2 rounded-lg transition truncate
                                  {{ request()->routeIs($r)
                                      ? 'bg-blue-50 text-blue-700 font-semibold'
                                      : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }}">
                            <span class="w-1 h-1 rounded-full flex-shrink-0
                                         {{ request()->routeIs($r) ? 'bg-blue-500' : 'bg-gray-300' }}"></span>
                            {{ $l }}
                        </a>
                        @endforeach
                    </div>
                </details>

                {{-- ── Pertemuan 3: Polymorphism ── --}}
                <details {{ $anyP3 ? 'open' : '' }} class="group/p3">
                    <summary class="flex items-center gap-2 px-2 py-1.5 rounded-lg text-[12px] font-semibold cursor-pointer list-none transition
                                    {{ $anyP3 ? 'text-purple-700' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50' }}">
                        <svg class="w-3 h-3 flex-shrink-0 transition-transform duration-150 group-open/p3:rotate-90
                                    {{ $anyP3 ? 'text-purple-500' : 'text-gray-400' }}"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                        <span class="flex-1">Pertemuan 3</span>
                        <span class="text-[10px] font-medium {{ $anyP3 ? 'text-purple-500' : 'text-gray-400' }}">Enkapsulasi & Inheritance</span>
                    </summary>
                    <div class="mt-0.5 ml-4 space-y-0.5">
                        @foreach([
                            ['p3.fase1','Fase 1 – Orientasi'],
                            ['p3.fase2','Fase 2 – Pencetusan Ide'],
                            ['p3.fase3','Fase 3 – Penstrukturan'],
                            ['p3.fase4','Fase 4 – Aplikasi'],
                            ['p3.fase5','Fase 5 – Refleksi'],
                        ] as [$r, $l])
                        <a href="{{ route($r) }}"
                           class="flex items-center gap-1.5 text-[11.5px] py-1 px-2 rounded-lg transition truncate
                                  {{ request()->routeIs($r)
                                      ? 'bg-purple-50 text-purple-700 font-semibold'
                                      : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }}">
                            <span class="w-1 h-1 rounded-full flex-shrink-0
                                         {{ request()->routeIs($r) ? 'bg-purple-500' : 'bg-gray-300' }}"></span>
                            {{ $l }}
                        </a>
                        @endforeach
                    </div>
                </details>

            </div>
        </details>

        {{-- Hasil Belajar --}}
        @php $gradeActive = request()->routeIs('grade'); @endphp
        <a href="{{ route('grade') }}"
           id="tour-nav-grade"
           class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-sm font-medium transition-all duration-150 group
                  {{ $gradeActive ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
           :class="sidebarOpen ? '' : 'justify-center px-0'"
           title="Hasil Belajar">
            <svg class="w-4 h-4 shrink-0 {{ $gradeActive ? 'text-green-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <span x-show="sidebarOpen" x-cloak class="truncate flex-1 text-[13px]">Hasil Belajar</span>
            @if($gradeActive)
            <span x-show="sidebarOpen" x-cloak class="w-1 h-1 rounded-full bg-green-500 shrink-0"></span>
            @endif
        </a>

    </nav>

    {{-- User + Logout --}}
    <div class="border-t border-gray-100 px-2 py-2.5 shrink-0 space-y-0.5">
        <a href="{{ route('profil') }}" x-show="sidebarOpen" x-cloak
           class="flex items-center gap-2 px-2.5 py-2 rounded-lg group hover:bg-gray-50 transition {{ request()->routeIs('profil') ? 'bg-green-50' : '' }}">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'S') }}&background=dcfce7&color=166534&size=28"
                 class="w-7 h-7 rounded-full shrink-0" alt="avatar">
            <div class="min-w-0 flex-1">
                <p class="text-[12px] font-semibold truncate leading-tight {{ request()->routeIs('profil') ? 'text-green-700' : 'text-gray-800 group-hover:text-gray-900' }}">{{ auth()->user()->name ?? 'Siswa' }}</p>
                <p class="text-[10px] text-gray-400 truncate leading-tight">{{ auth()->user()->email ?? '' }}</p>
            </div>
            <svg class="w-3 h-3 text-gray-300 group-hover:text-gray-500 shrink-0 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-[13px] font-medium text-gray-500 hover:bg-red-50 hover:text-red-600 transition group"
                    :class="sidebarOpen ? '' : 'justify-center px-0'"
                    title="Keluar">
                <svg class="w-4 h-4 shrink-0 group-hover:text-red-500"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span x-show="sidebarOpen" x-cloak>Keluar</span>
            </button>
        </form>
    </div>

</aside>
