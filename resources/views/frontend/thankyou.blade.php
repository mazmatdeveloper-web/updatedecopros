@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <h2 class="mb-4 text-success">🎉 Thank You!</h2>
    <p>Your appointment has been successfully booked.</p>

    <div class="card mt-4 text-start mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <p><strong>Customer Name:</strong> {{ $appointment->customer?->name ?? 'N/A' }}</p>
            <p><strong>Cleaner Name:</strong> {{ $appointment->cleaner?->name ?? 'N/A' }}</p>
            <p><strong>Service:</strong> {{ $appointment->service?->service_name ?? 'N/A' }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}</p>
            <p><strong>Time:</strong> {{ $appointment->start_time }} - {{ $appointment->end_time }}</p>
            <p><strong>Address:</strong> {{ $appointment->address ?? 'N/A' }}</p>
            <p><strong>Total Price:</strong> ${{ number_format($appointment->total_price, 2) }}</p>
            <p class="text-muted small">Booked at: {{ $appointment->created_at->format('Y-m-d H:i') }}</p>
        </div>
    </div>

    <a href="{{ route('customer.dashboard') }}" class="btn btn-primary mt-4">Go to Dashboard</a>
</div>
@endsection
