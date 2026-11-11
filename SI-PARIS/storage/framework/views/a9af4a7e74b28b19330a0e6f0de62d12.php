<?php $__env->startSection('title', 'Peminjaman Alat'); ?>
<?php $__env->startSection('page-title', 'Peminjaman Alat'); ?>

<?php $__env->startSection('content'); ?>
<style>body{background-color:#dbeafe !important;}</style>
<?php
    // Data barang untuk pratinjau di form (id => info)
    $dataBarang = $barang->mapWithKeys(fn ($b) => [$b->id => [
        'nama' => $b->nama_barang,
        'kategori' => $b->kategori,
        'tersedia' => $b->stok_tersedia,
        'gambar' => $b->gambar ? asset('storage/'.$b->gambar) : null,
    ]]);
?>
<div class="w-full bg-gradient-to-br from-blue-600 to-blue-800 rounded-2xl p-5 md:p-8">
<div class="grid lg:grid-cols-3 gap-6 items-start" x-data="{ pilih: '', data: <?php echo e(\Illuminate\Support\Js::from($dataBarang)); ?> }">

    <!-- Form pengajuan -->
    <div class="lg:col-span-1 bg-white rounded-xl shadow-sm p-6 md:p-8 h-fit">
        <h3 class="font-semibold text-gray-800 mb-1">Peminjaman Alat / Inventaris</h3>
        <p class="text-xs text-gray-400 mb-5">Pilih barang di daftar atau lewat form ini, lalu isi data peminjaman.</p>

        <?php if($errors->any()): ?>
            <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-600 text-sm"><?php echo e($errors->first()); ?></div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('peminjam.peminjaman.store')); ?>" class="space-y-4">
            <?php echo csrf_field(); ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang</label>
                <select name="barang_id" x-model="pilih" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Pilih Barang</option>
                    <?php $__currentLoopData = $barang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($b->id); ?>"><?php echo e($b->nama_barang); ?> (tersedia <?php echo e($b->stok_tersedia); ?>)</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <!-- Pratinjau detail barang yang dipilih -->
                <div x-show="pilih && data[pilih]" style="display:none" class="mt-4 bg-blue-50 border border-blue-100 rounded-xl p-4 space-y-3">
                    <template x-if="data[pilih] && data[pilih].gambar">
                        <img :src="data[pilih].gambar" :alt="data[pilih].nama" @click="foto = data[pilih].gambar" class="w-full h-52 rounded-lg object-cover cursor-zoom-in">
                    </template>
                    <template x-if="data[pilih] && !data[pilih].gambar">
                        <div class="w-full h-52 rounded-lg bg-blue-100 text-blue-300 flex items-center justify-center text-sm">Belum ada gambar</div>
                    </template>
                    <div class="text-sm">
                        <p class="text-base font-semibold text-gray-800" x-text="data[pilih] ? data[pilih].nama : ''"></p>
                        <p class="text-gray-500" x-text="data[pilih] && data[pilih].kategori ? 'Kategori: ' + data[pilih].kategori : ''"></p>
                        <p class="font-medium text-blue-700" x-text="data[pilih] ? 'Tersedia: ' + data[pilih].tersedia : ''"></p>
                    </div>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                <input type="number" min="1" name="jumlah" value="<?php echo e(old('jumlah')); ?>" placeholder="Masukkan jumlah" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Keperluan</label>
                <textarea name="keperluan" rows="3" placeholder="Tuliskan keperluan" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required><?php echo e(old('keperluan')); ?></textarea>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Peminjaman</label>
                    <input type="date" name="tanggal_pinjam" value="<?php echo e(old('tanggal_pinjam')); ?>" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengembalian</label>
                    <input type="date" name="tanggal_kembali" value="<?php echo e(old('tanggal_kembali')); ?>" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition">Ajukan Peminjaman</button>
        </form>
    </div>

    <div class="lg:col-span-2 space-y-6">

        <!-- Daftar barang bergambar -->
        <div class="bg-white rounded-xl shadow-sm p-6 md:p-8">
            <h3 class="font-semibold text-gray-800 mb-1">Daftar Barang</h3>
            <p class="text-xs text-gray-400 mb-4">Klik barang untuk memilihnya di form. Klik gambar untuk memperbesar.</p>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-5">
                <?php $__empty_1 = true; $__currentLoopData = $barang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php $gambar = $b->gambar ? asset('storage/'.$b->gambar) : null; ?>
                    <div @click="pilih = '<?php echo e($b->id); ?>'"
                         :class="pilih === '<?php echo e($b->id); ?>' ? 'ring-2 ring-blue-600 border-blue-600' : 'border-blue-100'"
                         class="group border rounded-xl overflow-hidden cursor-pointer bg-blue-50 transition-shadow duration-300 hover:shadow-lg">
                        <?php if($gambar): ?>
                            <img src="<?php echo e($gambar); ?>" alt="<?php echo e($b->nama_barang); ?>" @click.stop="foto = '<?php echo e($gambar); ?>'" class="w-full h-44 object-cover cursor-zoom-in transition-transform duration-300 ease-out group-hover:scale-125">
                        <?php else: ?>
                            <div class="w-full h-44 bg-blue-100 text-blue-400 flex items-center justify-center">
                                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        <?php endif; ?>
                        <div class="p-3 bg-blue-50">
                            <p class="text-sm font-semibold text-gray-800"><?php echo e($b->nama_barang); ?></p>
                            <p class="text-xs text-gray-500"><?php echo e($b->kategori ?: 'Tanpa kategori'); ?></p>
                            <p class="text-xs mt-1 <?php echo e($b->stok_tersedia > 0 ? 'text-green-600' : 'text-red-500'); ?>">Tersedia: <?php echo e($b->stok_tersedia); ?></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-sm text-gray-400 col-span-full">Belum ada barang yang tersedia.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Riwayat pengajuan -->
        <div class="bg-white rounded-xl shadow-sm p-6 md:p-8">
            <h3 class="font-semibold text-gray-800 mb-4">Riwayat Pengajuan</h3>
            <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-400 border-b border-gray-100">
                        <th class="py-2 font-medium">Barang</th>
                        <th class="py-2 font-medium">Jumlah</th>
                        <th class="py-2 font-medium">Tgl Pinjam</th>
                        <th class="py-2 font-medium">Status</th>
                        <th class="py-2 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $riwayat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-b border-gray-50">
                        <td class="py-4"><?php echo e($r->nama_barang); ?></td>
                        <td class="py-3"><?php echo e($r->jumlah); ?></td>
                        <td class="py-3"><?php echo e($r->tanggal_pinjam->format('d M Y')); ?></td>
                        <td class="py-3"><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $r->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($r->status)]); ?>
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
                            <a href="<?php echo e(route('peminjam.peminjaman.detail', $r->id)); ?>" class="text-blue-600 font-medium text-xs bg-blue-50 px-3 py-1.5 rounded-lg hover:bg-blue-100">Detail</a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="py-6 text-center text-gray-400">Belum ada pengajuan peminjaman.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\htdocs\SI-PARIS\SI-PARIS\SI-PARIS\resources\views/peminjam/peminjaman.blade.php ENDPATH**/ ?>