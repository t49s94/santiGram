<?php $__env->startSection('content'); ?>

<link href="<?php echo e(asset('css/ProfileIndexBladeStyle.css')); ?>" rel="stylesheet">

<div class="container">

  <!--

  Developer: Sergio Eduardo Santillana Lopez.
  Last update: 15/04/2021.

  This view shows the information about a Profile

  -->

  <?php
    if(isset($isConversationCreated))
    {
      echo('<script>alert(Message sent!);</script>');
    }

  ?>

  <div class="row">

    <div class="col-3 p-5">
      <img src="<?php echo e($user->profile->profileImage()); ?>" alt="" class="rounded-circle w-100">
    </div>

    <div class="col-9 pt-5">

      <div class="d-flex justify-content-between align-items-baseline">

        <div class="d-flex align-items-center pb-3">

          <div class="h4"><?php echo e($user->username); ?></div>

          <!-- We use Vue to create a follow-button. In Vue we can create any number of additional fields to pass data.
           These fields are called props (properties) in Vue-->
           <?php if(auth()->guard()->check()): ?>
             <?php if(Auth::user()->id != $user->id): ?>
              <follow-button  user-id="<?php echo e($user->id); ?>" follows="<?php echo e($follows); ?>"></follow-button>
            <?php endif; ?>
          <?php endif; ?>

        </div>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $user->profile)): ?>
          <a href="/p/create">Add new post</a>
        <?php endif; ?>

      </div>

      <!-- If the user is allowed to update, "Edit profile" link will be shown -->
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $user->profile)): ?>
        <a href="/profile/<?php echo e($user->id); ?>/edit">Edit Profile</a>
      <?php endif; ?>

      <div class="d-flex">
        <div class="pr-5"><strong><?php echo e($postCount); ?></strong> posts</div>
        <div class="pr-5"><strong><?php echo e($followerCount); ?></strong> followers</div>
        <div class="pr-5"><strong><?php echo e($followingCount); ?></strong> following</div>
      </div>

      <div class="pt-4 font-weight-bold"><?php echo e($user->profile->title); ?></div>
      <div><?php echo e($user->profile->description); ?></div>
      <div><a href="https://www.linkedin.com/in/sergio-eduardo-santillana-l%C3%B3pez-752ba219a/"><?php echo e($user->profile->url); ?></a></div>

      <hr>
      <form action="/m" enctype="multipart/form-data" method="post" class="px-3">
        <?php echo csrf_field(); ?>
        <div class="form-group row">
          <label class="col-form-label">Write a message to <?php echo e($user->username); ?>:</label>
        </div>

          <div class="form-group row">
            <input id="message" type="text" class="form-control " name="message">

          </div>

          <div class="form-group row d-flex justify-content-end">
            <button id="sendMessage" class="btn">
              <img src="/storage/images/Send-message-arrow.png" alt="" style="max-width:40px;">
            </button>

          </div>

          <input type="hidden" id="receiverId" name="receiverId" value="<?php echo e($user->profile->id); ?>">

      </form>

    </div>

    <!-- Shows Profile's posts -->
    <div class="row pt-5">
      <?php $__currentLoopData = $user->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-4 pb-4">
          <a href="/p/<?php echo e($post->id); ?>">
            <img src="/storage/<?php echo e($post->image); ?>" class="w-100">
          </a>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

  </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Owner\santiGram\resources\views/profiles\index.blade.php ENDPATH**/ ?>