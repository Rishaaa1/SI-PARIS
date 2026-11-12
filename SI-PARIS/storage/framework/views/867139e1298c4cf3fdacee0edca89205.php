<?php $__env->startSection('title', 'Kelola Barang'); ?>
<?php $__env->startSection('page-title', 'Kelola Barang / Inventaris'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 sm:p-6" x-data="{ showForm: <?php echo e($errors->any() ? 'true' : 'false'); ?>, preview: null, edit: null, editPreview: null }">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
        <h3 class="font-semibold text-gray-800">Data Barang / Inventaris</h3>
        <button type="button" @click="showForm = !showForm" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg whitespace-nowrap">+ Tambah Barang</button>
    </div>

    <?php if($errors->any()): ?>
        <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-600 text-sm"><?php echo e($errors->first()); ?></div>
    <?php endif; ?>

    <!-- Form tambah barang -->
    <div x-show="showForm" style="display:none" class="bg-gray-50 border border-gray-100 rounded-lg p-4 mb-5">
        <form method="POST" action="<?php echo e(route('petugas.barang.store')); ?>" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-[150px_minmax(0,1fr)] gap-5">
            <?php echo csrf_field(); ?>
            <!-- Tempat gambar -->
            <label class="block cursor-pointer min-w-0">
                <span class="block text-xs font-medium text-gray-600 mb-1">Gambar barang</span>
                <span class="flex items-center justify-center w-full h-36 md:w-[150px] border-2 border-dashed border-gray-300 hover:border-blue-500 rounded-lg bg-white overflow-hidden text-center text-xs text-gray-400">
                    <img x-show="preview" :src="preview" alt="Pratinjau" class="w-full h-full object-cover" style="display:none">
                    <span x-show="!preview" class="px-3">
                        <svg class="w-7 h-7 mx-auto mb-1 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V19a2 2 0 002 2h14a2 2 0 002-2v-2.5M16.5 8L12 3.5 7.5 8M12 4v12"/></svg>
                        Klik untuk pilih gambar<br>JPG / PNG, maks 3 MB
                    </span>
                </span>
                <input type="file" name="gambar" accept="image/*" class="hidden"
                       @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
            </label>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 content-start min-w-0">
                <input type="text" name="nama_barang" value="<?php echo e(old('nama_barang')); ?>" placeholder="Nama barang" class="w-full min-w-0 border border-gray-200 rounded-lg px-3 py-2 text-sm" required>
                <input type="text" name="kategori" value="<?php echo e(old('kategori')); ?>" placeholder="Kategori" class="w-full min-w-0 border border-gray-200 rounded-lg px-3 py-2 text-sm">
                <input type="number" name="stok" value="<?php echo e(old('stok')); ?>" placeholder="Stok" min="0" class="w-full min-w-0 border border-gray-200 rounded-lg px-3 py-2 text-sm" required>
                <input type="text" name="deskripsi" value="<?php echo e(old('deskripsi')); ?>" placeholder="Deskripsi (opsional)" class="w-full min-w-0 border border-gray-200 rounded-lg px-3 py-2 text-sm">
                <div class="sm:col-span-2">
                    <button class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg px-6 py-2.5">Simpan</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabel barang -->
    <div class="overflow-x-auto">
    <table class="w-full text-sm min-w-[720px]">
        <thead>
            <tr class="text-left text-gray-400 border-b border-gray-100">
                <th class="py-2 pr-4 font-medium whitespace-nowrap">No</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Gambar</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Nama Barang</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Kategori</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Stok</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Tersedia</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Status</th>
                <th class="py-2 pr-4 font-medium whitespace-nowrap">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $barang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="border-b border-gray-50">
                <td class="py-3 pr-4"><?php echo e($i + 1); ?></td>
                <td class="py-3 pr-4">
                    <?php if($b->gambar_url): ?>
                        <img src="<?php echo e($b->gambar_url); ?>" @click="foto = '<?php echo e($b->gambar_url); ?>'" alt="<?php echo e($b->nama_barang); ?>" class="w-14 h-14 rounded-lg object-cover border border-gray-100 cursor-zoom-in">
                    <?php else: ?>
                        <div class="w-14 h-14 rounded-lg bg-gray-100 text-gray-300 flex items-center justify-center" title="Belum ada gambar">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    <?php endif; ?>
                </td>
                <td class="py-3 pr-4 font-medium"><?php echo e($b->nama_barang); ?></td>
                <td class="py-3 pr-4 text-gray-500"><?php echo e($b->kategori); ?></td>
                <td class="py-3 pr-4"><?php echo e($b->stok); ?></td>
                <td class="py-3 pr-4"><?php echo e($b->stok_tersedia); ?></td>
                <td class="py-3 pr-4">
                    <form method="POST" action="<?php echo e(route('petugas.barang.toggle', $b->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="relative inline-flex h-6 w-11 items-center rounded-full transition <?php echo e($b->status === 'aktif' ? 'bg-blue-600' : 'bg-gray-300'); ?>">
                            <span class="inline-block h-4 w-4 transform rounded-full bg-white transition <?php echo e($b->status === 'aktif' ? 'translate-x-6' : 'translate-x-1'); ?>"></span>
                        </button>
                    </form>
                </td>
                <td class="py-3 pr-4">
                    <div class="flex items-center gap-1">
                        <button type="button" title="Ubah"
                            @click="edit = <?php echo e(\Illuminate\Support\Js::from(['id' => $b->id, 'nama_barang' => $b->nama_barang, 'kategori' => $b->kategori, 'stok' => $b->stok, 'deskripsi' => $b->deskripsi, 'gambar' => $b->gambar_url])); ?>; editPreview = null"
                            class="text-blue-600 hover:bg-blue-50 p-1.5 rounded-lg">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <form method="POST" action="<?php echo e(route('petugas.barang.destroy', $b->id)); ?>" onsubmit="return confirm('Hapus barang ini?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="text-red-500 hover:bg-red-50 p-1.5 rounded-lg" title="Hapus">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="8" class="py-6 text-center text-gray-400">Belum ada barang.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>

    <!-- Modal ubah barang -->
    <div x-show="edit" style="display:none" @keydown.escape.window="edit = null"
         class="fixed inset-0 z-40 flex items-center justify-center bg-black/40 p-4" role="dialog" aria-modal="true">
        <div @click.outside="edit = null" class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Ubah Barang</h3>
            <template x-if="edit">
                <form method="POST" :action="'<?php echo e(url('/petugas/barang')); ?>/' + edit.id" enctype="multipart/form-data" class="space-y-3">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="_method" value="PUT">

                    <label class="block cursor-pointer">
                        <span class="block text-xs font-medium text-gray-600 mb-1">Gambar barang (klik untuk mengganti)</span>
                        <span class="flex items-center justify-center w-full h-44 border-2 border-dashed border-gray-300 hover:border-blue-500 rounded-lg bg-gray-50 overflow-hidden text-xs text-gray-400">
                            <img x-show="editPreview || edit.gambar" :src="editPreview || edit.gambar" alt="Gambar barang" class="w-full h-full object-cover">
                            <span x-show="!editPreview && !edit.gambar">Belum ada gambar. Klik untuk memilih.</span>
                        </span>
                        <input type="file" name="gambar" accept="image/*" class="hidden"
                               @change="editPreview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
                    </label>

                    <input type="text" name="nama_barang" x-model="edit.nama_barang" placeholder="Nama barang" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm" required>
                    <div class="grid grid-cols-2 gap-3">
                        <input type="text" name="kategori" x-model="edit.kategori" placeholder="Kategori" class="border border-gray-200 rounded-lg px-3 py-2 text-sm">
                        <input type="number" name="stok" x-model="edit.stok" min="0" placeholder="Stok" class="border border-gray-200 rounded-lg px-3 py-2 text-sm" required>
                    </div>
                    <input type="text" name="deskripsi" x-model="edit.deskripsi" placeholder="Deskripsi (opsional)" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">

                    <div class="flex gap-3 pt-2">
                        <button type="button" @click="edit = null" class="flex-1 border border-gray-200 text-gray-600 font-semibold py-2.5 rounded-lg hover:bg-gray-50">Batal</button>
                        <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg">Simpan</button>
                    </div>
                </form>
            </template>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\htdocs\SI-PARIS\SI-PARIS\resources\views/petugas/barang.blade.php ENDPATH**/ ?>