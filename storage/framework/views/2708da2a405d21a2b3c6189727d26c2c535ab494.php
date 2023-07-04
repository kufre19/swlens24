<?php $__env->startComponent($typeForm, get_defined_vars()); ?>
    <div data-controller="select">
        <select <?php echo e($attributes); ?>>
            <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($key); ?>"
                        <?php if(isset($value)): ?>
                        <?php if(is_array($value) && in_array($key, $value, true)): ?> selected
                        <?php elseif(isset($value[$key]) && $value[$key] == $option): ?> selected
                        <?php elseif($key === $value): ?> selected
                        <?php endif; ?>
                        <?php endif; ?>
                ><?php echo e($option); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /var/www/html/resources/views/vendor/platform/fields/select.blade.php ENDPATH**/ ?>