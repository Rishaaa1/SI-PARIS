<?php $__env->startSection('title', 'Detail Peminjaman'); ?>
<?php $__env->startSection('page-title', 'Detail Peminjaman'); ?>

<?php $__env->startSection('content'); ?>
<style>body{background-color:#dbeafe !important;}</style>
<?php
    $steps = [
        'menunggu' => 'Menunggu',
        'disetujui' => 'Disetujui',
        'diambil' => 'Barang Diambil',
        'dikembalikan' => 'Dikembalikan',
    ];
    $order = array_keys($steps);
    $currentIndex = array_search($peminjaman->status, $order);
    if ($currentIndex === false) $currentIndex = 0;

    $fotoAcc = $peminjaman->gambar_acc ? asset('storage/'.$peminjaman->gambar_acc) : null;
    $fotoTerima = $peminjaman->gambar_terima ? asset('storage/'.$peminjaman->gambar_terima) : null;
?>

<div class="w-full bg-gradient-to-br from-blue-600 to-blue-800 rounded-2xl shadow-sm p-5 md:p-8">

    <!-- Header -->
    <div class="flex items-center justify-between gap-3 flex-wrap mb-6">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-white/15 text-white flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-white">Detail Peminjaman</h3>
                <p class="text-xs text-blue-100">No. Peminjaman: <span class="font-semibold text-white"><?php echo e($peminjaman->kode_peminjaman); ?></span></p>
            </div>
        </div>
        <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $peminjaman->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($peminjaman->status)]); ?>
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

    <div class="grid lg:grid-cols-3 gap-6 items-start">

        <!-- KIRI: informasi + aksi -->
        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white rounded-xl p-6 md:p-8 shadow-sm">
                <p class="text-sm font-semibold text-gray-600 mb-5">Informasi Peminjaman</p>
                <div class="grid sm:grid-cols-2 gap-x-8 gap-y-5 text-sm">
                    <div>
                        <p class="text-gray-400 text-xs mb-1">Nama Barang</p>
                        <p class="font-medium text-base"><?php echo e($peminjaman->nama_barang); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs mb-1">Jumlah</p>
                        <p class="font-medium text-base"><?php echo e($peminjaman->jumlah); ?></p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-gray-400 text-xs mb-1">Keperluan</p>
                        <p class="font-medium text-base"><?php echo e($peminjaman->keperluan); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs mb-1">Tanggal Pinjam</p>
                        <p class="font-medium text-base"><?php echo e($peminjaman->tanggal_pinjam->format('d M Y')); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs mb-1">Tanggal Kembali</p>
                        <p class="font-medium text-base"><?php echo e($peminjaman->tanggal_kembali->format('d M Y')); ?></p>
                    </div>
                </div>
            </div>

            <?php if($peminjaman->status === 'disetujui'): ?>
                <div class="bg-white rounded-xl p-6 md:p-8 shadow-sm border-l-4 border-blue-600">
                    <p class="text-sm text-blue-700 mb-4">Peminjaman disetujui petugas. Silakan datang ke ruang inventaris dan upload foto barang saat sudah diterima.</p>
                    <form method="POST" action="<?php echo e(route('peminjam.peminjaman.upload-foto', $peminjaman->id)); ?>" enctype="multipart/form-data" class="flex flex-col sm:flex-row gap-3">
                        <?php echo csrf_field(); ?>
                        <input type="file" name="foto" accept="image/*" required class="text-sm flex-1 border border-gray-200 rounded-lg px-3 py-2 bg-white">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg">Upload Foto</button>
                    </form>
                </div>
            <?php endif; ?>

            <?php if($fotoAcc || $fotoTerima): ?>
                <div class="bg-white rounded-xl p-6 md:p-8 shadow-sm">
                    <p class="text-sm font-semibold text-gray-600 mb-5">Foto</p>
                    <div class="grid sm:grid-cols-2 gap-5">
                        <?php if($fotoAcc): ?>
                            <div>
                                <p class="text-xs text-gray-400 mb-2">Foto barang dari petugas</p>
                                <img src="<?php echo e($fotoAcc); ?>" @click="foto = '<?php echo e($fotoAcc); ?>'" class="rounded-lg w-full h-52 object-cover border border-gray-100 cursor-zoom-in">
                            </div>
                        <?php endif; ?>
                        <?php if($fotoTerima): ?>
                            <div>
                                <p class="text-xs text-gray-400 mb-2">Foto bukti pengambilan Anda</p>
                                <img src="<?php echo e($fotoTerima); ?>" @click="foto = '<?php echo e($fotoTerima); ?>'" class="rounded-lg w-full h-52 object-cover border border-gray-100 cursor-zoom-in">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- KANAN: timeline status -->
        <div class="bg-white rounded-xl p-6 md:p-8 shadow-sm">
            <p class="text-sm font-semibold text-gray-600 mb-5">Status Pengajuan</p>
            <div class="space-y-6">
                <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $reached = array_search($key, $order) <= $currentIndex; ?>
                    <div class="flex items-start gap-3">
                        <div class="w-3.5 h-3.5 mt-1 rounded-full <?php echo e($reached ? 'bg-blue-600' : 'bg-gray-200'); ?>"></div>
                        <div>
                            <p class="text-sm font-medium <?php echo e($reached ? 'text-gray-800' : 'text-gray-400'); ?>"><?php echo e($label); ?></p>
                            <?php if($key === 'disetujui' && $peminjaman->diproses_at): ?>
                                <p class="text-xs text-gray-400"><?php echo e($peminjaman->diproses_at->format('d M Y, H:i')); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <?php if($peminjaman->status === 'ditolak'): ?>
                <div class="mt-6 p-3 rounded-lg bg-red-50 text-red-600 text-sm">
                    Pengajuan ditolak petugas.
                    <?php if($peminjaman->catatan_petugas): ?> <br>Catatan: <?php echo e($peminjaman->catatan_petugas); ?> <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <a href="<?php echo e(route('peminjam.peminjaman')); ?>" class="inline-block mt-6 bg-white hover:bg-blue-50 text-blue-700 text-sm font-semibold px-6 py-2.5 rounded-lg shadow-sm">&larr; Kembali</a>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\htdocs\SI-PARIS\SI-PARIS\SI-PARIS\resources\views/peminjam/detail-peminjaman.blade.php ENDPATH**/ ?>