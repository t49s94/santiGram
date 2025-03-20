<?php $__env->startSection('content'); ?>

<link href="<?php echo e(asset('css/ConversationIndexBladeStyle.css')); ?>" rel="stylesheet">

<div class="container">

  <!--

  Developer: Sergio Eduardo Santillana Lopez.
  Last update: 15/04/2021.

  This view shows Conversations Profile has.
  https://www.youtube.com/watch?v=3cmbkEQG8is
  -->

  <input type="hidden" id="profileId" value="<?php echo e(auth()->user()->profile->id); ?>">

  <div class="conversation-message  d-flex">

  <div class="conversations endless-pagination col-4"
  data-next-page="<?php echo e($conversations->nextPageUrl()); ?>">

  <div class="conversationList">

      <?php $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conversation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <?php
          $profile = auth()->user()->profile->id == $conversation->receiver->id ?
            $conversation->sender : $conversation->receiver;

          $yourMessage = auth()->user()->profile->id == $conversation->messages[0]->profile->id ?
            true : false;
        ?>

        <div class="conversation d-flex" id="conversation_<?php echo e($conversation->id); ?>">
          <img src="<?php echo e($profile->profileImage()); ?>" class="w-100 border-top py-2">
          <div class="align-self-stretch pl-3 border-top py-2">
            <div class="d-flex">
              <h5 id="profileUsername"><?php echo e($profile->user->username); ?></h5>
              <div class="pl-3"><?php echo e($conversation->messages[0]->created_at); ?></div>
            </div>
            <div id="seenConversation"><?php echo e($conversation->seen == 0 && !$yourMessage ? 'NEW Message!' : ''); ?></div>
            <div>
              <strong id="yourMessageSign"><?php echo e($yourMessage ? 'You: ' : ''); ?></strong>
              <span id="lastMessage"><?php echo e($conversation->messages[0]->body); ?></span>
            </div>
          </div>

        </div>

      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

  </div>

    <div id="overflowing"></div>

  </div>

  <div class="viewMessages col-8 d-flex flex-column">

    <h3 id="usernameHeader" class="border-bottom py-3 ">Username</h3>

    <div class="messages endless-pagination-message pb-2" data-next-page="">
      <div id="overflowing"></div>
      <div class="messageList">
      </div>
    </div>

    <div id="messageBoxContainer" class="rounded">

      <div class="form-group row pt-3 px-5">
        <input id="messageBox" type="text" class="form-control " name="messageBox" placeholder="Type a message..." disabled>
      </div>

      <div class="form-group row d-flex justify-content-end pb-3 pr-4">
        <img id="sendMessage" src="/storage/images/Send-message-arrow-disabled.png" alt="">
      </div>

    </div>


  </div>
</div>

  <input type="hidden" id="current_user" value="<?php echo e(auth()->user()->profile->id); ?>" />
  <input type="hidden" id="pusher_app_key" value="<?php echo e(env('PUSHER_APP_KEY')); ?>" />
  <input type="hidden" id="pusher_cluster" value="<?php echo e(env('PUSHER_APP_CLUSTER')); ?>" />

  <audio id="chat-alert-sound" style="display: none">
    <source src="<?php echo e(asset('sound/Message-notification.mp3')); ?>" />
  </audio>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('head'); ?>

<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<script src="<?php echo e(asset('js/ConversationIndexBladeJS.js')); ?>" defer></script>

<script>
  (function($){
  $(document).ready(function() {

    window.conversations = {};

    <?php for($i = 0; $i < $conversations->count(); $i++): ?>
      window.conversations[<?php echo e($i); ?>] = <?php echo e($conversations[$i]->id); ?>;
      $(`#conversation_<?php echo e($conversations[$i]->id); ?>`).click({idx: <?php echo e($i); ?> }, conversation_click);
    <?php endfor; ?>

  });
})(jQuery);
</script>



<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Owner\santiGram\resources\views/conversations/index.blade.php ENDPATH**/ ?>