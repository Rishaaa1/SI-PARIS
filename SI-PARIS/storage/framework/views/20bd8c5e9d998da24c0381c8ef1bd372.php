<?php $__env->startSection('title', 'Dashboard Peminjam'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-800">Halo, <?php echo e(explode(' ', auth()->user()->nama_lengkap)[0]); ?>! 👋</h2>
    <p class="text-gray-500 text-sm">Selamat datang di sistem peminjaman alat / inventaris.</p>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
        <div class="w-9 h-9 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mb-3">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        </div>
        <p class="text-2xl font-bold text-gray-800"><?php echo e($peminjamanAktif); ?></p>
        <p class="text-xs text-gray-500">Peminjaman Aktif</p>
    </div>
    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
        <div class="w-9 h-9 rounded-lg bg-orange-100 text-orange-500 flex items-center justify-center mb-3">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <p class="text-2xl font-bold text-gray-800"><?php echo e($menungguAcc); ?></p>
        <p class="text-xs text-gray-500">Menunggu ACC</p>
    </div>
    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
        <div class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center mb-3">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/></svg>
        </div>
        <p class="text-2xl font-bold text-gray-800"><?php echo e($totalHistori); ?></p>
        <p class="text-xs text-gray-500">Total Histori</p>
    </div>
    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
        <div class="w-9 h-9 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center mb-3">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <p class="text-2xl font-bold text-gray-800"><?php echo e($totalLaporan); ?></p>
        <p class="text-xs text-gray-500">Laporan</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <h3 class="font-semibold text-gray-800 mb-4">Peminjaman Terbaru</h3>
        <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-400 border-b border-gray-100">
                    <th class="py-2 font-medium">No</th>
                    <th class="py-2 font-medium">Nama Barang</th>
                    <th class="py-2 font-medium">Tanggal Pinjam</th>
                    <th class="py-2 font-medium">Status</th>
                    <th class="py-2 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $peminjamanTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="border-b border-gray-50">
                    <td class="py-3"><?php echo e($i + 1); ?></td>
                    <td class="py-3"><?php echo e($p->nama_barang); ?></td>
                    <td class="py-3"><?php echo e($p->tanggal_pinjam->format('d M Y')); ?></td>
                    <td class="py-3"><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $p->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($p->status)]); ?>
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
                    <td class="py-3">
<?php if(\App\Support\FiturAkses::aktif('Peminjaman Alat')): ?>
                        <a href="<?php echo e(route('peminjam.peminjaman.detail', $p->id)); ?>" class="text-blue-600 font-medium text-xs bg-blue-50 px-3 py-1.5 rounded-lg hover:bg-blue-100">Detail</a>
<?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="py-6 text-center text-gray-400">Belum ada peminjaman.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        </div>
    </div>

    <div class="bg-blue-600 rounded-xl p-5 text-white flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="font-semibold text-sm">Informasi</p>
            </div>
            <p class="text-blue-100 text-sm leading-relaxed">Jangan lupa untuk mengembalikan barang tepat waktu ya, dan laporkan segera jika ada kendala pada alat!</p>
        </div>
<?php if(\App\Support\FiturAkses::aktif('Peminjaman Alat')): ?>
        <a href="<?php echo e(route('peminjam.peminjaman')); ?>" class="mt-4 bg-white text-blue-600 text-sm font-semibold py-2.5 rounded-lg text-center hover:bg-blue-50">Ajukan Peminjaman</a>
<?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\htdocs\SI-PARIS\SI-PARIS\SI-PARIS\resources\views/peminjam/dashboard.blade.php ENDPATH**/ ?>