<?php $__env->startSection('content'); ?>

<div class="container">

  <!--

  Developer: Sergio Eduardo Santillana Lopez.
  Last update: 15/04/2021.

  This views shows information about a Post.

  -->

  <div class="row">

    <div class="col-8">
      <img src="/storage/<?php echo e($post->image); ?>" class="w-100">
    </div>

    <div class="col-4">

      <div>

        <div class="d-flex align-items-center">

          <div class="pr-3">
            <img src="<?php echo e($post->user->profile->profileImage()); ?>" class="rounded-circle w-100" style="max-width: 40px;">
          </div>

          <div>

            <div class="font-weight-bold d-flex align-items-center">

              <a href="/profile/<?php echo e($post->user->id); ?>" class="pr-3">
                <span class="text-dark"><?php echo e($post->user->username); ?></span>
              </a>

              <?php if(auth()->guard()->check()): ?>
                <!-- If User isn't looking at his own post, follow-button will show up -->
                <?php if(Auth::user()->id != $post->user->id): ?>
                  <follow-button  user-id="<?php echo e($post->user->id); ?>" follows="<?php echo e($follows); ?>"></follow-button>
                <?php endif; ?>
              <?php endif; ?>

            </div>

          </div>

        </div>

        <hr>

        <p>
          <span class="font-weight-bold">
            <a href="/profile/<?php echo e($post->user->id); ?>">
              <span class="text-dark"><?php echo e($post->user->username); ?></span>
            </a>
          </span>
        </p>

        <p><?php echo e($post->caption); ?></p>

        <div class="d-flex justify-content-around">

          <like-button class="container d-flex align-items-center justify-content-center"
          component-type="post" component-id="<?php echo e($post->id); ?>" likes="<?php echo e($likes); ?>" likes-count="<?php echo e($likesCount); ?>"></like-button>

          <div id="commentButton" class="container d-flex align-items-center justify-content-center">
            <img class="w-100 pr-2" style="max-width:30px;" src='/storage/images/Comment-button.png'  >
            <span class="font-weight-bold"><?php echo e($post->comments->count()); ?></span>
          </div>

        </div>

        <!-- Form to post a comment -->
        <form action="/c" enctype="multipart/form-data" method="post" class="px-3 py-3">

          <?php echo csrf_field(); ?>

          <div class="form-group row">
            <textarea id="commentBody" name="commentBody" class="form-control" rows="4" cols="50" placeholder="Comment here..."></textarea>
          </div>

          <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
              <button class="btn btn-primary">Post comment</button>
            </div>
          </div>

          <input type="hidden" id="postId" name="postId" value="<?php echo e($post->id); ?>">

        </form>

        <div id="displayComments">

          <?php for($i = 0; $i < $commentCount; $i++): ?>

            <div id="comment_<?php echo e($comments[$i]->id); ?>" class="card flex-row flex-wrap">

              <div class="card-header border-0">
                <img class="rounded-circle" src="<?php echo e($comments[$i]->profile->profileImage()); ?>" alt="" style="max-width:30px">
              </div>

              <div class="card-block px-2">

                <span class="card-title font-weight-bold"><?php echo e($comments[$i]->profile->user->username); ?></span>
                <p class="card-text"><?php echo e($comments[$i]->body); ?></p>

                <div class="d-flex flex-row pb-2">

                  <div id="likeButton" class="container d-flex align-items-center">
                    <img class="w-100 pr-2" style="max-width:30px;" src="<?php echo e($likesComment[$i]); ?>"  >
                    <span class="font-weight-bold"><?php echo e($comments[$i]->likers->count()); ?></span>
                  </div>

                  <span id="replyButton" class='font-weight-bold align-items-center'>REPLY</span>

                </div>

                <?php
                  $replyText = ($comments[$i]->replies->count() == 1) ? 'reply' : 'replies' ;
                ?>

                <!-- If comment has any replies, show seeRepliesButton -->
                <?php if($comments[$i]->replies->count() > 0): ?>
                  <div id='seeRepliesButton' class='container d-flex align-items-center pb-2'>
                    <img class='w-100 pr-2' style='max-width:30px;' src='/storage/images/Comment-button.png'>
                    <span class='font-weight-bold'>See <?php echo e($comments[$i]->replies->count()); ?> <?php echo e($replyText); ?></span>
                  </div>
                <?php endif; ?>

              </div>

            </div>

            <!-- Where replies are gonna be shown -->
            <div id='displayReplies_<?php echo e($comments[$i]->id); ?>' class='ml-3'></div>

          <?php endfor; ?>

          <!-- If there are still comments that haven't been shown, show loadComments button  -->
          <?php if($comments->count() > $numberNewComments): ?>
            <p id="loadComments" class="py-2">Load more comments...</p>
          <?php endif; ?>

        </div>

      </div>

    </div>

  </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('head'); ?>

  <link rel="stylesheet" href="<?php echo e(asset('css/PostShowBladeStyle.css')); ?>">

  <!-- Scripts -->

  <script>

    window.postId = <?php echo e($post->id); ?>;
    window.comments = {};
    window.numberNewComments = <?php echo e($numberNewComments); ?>;

    <?php for($i = 0; $i < $commentCount; $i++): ?>
      window.comments[<?php echo e($i); ?>] = { id: <?php echo e($comments[$i]->id); ?>, likesCount: <?php echo e($comments[$i]->likers->count()); ?> };
    <?php endfor; ?>

  </script>
  
  <script src="<?php echo e(asset('js/PostShowBladeJS.js')); ?>" defer></script>


<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Owner\santiGram\resources\views/posts/show.blade.php ENDPATH**/ ?>