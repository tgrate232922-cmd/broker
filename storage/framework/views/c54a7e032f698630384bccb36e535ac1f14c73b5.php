<?php $__env->startSection('title', 'Notifications'); ?>


<?php $__env->startSection('content'); ?>
<?php echo $__env->make('admin.topmenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="mt-2 mb-4 d-flex align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Notifications</h1>
    <a href="<?php echo e(route('admin.markallasread')); ?>" class="btn btn-primary">Mark All as Read</a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('success')); ?>

                </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('error')); ?>

                </div>
                <?php endif; ?>

                <?php if(count($notifications) > 0): ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Message</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="<?php echo e($notification->is_read ? '' : 'table-light font-weight-bold'); ?>">
                                        <td><?php echo e($notification->title); ?></td>
                                        <td><?php echo e($notification->message); ?></td>
                                        <td>
                                            <span class="badge badge-<?php echo e($notification->type === 'warning' ? 'warning' : ($notification->type === 'success' ? 'success' : ($notification->type === 'danger' ? 'danger' : 'info'))); ?>">
                                                <?php echo e(ucfirst($notification->type)); ?>

                                            </span>
                                        </td>
                                        <td><?php echo e($notification->created_at->diffForHumans()); ?></td>
                                        <td>
                                            <?php if(!$notification->is_read): ?>
                                                <a href="<?php echo e(route('admin.markasread', $notification->id)); ?>" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-check"></i> Mark as Read
                                                </a>
                                            <?php endif; ?>
                                            <a href="<?php echo e(route('admin.deletenotification', $notification->id)); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this notification?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        <?php echo e($notifications->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fa fa-bell-slash fa-3x text-muted"></i>
                        <p class="mt-3">You have no notifications</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/homefor1/scalpchain.com/account/resources/views/admin/notifications/index.blade.php ENDPATH**/ ?>