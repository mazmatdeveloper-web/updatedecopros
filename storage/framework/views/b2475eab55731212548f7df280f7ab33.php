<?php $__env->startSection('admin_content'); ?>
<div id="loader" style="display:none; position: fixed; top: 50%; left: 50%; z-index: 9999; transform: translate(-50%, -50%)">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<div class="container py-4">
    <h2 class="mb-4">All Appointments</h2>

    <form method="GET" action="<?php echo e(route('appointments')); ?>" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by service, cleaner, date, or status..." value="<?php echo e(request('search')); ?>">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <?php if($appointments->count()): ?>
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $serviceIds = json_decode($appointment->service_id, true);
                $services = \App\Models\Service::whereIn('id', $serviceIds ?? [])->pluck('service_name')->toArray();
            ?>

            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">
                                <?php echo e(implode(', ', $services) ?: 'N/A'); ?>


                                <?php if($appointment->status == 'pending'): ?>
                                    <span class="badge bg-info"><?php echo e(ucfirst($appointment->status)); ?></span>
                                <?php elseif($appointment->status == 'confirmed'): ?>
                                    <span class="badge bg-warning"><?php echo e(ucfirst($appointment->status)); ?></span>
                                <?php elseif($appointment->status == 'cancelled'): ?>
                                    <span class="badge bg-danger"><?php echo e(ucfirst($appointment->status)); ?></span>
                                <?php elseif($appointment->status == 'completed'): ?>
                                    <span class="badge bg-success"><?php echo e(ucfirst($appointment->status)); ?></span>
                                <?php endif; ?>
                            </h5>

                            <div class="d-flex align-items-center gap-1">
                                <a href="<?php echo e(route('edit.appointment', $appointment->id)); ?>">
                                    <button class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle edit-option-btn">
                                        <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                    </button>
                                </a>
                                <form action="<?php echo e(route('delete.appointment', $appointment->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this appointment?');" style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                        <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <p><strong>Employee:</strong> <?php echo e($appointment->employee->name ?? 'N/A'); ?></p>
                        <p><strong>Date:</strong> <?php echo e(\Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y')); ?></p>
                        <p><strong>Time:</strong> <?php echo e(\Carbon\Carbon::parse($appointment->start_time)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($appointment->end_time)->format('H:i')); ?></p>
                        <p><strong>Total Price:</strong> $<?php echo e(number_format($appointment->total_price, 2)); ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        <?php echo e($appointments->withQueryString()->links()); ?>

    </div>
<?php else: ?>
    <p class="text-muted">No appointments found.</p>
<?php endif; ?>

</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const loader = document.getElementById('loader');

        // Show loader on pagination click
        document.querySelectorAll('.pagination a').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                loader.style.display = 'block';

                const url = this.href;
                setTimeout(() => {
                    window.location.href = url;
                }, 5000); // 2 seconds delay
            });
        });

        // Show loader on search submit
        const searchForm = document.querySelector('form[action="<?php echo e(route('appointments')); ?>"]');
        if (searchForm) {
            searchForm.addEventListener('submit', function () {
                loader.style.display = 'block';
                // Optional: delay form submission
                setTimeout(() => {
                    this.submit();
                }, 5000); // 2 seconds delay
            });
        }
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/2025 Projects/A1ClassicGarage/resources/views/admin/appointments/index.blade.php ENDPATH**/ ?>