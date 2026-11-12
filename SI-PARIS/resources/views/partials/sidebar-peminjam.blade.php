{{-- Menu peminjam (siswa & guru). Menu fitur yang dimatikan petugas otomatis disembunyikan. --}}

<div class="flex flex-col gap-8">

<x-nav-link href="{{ route('peminjam.dashboard') }}" :active="request()->routeIs('peminjam.dashboard')">
    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
    Dashboard
</x-nav-link>

@if(\App\Support\FiturAkses::aktif('Histori Peminjaman'))
<x-nav-link href="{{ route('peminjam.histori') }}" :active="request()->routeIs('peminjam.histori')">
    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    Histori Peminjaman
</x-nav-link>
@endif

@if(\App\Support\FiturAkses::aktif('Peminjaman Alat'))
<x-nav-link href="{{ route('peminjam.peminjaman') }}" :active="request()->routeIs('peminjam.peminjaman*')">
    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
    Peminjaman Alat
</x-nav-link>
@endif

@if(\App\Support\FiturAkses::adaYangAktif('Pengembalian Barang', 'Laporan'))
<x-nav-link href="{{ route('peminjam.laporan') }}" :active="request()->routeIs('peminjam.laporan')">
    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
    Pengembalian / Laporan Kendala
</x-nav-link>
@endif
</div>