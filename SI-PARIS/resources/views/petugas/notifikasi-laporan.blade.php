@extends('layouts.dashboard')
@section('title', 'Laporan Siswa')
@section('page-title', 'Laporan Siswa')

@section('content')
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
    <h3 class="font-semibold text-gray-800 mb-4">Laporan Kendala / Perpanjangan / Pengembalian dari Siswa &amp; Guru</h3>
    <div class="space-y-3">
        @forelse($laporan as $l)
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border border-gray-100 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-semibold shrink-0">
                        {{ strtoupper(substr($l->peminjam->nama_lengkap,0,1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold">{{ $l->peminjam->nama_lengkap }} <span class="text-xs font-normal text-gray-400">({{ $l->peminjam->jenis_label }} &middot; {{ $l->peminjam->keterangan }})</span></p>
                        <p class="text-xs text-gray-500">{{ $l->jenisLabel() }} &mdash; {{ $l->nama_barang }} ({{ $l->jumlah }})</p>
                        @if($l->deskripsi_kendala)
                            <p class="text-xs text-gray-500 mt-1">"{{ $l->deskripsi_kendala }}"</p>
                        @endif
                        @if($l->foto)
                            <img src="{{ asset('storage/'.$l->foto) }}" class="w-20 h-20 object-cover rounded-lg mt-2 border border-gray-100">
                        @endif
                        <p class="text-xs text-gray-400 mt-1">{{ $l->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('petugas.laporan.proses', $l->id) }}">
                    @csrf
                    <button class="text-xs font-semibold bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 whitespace-nowrap">Proses</button>
                </form>
            </div>
        @empty
            <p class="text-sm text-gray-400">Tidak ada laporan yang menunggu.</p>
        @endforelse
    </div>
</div>
@endsection