<?php $__env->startComponent($typeForm, get_defined_vars()); ?>
    <button
            data-controller="button"
            data-turbo="<?php echo e(var_export($turbo)); ?>"
            <?php if(empty(!$confirm)): ?>
                data-action="button#confirm"
                data-button-confirm="<?php echo e($confirm); ?>"
            <?php endif; ?>
        <?php echo e($attributes); ?>>

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
<?php /**PATH /var/www/html/resources/views/vendor/platform/actions/button.blade.php ENDPATH**/ ?>