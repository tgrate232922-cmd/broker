
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.topmenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="main-panel">
        <div class="content ">
            <div class="page-inner">
                <div class="mt-2 mb-4">
                    <h1 class="title1 ">System Signals</h1>
                </div>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.danger-alert','data' => []]); ?>
<?php $component->withName('danger-alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.success-alert','data' => []]); ?>
<?php $component->withName('success-alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <div class="mb-5 row">
                    <div class="mt-2 mb-3 col-lg-12">
                        <a class="btn btn-primary" href="<?php echo e(route('newsignal')); ?>"><i class="fa fa-plus"></i> New plan</a>
                    </div>
                    <?php $__empty_1 = true; $__currentLoopData = $signals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $signal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="col-lg-4">
                            <div class="pricing-table purple border p-4 card">
                                <div class="card-body">
                                    <h2 class=""><?php echo e($signal->name); ?> <span
                                class="fs-3 fw-normal text-success"><?php echo e($signal->tag ?? ''); ?></span></h2>
                                    <!-- Price -->
                                    <div class="price-tag">
                                        <span class="symbol "><?php echo e($settings->currency); ?></span>
                                        <span class="amount "><?php echo e(number_format($signal->price)); ?></span>
                                    </div>
                                    <!-- Features -->
                                    <div class="pricing-features">
                                        <div class="feature text-dark">Signal Price:<span
                                                class=""><?php echo e($settings->currency); ?><?php echo e(number_format($signal->price)); ?></span>
                                        </div>
                                       
                                        <div class="feature text-dark">Percentage:<span
                                                class=""><?php echo e($signal->increment_amount); ?>%</span>
                                        </div>
                                    </div> <br>

                                    <!-- Button -->
                                    <div class="text-center">
                                        <a href="<?php echo e(route('editsignal', $signal->id)); ?>" class="btn btn-primary"><i
                                                class="text-white flaticon-pencil"></i>
                                        </a> &nbsp;
                                        <a href="<?php echo e(url('admin/dashboard/trashsignal')); ?>/<?php echo e($signal->id); ?>"
                                            class="btn btn-danger"><i class="text-white fa fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-lg-12 text-center">
                            <div class="pricing-table card purple border p-4">
                                <h4 class="">No Investment Plan at the moment, click the button above to add a plan.
                                </h4>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/homefor1/scalpchain.com/account/resources/views/admin/Signals/signals.blade.php ENDPATH**/ ?>