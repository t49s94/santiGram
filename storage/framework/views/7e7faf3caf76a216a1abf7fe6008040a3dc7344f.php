<link rel="stylesheet" type="text/css" href="<?php echo e(url('/css/NotificationIndexStyle.css')); ?>" />

<?php $__env->startSection('content'); ?>
<div class="container">

  <!--

  Developer: Sergio Eduardo Santillana Lopez.
  Last update: 15/04/2021.

  This view shows Notifications User has.

  -->

  <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <?php if($notification->seen == 0): ?>
      <div id="notification_<?php echo e($notification->id); ?>" class="card flex-row text-white bg-primary flex-wrap">
        <?php
          $notification->seen = 1;
          $notification->save();
        ?>

        <?php else: ?>
          <div id="notification_<?php echo e($notification->id); ?>" class="card flex-row text-white bg-secondary flex-wrap">

        <?php endif; ?>
          <div class="card-header border-0">
            <a href="/profile/<?php echo e($notification->sender->id); ?>">
              <img class="rounded-circle" src="<?php echo e($notification->sender->profileImage()); ?>" alt="" style="max-width:30px">
            </a>
          </div>
          <div class="card-block px-2">
            <a href="/p/<?php echo e($notification->post->id ?? $notification->sender->id); ?>" class="a_toPost">
              <span class="card-title font-weight-bold"><?php echo e($notification->created_at); ?></span>
              <p class="card-text"><?php echo e($notification->body); ?></p>
            </a>
          </div>
        </div>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <!-- Pagination button -->
    <div class="row pt-4">
      <div class="col-12 d-flex justify-content-center">
        <?php echo e($notifications->links()); ?>

      </div>
    </div>

  </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Owner\santiGram\resources\views/notifications/index.blade.php ENDPATH**/ ?>