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
      <h1 style="margin:0; font-size:24px; font-weight:600;">New Booking Received</h1>
      <p style="margin-top:10px; font-size:14px; color:#d4f7df;">Hello {{ $appointment->customer->name }}, here's the latest booking update.</p>
    </div>

    <!-- Main Content -->
    <div style="padding: 40px 30px;">

      <!-- Booking Info -->
      <div style="background:#f9fafc; padding:24px; border-radius:12px; border:1px solid #e6eaf0;">
        <h3 style="margin-top:0; font-size:16px; font-weight:600; color:#333;">Booking Summary</h3>
        <p style="margin:8px 0;"><strong>Cleaner:</strong> {{ $appointment->cleaner->name }}</p>
        <p style="margin:8px 0;"><strong>Service:</strong> {{ $appointment->service->service_name }}</p>
        <p style="margin:8px 0;"><strong>Date & Time:</strong> {{ $appointment->appointment_date }} at {{ $appointment->start_time }} - {{ $appointment->end_time }}</p>
        <p style="margin:8px 0;"><strong>Address:</strong> {{ $appointment->address }}</p>
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
