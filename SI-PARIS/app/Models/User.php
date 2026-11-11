<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama_lengkap',
        'nis',
        'nip',
        'tanggal_lahir',
        'kelas',
        'jabatan',
        'role', // petugas | guru | siswa
        'password',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'tanggal_lahir' => 'date',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'peminjam_id');
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'peminjam_id');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'user_id');
    }

    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    /** Siswa & guru sama-sama berstatus peminjam. */
    public function isPeminjam(): bool
    {
        return in_array($this->role, ['siswa', 'guru'], true);
    }

    /** Label jenis akun untuk tampilan. */
    public function getJenisLabelAttribute(): string
    {
        return match ($this->role) {
            'siswa' => 'Siswa',
            'guru' => 'Guru',
            'petugas' => 'Petugas',
            default => ucfirst((string) $this->role),
        };
    }

    /** Siswa -> kelas, Guru -> "Guru" (dipakai di daftar/notifikasi). */
    public function getKeteranganAttribute(): string
    {
        if ($this->role === 'siswa') {
            return $this->kelas ?: 'Siswa';
        }

        return $this->jabatan ?: 'Guru';
    }

    /** NIS untuk siswa, NIP untuk guru. */
    public function getNomorIndukAttribute(): ?string
    {
        return $this->role === 'siswa' ? $this->nis : $this->nip;
    }
}
