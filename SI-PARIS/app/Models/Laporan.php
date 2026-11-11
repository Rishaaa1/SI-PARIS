<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'peminjam_id',
        'peminjaman_id',
        'jenis', // kendala | perpanjangan | pengembalian
        'nama_barang',
        'jumlah',
        'deskripsi_kendala',
        'foto',
        'tanggal_pengembalian_baru',
        'status', // menunggu | diproses | selesai
    ];

    protected $casts = [
        'tanggal_pengembalian_baru' => 'date',
    ];

    public function peminjam()
    {
        return $this->belongsTo(User::class, 'peminjam_id');
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    public function jenisLabel(): string
    {
        return match ($this->jenis) {
            'kendala' => 'Kendala',
            'perpanjangan' => 'Perpanjangan',
            'pengembalian' => 'Pengembalian',
            default => ucfirst($this->jenis),
        };
    }
}
