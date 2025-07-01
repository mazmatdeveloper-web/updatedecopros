@extends('admin.layouts.app')

@section('admin_content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center gap-3 mb-24 justify-content-between">
        <div class="card border-0 shadow-sm rounded-4 p-3 mb-4" style="max-width: 500px;">
            <div class="d-flex align-items-center mb-3">
                @if ($customer->profile_picture)
                <img src="{{ asset('storage/' . $customer->profile_picture) }}" alt="Profile Picture"
                    class="rounded-circle shadow" style="width: 80px; height: 80px; object-fit: cover;">
                @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=0D8ABC&color=fff"
                    alt="Default Avatar" class="rounded-circle shadow"
                    style="width: 80px; height: 80px; object-fit: cover;">
                @endif
                <div class="ms-3">
                    <h5 class="mb-1 fw-bold text-dark">{{ $customer->name }}</h5>
                    <span class="text-muted small">{{ $customer->email }}</span>
                </div>
            </div>

            <ul class="list-group list-group-flush border-top pt-3">
                <li class="list-group-item px-0 d-flex justify-content-between align-items-center border-0">
                    <strong><i class="bi bi-telephone me-1"></i>Phone:</strong>
                    <span>{{ $customer->phone }}</span>
                </li>
            </ul>
        </div>

        @if ($errors->any())
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Something went wrong...',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                position: 'top-end',
                toast: true,
                timer: 500000,
                showCloseButton: true,
                showConfirmButton: false,
                timerProgressBar: true,
            });
        </script>
        @endif
        <div>
            <button data-bs-toggle="modal" data-bs-target="#customeraddModal" data-id="{{ $customer->id }}"
                data-name="{{$customer->name}}" data-email="{{$customer->email}}" data-phone="{{$customer->phone}}"
                data-bio="{{$customer->bio}}" data-price="{{$customer->price}}" class="btn btn-primary">Update Profile
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- Buttons to open modal -->

            <!-- Tabs -->
            <ul class="nav nav-tabs mt-4" id="customerTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="bed-area-tab" data-bs-toggle="tab" data-bs-target="#bedarea"
                        type="button" role="tab" aria-controls="bed-area" aria-selected="false">Appointments</button>
                </li>
            </ul>

            <!-- Tab content -->
            <div class="tab-content mt-4" id="customerTabContent">
                <!-- Bedroom Area Sqft Tab -->
                <div class="tab-pane fade active show" id="bedarea" role="tabpanel" aria-labelledby="bed-area-tab">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="mb-4">Appointments for <strong>{{ $customer->name }}</strong></h5>

                            @if($appointments->count())
                            <div class="row row-cols-1 row-cols-md-2 g-4">
                                @foreach($appointments as $appointment)
                                <div class="col">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="card-title">
                                                    {{ $appointment->service->service_name ?? 'N/A' }}
                                                    <span class="badge bg-{{ 
                                                                $appointment->status == 'pending' ? 'info' :
                                                                ($appointment->status == 'confirmed' ? 'warning' :
                                                                ($appointment->status == 'cancelled' ? 'danger' : 'success'))
                                                            }}">
                                                        {{ ucfirst($appointment->status) }}
                                                    </span>
                                                </h5>
                                                <div class="d-flex align-items-center gap-1">
                                                    <a href="{{ route('edit.appointment', $appointment->id) }}">
                                                        <button class="btn btn-outline-success btn-sm rounded-circle p-3">
                                                          <iconify-icon icon="lucide:edit" class="icon text-xl"></iconify-icon>
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                            <p><strong>Cleaner:</strong> {{ $appointment->cleaner->name ?? 'N/A' }}</p>
                                            <p><strong>Date:</strong> {{
                                                \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y')
                                                }}</p>
                                            <p><strong>Time:</strong> {{
                                                \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} - {{
                                                \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}</p>
                                            <p><strong>Total Price:</strong> ${{
                                                number_format($appointment->total_price, 2) }}</p>
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
                            <p class="text-muted">No appointments found for this customer.</p>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

</div>
</div>
</div>
</div>

@endsection