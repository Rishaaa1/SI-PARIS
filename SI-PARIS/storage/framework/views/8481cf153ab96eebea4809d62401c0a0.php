<?php $__env->startSection('title', 'Dashboard Petugas'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<div class="space-y-6">

    
     <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800">Halo, <?php echo e(explode(' ', auth()->user()->nama_lengkap)[0]); ?>! 👋</h2>
        <p class="text-gray-500 text-sm">Kelola peminjaman alat / inventaris dari siswa dan guru.</p>
    </div>

    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

        <div class="bg-blue-100 rounded-2xl p-5 border border-blue-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-2xl font-bold text-blue-700">
                        <?php echo e($totalSiswa); ?>

                    </p>
                    <p class="text-xs text-blue-800 mt-1">Total Siswa</p>
                </div>
            </div>
        </div>

        <div class="bg-blue-100 rounded-2xl p-5 border border-blue-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-2xl font-bold text-blue-700">
                        <?php echo e($totalGuru); ?>

                    </p>
                    <p class="text-xs text-blue-800 mt-1">Total Guru</p>
                </div>
            </div>
        </div>

        <div class="bg-blue-100 rounded-2xl p-5 border border-blue-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-2xl font-bold text-blue-700">
                        <?php echo e($totalPeminjaman); ?>

                    </p>
                    <p class="text-xs text-blue-800 mt-1">Total Peminjaman</p>
                </div>
            </div>
        </div>

        <div class="bg-sky-100 rounded-2xl p-5 border border-sky-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-2xl font-bold text-sky-700">
                        <?php echo e($totalBarang); ?>

                    </p>
                    <p class="text-xs text-sky-800 mt-1">Total Barang</p>
                </div>
            </div>
        </div>

    </div>


    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

        <?php if(\App\Support\FiturAkses::aktif('Notifikasi Petugas')): ?>
        <a href="<?php echo e(route('petugas.notifikasi')); ?>"
           class="bg-white hover:bg-blue-100 rounded-2xl p-5 border border-blue-200 shadow-sm hover:shadow-md transition">
            <p class="text-2xl font-bold text-blue-600">
                <?php echo e($menungguAcc); ?>

            </p>
            <p class="text-xs text-gray-600 mt-1">🔔 Menunggu ACC</p>
        </a>
        <?php endif; ?>

        <?php if(\App\Support\FiturAkses::aktif('Notifikasi Petugas')): ?>
        <a href="<?php echo e(route('petugas.notifikasi.laporan')); ?>"
           class="bg-white hover:bg-blue-100 rounded-2xl p-5 border border-blue-200 shadow-sm hover:shadow-md transition">
            <p class="text-2xl font-bold text-blue-600">
                <?php echo e($laporanMenunggu); ?>

            </p>
            <p class="text-xs text-gray-600 mt-1">📄 Laporan Belum Diproses</p>
        </a>
        <?php endif; ?>

        <?php if(\App\Support\FiturAkses::aktif('Rekap Barang')): ?>
        <a href="<?php echo e(route('petugas.rekap', ['tab' => 'dikembalikan'])); ?>"
           class="bg-white hover:bg-blue-100 rounded-2xl p-5 border border-blue-200 shadow-sm hover:shadow-md transition">
            <p class="text-2xl font-bold text-emerald-600">
                <?php echo e($totalDikembalikan); ?>

            </p>
            <p class="text-xs text-gray-600 mt-1">✅ Barang Dikembalikan</p>
        </a>
        <?php endif; ?>

        <?php if(\App\Support\FiturAkses::aktif('Rekap Barang')): ?>
        <a href="<?php echo e(route('petugas.rekap', ['tab' => 'rusak'])); ?>"
           class="bg-white hover:bg-sky-100 rounded-2xl p-5 border border-sky-200 shadow-sm hover:shadow-md transition">
            <p class="text-2xl font-bold text-sky-600">
                <?php echo e($totalRusak); ?>

            </p>
            <p class="text-xs text-gray-600 mt-1">⚠️ Barang Rusak</p>
        </a>
        <?php endif; ?>

    </div>


    
    <div class="grid lg:grid-cols-2 gap-6">

        
        <?php if(\App\Support\FiturAkses::aktif('Notifikasi Petugas')): ?>
        <div class="bg-blue-50 rounded-2xl border border-blue-200 shadow-sm overflow-hidden">

            <div class="flex items-center justify-between p-5 bg-blue-200/70 border-b border-blue-200">
                <h3 class="font-bold text-blue-900 text-lg">Notifikasi Terbaru</h3>
                <a href="<?php echo e(route('petugas.notifikasi')); ?>"
                   class="text-xs font-semibold text-blue-700 bg-white px-4 py-2 rounded-full hover:bg-blue-100 transition">
                    Lihat Semua →
                </a>
            </div>

            <div class="p-5 space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $notifBaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e($n->jenis === 'laporan' ? route('petugas.notifikasi.laporan') : route('petugas.acc.show', $n->ref_id)); ?>"
                   class="block bg-white border border-blue-100 rounded-xl p-4 hover:bg-blue-100 hover:border-blue-300 transition">

                    <div class="flex gap-3 items-start">
                        <div class="bg-blue-100 rounded-full p-3 text-xl">
                            📢
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-blue-950">
                                <?php echo e($n->judul); ?>

                            </p>
                            <p class="text-xs text-gray-600 mt-1">
                                <?php echo e($n->pesan); ?>

                            </p>
                            <p class="text-xs text-blue-500 mt-2">
                                🕒 <?php echo e($n->created_at->copy()->timezone('Asia/Jakarta')->format('d M Y, H:i:s')); ?> WIB
                            </p>
                        </div>
                    </div>
                </a>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <div class="text-center py-8">
                    <p class="text-sm text-blue-500 mt-2">
                        Tidak ada notifikasi baru.
                    </p>
                </div>

                <?php endif; ?>

            </div>
        </div>
        <?php endif; ?>


        
        <div class="space-y-6">

            
            <div class="bg-blue-50 rounded-2xl border border-blue-200 shadow-sm overflow-hidden">

                <div class="p-5 bg-blue-200/70 border-b border-blue-200">
                    <h3 class="font-bold text-blue-900 text-lg">
                        Aktivitas Terbaru
                    </h3>
                </div>

                <div class="p-5 space-y-4">

                    <?php $__empty_1 = true; $__currentLoopData = $aktivitasTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <div class="flex items-center justify-between gap-3 border-b border-blue-200 pb-4 last:border-0 last:pb-0">

                        <div class="flex items-center gap-3 min-w-0">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-blue-950">
                                    <?php echo e($a->peminjam->nama_lengkap ?? '-'); ?>

                                    <span class="text-xs font-normal text-gray-500">
                                        (<?php echo e($a->peminjam->jenis_label ?? '-'); ?>)
                                    </span>
                                </p>

                                <p class="text-xs text-gray-600">
                                    <?php echo e($a->nama_barang); ?>

                                </p>

                                <p class="text-xs text-blue-500 mt-1">
                                    🕒 <?php echo e($a->created_at->copy()->timezone('Asia/Jakarta')->format('d M Y, H:i:s')); ?> WIB
                                </p>
                            </div>

                        </div>

                        <div class="shrink-0">
                            <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $a->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($a->status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $attributes = $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $component = $__componentOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
                        </div>

                    </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <div class="text-center py-6">
                        <span class="text-4xl">📭</span>
                        <p class="text-sm text-blue-500 mt-2">
                            Belum ada aktivitas.
                        </p>
                    </div>

                    <?php endif; ?>

                </div>
            </div>

            
            <div class="bg-blue-50 rounded-2xl border border-blue-200 shadow-sm overflow-hidden">

                <div class="p-5 bg-blue-200/70 border-b border-blue-200">
                    <h3 class="font-bold text-blue-900 text-lg">
                         Pengingat
                    </h3>
                </div>

                <div class="p-5">

                    <?php if($terlambat > 0): ?>

                    <div class="bg-sky-100 border border-sky-300 rounded-xl p-4 mb-4">
                        <p class="text-sm text-sky-700">
                            ⚠️ Ada <?php echo e($terlambat); ?> peminjaman yang melewati batas tanggal pengembalian.
                        </p>
                    </div>

                    <?php else: ?>

                    <div class="bg-blue-100 border border-blue-200 rounded-xl p-4 mb-4">
                        <p class="text-sm text-blue-800">
                            ✓ Tidak ada peminjaman yang terlambat dikembalikan.
                        </p>
                    </div>

                    <?php endif; ?>

                    <?php if(\App\Support\FiturAkses::aktif('Histori Peminjaman')): ?>

                    <a href="<?php echo e(route('petugas.histori', ['status' => 'diambil'])); ?>"
                       class="inline-block bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold px-5 py-2.5 rounded-full shadow-sm transition">
                        Lihat Detail →
                    </a>

                    <?php endif; ?>

                </div>
            </div>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\htdocs\SI-PARIS\SI-PARIS\SI-PARIS\resources\views/petugas/dashboard.blade.php ENDPATH**/ ?>