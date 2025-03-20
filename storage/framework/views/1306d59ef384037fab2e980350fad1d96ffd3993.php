<?php $__env->startSection('content'); ?>

<div class="container">

  <!--

  Developer: Sergio Eduardo Santillana Lopez.
  Last update: 15/04/2021.

  This view shows all the posts from the following Users.

  -->

  <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <div class="row">

      <div class="col-6 offset-3">
        <a href="/p/<?php echo e($post->id); ?>">
          <img src="/storage/<?php echo e($post->image); ?>"class="w-100">
        </a>
      </div>

    </div>

    <div class="row pt-2 pb-4">

      <div class="col-6 offset-3">

        <div>

          <p class="d-flex align-items-center">

            <span class="pr-3">
              <img src="<?php echo e($post->user->profile->profileImage()); ?>" class="rounded-circle w-100" style="max-width: 40px;">
            </span>

            <span class="font-weight-bold pr-3">
              <a href="/profile/<?php echo e($post->user->id); ?>">
                <span class="text-dark"><?php echo e($post->user->username); ?></span>
              </a>
            </span><?php echo e($post->caption); ?>


          </p>

        </div>

        <div class="d-flex justify-content-around">

          <div id="likeButton" class="container d-flex align-items-center justify-content-center">
            <img class="w-100 pr-2" style="max-width:30px;" src='/storage/images/Like-button.png'  >
            <span class="font-weight-bold"><?php echo e($post->likers->count()); ?></span>
          </div>

          <div id="commentButton" class="container d-flex align-items-center justify-content-center">
            <img class="w-100 pr-2" style="max-width:30px;" src='/storage/images/Comment-button.png'  >
            <span class="font-weight-bold"><?php echo e($post->comments->count()); ?></span>
          </div>

        </div>

      </div>

    </div>

  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

  <!-- Pagination button -->
  <div class="row">
    <div class="col-12 d-flex justify-content-center">
      <?php echo e($posts->links()); ?>

    </div>
  </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Owner\santiGram\resources\views/posts/index.blade.php ENDPATH**/ ?>