<?php if(isset($messages)): ?>

  <?php for($i = ($messages->count() - 1); $i >= 0 ; $i--): ?>

    <?php
    $yourMessage = auth()->user()->profile->id == $messages[$i]->profile->id ? true : false;
     ?>

    <div class="message d-flex align-items-center pt-3 <?php echo e($yourMessage ? 'flex-row-reverse' : ''); ?>">

      <div class="px-3">
        <img src="<?php echo e($messages[$i]->profile->profileImage()); ?>" class=" rounded-circle" style="max-width: 50px">
      </div>

      <div class="rounded p-2" style="background-color:<?php echo e($yourMessage ? 'DarkSeaGreen' : 'Wheat'); ?>;">
        <div>
          <?php echo e($messages[$i]->body); ?>

        </div>
        <div class="pt-2 font-weight-bold">
            <?php echo e($messages[$i]->created_at->format('Y-m-d h:i a')); ?>

        </div>
      </div>

    </div>

  <?php endfor; ?>

<?php else: ?>

<?php
$yourMessage = auth()->user()->profile->id == $message->profile->id ? true : false;
 ?>

<div class="message d-flex align-items-center pt-3 <?php echo e($yourMessage ? 'flex-row-reverse' : ''); ?>">

  <div class="px-3">
    <img src="<?php echo e($message->profile->profileImage()); ?>" class=" rounded-circle" style="max-width: 50px">
  </div>

  <div class="rounded p-2" style="background-color:<?php echo e($yourMessage ? 'DarkSeaGreen' : 'Wheat'); ?>;">
    <div>
      <?php echo e($message->body); ?>

    </div>
    <div class="pt-2 font-weight-bold">
        <?php echo e($message->created_at->format('Y-m-d h:i a')); ?>

    </div>
  </div>

</div>

<?php endif; ?>
<?php /**PATH C:\Users\Owner\santiGram\resources\views/messages/index.blade.php ENDPATH**/ ?>