@extends('layouts.dashboard')
@section('title', 'Peminjaman Alat')
@section('page-title', 'Peminjaman Alat')

@section('content')
<style>body{background-color:#dbeafe !important;}</style>
@php
    // Data barang untuk pratinjau di form (id => info)
    $dataBarang = $barang->mapWithKeys(fn ($b) => [$b->id => [
        'nama' => $b->nama_barang,
        'kategori' => $b->kategori,
        'tersedia' => $b->stok_tersedia,
        'gambar' => $b->gambar ? asset('storage/'.$b->gambar) : null,
    ]]);
@endphp
<div class="w-full bg-gradient-to from-blue-600 to-blue-800 rounded-2xl p-5 md:p-8">
<div class="grid lg:grid-cols-3 gap-6 items-start" x-data="{ pilih: '', data: {{ \Illuminate\Support\Js::from($dataBarang) }} }">

    <!-- Form pengajuan -->
    <div class="lg:col-span-1 bg-white rounded-xl shadow-sm p-6 md:p-8 h-fit">
        <h3 class="font-semibold text-gray-800 mb-1">Peminjaman Alat / Inventaris</h3>
        <p class="text-xs text-gray-400 mb-5">Pilih barang di daftar atau lewat form ini, lalu isi data peminjaman.</p>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-600 text-sm">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('peminjam.peminjaman.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang</label>
                <select name="barang_id" x-model="pilih" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Pilih Barang</option>
                    @foreach($barang as $b)
                        <option value="{{ $b->id }}">{{ $b->nama_barang }} (tersedia {{ $b->stok_tersedia }})</option>
                    @endforeach
                </select>

                <!-- Pratinjau detail barang yang dipilih -->
                <div x-show="pilih && data[pilih]" style="display:none" class="mt-4 bg-blue-50 border border-blue-100 rounded-xl p-4 space-y-3">
                    <template x-if="data[pilih] && data[pilih].gambar">
                        <img :src="data[pilih].gambar" :alt="data[pilih].nama" @click="foto = data[pilih].gambar" class="w-full h-52 rounded-lg object-cover cursor-zoom-in">
                    </template>
                    <template x-if="data[pilih] && !data[pilih].gambar">
                        <div class="w-full h-52 rounded-lg bg-blue-100 text-blue-300 flex items-center justify-center text-sm">Belum ada gambar</div>
                    </template>
                    <div class="text-sm">
                        <p class="text-base font-semibold text-gray-800" x-text="data[pilih] ? data[pilih].nama : ''"></p>
                        <p class="text-gray-500" x-text="data[pilih] && data[pilih].kategori ? 'Kategori: ' + data[pilih].kategori : ''"></p>
                        <p class="font-medium text-blue-700" x-text="data[pilih] ? 'Tersedia: ' + data[pilih].tersedia : ''"></p>
                    </div>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                <input type="number" min="1" name="jumlah" value="{{ old('jumlah') }}" placeholder="Masukkan jumlah" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Keperluan</label>
                <textarea name="keperluan" rows="3" placeholder="Tuliskan keperluan" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('keperluan') }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Peminjaman</label>
                    <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengembalian</label>
                    <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali') }}" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition">Ajukan Peminjaman</button>
        </form>
    </div>

    <div class="lg:col-span-2 space-y-6">

        <!-- Daftar barang bergambar -->
        <div class="bg-white rounded-xl shadow-sm p-6 md:p-8">
            <h3 class="font-semibold text-gray-800 mb-1">Daftar Barang</h3>
            <p class="text-xs text-gray-400 mb-4">Klik barang untuk memilihnya di form. Klik gambar untuk memperbesar.</p>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-5">
                @forelse($barang as $b)
                    @php $gambar = $b->gambar ? asset('storage/'.$b->gambar) : null; @endphp
                    <div @click="pilih = '{{ $b->id }}'"
                         :class="pilih === '{{ $b->id }}' ? 'ring-2 ring-blue-600 border-blue-600' : 'border-blue-100'"
                         class="group border rounded-xl overflow-hidden cursor-pointer bg-blue-50 transition-shadow duration-300 hover:shadow-lg">
                        @if($gambar)
                            <img src="{{ $gambar }}" alt="{{ $b->nama_barang }}" @click.stop="foto = '{{ $gambar }}'" class="w-full h-44 object-cover cursor-zoom-in transition-transform duration-300 ease-out group-hover:scale-125">
                        @else
                            <div class="w-full h-44 bg-blue-100 text-blue-400 flex items-center justify-center">
                                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                        <div class="p-3 bg-blue-50">
                            <p class="text-sm font-semibold text-gray-800">{{ $b->nama_barang }}</p>
                            <p class="text-xs text-gray-500">{{ $b->kategori ?: 'Tanpa kategori' }}</p>
                            <p class="text-xs mt-1 {{ $b->stok_tersedia > 0 ? 'text-green-600' : 'text-red-500' }}">Tersedia: {{ $b->stok_tersedia }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 col-span-full">Belum ada barang yang tersedia.</p>
                @endforelse
            </div>
        </div>

        <!-- Riwayat pengajuan -->
        <div class="bg-white rounded-xl shadow-sm p-6 md:p-8">
            <h3 class="font-semibold text-gray-800 mb-4">Riwayat Pengajuan</h3>
            <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-400 border-b border-gray-100">
                        <th class="py-2 font-medium">Barang</th>
                        <th class="py-2 font-medium">Jumlah</th>
                        <th class="py-2 font-medium">Tgl Pinjam</th>
                        <th class="py-2 font-medium">Status</th>
                        <th class="py-2 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $r)
                    <tr class="border-b border-gray-50">
                        <td class="py-4">{{ $r->nama_barang }}</td>
                        <td class="py-3">{{ $r->jumlah }}</td>
                        <td class="py-3">{{ $r->tanggal_pinjam->format('d M Y') }}</td>
                        <td class="py-3"><x-status-badge :status="$r->status" /></td>
                        <td class="py-3">
                            <a href="{{ route('peminjam.peminjaman.detail', $r->id) }}" class="text-blue-600 font-medium text-xs bg-blue-50 px-3 py-1.5 rounded-lg hover:bg-blue-100">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-6 text-center text-gray-400">Belum ada pengajuan peminjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
</div>
@endsection