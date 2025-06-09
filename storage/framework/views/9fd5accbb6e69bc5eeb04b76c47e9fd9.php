<?php $__env->startSection('content'); ?>
<div class="container py-5 text-center">
    <h2 class="mb-4 text-success">🎉 Thank You!</h2>
    <p>Your appointment has been successfully booked.</p>

    <div class="card mt-4 text-start mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <p><strong>Customer Name:</strong> <?php echo e($appointment->customer?->name ?? 'N/A'); ?></p>
            <p><strong>Cleaner Name:</strong> <?php echo e($appointment->cleaner?->name ?? 'N/A'); ?></p>
            <p><strong>Service:</strong> <?php echo e($appointment->service?->service_name ?? 'N/A'); ?></p>
            <p><strong>Date:</strong> <?php echo e(\Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y')); ?></p>
            <p><strong>Time:</strong> <?php echo e($appointment->start_time); ?> - <?php echo e($appointment->end_time); ?></p>
            <p><strong>Address:</strong> <?php echo e($appointment->address ?? 'N/A'); ?></p>
            <p><strong>Total Price:</strong> $<?php echo e(number_format($appointment->total_price, 2)); ?></p>
            <p class="text-muted small">Booked at: <?php echo e($appointment->created_at->format('Y-m-d H:i')); ?></p>
        </div>
    </div>

    <a href="<?php echo e(route('customer.dashboard')); ?>" class="btn btn-primary mt-4">Go to Dashboard</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/2025 Projects/updatedecopros/resources/views/frontend/thankyou.blade.php ENDPATH**/ ?>