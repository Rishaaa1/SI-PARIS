@extends('layouts.dashboard')
@section('title', 'Data Siswa')
@section('page-title', 'Data Siswa')

@section('content')
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6" x-data="{ showForm: false }">
    <div class="flex items-center justify-between mb-5">
        <h3 class="font-semibold text-gray-800">Data Siswa</h3>
        <button @click="showForm = !showForm" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg">+ Tambah Siswa</button>
    </div>

    <div x-show="showForm" class="bg-gray-50 border border-gray-100 rounded-lg p-4 mb-5">
        @if ($errors->any())
            <div class="mb-3 p-2 rounded-lg bg-red-50 text-red-600 text-xs">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('petugas.siswa.store') }}" class="grid grid-cols-1 sm:grid-cols-5 gap-3">
            @csrf
            <input type="text" name="nama_lengkap" placeholder="Nama lengkap" class="border border-gray-200 rounded-lg px-3 py-2 text-sm" required>
            <input type="text" name="nis" placeholder="NIS" class="border border-gray-200 rounded-lg px-3 py-2 text-sm" required>
            <input type="text" name="kelas" placeholder="Kelas" class="border border-gray-200 rounded-lg px-3 py-2 text-sm" required>
            <input type="date" name="tanggal_lahir" title="Tanggal lahir (dipakai untuk login)" class="border border-gray-200 rounded-lg px-3 py-2 text-sm" required>
            <button class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg py-2">Simpan</button>
        </form>
    </div>

    <div class="overflow-x-auto">
    <table class="w-full text-sm min-w-[640px]">
        <thead>
            <tr class="text-left text-gray-400 border-b border-gray-100">
                <th class="py-2 pr-4 font-medium whitespace-nowrap">No</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Nama Lengkap</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">NIS</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Kelas</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Tanggal Lahir</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswa as $i => $s)
            <tr class="border-b border-gray-50">
                <td class="py-3 pr-4">{{ $i + 1 }}</td>
                <td class="py-3 pr-4 font-medium">{{ $s->nama_lengkap }}</td>
                <td class="py-3 pr-4">{{ $s->nis }}</td>
                <td class="py-3 pr-4">{{ $s->kelas }}</td>
                <td class="py-3 pr-4">{{ $s->tanggal_lahir ? $s->tanggal_lahir->format('d/m/Y') : '-' }}</td>
                <td class="py-3 pr-4">
                    <form method="POST" action="{{ route('petugas.user.destroy', $s->id) }}" onsubmit="return confirm('Hapus siswa ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:bg-red-50 p-1.5 rounded-lg">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="py-6 text-center text-gray-400">Belum ada siswa.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>
@endsection
