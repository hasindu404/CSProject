<?php
	// if not otherwise specified, the hidden input should take up no space in the form
  $field['wrapper'] = $field['wrapper'] ?? $field['wrapperAttributes'] ?? [];
  $field['wrapper']['class'] = $field['wrapper']['class'] ?? "hidden";
?>


<?php echo $__env->make('crud::fields.inc.wrapper_start', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <input
  	type="hidden"
    name="<?php echo e($field['name']); ?>"
    value="<?php echo e(old_empty_or_null($field['name'], '') ??  $field['value'] ?? $field['default'] ?? ''); ?>"
    <?php echo $__env->make('crud::fields.inc.attributes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  	>
<?php echo $__env->make('crud::fields.inc.wrapper_end', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH C:\Users\user\project3\vendor\backpack\crud\src\resources\views\crud/fields/hidden.blade.php ENDPATH**/ ?>