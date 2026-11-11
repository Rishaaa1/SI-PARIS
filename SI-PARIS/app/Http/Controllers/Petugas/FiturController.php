<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Fitur;
use Illuminate\Http\Request;

class FiturController extends Controller
{
    public function index()
    {
        $fitur = Fitur::latest()->get();
        return view('petugas.fitur', compact('fitur'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_fitur' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        Fitur::create([
            'nama_fitur' => $request->nama_fitur,
            'deskripsi' => $request->deskripsi,
            'status' => 'aktif',
        ]);

        return back()->with('success', 'Fitur berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $fitur = Fitur::findOrFail($id);
        $request->validate([
            'nama_fitur' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        $fitur->update($request->only('nama_fitur', 'deskripsi'));

        return back()->with('success', 'Fitur berhasil diperbarui.');
    }

    public function toggleStatus($id)
    {
        $fitur = Fitur::findOrFail($id);
        $fitur->update(['status' => $fitur->status === 'aktif' ? 'nonaktif' : 'aktif']);

        return back()->with('success', 'Status fitur diperbarui.');
    }

    public function destroy($id)
    {
        Fitur::findOrFail($id)->delete();
        return back()->with('success', 'Fitur berhasil dihapus.');
    }
}
