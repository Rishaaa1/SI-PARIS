@extends('layouts.dashboard')
@section('title', 'Histori Peminjaman')
@section('page-title', 'Histori Peminjaman')

@section('content')
<div class="w-full bg-gradient-to from-blue-600 to-blue-800 rounded-2xl p-5 md:p-8">
<div class="bg-white rounded-xl shadow-sm p-6 md:p-8">
    <h3 class="font-semibold text-gray-800 mb-4">Histori Peminjaman Saya</h3>
    <div class="overflow-x-auto">
    <table class="w-full text-sm min-w-[640px]">
        <thead>
            <tr class="text-left text-gray-400 border-b border-blue-100">
                <th class="py-2 pr-4 font-medium whitespace-nowrap">No</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Barang</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Jumlah</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Tgl Pinjam</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Tgl Kembali</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Foto Pengambilan</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($histori as $i => $h)
            <tr class="border-b border-blue-50">
                <td class="py-4">{{ $i + 1 }}</td>
                <td class="py-4">
                    <div class="flex items-center gap-3">
                        @if($h->barang && $h->barang->gambar_url)
                            <img src="{{ $h->barang->gambar_url }}" @click="foto = '{{ $h->barang->gambar_url }}'" alt="" class="w-10 h-10 rounded-lg object-cover border border-gray-100 cursor-zoom-in">
                        @endif
                        <span>{{ $h->nama_barang }}</span>
                    </div>
                </td>
                <td class="py-4">{{ $h->jumlah }}</td>
                <td class="py-4">{{ $h->tanggal_pinjam->format('d M Y') }}</td>
                <td class="py-4">{{ $h->tanggal_kembali->format('d M Y') }}</td>
                <td class="py-4">
                    @if($h->gambar_terima_url)
                        <img src="{{ $h->gambar_terima_url }}" @click="foto = '{{ $h->gambar_terima_url }}'" alt="Foto pengambilan" class="w-14 h-14 rounded-lg object-cover border border-gray-100 cursor-zoom-in">
                    @else
                        <span class="text-xs text-gray-400">Belum diambil</span>
                    @endif
                </td>
                <td class="py-4"><x-status-badge :status="$h->status" /></td>
            </tr>
            @empty
            <tr><td colspan="7" class="py-6 text-center text-gray-400">Belum ada histori.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>
</div>
@endsection