<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['href', 'active' => false, 'badge' => null]));

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

foreach (array_filter((['href', 'active' => false, 'badge' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<a href="<?php echo e($href); ?>"
   class="flex items-center justify-between gap-3 px-4 py-3.5 rounded-lg text-sm font-medium transition
          <?php echo e($active ? 'bg-blue-600 text-white shadow' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800'); ?>">
    <span class="flex items-center gap-3">
        <?php echo e($slot); ?>

    </span>
    <?php if($badge): ?>
        <span class="text-[11px] font-bold px-2 py-0.5 rounded-full <?php echo e($active ? 'bg-white/20 text-white' : 'bg-red-100 text-red-600'); ?>"><?php echo e($badge); ?></span>
    <?php endif; ?>
</a><?php /**PATH C:\htdocs\SI-PARIS\SI-PARIS\SI-PARIS\resources\views/components/nav-link.blade.php ENDPATH**/ ?>