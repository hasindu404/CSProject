

<?php
// if the column has been cast to Carbon or Date (using attribute casting)
// get the value as a date string
if (isset($field['value']) && ($field['value'] instanceof \Carbon\CarbonInterface)) {
    $field['value'] = $field['value']->toDateTimeString();
}

$timestamp = strtotime(old_empty_or_null($field['name'], '') ??  $field['value'] ?? $field['default'] ?? '');

$value = $timestamp ? date('Y-m-d\TH:i:s', $timestamp) : '';
?>

<?php echo $__env->make('crud::fields.inc.wrapper_start', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <label><?php echo $field['label']; ?></label>
    <?php echo $__env->make('crud::fields.inc.translatable_icon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php if(isset($field['prefix']) || isset($field['suffix'])): ?> <div class="input-group"> <?php endif; ?>
        <?php if(isset($field['prefix'])): ?> <div class="input-group-prepend"><span class="input-group-text"><?php echo $field['prefix']; ?></span></div> <?php endif; ?>
        <input
            type="datetime-local"
            name="<?php echo e($field['name']); ?>"
            value="<?php echo e($value); ?>"
            <?php echo $__env->make('crud::fields.inc.attributes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        >
        <?php if(isset($field['suffix'])): ?> <div class="input-group-append"><span class="input-group-text"><?php echo $field['suffix']; ?></span></div> <?php endif; ?>
    <?php if(isset($field['prefix']) || isset($field['suffix'])): ?> </div> <?php endif; ?>
    
    
    <?php if(isset($field['hint'])): ?>
        <p class="help-block"><?php echo $field['hint']; ?></p>
    <?php endif; ?>
<?php echo $__env->make('crud::fields.inc.wrapper_end', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH C:\Users\user\project3\vendor\backpack\crud\src\resources\views\crud/fields/datetime.blade.php ENDPATH**/ ?>