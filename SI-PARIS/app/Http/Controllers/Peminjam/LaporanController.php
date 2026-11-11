<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Laporan;
use App\Models\Notifikasi;
use App\Models\Peminjaman;
use App\Models\User;
use App\Support\FiturAkses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LaporanController extends Controller
{
    /** Jenis laporan yang boleh dipakai sesuai fitur yang AKTIF di Kelola Fitur. */
    private function jenisTersedia(): array
    {
        $jenis = [];

        if (FiturAkses::aktif('Laporan')) {
            $jenis[] = 'kendala';
            $jenis[] = 'perpanjangan';
        }
        if (FiturAkses::aktif('Pengembalian Barang')) {
            $jenis[] = 'pengembalian';
        }

        return $jenis;
    }

    public function index()
    {
        // Barang yang sedang dipinjam (sudah disetujui / sudah diambil)
        $peminjamanAktif = Peminjaman::where('peminjam_id', Auth::id())
            ->whereIn('status', ['disetujui', 'diambil'])
            ->get();

        // id barang => nama file gambar (untuk pratinjau di form)
        $gambarBarang = Barang::whereIn('id', $peminjamanAktif->pluck('barang_id'))->pluck('gambar', 'id');

        $riwayatLaporan = Laporan::where('peminjam_id', Auth::id())->latest()->get();

        $jenisTersedia = $this->jenisTersedia();

        return view('peminjam.laporan', compact('peminjamanAktif', 'riwayatLaporan', 'gambarBarang', 'jenisTersedia'));
    }

    public function store(Request $request)
    {
        $rules = [
            'jenis' => ['required', Rule::in($this->jenisTersedia())],
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'jumlah' => 'required|integer|min:1',
        ];

        if ($request->jenis === 'kendala') {
            $rules['deskripsi_kendala'] = 'required|string';
            $rules['foto'] = 'required|image|mimes:jpg,jpeg,png|max:3072';
        } else {
            $rules['tanggal_pengembalian_baru'] = 'required|date';
        }

        $request->validate($rules, [
            'peminjaman_id.required' => 'Pilih barang yang akan dilaporkan.',
            'peminjaman_id.exists' => 'Barang yang dipilih tidak ditemukan.',
        ]);

        // Barang harus milik peminjam yang login dan masih dipinjam
        $peminjaman = Peminjaman::where('peminjam_id', Auth::id())
            ->whereIn('status', ['disetujui', 'diambil'])
            ->find($request->peminjaman_id);

        if (!$peminjaman) {
            return back()->withInput()->withErrors(['peminjaman_id' => 'Barang yang dipilih tidak sedang Anda pinjam.']);
        }

        if ((int) $request->jumlah > (int) $peminjaman->jumlah) {
            return back()->withInput()->withErrors(['jumlah' => 'Jumlah melebihi jumlah yang Anda pinjam ('.$peminjaman->jumlah.').']);
        }

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('laporan', 'public');
        }

        $laporan = Laporan::create([
            'peminjam_id' => Auth::id(),
            'peminjaman_id' => $peminjaman->id,
            'jenis' => $request->jenis,
            'nama_barang' => $peminjaman->nama_barang,   // otomatis dari barang yang dipilih
            'jumlah' => $request->jumlah,
            'deskripsi_kendala' => $request->deskripsi_kendala,
            'foto' => $fotoPath,
            'tanggal_pengembalian_baru' => $request->tanggal_pengembalian_baru,
            'status' => 'menunggu',
        ]);

        // Notifikasi laporan masuk ke petugas
        $user = Auth::user();
        foreach (User::where('role', 'petugas')->get() as $petugas) {
            Notifikasi::create([
                'user_id' => $petugas->id,
                'dari_user_id' => $user->id,
                'jenis' => 'laporan',
                'judul' => 'Laporan '.$laporan->jenisLabel().' Baru',
                'pesan' => $user->nama_lengkap.' ('.$user->jenis_label.') melaporkan '.$laporan->jenisLabel().' untuk '.$peminjaman->nama_barang,
                'ref_id' => $laporan->id,
                'ref_type' => 'laporan',
            ]);
        }

        return back()->with('success', 'Laporan berhasil dikirim ke petugas.');
    }
}