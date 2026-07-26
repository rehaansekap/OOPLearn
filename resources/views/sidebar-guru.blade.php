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
        <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center shrink-0">
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
            <p class="text-[10px] text-gray-400 leading-none truncate">Panel Guru</p>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-2 py-3 space-y-0.5 overflow-y-auto overflow-x-hidden">

        @php
        $menuItems = [
            ['key' => 'dashboard',  'label' => 'Dashboard',
             'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
            ['key' => 'data-siswa', 'label' => 'Data Siswa',
             'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
            ['key' => 'assessment', 'label' => 'Kelola Assessment',
             'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'],
            ['key' => 'data-nilai', 'label' => 'Data Nilai',
             'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
            ['key' => 'materi',     'label' => 'Kelola Materi',
             'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
            ['key' => 'akun',       'label' => 'Akun Guru',
             'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
        ];
        @endphp

        @foreach($menuItems as $item)
        <button @click="page = '{{ $item['key'] }}'; if(window.innerWidth < 1024) sidebarOpen = false"
                id="tour-menu-{{ $item['key'] }}"
                class="w-full flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-[13px] font-medium transition-all group"
                :class="[
                    sidebarOpen ? '' : 'justify-center px-0',
                    page === '{{ $item['key'] }}'
                        ? 'bg-indigo-50 text-indigo-700'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
                ]"
                :title="sidebarOpen ? '' : '{{ $item['label'] }}'">
            <svg class="w-4 h-4 shrink-0 transition-colors"
                 :class="page === '{{ $item['key'] }}' ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-600'"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
            </svg>
            <span x-show="sidebarOpen" x-cloak class="flex-1 text-left truncate">{{ $item['label'] }}</span>
            <span x-show="sidebarOpen && page === '{{ $item['key'] }}'" x-cloak
                  class="w-1 h-1 rounded-full bg-indigo-500 shrink-0"></span>
        </button>
        @endforeach

    </nav>

    {{-- User + Logout --}}
    <div class="border-t border-gray-100 px-2 py-2.5 shrink-0 space-y-0.5">
        <div x-show="sidebarOpen" x-cloak
             class="flex items-center gap-2 px-2.5 py-2 rounded-lg">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'G') }}&background=e0e7ff&color=4338ca&size=28"
                 class="w-7 h-7 rounded-full shrink-0" alt="avatar">
            <div class="min-w-0 flex-1">
                <p class="text-[12px] font-semibold text-gray-800 truncate leading-tight">{{ auth()->user()->name ?? 'Guru' }}</p>
                <p class="text-[10px] text-gray-400 truncate leading-tight">{{ auth()->user()->email ?? '' }}</p>
            </div>
        </div>
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
