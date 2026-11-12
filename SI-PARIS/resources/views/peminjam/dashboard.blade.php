@extends('layouts.dashboard')
@section('title', 'Dashboard Peminjam')
@section('page-title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-800">Halo, {{ explode(' ', auth()->user()->nama_lengkap)[0] }}! 👋</h2>
    <p class="text-gray-500 text-sm">Selamat datang di sistem peminjaman alat / inventaris.</p>
</div>

@if($siapDiambil->isNotEmpty())
<div class="mb-6 space-y-3">
    @foreach($siapDiambil as $sd)
        @php $fotoSd = $sd->gambar_acc ? asset('storage/'.$sd->gambar_acc) : null; @endphp
        <div class="bg-blue-600 text-white rounded-xl p-4 md:p-5 flex flex-col sm:flex-row sm:items-center gap-4 shadow-sm">
            @if($fotoSd)
                <img src="{{ $fotoSd }}" @click="foto = '{{ $fotoSd }}'" alt="Bukti foto barang" class="w-full sm:w-28 h-40 sm:h-28 rounded-lg object-cover border-2 border-white/40 cursor-zoom-in">
            @endif
            <div class="flex-1">
                <p class="text-xs text-blue-100">Notifikasi</p>
                <p class="font-semibold">Barang siap diambil: {{ $sd->nama_barang }} ({{ $sd->jumlah_acc ?? $sd->jumlah }})</p>
                <p class="text-sm text-blue-100">Peminjaman {{ $sd->kode_peminjaman }} sudah disetujui petugas. Ambil barang di ruang inventaris, lalu upload foto saat barang diterima.</p>
            </div>
            <a href="{{ route('peminjam.peminjaman.detail', $sd->id) }}" class="bg-white text-blue-700 text-sm font-semibold px-5 py-2.5 rounded-lg text-center hover:bg-blue-50">Lihat Bukti</a>
        </div>
    @endforeach
</div>
@endif

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl p-5 border border-blue-100 shadow-sm">
        <div class="w-9 h-9 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mb-3">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        </div>
        <p class="text-2xl font-bold text-gray-800">{{ $peminjamanAktif }}</p>
        <p class="text-xs text-gray-500">Peminjaman Aktif</p>
    </div>
    <div class="bg-white rounded-xl p-5 border border-blue-100 shadow-sm">
        <div class="w-9 h-9 rounded-lg bg-orange-100 text-orange-500 flex items-center justify-center mb-3">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <p class="text-2xl font-bold text-gray-800">{{ $menungguAcc }}</p>
        <p class="text-xs text-gray-500">Menunggu ACC</p>
    </div>
    <div class="bg-white rounded-xl p-5 border border-blue-100 shadow-sm">
        <div class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center mb-3">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/></svg>
        </div>
        <p class="text-2xl font-bold text-gray-800">{{ $totalHistori }}</p>
        <p class="text-xs text-gray-500">Total Histori</p>
    </div>
    <div class="bg-white rounded-xl p-5 border border-blue-100 shadow-sm">
        <div class="w-9 h-9 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center mb-3">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <p class="text-2xl font-bold text-gray-800">{{ $totalLaporan }}</p>
        <p class="text-xs text-gray-500">Laporan</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-xl border border-blue-100 shadow-sm p-5">
        <h3 class="font-semibold text-gray-800 mb-4">Peminjaman Terbaru</h3>
        <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[560px]">
            <thead>
                <tr class="text-left text-gray-400 border-b border-gray-100">
                    <th class="py-2 pr-4 font-medium whitespace-nowrap">No</th>
                    <th class="py-2 pr-4 font-medium whitespace-nowrap">Nama Barang</th>
                    <th class="py-2 pr-4 font-medium whitespace-nowrap">Tanggal Pinjam</th>
                    <th class="py-2 pr-4 font-medium whitespace-nowrap">Status</th>
                    <th class="py-2 pr-4 font-medium whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamanTerbaru as $i => $p)
                <tr class="border-b border-gray-50">
                    <td class="py-3 pr-4">{{ $i + 1 }}</td>
                    <td class="py-3 pr-4">{{ $p->nama_barang }}</td>
                    <td class="py-3 pr-4">{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                    <td class="py-3 pr-4"><x-status-badge :status="$p->status" /></td>
                    <td class="py-3 pr-4">
@if(\App\Support\FiturAkses::aktif('Peminjaman Alat'))
                        <a href="{{ route('peminjam.peminjaman.detail', $p->id) }}" class="text-blue-600 font-medium text-xs bg-blue-50 px-3 py-1.5 rounded-lg hover:bg-blue-100">Detail</a>
@endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="py-6 text-center text-gray-400">Belum ada peminjaman.</td></tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    <div class="bg-blue-600 rounded-xl p-5 text-white flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="font-semibold text-sm">Informasi</p>
            </div>
            <p class="text-blue-100 text-sm leading-relaxed">Jangan lupa untuk mengembalikan barang tepat waktu ya, dan laporkan segera jika ada kendala pada alat!</p>
        </div>
@if(\App\Support\FiturAkses::aktif('Peminjaman Alat'))
        <a href="{{ route('peminjam.peminjaman') }}" class="mt-4 bg-white text-blue-600 text-sm font-semibold py-2.5 rounded-lg text-center hover:bg-blue-50">Ajukan Peminjaman</a>
@endif
    </div>
</div>

@if($notifikasi->isNotEmpty())
<div class="mt-6 bg-white rounded-xl border border-blue-100 shadow-sm p-5">
    <h3 class="font-semibold text-gray-800 mb-4">Notifikasi Terbaru</h3>
    <div class="space-y-3">
        @foreach($notifikasi as $n)
            <a href="{{ route('peminjam.peminjaman.detail', $n->ref_id) }}" class="block border border-blue-100 {{ $n->dibaca ? 'bg-white' : 'bg-blue-50' }} rounded-lg p-3 hover:bg-blue-100 transition">
                <div class="flex items-center justify-between gap-2">
                    <p class="text-sm font-semibold text-gray-800">{{ $n->judul }}</p>
                    @unless($n->dibaca)<span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-blue-600 text-white">Baru</span>@endunless
                </div>
                <p class="text-xs text-gray-500 mt-1">{{ $n->pesan }}</p>
                <p class="text-[11px] text-gray-400 mt-1">{{ $n->created_at->copy()->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</p>
            </a>
        @endforeach
    </div>
</div>
@endif
@endsection