<?php $__env->startComponent($typeForm, get_defined_vars()); ?>
    <div data-controller="quill"
         data-quill-toolbar='<?php echo json_encode($toolbar, 15, 512) ?>'
         data-quill-value='<?php echo json_encode($value, 15, 512) ?>'
         data-theme="<?php echo e($theme ?? 'inlite'); ?>"
    >
        <div id="toolbar"></div>
        <div class="quill p-3 position-relative" id="quill-wrapper-<?php echo e($id); ?>"
             style="min-height: <?php echo e($attributes['height']); ?>">
        </div>
        <input class="d-none" <?php echo e($attributes); ?>>
    </div>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /var/www/html/resources/views/vendor/platform/fields/quill.blade.php ENDPATH**/ ?>