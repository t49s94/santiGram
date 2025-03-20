<?php $__env->startSection('content'); ?>
<div class="container">

                <form action="/c" enctype="multipart/form-data" method="post">
                    <?php echo csrf_field(); ?>

                    <div class="form-group row pr-3">
                        <textarea id="commentBody" class="form-control" rows="4" cols="50" placeholder="Comment here..."><?php echo e($commentBody); ?></textarea>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button class="btn btn-primary">Post comment</button>
                        </div>
                    </div>

                    <input type="hidden" id="postId" value="<?php echo e($post); ?>">

                </form>

                <div class="card">
                  <div class="card-body">Basic card</div>
                </div>
                <div class="card">
                  <div class="card-body">Basic card</div>
                </div>
            </div>


</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Owner\santiGram\resources\views/comments/create.blade.php ENDPATH**/ ?>