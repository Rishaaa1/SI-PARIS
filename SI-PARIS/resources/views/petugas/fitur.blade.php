@extends('layouts.dashboard')
@section('title', 'Kelola Fitur')
@section('page-title', 'Kelola Fitur Sistem')

@section('content')
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6" x-data="{ showForm: false, edit: null }">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h3 class="font-semibold text-gray-800">Kelola Fitur Sistem</h3>
            <p class="text-xs text-gray-400">Tambah, edit, atau hapus fitur yang tersedia di sistem.</p>
        </div>
        <button @click="showForm = !showForm" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg flex items-center gap-2">
            <span>+ Tambah Fitur</span>
        </button>
    </div>

    <div x-show="showForm" class="bg-gray-50 border border-gray-100 rounded-lg p-4 mb-5">
        <form method="POST" action="{{ route('petugas.fitur.store') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            @csrf
            <input type="text" name="nama_fitur" placeholder="Nama fitur" class="border border-gray-200 rounded-lg px-3 py-2 text-sm" required>
            <input type="text" name="deskripsi" placeholder="Deskripsi" class="border border-gray-200 rounded-lg px-3 py-2 text-sm sm:col-span-1">
            <button class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg py-2">Simpan</button>
        </form>
    </div>

    <div class="overflow-x-auto">
    <table class="w-full text-sm min-w-[560px]">
        <thead>
            <tr class="text-left text-gray-400 border-b border-gray-100">
                <th class="py-2 pr-4 font-medium whitespace-nowrap">No</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Nama Fitur</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Deskripsi</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Status</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($fitur as $i => $f)
            <tr class="border-b border-gray-50">
                <td class="py-3 pr-4">{{ $i + 1 }}</td>
                <td class="py-3 pr-4 font-medium">{{ $f->nama_fitur }}</td>
                <td class="py-3 pr-4 text-gray-500">{{ $f->deskripsi }}</td>
                <td class="py-3 pr-4">
                    <form method="POST" action="{{ route('petugas.fitur.toggle', $f->id) }}">
                        @csrf
                        <button type="submit" class="relative inline-flex h-6 w-11 items-center rounded-full transition {{ $f->status === 'aktif' ? 'bg-blue-600' : 'bg-gray-300' }}">
                            <span class="inline-block h-4 w-4 transform rounded-full bg-white transition {{ $f->status === 'aktif' ? 'translate-x-6' : 'translate-x-1' }}"></span>
                        </button>
                    </form>
                </td>
                <td class="py-3 pr-4">
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('petugas.fitur.destroy', $f->id) }}" onsubmit="return confirm('Hapus fitur ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:bg-red-50 p-1.5 rounded-lg">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="py-6 text-center text-gray-400">Belum ada fitur.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>
@endsection
