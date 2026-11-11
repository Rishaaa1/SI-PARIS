<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('nis')->nullable()->unique();      // untuk siswa (ekstrakurikuler)
            $table->date('tanggal_lahir')->nullable();         // untuk siswa (dipakai login)
            $table->string('nip')->nullable()->unique();      // untuk guru
            $table->string('kelas')->nullable();               // untuk siswa
            $table->string('jabatan')->nullable();              // untuk guru
            $table->enum('role', ['petugas', 'guru', 'siswa'])->default('siswa');
            $table->string('password');
            $table->string('foto')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
