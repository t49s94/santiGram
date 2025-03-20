<?php $__env->startSection('content'); ?>

<div class="container">

  <!--

  Developer: Sergio Eduardo Santillana Lopez.
  Last update: 15/04/2021.

  This view shows the User's followers.

  -->

  <div class="d-flex justify-content-center pb-5"><h2>Followers</h2></div>

  <div class="d-flex flex-wrap justify-content-center">

    <?php $__currentLoopData = $followers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $follower): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <div class="pr-4 pb-3">

          <div class="card" style="max-width: 200px">

            <img class="card-img-top" src="<?php echo e($follower->profile->profileImage()); ?>">

            <div class="card-body">

              <h4 class="card-title"><?php echo e(\Illuminate\Support\Str::limit($follower->username , 12, $end='...')); ?></h4>

              <p class="card-text" style="height: 50px;">
                <?php echo e(\Illuminate\Support\Str::limit($follower->profile->title , 50, $end='...')); ?>

              </p>

              <p class="card-text" style="height: 110px;">
                <?php echo e(\Illuminate\Support\Str::limit($follower->profile->description , 90, $end='...') ?? "No description"); ?>

              </p>

              <a href="/profile/<?php echo e($follower->profile->id); ?>" class="btn btn-primary stretched-link">Visit Profile</a>

            </div>

          </div>

        </div>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

  </div>

  <?php if(count($followers) == 0): ?>
    <div class="d-flex flex-column pt-5">
      <div class="d-flex justify-content-center"><h3 style="color:gray;">You have no followers!</h3></div>
      <div class="d-flex justify-content-center pt-5"><img src='/storage/images/Shocked-face.png'></div>
    </div>
  <?php endif; ?>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Owner\santiGram\resources\views/profiles/followers.blade.php ENDPATH**/ ?>