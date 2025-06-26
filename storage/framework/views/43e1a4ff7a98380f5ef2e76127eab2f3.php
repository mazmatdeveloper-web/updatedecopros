<!-- admin-booking.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>New Appointment Notification</title>
  <style>
    @media only screen and (max-width: 640px) {
      .card { width: 100% !important; margin-bottom: 20px !important; }
    }
  </style>
</head>
<body style="margin:0; padding:0; background-color:#f5f7fa; font-family:'Segoe UI', sans-serif;'">

  <div style="max-width:700px; margin: 40px auto; background:#ffffff; border-radius:16px; box-shadow:0 12px 28px rgba(0,0,0,0.06); overflow:hidden;">

    <!-- Header -->
    <div style="background-color:#006838; padding:40px 30px; text-align:center; color:white;">
      <img src="https://cdn.bookingkoala.com/uploads/ecoproz/2025/5/8/1746744044LOGOEcoProz.png" style='width:120px;margin-bottom:20px;' alt="">
      <h1 style="margin:0; font-size:24px; font-weight:600;">New Appointment Created</h1>
      <p style="margin-top:10px; font-size:14px; color:#d4f7df;">A new appointment has been booked.</p>
    </div>

    <!-- Main Content -->
    <div style="padding: 40px 30px;">
      <div style="background:#f9fafc; padding:24px; border-radius:12px; border:1px solid #e6eaf0;">
        <h3 style="margin-top:0; font-size:16px; font-weight:600; color:#333;">Booking Overview</h3>
        <p><strong>Customer:</strong> <?php echo e($appointment->customer->name); ?> (<?php echo e($appointment->customer->email); ?>)</p>
        <p><strong>Cleaner:</strong> <?php echo e($appointment->cleaner->name); ?></p>
        <p><strong>Service:</strong> <?php echo e($appointment->service->service_name); ?></p>
        <p><strong>Dimensions:</strong>
            <?php echo e($appointment->bedsArea->beds ?? '-'); ?> BD /
            <?php echo e($appointment->no_of_baths); ?> BR /
            <?php echo e($appointment->bedsArea->no_of_sqft ?? '-'); ?> sqft
        </p>
        <p><strong>Price:</strong> $<?php echo e(number_format($appointment->total_price, 2)); ?></p>

        <?php
            use Carbon\Carbon;
            $date = Carbon::parse($appointment->appointment_date)->format('D, M d');
            $start = Carbon::parse($appointment->start_time)->format('H:i');
            $end = Carbon::parse($appointment->end_time)->format('H:i');
        ?>
        <p><strong>Date & Time:</strong> <?php echo e($date); ?> at <?php echo e($start); ?> - <?php echo e($end); ?></p>


        <?php if(isset($appointment->addons) && $appointment->addons->count()): ?>
            <p><strong>Addons:</strong></p>
            
            <?php $__currentLoopData = $appointment->addons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <p><?php echo e($addon->addon_name); ?> — $<?php echo e(number_format($addon->price, 2)); ?></p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
        <?php endif; ?>

        <p style="margin:8px 0;"><strong>Total Price:</strong> $<?php echo e(number_format($appointment->total_price, 2)); ?></p>
      
        
        <p><strong>Address:</strong> <?php echo e($appointment->address); ?></p>
        <p><strong>Additional Notes:</strong> <?php echo e($appointment->additional_notes); ?></p>
      </div>
    </div>

    <!-- Footer -->
    <div style="background-color:#f1f1f1; padding:20px 30px; text-align:center; font-size:12px; color:#888;">
      Appointment successfully logged into the system.<br>
      &copy; 2025 Ecoproz Admin Panel
    </div>

  </div>
</body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/2025 Projects/updatedecopros/resources/views/emails/booking/admin_new_booking.blade.php ENDPATH**/ ?>