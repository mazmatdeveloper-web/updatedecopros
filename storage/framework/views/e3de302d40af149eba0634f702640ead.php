<?php $__env->startSection('content'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDNECwhx76acUzGrfxknooV5O9LJFJSyKA&libraries=places"></script>
    
    <style>
        .pac-container {
            z-index: 1056 !important;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#zipcodeModal').modal('show');
        });
    </script>

<div class="modal modal-md fade" id="zipcodeModal" tabindex="-1" aria-labelledby="zipcodeModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="true">
        <div class="modal-dialog modal-dialog-centered zipcodemodal">
            <div class="modal-content">
                <div class="modal-body">             
                            <h3 class='modal-heading'>Where Will The Service Be Taking Place?</h3>
                            <p class='modal-para'>To get started, please enter your ZIP code below. This helps us check service availability in your area and provide the best options for your location. Once verified, you’ll be able to continue with the rest of the booking process.</p>                          
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

   <div class="row d-flex justify-content-center">
        <div class="col-md-4">
            <div id="initial-form" class="mt-2">
                <h2 class='mb-5'>See available house cleaners</h2>
                <form action="<?php echo e(route('quote.extended')); ?>" method='GET'>
                    <?php echo csrf_field(); ?>
                    
                    <div class="field-group mb-0">
                        <label class='field_group_label'>Address</label>
                        <input type="text" name="address" class='address_form_field form_field' id="address_field">
                    </div>
                    <div class="field-group">
                        <button type='button' class='pill-btn' data-bs-toggle="modal" data-bs-target="#pill-modal">
                            <span class='no_of_beds'>2 BD</span>
                            <span class='seperator'>/</span>
                            <span class='no_of_bathrooms'>2 BR</span>
                            <span class='seperator'>/</span>
                            <span class='sq_ft'>4000 - 4500 sqft</span>
                        </button>
                        <input type="hidden" name='beds' class='no_of_beds'>
                        <input type="hidden" name='baths' class='no_of_baths'>
                        <input type="hidden" name='sq_ft' class='sq_ft'>
                    </div>
                    <div class="field-group">
                        <label class='field_group_label'>Which service would you like?</label><br>
                        
                        <input type="radio" name="service_type" data-price='50' id='standard_cleaning' class='service_type_form_field form_field' value="Standard Cleaning" checked>
                        <label for="standard_cleaning">Standard Cleaning <br><span>Home hasn't been cleaned in a while</span></label><br>
                        
                        <input type="radio" name="service_type" data-price='40' id='deep_cleaning' class='service_type_form_field form_field' value="Deep Cleaning" >
                        <label for="deep_cleaning">Deep Cleaning <br><span>Home was cleaned in the past few weeks</span></label><br>
                        
                        <input type="radio" name="service_type" data-price='30' id='move_in_out_cleaning' class='service_type_form_field form_field' value="Move-in/Move-out Cleaning" >
                        <label for="move_in_out_cleaning">Move-in/Move-out Cleaning <br><span>Home was cleaned in the past few weeks</span></label>
                   
                    </div>
                    <div class="field-group">
                        <label class='field_group_label'>Pets in home?</label><br>
                        <select name="pets" id="pets">
                            <option value="no_pets">No</option>
                            <option value="yes_pets">Yes</option>
                        </select>
                    </div>
                    <div class="field-group">
                        <label class='field_group_label'>Frequency</label><br>
                        <select name="service_duration" id="havepets">
                            <option value="one_time">One-time Cleaning</option>
                            <option value="weekly">Weekly (20% off)</option>
                            <option value="biweekly">Biweekly (15% off)</option>
                            <option value="monthly">Monthly (10% off)</option>
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
                    
                    <!-- <div class="price-estimate-row">
                        <p class='text-end my-2'><strong id='price-calculate-estimate'>$208+</strong> Total Price</p>
                    </div> -->
                    <button type='submit' class='continue-btn w-100'>Continue</button>
                </form>
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
                            <option value="0">0 BD</option>
                            <option value="1">1 BD</option>
                            <option value="2">2 BD</option>
                            <option value="3">3 BD</option>
                            <option value="4">4 BD</option>
                            <option value="5">5 BD</option>
                            <option value="6">6 BD</option>
                        </select>
                        <select name="no_of_baths" id="no_of_baths_select">
                            <option value="1">1 BR</option>
                            <option value="1.5">1.5 BR</option>
                            <option value="2">2 BR</option>
                            <option value="2.5">2.5 BR</option>
                            <option value="3">3 BR</option>
                            <option value="3.5">3.5 BR</option>
                            <option value="4">4 BR</option>
                            <option value="4.5">4.5 BR</option>
                            <option value="5">5 BR</option>
                        </select>
                        <select name="no_of_sqft" id="no_of_sqft_select">
                            <option value="0 - 1000">0 -1000 sqft</option>
                            <option value="1000 - 1500">1000 - 1500 sqft</option>
                            <option value="1500 - 2000">1500 - 2000 sqft</option>
                            <option value="2000 - 2500">2000 - 2500 sqft</option>
                            <option value="2500 - 3000">2500 - 3000 sqft</option>
                            <option value="3000 - 3500">3000 - 3500 sqft</option>
                            <option value="3500 - 4000">3500 - 4000 sqft</option>
                            <option value="4000 - 4500">4000 - 4500 sqft</option>
                            <option value="4500 - 5000">4500 - 5000 sqft</option>
                            <option value="5000 - 5500">5000 - 5500 sqft</option>
                            <option value="5500 - 6000">5500 - 6000 sqft</option>
                            <option value="6000 - 6500">6000 - 6500 sqft</option>
                        </select>
                        <button type='button' class='popup-form-btn'>Done</button>
                   </div>
                </div>
            </div>
        </div>
    </div>


<script>
    $(document).ready(function() {
    $('#address_field').on('focus click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $('#zipcodeModal').modal('show');
        $(this).blur(); // remove focus to prevent cursor appearing
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
            $('input.no_of_beds').val(beds);
            $('input.no_of_baths').val(baths);
            $('input.sq_ft').val(sqft);
            $('#pill-modal').modal('hide');
        });

    });

    jQuery(document).ready(function ($) {
       
        $('.recurring-message').show();

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
            url: "<?php echo e(route('check.zipcode')); ?>",
            type: "POST",
            data: {
                _token: "<?php echo e(csrf_token()); ?>",
                zipcode: zip
            },
            success: function(response) {
                if (response.exists) {
                    $('#error').hide();
                    $('#successmessage').text("Zipcode Matched Successfully!").show();
                    $('#next-step').show();
                    $('#address_field').val(address);
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/2025 Projects/updatedecopros/resources/views/frontend/quote.blade.php ENDPATH**/ ?>