<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['slots', 'gaps' => [], 'now' => null]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['slots', 'gaps' => [], 'now' => null]); ?>
<?php foreach (array_filter((['slots', 'gaps' => [], 'now' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>


<div class="relative h-9 overflow-hidden rounded-lg bg-slate-100">
    <?php $__currentLoopData = $gaps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$from, $to]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="absolute inset-y-0 bg-[repeating-linear-gradient(45deg,#e2e8f0_0,#e2e8f0_4px,#f1f5f9_4px,#f1f5f9_8px)]"
             style="left: <?php echo e($from / 14.4); ?>%; width: <?php echo e(($to - $from) / 14.4); ?>%"></div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php $__currentLoopData = $slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('slots.edit', $slot)); ?>" title="<?php echo e($slot->show->title); ?> · <?php echo e($slot->timeRange()); ?>"
           class="absolute inset-y-1 flex items-center overflow-hidden rounded-md bg-slate-900 px-2 text-xs font-medium text-white hover:bg-rose-600"
           style="left: calc(<?php echo e($slot->starts_at / 14.4); ?>% + 1px); width: calc(<?php echo e($slot->minutes() / 14.4); ?>% - 2px)">
            <span class="truncate"><?php echo e($slot->show->title); ?></span>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php if($now !== null): ?>
        <div class="absolute inset-y-0 w-0.5 bg-rose-500" style="left: <?php echo e($now / 14.4); ?>%"></div>
    <?php endif; ?>
</div>
<?php /**PATH /workspaces/xchannel-dashboard-demo/resources/views/components/day-timeline.blade.php ENDPATH**/ ?>