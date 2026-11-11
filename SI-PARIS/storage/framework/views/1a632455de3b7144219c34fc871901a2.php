<?php $__env->startSection('title', 'Histori Peminjaman'); ?>
<?php $__env->startSection('page-title', 'Histori Peminjaman'); ?>

<?php $__env->startSection('content'); ?>
<div class="w-full bg-gradient-to-br from-blue-600 to-blue-800 rounded-2xl p-5 md:p-8">
<div class="bg-white rounded-xl shadow-sm p-6 md:p-8">
    <h3 class="font-semibold text-gray-800 mb-4">Histori Peminjaman Saya</h3>
    <div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead>
            <tr class="text-left text-gray-400 border-b border-blue-100">
                <th class="py-2 font-medium">No</th>
                <th class="py-2 font-medium">Barang</th>
                <th class="py-2 font-medium">Jumlah</th>
                <th class="py-2 font-medium">Tgl Pinjam</th>
                <th class="py-2 font-medium">Tgl Kembali</th>
                <th class="py-2 font-medium">Foto Pengambilan</th>
                <th class="py-2 font-medium">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $histori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="border-b border-blue-50">
                <td class="py-4"><?php echo e($i + 1); ?></td>
                <td class="py-4">
                    <div class="flex items-center gap-3">
                        <?php if($h->barang && $h->barang->gambar_url): ?>
                            <img src="<?php echo e($h->barang->gambar_url); ?>" @click="foto = '<?php echo e($h->barang->gambar_url); ?>'" alt="" class="w-10 h-10 rounded-lg object-cover border border-gray-100 cursor-zoom-in">
                        <?php endif; ?>
                        <span><?php echo e($h->nama_barang); ?></span>
                    </div>
                </td>
                <td class="py-4"><?php echo e($h->jumlah); ?></td>
                <td class="py-4"><?php echo e($h->tanggal_pinjam->format('d M Y')); ?></td>
                <td class="py-4"><?php echo e($h->tanggal_kembali->format('d M Y')); ?></td>
                <td class="py-4">
                    <?php if($h->gambar_terima_url): ?>
                        <img src="<?php echo e($h->gambar_terima_url); ?>" @click="foto = '<?php echo e($h->gambar_terima_url); ?>'" alt="Foto pengambilan" class="w-14 h-14 rounded-lg object-cover border border-gray-100 cursor-zoom-in">
                    <?php else: ?>
                        <span class="text-xs text-gray-400">Belum diambil</span>
                    <?php endif; ?>
                </td>
                <td class="py-4"><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $h->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($h->status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $attributes = $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $component = $__componentOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="7" class="py-6 text-center text-gray-400">Belum ada histori.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\htdocs\SI-PARIS\SI-PARIS\SI-PARIS\resources\views/peminjam/histori.blade.php ENDPATH**/ ?>