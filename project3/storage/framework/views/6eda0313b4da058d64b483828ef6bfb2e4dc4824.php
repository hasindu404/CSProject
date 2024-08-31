
<?php if($crud->groupedErrorsEnabled() && session()->get('errors')): ?>
    <div class="alert alert-danger pb-0">
        <ul class="list-unstyled">
            <?php $__currentLoopData = session()->get('errors')->getBags(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bag => $errorMessages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $errorMessages->getMessages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $errorMessageForInput): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $errorMessageForInput; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><i class="la la-info-circle"></i> <?php echo e($message); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?><?php /**PATH C:\Users\user\project3\vendor\backpack\crud\src\resources\views\crud/inc/grouped_errors.blade.php ENDPATH**/ ?>