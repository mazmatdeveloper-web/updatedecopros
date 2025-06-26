@extends('admin.layouts.app')

@section('admin_content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDNECwhx76acUzGrfxknooV5O9LJFJSyKA&libraries=places"></script>
    

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('update.availability', $appointments->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="appointment_id" value="{{ $appointments->id ?? '' }}">
                            <!-- Service Name -->
                                <div class="mb-3">
                                    <label for="service_name" class="form-label fw-semibold">Service Name</label>
                                    <input type="text" class="form-control" id="service_name" name="service_name"
                                        value="{{ old('service_name', $appointments->service->service_name ?? '') }}" readonly>
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="status" class="form-label fw-semibold">Appointment Status</label>
                                    <select class="form-select" id="status" name="status">
                                        @foreach(['pending', 'confirmed', 'completed', 'cancelled'] as $status)
                                            <option value="{{ $status }}" {{ (old('status', $appointments->status) === $status) ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Cleaner -->
                                <div class="mb-3">
                                    <label for="cleaner" class="form-label fw-semibold">Assigned Cleaner</label>
                                    <select class="form-select" id="cleaner" name="cleaner">
                                        <option value="">Select Cleaner</option>
                                        @foreach($cleaners as $cleaner)
                                            <option value="{{ $cleaner->id }}"
                                                {{ $appointments->cleaner_id == $cleaner->id ? 'selected' : '' }}>
                                                {{ $cleaner->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" id="cleaner_id" name="cleaner_id" value="{{ $appointments->cleaner_id }}">
                                </div>

                                <!-- Date -->
                                <div class="mb-3">
                                    <label for="appointment_date" class="form-label fw-semibold">Appointment Date <span class='badge bg-success'>{{ $appointments->appointment_date }}</span></label>
                                    <input type="date" class="form-control" id="appointment_date" name="appointment_date"
                                        value="{{ old('appointment_date', $appointments->appointment_date ?? '') }}">
                                </div>

                                <!-- Time Slot -->
                                <div class="mb-3">
                                    <label for="start_time" class="form-label fw-semibold">Time Slot <span class='badge bg-success'>{{$appointments->start_time}} - {{$appointments->end_time}}</span></label>
                                    <select class="form-select" id="start_time" name="start_time">
                                        <option value="">Select a time</option>
                                        <option value="{{ \Carbon\Carbon::parse($appointments->start_time)->format('H:i')  }} - {{ \Carbon\Carbon::parse($appointments->end_time)->format('H:i')  }}" selected>{{ \Carbon\Carbon::parse($appointments->start_time)->format('H:i')  }} - {{ \Carbon\Carbon::parse($appointments->end_time)->format('H:i')  }}</option>
                                        <!-- Time slots will be populated via JS -->
                                    </select>
                                </div>

                                <!-- Address -->
                                <div class="mb-3">
                                    <label for="start_time" class="form-label fw-semibold">Address</label>
                                    <input type="text" name='address' id="autocomplete" class="zipcode-field form-control"
                                    value='{{ $appointments->address }}'>
                                    <input type="hidden" id="old_address" value="{{ $appointments->address ?? '' }}">
                                    <div id="address-error" class="text-danger mt-1" style="display:none;"></div>
                                </div>

                                <!-- Price -->
                                <div class="mb-3">
                                    <label for="price" class="form-label fw-semibold">Total Price ($)</label>
                                    <input type="number" step="0.01" class="form-control" id="price" name="price"
                                        value="{{ old('price', $appointments->total_price ?? '') }}">
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="bi bi-save me-2"></i> Update Appointment
                                    </button>
                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cleanerSelect = document.getElementById('cleaner');
        const dateInput = document.getElementById('appointment_date');
        const slotSelect = document.getElementById('start_time');

        async function fetchSlots() {
            const cleanerId = cleanerSelect.value;
            const date = dateInput.value;

            if (!cleanerId || !date) {
                slotSelect.innerHTML = '<option value="">Select a time</option>';
                return;
            }

            try {
                const response = await fetch(`/admin/cleaner-slots?cleaner_id=${cleanerId}&date=${date}`);
                const data = await response.json();

                slotSelect.innerHTML = '<option value="">Select a time</option>';
                if (data.slots.length > 0) {
                    data.slots.forEach(slot => {
                        const option = document.createElement('option');
                        option.value = slot.start_time + ' - ' + slot.end_time;
                        option.text = slot.start_time + ' - ' + slot.end_time;
                        slotSelect.appendChild(option);
                    });
                } else {
                    slotSelect.innerHTML = '<option value="">No available slots</option>';
                }
            } catch (error) {
                console.error('Error fetching slots:', error);
            }
        }

        cleanerSelect.addEventListener('change', fetchSlots);
        dateInput.addEventListener('change', fetchSlots);
    });
</script>

<script>
    let autocomplete;

    function initAutocomplete() {
        autocomplete = new google.maps.places.Autocomplete(
            document.getElementById('autocomplete'), {
                types: ['geocode'],
                componentRestrictions: { country: 'us' }
            }
        );

        autocomplete.addListener('place_changed', function () {
            const place = autocomplete.getPlace();
            const address = $('#autocomplete').val();
            let zip = '';

            // Extract ZIP code from the selected place
            if (place.address_components) {
                place.address_components.forEach(function(component) {
                    if (component.types.includes('postal_code')) {
                        zip = component.long_name;
                    }
                });
            }

            // Show error if no zip found
            if (!zip || !/^\d{5}$/.test(zip)) {
                $('#address-error').text("Could not detect a valid ZIP code from the selected address.").show();
                return;
            }

            checkZipcode(zip, address);
        });
    }

    // Load autocomplete on page load
    google.maps.event.addDomListener(window, 'load', initAutocomplete);

    // Ajax function to check if we serve that area
    function checkZipcode(zip, address) {
        $.ajax({
            url: "{{ route('check.zipcode') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                zipcode: zip
            },
            success: function(response) {
                if (response.exists) {
                    $('#address-error').hide(); // Clear error
                    $('#address_field').val(address); // Update hidden field
                } else {
                    $('#address-error').text("We are not currently serving this area.").show();
                    
                    // Revert visible input to old address
                    const oldAddress = $('#old_address').val();
                    $('#autocomplete').val(oldAddress);

                    // Also update hidden address field to old value
                    $('#address_field').val(oldAddress);
                }
            },
            error: function() {
                $('#address-error').text("An error occurred while checking the service area. Please try again.").show();
            }
        });
    }
</script>

@endsection
