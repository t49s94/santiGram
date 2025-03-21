<?php $__env->startSection('content'); ?>
<div class="container">
    <form action="/profile/<?php echo e($user->id); ?>" enctype="multipart/form-data" method="post">

        <!-- <?php echo csrf_field(); ?> allows laravel who can post into our form. If we don't do this we can curl into an end point such as
        /p and create any post that an user wants without actually having to go through the website. So we need to limit
        who is authorized to actually hit that empty point and the way that laravel does it is by adding an extremely large key
        to each form and then it can validate that key and say: "Did this come from this server?". If it did then it allows the
        user to post. If it didn't, it will throw a 419 error.
        -->
        <?php echo csrf_field(); ?>

        <!-- We say we will use method "PATCH" to edit profile  -->
        <?php echo method_field('PATCH'); ?>

        <div class="row">
            <div class="col-8 offset-2">

                <div class="row">
                    <h1>Edit Profile</h1>
                </div>

                <div class="form-group row">

                    <label for="title" class="col-md-4 col-form-label">Title</label>

                    <input id="title" type="text" class="form-control<?php echo e($errors->has('title') ? ' is-invalid' : ''); ?>"
                    name="title" value="<?php echo e(old('title') ?? $user->profile->title); ?>"
                    autocomplete="title" autofocus>

                    <?php if($errors->has('title')): ?>
                        <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($errors->first('title')); ?></strong>
                        </span>
                    <?php endif; ?>

                </div>

                <div class="form-group row">

                    <label for="description" class="col-md-4 col-form-label">Description</label>

                    <input id="description" type="text" class="form-control<?php echo e($errors->has('description') ? ' is-invalid' : ''); ?>"
                    name="description" value="<?php echo e(old('description') ?? $user->profile->description); ?>"
                    autocomplete="description" autofocus>

                    <?php if($errors->has('description')): ?>
                        <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($errors->first('description')); ?></strong>
                        </span>
                    <?php endif; ?>

                </div>

                <div class="form-group row">

                    <label for="url" class="col-md-4 col-form-label">URL</label>

                    <input id="url" type="text" class="form-control<?php echo e($errors->has('url') ? ' is-invalid' : ''); ?>"
                    name="url" value="<?php echo e(old('url') ?? $user->profile->url); ?>"
                    autocomplete="url" autofocus>

                    <?php if($errors->has('url')): ?>
                        <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($errors->first('url')); ?></strong>
                        </span>
                    <?php endif; ?>

                </div>

                <div class="row">
                    <label for="caption" class="col-md-4 col-form-label">Profile Image</label>
                    <input type="file" class="form-control-file" id="image" name="image">

                    <?php if($errors->has('image')): ?>
                        <strong><?php echo e($errors->first('image')); ?></strong>
                    <?php endif; ?>
                </div>

                <div class="row pt-4">
                    <button class="btn btn-primary">Save Profile</button>
                </div>

            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Owner\santiGram\resources\views/profiles/edit.blade.php ENDPATH**/ ?>