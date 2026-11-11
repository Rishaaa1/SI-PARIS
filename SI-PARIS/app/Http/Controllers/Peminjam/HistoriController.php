<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class HistoriController extends Controller
{
    public function index()
    {
        $histori = Peminjaman::with('barang')->where('peminjam_id', Auth::id())->latest()->get();
        return view('peminjam.histori', compact('histori'));
    }
}
