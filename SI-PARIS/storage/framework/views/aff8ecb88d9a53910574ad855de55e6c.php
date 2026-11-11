<?php $__env->startSection('title', 'Histori Peminjaman'); ?>
<?php $__env->startSection('page-title', 'Histori Peminjaman'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
    <div class="flex items-center justify-between mb-5 flex-wrap gap-3">
        <h3 class="font-semibold text-gray-800">Histori Peminjaman Siswa &amp; Guru</h3>
        <form method="GET" class="flex items-center gap-2 flex-wrap">
            <select name="jenis" onchange="this.form.submit()" class="border border-gray-200 rounded-lg px-3 py-2 text-sm">
                <option value="">Semua Peminjam</option>
                <option value="siswa" <?php echo e($jenis === 'siswa' ? 'selected' : ''); ?>>Siswa</option>
                <option value="guru" <?php echo e($jenis === 'guru' ? 'selected' : ''); ?>>Guru</option>
            </select>
            <select name="kelas" onchange="this.form.submit()" class="border border-gray-200 rounded-lg px-3 py-2 text-sm">
                <option value="">Semua Kelas</option>
                <?php $__currentLoopData = $kelasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($k); ?>" <?php echo e($kelasDipilih === $k ? 'selected' : ''); ?>><?php echo e($k); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select name="status" onchange="this.form.submit()" class="border border-gray-200 rounded-lg px-3 py-2 text-sm">
                <option value="">Semua Status</option>
                <?php $__currentLoopData = ['menunggu' => 'Menunggu ACC', 'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak', 'diambil' => 'Barang Diambil', 'dikembalikan' => 'Dikembalikan', 'rusak' => 'Barang Rusak']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($val); ?>" <?php echo e($status === $val ? 'selected' : ''); ?>><?php echo e($lbl); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <a href="<?php echo e(route('petugas.histori.cetak', request()->query())); ?>" target="_blank"
               class="inline-flex items-center gap-2 text-sm font-semibold border border-gray-200 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak
            </a>
        </form>
    </div>

    <div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead>
            <tr class="text-left text-gray-400 border-b border-gray-100">
                <th class="py-2 font-medium">No</th>
                <th class="py-2 font-medium">Nama Peminjam</th>
                <th class="py-2 font-medium">Jenis / Kelas</th>
                <th class="py-2 font-medium">Barang</th>
                <th class="py-2 font-medium">Jumlah</th>
                <th class="py-2 font-medium">Waktu Pengajuan</th>
                <th class="py-2 font-medium">Foto Pengambilan</th>
                <th class="py-2 font-medium">Status</th>
                <th class="py-2 font-medium">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $histori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="border-b border-gray-50 align-top">
                <td class="py-3"><?php echo e($i + 1); ?></td>
                <td class="py-3"><?php echo e($h->peminjam->nama_lengkap ?? '-'); ?></td>
                <td class="py-3"><?php echo e($h->peminjam->jenis_label ?? '-'); ?><?php if(($h->peminjam->role ?? null) === 'siswa'): ?> &middot; <?php echo e($h->peminjam->kelas ?? '-'); ?><?php endif; ?></td>
                <td class="py-3">
                    <div class="flex items-center gap-3">
                        <?php if($h->barang && $h->barang->gambar_url): ?>
                            <img src="<?php echo e($h->barang->gambar_url); ?>" @click="foto = '<?php echo e($h->barang->gambar_url); ?>'" alt="" class="w-10 h-10 rounded-lg object-cover border border-gray-100 cursor-zoom-in">
                        <?php endif; ?>
                        <span><?php echo e($h->nama_barang); ?></span>
                    </div>
                </td>
                <td class="py-3"><?php echo e($h->jumlah); ?></td>
                <td class="py-3 whitespace-nowrap">
                    <?php echo e($h->created_at->copy()->timezone('Asia/Jakarta')->format('d/m/Y')); ?><br>
                    <span class="text-xs text-gray-400"><?php echo e($h->created_at->copy()->timezone('Asia/Jakarta')->format('H:i:s')); ?> WIB</span>
                </td>
                <td class="py-3">
                    <?php if($h->gambar_terima_url): ?>
                        <img src="<?php echo e($h->gambar_terima_url); ?>" @click="foto = '<?php echo e($h->gambar_terima_url); ?>'" alt="Foto pengambilan" class="w-14 h-14 rounded-lg object-cover border border-gray-100 cursor-zoom-in">
                    <?php else: ?>
                        <span class="text-xs text-gray-400">Belum diambil</span>
                    <?php endif; ?>
                </td>
                <td class="py-3"><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
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
                <td class="py-3">
                    <div class="flex items-start gap-2">
                        <?php if($h->status === 'diambil'): ?>
                            <div x-data="{ open: false }" class="relative">
                                <button type="button" @click="open = !open" class="text-xs font-semibold border border-gray-200 text-gray-600 px-3 py-1.5 rounded-lg hover:bg-gray-50 whitespace-nowrap">Catat Kembali</button>
                                <div x-show="open" @click.outside="open = false" style="display:none" class="absolute right-0 z-10 mt-1 w-64 bg-white border border-gray-100 shadow-lg rounded-lg p-3 space-y-2">
                                    <form method="POST" action="<?php echo e(route('petugas.histori.selesai', $h->id)); ?>" class="space-y-2">
                                        <?php echo csrf_field(); ?>
                                        <select name="status" class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-xs">
                                            <option value="dikembalikan">Dikembalikan</option>
                                            <option value="rusak">Rusak</option>
                                        </select>
                                        <textarea name="catatan" rows="2" placeholder="Keterangan (wajib jika rusak)" class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-xs"></textarea>
                                        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-1.5 rounded-lg">Simpan</button>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>
                        <form method="POST" action="<?php echo e(route('petugas.histori.destroy', $h->id)); ?>" onsubmit="return confirm('Hapus riwayat ini?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="text-red-500 hover:bg-red-50 p-1.5 rounded-lg">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="9" class="py-6 text-center text-gray-400">Belum ada data.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\htdocs\SI-PARIS\SI-PARIS\SI-PARIS\resources\views/petugas/histori.blade.php ENDPATH**/ ?>