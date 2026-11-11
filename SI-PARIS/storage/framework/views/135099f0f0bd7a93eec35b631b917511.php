<?php $__env->startSection('title', 'ACC Peminjaman'); ?>
<?php $__env->startSection('page-title', 'Setujui Peminjaman Alat / Inventaris'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $pj = $peminjaman;
    $diajukan = $pj->created_at->copy()->timezone('Asia/Jakarta')->locale('id');

    // Bukti foto: diupload petugas saat ACC (tampil di sini & di sisi peminjam)
    $fotoAcc    = $pj->gambar_acc ? asset('storage/'.$pj->gambar_acc) : null;
    $fotoTerima = $pj->gambar_terima ? asset('storage/'.$pj->gambar_terima) : null;
?>

<div class="w-full max-w-7xl mx-auto space-y-6">

    <!-- Bukti pengajuan (waktu real-time tercatat) -->
    <div class="bg-white rounded-2xl border border-blue-100 shadow-sm p-6 md:p-8">
        <div class="flex items-start justify-between gap-3 flex-wrap">
            <div>
                <p class="text-xs text-gray-400">Bukti Pengajuan Peminjaman</p>
                <p class="text-2xl font-bold text-gray-800"><?php echo e($pj->kode_peminjaman); ?></p>
            </div>
            <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $pj->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pj->status)]); ?>
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

        <div class="mt-5 grid md:grid-cols-2 gap-4">
            <div class="rounded-xl bg-blue-50 border border-blue-100 p-5">
                <p class="text-xs text-blue-700">Waktu pengajuan tercatat</p>
                <p class="text-base md:text-lg font-semibold text-blue-700">
                    <?php echo e($diajukan->translatedFormat('l, d F Y')); ?> pukul <?php echo e($diajukan->format('H:i:s')); ?> WIB
                </p>
                <p class="text-xs text-gray-500 mt-1">
                    Masuk <span data-ago="<?php echo e($pj->created_at->toIso8601String()); ?>" class="font-medium"></span>
                </p>
            </div>

            <div class="rounded-xl bg-blue-50 border border-blue-100 p-5">
                <p class="text-xs text-blue-700">Status pemrosesan</p>
                <?php if($pj->diproses_at): ?>
                    <?php $diproses = $pj->diproses_at->copy()->timezone('Asia/Jakarta')->locale('id'); ?>
                    <p class="text-base md:text-lg font-semibold text-blue-700">
                        <?php echo e($pj->status === 'ditolak' ? 'Ditolak' : 'Disetujui'); ?>

                        <?php echo e($diproses->translatedFormat('d F Y')); ?> pukul <?php echo e($diproses->format('H:i:s')); ?> WIB
                    </p>
                    <?php if($pj->petugas): ?>
                        <p class="text-xs text-gray-500 mt-1">oleh <?php echo e($pj->petugas->nama_lengkap); ?></p>
                    <?php endif; ?>
                <?php else: ?>
                    <p class="text-base md:text-lg font-semibold text-blue-700">Belum diproses</p>
                    <p class="text-xs text-gray-500 mt-1">Menunggu keputusan petugas.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-5 gap-6 items-start" x-data="{ prev: null }">

        <!-- KIRI: data permintaan + bukti foto -->
        <div class="lg:col-span-3 space-y-6">

            <div class="bg-white rounded-2xl border border-blue-100 shadow-sm p-6 md:p-8">
                <p class="text-sm font-semibold text-gray-600 mb-5">Data Permintaan</p>
                <div class="grid sm:grid-cols-2 gap-x-8 gap-y-5 text-sm">
                    <div class="sm:col-span-2">
                        <p class="text-gray-400 text-xs mb-1">Nama Peminjam</p>
                        <p class="font-medium text-base"><?php echo e($pj->peminjam->nama_lengkap); ?> (<?php echo e($pj->peminjam->jenis_label); ?> &middot; <?php echo e($pj->peminjam->keterangan); ?>)</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs mb-1">Nama Barang</p>
                        <p class="font-medium text-base"><?php echo e($pj->nama_barang); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs mb-1">Jumlah</p>
                        <p class="font-medium text-base"><?php echo e($pj->jumlah); ?></p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-gray-400 text-xs mb-1">Keperluan</p>
                        <p class="font-medium text-base"><?php echo e($pj->keperluan); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs mb-1">Tanggal Pinjam</p>
                        <p class="font-medium text-base"><?php echo e($pj->tanggal_pinjam->format('d M Y')); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs mb-1">Tanggal Kembali</p>
                        <p class="font-medium text-base"><?php echo e($pj->tanggal_kembali->format('d M Y')); ?></p>
                    </div>
                </div>
            </div>

            <!-- BUKTI FOTO (diupload petugas) -->
            <div class="bg-white rounded-2xl border border-blue-100 shadow-sm p-6 md:p-8">
                <p class="text-sm font-semibold text-gray-600">Bukti Foto</p>
                <p class="text-xs text-gray-400 mb-5">Foto yang diupload petugas sebagai bukti barang siap diambil. Setelah ACC, foto ini bisa dilihat peminjam. Klik foto untuk memperbesar.</p>

                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <p class="text-xs text-gray-400 mb-2">Foto dari petugas</p>
                        <?php if($fotoAcc): ?>
                            <img src="<?php echo e($fotoAcc); ?>" @click="foto = '<?php echo e($fotoAcc); ?>'" alt="Foto dari petugas"
                                 class="w-full h-64 object-cover rounded-xl border border-blue-100 cursor-zoom-in">
                        <?php else: ?>
                            <template x-if="prev">
                                <img :src="prev" @click="foto = prev" alt="Pratinjau foto"
                                     class="w-full h-64 object-cover rounded-xl border border-blue-100 cursor-zoom-in">
                            </template>
                            <div x-show="!prev" class="w-full h-64 rounded-xl bg-blue-50 border border-dashed border-blue-200 text-blue-400 flex items-center justify-center text-sm text-center px-4">
                                Belum ada foto. Upload foto di form Persetujuan, fotonya akan muncul di sini.
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if($fotoTerima): ?>
                        <div>
                            <p class="text-xs text-gray-400 mb-2">Foto bukti pengambilan peminjam</p>
                            <img src="<?php echo e($fotoTerima); ?>" @click="foto = '<?php echo e($fotoTerima); ?>'" alt="Foto pengambilan"
                                 class="w-full h-64 object-cover rounded-xl border border-blue-100 cursor-zoom-in">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- KANAN: persetujuan -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-blue-100 shadow-sm p-6 md:p-8 lg:sticky lg:top-24">
            <p class="text-sm font-semibold text-gray-600 mb-5">Persetujuan</p>

            <?php if($errors->any()): ?>
                <div class="mb-3 p-3 rounded-lg bg-red-50 text-red-600 text-sm"><?php echo e($errors->first()); ?></div>
            <?php endif; ?>

            <?php if($pj->status !== 'menunggu'): ?>
                <div class="p-4 rounded-lg bg-gray-50 text-gray-600 text-sm">
                    Pengajuan ini sudah diproses.
                    <?php if($pj->jumlah_acc): ?> Jumlah disetujui: <strong><?php echo e($pj->jumlah_acc); ?></strong>. <?php endif; ?>
                    <?php if($pj->catatan_petugas): ?> <br>Catatan: <?php echo e($pj->catatan_petugas); ?> <?php endif; ?>
                </div>
            <?php else: ?>
                <form method="POST" action="<?php echo e(route('petugas.acc.store', $pj->id)); ?>" enctype="multipart/form-data" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang</label>
                        <input type="text" value="<?php echo e($pj->nama_barang); ?>" disabled class="w-full border border-gray-200 bg-gray-50 rounded-lg px-3 py-2.5 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Disetujui</label>
                        <input type="number" name="jumlah_acc" min="1" value="<?php echo e(old('jumlah_acc', $pj->jumlah)); ?>" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Barang (bukti siap diambil)</label>
                        <input type="file" name="foto_acc" accept="image/*" required
                               @change="prev = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white">
                        <p class="text-xs text-gray-400 mt-1">JPG, PNG, atau WEBP, maksimal 3 MB. Peminjam akan melihat foto ini.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (opsional)</label>
                        <textarea name="catatan_petugas" rows="4" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo e(old('catatan_petugas')); ?></textarea>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit" formaction="<?php echo e(route('petugas.acc.tolak', $pj->id)); ?>" formnovalidate class="flex-1 border border-gray-200 text-gray-600 font-semibold py-2.5 rounded-lg hover:bg-gray-50">Tolak</button>
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg">ACC</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <a href="<?php echo e(route('petugas.notifikasi')); ?>" class="inline-block text-sm text-blue-600 font-medium hover:text-blue-800">&larr; Kembali ke notifikasi</a>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\htdocs\SI-PARIS\SI-PARIS\SI-PARIS\resources\views/petugas/acc.blade.php ENDPATH**/ ?>