<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

/**
 * Halaman cetak Histori Peminjaman (mengikuti filter jenis, kelas, dan status
 * yang sedang dipilih di halaman Histori).
 */
class HistoriCetakController extends Controller
{
    private const STATUS = [
        'menunggu' => 'Menunggu ACC',
        'disetujui' => 'Disetujui',
        'ditolak' => 'Ditolak',
        'diambil' => 'Barang Diambil',
        'dikembalikan' => 'Dikembalikan',
        'rusak' => 'Barang Rusak',
    ];

    public function __invoke(Request $request)
    {
        $jenis = in_array($request->get('jenis'), ['siswa', 'guru'], true) ? $request->get('jenis') : null;
        $kelas = $request->get('kelas');
        $status = array_key_exists((string) $request->get('status'), self::STATUS) ? $request->get('status') : null;

        $query = Peminjaman::with('peminjam');

        if ($jenis) {
            $query->whereHas('peminjam', fn ($q) => $q->where('role', $jenis));
        }
        if ($kelas) {
            $query->whereHas('peminjam', fn ($q) => $q->where('role', 'siswa')->where('kelas', $kelas));
        }
        if ($status) {
            $query->where('status', $status);
        }

        $histori = $query->latest()->get();
        $statusLabel = self::STATUS;
        $auto = $request->boolean('auto', true);

        return view('petugas.histori-cetak', compact('histori', 'jenis', 'kelas', 'status', 'statusLabel', 'auto'));
    }
}