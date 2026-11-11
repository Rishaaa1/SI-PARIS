@extends('layouts.dashboard')
@section('title', 'Notifikasi Pengajuan')
@section('page-title', 'Notifikasi Pengajuan Peminjaman')

@section('content')
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
    <div class="flex items-start justify-between gap-3 flex-wrap mb-5">
        <div>
            <h3 class="font-semibold text-gray-800">Pengajuan dari Siswa &amp; Guru</h3>
            <p class="text-xs text-gray-400">Waktu pengajuan tercatat otomatis oleh sistem.</p>
        </div>
        <div class="text-right">
            <p class="text-xs text-gray-400">Waktu sekarang</p>
            <p class="text-sm font-semibold text-blue-700" data-jam></p>
        </div>
    </div>

    <div class="space-y-3">
        @forelse($pengajuan as $p)
            @php $t = $p->created_at->copy()->timezone('Asia/Jakarta')->locale('id'); @endphp
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border border-gray-100 rounded-lg p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-semibold">
                        {{ strtoupper(substr($p->peminjam->nama_lengkap, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold">
                            {{ $p->peminjam->nama_lengkap }}
                            <span class="text-xs font-normal text-gray-400">({{ $p->peminjam->jenis_label }} &middot; {{ $p->peminjam->keterangan }})</span>
                        </p>
                        <p class="text-xs text-gray-500">Mengajukan peminjaman {{ $p->nama_barang }} ({{ $p->jumlah }}) &middot; {{ $p->kode_peminjaman }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Diajukan {{ $t->translatedFormat('l, d F Y') }} pukul {{ $t->format('H:i:s') }} WIB
                            <span class="text-blue-700 font-medium">(<span data-ago="{{ $p->created_at->toIso8601String() }}"></span>)</span>
                        </p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('petugas.acc.show', $p->id) }}" class="text-xs font-semibold border border-gray-200 text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-50">Lihat</a>
                    <a href="{{ route('petugas.acc.show', $p->id) }}" class="text-xs font-semibold bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">ACC</a>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-400">Tidak ada pengajuan yang menunggu.</p>
        @endforelse
    </div>
</div>
@endsection