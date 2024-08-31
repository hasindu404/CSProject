<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-4">
            <h3 class="text-center mb-4"><?php echo e(trans('backpack::base.register')); ?></h3>
            <div class="card">
                <div class="card-body">
                    <form class="col-md-12 p-t-10" role="form" method="POST" action="<?php echo e(route('backpack.auth.register')); ?>">
                        <?php echo csrf_field(); ?>


                        <div class="form-group">
                            <label class="control-label" for="name"><?php echo e(trans('backpack::base.name')); ?></label>

                            <div>
                                <input type="text" class="form-control<?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>" name="name" id="name" value="<?php echo e(old('name')); ?>">

                                <?php if($errors->has('name')): ?>
                                    <span class="invalid-feedback">
                                        <strong><?php echo e($errors->first('name')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="<?php echo e(backpack_authentication_column()); ?>"><?php echo e(config('backpack.base.authentication_column_name')); ?></label>

                            <div>
                                <input type="<?php echo e(backpack_authentication_column()==backpack_email_column()?'email':'text'); ?>" class="form-control<?php echo e($errors->has(backpack_authentication_column()) ? ' is-invalid' : ''); ?>" name="<?php echo e(backpack_authentication_column()); ?>" id="<?php echo e(backpack_authentication_column()); ?>" value="<?php echo e(old(backpack_authentication_column())); ?>">

                                <?php if($errors->has(backpack_authentication_column())): ?>
                                    <span class="invalid-feedback">
                                        <strong><?php echo e($errors->first(backpack_authentication_column())); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="password"><?php echo e(trans('backpack::base.password')); ?></label>

                            <div>
                                <input type="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" name="password" id="password">

                                <?php if($errors->has('password')): ?>
                                    <span class="invalid-feedback">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="password_confirmation"><?php echo e(trans('backpack::base.confirm_password')); ?></label>

                            <div>
                                <input type="password" class="form-control<?php echo e($errors->has('password_confirmation') ? ' is-invalid' : ''); ?>" name="password_confirmation" id="password_confirmation">

                                <?php if($errors->has('password_confirmation')): ?>
                                    <span class="invalid-feedback">
                                        <strong><?php echo e($errors->first('password_confirmation')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-block btn-primary">
                                    <?php echo e(trans('backpack::base.register')); ?>

                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php if(backpack_users_have_email() && backpack_email_column() == 'email' && config('backpack.base.setup_password_recovery_routes', true)): ?>
                <div class="text-center"><a href="<?php echo e(route('backpack.auth.password.reset')); ?>"><?php echo e(trans('backpack::base.forgot_your_password')); ?></a></div>
            <?php endif; ?>
            <div class="text-center"><a href="<?php echo e(route('backpack.auth.login')); ?>"><?php echo e(trans('backpack::base.login')); ?></a></div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(backpack_view('layouts.plain'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\project3\vendor\backpack\crud\src\resources\views\base/auth/register.blade.php ENDPATH**/ ?>