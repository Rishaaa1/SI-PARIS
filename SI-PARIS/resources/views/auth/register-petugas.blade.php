@extends('layouts.guest')
@section('title', 'Daftar Petugas')
@section('content')
<h2 class="text-2xl font-bold text-gray-800 mb-1">Daftar Petugas</h2>
<p class="text-gray-500 text-sm mb-6">Isi nama dan password untuk membuat akun petugas.</p>

@if ($errors->any())
    <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-600 text-sm">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('register.petugas.store') }}" class="space-y-4">
    @csrf
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Nama petugas" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input type="password" name="password" placeholder="Minimal 6 karakter" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>
    @if ($butuhKode)
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Petugas</label>
        <input type="password" name="kode" placeholder="Kode dari sekolah" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>
    @endif
    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition">Daftar</button>
    <div class="flex justify-between text-sm">
        <a href="{{ route('register') }}" class="text-gray-500 hover:text-blue-600">&larr; Ganti pilihan</a>
        <a href="{{ route('login') }}" class="text-blue-600 font-medium">Sudah punya akun? Login</a>
    </div>
</form>
@endsection
