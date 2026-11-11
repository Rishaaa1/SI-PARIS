<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $peminjamanAktif = Peminjaman::where('peminjam_id', $user->id)
            ->whereIn('status', ['disetujui', 'diambil'])
            ->count();

        $menungguAcc = Peminjaman::where('peminjam_id', $user->id)
            ->where('status', 'menunggu')
            ->count();

        $totalHistori = Peminjaman::where('peminjam_id', $user->id)->count();

        $totalLaporan = $user->laporan()->count();

        $peminjamanTerbaru = Peminjaman::where('peminjam_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Barang yang sudah di-ACC petugas dan siap diambil (lengkap dengan foto bukti)
        $siapDiambil = Peminjaman::where('peminjam_id', $user->id)
            ->where('status', 'disetujui')
            ->latest('diproses_at')
            ->get();

        $notifikasi = Notifikasi::where('user_id', $user->id)
            ->where('ref_type', 'peminjaman')
            ->latest()
            ->take(5)
            ->get();

        return view('peminjam.dashboard', compact(
            'peminjamanAktif', 'menungguAcc', 'totalHistori', 'totalLaporan', 'peminjamanTerbaru',
            'siapDiambil', 'notifikasi'
        ));
    }
}