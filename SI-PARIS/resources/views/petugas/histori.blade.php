@extends('layouts.dashboard')
@section('title', 'Histori Peminjaman')
@section('page-title', 'Histori Peminjaman')

@section('content')
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 sm:p-6">
    <div class="flex items-center justify-between mb-5 flex-wrap gap-3">
        <h3 class="font-semibold text-gray-800">Histori Peminjaman Siswa &amp; Guru</h3>
        <form method="GET" class="flex flex-col gap-2 w-full sm:w-auto sm:flex-row sm:flex-wrap sm:items-center">
            <select name="jenis" onchange="this.form.submit()" class="w-full sm:w-auto border border-gray-200 rounded-lg px-3 py-2 text-sm">
                <option value="">Semua Peminjam</option>
                <option value="siswa" {{ $jenis === 'siswa' ? 'selected' : '' }}>Siswa</option>
                <option value="guru" {{ $jenis === 'guru' ? 'selected' : '' }}>Guru</option>
            </select>
            <select name="kelas" onchange="this.form.submit()" class="w-full sm:w-auto border border-gray-200 rounded-lg px-3 py-2 text-sm">
                <option value="">Semua Kelas</option>
                @foreach($kelasList as $k)
                    <option value="{{ $k }}" {{ $kelasDipilih === $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>
            <select name="status" onchange="this.form.submit()" class="w-full sm:w-auto border border-gray-200 rounded-lg px-3 py-2 text-sm">
                <option value="">Semua Status</option>
                @foreach(['menunggu' => 'Menunggu ACC', 'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak', 'diambil' => 'Barang Diambil', 'dikembalikan' => 'Dikembalikan', 'rusak' => 'Barang Rusak'] as $val => $lbl)
                    <option value="{{ $val }}" {{ $status === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                @endforeach
            </select>
            <a href="{{ route('petugas.histori.cetak', request()->query()) }}" target="_blank"
               class="inline-flex items-center justify-center gap-2 text-sm font-semibold border border-gray-200 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak
            </a>
        </form>
    </div>

    <div class="overflow-x-auto">
    <table class="w-full text-sm min-w-[960px]">
        <thead>
            <tr class="text-left text-gray-400 border-b border-gray-100">
                <th class="py-2 pr-4 font-medium whitespace-nowrap">No</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Nama Peminjam</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Jenis / Kelas</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Barang</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Jumlah</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Waktu Pengajuan</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Foto Pengambilan</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Status</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($histori as $i => $h)
            <tr class="border-b border-gray-50 align-top">
                <td class="py-3 pr-4">{{ $i + 1 }}</td>
                <td class="py-3 pr-4 min-w-[140px]">{{ $h->peminjam->nama_lengkap ?? '-' }}</td>
                <td class="py-3 pr-4 whitespace-nowrap">{{ $h->peminjam->jenis_label ?? '-' }}@if(($h->peminjam->role ?? null) === 'siswa') &middot; {{ $h->peminjam->kelas ?? '-' }}@endif</td>
                <td class="py-3 pr-4">
                    <div class="flex items-center gap-3">
                        @if($h->barang && $h->barang->gambar_url)
                            <img src="{{ $h->barang->gambar_url }}" @click="foto = '{{ $h->barang->gambar_url }}'" alt="" class="w-10 h-10 rounded-lg object-cover border border-gray-100 cursor-zoom-in">
                        @endif
                        <span class="whitespace-nowrap">{{ $h->nama_barang }}</span>
                    </div>
                </td>
                <td class="py-3 pr-4">{{ $h->jumlah }}</td>
                <td class="py-3 pr-4 whitespace-nowrap">
                    {{ $h->created_at->copy()->timezone('Asia/Jakarta')->format('d/m/Y') }}<br>
                    <span class="text-xs text-gray-400">{{ $h->created_at->copy()->timezone('Asia/Jakarta')->format('H:i:s') }} WIB</span>
                </td>
                <td class="py-3 pr-4">
                    @if($h->gambar_terima_url)
                        <img src="{{ $h->gambar_terima_url }}" @click="foto = '{{ $h->gambar_terima_url }}'" alt="Foto pengambilan" class="w-14 h-14 rounded-lg object-cover border border-gray-100 cursor-zoom-in">
                    @else
                        <span class="text-xs text-gray-400">Belum diambil</span>
                    @endif
                </td>
                <td class="py-3 pr-4"><x-status-badge :status="$h->status" /></td>
                <td class="py-3 pr-4">
                    <div class="flex items-start gap-2">
                        @if($h->status === 'diambil')
                            <div x-data="{ open: false }" class="relative">
                                <button type="button" @click="open = !open" class="text-xs font-semibold border border-gray-200 text-gray-600 px-3 py-1.5 rounded-lg hover:bg-gray-50 whitespace-nowrap">Catat Kembali</button>
                                <div x-show="open" @click.outside="open = false" style="display:none" class="absolute right-0 z-10 mt-1 w-64 bg-white border border-gray-100 shadow-lg rounded-lg p-3 space-y-2">
                                    <form method="POST" action="{{ route('petugas.histori.selesai', $h->id) }}" class="space-y-2">
                                        @csrf
                                        <select name="status" class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-xs">
                                            <option value="dikembalikan">Dikembalikan</option>
                                            <option value="rusak">Rusak</option>
                                        </select>
                                        <textarea name="catatan" rows="2" placeholder="Keterangan (wajib jika rusak)" class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-xs"></textarea>
                                        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-1.5 rounded-lg">Simpan</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('petugas.histori.destroy', $h->id) }}" onsubmit="return confirm('Hapus riwayat ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:bg-red-50 p-1.5 rounded-lg">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="9" class="py-6 text-center text-gray-400">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>
@endsection