<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Dashboard']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Dashboard']); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => __('Dashboard'),'description' => __('What every station is playing, and how the week is filled.')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Dashboard')),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('What every station is playing, and how the week is filled.'))]); ?>
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

    <form method="GET" class="mb-6 flex flex-wrap items-end gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <div>
            <label for="day" class="mb-1.5 block text-sm font-medium text-slate-700"><?php echo e(__('Day')); ?></label>
            <select id="day" name="day" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm">
                <?php $__currentLoopData = \App\Enums\Day::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($day->value); ?>" <?php if($day === $today): echo 'selected'; endif; ?>><?php echo e($day->label()); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div>
            <label for="time" class="mb-1.5 block text-sm font-medium text-slate-700"><?php echo e(__('Time (WIB)')); ?></label>
            <input id="time" name="time" type="time" value="<?php echo e($at->format('H:i')); ?>" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm">
        </div>
        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['variant' => 'outline']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'outline']); ?><?php echo e(__('View')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
        <?php if(request()->filled('day')): ?>
            <a href="<?php echo e(route('dashboard')); ?>" class="pb-2 text-sm text-slate-500 hover:text-slate-900"><?php echo e(__('Back to now')); ?></a>
        <?php endif; ?>
    </form>

    <?php
        $cards = [
            [__('Active stations'), $stations->count(), __('on air')],
            [__('Shows'), $showCount, __('active programmes')],
            [__('Hosts'), $hostCount, __('active announcers')],
            [__('Airtime per week'), \App\Support\Clock::hours($weeklyMinutes).' '.__('hours'), __('scheduled, all stations')],
        ];
    ?>
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $value, $note]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="whitespace-nowrap text-xl font-bold"><?php echo e($value); ?></p>
                <p class="text-sm text-slate-500"><?php echo e($label); ?></p>
                <p class="mt-1 text-xs text-slate-400"><?php echo e($note); ?></p>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <section class="mt-6 rounded-xl border border-slate-200 bg-white shadow-sm">
        <header class="border-b border-slate-100 px-6 py-4">
            <h2 class="font-semibold"><?php echo e(__('On air at :day :time', ['day' => $today->label(), 'time' => $at->format('H:i')])); ?></h2>
        </header>
        <ul class="divide-y divide-slate-100">
            <?php $__currentLoopData = $stations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php [$station, $now, $next] = [$row['station'], $row['now'], $row['next']]; ?>
                <li class="px-6 py-4">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div class="min-w-0">
                            <a href="<?php echo e(route('stations.show', $station)); ?>" class="font-medium hover:underline"><?php echo e($station->name); ?></a>
                            <span class="ml-1 text-xs text-slate-500"><?php echo e($station->frequency); ?></span>
                            <?php if (isset($component)) { $__componentOriginal40fb3f87bdce298d39161c783df685a1 = $component; } ?>
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
<?php endif; ?>
                        </div>
                        <div class="text-right text-sm">
                            <?php if($now): ?>
                                <span class="block font-medium"><?php echo e($now->show->title); ?> <span class="font-normal text-slate-500">· <?php echo e($now->timeRange()); ?></span></span>
                                <span class="block text-xs text-slate-500"><?php echo e($now->show->hostNames() ?: __('No host')); ?></span>
                            <?php else: ?>
                                <span class="block text-slate-500"><?php echo e(__('Nothing scheduled: automated music')); ?></span>
                            <?php endif; ?>
                            <?php if($next): ?>
                                <span class="block text-xs text-slate-400"><?php echo e(__('Up next: :show, :day :time', ['show' => $next->show->title, 'day' => $next->day_of_week->label(), 'time' => \App\Support\Clock::format($next->starts_at)])); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mt-3">
                        <?php if (isset($component)) { $__componentOriginal0978d285a98ac0dd683982c7ab5418a2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0978d285a98ac0dd683982c7ab5418a2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.day-timeline','data' => ['slots' => $station->slots->where('day_of_week', $today),'gaps' => $row['gaps'],'now' => $at->hour * 60 + $at->minute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('day-timeline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['slots' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($station->slots->where('day_of_week', $today)),'gaps' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($row['gaps']),'now' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($at->hour * 60 + $at->minute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0978d285a98ac0dd683982c7ab5418a2)): ?>
<?php $attributes = $__attributesOriginal0978d285a98ac0dd683982c7ab5418a2; ?>
<?php unset($__attributesOriginal0978d285a98ac0dd683982c7ab5418a2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0978d285a98ac0dd683982c7ab5418a2)): ?>
<?php $component = $__componentOriginal0978d285a98ac0dd683982c7ab5418a2; ?>
<?php unset($__componentOriginal0978d285a98ac0dd683982c7ab5418a2); ?>
<?php endif; ?>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </section>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['title' => __('Airtime per host'),'description' => __('Hours on air per week, across all stations')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Airtime per host')),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Hours on air per week, across all stations'))]); ?>
            <?php $most = max(1, $byHost->max()); ?>
            <ul class="space-y-3">
                <?php $__currentLoopData = $byHost; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $minutes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <div class="mb-1 flex justify-between text-sm"><span><?php echo e($name); ?></span><span class="text-slate-500"><?php echo e(\App\Support\Clock::hours($minutes)); ?> <?php echo e(__('hours')); ?></span></div>
                        <div class="h-2 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full bg-rose-600" style="width: <?php echo e($minutes / $most * 100); ?>%"></div></div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $attributes = $__attributesOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__attributesOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $component = $__componentOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__componentOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal53747ceb358d30c0105769f8471417f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53747ceb358d30c0105769f8471417f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.card','data' => ['title' => __('Airtime per station'),'description' => __('Scheduled hours per week; the rest is automated music')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Airtime per station')),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Scheduled hours per week; the rest is automated music'))]); ?>
            <ul class="space-y-3">
                <?php $__currentLoopData = $byStation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $minutes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <div class="mb-1 flex justify-between text-sm"><span><?php echo e($name); ?></span><span class="text-slate-500"><?php echo e(__(':hours of 168 hours', ['hours' => \App\Support\Clock::hours($minutes)])); ?></span></div>
                        <div class="h-2 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full bg-slate-900" style="width: <?php echo e($minutes / (168 * 60) * 100); ?>%"></div></div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $attributes = $__attributesOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__attributesOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal53747ceb358d30c0105769f8471417f6)): ?>
<?php $component = $__componentOriginal53747ceb358d30c0105769f8471417f6; ?>
<?php unset($__componentOriginal53747ceb358d30c0105769f8471417f6); ?>
<?php endif; ?>
    </div>
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
<?php /**PATH /workspaces/xchannel-dashboard-demo/resources/views/dashboard/index.blade.php ENDPATH**/ ?>