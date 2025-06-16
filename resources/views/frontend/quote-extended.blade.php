@extends('layouts.app')

@section('content')

<!-- <aside class='quote-sidebar'>
  

            
            
</aside> -->

<div class="main-content">
    <div class="container-fluid">
   
    <div class="row d-flex justify-content-center">
        
            <div class="col-md-9 pt-4">

            <h6>7 House Cleaners<br>Serving {{ $quoteData['address'] }}</h6>

            
<!-- <div id="filters-form-div" class="mt-2">
    <form action="" class='filters-form'>
        @csrf
        
        <div class="field-group mb-0">
            <input type="hidden" name="address" value="{{ $quoteData['address'] }}" class='address_form_field form_field' id="address_field">
        </div>
        <div class="field-group">
        
            <button type='button' class='pill-btn' data-bs-toggle="modal" data-bs-target="#pill-modal">
                <span class='no_of_beds'>{{ $quoteData['beds']}} BD</span>
                <span class='seperator'>/</span>
                <span class='no_of_bathrooms'>{{ $quoteData['baths'] }} BR</span>
                <span class='seperator'>/</span>
                <span class='sq_ft'>{{ $quoteData['sq_ft'] }} sqft</span>
            </button>
        </div>

        <div class="field-group">
            <label class='field_group_label'>Frequency</label><br>
            <select name="service_duration" id="service_duration">
                <option value="one_time" {{ $quoteData['service_duration'] === 'one_time' ? 'selected' : '' }}>One-time Cleaning</option>
                <option value="weekly" {{ $quoteData['service_duration'] === 'weekly' ? 'selected' : '' }}>Weekly (20% off)</option>
                <option value="biweekly" {{ $quoteData['service_duration'] === 'biweekly' ? 'selected' : '' }}>Biweekly (15% off)</option>
                <option value="monthly"{{ $quoteData['service_duration'] === 'monthly' ? 'selected' : '' }} >Monthly (10% off)</option>
            </select>
        </div>
        <div class="recurring-message my-3">
            <div class="recurring-title d-flex justify-content-between align-items-center">
                <h4>Make it recurring?</h4>
                <span>Up to 20% off</span>
            </div>
            <p>Providers offer up to 20% off</p>
            <p>Consistent schedule, no contracts</p>
            <p>Rate Increase Protection</p>
        </div>

        <div class="field-group service-select-box">
            <label class='field_group_label'>Which service would you like?</label><br>
            
            <div class="label-div">
            <input type="radio" name="service_type" data-price='50' id='standard_cleaning' class='service_type_form_field form_field' value="Standard Cleaning" {{ $quoteData['service_type'] === 'Standard Cleaning' ? 'checked' : '' }}>
            <label for="standard_cleaning">Standard Cleaning <br><span>Home hasn't been cleaned in a while</span></label><br>
            </div>
            
            <div class="label-div">
            <input type="radio" name="service_type" data-price='40' id='deep_cleaning' class='service_type_form_field form_field' {{ $quoteData['service_type'] === 'Deep Cleaning' ? 'checked' : '' }} value="Deep Cleaning">
            <label for="deep_cleaning">Deep Cleaning <br><span>Home was cleaned in the past few weeks</span></label><br>
            
            </div>
            <div class="label-div">
            <input type="radio" name="service_type" data-price='40' id='move_in_out_cleaning' class='service_type_form_field form_field' {{ $quoteData['service_type'] === 'Move-in/Move-out Cleaning' ? 'checked' : '' }} value="Move-in/Move-out Cleaning" >
            <label for="move_in_out_cleaning">Move-in/Move-out Cleaning <br><span>Home was cleaned in the past few weeks</span></label>
       
            </div>
           
        </div>
        <div class="field-group">
            <label class='field_group_label'>Do you have pets?</label><br>
            <select name="pets" id="pets">
                <option value="no_pets" {{ $quoteData['pets'] === 'no_pets' ? 'selected' : '' }}>No Pets</option>
                <option value="yes_pets" {{ $quoteData['pets'] === 'yes_pets' ? 'selected' : '' }}>Yes, I have pets!</option>
            </select>
        </div>

        <label class='field_group_label'>Available Options</label><br>

        <div class="field-group options-field-group">
        @foreach($addons as $addon)
            <div class="more-options">
                <input type="checkbox" id="addon_{{ $addon->id }}" name="addons[]" value="{{ $addon->id }}">
                <label for="addon_{{ $addon->id }}">{{ $addon->addon_name }}</label><br>
            </div>
        @endforeach

        </div>    
        
    </form>
</div> -->


<form action="" class='filters-form'>
        @csrf
        <div class="form-group-field">
            <input type="hidden" name="address" value="{{ $quoteData['address'] }}" class='address_form_field form_field' id="address_field">
            <label class='field_group_label'>Dimensions</label><br>
            
            <button type='button' class='pill-btn' data-bs-toggle="modal" data-bs-target="#pill-modal">
                <span class='no_of_beds'>{{ $quoteData['beds']}} BD</span>
                <span class='seperator'>/</span>
                <span class='no_of_bathrooms'>{{ $quoteData['baths'] }} BR</span>
                <span class='seperator'>/</span>
                <span class='sq_ft'>{{ $quoteData['sq_ft'] }} sqft</span>
            </button>
        </div>

        <div class="form-group-field">
            <label class='field_group_label'>Frequency</label><br>
            <select name="service_duration" id="service_duration">
                <option value="one_time" {{ $quoteData['service_duration'] === 'one_time' ? 'selected' : '' }}>One-time Cleaning</option>
                <option value="weekly" {{ $quoteData['service_duration'] === 'weekly' ? 'selected' : '' }}>Weekly (20% off)</option>
                <option value="biweekly" {{ $quoteData['service_duration'] === 'biweekly' ? 'selected' : '' }}>Biweekly (15% off)</option>
                <option value="monthly"{{ $quoteData['service_duration'] === 'monthly' ? 'selected' : '' }} >Monthly (10% off)</option>
            </select>
        </div>

        <div class="form-group-field">

            <label class='field_group_label'>Which service would you like?</label><br>
            <select name="service_type" id="service_type">
                <option id='standard_cleaning' value="Standard Cleaning" {{ $quoteData['service_type'] === 'Standard Cleaning' ? 'selected' : '' }}>Standard Cleaning</option>
                <option id='deep_cleaning' {{ $quoteData['service_type'] === 'Deep Cleaning' ? 'selected' : '' }} value="Deep Cleaning">Deep Cleaning</option>
                <option id='move_in_out_cleaning' value="Move-in/Move-out Cleaning" {{ $quoteData['service_type'] === 'Move-in/Move-out Cleaning' ? 'selected' : '' }} value="Move-in/Move-out Cleaning">Move-in/Move-out Cleaning</option>
            </select>
        </div>

        <div class="form-group-field">
            <button type="button" id="toggleAddons">Available Services</button>
            <div class="addons-div" id="addonsDiv">
                @foreach($addons as $addon)
                    <div class="more-options">
                        <input type="checkbox" id="addon_{{ $addon->id }}" name="addons[]" value="{{ $addon->id }}">
                        <label for="addon_{{ $addon->id }}">{{ $addon->addon_name }}</label><br>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="form-group-field">
            <label class='field_group_label'>Do you have pets?</label><br>
            <select name="pets" id="pets">
                <option value="no_pets" {{ $quoteData['pets'] === 'no_pets' ? 'selected' : '' }}>No Pets</option>
                <option value="yes_pets" {{ $quoteData['pets'] === 'yes_pets' ? 'selected' : '' }}>Yes, I have pets!</option>
            </select>
        </div>

</form>


                        {{-- Calendar Date Picker --}}
                <form class="mb-4">
                    @php
                        use Carbon\Carbon;
                        $today = Carbon::today()->toDateString();
                    @endphp
                    <input type="date" name="date" value="{{ $selectedDate }}" class="form-control w-25 d-inline-block" id='dateInput' min="{{ $today }}">
                </form>
                <h3 class="mb-3">{{ \Carbon\Carbon::parse($selectedDate)->format('F j') }}</h3>
    
                <div id="cleanersContainer" class='row'>
               <div class="row d-flex justify-content-center">
                
                @foreach ($cleaners as $cleaner)
                
                <div class="col-md-5">
                <div class="card mb-2 border-0" data-cleaner-id="{{ $cleaner->id }}">
                            <div class="card-body">
                            <div class="cleaner-profile-box d-flex align-items-center justify-content-between">
                                <div class="cleaner-name d-flex align-items-center gap-2">
                                    @if ($cleaner->profile_picture)
                                        <img src="{{ asset('storage/' . $cleaner->profile_picture) }}" alt="Profile Picture" width="150">
                                    @endif
                                    <p class='cleanerId' style='display:none;'>{{$cleaner->id}}</p>
                                    <div>
                                        <h4 class='cleanernames mb-0'>{{ $cleaner->name }} </h4>
                                    @if (!empty($cleaner->available_slots))    
                                        <span class='avialable-badge'>Available</span>
                                    @endif
                                    </div>
                                </div>
                            <div>
                                <span class='base_price'></span>
                                <span class="price-value"></span>
                            </div>
                            </div>    
                                @if (!empty($cleaner->available_slots))
                                    @foreach ($cleaner->available_slots as $slot)
                                        <span class='timeslotstext'>{{ $slot }}</span>
                                    @endforeach
                                @else
                                    <p class='notavailabletext'>Not available</p>
                                @endif
                            </div>
                        </div>
                </div>
                      
                
                @endforeach
                </div>

                </div>
            </div>
        

        <div class="col-md-3 cart-col" style='height:100vh;'>
                <h2 class='cart-col-title mb-4'>Summary</h2>

               
                
                <h3 class='summary-labels'>Dimensions</h3>
                <div class="dimensions-div mb-4">
                    <table class='dimensions-table w-100'>
                        <tr>
                            <th>Dimensions:</th>
                            <td>
                                <span id='bed_summary'>1</span> BD / 
                                <span id='bath_summary'>1</span> BA / 
                                <span id='sqft_summary'>0 - 1000</span> sqft
                            </td>
                        </tr>
                        <tr>
                        <th>Service:</th>
                            <td id='service_summary'></td>
                        </tr>
                    </table>
                </div>
            
                <h3 class='summary-labels'>Additional Services</h3>
                <div class="additional-services-div mb-4">
                    <table class='additional-services-table w-100'>
                    <tr>
                        <th id='addon_name_summary'>Interior Refrigerator</th>
                        <td id='addon_price_summary'></td>
                    </tr> 
                    </table>    
                </div>

                <div class="frequency-div mb-4">
                    <table class='frequency-table w-100'>
                    <!-- <tr>
                        <th>Frequency:</th>
                        <td class='frequenct_summary'>One Time</td>
                    </tr>  -->
                    <!-- <tr>
                        <th>One Time price</th>
                        <td class='onetime_frequency_price_summary'></td>
                    </tr>  -->
                    <tr>
                        <th>Frequency</th>
                        <td class='frequency_name_summary'></td>
                        
                    </tr>   
                    </table>    
                </div>
                
              
                    <input type="hidden" name='selectedTimeSlot' id='selectedTimeSlot'>
                    <input type="hidden" name='selectedCleanerId' id='selectedCleanerId'>
                    <button style='display:none;' class='continuebtn'>Continue</button>
                
            </div>
        </div>
    </div>
</div>




    <div class="modal fade" id="pill-modal" tabindex="-1" aria-labelledby="pillModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="true">
        <div class="modal-dialog modal-dialog-centered pillmodal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pillModalLabel">Input Dimensions</h5>
                </div>
                <div class="modal-body">
                   <p>Input the dimensions of your entire home.</p>
                   <div class="popup-field-group">
                        <select name="no_of_beds" id="no_of_beds_select">
                            <option value="0" {{ $quoteData['beds'] == '0' ? 'selected' : '' }}>0 BD</option>
                            <option value="1" {{ $quoteData['beds'] == '1' ? 'selected' : '' }}>1 BD</option>
                            <option value="2" {{ $quoteData['beds'] == '2' ? 'selected' : '' }}>2 BD</option>
                            <option value="3" {{ $quoteData['beds'] == '3' ? 'selected' : '' }}>3 BD</option>
                            <option value="4" {{ $quoteData['beds'] == '4' ? 'selected' : '' }}>4 BD</option>
                            <option value="5" {{ $quoteData['beds'] == '5' ? 'selected' : '' }}>5 BD</option>
                            <option value="6" {{ $quoteData['beds'] == '6' ? 'selected' : '' }}>6 BD</option>
                        </select>
                        <select name="no_of_baths" id="no_of_baths_select">
                            <option value="1" {{ $quoteData['baths'] == '1' ? 'selected' : '' }}>1 BA</option>
                            <option value="1.5" {{ $quoteData['baths'] == '1.5' ? 'selected' : '' }}>1.5 BA</option>
                            <option value="2" {{ $quoteData['baths'] == '2' ? 'selected' : '' }}>2 BA</option>
                            <option value="2.5" {{ $quoteData['baths'] == '2.5' ? 'selected' : '' }}>2.5 BA</option>
                            <option value="3" {{ $quoteData['baths'] == '3' ? 'selected' : '' }}>3 BA</option>
                            <option value="3.5" {{ $quoteData['baths'] == '3.5' ? 'selected' : '' }}>3.5 BA</option>
                            <option value="4" {{ $quoteData['baths'] == '4' ? 'selected' : '' }}>4 BA</option>
                            <option value="4.5" {{ $quoteData['baths'] == '4.5' ? 'selected' : '' }}>4.5 BA</option>
                            <option value="5" {{ $quoteData['baths'] == '5' ? 'selected' : '' }}>5 BA</option>
                            <option value="5.5" {{ $quoteData['baths'] == '5.5' ? 'selected' : '' }}>5 BA</option>
                            <option value="6" {{ $quoteData['baths'] == '6' ? 'selected' : '' }}>5 BA</option>
                            <option value="6.5" {{ $quoteData['baths'] == '6.5' ? 'selected' : '' }}>5 BA</option>
                        </select>
                        <select name="no_of_sqft" id="no_of_sqft_select">
                            <option value="0 - 1000" {{ $quoteData['sq_ft'] == '0 - 1000' ? 'selected' : '' }}>0 -1000 sqft</option>
                            <option value="1000 - 1500" {{ $quoteData['sq_ft'] == '1000 - 1500' ? 'selected' : '' }}>1000 - 1500 sqft</option>
                            <option value="1500 - 2000" {{ $quoteData['sq_ft'] == '1500 - 2000' ? 'selected' : '' }}>1500 - 2000 sqft</option>
                            <option value="2000 - 2500" {{ $quoteData['sq_ft'] == '2000 - 2500' ? 'selected' : '' }}>2000 - 2500 sqft</option>
                            <option value="2500 - 3000" {{ $quoteData['sq_ft'] == '2500 - 3000' ? 'selected' : '' }}>2500 - 3000 sqft</option>
                            <option value="3000 - 3500" {{ $quoteData['sq_ft'] == '3000 - 3500' ? 'selected' : '' }}>3000 - 3500 sqft</option>
                            <option value="3500 - 4000" {{ $quoteData['sq_ft'] == '3500 - 4000' ? 'selected' : '' }}>3500 - 4000 sqft</option>
                            <option value="4000 - 4500" {{ $quoteData['sq_ft'] == '4000 - 4500' ? 'selected' : '' }}>4000 - 4500 sqft</option>
                            <option value="4500 - 5000" {{ $quoteData['sq_ft'] == '4500 - 5000' ? 'selected' : '' }}>4500 - 5000 sqft</option>
                            <option value="5000 - 5500" {{ $quoteData['sq_ft'] == '5000 - 5500' ? 'selected' : '' }}>5000 - 5500 sqft</option>
                            <option value="5500 - 6000" {{ $quoteData['sq_ft'] == '5500 - 6000' ? 'selected' : '' }}>5500 - 6000 sqft</option>
                            <option value="6000 - 6500" {{ $quoteData['sq_ft'] == '6000 - 6500' ? 'selected' : '' }}>6000 - 6500 sqft</option>
                        </select>
                        <button type='button' class='popup-form-btn'>Done</button>
                   </div>
                </div>
            </div>
        </div>
    </div>



<script>
  document.addEventListener('DOMContentLoaded', function() {
    const button = document.getElementById('toggleAddons');
    const addonsDiv = document.getElementById('addonsDiv');

    button.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        // Toggle visibility
        if (addonsDiv.style.display === 'block') {
            addonsDiv.style.display = 'none';
        } else {
            addonsDiv.style.display = 'block';
        }
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.form-group-field')) {
            addonsDiv.style.display = 'none';
        }
    });
});

</script>
<script>
    $(document).ready(function () {

        $('.popup-form-btn').on('click', function () {
            const beds = $('#no_of_beds_select').val();
            const baths = $('#no_of_baths_select').val();
            const sqft = $('#no_of_sqft_select').val();

            $('.pill-btn .no_of_beds').text(beds + ' BD');
            $('.pill-btn .no_of_bathrooms').text(baths + ' BR');
            $('.pill-btn .sq_ft').text(sqft + ' sqft');

            $('#bed_summary').text(beds);
            $('#bath_summary').text(baths);
            $('#sqft_summary').text(sqft);
            

            $('#pill-modal').modal('hide');
        });
    });

    jQuery(document).ready(function ($) {
        
        if ($('#havepets').val() === 'no_pets'){
            $('.recurring-message').show();
        }
        else {
                $('.recurring-message').hide();
            }
        // Run on change
        $('#havepets').on('change', function () {

            if ($('#havepets').val() === 'no_pets') {
            $('.recurring-message').show();
            } else {
                $('.recurring-message').hide();
            }

        });
  });

</script>

<script>
   $(document).on('click', '.timeslotstext', function() {
        $('.timeslotstext').removeClass('selected');
        $(this).addClass('selected');
        
        let card = $(this).closest('.card');
        let selectedTimeslot = $(this).text();
        let cleanerId = card.find('.cleanerId').text();

        $('.continuebtn').show();

        console.log(selectedTimeslot);
        console.log(cleanerId);

        // store data globally or in hidden inputs
        $('input[name="selectedTimeSlot"]').val(selectedTimeslot);
        $('input[name="selectedCleanerId"]').val(cleanerId);
});

    $(document).ready(function () {
        $('#dateInput').on('change', function () {
            var selectedDate = $(this).val();
            var url = $('#dateForm').attr('action');

            $.ajax({
                url: url,
                type: 'GET',
                data: { date: selectedDate },
                success: function (response) {
                    $('#cleanersContainer').html(response.html);
                    updatePrices(); 
                },
                error: function (xhr) {
                    console.error('An error occurred:', xhr.responseText);
                }
            });
        });

    function updatePrices() {
        let filters = {
            beds: $('select[name="no_of_beds"]').val(),
            baths: $('select[name="no_of_baths"]').val(),
            area: $('select[name="no_of_sqft"]').val(),
            pets: $('select[name="pets"]').val(),
            service_duration: $('select[name="service_duration"]').val(),
            service_type: $('#service_type').val(),
            addons: $('input[name="addons[]"]:checked').map(function() {
            return $(this).val();
            }).get(),
            _token: '{{ csrf_token() }}'
        };
        
        $.ajax({
            url: "{{ route('calculate.prices') }}",
            method: 'POST',
            data: filters,
            success: function(response) {

                response.forEach(function(item, index) {
                    const card = $('.card[data-cleaner-id="' + item.cleaner_id + '"]');
                    card.find('.price-value').text('$' + item.price);                
                    console.log('Cleaner:', item.cleaner_name, 'Response Index:', index);

                    let addonNames = '';
                    let addonPrices = '';

                    let frequencyName;
                    const discountMap = {
                        0: 'One Time',
                        0.10: 'Monthly (10% off)',
                        0.15: 'Biweekly (15% off)',
                        0.20: 'Weekly (20% off)'
                    };

                    if (Array.isArray(item.addons) && item.addons.length > 0) {
                        item.addons.forEach(function(addon) {
                            addonNames += addon.addon_name + '<br>';
                            // addonPrices += `$${addon.price}<br>`;
                        });

                        $('#addon_name_summary').html(addonNames);
                        $('#addon_price_summary').html(addonPrices);
                    } else {
                        $('#addon_name_summary').text('No Additional Services');
                        // $('#addon_price_summary').text('$0');
                    }

                    if (item.discount === null) {
                        card.find('.base_price').text('');
                    } else {
                        card.find('.base_price').text('$' + item.basePrice);
                    }

                    if (item.discount === null) {
                        frequencyName = 'One Time';
                    } else {
                        frequencyName = discountMap[item.discount] ?? 'One Time';
                    }
                    $('.frequency_name_summary').text(frequencyName);

                    // $('.onetime_frequency_price_summary').text('$' + item.basePrice);

                });

            },
            error: function(xhr) {
                console.error('Error fetching prices:', xhr.responseText);
            }
        });
    }

    // Trigger price update on filter change
    $('select[name="no_of_beds"], select[name="no_of_baths"], select[name="no_of_sqft"], select[name="pets"], select[name="service_duration"], select[name="service_type"], input[name="addons[]"]').on('change', updatePrices);

    // Initial price load
    updatePrices();

    // Listen for service_type change
    $('#service_type').on('change', function() {
        const selectedService = $(this).find('option:selected').text();
        $('#service_summary').text(selectedService);
    });

    // Also set initial service summary on page load
    const initialService = $('#service_type').find('option:selected').text();
    $('#service_summary').text(initialService);
        

    // $('#cleanersContainer').on('click', '.continuebtn', function() {
     $('.continuebtn').on('click', function() {

        let dateInput = $('#dateInput').val();
        let cleanerId = $('#selectedCleanerId').val();
        console.log(cleanerId);
        let selectedslot = $('#selectedTimeSlot').val();
        let beds = $('#no_of_beds_select').val();
        let baths = $('#no_of_baths_select').val();
        let area = $('#no_of_sqft_select').val();
        let service = $('select[name="service_type"]').val();
        let pets = $('#pets').val();
        let service_duration = $('#service_duration').val();


        let selectedAddons = $('input[name="addons[]"]:checked').map(function () {
            return $(this).val();
        }).get();

        let params = new URLSearchParams({
            cleaner: cleanerId,
            slot: selectedslot,
            beds: beds,
            frequency: service_duration,
            baths: baths,
            service: service,
            pets: pets,
            selecteddate: dateInput,
            area: area,
        });

         // Append each addon[] manually
        selectedAddons.forEach(id => {
            params.append('addons[]', id);
        });

        window.location.href = '/checkout/?' + params.toString();

    });
});

</script>

@endsection