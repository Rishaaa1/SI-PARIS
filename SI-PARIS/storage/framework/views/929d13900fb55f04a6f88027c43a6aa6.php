<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['status']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['status']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $map = [
        'menunggu' => ['Menunggu ACC', 'bg-orange-100 text-orange-600'],
        'disetujui' => ['Disetujui', 'bg-sky-100 text-sky-700'],
        'ditolak' => ['Ditolak', 'bg-red-100 text-red-600'],
        'diambil' => ['Barang Diambil', 'bg-indigo-100 text-indigo-600'],
        'dikembalikan' => ['Dikembalikan', 'bg-emerald-100 text-emerald-600'],
        'rusak' => ['Barang Rusak', 'bg-red-100 text-red-600'],
        'selesai' => ['Selesai', 'bg-emerald-100 text-emerald-600'],
        'diproses' => ['Diproses', 'bg-sky-100 text-sky-700'],
    ];
    [$label, $class] = $map[$status] ?? [ucfirst($status), 'bg-gray-100 text-gray-600'];
?>

<span class="text-xs font-semibold px-2.5 py-1 rounded-full <?php echo e($class); ?>"><?php echo e($label); ?></span><?php /**PATH C:\htdocs\SI-PARIS\SI-PARIS\SI-PARIS\resources\views/components/status-badge.blade.php ENDPATH**/ ?>