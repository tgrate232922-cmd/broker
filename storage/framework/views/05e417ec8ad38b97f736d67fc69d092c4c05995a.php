<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.topmenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="main-panel">
        <div class="content ">
            <div class="page-inner">
                <div class="mt-2 mb-4">
                    <h1 class="title1 ">Active Clients Trades</h1>
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
    <th>Plan</th>
    <th>Amount Invested</th>
    <th>Duration</th>
    <th>ROI</th>
    <th>Start Date</th>
    <th>Expiration Date</th>
    <th>Remaining Days</th>
    <th></th>
  </tr>
</thead>

                    <tbody>
<?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <?php
    $currency = $plan->puser->currency ?? '$';

    // Remaining days (never show negative)
    $remainingDays = $plan->expire_date
        ? max(0, \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($plan->expire_date), false))
        : null;

    // ROI display (choose the right one for your system)
    // Option A: profit_earned if it exists on the Investment row
    $roiValue = isset($plan->profit_earned) ? $plan->profit_earned : 0;

    // Option B (if your Investment table has "roi" column instead)
    // $roiValue = isset($plan->roi) ? $plan->roi : 0;
  ?>

  <tr>
    <td><?php echo e($plan->puser->name ?? 'User deleted'); ?></td>

    <td><?php echo e($plan->uplan->name ?? 'Plan deleted'); ?></td>

    <td><?php echo e($currency); ?><?php echo e(number_format($plan->amount ?? 0, 2)); ?></td>

    
    <td><?php echo e($plan->inv_duration ?? '-'); ?></td>

    
    <td><?php echo e($currency); ?><?php echo e(number_format($roiValue ?? 0, 2)); ?></td>

    <td><?php echo e(\Carbon\Carbon::parse($plan->created_at)->toDayDateTimeString()); ?></td>

    <td>
      <?php echo e($plan->expire_date ? \Carbon\Carbon::parse($plan->expire_date)->toDayDateTimeString() : '-'); ?>

    </td>

    <td>
      <?php if($remainingDays === null): ?>
        -
      <?php elseif($remainingDays == 0): ?>
        <span class="badge badge-danger">Expired</span>
      <?php else: ?>
        <span class="badge badge-success"><?php echo e($remainingDays); ?> day(s)</span>
      <?php endif; ?>
    </td>

    <td>
      <?php if(!empty($plan->puser)): ?>
        <a href="<?php echo e(route('user.investments', $plan->puser->id)); ?>" class="btn btn-sm btn-primary">
         Manage
        </a>
      <?php endif; ?>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/homefor1/scalpchain.com/account/resources/views/admin/Plans/activeinv.blade.php ENDPATH**/ ?>