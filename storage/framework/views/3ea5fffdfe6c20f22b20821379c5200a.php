<div class="relative mb-1 h-4 text-[10px] text-slate-400">
    <?php $__currentLoopData = [0 => 'translate-x-0', 6 => '-translate-x-1/2', 12 => '-translate-x-1/2', 18 => '-translate-x-1/2', 24 => '-translate-x-full']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hour => $align): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <span class="absolute <?php echo e($align); ?>" style="left: <?php echo e($hour / 24 * 100); ?>%"><?php echo e(sprintf('%02d:00', $hour)); ?></span>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH /workspaces/xchannel-dashboard-demo/resources/views/components/hour-ruler.blade.php ENDPATH**/ ?>