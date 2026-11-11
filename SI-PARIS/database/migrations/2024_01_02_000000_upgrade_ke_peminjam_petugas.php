<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

/**
 * Mengubah database LAMA (admin/guru/siswa) menjadi skema baru (petugas/peminjam).
 * Aman dijalankan di database baru: semua langkah dilewati bila sudah sesuai.
 */
return new class extends Migration
{
    public function up(): void
    {
        $mysql = in_array(DB::getDriverName(), ['mysql', 'mariadb'], true);

        /* ---------------- users ---------------- */
        if (Schema::hasColumn('users', 'username')) {
            if ($mysql) {
                DB::statement("ALTER TABLE users MODIFY role ENUM('admin','petugas','guru','siswa') NOT NULL DEFAULT 'siswa'");
            }

            DB::table('users')->where('role', 'admin')->update(['role' => 'petugas']);

            if ($mysql) {
                DB::statement("ALTER TABLE users MODIFY role ENUM('petugas','guru','siswa') NOT NULL DEFAULT 'siswa'");
            }

            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('username');
            });
        }

        if (!Schema::hasColumn('users', 'tanggal_lahir')) {
            Schema::table('users', function (Blueprint $table) {
                $table->date('tanggal_lahir')->nullable();
            });
        }

        /* ---------------- peminjaman ---------------- */
        if (Schema::hasColumn('peminjaman', 'siswa_id')) {
            Schema::table('peminjaman', function (Blueprint $table) {
                $table->dropForeign(['siswa_id']);
                $table->dropForeign(['guru_id']);
            });

            Schema::table('peminjaman', function (Blueprint $table) {
                $table->renameColumn('siswa_id', 'peminjam_id');
                $table->renameColumn('guru_id', 'petugas_id');
                $table->renameColumn('catatan_guru', 'catatan_petugas');
            });

            Schema::table('peminjaman', function (Blueprint $table) {
                $table->foreign('peminjam_id')->references('id')->on('users')->cascadeOnDelete();
                $table->foreign('petugas_id')->references('id')->on('users')->nullOnDelete();
            });
        }

        Schema::table('peminjaman', function (Blueprint $table) {
            if (!Schema::hasColumn('peminjaman', 'selesai_at')) {
                $table->timestamp('selesai_at')->nullable();
            }
            if (!Schema::hasColumn('peminjaman', 'catatan_selesai')) {
                $table->text('catatan_selesai')->nullable();
            }
            if (!Schema::hasColumn('peminjaman', 'foto_kendala')) {
                $table->string('foto_kendala')->nullable();
            }
        });

        /* ---------------- laporan ---------------- */
        if (Schema::hasColumn('laporan', 'siswa_id')) {
            Schema::table('laporan', function (Blueprint $table) {
                $table->dropForeign(['siswa_id']);
            });

            Schema::table('laporan', function (Blueprint $table) {
                $table->renameColumn('siswa_id', 'peminjam_id');
            });

            Schema::table('laporan', function (Blueprint $table) {
                $table->foreign('peminjam_id')->references('id')->on('users')->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        // tidak ada rollback; gunakan migrate:fresh bila perlu
    }
};
