@extends('layouts.dashboard')
@section('title', 'Rekap Barang')
@section('page-title', 'Rekap Barang')

@section('content')
@php
    $q = array_filter($filter);   // dari, sampai, peminjam (yang terisi saja)
@endphp
<div x-data="{ tab: '{{ $tab }}' }">
    <!-- Filter -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 mb-6">
        <form method="GET" class="flex flex-wrap items-end gap-3">
            <input type="hidden" name="tab" :value="tab">
            <div>
                <label class="block text-xs text-gray-500 mb-1">Dari Tanggal</label>
                <input type="date" name="dari" value="{{ $filter['dari'] }}" class="border border-gray-200 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Sampai Tanggal</label>
                <input type="date" name="sampai" value="{{ $filter['sampai'] }}" class="border border-gray-200 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Peminjam</label>
                <select name="peminjam" class="border border-gray-200 rounded-lg px-3 py-2 text-sm">
                    <option value="">Siswa &amp; Guru</option>
                    <option value="siswa" {{ $filter['peminjam'] === 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="guru" {{ $filter['peminjam'] === 'guru' ? 'selected' : '' }}>Guru</option>
                </select>
            </div>
            <button class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2 rounded-lg">Terapkan</button>
            @if($q)
                <a href="{{ route('petugas.rekap') }}" class="text-sm text-gray-500 hover:text-red-500 py-2">Reset</a>
            @endif

            <div class="ml-auto flex flex-wrap gap-2">
                <a href="{{ route('petugas.rekap.export', $q + ['jenis' => 'semua']) }}"
                   class="inline-flex items-center gap-2 text-sm font-semibold border border-emerald-200 text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-4 py-2 rounded-lg">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Excel (Semua)
                </a>
                <a href="{{ route('petugas.rekap.cetak', $q + ['jenis' => 'semua']) }}" target="_blank"
                   class="inline-flex items-center gap-2 text-sm font-semibold border border-gray-200 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak (Semua)
                </a>
            </div>
        </form>
    </div>

    <!-- Tab pemisah: Dikembalikan | Rusak -->
    <div class="flex gap-2 mb-4">
        <button type="button" @click="tab = 'dikembalikan'"
            :class="tab === 'dikembalikan' ? 'bg-emerald-600 text-white shadow' : 'bg-white text-gray-500 border border-gray-200'"
            class="text-sm font-semibold px-5 py-2.5 rounded-lg transition">
            Barang Dikembalikan <span class="ml-1 text-xs opacity-80">({{ $dikembalikan->count() }})</span>
        </button>
        <button type="button" @click="tab = 'rusak'"
            :class="tab === 'rusak' ? 'bg-red-600 text-white shadow' : 'bg-white text-gray-500 border border-gray-200'"
            class="text-sm font-semibold px-5 py-2.5 rounded-lg transition">
            Barang Rusak <span class="ml-1 text-xs opacity-80">({{ $rusak->count() }})</span>
        </button>
    </div>

    <!-- Dikembalikan -->
    <div x-show="tab === 'dikembalikan'" class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
            <h3 class="font-semibold text-gray-800">Rekap Barang Dikembalikan</h3>
            <div class="flex gap-2">
                <a href="{{ route('petugas.rekap.export', $q + ['jenis' => 'dikembalikan']) }}" class="text-xs font-semibold border border-emerald-200 text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg">Export Excel</a>
                <a href="{{ route('petugas.rekap.cetak', $q + ['jenis' => 'dikembalikan']) }}" target="_blank" class="text-xs font-semibold border border-gray-200 text-gray-700 hover:bg-gray-50 px-3 py-1.5 rounded-lg">Cetak</a>
            </div>
        </div>
        @include('petugas.rekap-tabel', ['items' => $dikembalikan, 'status' => 'dikembalikan'])
    </div>

    <!-- Rusak -->
    <div x-show="tab === 'rusak'" style="display:none" class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
            <h3 class="font-semibold text-gray-800">Rekap Barang Rusak</h3>
            <div class="flex gap-2">
                <a href="{{ route('petugas.rekap.export', $q + ['jenis' => 'rusak']) }}" class="text-xs font-semibold border border-emerald-200 text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg">Export Excel</a>
                <a href="{{ route('petugas.rekap.cetak', $q + ['jenis' => 'rusak']) }}" target="_blank" class="text-xs font-semibold border border-gray-200 text-gray-700 hover:bg-gray-50 px-3 py-1.5 rounded-lg">Cetak</a>
            </div>
        </div>
        @include('petugas.rekap-tabel', ['items' => $rusak, 'status' => 'rusak'])
    </div>
</div>
@endsection
