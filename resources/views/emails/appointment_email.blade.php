<h2>New Appointment Details</h2>
<p><strong>Customer:</strong> {{ $appointment->customer->name }}</p>
<p><strong>Cleaner:</strong> {{ $appointment->cleaner->name }}</p>
<p><strong>Service:</strong> {{ $appointment->service->service_name }}</p>
<p><strong>Date:</strong> {{ $appointment->appointment_date }}</p>
<p><strong>Time:</strong> {{ $appointment->start_time }} - {{ $appointment->end_time }}</p>
<p><strong>Address:</strong> {{ $appointment->address }}</p>
