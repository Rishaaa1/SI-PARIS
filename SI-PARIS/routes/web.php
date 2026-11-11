<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Peminjam\DashboardController as PeminjamDashboardController;
use App\Http\Controllers\Peminjam\HistoriController as PeminjamHistoriController;
use App\Http\Controllers\Peminjam\LaporanController as PeminjamLaporanController;
use App\Http\Controllers\Peminjam\PeminjamanController;
use App\Http\Controllers\Petugas\AccController;
use App\Http\Controllers\Petugas\BarangController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\FiturController;
use App\Http\Controllers\Petugas\HistoriController as PetugasHistoriController;
use App\Http\Controllers\Petugas\HistoriCetakController;
use App\Http\Controllers\Petugas\LaporanController as PetugasLaporanController;
use App\Http\Controllers\Petugas\NotifikasiController;
use App\Http\Controllers\Petugas\RekapController;
use App\Http\Controllers\Petugas\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman depan
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    // Sudah login -> langsung ke dashboard sesuai peran; belum login -> halaman depan
    if (auth()->check()) {
        return redirect(auth()->user()->role === 'petugas' ? '/petugas/dashboard' : '/peminjam/dashboard');
    }

    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Login & Register (guest only)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login/siswa', [AuthController::class, 'loginSiswa'])->name('login.siswa');
    Route::post('/login/guru', [AuthController::class, 'loginGuru'])->name('login.guru');
    Route::post('/login/petugas', [AuthController::class, 'loginPetugas'])->name('login.petugas');

    // Register: pilih Siswa / Guru / Petugas
    Route::get('/register', [AuthController::class, 'showRegisterPilih'])->name('register');
    Route::get('/register/siswa', [AuthController::class, 'showRegisterSiswa'])->name('register.siswa');
    Route::post('/register/siswa', [AuthController::class, 'registerSiswa'])->name('register.siswa.store');
    Route::get('/register/guru', [AuthController::class, 'showRegisterGuru'])->name('register.guru');
    Route::post('/register/guru', [AuthController::class, 'registerGuru'])->name('register.guru.store');
    Route::get('/register/petugas', [AuthController::class, 'showRegisterPetugas'])->name('register.petugas');
    Route::post('/register/petugas', [AuthController::class, 'registerPetugas'])->name('register.petugas.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Peminjam (Siswa & Guru) - tampilan & alur sama
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:siswa,guru'])->prefix('peminjam')->name('peminjam.')->group(function () {
    Route::get('/dashboard', [PeminjamDashboardController::class, 'index'])->name('dashboard');

    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'detail'])->name('peminjaman.detail');
    Route::post('/peminjaman/{id}/upload-foto', [PeminjamanController::class, 'uploadFoto'])->name('peminjaman.upload-foto');

    Route::get('/laporan', [PeminjamLaporanController::class, 'index'])->name('laporan');
    Route::post('/laporan', [PeminjamLaporanController::class, 'store'])->name('laporan.store');

    Route::get('/histori', [PeminjamHistoriController::class, 'index'])->name('histori');
});

/*
|--------------------------------------------------------------------------
| Petugas (admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('dashboard');

    // Notifikasi pengajuan & laporan dari peminjam
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');
    Route::get('/notifikasi-laporan', [NotifikasiController::class, 'laporan'])->name('notifikasi.laporan');

    // ACC / tolak peminjaman
    Route::get('/acc/{id}', [AccController::class, 'show'])->name('acc.show');
    Route::post('/acc/{id}', [AccController::class, 'acc'])->name('acc.store');
    Route::post('/acc/{id}/tolak', [AccController::class, 'tolak'])->name('acc.tolak');

    // Proses laporan (kendala / perpanjangan / pengembalian)
    Route::post('/laporan/{id}/proses', [PetugasLaporanController::class, 'proses'])->name('laporan.proses');

    // Rekap barang (dikembalikan & rusak) + Excel + cetak
    Route::get('/rekap', [RekapController::class, 'index'])->name('rekap');
    Route::get('/rekap/export', [RekapController::class, 'export'])->name('rekap.export');
    Route::get('/rekap/cetak', [RekapController::class, 'cetak'])->name('rekap.cetak');

    // Histori peminjaman (siswa & guru)
    Route::get('/histori', [PetugasHistoriController::class, 'index'])->name('histori');
    Route::get('/histori/cetak', HistoriCetakController::class)->name('histori.cetak');
    Route::post('/histori/{id}/selesai', [PetugasHistoriController::class, 'selesai'])->name('histori.selesai');
    Route::delete('/histori/{id}', [PetugasHistoriController::class, 'destroy'])->name('histori.destroy');

    Route::get('/fitur', [FiturController::class, 'index'])->name('fitur');
    Route::post('/fitur', [FiturController::class, 'store'])->name('fitur.store');
    Route::put('/fitur/{id}', [FiturController::class, 'update'])->name('fitur.update');
    Route::post('/fitur/{id}/toggle', [FiturController::class, 'toggleStatus'])->name('fitur.toggle');
    Route::delete('/fitur/{id}', [FiturController::class, 'destroy'])->name('fitur.destroy');

    Route::get('/barang', [BarangController::class, 'index'])->name('barang');
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
    Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::post('/barang/{id}/toggle', [BarangController::class, 'toggleStatus'])->name('barang.toggle');
    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');

    Route::get('/siswa', [UserController::class, 'siswa'])->name('siswa');
    Route::post('/siswa', [UserController::class, 'storeSiswa'])->name('siswa.store');

    Route::get('/guru', [UserController::class, 'guru'])->name('guru');
    Route::post('/guru', [UserController::class, 'storeGuru'])->name('guru.store');

    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
});