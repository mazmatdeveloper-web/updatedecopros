<?php $__env->startSection('admin_content'); ?>
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center gap-3 mb-24 justify-content-between">
        <div class="card border-0 shadow-sm rounded-4 p-3 mb-4" style="max-width: 500px;">
            <div class="d-flex align-items-center mb-3">
                <?php if($customer->profile_picture): ?>
                <img src="<?php echo e(asset('storage/' . $customer->profile_picture)); ?>" alt="Profile Picture"
                    class="rounded-circle shadow" style="width: 80px; height: 80px; object-fit: cover;">
                <?php else: ?>
                <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($customer->name)); ?>&background=0D8ABC&color=fff"
                    alt="Default Avatar" class="rounded-circle shadow"
                    style="width: 80px; height: 80px; object-fit: cover;">
                <?php endif; ?>
                <div class="ms-3">
                    <h5 class="mb-1 fw-bold text-dark"><?php echo e($customer->name); ?></h5>
                    <span class="text-muted small"><?php echo e($customer->email); ?></span>
                </div>
            </div>

            <ul class="list-group list-group-flush border-top pt-3">
                <li class="list-group-item px-0 d-flex justify-content-between align-items-center border-0">
                    <strong><i class="bi bi-telephone me-1"></i>Phone:</strong>
                    <span><?php echo e($customer->phone); ?></span>
                </li>
            </ul>
        </div>

        <?php if($errors->any()): ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Something went wrong...',
                html: `<?php echo implode('<br>', $errors->all()); ?>`,
                position: 'top-end',
                toast: true,
                timer: 500000,
                showCloseButton: true,
                showConfirmButton: false,
                timerProgressBar: true,
            });
        </script>
        <?php endif; ?>
        <div>
            <button data-bs-toggle="modal" data-bs-target="#customeraddModal" data-id="<?php echo e($customer->id); ?>"
                data-name="<?php echo e($customer->name); ?>" data-email="<?php echo e($customer->email); ?>" data-phone="<?php echo e($customer->phone); ?>"
                data-bio="<?php echo e($customer->bio); ?>" data-price="<?php echo e($customer->price); ?>" class="btn btn-primary">Update Profile
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- Buttons to open modal -->

            <!-- Tabs -->
            <ul class="nav nav-tabs mt-4" id="customerTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="bed-area-tab" data-bs-toggle="tab" data-bs-target="#bedarea"
                        type="button" role="tab" aria-controls="bed-area" aria-selected="false">Appointments</button>
                </li>
            </ul>

            <!-- Tab content -->
            <div class="tab-content mt-4" id="customerTabContent">
                <!-- Bedroom Area Sqft Tab -->
                <div class="tab-pane fade active show" id="bedarea" role="tabpanel" aria-labelledby="bed-area-tab">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="mb-4">Appointments for <strong><?php echo e($customer->name); ?></strong></h5>

                            <?php if($appointments->count()): ?>
                            <div class="row row-cols-1 row-cols-md-2 g-4">
                                <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="card-title">
                                                    <?php echo e($appointment->service->service_name ?? 'N/A'); ?>

                                                    <span class="badge bg-<?php echo e($appointment->status == 'pending' ? 'info' :
                                                                ($appointment->status == 'confirmed' ? 'warning' :
                                                                ($appointment->status == 'cancelled' ? 'danger' : 'success'))); ?>">
                                                        <?php echo e(ucfirst($appointment->status)); ?>

                                                    </span>
                                                </h5>
                                                <div class="d-flex align-items-center gap-1">
                                                    <a href="<?php echo e(route('edit.appointment', $appointment->id)); ?>">
                                                        <button class="btn btn-outline-success btn-sm rounded-circle p-3">
                                                          <iconify-icon icon="lucide:edit" class="icon text-xl"></iconify-icon>
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                            <p><strong>Cleaner:</strong> <?php echo e($appointment->cleaner->name ?? 'N/A'); ?></p>
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
                            <p class="text-muted">No appointments found for this customer.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

</div>
</div>
</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/2025 Projects/A1ClassicGarage/resources/views/admin/customers/single_customer.blade.php ENDPATH**/ ?>