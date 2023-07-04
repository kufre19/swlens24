<?php $__env->startSection('content'); ?>
    

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Schedule Menu Item</h4>
                </div>
                <div class="card-body text-center">
                    <a href="<?php echo e(url('schedule-menu/list')); ?>" class="btn btn-success btn-sm px-4 py-2"><i class="icon-download"></i> Back To Schedule Menu Items</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Schedule Menu Title</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(url('schedule-menu/edit/save')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="form-group">
                            <label for="textarea">Enter a schedule menu item:</label>
                          <input type="text" name="schedule" id="" value="<?php echo e($item->name); ?>" class="form-control form-control-lg">
                          <input type="hidden" name="id" value="<?php echo e($item->id); ?>">
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('platform::dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/vendor/platform/schedule_menu/edit.blade.php ENDPATH**/ ?>