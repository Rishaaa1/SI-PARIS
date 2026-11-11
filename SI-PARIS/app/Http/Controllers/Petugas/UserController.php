<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function siswa()
    {
        $siswa = User::where('role', 'siswa')->latest()->get();
        return view('petugas.siswa', compact('siswa'));
    }

    public function storeSiswa(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nis' => 'required|string|unique:users,nis',
            'kelas' => 'required|string',
            'tanggal_lahir' => 'required|date',
        ]);

        $tanggalLahir = Carbon::parse($request->tanggal_lahir)->format('Y-m-d');

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'tanggal_lahir' => $tanggalLahir,
            'role' => 'siswa',
            'password' => Hash::make($tanggalLahir),
        ]);

        return back()->with('success', 'Siswa baru berhasil ditambahkan.');
    }

    public function guru()
    {
        $guru = User::where('role', 'guru')->latest()->get();
        return view('petugas.guru', compact('guru'));
    }

    public function storeGuru(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nip' => 'required|string|unique:users,nip',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'nip' => $request->nip,
            'role' => 'guru',
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Guru baru berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        // Hanya akun peminjam (siswa/guru) yang bisa dihapus dari sini
        User::whereIn('role', ['siswa', 'guru'])->findOrFail($id)->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }
}
