<sup class="text-black"
     role="button"
     data-controller="popover"
     data-action="click->popover#trigger"
     data-container="body"
     data-toggle="popover"
     tabindex="0"
     data-trigger="focus"
     data-placement="<?php echo e($placement); ?>"
     data-delay-show="300"
     data-delay-hide="200"
     data-bs-content="<?php echo e($content); ?>">
    <?php if (isset($component)) { $__componentOriginald36eae2be856e5ea3de02a2f65da5a3c27957ebc = $component; } ?>
<?php $component = $__env->getContainer()->make(Orchid\Icons\IconComponent::class, ['path' => 'exclamation']); ?>
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
</sup>
<?php /**PATH /var/www/html/resources/views/vendor/platform/components/popover.blade.php ENDPATH**/ ?>