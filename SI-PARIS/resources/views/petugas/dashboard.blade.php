@extends('layouts.dashboard')

@section('title', 'Dashboard Petugas')
@section('page-title', 'Dashboard')

@section('content')

<div class="space-y-6">

    {{-- HEADER SELAMAT DATANG --}}
     <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800">Halo, {{ explode(' ', auth()->user()->nama_lengkap)[0] }}! 👋</h2>
        <p class="text-gray-500 text-sm">Kelola peminjaman alat / inventaris dari siswa dan guru.</p>
    </div>

    {{-- STATISTIK UTAMA --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

        <div class="bg-blue-100 rounded-2xl p-5 border border-blue-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-2xl font-bold text-blue-700">
                        {{ $totalSiswa }}
                    </p>
                    <p class="text-xs text-blue-800 mt-1">Total Siswa</p>
                </div>
            </div>
        </div>

        <div class="bg-blue-100 rounded-2xl p-5 border border-blue-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-2xl font-bold text-blue-700">
                        {{ $totalGuru }}
                    </p>
                    <p class="text-xs text-blue-800 mt-1">Total Guru</p>
                </div>
            </div>
        </div>

        <div class="bg-blue-100 rounded-2xl p-5 border border-blue-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-2xl font-bold text-blue-700">
                        {{ $totalPeminjaman }}
                    </p>
                    <p class="text-xs text-blue-800 mt-1">Total Peminjaman</p>
                </div>
            </div>
        </div>

        <div class="bg-sky-100 rounded-2xl p-5 border border-sky-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-2xl font-bold text-sky-700">
                        {{ $totalBarang }}
                    </p>
                    <p class="text-xs text-sky-800 mt-1">Total Barang</p>
                </div>
            </div>
        </div>

    </div>


    {{-- STATISTIK TAMBAHAN --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

        @if(\App\Support\FiturAkses::aktif('Notifikasi Petugas'))
        <a href="{{ route('petugas.notifikasi') }}"
           class="bg-white hover:bg-blue-100 rounded-2xl p-5 border border-blue-200 shadow-sm hover:shadow-md transition">
            <p class="text-2xl font-bold text-blue-600">
                {{ $menungguAcc }}
            </p>
            <p class="text-xs text-gray-600 mt-1">🔔 Menunggu ACC</p>
        </a>
        @endif

        @if(\App\Support\FiturAkses::aktif('Notifikasi Petugas'))
        <a href="{{ route('petugas.notifikasi.laporan') }}"
           class="bg-white hover:bg-blue-100 rounded-2xl p-5 border border-blue-200 shadow-sm hover:shadow-md transition">
            <p class="text-2xl font-bold text-blue-600">
                {{ $laporanMenunggu }}
            </p>
            <p class="text-xs text-gray-600 mt-1">📄 Laporan Belum Diproses</p>
        </a>
        @endif

        @if(\App\Support\FiturAkses::aktif('Rekap Barang'))
        <a href="{{ route('petugas.rekap', ['tab' => 'dikembalikan']) }}"
           class="bg-white hover:bg-blue-100 rounded-2xl p-5 border border-blue-200 shadow-sm hover:shadow-md transition">
            <p class="text-2xl font-bold text-emerald-600">
                {{ $totalDikembalikan }}
            </p>
            <p class="text-xs text-gray-600 mt-1">✅ Barang Dikembalikan</p>
        </a>
        @endif

        @if(\App\Support\FiturAkses::aktif('Rekap Barang'))
        <a href="{{ route('petugas.rekap', ['tab' => 'rusak']) }}"
           class="bg-white hover:bg-sky-100 rounded-2xl p-5 border border-sky-200 shadow-sm hover:shadow-md transition">
            <p class="text-2xl font-bold text-sky-600">
                {{ $totalRusak }}
            </p>
            <p class="text-xs text-gray-600 mt-1">⚠️ Barang Rusak</p>
        </a>
        @endif

    </div>


    {{-- NOTIFIKASI, AKTIVITAS DAN PENGINGAT --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- NOTIFIKASI TERBARU --}}
        @if(\App\Support\FiturAkses::aktif('Notifikasi Petugas'))
        <div class="bg-blue-50 rounded-2xl border border-blue-200 shadow-sm overflow-hidden">

            <div class="flex items-center justify-between p-5 bg-blue-200/70 border-b border-blue-200">
                <h3 class="font-bold text-blue-900 text-lg">Notifikasi Terbaru</h3>
                <a href="{{ route('petugas.notifikasi') }}"
                   class="text-xs font-semibold text-blue-700 bg-white px-4 py-2 rounded-full hover:bg-blue-100 transition">
                    Lihat Semua →
                </a>
            </div>

            <div class="p-5 space-y-3">
                @forelse($notifBaru as $n)
                <a href="{{ $n->jenis === 'laporan' ? route('petugas.notifikasi.laporan') : route('petugas.acc.show', $n->ref_id) }}"
                   class="block bg-white border border-blue-100 rounded-xl p-4 hover:bg-blue-100 hover:border-blue-300 transition">

                    <div class="flex gap-3 items-start">
                        <div class="bg-blue-100 rounded-full p-3 text-xl">
                            📢
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-blue-950">
                                {{ $n->judul }}
                            </p>
                            <p class="text-xs text-gray-600 mt-1">
                                {{ $n->pesan }}
                            </p>
                            <p class="text-xs text-blue-500 mt-2">
                                🕒 {{ $n->created_at->copy()->timezone('Asia/Jakarta')->format('d M Y, H:i:s') }} WIB
                            </p>
                        </div>
                    </div>
                </a>

                @empty

                <div class="text-center py-8">
                    <p class="text-sm text-blue-500 mt-2">
                        Tidak ada notifikasi baru.
                    </p>
                </div>

                @endforelse

            </div>
        </div>
        @endif


        {{-- AKTIVITAS DAN PENGINGAT --}}
        <div class="space-y-6">

            {{-- AKTIVITAS TERBARU --}}
            <div class="bg-blue-50 rounded-2xl border border-blue-200 shadow-sm overflow-hidden">

                <div class="p-5 bg-blue-200/70 border-b border-blue-200">
                    <h3 class="font-bold text-blue-900 text-lg">
                        Aktivitas Terbaru
                    </h3>
                </div>

                <div class="p-5 space-y-4">

                    @forelse($aktivitasTerbaru as $a)

                    <div class="flex items-center justify-between gap-3 border-b border-blue-200 pb-4 last:border-0 last:pb-0">

                        <div class="flex items-center gap-3 min-w-0">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-blue-950">
                                    {{ $a->peminjam->nama_lengkap ?? '-' }}
                                    <span class="text-xs font-normal text-gray-500">
                                        ({{ $a->peminjam->jenis_label ?? '-' }})
                                    </span>
                                </p>

                                <p class="text-xs text-gray-600">
                                    {{ $a->nama_barang }}
                                </p>

                                <p class="text-xs text-blue-500 mt-1">
                                    🕒 {{ $a->created_at->copy()->timezone('Asia/Jakarta')->format('d M Y, H:i:s') }} WIB
                                </p>
                            </div>

                        </div>

                        <div class="shrink-0">
                            <x-status-badge :status="$a->status" />
                        </div>

                    </div>

                    @empty

                    <div class="text-center py-6">
                        <span class="text-4xl">📭</span>
                        <p class="text-sm text-blue-500 mt-2">
                            Belum ada aktivitas.
                        </p>
                    </div>

                    @endforelse

                </div>
            </div>

            {{-- PENGINGAT --}}
            <div class="bg-blue-50 rounded-2xl border border-blue-200 shadow-sm overflow-hidden">

                <div class="p-5 bg-blue-200/70 border-b border-blue-200">
                    <h3 class="font-bold text-blue-900 text-lg">
                         Pengingat
                    </h3>
                </div>

                <div class="p-5">

                    @if($terlambat > 0)

                    <div class="bg-sky-100 border border-sky-300 rounded-xl p-4 mb-4">
                        <p class="text-sm text-sky-700">
                            ⚠️ Ada {{ $terlambat }} peminjaman yang melewati batas tanggal pengembalian.
                        </p>
                    </div>

                    @else

                    <div class="bg-blue-100 border border-blue-200 rounded-xl p-4 mb-4">
                        <p class="text-sm text-blue-800">
                            ✓ Tidak ada peminjaman yang terlambat dikembalikan.
                        </p>
                    </div>

                    @endif

                    @if(\App\Support\FiturAkses::aktif('Histori Peminjaman'))

                    <a href="{{ route('petugas.histori', ['status' => 'diambil']) }}"
                       class="inline-block bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold px-5 py-2.5 rounded-full shadow-sm transition">
                        Lihat Detail →
                    </a>

                    @endif

                </div>
            </div>

        </div>

    </div>

</div>

@endsection