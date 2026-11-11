@extends('layouts.guest')

@section('title', 'Login - Sistem Peminjaman Alat')

@section('content')
@php $aktif = old('_form', session('tab', request('role', 'siswa'))); @endphp
<div x-data="{ role: '{{ in_array($aktif, ['siswa','guru','petugas']) ? $aktif : 'siswa' }}' }">
    <h2 class="text-2xl font-bold text-gray-800 mb-1">Selamat Datang!</h2>
    <p class="text-gray-500 text-sm mb-6">Silakan login sesuai dengan akun Anda.</p>

    <!-- Pilihan utama: Peminjam / Petugas -->
    <div class="flex bg-gray-100 rounded-xl p-1 mb-3">
        <button type="button" @click="if (role === 'petugas') role = 'siswa'"
            :class="role !== 'petugas' ? 'bg-blue-600 text-white shadow' : 'text-gray-500'"
            class="flex-1 py-2 rounded-lg text-sm font-semibold transition">Peminjam</button>
        <button type="button" @click="role = 'petugas'"
            :class="role === 'petugas' ? 'bg-blue-600 text-white shadow' : 'text-gray-500'"
            class="flex-1 py-2 rounded-lg text-sm font-semibold transition">Petugas</button>
    </div>

    <!-- Pilihan peminjam: Siswa / Guru -->
    <div x-show="role !== 'petugas'" class="flex gap-2 mb-5">
        <button type="button" @click="role = 'siswa'"
            :class="role === 'siswa' ? 'border-blue-600 text-blue-600 bg-blue-50' : 'border-gray-200 text-gray-500'"
            class="flex-1 py-2 rounded-lg text-sm font-medium border transition">Siswa</button>
        <button type="button" @click="role = 'guru'"
            :class="role === 'guru' ? 'border-blue-600 text-blue-600 bg-blue-50' : 'border-gray-200 text-gray-500'"
            class="flex-1 py-2 rounded-lg text-sm font-medium border transition">Guru</button>
    </div>
    <div x-show="role === 'petugas'" class="mb-5"></div>

    @if (session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-700 text-sm border border-green-100">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-600 text-sm">{{ $errors->first() }}</div>
    @endif

    <!-- SISWA: NIS + tanggal lahir -->
    <form x-show="role === 'siswa'" method="POST" action="{{ route('login.siswa') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="_form" value="siswa">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">NIS</label>
            <input type="text" name="nis" value="{{ old('_form') === 'siswa' ? old('nis') : '' }}" placeholder="Masukkan NIS"
                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" value="{{ old('_form') === 'siswa' ? old('tanggal_lahir') : '' }}"
                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition">Login</button>
    </form>

    <!-- GURU: NIP + password -->
    <form x-show="role === 'guru'" method="POST" action="{{ route('login.guru') }}" class="space-y-4" style="display:none">
        @csrf
        <input type="hidden" name="_form" value="guru">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
            <input type="text" name="nip" value="{{ old('_form') === 'guru' ? old('nip') : '' }}" placeholder="Masukkan NIP"
                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" placeholder="Masukkan password"
                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition">Login</button>
    </form>

    <!-- PETUGAS: nama + password -->
    <form x-show="role === 'petugas'" method="POST" action="{{ route('login.petugas') }}" class="space-y-4" style="display:none">
        @csrf
        <input type="hidden" name="_form" value="petugas">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
            <input type="text" name="nama" value="{{ old('_form') === 'petugas' ? old('nama') : '' }}" placeholder="Masukkan nama petugas"
                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" placeholder="Masukkan password"
                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition">Login</button>
    </form>

    <!-- Link register per peran -->
    <p x-show="role !== 'petugas'" class="text-center text-sm text-gray-500 mt-6">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-blue-600 font-medium hover:underline">Daftar sekarang</a>
    </p>
    <p x-show="role === 'petugas'" style="display:none" class="text-center text-sm text-gray-500 mt-6">
        Belum punya akun petugas?
        <a href="{{ route('register.petugas') }}" class="text-blue-600 font-medium hover:underline">Daftar sekarang</a>
    </p>
</div>
@endsection