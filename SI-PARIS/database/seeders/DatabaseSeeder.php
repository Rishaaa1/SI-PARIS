<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Fitur;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Tidak ada akun bawaan: petugas, guru, dan siswa mendaftar sendiri lewat halaman Register.

        // Barang / Inventaris
        $barangList = [
            ['nama_barang' => 'Proyektor', 'kategori' => 'Elektronik', 'stok' => 5, 'stok_tersedia' => 4],
            ['nama_barang' => 'Kamera DSLR', 'kategori' => 'Elektronik', 'stok' => 3, 'stok_tersedia' => 2],
            ['nama_barang' => 'Tripod', 'kategori' => 'Aksesoris', 'stok' => 6, 'stok_tersedia' => 5],
            ['nama_barang' => 'Laptop', 'kategori' => 'Elektronik', 'stok' => 10, 'stok_tersedia' => 8],
            ['nama_barang' => 'Mikrofon', 'kategori' => 'Elektronik', 'stok' => 4, 'stok_tersedia' => 4],
        ];

        foreach ($barangList as $barang) {
            Barang::create(array_merge($barang, ['status' => 'aktif']));
        }

        // Fitur sistem (dikelola petugas)
        $fiturList = [
            ['nama_fitur' => 'Peminjaman Alat', 'deskripsi' => 'Mengajukan peminjaman alat'],
            ['nama_fitur' => 'Pengembalian Barang', 'deskripsi' => 'Mengembalikan barang'],
            ['nama_fitur' => 'Laporan', 'deskripsi' => 'Melaporkan kendala'],
            ['nama_fitur' => 'Histori Peminjaman', 'deskripsi' => 'Melihat histori peminjaman'],
            ['nama_fitur' => 'Notifikasi Petugas', 'deskripsi' => 'Notifikasi pengajuan peminjam ke petugas'],
            ['nama_fitur' => 'Rekap Barang', 'deskripsi' => 'Rekap barang dikembalikan & rusak (Excel/cetak)'],
        ];

        foreach ($fiturList as $fitur) {
            Fitur::create(array_merge($fitur, ['status' => 'aktif']));
        }
    }
}
