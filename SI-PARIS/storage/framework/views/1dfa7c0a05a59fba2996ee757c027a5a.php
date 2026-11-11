<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI-PARIS - Peminjaman Alat & Inventaris SMK Negeri 5 Surakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Poppins', 'sans-serif'] } } } }
    </script>
    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Poppins', sans-serif; background: #f3f8fc; }

        /* ===== Latar aurora: putih + biru, bergerak terus ===== */
        .aurora { position: fixed; inset: 0; z-index: -10; overflow: hidden; background: #f4f9fd; animation: warna 20s ease-in-out infinite alternate; }
        .blob { position: absolute; border-radius: 9999px; filter: blur(60px); will-change: transform; }
        .b1 { width: 50vw; height: 46vw; left: -8vw;  top: -10vw;    background: rgba(125, 211, 252, 0.80); animation: gerak1 22s ease-in-out infinite; }
        .b2 { width: 56vw; height: 42vw; right: -10vw; top: 18vh;    background: rgba(34, 211, 238, 0.50);  animation: gerak2 26s ease-in-out infinite; }
        .b3 { width: 54vw; height: 46vw; left: 8vw;   bottom: -18vw; background: rgba(96, 165, 250, 0.60);  animation: gerak3 30s ease-in-out infinite; }
        .b4 { width: 36vw; height: 32vw; right: 22vw; top: -8vw;     background: rgba(165, 180, 252, 0.65); animation: gerak4 24s ease-in-out infinite; }

        /* Ukuran bola TETAP (tanpa scale). Hanya berpindah tempat, menyusuri sisi-sisi layar
           lalu kembali ke posisi awal, jadi tidak menyusut atau menumpuk ke tengah. */
        @keyframes gerak1 { 0%,100% { transform: translate(0, 0); }     33% { transform: translate(46vw, 4vh); }    66% { transform: translate(18vw, 40vh); } }
        @keyframes gerak2 { 0%,100% { transform: translate(0, 0); }     33% { transform: translate(-16vw, 34vh); } 66% { transform: translate(-44vw, 8vh); } }
        @keyframes gerak3 { 0%,100% { transform: translate(0, 0); }     33% { transform: translate(40vw, -4vh); }   66% { transform: translate(64vw, -26vh); } }
        @keyframes gerak4 { 0%,100% { transform: translate(0, 0); }     33% { transform: translate(-36vw, 12vh); }  66% { transform: translate(-10vw, 40vh); } }
        /* warna ikut bergeser pelan di antara biru langit, cyan, dan biru */
        @keyframes warna  { from { filter: hue-rotate(-12deg); } to { filter: hue-rotate(20deg); } }

        /* Pengguna yang mematikan animasi sistem: tetap bergerak, tapi lebih pelan */
        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            .blob, .aurora { animation-duration: 60s; }
        }

        /* ===== Kaca putih tanpa garis tepi ===== */
        .glass {
            background: rgba(255, 255, 255, 0.60);
            -webkit-backdrop-filter: blur(18px) saturate(150%);
            backdrop-filter: blur(18px) saturate(150%);
            box-shadow: 0 10px 32px rgba(37, 99, 235, 0.12);
        }
        .tile { background: rgba(255, 255, 255, 0.60); }
    </style>
</head>
<body class="text-slate-700 antialiased min-h-screen relative overflow-x-hidden">

    <div class="aurora" aria-hidden="true">
        <div class="blob b1"></div>
        <div class="blob b2"></div>
        <div class="blob b3"></div>
        <div class="blob b4"></div>
    </div>

    <!-- Navigasi -->
    <header class="px-4 pt-4 relative z-30">
        <div class="max-w-6xl mx-auto px-5 py-3 grid grid-cols-[auto_1fr_auto] items-center gap-4">
            <a href="<?php echo e(url('/')); ?>" class="flex items-center gap-3 rounded focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">
                <span class="bg-blue-600 text-white rounded-lg w-9 h-9 flex items-center justify-center font-bold">P</span>
                <span class="leading-tight">
                    <span class="block text-sm font-bold text-blue-950">SI-PARIS</span>
                    <span class="block text-[11px] text-slate-500">SMK Negeri 5 Surakarta</span>
                </span>
            </a>

            <nav class="hidden md:flex items-center justify-center gap-10 text-sm font-medium text-slate-600" aria-label="Navigasi halaman">
                <a href="#peran">Peran</a>
                <a href="#alur">Alur</a>
                <a href="#rekap">Rekap</a>
            </nav>
            <span class="md:hidden"></span>

            <div class="flex items-center gap-2">
                <a href="<?php echo e(route('login')); ?>" class="text-sm font-semibold text-blue-700 px-4 py-2 rounded-lg focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-600">Masuk</a>
                <a href="<?php echo e(route('register')); ?>" class="text-sm font-semibold bg-blue-600 text-white px-5 py-2 rounded-lg focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Daftar</a>
            </div>
        </div>
    </header>

    <main>
    <!-- Hero: pas satu layar, semua teks terlihat utuh -->
    <section class="max-w-4xl mx-auto px-5 min-h-[calc(100svh-5.5rem)] flex flex-col items-center justify-center text-center py-12">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight text-blue-950">
            Pinjam alat sekolah tanpa <span class="whitespace-nowrap">bolak-balik</span> ke ruang inventaris.
        </h1>
        <p class="mt-5 text-slate-600 leading-relaxed max-w-xl">
            Ajukan peminjaman dari ponsel atau komputer, tunggu persetujuan petugas, lalu pantau statusnya sampai barang kembali.
        </p>
    </section>

    <!-- Contoh pengajuan (kiri) + Masuk sesuai peran (kanan) -->
    <section class="max-w-6xl mx-auto px-5 pb-16 grid lg:grid-cols-2 gap-6 items-stretch">

        <!-- Contoh pengajuan -->
        <div class="glass rounded-3xl p-6 md:p-8" aria-label="Contoh status peminjaman">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs text-slate-400">Contoh pengajuan</p>
                    <p class="text-lg font-bold text-blue-950">Proyektor &times; 1</p>
                    <p class="text-sm text-slate-500">Untuk latihan presentasi di kelas</p>
                </div>
                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-blue-100 text-blue-700 whitespace-nowrap">Barang Diambil</span>
            </div>

            <ol class="mt-8">
                <li class="flex gap-4">
                    <div class="flex flex-col items-center">
                        <span class="w-3 h-3 rounded-full bg-blue-600 mt-1.5 ring-4 ring-blue-100"></span>
                        <span class="w-px flex-1 bg-blue-300"></span>
                    </div>
                    <div class="pb-6">
                        <p class="text-sm font-semibold text-blue-950">Diajukan</p>
                        <p class="text-xs text-slate-500">Menunggu ACC petugas</p>
                    </div>
                </li>
                <li class="flex gap-4">
                    <div class="flex flex-col items-center">
                        <span class="w-3 h-3 rounded-full bg-blue-600 mt-1.5 ring-4 ring-blue-100"></span>
                        <span class="w-px flex-1 bg-blue-300"></span>
                    </div>
                    <div class="pb-6">
                        <p class="text-sm font-semibold text-blue-950">Disetujui petugas</p>
                        <p class="text-xs text-slate-500">Jumlah dan foto barang sudah dikonfirmasi</p>
                    </div>
                </li>
                <li class="flex gap-4">
                    <div class="flex flex-col items-center">
                        <span class="w-3 h-3 rounded-full bg-blue-600 mt-1.5 ring-4 ring-blue-100"></span>
                        <span class="w-px flex-1 bg-slate-300"></span>
                    </div>
                    <div class="pb-6">
                        <p class="text-sm font-semibold text-blue-950">Barang diambil</p>
                        <p class="text-xs text-slate-500">Foto bukti pengambilan sudah diunggah</p>
                    </div>
                </li>
                <li class="flex gap-4">
                    <div class="flex flex-col items-center">
                        <span class="w-3 h-3 rounded-full bg-slate-300 mt-1.5"></span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-400">Dikembalikan</p>
                        <p class="text-xs text-slate-400">Menunggu pengembalian</p>
                    </div>
                </li>
            </ol>
        </div>

        <!-- Masuk sesuai peran -->
        <div id="peran" class="glass rounded-3xl p-6 md:p-8 scroll-mt-24">
            <h2 class="text-xl font-bold text-blue-950">Masuk sesuai peran Anda</h2>
            <p class="mt-1 text-sm text-slate-600">Siswa dan guru meminjam alat. Petugas menyetujui dan mengelola inventaris.</p>

            <div class="mt-6 space-y-3">
                <?php
                    $peran = [
                        ['Siswa', 'Meminjam alat sekolah. Masuk dengan NIS dan tanggal lahir.', 'siswa', route('register.siswa')],
                        ['Guru', 'Meminjam alat untuk keperluan mengajar. Masuk dengan NIP dan password.', 'guru', route('register.guru')],
                    ];
                ?>
                <?php $__currentLoopData = $peran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$nama, $isi, $kode, $daftar]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="tile rounded-2xl p-4 flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <h3 class="font-semibold text-blue-950"><?php echo e($nama); ?></h3>
                            <p class="mt-0.5 text-xs text-slate-600"><?php echo e($isi); ?></p>
                        </div>
                        <div class="flex flex-col gap-2 shrink-0">
                            <a href="<?php echo e(route('login', ['role' => $kode])); ?>" class="w-20 text-center text-sm font-semibold bg-blue-600 text-white py-1.5 rounded-lg focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Masuk</a>
                            <a href="<?php echo e($daftar); ?>" class="w-20 text-center text-sm font-semibold bg-blue-100 text-blue-700 py-1.5 rounded-lg focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Daftar</a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    <!-- Alur -->
    <section id="alur" class="max-w-6xl mx-auto px-5 pb-16 scroll-mt-24">
        <h2 class="text-2xl font-bold text-blue-950 text-center">Dari pengajuan sampai barang kembali</h2>

        <ol class="mt-8 grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <?php $__currentLoopData = [
                ['Ajukan', 'Pilih barang, jumlah, keperluan, dan tanggal pinjam serta kembali.'],
                ['Disetujui petugas', 'Petugas menerima notifikasi, mengecek barang, lalu menyetujui atau menolak.'],
                ['Ambil barang', 'Ambil di ruang inventaris, lalu unggah foto sebagai bukti terima.'],
                ['Kembalikan atau laporkan', 'Kembalikan tepat waktu, perpanjang, atau laporkan jika barang bermasalah.'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => [$judul, $isi]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="glass rounded-2xl p-6">
                    <span class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-sm font-bold"><?php echo e($i + 1); ?></span>
                    <p class="mt-3 text-sm font-semibold text-blue-950"><?php echo e($judul); ?></p>
                    <p class="mt-1 text-sm text-slate-600"><?php echo e($isi); ?></p>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ol>
    </section>

    <!-- Rekap -->
    <section id="rekap" class="max-w-6xl mx-auto px-5 pb-16 scroll-mt-24">
        <div class="glass rounded-3xl p-7 md:p-9 grid md:grid-cols-[1fr_auto] gap-6 items-center">
            <div>
                <h2 class="text-2xl font-bold text-blue-950">Rekap barang yang rapi untuk petugas</h2>
                <p class="mt-3 text-slate-600 max-w-lg">Barang dikembalikan dan barang rusak dipisah. Unduh sebagai file Excel atau cetak langsung untuk arsip.</p>
            </div>
            <div class="flex gap-3 flex-wrap">
                <span class="tile text-blue-800 rounded-lg px-4 py-2 text-sm font-medium">Barang dikembalikan</span>
                <span class="tile text-blue-800 rounded-lg px-4 py-2 text-sm font-medium">Barang rusak</span>
                <span class="bg-blue-600 text-white rounded-lg px-4 py-2 text-sm font-medium">Excel &amp; cetak</span>
            </div>
        </div>
    </section>
    </main>

    <footer class="max-w-6xl mx-auto px-5 pb-8">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 text-sm text-slate-500">
            <p>SI-PARIS &middot; SMK Negeri 5 Surakarta</p>
            <a href="<?php echo e(route('login')); ?>" class="font-semibold text-blue-700">Masuk ke sistem</a>
        </div>
    </footer>
</body>
</html><?php /**PATH C:\htdocs\SI-PARIS\SI-PARIS\SI-PARIS\resources\views/welcome.blade.php ENDPATH**/ ?>