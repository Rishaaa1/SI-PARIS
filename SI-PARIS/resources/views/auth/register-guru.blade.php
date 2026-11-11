@extends('layouts.guest')
@section('title', 'Daftar Guru')
@section('content')
<h2 class="text-2xl font-bold text-gray-800 mb-1">Daftar Guru</h2>
<p class="text-gray-500 text-sm mb-6">Isi data berikut untuk membuat akun guru.</p>

@if ($errors->any())
    <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-600 text-sm">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('register.guru.store') }}" class="space-y-4">
    @csrf
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
        <input type="text" name="nip" value="{{ old('nip') }}" placeholder="Masukkan NIP" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Nama lengkap" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input type="password" name="password" placeholder="Minimal 6 karakter" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>
    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition">Daftar</button>
    <div class="flex justify-between text-sm">
        <a href="{{ route('register') }}" class="text-gray-500 hover:text-blue-600">&larr; Ganti pilihan</a>
        <a href="{{ route('login') }}" class="text-blue-600 font-medium">Sudah punya akun? Login</a>
    </div>
</form>
@endsection
