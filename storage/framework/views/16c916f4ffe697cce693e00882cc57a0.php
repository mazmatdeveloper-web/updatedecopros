<h2>New Appointment Details</h2>
<p><strong>Customer:</strong> <?php echo e($appointment->customer->name); ?></p>
<p><strong>Cleaner:</strong> <?php echo e($appointment->cleaner->name); ?></p>
<p><strong>Service:</strong> <?php echo e($appointment->service->service_name); ?></p>
<p><strong>Date:</strong> <?php echo e($appointment->appointment_date); ?></p>
<p><strong>Time:</strong> <?php echo e($appointment->start_time); ?> - <?php echo e($appointment->end_time); ?></p>
<p><strong>Address:</strong> <?php echo e($appointment->address); ?></p>
<?php /**PATH D:\echopros1\echopros\updatedecopros\resources\views/emails/appointment_email.blade.php ENDPATH**/ ?>