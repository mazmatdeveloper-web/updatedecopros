<!-- appointment-reminder.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Appointment Reminder</title>
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
      <h1 style="margin:0; font-size:24px; font-weight:600;color:white;text-align:center;">Appointment Reminder</h1>
      <p style="margin-top:10px; font-size:14px; color:#d4f7df;text-align:center;">Don't forget your upcoming appointment!</p>
    </div>

    <!-- Main Content -->
    <div style="padding: 40px 30px;">
      <div style="background:#f9fafc; padding:24px; border-radius:12px; border:1px solid #e6eaf0;">
        <h3 style="margin-top:0; font-size:16px; font-weight:600; color:#333;">Hello {{ $appointment->customer->name }},</h3>
        
        @php
            use Carbon\Carbon;
            $date = Carbon::parse($appointment->appointment_date)->format('l, F j');
            $start = Carbon::parse($appointment->start_time)->format('g:i A');
            $end = Carbon::parse($appointment->end_time)->format('g:i A');
        @endphp

        <p style="font-size:15px; color:#555;">
          This is a friendly reminder for your upcoming appointment with <strong>{{ $appointment->cleaner->name }}</strong> scheduled for <strong>{{ $date }}</strong> between <strong>{{ $start }} and {{ $end }}</strong>.  
          The service booked is <strong>{{ $appointment->service->service_name }}</strong>.
        </p>

        <p style="font-size:15px; color:#555;">We look forward to serving you. Please ensure you're available at the address you provided.</p>
      </div>
    </div>

    <!-- Footer -->
    <div style="background-color:#f1f1f1; padding:20px 30px; text-align:center; font-size:12px; color:#888;">
      Appointment reminder from Ecoproz.<br>
      &copy; 2025 Ecoproz Admin Panel
    </div>

  </div>
</body>
</html>
