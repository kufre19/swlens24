<?php $__env->startSection('content'); ?>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Schedule Menu Items</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Schedule Menu Items</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                           <?php echo e($item->name); ?>

                            <a  href="<?php echo e(url('schedule-menu/edit') ."/" .$item->id); ?>" class="btn btn-link">Edit</a>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('platform::dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/vendor/platform/schedule_menu/list.blade.php ENDPATH**/ ?>