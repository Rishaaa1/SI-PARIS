<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Notifikasi;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PeminjamanController extends Controller
{
    public function index()
    {
        $barang = Barang::where('status', 'aktif')->get();
        $riwayat = Peminjaman::where('peminjam_id', Auth::id())->latest()->get();

        return view('peminjam.peminjaman', compact('barang', 'riwayat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
            'keperluan' => 'required|string',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $barang = Barang::findOrFail($request->barang_id);
        $user = Auth::user();

        $peminjaman = Peminjaman::create([
            'kode_peminjaman' => 'PJM-'.strtoupper(Str::random(6)),
            'peminjam_id' => $user->id,
            'barang_id' => $barang->id,
            'nama_barang' => $barang->nama_barang,
            'jumlah' => $request->jumlah,
            'keperluan' => $request->keperluan,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'menunggu',
        ]);

        // Notifikasi pengajuan masuk ke petugas
        $petugasList = User::where('role', 'petugas')->get();
        foreach ($petugasList as $petugas) {
            Notifikasi::create([
                'user_id' => $petugas->id,
                'dari_user_id' => $user->id,
                'jenis' => 'pengajuan',
                'judul' => 'Pengajuan Peminjaman Baru',
                'pesan' => $user->nama_lengkap.' ('.$user->jenis_label.' - '.$user->keterangan.') mengajukan peminjaman '.$barang->nama_barang.' ('.$request->jumlah.')',
                'ref_id' => $peminjaman->id,
                'ref_type' => 'peminjaman',
            ]);
        }

        return redirect()->route('peminjam.peminjaman.detail', $peminjaman->id)
            ->with('success', 'Pengajuan peminjaman berhasil dikirim. Menunggu persetujuan petugas.');
    }

    public function detail($id)
    {
        $peminjaman = Peminjaman::where('peminjam_id', Auth::id())->findOrFail($id);

        // Notifikasi terkait peminjaman ini dianggap sudah dibaca
        Notifikasi::where('user_id', Auth::id())
            ->where('ref_type', 'peminjaman')
            ->where('ref_id', $peminjaman->id)
            ->update(['dibaca' => true]);

        return view('peminjam.detail-peminjaman', compact('peminjaman'));
    }

    public function uploadFoto(Request $request, $id)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:3072',
        ]);

        $peminjaman = Peminjaman::where('peminjam_id', Auth::id())->findOrFail($id);

        if ($peminjaman->status !== 'disetujui') {
            return back()->with('error', 'Peminjaman belum disetujui petugas.');
        }

        $path = $request->file('foto')->store('bukti-terima', 'public');

        $peminjaman->update([
            'gambar_terima' => $path,
            'status' => 'diambil',
        ]);

        return redirect()->route('peminjam.peminjaman.detail', $peminjaman->id)
            ->with('success', 'Foto berhasil diupload. Barang berhasil diambil.');
    }
}