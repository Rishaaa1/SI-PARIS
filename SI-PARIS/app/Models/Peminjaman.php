<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'kode_peminjaman',
        'peminjam_id',
        'barang_id',
        'nama_barang',
        'jumlah',
        'keperluan',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status', // menunggu | disetujui | ditolak | diambil | dikembalikan | rusak
        'petugas_id',
        'jumlah_acc',
        'gambar_acc',
        'gambar_terima',
        'catatan_petugas',
        'diproses_at',
        'selesai_at',
        'catatan_selesai',
        'foto_kendala',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
        'diproses_at' => 'datetime',
        'selesai_at' => 'datetime',
    ];

    /** URL foto bukti pengambilan barang (null bila belum diambil). */
    public function getGambarTerimaUrlAttribute(): ?string
    {
        return $this->gambar_terima ? asset('storage/'.$this->gambar_terima) : null;
    }

    public function peminjam()
    {
        return $this->belongsTo(User::class, 'peminjam_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'peminjaman_id');
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'menunggu' => 'Menunggu ACC',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            'diambil' => 'Barang Diambil',
            'dikembalikan' => 'Dikembalikan',
            'rusak' => 'Barang Rusak',
            default => ucfirst($this->status),
        };
    }
}
