<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Peminjaman;

class NotifikasiController extends Controller
{
    // Pengajuan peminjaman yang masuk (siswa & guru)
    public function index()
    {
        $pengajuan = Peminjaman::with('peminjam')->where('status', 'menunggu')->latest()->get();
        return view('petugas.notifikasi', compact('pengajuan'));
    }

    // Laporan kendala / perpanjangan / pengembalian
    public function laporan()
    {
        $laporan = Laporan::with('peminjam')->where('status', 'menunggu')->latest()->get();
        return view('petugas.notifikasi-laporan', compact('laporan'));
    }
}
