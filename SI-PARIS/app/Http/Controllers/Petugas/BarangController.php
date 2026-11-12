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

    // Menambahkan barang baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:100',
            'kategori' => 'nullable|string|max:100',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image',
        ], [
            'gambar.image' => 'File harus berupa gambar.',
        ]);

        $path = null;

        // Upload gambar
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')
                ->store('barang', 'public');
        }

        Barang::create([
            'nama_barang' => $validated['nama_barang'],
            'kategori' => $validated['kategori'] ?? null,
            'deskripsi' => $validated['deskripsi'] ?? null,
            'stok' => $validated['stok'],
            'stok_tersedia' => $validated['stok'],
            'gambar' => $path,
            'status' => 'aktif',
        ]);

        return back()->with(
            'success',
            'Barang berhasil ditambahkan.'
        );
    }

    // Mengubah data barang
    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $validated = $request->validate([
            'nama_barang' => 'required|string|max:100',
            'kategori' => 'nullable|string|max:100',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image',
        ], [
            'gambar.image' => 'File harus berupa gambar.',
        ]);

        $data = [
            'nama_barang' => $validated['nama_barang'],
            'kategori' => $validated['kategori'] ?? null,
            'deskripsi' => $validated['deskripsi'] ?? null,
            'stok' => $validated['stok'],
        ];

        // Menyesuaikan stok tersedia berdasarkan perubahan stok
        $selisih = (int) $validated['stok'] - (int) $barang->stok;

        $data['stok_tersedia'] = max(
            0,
            (int) $barang->stok_tersedia + $selisih
        );

        // Jika ada gambar baru
        if ($request->hasFile('gambar')) {

            // Simpan gambar baru terlebih dahulu
            $pathBaru = $request->file('gambar')
                ->store('barang', 'public');

            // Hapus gambar lama
            if ($barang->gambar) {
                $gambarLama = str_replace(
                    'storage/',
                    '',
                    $barang->gambar
                );

                Storage::disk('public')->delete($gambarLama);
            }

            $data['gambar'] = $pathBaru;
        }

        $barang->update($data);

        return back()->with(
            'success',
            'Barang berhasil diperbarui.'
        );
    }

    // Mengubah status barang
    public function toggleStatus($id)
    {
        $barang = Barang::findOrFail($id);

        $barang->update([
            'status' => $barang->status === 'aktif'
                ? 'nonaktif'
                : 'aktif'
        ]);

        return back()->with(
            'success',
            'Status barang diperbarui.'
        );
    }

    // Menghapus barang
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        // Hapus file gambar dari storage
        if ($barang->gambar) {
            $gambar = str_replace(
                'storage/',
                '',
                $barang->gambar
            );

            Storage::disk('public')->delete($gambar);
        }

        $barang->delete();

        return back()->with(
            'success',
            'Barang berhasil dihapus.'
        );
    }
}
