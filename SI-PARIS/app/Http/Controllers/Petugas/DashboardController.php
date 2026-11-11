<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Laporan;
use App\Models\Notifikasi;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalGuru = User::where('role', 'guru')->count();
        $totalPeminjaman = Peminjaman::count();
        $totalBarang = Barang::sum('stok');

        $menungguAcc = Peminjaman::where('status', 'menunggu')->count();
        $laporanMenunggu = Laporan::where('status', 'menunggu')->count();
        $totalDikembalikan = Peminjaman::where('status', 'dikembalikan')->count();
        $totalRusak = Peminjaman::where('status', 'rusak')->count();

        $terlambat = Peminjaman::where('status', 'diambil')
            ->whereDate('tanggal_kembali', '<', now()->toDateString())
            ->count();

        $notifBaru = Notifikasi::where('user_id', Auth::id())
            ->whereIn('jenis', ['pengajuan', 'laporan'])
            ->where('dibaca', false)
            ->latest()
            ->take(6)
            ->get();

        $aktivitasTerbaru = Peminjaman::with('peminjam')->latest()->take(5)->get();

        return view('petugas.dashboard', compact(
            'totalSiswa', 'totalGuru', 'totalPeminjaman', 'totalBarang',
            'menungguAcc', 'laporanMenunggu', 'totalDikembalikan', 'totalRusak',
            'terlambat', 'notifBaru', 'aktivitasTerbaru'
        ));
    }
}
