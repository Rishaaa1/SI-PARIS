@extends('layouts.dashboard')
@section('title', 'Pengingat')
@section('page-title', 'Pengingat Pengembalian')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6" x-data="{ pilih: '', pesan: '' }">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-semibold text-gray-800 mb-1">Barang Sedang Dipinjam</h3>
        <p class="text-xs text-gray-400 mb-4">Pilih peminjaman untuk mengirim pengingat pengembalian ke siswa / guru.</p>
        <div class="space-y-2">
            @forelse($dipinjam as $d)
                @php $telat = $d->tanggal_kembali->lt(now()->startOfDay()); @endphp
                <button type="button"
                    @click="pilih = '{{ $d->id }}'; pesan = 'Mohon segera mengembalikan {{ addslashes($d->nama_barang) }} (batas kembali {{ $d->tanggal_kembali->format('d/m/Y') }}).'"
                    :class="pilih === '{{ $d->id }}' ? 'border-blue-500 bg-blue-50' : 'border-gray-100'"
                    class="w-full text-left border rounded-lg p-3 text-sm transition">
                    <p class="font-medium">{{ $d->peminjam->nama_lengkap ?? '-' }} <span class="text-xs text-gray-400">({{ $d->peminjam->jenis_label ?? '-' }})</span> &mdash; {{ $d->nama_barang }}</p>
                    <p class="text-xs {{ $telat ? 'text-red-500 font-semibold' : 'text-gray-400' }}">
                        Batas kembali {{ $d->tanggal_kembali->format('d M Y') }}{{ $telat ? ' (terlambat)' : '' }}
                    </p>
                </button>
            @empty
                <p class="text-sm text-gray-400">Tidak ada barang yang sedang dipinjam.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Kirim Pengingat</h3>
        <form method="POST" action="{{ route('petugas.pengingat.kirim') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="peminjaman_id" :value="pilih">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                <textarea name="pesan" rows="4" x-model="pesan" placeholder="Pilih peminjaman di sebelah kiri, lalu ubah pesan jika perlu..." class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
            </div>
            @error('peminjaman_id')
                <p class="text-xs text-red-500">Pilih peminjaman terlebih dahulu.</p>
            @enderror
            <div class="flex gap-3">
                <a href="{{ route('petugas.dashboard') }}" class="flex-1 text-center border border-gray-200 text-gray-600 font-semibold py-2.5 rounded-lg hover:bg-gray-50">Batal</a>
                <button type="submit" :disabled="!pilih" class="flex-1 bg-blue-600 hover:bg-blue-700 disabled:opacity-50 text-white font-semibold py-2.5 rounded-lg">Kirim</button>
            </div>
        </form>
    </div>
</div>
@endsection
