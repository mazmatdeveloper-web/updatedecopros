@extends('customer.layouts.app')

@section('customer_content')
<div class="container py-4">
    <h2 class="mb-4">My Booked Appointments</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row row-cols-1 row-cols-md-2 g-4">
    @foreach($appointments as $key => $appointment)
        <div class="col">
            <div class="card h-100 appointment-card" data-bs-toggle="modal" data-bs-target="#appointmentModal{{ $key }}">
                <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-2">
                        {{ $appointment['service_name'] }}    
                    </h5>
                    @if($appointment['status'] == 'pending')
                                <span class="badge bg-info">{{ ucfirst($appointment['status']) }}</span>
                                @elseif($appointment['status'] == 'confirmed')
                                <span class="badge bg-warning">{{ ucfirst($appointment['status']) }}</span>
                                @elseif($appointment['status'] == 'cancelled')
                                <span class="badge bg-danger">{{ ucfirst($appointment['status']) }}</span>
                                @elseif($appointment['status'] == 'completed')
                                <span class="badge bg-success">{{ ucfirst($appointment['status']) }}</span>
                                @endif
                </div>   
                    <p class="mb-1"><strong>Date:</strong> {{ $appointment['date'] }}</p>
                    <p class="mb-1"><strong>Time:</strong> {{ $appointment['time'] }}</p>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="appointmentModal{{ $key }}" tabindex="-1" aria-labelledby="appointmentModalLabel{{ $key }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="appointmentModalLabel{{ $key }}">{{ $appointment['service_name'] }} Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Status:</strong> {{ $appointment['status'] }}</p>
                        <p><strong>Cleaner:</strong> {{ $appointment['cleaner_name'] }}</p>
                        <p><strong>Date:</strong> {{ $appointment['date'] }}</p>
                        <p><strong>Time:</strong> {{ $appointment['time'] }}</p>

                        <p><strong>Addons:</strong>
                            @if(count($appointment['addons']))
                                <ul class="ps-3">
                                    @foreach($appointment['addons'] as $addon)
                                        <li>{{ $addon }}</li>
                                    @endforeach
                                </ul>
                            @else
                                None
                            @endif
                        </p>

                        @if($appointment['discount_label'] !== 'one_time')
                            <p><strong>Discount:</strong> {{ $appointment['discount_label'] }} ({{ $appointment['discount_price'] }})</p>
                        @endif
                        <p><strong>Total Price:</strong> ${{ $appointment['total_price'] }}</p>
                        <p class="text-muted"><small>Booked at: {{ $appointment['booked_at'] }}</small></p>
                        <a href="{{ route('edit.customer.appointment', $appointment['id']) }}">
                                    <button
                                        class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle edit-option-btn">
                                    <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                    </button>
                                </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

</div>
@endsection