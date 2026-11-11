<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengingatController extends Controller
{
    // Barang yang sedang dipinjam (sudah diambil) -> petugas bisa kirim pengingat pengembalian
    public function index()
    {
        $dipinjam = Peminjaman::with('peminjam')
            ->where('status', 'diambil')
            ->orderBy('tanggal_kembali')
            ->get();

        return view('petugas.pengingat', compact('dipinjam'));
    }

    public function kirim(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'pesan' => 'required|string|max:500',
        ]);

        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

        Notifikasi::create([
            'user_id' => $peminjaman->peminjam_id,
            'dari_user_id' => Auth::id(),
            'jenis' => 'pengingat',
            'judul' => 'Pengingat dari Petugas',
            'pesan' => $request->pesan,
            'ref_id' => $peminjaman->id,
            'ref_type' => 'peminjaman',
        ]);

        return back()->with('success', 'Pengingat berhasil dikirim ke '.$peminjaman->peminjam->nama_lengkap.'.');
    }
}
