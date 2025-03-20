<!doctype html>

<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<!--

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This view has the Page header for website.

-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('jquery-ui.min.css')); ?>">
    <link href="<?php echo e(asset('css/myStyles.css')); ?>" rel="stylesheet">

    <!-- Scripts -->

    <script src="<?php echo e(asset('js/app.js')); ?> " defer></script>
    <script src="<?php echo e(asset('jquery-3.5.1.min.js')); ?>" type="text/javascript" ></script>
    <script src="<?php echo e(asset('jquery-ui.min.js')); ?>" type="text/javascript" ></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

</head>

<?php echo $__env->yieldPushContent('head'); ?>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex" href="<?php echo e(url('/')); ?>">
                    <div><img src="/svg/santiGramLogo.svg" alt="" style="height: 20px; border-right: 1px solid #333" class="pr-3"></div>
                    <div class="pl-3">SantiGram</div>
                </a>

                <input type="text" id="profileSearch">

                <a href="#" id="selectedProfile" class="darken">
                    <img src="/storage/images/Search-button.png" style="max-width: 30px;">
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="<?php echo e(__('Toggle navigation')); ?>">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <?php if(auth()->guard()->guest()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
                            </li>
                            <?php if(Route::has('register')): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo e(route('register')); ?>"><?php echo e(__('Register')); ?></a>
                                </li>
                            <?php endif; ?>
                        <?php else: ?>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <?php echo e(Auth::user()->username); ?> <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                    <a class="dropdown-item" href="/profile/<?php echo e(Auth::user()->id); ?>/conversations">
                                        <?php echo e(__('Mailbox')); ?>

                                    </a>

                                    <a class="dropdown-item" href="/profile/<?php echo e(Auth::user()->id); ?>">
                                        <?php echo e(__('Profile')); ?>

                                    </a>

                                    <a class="dropdown-item" href="/profile/<?php echo e(Auth::user()->id); ?>/followers">
                                        <?php echo e(__('Followers')); ?>

                                    </a>

                                    <a class="dropdown-item" href="/profile/<?php echo e(Auth::user()->id); ?>/following">
                                        <?php echo e(__('Following')); ?>

                                    </a>

                                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <?php echo e(__('Logout')); ?>

                                    </a>

                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>

                    <notification-button :profile-id="<?php echo e(is_null( Auth::user() ) ? '-1' : Auth::user()->profile->id); ?>">
                    </notification-button>



                </div>
            </div>
        </nav>

        <main class="py-4">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <script src="<?php echo e(asset('js/app_ProfileSearch.js')); ?> " type="text/javascript"></script>

</body>
</html>
<?php /**PATH C:\Users\Owner\santiGram\resources\views/layouts/app.blade.php ENDPATH**/ ?>