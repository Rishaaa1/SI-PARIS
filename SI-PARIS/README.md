# SI-PARIS — Sistem Peminjaman Alat / Inventaris (SMK Negeri 5 Surakarta)

Aplikasi **Laravel 10 (PHP + MySQL)**. Sistem dibagi menjadi **dua sisi**:

1. **Peminjam** — terdiri dari **Siswa (Ekstrakurikuler)** dan **Guru**
2. **Petugas** — bertindak sebagai admin (menerima notifikasi, ACC, kelola data, rekap)

## Login & Register

Halaman login memiliki pilihan **Peminjam** (Siswa / Guru) dan **Petugas**.
Register hanya untuk peminjam: pilih **Siswa** atau **Guru** dulu di `/register`.

| Akun    | Register                           | Login                |
|---------|------------------------------------|----------------------|
| Siswa   | NIS, Tanggal Lahir, Nama, Kelas    | NIS + Tanggal Lahir  |
| Guru    | NIP, Nama, Password                | NIP + Password       |
| Petugas | Nama, Password (+ kode bila `PETUGAS_KODE` di `.env` diisi) | Nama + Password      |

> Untuk siswa, tanggal lahir (format `YYYY-MM-DD`) disimpan sebagai password ter-hash, jadi proses login memakai mekanisme Laravel biasa.

## Peminjam (Siswa & Guru) — tampilan & alur sama
- Dashboard (peminjaman aktif, menunggu ACC, total histori, laporan, peminjaman terbaru)
- Ajukan peminjaman → **notifikasi masuk ke Petugas**
- Detail peminjaman + upload foto bukti pengambilan setelah disetujui
- Pengembalian / Laporan (kendala + foto, perpanjangan, pengembalian)
- Histori peminjaman sendiri

## Petugas (sistem sama seperti file admin + fitur baru)
- Dashboard ringkasan + notifikasi terbaru
- **Notifikasi Pengajuan** → ACC (isi jumlah + foto barang) atau Tolak
- **Notifikasi Laporan** → Proses (status peminjaman otomatis jadi Dikembalikan / Rusak / tanggal baru)
- **Rekap Barang (BARU)**
  - Dipisah jadi tab **Barang Dikembalikan** dan **Barang Rusak**
  - Filter tanggal & jenis peminjam (siswa/guru)
  - **Export Excel (.xlsx)** — semua (2 sheet: Dikembalikan & Rusak) atau per jenis
  - **Cetak** — halaman siap print (semua / per jenis) dengan kop dan kolom tanda tangan
- Histori Peminjaman (filter jenis, kelas, status) + tombol **Catat Kembali** untuk mencatat langsung barang Dikembalikan / Rusak
- Kelola Barang, Kelola Fitur, Data Siswa (tambah: NIS, nama, kelas, tanggal lahir), Data Guru (tambah: NIP, nama, password)
- Pengingat pengembalian ke peminjam (barang yang sedang dipinjam / terlambat)

## Kebutuhan Sistem
- PHP >= 8.1, Composer, MySQL / MariaDB
- Ekstensi PHP: pdo_mysql, mbstring, openssl, tokenizer, xml, ctype, json, fileinfo, gd, **zip** (untuk export .xlsx; jika `zip` tidak aktif, export otomatis menjadi file .xls yang tetap bisa dibuka di Excel)

## Instalasi (Windows / XAMPP)
1. **Start MySQL** di XAMPP (kalau tidak, muncul error `No connection could be made`).
2. Buat database `peminjaman_alat` (atau sesuaikan `DB_*` di `.env`).
3. Klik dua kali **`setup.bat`** (menjalankan migrate:fresh + seed + storage:link + server).

Database lama (skema admin/siswa/guru) juga bisa dinaikkan tanpa hapus data dengan `php artisan migrate` — akun admin lama menjadi petugas (login: nama lengkap + password lamanya). Akun siswa lama perlu didaftarkan ulang karena login siswa sekarang memakai tanggal lahir.

## Instalasi manual
```bash
composer install            # lewati bila folder vendor/ sudah ada
php artisan key:generate    # lewati bila APP_KEY di .env sudah terisi
# buat database "peminjaman_alat" (atau sesuaikan DB_* di .env)
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```
Buka http://localhost:8000

> **Penting:** struktur database berubah (kolom `siswa_id`→`peminjam_id`, `guru_id`→`petugas_id`, role `admin`→`petugas`, tambah `tanggal_lahir`, dll). Jalankan `php artisan migrate:fresh --seed` — data lama akan terhapus.

## Akun
Tidak ada akun bawaan. Semua akun dibuat lewat halaman **Register** (`/register`): siswa, guru, dan petugas mendaftar sendiri, lalu login memakai data yang didaftarkan. Daftar **petugas** dulu supaya ada yang mengelola sistem.

## Alur Sistem
1. Peminjam (siswa/guru) login → ajukan peminjaman → status *Menunggu ACC*.
2. Notifikasi masuk ke **Petugas** → ACC / Tolak.
3. Peminjam upload foto bukti ambil barang → status *Barang Diambil*.
4. Pengembalian / kendala dilaporkan lewat menu Laporan (atau dicatat langsung oleh Petugas) → masuk **Rekap Barang** (Dikembalikan / Rusak).
5. Petugas melihat rekap, export Excel, atau cetak.
