<?php

namespace App\Support;

use App\Models\Fitur;

/**
 * Cek apakah sebuah fitur sedang AKTIF di menu "Kelola Fitur".
 * Fitur yang dimatikan disembunyikan dari menu dan tidak bisa dibuka lewat alamat langsung.
 */
class FiturAkses
{
    /** @var array<string,string>|null  nama fitur (huruf kecil) => status */
    private static ?array $peta = null;

    public static function aktif(string $nama): bool
    {
        if (self::$peta === null) {
            self::$peta = [];
            try {
                foreach (Fitur::all(['nama_fitur', 'status']) as $f) {
                    self::$peta[mb_strtolower(trim($f->nama_fitur))] = $f->status;
                }
            } catch (\Throwable $e) {
                self::$peta = [];   // tabel belum ada: anggap semua aktif
            }
        }

        $kunci = mb_strtolower(trim($nama));

        // Fitur yang tidak terdaftar di tabel dianggap aktif
        return !array_key_exists($kunci, self::$peta) || self::$peta[$kunci] === 'aktif';
    }

    /** True bila minimal salah satu fitur aktif. */
    public static function adaYangAktif(string ...$nama): bool
    {
        foreach ($nama as $n) {
            if (self::aktif($n)) {
                return true;
            }
        }

        return false;
    }
}