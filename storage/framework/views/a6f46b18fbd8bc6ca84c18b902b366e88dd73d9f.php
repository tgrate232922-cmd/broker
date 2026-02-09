<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.topmenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="main-panel">
        <div class="content ">
            <div class="page-inner">
                <div class="mt-2 mb-4">
                    <h1 class="title1 ">All Signals</h1>
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
                <div class="col-12 card shadow p-4 ">
                    <div class="table-responsive" data-example-id="hoverable-table">
                        <table id="ShipTable" class="table table-hover ">
                            <thead>
                                <tr>
                                    <th>Client name</th>
                                     <th>Asset</th>
                                     <th>Signal Type</th>
                                    <th>Signal Name</th>
                                    <th>Signal Status</th>
                                    <th>Amount Invested</th>
                                    <th>Expiration </th>
                                   
                                    
                                    <th>Start Date</th>
                                    
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $signals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $signal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        
                                         <?php if(isset( $signal->suser->name ) &&  $signal->suser->name!= null): ?> 
                                        <td><?php echo e($signal->suser->name); ?> 
                                            </td>
                                            <?php endif; ?>
                                            
                                          <td><?php echo e($signal->asset); ?></td>
                                          <?php if($signal->status=='ongoing'): ?>
                                           <td><strong><span class="text-success"><?php echo e($signal->status); ?></span></strong></i></td>
                                        <?php else: ?>
                                        <td><strong><span class="text-danger"><?php echo e($signal->status); ?></span></strong></i></td>
                                        <?php endif; ?>
                                        <?php if($signal->order_type	=='Buy'): ?>
                                           <td><strong><span class="text-success"><i class="fas fa-arrow-up mr-1"></i><?php echo e($signal->order_type); ?></span></strong></i></td>
                                        <?php else: ?>
                                        <td><strong><span class="text-danger"><i class="fas fa-arrow-down mr-1"></i><?php echo e($signal->order_type); ?></span></strong></i></td>
                                        <?php endif; ?>
                                        <td><?php echo e($signal->dsignal->name); ?></td>
                                      
                                       
                                        <td>
                                            <?php echo e($signal->suser->currency); ?><?php echo e($signal->amount); ?>

                                        </td>
                                        <td><?php echo e($signal->expiration); ?></td>
                                        <td><?php echo e(\Carbon\Carbon::parse($signal->created_at)->toDayDateTimeString()); ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item text-danger"
                                                        href="<?php echo e(route('deletesignal', $signal->id)); ?>">Delete Signal</a>
                                                
                                                        <?php if($signal->status == 'ongoing'): ?>
                                                        <a href="<?php echo e(route('signalmarkas', ['id' => $signal->id, 'status' => 'expired'])); ?>"
                                                            class="m-1 btn btn-danger btn-sm">Mark as expired</a>
                                                    <?php else: ?>
                                                        <a href="<?php echo e(route('signalmarkas', ['id' => $signal->id, 'status' => 'ongoing'])); ?>"
                                                            class="m-1 btn btn-success btn-sm">Mark as active</a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/homefor1/scalpchain.com/account/resources/views/admin/Signals/activesingnals.blade.php ENDPATH**/ ?>