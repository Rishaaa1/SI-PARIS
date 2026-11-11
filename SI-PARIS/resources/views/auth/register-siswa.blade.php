@extends('layouts.guest')
@section('title', 'Daftar Siswa')
@section('content')
<h2 class="text-2xl font-bold text-gray-800 mb-1">Daftar Siswa</h2>
<p class="text-gray-500 text-sm mb-6">Isi data berikut untuk membuat akun siswa.</p>

@if ($errors->any())
    <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-600 text-sm">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('register.siswa.store') }}" class="space-y-4">
    @csrf
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">NIS</label>
        <input type="text" name="nis" value="{{ old('nis') }}" placeholder="Masukkan NIS" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Nama lengkap" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
        <input type="text" name="kelas" value="{{ old('kelas') }}" placeholder="Contoh: XI TKJ 1" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>
    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition">Daftar</button>
    <p class="text-xs text-gray-400 text-center">Untuk login, Anda cukup memakai NIS dan tanggal lahir.</p>
    <div class="flex justify-between text-sm">
        <a href="{{ route('register') }}" class="text-gray-500 hover:text-blue-600">&larr; Ganti pilihan</a>
        <a href="{{ route('login') }}" class="text-blue-600 font-medium">Sudah punya akun? Login</a>
    </div>
</form>
@endsection