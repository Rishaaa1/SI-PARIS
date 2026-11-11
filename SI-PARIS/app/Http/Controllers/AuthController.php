<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    /* ------------------------------------------------------------------
     |  Halaman
     * ----------------------------------------------------------------*/

    public function showLogin()
    {
        return view('auth.login');
    }

    // Pilihan daftar: Siswa, Guru, atau Petugas
    public function showRegisterPilih()
    {
        return view('auth.register-pilih');
    }

    public function showRegisterSiswa()
    {
        return view('auth.register-siswa');
    }

    public function showRegisterGuru()
    {
        return view('auth.register-guru');
    }

    public function showRegisterPetugas()
    {
        return view('auth.register-petugas', ['butuhKode' => filled(config('app.petugas_kode'))]);
    }

    /* ------------------------------------------------------------------
     |  Register
     * ----------------------------------------------------------------*/

    // Register siswa: NIS, tanggal lahir, nama, kelas
    public function registerSiswa(Request $request)
    {
        $data = $request->validate([
            'nis' => 'required|string|max:30|unique:users,nis',
            'tanggal_lahir' => 'required|date',
            'nama_lengkap' => 'required|string|max:100',
            'kelas' => 'required|string|max:30',
        ], [
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS sudah terdaftar.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'nama_lengkap.required' => 'Nama wajib diisi.',
            'kelas.required' => 'Kelas wajib diisi.',
        ]);

        $tanggalLahir = Carbon::parse($data['tanggal_lahir'])->format('Y-m-d');

        User::create([
            'nama_lengkap' => $data['nama_lengkap'],
            'nis' => $data['nis'],
            'kelas' => $data['kelas'],
            'tanggal_lahir' => $tanggalLahir,
            'role' => 'siswa',
            // login siswa memakai tanggal lahir, jadi disimpan sebagai password (di-hash)
            'password' => Hash::make($tanggalLahir),
        ]);

        return redirect()->route('login')
            ->with('success', 'Pendaftaran siswa berhasil. Silakan login dengan NIS dan tanggal lahir.')
            ->with('tab', 'siswa');
    }

    // Register guru: NIP, nama, password
    public function registerGuru(Request $request)
    {
        $data = $request->validate([
            'nip' => 'required|string|max:30|unique:users,nip',
            'nama_lengkap' => 'required|string|max:100',
            'password' => 'required|string|min:6',
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP sudah terdaftar.',
            'nama_lengkap.required' => 'Nama wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        User::create([
            'nama_lengkap' => $data['nama_lengkap'],
            'nip' => $data['nip'],
            'role' => 'guru',
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('login')
            ->with('success', 'Pendaftaran guru berhasil. Silakan login dengan NIP dan password.')
            ->with('tab', 'guru');
    }

    // Register petugas: nama + password (+ kode rahasia bila PETUGAS_KODE diisi di .env)
    public function registerPetugas(Request $request)
    {
        $rules = [
            'nama_lengkap' => [
                'required', 'string', 'max:100',
                Rule::unique('users', 'nama_lengkap')->where('role', 'petugas'),
            ],
            'password' => 'required|string|min:6',
        ];

        $kode = config('app.petugas_kode');
        if (filled($kode)) {
            $rules['kode'] = 'required|string';
        }

        $data = $request->validate($rules, [
            'nama_lengkap.required' => 'Nama wajib diisi.',
            'nama_lengkap.unique' => 'Nama petugas sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'kode.required' => 'Kode petugas wajib diisi.',
        ]);

        if (filled($kode) && !hash_equals((string) $kode, (string) $request->kode)) {
            return back()->withErrors(['kode' => 'Kode petugas salah.'])->withInput($request->only('nama_lengkap'));
        }

        User::create([
            'nama_lengkap' => $data['nama_lengkap'],
            'role' => 'petugas',
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('login')
            ->with('success', 'Pendaftaran petugas berhasil. Silakan login dengan nama dan password.')
            ->with('tab', 'petugas');
    }

    /* ------------------------------------------------------------------
     |  Login
     * ----------------------------------------------------------------*/

    // Login siswa: NIS + tanggal lahir
    public function loginSiswa(Request $request)
    {
        $request->validate([
            'nis' => 'required|string',
            'tanggal_lahir' => 'required|date',
        ], [
            'nis.required' => 'NIS wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
        ]);

        $nis = trim($request->nis);
        $tanggalLahir = Carbon::parse($request->tanggal_lahir)->format('Y-m-d');

        $user = User::where('role', 'siswa')->where('nis', $nis)->first();

        if (!$user) {
            return back()->withErrors(['nis' => 'NIS belum terdaftar. Silakan daftar dulu.'])
                ->withInput($request->only('_form', 'nis', 'tanggal_lahir'))
                ->with('tab', 'siswa');
        }

        if (Auth::attempt(['nis' => $nis, 'password' => $tanggalLahir, 'role' => 'siswa'])) {
            $request->session()->regenerate();
            return redirect()->intended('/peminjam/dashboard');
        }

        return back()->withErrors(['tanggal_lahir' => 'Tanggal lahir tidak cocok dengan yang didaftarkan untuk NIS ini.'])
            ->withInput($request->only('_form', 'nis', 'tanggal_lahir'))
            ->with('tab', 'siswa');
    }

    // Login guru: NIP + password
    public function loginGuru(Request $request)
    {
        $request->validate([
            'nip' => 'required|string',
            'password' => 'required|string',
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::attempt(['nip' => $request->nip, 'password' => $request->password, 'role' => 'guru'])) {
            $request->session()->regenerate();
            return redirect()->intended('/peminjam/dashboard');
        }

        return back()->withErrors(['nip' => 'NIP atau password salah.'])
            ->withInput($request->only('_form', 'nip'))
            ->with('tab', 'guru');
    }

    // Login petugas: nama + password
    public function loginPetugas(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'password' => 'required|string',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::attempt(['nama_lengkap' => $request->nama, 'password' => $request->password, 'role' => 'petugas'])) {
            $request->session()->regenerate();
            return redirect()->intended('/petugas/dashboard');
        }

        return back()->withErrors(['nama' => 'Nama atau password salah.'])
            ->withInput($request->only('_form', 'nama'))
            ->with('tab', 'petugas');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Setelah logout kembali ke halaman depan (welcome).
        // Alamat relatif: tetap di host & port yang sedang dipakai (mis. 127.0.0.1:8000)
        return new \Illuminate\Http\RedirectResponse('/');
    }
}