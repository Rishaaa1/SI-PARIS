<?php $__env->startSection('title', 'Laporan'); ?>
<?php $__env->startSection('page-title', 'Laporan'); ?>

<?php $__env->startSection('content'); ?>
<?php
    // Barang yang sedang dipinjam (disetujui / diambil): id peminjaman => info
    $dataPinjam = $peminjamanAktif->mapWithKeys(fn ($p) => [$p->id => [
        'nama' => $p->nama_barang,
        'jumlah' => $p->jumlah,
        'kode' => $p->kode_peminjaman,
        'gambar' => !empty($gambarBarang[$p->barang_id]) ? asset('storage/'.$gambarBarang[$p->barang_id]) : null,
    ]]);
?>
<div class="w-full bg-gradient-to-br from-blue-600 to-blue-800 rounded-2xl p-5 md:p-8">
<div class="grid lg:grid-cols-3 gap-6 items-start" x-data="{ jenis: '<?php echo e(old('jenis', $jenisTersedia[0] ?? 'kendala')); ?>', pilih: '<?php echo e(old('peminjaman_id')); ?>', jumlah: '<?php echo e(old('jumlah')); ?>', data: <?php echo e(\Illuminate\Support\Js::from($dataPinjam)); ?> }">
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6 md:p-8">
        <h3 class="font-semibold text-gray-800 mb-1">Laporan Kendala / Perpanjangan / Pengembalian</h3>
        <p class="text-xs text-gray-400 mb-5">Isi form sesuai kebutuhan Anda.</p>

        <div class="flex bg-blue-100 rounded-xl p-1 mb-5 text-sm">
            <?php if(in_array('kendala', $jenisTersedia)): ?>
            <button type="button" @click="jenis = 'kendala'" :class="jenis==='kendala' ? 'bg-blue-600 text-white shadow' : 'text-blue-700'" class="flex-1 py-2 rounded-lg font-semibold transition">Laporan Kendala</button>
            <?php endif; ?>
            <?php if(in_array('perpanjangan', $jenisTersedia)): ?>
            <button type="button" @click="jenis = 'perpanjangan'" :class="jenis==='perpanjangan' ? 'bg-blue-600 text-white shadow' : 'text-blue-700'" class="flex-1 py-2 rounded-lg font-semibold transition">Perpanjangan</button>
            <?php endif; ?>
            <?php if(in_array('pengembalian', $jenisTersedia)): ?>
            <button type="button" @click="jenis = 'pengembalian'" :class="jenis==='pengembalian' ? 'bg-blue-600 text-white shadow' : 'text-blue-700'" class="flex-1 py-2 rounded-lg font-semibold transition">Pengembalian</button>
            <?php endif; ?>
        </div>

        <?php if($errors->any()): ?>
            <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-600 text-sm"><?php echo e($errors->first()); ?></div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('peminjam.laporan.store')); ?>" enctype="multipart/form-data" class="space-y-4">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="jenis" :value="jenis">

            <!-- Satu pilihan: barang yang sedang dipinjam -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Barang</label>
                <select name="peminjaman_id" x-model="pilih"
                        @change="jumlah = data[pilih] ? data[pilih].jumlah : ''"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Pilih barang</option>
                    <?php $__currentLoopData = $peminjamanAktif; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($p->id); ?>"><?php echo e($p->nama_barang); ?> &times; <?php echo e($p->jumlah); ?> (<?php echo e($p->kode_peminjaman); ?>)</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <p class="text-xs text-gray-400 mt-1">Hanya barang yang sedang Anda pinjam (sudah disetujui petugas) yang bisa dilaporkan.</p>

                <?php if($peminjamanAktif->isEmpty()): ?>
                    <p class="mt-2 text-xs text-orange-600 bg-orange-50 rounded-lg p-3">Anda belum punya barang yang sedang dipinjam, jadi belum ada yang bisa dilaporkan.</p>
                <?php endif; ?>

                <div x-show="pilih && data[pilih]" style="display:none" class="mt-3 flex items-center gap-3 bg-blue-50 rounded-lg p-3">
                    <template x-if="data[pilih] && data[pilih].gambar">
                        <img :src="data[pilih].gambar" :alt="data[pilih].nama" @click="foto = data[pilih].gambar" class="w-16 h-16 rounded-lg object-cover cursor-zoom-in">
                    </template>
                    <div class="text-sm">
                        <p class="font-semibold text-gray-800" x-text="data[pilih] ? data[pilih].nama : ''"></p>
                        <p class="text-xs text-gray-500" x-text="data[pilih] ? 'Kode ' + data[pilih].kode + ' · dipinjam ' + data[pilih].jumlah + ' unit' : ''"></p>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                <input type="number" min="1" name="jumlah" x-model="jumlah" :max="data[pilih] ? data[pilih].jumlah : null" placeholder="Masukkan jumlah" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div x-show="jenis === 'kendala'">
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kendala</label>
                <textarea name="deskripsi_kendala" rows="3" placeholder="Jelaskan kendala yang terjadi..." class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo e(old('deskripsi_kendala')); ?></textarea>
            </div>

            <div x-show="jenis !== 'kendala'">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengembalian</label>
                <input type="date" name="tanggal_pengembalian_baru" value="<?php echo e(old('tanggal_pengembalian_baru')); ?>" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div x-show="jenis === 'kendala'">
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Foto (jika ada kendala)</label>
                <input type="file" name="foto" accept="image/*" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white">
            </div>

            <button type="submit" <?php echo e($peminjamanAktif->isEmpty() ? 'disabled' : ''); ?> class="w-full bg-blue-600 hover:bg-blue-700 disabled:opacity-50 text-white font-semibold py-2.5 rounded-lg transition">Kirim Laporan</button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 md:p-8">
        <h3 class="font-semibold text-gray-800 mb-4">Riwayat Laporan</h3>
        <div class="space-y-3">
            <?php $__empty_1 = true; $__currentLoopData = $riwayatLaporan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="border border-blue-100 bg-blue-50 rounded-lg p-3">
                    <div class="flex items-center justify-between mb-1">
                        <p class="text-sm font-semibold"><?php echo e($l->nama_barang); ?></p>
                        <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $l->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($l->status)]); ?>
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
                    <p class="text-xs text-gray-400"><?php echo e($l->jenisLabel()); ?> &middot; <?php echo e($l->created_at->format('d M Y')); ?></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-sm text-gray-400">Belum ada laporan.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\htdocs\SI-PARIS\SI-PARIS\SI-PARIS\resources\views/peminjam/laporan.blade.php ENDPATH**/ ?>