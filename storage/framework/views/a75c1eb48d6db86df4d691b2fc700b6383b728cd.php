<?php $__env->startComponent($typeForm, get_defined_vars()); ?>
    <button type="button"
            <?php echo e($attributes); ?>

            data-controller="modal-toggle"
            data-action="click->modal-toggle#targetModal"
            data-modal-toggle-title="<?php echo e($modalTitle ?? $title ??  ''); ?>"
            data-modal-toggle-key="<?php echo e($modal ?? ''); ?>"
            data-modal-toggle-async="<?php echo e($async); ?>"
            data-modal-toggle-params='<?php echo json_encode($parameters, 15, 512) ?>'
            data-modal-toggle-action="<?php echo e($action); ?>"
            data-modal-toggle-open="<?php echo e($open); ?>"
    >

        <?php if(isset($icon)): ?>
            <?php if (isset($component)) { $__componentOriginald36eae2be856e5ea3de02a2f65da5a3c27957ebc = $component; } ?>
<?php $component = $__env->getContainer()->make(Orchid\Icons\IconComponent::class, ['path' => $icon,'class' => ''.e(empty($name) ?: 'me-2').'']); ?>
<?php $component->withName('orchid-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald36eae2be856e5ea3de02a2f65da5a3c27957ebc)): ?>
<?php $component = $__componentOriginald36eae2be856e5ea3de02a2f65da5a3c27957ebc; ?>
<?php unset($__componentOriginald36eae2be856e5ea3de02a2f65da5a3c27957ebc); ?>
<?php endif; ?>
        <?php endif; ?>

        <?php echo e($name ?? ''); ?>

    </button>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /var/www/html/resources/views/vendor/platform/actions/modal.blade.php ENDPATH**/ ?>