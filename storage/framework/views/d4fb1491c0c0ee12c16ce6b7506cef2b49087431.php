<?php $__env->startSection('content'); ?>
<div class="container">

    <form action="/p" enctype="multipart/form-data" method="post">

        <!-- <?php echo csrf_field(); ?> allows laravel who can post into our form. If we don't do this we can curl into an end point such as
        /p and create any post that an user wants without actually having to go through the website. So we need to limit
        who is authorized to actually hit that empty point and the way that laravel does it is by adding an extremely large key
        to each form and then it can validate that key and say: "Did this come from this server?". If it did then it allows the
        user to post. If it didn't, it will throw a 419 error.
        -->
        <?php echo csrf_field(); ?>

        <div class="row">
            <div class="col-8 offset-2">

                <div class="row">
                    <h1>Add New Post</h1>
                </div>

                <div class="form-group row">

                    <input id="caption" type="text" class="form-control<?php echo e($errors->has('caption') ? ' is-invalid' : ''); ?>"
                    name="caption" value="<?php echo e(old('caption')); ?>"
                    autocomplete="caption" autofocus>

                    <?php if($errors->has('caption')): ?>
                        <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($errors->first('caption')); ?></strong>
                        </span>
                    <?php endif; ?>

                </div>

                <div class="row">
                    <label for="caption" class="col-md-4 col-form-label">Post Image</label>
                    <input type="file" class="form-control-file" id="image" name="image">

                    <?php if($errors->has('image')): ?>
                        <strong><?php echo e($errors->first('image')); ?></strong>
                    <?php endif; ?>
                </div>

                <div class="row pt-4">
                    <button class="btn btn-primary">Add New Post</button>
                </div>

            </div>
        </div>
    </form>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Owner\santiGram\resources\views/posts/create.blade.php ENDPATH**/ ?>