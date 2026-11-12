<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'nama_barang',
        'deskripsi',
        'stok',
        'stok_tersedia',
        'kategori',
        'gambar',
        'status', // aktif | nonaktif
    ];

    /** URL gambar barang (null bila belum ada). */
    public function getGambarUrlAttribute(): ?string
    {
        if (!$this->gambar) {
        return null;
        }
        $path = ltrim(str_replace('storage/', '', $this->gambar), '/');

        return Storage::disk('public')->url($path);
    }
}
