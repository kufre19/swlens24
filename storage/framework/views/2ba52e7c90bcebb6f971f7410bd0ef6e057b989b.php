<?php $__env->startComponent($typeForm, get_defined_vars()); ?>
    <div data-controller="checkbox"
         data-checkbox-indeterminate="<?php echo e($indeterminate); ?>">
        <?php if(isset($sendTrueOrFalse)): ?>
            <input hidden name="<?php echo e($attributes['name']); ?>" value="<?php echo e($attributes['novalue']); ?>">
            <div class="form-check">
                <input value="<?php echo e($attributes['yesvalue']); ?>"
                       <?php echo e($attributes); ?>

                       <?php if(isset($attributes['value']) && $attributes['value']): ?> checked <?php endif; ?>
                >
                <label class="form-check-label" for="<?php echo e($id); ?>"><?php echo e($placeholder ?? ''); ?></label>
            </div>
        <?php else: ?>
            <div class="form-check">
                <input <?php echo e($attributes); ?>

                       <?php if(isset($attributes['value']) && $attributes['value'] && (!isset($attributes['checked']) || $attributes['checked'] !== false)): ?> checked <?php endif; ?>
                >
                <label class="form-check-label" for="<?php echo e($id); ?>"><?php echo e($placeholder ?? ''); ?></label>
            </div>
        <?php endif; ?>
    </div>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /var/www/html/resources/views/vendor/platform/fields/checkbox.blade.php ENDPATH**/ ?>