<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function proses($id)
    {
        $laporan = Laporan::findOrFail($id);

        if ($laporan->status === 'selesai') {
            return back()->with('error', 'Laporan ini sudah diproses.');
        }

        $laporan->update(['status' => 'selesai']);

        $peminjaman = $laporan->peminjaman;

        if ($peminjaman) {
            if ($laporan->jenis === 'pengembalian') {
                $peminjaman->update([
                    'status' => 'dikembalikan',
                    'selesai_at' => $laporan->tanggal_pengembalian_baru
                        ? $laporan->tanggal_pengembalian_baru->copy()->setTimeFrom(now())
                        : now(),
                    'catatan_selesai' => $laporan->deskripsi_kendala,
                ]);
            } elseif ($laporan->jenis === 'kendala') {
                $peminjaman->update([
                    'status' => 'rusak',
                    'selesai_at' => now(),
                    'catatan_selesai' => $laporan->deskripsi_kendala,
                    'foto_kendala' => $laporan->foto,
                ]);
            } elseif ($laporan->jenis === 'perpanjangan') {
                $peminjaman->update(['tanggal_kembali' => $laporan->tanggal_pengembalian_baru]);
            }
        }

        Notifikasi::where('ref_id', $laporan->id)->where('ref_type', 'laporan')->update(['dibaca' => true]);

        Notifikasi::create([
            'user_id' => $laporan->peminjam_id,
            'dari_user_id' => Auth::id(),
            'jenis' => 'info',
            'judul' => 'Laporan Diproses',
            'pesan' => 'Laporan '.$laporan->jenisLabel().' untuk '.$laporan->nama_barang.' telah diproses oleh petugas.',
            'ref_id' => $laporan->id,
            'ref_type' => 'laporan',
        ]);

        return back()->with('success', 'Laporan berhasil diproses.');
    }
}
