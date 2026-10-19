<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Stations']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Stations']); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => __('Stations'),'description' => __('Each city has its own station and its own week of shows.')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Stations')),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Each city has its own station and its own week of shows.'))]); ?>
        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => route('stations.create')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('stations.create'))]); ?><?php echo e(__('New station')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $attributes = $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $component = $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginal163c8ba6efb795223894d5ffef5034f5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal163c8ba6efb795223894d5ffef5034f5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table','data' => ['headings' => ['Station', 'City', 'Stream', '>Slots per week', 'Status']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['headings' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Station', 'City', 'Stream', '>Slots per week', 'Status'])]); ?>
        <?php $__empty_1 = true; $__currentLoopData = $stations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $station): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="px-4 py-3">
                    <a href="<?php echo e(route('stations.show', $station)); ?>" class="block font-medium hover:underline"><?php echo e($station->name); ?></a>
                    <span class="block text-xs text-slate-500"><?php echo e($station->frequency); ?></span>
                </td>
                <td class="px-4 py-3 text-slate-600"><?php echo e($station->city); ?></td>
                <td class="px-4 py-3"><?php if (isset($component)) { $__componentOriginal40fb3f87bdce298d39161c783df685a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40fb3f87bdce298d39161c783df685a1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stream-badge','data' => ['status' => $station->stream_status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('stream-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($station->stream_status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40fb3f87bdce298d39161c783df685a1)): ?>
<?php $attributes = $__attributesOriginal40fb3f87bdce298d39161c783df685a1; ?>
<?php unset($__attributesOriginal40fb3f87bdce298d39161c783df685a1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40fb3f87bdce298d39161c783df685a1)): ?>
<?php $component = $__componentOriginal40fb3f87bdce298d39161c783df685a1; ?>
<?php unset($__componentOriginal40fb3f87bdce298d39161c783df685a1); ?>
<?php endif; ?></td>
                <td class="px-4 py-3 text-right tabular-nums"><?php echo e($station->slots_count); ?></td>
                <td class="px-4 py-3"><?php if (isset($component)) { $__componentOriginal23f1bbd2fed10b05ea73e1fd3a6d9617 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23f1bbd2fed10b05ea73e1fd3a6d9617 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.active-badge','data' => ['active' => $station->is_active]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('active-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($station->is_active)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23f1bbd2fed10b05ea73e1fd3a6d9617)): ?>
<?php $attributes = $__attributesOriginal23f1bbd2fed10b05ea73e1fd3a6d9617; ?>
<?php unset($__attributesOriginal23f1bbd2fed10b05ea73e1fd3a6d9617); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23f1bbd2fed10b05ea73e1fd3a6d9617)): ?>
<?php $component = $__componentOriginal23f1bbd2fed10b05ea73e1fd3a6d9617; ?>
<?php unset($__componentOriginal23f1bbd2fed10b05ea73e1fd3a6d9617); ?>
<?php endif; ?></td>
                <td class="px-4 py-3">
                    <?php if (isset($component)) { $__componentOriginal46b3bac9d56bec6271aaffa668486026 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal46b3bac9d56bec6271aaffa668486026 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.row-actions','data' => ['edit' => route('stations.edit', $station),'destroy' => route('stations.destroy', $station),'confirm' => __('Delete :name?', ['name' => $station->name])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('row-actions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['edit' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('stations.edit', $station)),'destroy' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('stations.destroy', $station)),'confirm' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Delete :name?', ['name' => $station->name]))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal46b3bac9d56bec6271aaffa668486026)): ?>
<?php $attributes = $__attributesOriginal46b3bac9d56bec6271aaffa668486026; ?>
<?php unset($__attributesOriginal46b3bac9d56bec6271aaffa668486026); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal46b3bac9d56bec6271aaffa668486026)): ?>
<?php $component = $__componentOriginal46b3bac9d56bec6271aaffa668486026; ?>
<?php unset($__componentOriginal46b3bac9d56bec6271aaffa668486026); ?>
<?php endif; ?>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php if (isset($component)) { $__componentOriginal4eed7548ad3bd4d0709494afb2239601 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4eed7548ad3bd4d0709494afb2239601 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-row','data' => ['span' => '6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('empty-row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['span' => '6']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4eed7548ad3bd4d0709494afb2239601)): ?>
<?php $attributes = $__attributesOriginal4eed7548ad3bd4d0709494afb2239601; ?>
<?php unset($__attributesOriginal4eed7548ad3bd4d0709494afb2239601); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4eed7548ad3bd4d0709494afb2239601)): ?>
<?php $component = $__componentOriginal4eed7548ad3bd4d0709494afb2239601; ?>
<?php unset($__componentOriginal4eed7548ad3bd4d0709494afb2239601); ?>
<?php endif; ?>
        <?php endif; ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal163c8ba6efb795223894d5ffef5034f5)): ?>
<?php $attributes = $__attributesOriginal163c8ba6efb795223894d5ffef5034f5; ?>
<?php unset($__attributesOriginal163c8ba6efb795223894d5ffef5034f5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal163c8ba6efb795223894d5ffef5034f5)): ?>
<?php $component = $__componentOriginal163c8ba6efb795223894d5ffef5034f5; ?>
<?php unset($__componentOriginal163c8ba6efb795223894d5ffef5034f5); ?>
<?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php /**PATH /workspaces/xchannel-dashboard-demo/resources/views/stations/index.blade.php ENDPATH**/ ?>