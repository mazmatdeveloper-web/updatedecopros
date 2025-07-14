@extends('layouts.app')

@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDNECwhx76acUzGrfxknooV5O9LJFJSyKA&libraries=places"></script>
    
    <style>
        .pac-container {
            z-index: 1056 !important;
        }
    .service-card {
        cursor: pointer;
        border: 2px solid #dee2e6;
        border-radius: 8px;
        padding: 10px;
        transition: all 0.3s ease;
        height: 100%;
    }

    .service-card:hover {
        border-color: #0d6efd;
        background-color: #f0f8ff;
    }

    .service-checkbox:checked + .service-card {
        border-color: #0d6efd;
        background-color: #e7f1ff;
    }

    .service-checkbox {
        display: none;
    }
</style>

<style>
    .hover-effect:hover {
        transform: translateY(-5px);
        transition: 0.3s;
        border-color: #007bff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .service-card {
        cursor: pointer;
    }
</style>

    <!-- <script>
        $(document).ready(function() {
            $('#zipcodeModal').modal('show');
        });
    </script> -->

<div class="modal modal-md fade" id="zipcodeModal" tabindex="-1" aria-labelledby="zipcodeModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="true">
        <div class="modal-dialog modal-dialog-centered zipcodemodal">
            <div class="modal-content">
                <div class="modal-body">             
                    <form id="zipcode-form">
                        <div class="mb-3">
                            <label for="autocomplete" class="form-label modal-label">We just need your <strong>ADDRESS</strong> to start.</label>
                            <div class="row">
                                <div class="col-md-8 zipfield-col">
                                    <input type="text" id="autocomplete" class="zipcode-field form-control"
                                    placeholder="e.g. Haun Road, Menifee, CA">
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="w-100 zipcode-submit">Submit</button>
                                </div>
                            </div>
                            
                        </div>
                        <!-- <div id="successmessage" style="font-siz:14px; color: green; text-align:center; margin-top:10px; display:none;"></div> -->
                        <p id="error" class='mb-0 mt-1' style="color:red; display:none;">Zip code not found in system.</p>
                    </form>
                </div>
            </div>
        </div>
    </div>

   <div class="row d-flex justify-content-center"  id="service-section" style="display: none;">
        <div class="col-md-6">
        <div id="initial-form" class="mt-4">
    <h2 class='mb-4 fw-bold text-primary'>Select Services</h2>

    <form action="{{ route('quote.extended') }}" method='POST'>
        @csrf

        {{-- Editable Address Display --}}
        <div class="mb-4">
            <label class="form-label fw-semibold text-dark">Location</label>
            <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded shadow-sm">
                <p class="mb-0 text-muted" id="address_text">
                    {{ session('booking.address') ?? 'Click ✎ to enter address' }}
                </p>
                <button type="button" class="btn btn-outline-secondary btn-sm" id="editAddressBtn">✎</button>
            </div>
            <input type="hidden" name="address" id="address_field" value="{{ old('address', session('booking.address')) }}">
            @error('address')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Services --}}
        <label class="form-label fw-semibold text-dark mb-4">Select Services</label>
        <div class="row">
            @php $selectedServices = session('booking.services', []); @endphp
            @foreach($services as $service)
                <div class="col-md-4 col-sm-6 mb-4">
                    <label class="w-100">
                        <input type="checkbox" name="service_type[]" value="{{ $service->id }}"
                            class="d-none service-checkbox"
                            {{ in_array($service->id, $selectedServices) ? 'checked' : '' }}>
                        
                        <div class="d-flex gap-2 service-card border rounded shadow-sm p-2 hover-effect">
                            <img src="/storage/{{ $service->service_image }}" class="img-fluid mb-2" alt="">
                           <div class="service-content">
                                <h6 class="mb-0 fw-bold">{{ $service->service_name }}</h6>
                                <small class="text-muted">${{ number_format($service->price, 2) }}</small>
                           </div>
                        </div>
                    </label>
                </div>
            @endforeach
        </div>

        @error('service_type')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        <button type='submit' class='btn btn-primary w-100 py-2 fw-semibold mt-3'>Continue</button>
    </form>
</div>

        </div>
   </div>

 
       
<script>
    $(document).ready(function() {
    $('#editAddressBtn').on('focus click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $('#zipcodeModal').modal('show');
        $(this).blur();
    });
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
    }

    google.maps.event.addDomListener(window, 'load', initAutocomplete);

    $('#zipcode-form').on('submit', function(e) {
        e.preventDefault();

        const address = $('#autocomplete').val();
        let zip = '';

      
        $.get(`https://maps.googleapis.com/maps/api/geocode/json`, {
            address: address,
            key: 'AIzaSyDNECwhx76acUzGrfxknooV5O9LJFJSyKA'
        }, function(response) {
            if (response.status === 'OK') {
                const components = response.results[0].address_components;
                components.forEach(function(component) {
                    if (component.types.includes('postal_code')) {
                        zip = component.long_name;
                    }
                });

                if (zip && /^\d{5}$/.test(zip)) {
                    checkZipcode(zip, address);
                } else {
                    $('#error').text("Could not find a valid 5-digit ZIP code in the address.").show();
                }
            } else {
                $('#error').text("Google could not process the address.").show();
            }
        });
    });

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
                    $('#error').hide();
                    $('#successmessage').text("Zipcode Matched Successfully!").show();
                    $('#next-step').show();
                    $('#address_field').val(address);
                    $('#address_text').html(address);
                    setTimeout(function() {
                        $('#successmessage').fadeOut();
                        $('#zipcodeModal').modal('hide');
                    }, 1000);
                } else {
                    $('#error').text("We are not providing services in this area.").show();
                }
            }
        });
    }
</script>


@endsection