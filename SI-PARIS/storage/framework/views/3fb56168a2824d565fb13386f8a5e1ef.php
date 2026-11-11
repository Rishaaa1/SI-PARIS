<?php $__env->startSection('title', 'Notifikasi Pengajuan'); ?>
<?php $__env->startSection('page-title', 'Notifikasi Pengajuan Peminjaman'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
    <div class="flex items-start justify-between gap-3 flex-wrap mb-5">
        <div>
            <h3 class="font-semibold text-gray-800">Pengajuan dari Siswa &amp; Guru</h3>
            <p class="text-xs text-gray-400">Waktu pengajuan tercatat otomatis oleh sistem.</p>
        </div>
        <div class="text-right">
            <p class="text-xs text-gray-400">Waktu sekarang</p>
            <p class="text-sm font-semibold text-blue-700" data-jam></p>
        </div>
    </div>

    <div class="space-y-3">
        <?php $__empty_1 = true; $__currentLoopData = $pengajuan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php $t = $p->created_at->copy()->timezone('Asia/Jakarta')->locale('id'); ?>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border border-gray-100 rounded-lg p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-semibold">
                        <?php echo e(strtoupper(substr($p->peminjam->nama_lengkap, 0, 1))); ?>

                    </div>
                    <div>
                        <p class="text-sm font-semibold">
                            <?php echo e($p->peminjam->nama_lengkap); ?>

                            <span class="text-xs font-normal text-gray-400">(<?php echo e($p->peminjam->jenis_label); ?> &middot; <?php echo e($p->peminjam->keterangan); ?>)</span>
                        </p>
                        <p class="text-xs text-gray-500">Mengajukan peminjaman <?php echo e($p->nama_barang); ?> (<?php echo e($p->jumlah); ?>) &middot; <?php echo e($p->kode_peminjaman); ?></p>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Diajukan <?php echo e($t->translatedFormat('l, d F Y')); ?> pukul <?php echo e($t->format('H:i:s')); ?> WIB
                            <span class="text-blue-700 font-medium">(<span data-ago="<?php echo e($p->created_at->toIso8601String()); ?>"></span>)</span>
                        </p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="<?php echo e(route('petugas.acc.show', $p->id)); ?>" class="text-xs font-semibold border border-gray-200 text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-50">Lihat</a>
                    <a href="<?php echo e(route('petugas.acc.show', $p->id)); ?>" class="text-xs font-semibold bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">ACC</a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-sm text-gray-400">Tidak ada pengajuan yang menunggu.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\htdocs\SI-PARIS\SI-PARIS\SI-PARIS\resources\views/petugas/notifikasi.blade.php ENDPATH**/ ?>