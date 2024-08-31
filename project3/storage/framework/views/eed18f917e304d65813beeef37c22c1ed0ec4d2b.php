    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <?php if(config('backpack.base.meta_robots_content')): ?><meta name="robots" content="<?php echo e(config('backpack.base.meta_robots_content', 'noindex, nofollow')); ?>"> <?php endif; ?>

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" /> 
    <title><?php echo e(isset($title) ? $title.' :: '.config('backpack.base.project_name') : config('backpack.base.project_name')); ?></title>

    <?php echo $__env->yieldContent('before_styles'); ?>
    <?php echo $__env->yieldPushContent('before_styles'); ?>

    <?php $__currentLoopData = config('backpack.base.styles', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $path): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset($path).'?v='.config('backpack.base.cachebusting_string')); ?>">
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php $__currentLoopData = config('backpack.base.mix_styles', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $path => $manifest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <link rel="stylesheet" type="text/css" href="<?php echo e(mix($path, $manifest)); ?>">
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php if(!empty(config('backpack.base.vite_styles', []))): ?>
        <?php echo app('Illuminate\Foundation\Vite')(config('backpack.base.vite_styles', [])); ?>
    <?php endif; ?>
    
    <?php echo $__env->yieldContent('after_styles'); ?>
    <?php echo $__env->yieldPushContent('after_styles'); ?>

    
    
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<?php /**PATH C:\Users\user\project3\vendor\backpack\crud\src\resources\views\base/inc/head.blade.php ENDPATH**/ ?>