<?php $__env->startSection('content'); ?>
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
        padding: 15px;
        text-align: center;
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

   <div class="row d-flex justify-content-center">
        <div class="col-md-4">
            <div id="initial-form" class="mt-2">
                <h2 class='mb-5'>Select Services</h2>
                <form action="<?php echo e(route('updated.booking.extended')); ?>" method='POST'>
                    <?php echo csrf_field(); ?>
                    
                    <div class="field-group mb-0">
                        <label class='field_group_label'>Address</label>
                        <input type="text" name="address" class='address_form_field form-control mb-2 form_field' id="address_field" placeholder='30329 Atlanta, GA USA'>
                             <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="row">
                        <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-3 mb-3">
                                <label>
                                    <input type="checkbox" class="service-checkbox" name="service_type[]" value="<?php echo e($service->id); ?>">
                                    <div class="service-card h-100">
                                        <h6 class="mb-1"><?php echo e($service->service_name); ?></h6>
                                        <small>$<?php echo e(number_format($service->price, 2)); ?></small>
                                    </div>
                                </label>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php $__errorArgs = ['service_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                   
                    <button type='submit' class='continue-btn w-100'>Continue</button>
                </form>
            </div>
        </div>
   </div>

 
       
<script>
    $(document).ready(function() {
    $('#address_field').on('focus click', function(e) {
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/2025 Projects/A1ClassicGarage/resources/views/updated-frontend/booking.blade.php ENDPATH**/ ?>