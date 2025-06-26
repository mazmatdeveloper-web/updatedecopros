<?php $__env->startSection('customer_content'); ?>
<div class="container py-4">
    <h2 class="mb-4">My Booked Appointments</h2>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="row row-cols-1 row-cols-md-2 g-4">
    <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col">
            <div class="card h-100 appointment-card" data-bs-toggle="modal" data-bs-target="#appointmentModal<?php echo e($key); ?>">
                <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-2">
                        <?php echo e($appointment['service_name']); ?>    
                    </h5>
                    <?php if($appointment['status'] == 'pending'): ?>
                                <span class="badge bg-info"><?php echo e(ucfirst($appointment['status'])); ?></span>
                                <?php elseif($appointment['status'] == 'confirmed'): ?>
                                <span class="badge bg-warning"><?php echo e(ucfirst($appointment['status'])); ?></span>
                                <?php elseif($appointment['status'] == 'cancelled'): ?>
                                <span class="badge bg-danger"><?php echo e(ucfirst($appointment['status'])); ?></span>
                                <?php elseif($appointment['status'] == 'completed'): ?>
                                <span class="badge bg-success"><?php echo e(ucfirst($appointment['status'])); ?></span>
                                <?php endif; ?>
                </div>   
                    <p class="mb-1"><strong>Date:</strong> <?php echo e($appointment['date']); ?></p>
                    <p class="mb-1"><strong>Time:</strong> <?php echo e($appointment['time']); ?></p>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="appointmentModal<?php echo e($key); ?>" tabindex="-1" aria-labelledby="appointmentModalLabel<?php echo e($key); ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="appointmentModalLabel<?php echo e($key); ?>"><?php echo e($appointment['service_name']); ?> Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Status:</strong> <?php echo e($appointment['status']); ?></p>
                        <p><strong>Cleaner:</strong> <?php echo e($appointment['cleaner_name']); ?></p>
                        <p><strong>Date:</strong> <?php echo e($appointment['date']); ?></p>
                        <p><strong>Time:</strong> <?php echo e($appointment['time']); ?></p>

                        <p><strong>Addons:</strong>
                            <?php if(count($appointment['addons'])): ?>
                                <ul class="ps-3">
                                    <?php $__currentLoopData = $appointment['addons']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($addon); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php else: ?>
                                None
                            <?php endif; ?>
                        </p>

                        <?php if($appointment['discount_label'] !== 'one_time'): ?>
                            <p><strong>Discount:</strong> <?php echo e($appointment['discount_label']); ?> (<?php echo e($appointment['discount_price']); ?>)</p>
                        <?php endif; ?>
                        <p><strong>Total Price:</strong> $<?php echo e($appointment['total_price']); ?></p>
                        <p class="text-muted"><small>Booked at: <?php echo e($appointment['booked_at']); ?></small></p>
                        <a href="<?php echo e(route('edit.customer.appointment', $appointment['id'])); ?>">
                                    <button
                                        class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle edit-option-btn">
                                    <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                    </button>
                                </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('customer.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/2025 Projects/updatedecopros/resources/views/customer/appointments/index.blade.php ENDPATH**/ ?>