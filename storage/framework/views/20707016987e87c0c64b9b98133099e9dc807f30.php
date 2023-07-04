<?php $__env->startComponent($typeForm, get_defined_vars()); ?>
    <div
        data-controller="code"
        data-code-language="<?php echo e($language); ?>"
        data-code-line-numbers="<?php echo e($lineNumbers); ?>"
        data-code-default-Theme="<?php echo e($defaultTheme); ?>"
    >
        <div class="code border position-relative w-100" style="min-height: <?php echo e($attributes['height']); ?>"></div>
        <input type="hidden" <?php echo e($attributes); ?>>
    </div>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /var/www/html/resources/views/vendor/platform/fields/code.blade.php ENDPATH**/ ?>