@extends('admin.layouts.app')

@section('admin_content')
<div id="loader" style="display:none; position: fixed; top: 50%; left: 50%; z-index: 9999; transform: translate(-50%, -50%)">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<div class="container py-4">
    <h2 class="mb-4">All Appointments</h2>

    <form method="GET" action="{{ route('appointments') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by service, cleaner, date, or status..." value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    @if($appointments->count())
    <div class="row row-cols-1 row-cols-md-2 g-4">
        @foreach($appointments as $appointment)
            @php
                $serviceIds = json_decode($appointment->service_id, true);
                $services = \App\Models\Service::whereIn('id', $serviceIds ?? [])->pluck('service_name')->toArray();
            @endphp

            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">
                                {{ implode(', ', $services) ?: 'N/A' }}

                                @if($appointment->status == 'pending')
                                    <span class="badge bg-info">{{ ucfirst($appointment->status) }}</span>
                                @elseif($appointment->status == 'confirmed')
                                    <span class="badge bg-warning">{{ ucfirst($appointment->status) }}</span>
                                @elseif($appointment->status == 'cancelled')
                                    <span class="badge bg-danger">{{ ucfirst($appointment->status) }}</span>
                                @elseif($appointment->status == 'completed')
                                    <span class="badge bg-success">{{ ucfirst($appointment->status) }}</span>
                                @endif
                            </h5>

                            <div class="d-flex align-items-center gap-1">
                                <a href="{{ route('edit.appointment', $appointment->id) }}">
                                    <button class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle edit-option-btn">
                                        <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                    </button>
                                </a>
                                <form action="{{ route('delete.appointment', $appointment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this appointment?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                        <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <p><strong>Employee:</strong> {{ $appointment->employee->name ?? 'N/A' }}</p>
                        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}</p>
                        <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}</p>
                        <p><strong>Total Price:</strong> ${{ number_format($appointment->total_price, 2) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $appointments->withQueryString()->links() }}
    </div>
@else
    <p class="text-muted">No appointments found.</p>
@endif

</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const loader = document.getElementById('loader');

        // Show loader on pagination click
        document.querySelectorAll('.pagination a').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                loader.style.display = 'block';

                const url = this.href;
                setTimeout(() => {
                    window.location.href = url;
                }, 5000); // 2 seconds delay
            });
        });

        // Show loader on search submit
        const searchForm = document.querySelector('form[action="{{ route('appointments') }}"]');
        if (searchForm) {
            searchForm.addEventListener('submit', function () {
                loader.style.display = 'block';
                // Optional: delay form submission
                setTimeout(() => {
                    this.submit();
                }, 5000); // 2 seconds delay
            });
        }
    });
</script>

@endsection
