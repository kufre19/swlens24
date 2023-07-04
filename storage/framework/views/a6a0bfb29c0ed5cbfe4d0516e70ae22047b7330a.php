<div class="dropdown d-inline-block" data-controller="filter">
    <button class="btn btn-sm btn-link dropdown-toggle"
            type="button"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            data-bs-boundary="viewport"
            aria-expanded="false">
        <?php if (isset($component)) { $__componentOriginald36eae2be856e5ea3de02a2f65da5a3c27957ebc = $component; } ?>
<?php $component = $__env->getContainer()->make(Orchid\Icons\IconComponent::class, ['path' => 'filter']); ?>
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
    </button>
    <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow" data-action="click->filter#onMenuClick" x-placement="bottom-end">
        <div class="py-2 px-3">

            <?php echo $filter; ?>


            <div class="line line-dashed border-bottom my-3"></div>
            <button type="submit" form="filters" class="btn btn-default btn-sm w-100"><?php echo e(__('Apply')); ?></button>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/resources/views/vendor/platform/partials/layouts/filter.blade.php ENDPATH**/ ?>