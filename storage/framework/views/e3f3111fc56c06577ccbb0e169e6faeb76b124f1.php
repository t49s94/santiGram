<?php $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conversation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

  <?php
    $profile = auth()->user()->profile->id == $conversation->receiver->id ?
      $conversation->sender : $conversation->receiver;

    $yourMessage = auth()->user()->profile->id == $conversation->messages[0]->profile->id ?
      true : false;

    $i = 0;
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

    <input type="hidden" id="newConversation_<?php echo e($i++); ?>" value="<?php echo e($conversation->id); ?>">

  </div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<input type="hidden" id="newConversationsCount" value="<?php echo e($conversations->count()); ?>">
<div id="overflowing"></div>
<?php /**PATH C:\Users\Owner\santiGram\resources\views/conversations/ajax/index.blade.php ENDPATH**/ ?>