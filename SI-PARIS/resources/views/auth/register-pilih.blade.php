@extends('layouts.guest')
@section('title', 'Daftar - Pilih Peminjam')
@section('content')
<h2 class="text-2xl font-bold text-gray-800 mb-1">Daftar Akun</h2>
<p class="text-gray-500 text-sm mb-6">Pilih jenis akun yang ingin Anda daftarkan.</p>

<div class="space-y-3">
    <a href="{{ route('register.siswa') }}" class="flex items-center gap-4 border border-gray-200 hover:border-blue-500 hover:bg-blue-50 rounded-xl p-4 transition">
        <div class="w-11 h-11 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422A12.083 12.083 0 0121 17.11 12.083 12.083 0 0112 21a12.083 12.083 0 01-9-3.89 12.083 12.083 0 013.16-9.532L12 14z"/></svg>
        </div>
        <div>
            <p class="font-semibold text-gray-800">Siswa</p>
            <p class="text-xs text-gray-500">Daftar dengan NIS &amp; tanggal lahir</p>
        </div>
    </a>
    <a href="{{ route('register.guru') }}" class="flex items-center gap-4 border border-gray-200 hover:border-blue-500 hover:bg-blue-50 rounded-xl p-4 transition">
        <div class="w-11 h-11 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <div>
            <p class="font-semibold text-gray-800">Guru</p>
            <p class="text-xs text-gray-500">Daftar dengan NIP, nama &amp; password</p>
        </div>
    </a>
</div>

<a href="{{ route('login') }}" class="block text-center text-sm text-blue-600 font-medium mt-6">Sudah punya akun? Login</a>
@endsection