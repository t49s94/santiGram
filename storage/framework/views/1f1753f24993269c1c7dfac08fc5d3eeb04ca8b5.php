<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-3 p-5">
            <img src="/svg/santiGramLogo.svg" alt="" style="height: 100px;" class="rounded-circle">
        </div>
        <div class="col-9 pt-5">
            <div class="d-flex justify-content-between align-items-baseline">
                <h1><?php echo e($user->username); ?></h1>
                <a href="#">Add new post</a>
            </div>
            <div class="d-flex">
                <div class="pr-5"><strong>153</strong> posts</div>
                <div class="pr-5"><strong>23k</strong> followers</div>
                <div class="pr-5"><strong>212</strong> following</div>
            </div>
            <div class="pt-4 font-weight-bold"><?php echo e($user->profile->title); ?></div>
            <div><?php echo e($user->profile->description); ?></div>
            <div><a href="https://www.linkedin.com/in/sergio-eduardo-santillana-l%C3%B3pez-752ba219a/"><?php echo e($user->profile->url); ?></a></div>
        </div>

        <div class="row pt-5">
          <div class="col-4">
              <img src="https://scontent-mia3-1.cdninstagram.com/v/t51.2885-15/sh0.08/e35/c2.0.824.824a/s640x640/143377875_747593889489606_5323934135154740495_n.jpg?_nc_ht=scontent-mia3-1.cdninstagram.com&amp;_nc_cat=106&amp;_nc_ohc=4dEPFR913mEAX8QEAs7&amp;tp=1&amp;oh=f4dd1a5a53361fac6eec8f6fb989b43d&amp;oe=60400584" class="w-100">
          </div>
          <div class="col-4">
              <img src="https://scontent-mia3-1.cdninstagram.com/v/t51.2885-15/sh0.08/e35/c2.0.824.824a/s640x640/143377875_747593889489606_5323934135154740495_n.jpg?_nc_ht=scontent-mia3-1.cdninstagram.com&amp;_nc_cat=106&amp;_nc_ohc=4dEPFR913mEAX8QEAs7&amp;tp=1&amp;oh=f4dd1a5a53361fac6eec8f6fb989b43d&amp;oe=60400584" class="w-100">
          </div>
          <div class="col-4">
              <img src="https://scontent-mia3-1.cdninstagram.com/v/t51.2885-15/sh0.08/e35/c2.0.824.824a/s640x640/143377875_747593889489606_5323934135154740495_n.jpg?_nc_ht=scontent-mia3-1.cdninstagram.com&amp;_nc_cat=106&amp;_nc_ohc=4dEPFR913mEAX8QEAs7&amp;tp=1&amp;oh=f4dd1a5a53361fac6eec8f6fb989b43d&amp;oe=60400584" class="w-100">
          </div>
        </div>


    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Owner\santiGram\resources\views/home.blade.php ENDPATH**/ ?>