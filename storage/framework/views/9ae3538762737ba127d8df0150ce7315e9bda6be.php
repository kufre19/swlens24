<fieldset class="mb-3" data-async>

    <?php if(empty(!$title)): ?>
        <div class="col p-0 px-3">
            <legend class="text-black">
                <?php echo e($title); ?>

            </legend>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded shadow-sm p-4 py-4 d-flex flex-column">
        <?php echo $form ?? ''; ?>

    </div>
</fieldset>
<?php /**PATH /var/www/html/resources/views/vendor/platform/layouts/row.blade.php ENDPATH**/ ?>