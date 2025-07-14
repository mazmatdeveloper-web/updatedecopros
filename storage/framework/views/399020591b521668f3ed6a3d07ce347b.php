<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>New Booking Notification</title>
  <style>
    @media only screen and (max-width: 640px) {
      .card {
        width: 100% !important;
        margin-bottom: 20px !important;
      }
    }
  </style>
</head>
<body style="margin:0; padding:0; background-color:#f5f7fa; font-family:'Segoe UI', sans-serif;">

  <div style="max-width:700px; margin: 40px auto; background:#ffffff; border-radius:16px; box-shadow:0 12px 28px rgba(0,0,0,0.06); overflow:hidden;">

    <!-- Header -->
    <div style="background-color:#006838; padding:40px 30px; text-align:center; color:white;">
      <img src="https://cdn.bookingkoala.com/uploads/ecoproz/2025/5/8/1746744044LOGOEcoProz.png" style='width:120px;margin-bottom:20px;' alt="">
      <h1 style="margin:0; font-size:24px; font-weight:600;">Your Booking Appointment Has Been Updated</h1>
      <p style="margin-top:10px; font-size:14px; color:#d4f7df;">Hello <?php echo e($appointment->customer->name); ?>, here's the latest your booking update.</p>
    </div>

    <!-- Main Content -->
    <div style="padding: 40px 30px;">

      <!-- Booking Info -->
      <div style="background:#f9fafc; padding:24px; border-radius:12px; border:1px solid #e6eaf0;">
      <div style='display:flex;justify-content:space-between;align-items:start;'>
      <h3 style="margin-top:0; font-size:16px; font-weight:600; color:#333;">Booking Summary</h3>
      <span style='background: #1a73e8;display: inline-block;padding: 5px 10px;border-radius: 6px;font-size: 13px !important;font-weight:bold;color: white !important;'>
      <?php echo e($appointment->status); ?>

      </span>
      </div>  
     
        <p style="margin:8px 0;"><strong>Employee:</strong> <?php echo e($appointment->employee->name); ?></p>
        <?php
              $serviceIds = json_decode($appointment->service_id, true);
              $services = \App\Models\Service::whereIn('id', $serviceIds ?? [])->pluck('service_name')->toArray();
          ?>

          <p style="margin:8px 0;">
              <strong>Service<?php echo e(count($services) > 1 ? 's' : ''); ?>:</strong>
              <?php echo e(implode(', ', $services)); ?>

          </p>          
        <?php
            use Carbon\Carbon;
            $date = Carbon::parse($appointment->appointment_date)->format('D, M d');
            $startTime = Carbon::parse($appointment->start_time)->format('H:i');
            $endTime = Carbon::parse($appointment->end_time)->format('H:i');
        ?>

        <p style="margin:8px 0;">
            <strong>Date & Time:</strong> <?php echo e($date); ?> at <?php echo e($startTime); ?> - <?php echo e($endTime); ?>

        </p>
        <p style="margin:8px 0;"><strong>Address:</strong> <?php echo e($appointment->address); ?></p>
        <p style="margin:8px 0;"><strong>Additional Notes:</strong> <?php echo e($appointment->additional_notes); ?></p>
      
        <?php if(isset($appointment->addons) && $appointment->addons->count()): ?>
            <p><strong>Addons:</strong></p>
            
            <?php $__currentLoopData = $appointment->addons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <p><?php echo e($addon->addon_name); ?> — $<?php echo e(number_format($addon->price, 2)); ?></p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
        <?php endif; ?>

        <p style="margin:8px 0;"><strong>Total Price:</strong> $<?php echo e(number_format($appointment->total_price, 2)); ?></p>
      
      
      </div>

      <!-- CTA -->
      <div style="text-align:center; margin-top:30px;">
        <a href="#" style="background-color:#006838; color:#fff; padding:14px 28px; border-radius:8px; text-decoration:none; font-weight:600; font-size:15px;">
          View in Dashboard
        </a>
      </div>
    </div>

    <!-- Footer -->
    <div style="background-color:#f1f1f1; padding:20px 30px; text-align:center; font-size:12px; color:#888;">
      This is an automated notification for your records.<br>
      &copy; 2025 Ecoproz
    </div>

  </div>
</body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/2025 Projects/A1ClassicGarage/resources/views/emails/updates/customer_appointment_update.blade.php ENDPATH**/ ?>