<?php $__env->startComponent($typeForm, get_defined_vars()); ?>
    <div class="simplemde-wrapper" data-controller="simplemde"
         data-simplemde-text-value='<?php echo json_encode($attributes['value'], 15, 512) ?>'>
        <textarea <?php echo e($attributes); ?>></textarea>
        <input class="d-none upload" type="file" data-action="simplemde#upload">
    </div>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /var/www/html/resources/views/vendor/platform/fields/simplemde.blade.php ENDPATH**/ ?>