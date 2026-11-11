<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::latest()->get();
        return view('petugas.barang', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:100',
            'kategori' => 'nullable|string|max:100',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ], [
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.max' => 'Ukuran gambar maksimal 3 MB.',
        ]);

        $path = null;
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('barang', 'public');
        }

        Barang::create([
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok,
            'stok_tersedia' => $request->stok,
            'gambar' => $path,
            'status' => 'aktif',
        ]);

        return back()->with('success', 'Barang berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'nama_barang' => 'required|string|max:100',
            'kategori' => 'nullable|string|max:100',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ], [
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.max' => 'Ukuran gambar maksimal 3 MB.',
        ]);

        $data = $request->only('nama_barang', 'kategori', 'stok', 'deskripsi');

        // Jumlah tersedia ikut menyesuaikan selisih stok
        $selisih = (int) $request->stok - (int) $barang->stok;
        $data['stok_tersedia'] = max(0, (int) $barang->stok_tersedia + $selisih);

        if ($request->hasFile('gambar')) {
            if ($barang->gambar) {
                Storage::disk('public')->delete($barang->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('barang', 'public');
        }

        $barang->update($data);

        return back()->with('success', 'Barang berhasil diperbarui.');
    }

    public function toggleStatus($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->update(['status' => $barang->status === 'aktif' ? 'nonaktif' : 'aktif']);
        return back()->with('success', 'Status barang diperbarui.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->gambar) {
            Storage::disk('public')->delete($barang->gambar);
        }

        $barang->delete();

        return back()->with('success', 'Barang berhasil dihapus.');
    }
}
