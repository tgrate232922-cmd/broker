<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.topmenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="main-panel">
        <div class="content ">
            <div class="page-inner">
                <div class="mt-2 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="title1 ">Update Signal</h1>
                        </div>
                        <div>
                            <a href="<?php echo e(route('signals')); ?>" class="btn btn-sm btn-primary"> <i class="fa fa-arrow-left"></i>
                                Back</a>
                        </div>
                    </div>
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
                    <div class="col-lg-12 ">
                        <div class="p-3 card ">
                            <form role="form" method="post" action="<?php echo e(route('updatesignal')); ?>">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <h5 class="">Signal Name</h5>
                                        <input class="form-control  " placeholder="Enter Plan name" type="text"
                                           value="<?php echo e($signal->name); ?>"  name="name"  required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <h5 class="">Signal price(<?php echo e($settings->currency); ?>)</h5>
                                        <input class="form-control  " placeholder="Enter Plan price" type="number"
                                            value="<?php echo e($signal->price); ?>"   name="price" required>
                                        <small class="">This is the  amount a user can pay
                                            to get in this signal, enter the value without a comma(,)</small>
                                    </div>
                                    
                                   
                                   
                                    
                                    

                                    <div class="form-group col-md-6">
                                        <h5 class="">Increament (in % )</h5>
                                        <input class="form-control  " placeholder="Increament Amount" type="number"
                                            step="any"  value="<?php echo e($signal->increment_amount); ?>" name="increment_amount" required>
                                        
                                    </div>

                                  
                                    <div class="form-group col-md-12">
                                        <input type="hidden" name="id" value="<?php echo e($signal->id); ?>">
                                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                        <input type="submit" class="btn btn-primary" value="Update Signal">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div id="topupModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body ">

                    </div>
                </div>
            </div>
        </div>

        <script>
            function getduration(id, event) {
                event.preventDefault();
                document.getElementById('duridden').value = id;
            }
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/homefor1/scalpchain.com/account/resources/views/admin/Signals/editsignal.blade.php ENDPATH**/ ?>