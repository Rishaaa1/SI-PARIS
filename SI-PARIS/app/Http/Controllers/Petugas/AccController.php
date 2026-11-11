<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccController extends Controller
{
    public function show($id)
    {
        $peminjaman = Peminjaman::with('peminjam', 'petugas', 'barang')->findOrFail($id);
        return view('petugas.acc', compact('peminjaman'));
    }

    // ACC peminjaman: jumlah disetujui + catatan + foto bukti barang siap diambil (diupload petugas)
    public function acc(Request $request, $id)
    {
        $request->validate([
            'jumlah_acc' => 'required|integer|min:1',
            'catatan_petugas' => 'nullable|string|max:500',
            'foto_acc' => 'required|image|mimes:jpg,jpeg,png,webp|max:3072',
        ], [
            'foto_acc.required' => 'Foto bukti barang wajib diupload sebelum ACC.',
            'foto_acc.image' => 'File harus berupa gambar.',
            'foto_acc.mimes' => 'Foto harus berformat JPG, PNG, atau WEBP.',
            'foto_acc.max' => 'Ukuran foto maksimal 3 MB.',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
            return redirect()->route('petugas.notifikasi')->with('error', 'Pengajuan ini sudah diproses.');
        }

        $pathFoto = $request->file('foto_acc')->store('acc-barang', 'public');

        $peminjaman->update([
            'status' => 'disetujui',
            'petugas_id' => Auth::id(),
            'gambar_acc' => $pathFoto,
            'jumlah_acc' => $request->jumlah_acc,
            'catatan_petugas' => $request->catatan_petugas,
            'diproses_at' => now(), // waktu persetujuan tercatat
        ]);

        Notifikasi::where('ref_id', $peminjaman->id)
            ->where('ref_type', 'peminjaman')
            ->update(['dibaca' => true]);

        Notifikasi::create([
            'user_id' => $peminjaman->peminjam_id,
            'dari_user_id' => Auth::id(),
            'jenis' => 'info',
            'judul' => 'Barang Siap Diambil',
            'pesan' => 'Peminjaman '.$peminjaman->nama_barang.' telah disetujui. Barang sudah siap diambil di ruang inventaris, lihat bukti fotonya di detail peminjaman. Upload foto saat barang sudah diterima.',
            'ref_id' => $peminjaman->id,
            'ref_type' => 'peminjaman',
        ]);

        return redirect()->route('petugas.notifikasi')->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function tolak(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
            return redirect()->route('petugas.notifikasi')->with('error', 'Pengajuan ini sudah diproses.');
        }

        $peminjaman->update([
            'status' => 'ditolak',
            'petugas_id' => Auth::id(),
            'catatan_petugas' => $request->catatan_petugas,
            'diproses_at' => now(),
        ]);

        Notifikasi::where('ref_id', $peminjaman->id)->where('ref_type', 'peminjaman')->update(['dibaca' => true]);

        Notifikasi::create([
            'user_id' => $peminjaman->peminjam_id,
            'dari_user_id' => Auth::id(),
            'jenis' => 'info',
            'judul' => 'Peminjaman Anda Ditolak',
            'pesan' => 'Peminjaman '.$peminjaman->nama_barang.' ditolak oleh petugas.'.($request->catatan_petugas ? ' Catatan: '.$request->catatan_petugas : ''),
            'ref_id' => $peminjaman->id,
            'ref_type' => 'peminjaman',
        ]);

        return redirect()->route('petugas.notifikasi')->with('success', 'Peminjaman ditolak.');
    }
}