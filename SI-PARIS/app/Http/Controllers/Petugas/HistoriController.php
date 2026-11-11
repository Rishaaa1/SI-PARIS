<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoriController extends Controller
{
    public function index(Request $request)
    {
        $kelasList = User::where('role', 'siswa')->whereNotNull('kelas')->distinct()->orderBy('kelas')->pluck('kelas');

        $jenis = $request->get('jenis');          // siswa | guru | (kosong = semua)
        $kelasDipilih = $request->get('kelas');   // hanya untuk siswa
        $status = $request->get('status');

        $query = Peminjaman::with('peminjam', 'barang');

        if (in_array($jenis, ['siswa', 'guru'], true)) {
            $query->whereHas('peminjam', fn ($q) => $q->where('role', $jenis));
        }

        if ($kelasDipilih) {
            $query->whereHas('peminjam', fn ($q) => $q->where('role', 'siswa')->where('kelas', $kelasDipilih));
        }

        if ($status) {
            $query->where('status', $status);
        }

        $histori = $query->latest()->get();

        return view('petugas.histori', compact('kelasList', 'kelasDipilih', 'jenis', 'status', 'histori'));
    }

    // Petugas mencatat langsung barang yang sudah diambil: dikembalikan / rusak
    public function selesai(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:dikembalikan,rusak',
            'catatan' => 'nullable|string|max:500|required_if:status,rusak',
        ], [
            'catatan.required_if' => 'Keterangan kerusakan wajib diisi.',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'diambil') {
            return back()->with('error', 'Hanya peminjaman berstatus "Barang Diambil" yang dapat dicatat.');
        }

        $peminjaman->update([
            'status' => $request->status,
            'selesai_at' => now(),
            'catatan_selesai' => $request->catatan,
        ]);

        Notifikasi::create([
            'user_id' => $peminjaman->peminjam_id,
            'dari_user_id' => Auth::id(),
            'jenis' => 'info',
            'judul' => $request->status === 'rusak' ? 'Barang Dicatat Rusak' : 'Barang Dicatat Dikembalikan',
            'pesan' => 'Petugas mencatat '.$peminjaman->nama_barang.' sebagai '.($request->status === 'rusak' ? 'rusak' : 'sudah dikembalikan').'.',
            'ref_id' => $peminjaman->id,
            'ref_type' => 'peminjaman',
        ]);

        return back()->with('success', 'Status peminjaman berhasil dicatat.');
    }

    public function destroy($id)
    {
        Peminjaman::findOrFail($id)->delete();
        return back()->with('success', 'Riwayat berhasil dihapus.');
    }
}
