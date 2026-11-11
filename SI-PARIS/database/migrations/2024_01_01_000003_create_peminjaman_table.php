<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('kode_peminjaman')->unique();
            $table->foreignId('peminjam_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('barang_id')->nullable()->constrained('barang')->nullOnDelete();
            $table->string('nama_barang');
            $table->integer('jumlah');
            $table->text('keperluan')->nullable();
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'diambil', 'dikembalikan', 'rusak'])->default('menunggu');
            $table->foreignId('petugas_id')->nullable()->constrained('users')->nullOnDelete();
            $table->integer('jumlah_acc')->nullable();
            $table->string('gambar_acc')->nullable();
            $table->string('gambar_terima')->nullable();
            $table->text('catatan_petugas')->nullable();
            $table->timestamp('diproses_at')->nullable();
            $table->timestamp('selesai_at')->nullable();      // waktu barang dikembalikan / dilaporkan rusak
            $table->text('catatan_selesai')->nullable();      // keterangan pengembalian / kerusakan
            $table->string('foto_kendala')->nullable();       // foto kerusakan (dari laporan)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
