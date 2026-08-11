@props(['completeRoute', 'label' => 'Lanjut', 'warna' => 'green'])

@php
$colorClasses = match ($warna) {
    'blue'   => 'btn-pulse-blue bg-blue-600 hover:bg-blue-700',
    'purple' => 'btn-pulse-purple bg-purple-600 hover:bg-purple-700',
    default  => 'btn-pulse bg-green-600 hover:bg-green-700',
};
@endphp

<!-- PENTING: Partial ini WAJIB dipakai untuk semua tombol "Lanjut" antar-fase. JANGAN tulis ulang manual pakai <a href> — itu sudah menyebabkan bug penguncian siswa berulang kali (9 kejadian tercatat). Semua perubahan navigasi antar-fase HARUS lewat partial ini. -->
<div class="absolute bottom-8 right-8">
    <form method="POST" action="{{ route($completeRoute) }}">
        @csrf
        <button type="submit"
                class="{{ $colorClasses }} inline-flex items-center gap-2 text-white px-6 py-2.5 rounded-xl font-semibold text-sm transition shadow-sm">
            {{ $label }}
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </button>
    </form>
</div>
