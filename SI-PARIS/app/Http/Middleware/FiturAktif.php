<?php

namespace App\Http\Middleware;

use App\Support\FiturAkses;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Pemakaian di route:  ->middleware(FiturAktif::class.':Rekap Barang')
 * Boleh lebih dari satu nama (dipisah koma): lolos jika salah satunya aktif.
 */
class FiturAktif
{
    public function handle(Request $request, Closure $next, string ...$nama)
    {
        if (FiturAkses::adaYangAktif(...$nama)) {
            return $next($request);
        }

        $tujuan = (Auth::check() && Auth::user()->role === 'petugas')
            ? '/petugas/dashboard'
            : '/peminjam/dashboard';

        return redirect()->to($tujuan)
            ->with('error', 'Fitur "'.implode('" / "', $nama).'" sedang dinonaktifkan.');
    }
}