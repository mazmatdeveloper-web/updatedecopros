<?php $__env->startSection('content'); ?>
<div class="error-div" style='display:none;'>
    <p class='mb-0' id='serviceErrorMessage'></p>
</div>
<div class="main-content">
    <div class="container-fluid">
   
    <div class="row d-flex justify-content-center">
        
            <div class="col-md-9 pt-4 pb-5">


    <form action="" class='filters-form'>
        <?php echo csrf_field(); ?>
        <div class="form-group-field">
            <input type="hidden" name="address" value="<?php echo e($quoteData['address']); ?>" class='address_form_field form_field' id="address_field">
            <label class='field_group_label'>Dimensions</label><br>
            
            <button type='button' class='pill-btn w-100' data-bs-toggle="modal" data-bs-target="#pill-modal">
                <span class='no_of_beds'><?php echo e($quoteData['beds']); ?> BD</span>
                <span class='seperator'>/</span>
                <span class='no_of_bathrooms'><?php echo e($quoteData['baths']); ?> BR</span>
                <span class='seperator'>/</span>
                <span class='sq_ft'><?php echo e($quoteData['sq_ft']); ?> sqft</span>
            </button>
        </div>

        <div class="form-group-field">
            <label class='field_group_label'>Frequency</label><br>
            <select name="service_duration" id="service_duration">
                <option value="one_time" <?php echo e($quoteData['service_duration'] === 'one_time' ? 'selected' : ''); ?>>One-time Cleaning</option>
                <option value="weekly" <?php echo e($quoteData['service_duration'] === 'weekly' ? 'selected' : ''); ?>>Weekly (20% off)</option>
                <option value="biweekly" <?php echo e($quoteData['service_duration'] === 'biweekly' ? 'selected' : ''); ?>>Biweekly (15% off)</option>
                <option value="monthly"<?php echo e($quoteData['service_duration'] === 'monthly' ? 'selected' : ''); ?> >Monthly (10% off)</option>
            </select>
        </div>

        <div class="form-group-field">

            <label class='field_group_label'>Which service would you like?</label><br>
            <select name="service_type" id="service_type">
                <option id='standard_cleaning' value="Standard Cleaning" <?php echo e($quoteData['service_type'] === 'Standard Cleaning' ? 'selected' : ''); ?>>Standard Cleaning</option>
                <option id='deep_cleaning' <?php echo e($quoteData['service_type'] === 'Deep Cleaning' ? 'selected' : ''); ?> value="Deep Cleaning">Deep Cleaning</option>
                <option id='move_in_out_cleaning' value="Move-in/Move-out Cleaning" <?php echo e($quoteData['service_type'] === 'Move-in/Move-out Cleaning' ? 'selected' : ''); ?> value="Move-in/Move-out Cleaning">Move-in/Move-out Cleaning</option>
            </select>
        </div>

        <div class="form-group-field">
            <label class='field_group_label'>Select Additional Services</label><br>
            <button type="button" id="toggleAddons" class='w-100'>Available Services</button>
            <div class="addons-div" id="addonsDiv">
                <?php $__currentLoopData = $addons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="more-options">
                        <input type="checkbox" id="addon_<?php echo e($addon->id); ?>" name="addons[]" value="<?php echo e($addon->id); ?>">
                        <label for="addon_<?php echo e($addon->id); ?>"><?php echo e($addon->addon_name); ?></label><br>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="form-group-field">
            <label class='field_group_label'>Do you have pets?</label><br>
            <select name="pets" id="pets">
                <option value="no_pets" <?php echo e($quoteData['pets'] === 'no_pets' ? 'selected' : ''); ?>>No Pets</option>
                <option value="yes_pets" <?php echo e($quoteData['pets'] === 'yes_pets' ? 'selected' : ''); ?>>Yes, I have pets!</option>
            </select>
        </div>

</form>
 


                        
               <div class="date-div">
              

                <?php
                    use Carbon\Carbon;
                    $today = Carbon::today();
                    $startOfWeek = $today->copy()->startOfWeek(Carbon::SUNDAY);
                ?>

                <div class="d-flex align-items-center my-3">
                    <button id="prevDay" class="btn btn-light me-2">&larr;</button>

                    <div id="weekDates" class="d-flex gap-2 flex-grow-1 overflow-auto">
                        <!-- Week buttons will be rendered by JS -->
                    </div>

                    <button id="nextDay" class="btn btn-light ms-2">&rarr;</button>
                </div>

                <h3 class="mx-3" id="selectedDateDisplay"><?php echo e($today->format('F j')); ?></h3>

                <input type="hidden" id="weekStartDate" value="<?php echo e($startOfWeek->toDateString()); ?>">
                <input type="hidden" id="selectedDateInput" value="<?php echo e($today->toDateString()); ?>">

               </div>
    
            <div id="cleanersContainer">
               <div class="row d-flex justify-content-center align-items-stretch">
                
                <?php $__currentLoopData = $cleaners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cleaner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <div class="col-md-5">
                <div class="card mb-2 border-0 h-100" data-cleaner-id="<?php echo e($cleaner->id); ?>">
                            <div class="card-body mb-2">
                            <div class="cleaner-profile-box d-flex align-items-center justify-content-between">
                                <div class="cleaner-name d-flex align-items-center gap-2">
                                    <?php if($cleaner->profile_picture): ?>
                                        <img src="<?php echo e(asset('storage/' . $cleaner->profile_picture)); ?>" alt="Profile Picture" width="150">
                                    <?php endif; ?>
                                    <p class='cleanerId' style='display:none;'><?php echo e($cleaner->id); ?></p>
                                    <div>
                                        <h4 class='cleanernames mb-0'><?php echo e($cleaner->name); ?> </h4>
                                    <?php if(!empty($cleaner->available_slots)): ?>    
                                        <span class='avialable-badge'>Available</span>
                                    <?php endif; ?>
                                    </div>
                                </div>
                            <div>
                                <span class='base_price'></span>
                                <span class="price-value"></span>
                            </div>
                            </div>    
                                <?php if(!empty($cleaner->available_slots)): ?>
                                    <?php $__currentLoopData = $cleaner->available_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class='timeslotstext' 
                                        data-slot="<?php echo e($slot); ?>" 
                                        data-cleaner-id="<?php echo e($cleaner->id); ?>">
                                        <?php echo e($slot); ?>

                                    </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <p class='notavailabletext'>Not available</p>
                                <?php endif; ?>
                            </div>
                        </div>
                </div>
                      
                
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                </div>
            </div>
        

        <div class="col-md-3 cart-col" style='height:100vh;'>
                <h2 class='cart-col-title mb-4'>Summary</h2>

                <h3 class='summary-labels'>Address</h3>
            
                <div class="additional-services-div mb-4">
                    <table class='additional-services-table w-100'>
                    <tr>
                        <td class='text-start'><?php echo e($quoteData['address']); ?></td>
                    </tr> 
                    </table>    
                </div>

                
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
                            <option value="0" <?php echo e($quoteData['beds'] == '0' ? 'selected' : ''); ?>>0 BD</option>
                            <option value="1" <?php echo e($quoteData['beds'] == '1' ? 'selected' : ''); ?>>1 BD</option>
                            <option value="2" <?php echo e($quoteData['beds'] == '2' ? 'selected' : ''); ?>>2 BD</option>
                            <option value="3" <?php echo e($quoteData['beds'] == '3' ? 'selected' : ''); ?>>3 BD</option>
                            <option value="4" <?php echo e($quoteData['beds'] == '4' ? 'selected' : ''); ?>>4 BD</option>
                            <option value="5" <?php echo e($quoteData['beds'] == '5' ? 'selected' : ''); ?>>5 BD</option>
                            <option value="6" <?php echo e($quoteData['beds'] == '6' ? 'selected' : ''); ?>>6 BD</option>
                        </select>
                        <select name="no_of_baths" id="no_of_baths_select">
                            <option value="1" <?php echo e($quoteData['baths'] == '1' ? 'selected' : ''); ?>>1 BA</option>
                            <option value="1.5" <?php echo e($quoteData['baths'] == '1.5' ? 'selected' : ''); ?>>1.5 BA</option>
                            <option value="2" <?php echo e($quoteData['baths'] == '2' ? 'selected' : ''); ?>>2 BA</option>
                            <option value="2.5" <?php echo e($quoteData['baths'] == '2.5' ? 'selected' : ''); ?>>2.5 BA</option>
                            <option value="3" <?php echo e($quoteData['baths'] == '3' ? 'selected' : ''); ?>>3 BA</option>
                            <option value="3.5" <?php echo e($quoteData['baths'] == '3.5' ? 'selected' : ''); ?>>3.5 BA</option>
                            <option value="4" <?php echo e($quoteData['baths'] == '4' ? 'selected' : ''); ?>>4 BA</option>
                            <option value="4.5" <?php echo e($quoteData['baths'] == '4.5' ? 'selected' : ''); ?>>4.5 BA</option>
                            <option value="5" <?php echo e($quoteData['baths'] == '5' ? 'selected' : ''); ?>>5 BA</option>
                            <option value="5.5" <?php echo e($quoteData['baths'] == '5.5' ? 'selected' : ''); ?>>5.5 BA</option>
                            <option value="6" <?php echo e($quoteData['baths'] == '6' ? 'selected' : ''); ?>>6 BA</option>
                            <option value="6.5" <?php echo e($quoteData['baths'] == '6.5' ? 'selected' : ''); ?>>6.5 BA</option>
                        </select>
                        <select name="no_of_sqft" id="no_of_sqft_select">
                            <option value="0 - 1000" <?php echo e($quoteData['sq_ft'] == '0 - 1000' ? 'selected' : ''); ?>>0 -1000 sqft</option>
                            <option value="1000 - 1500" <?php echo e($quoteData['sq_ft'] == '1000 - 1500' ? 'selected' : ''); ?>>1000 - 1500 sqft</option>
                            <option value="1500 - 2000" <?php echo e($quoteData['sq_ft'] == '1500 - 2000' ? 'selected' : ''); ?>>1500 - 2000 sqft</option>
                            <option value="2000 - 2500" <?php echo e($quoteData['sq_ft'] == '2000 - 2500' ? 'selected' : ''); ?>>2000 - 2500 sqft</option>
                            <option value="2500 - 3000" <?php echo e($quoteData['sq_ft'] == '2500 - 3000' ? 'selected' : ''); ?>>2500 - 3000 sqft</option>
                            <option value="3000 - 3500" <?php echo e($quoteData['sq_ft'] == '3000 - 3500' ? 'selected' : ''); ?>>3000 - 3500 sqft</option>
                            <option value="3500 - 4000" <?php echo e($quoteData['sq_ft'] == '3500 - 4000' ? 'selected' : ''); ?>>3500 - 4000 sqft</option>
                            <option value="4000 - 4500" <?php echo e($quoteData['sq_ft'] == '4000 - 4500' ? 'selected' : ''); ?>>4000 - 4500 sqft</option>
                            <option value="4500 - 5000" <?php echo e($quoteData['sq_ft'] == '4500 - 5000' ? 'selected' : ''); ?>>4500 - 5000 sqft</option>
                            <option value="5000 - 5500" <?php echo e($quoteData['sq_ft'] == '5000 - 5500' ? 'selected' : ''); ?>>5000 - 5500 sqft</option>
                            <option value="5500 - 6000" <?php echo e($quoteData['sq_ft'] == '5500 - 6000' ? 'selected' : ''); ?>>5500 - 6000 sqft</option>
                            <option value="6000 - 6500" <?php echo e($quoteData['sq_ft'] == '6000 - 6500' ? 'selected' : ''); ?>>6000 - 6500 sqft</option>
                        </select>
                        <button type='button' class='popup-form-btn'>Done</button>
                   </div>
                </div>
            </div>
        </div>
    </div>


    <script>

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
            _token: '<?php echo e(csrf_token()); ?>'
        };
        
        $.ajax({
            url: "<?php echo e(route('calculate.prices')); ?>",
            method: 'POST',
            data: filters,
            success: function(response) {

                response.forEach(function(item, index) {
                    const card = $('.card[data-cleaner-id="' + item.cleaner_id + '"]');
                    card.find('.price-value').text('$' + item.price);                
    
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

    function generateWeekButtons(startDateStr) {
        const startDate = new Date(startDateStr);
        const todayStr = new Date().toISOString().split('T')[0];
        const selectedDate = $('#selectedDateInput').val();
        let weekHtml = '';

        for (let i = 0; i < 7; i++) {
            const date = new Date(startDate);
            date.setDate(date.getDate() + i);
            const dateStr = date.toISOString().split('T')[0];

            const isSelected = dateStr === selectedDate;
            const isToday = dateStr === todayStr;
            const isPast = dateStr < todayStr;

            weekHtml += `
                <button type="button"
                        class="date-button ${isSelected ? 'btn-selected' : 'btn-not-selected'} ${isToday ? 'today-button' : ''} ${isPast ? 'disabled' : ''}"
                        data-date="${dateStr}"
                        ${isPast ? 'disabled' : ''}>
                    ${date.toLocaleDateString('en-US', { weekday: 'short' })}<br>
                    ${date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' })}
                </button>`;
        }

        $('#weekDates').html(weekHtml);
    }

    function updateSelectedDateDisplay(dateStr) {
        const displayDate = new Date(dateStr);
        const formatted = displayDate.toLocaleDateString('en-US', { month: 'long', day: 'numeric' });
        $('#selectedDateDisplay').text(formatted);
    }

    function updateDateByOffset(offset) {
        const current = new Date($('#selectedDateInput').val());
        current.setDate(current.getDate() + offset);

        const newDateStr = current.toISOString().split('T')[0];
        const todayStr = new Date().toISOString().split('T')[0];

        if (newDateStr < todayStr) return; // prevent past selection

        $('#selectedDateInput').val(newDateStr);
        updateSelectedDateDisplay(newDateStr);

        const currentWeekStart = new Date($('#weekStartDate').val());
        const currentWeekEnd = new Date(currentWeekStart);
        currentWeekEnd.setDate(currentWeekStart.getDate() + 6);

        if (current < currentWeekStart || current > currentWeekEnd) {
            const newWeekStart = new Date(current);
            newWeekStart.setDate(newWeekStart.getDate() - newWeekStart.getDay()); // Sunday
            const newStartStr = newWeekStart.toISOString().split('T')[0];
            $('#weekStartDate').val(newStartStr);
            generateWeekButtons(newStartStr);
        } else {
            generateWeekButtons($('#weekStartDate').val());
        }

        fetchData(newDateStr);
    }

    function fetchData(date) {
        $.ajax({
            url: $('#dateForm')?.attr('action') ?? '',
            type: 'GET',
            data: { date },
            success: function (response) {
                $('#cleanersContainer').html(response.html);
                updatePrices();
            },
            error: function (xhr) {
                console.error('Error:', xhr.responseText);
            }
        });
    }

    $(document).ready(function () {
        const today = new Date();
        const weekStart = new Date(today);
        weekStart.setDate(today.getDate() - today.getDay()); // Set to Sunday
        const weekStartStr = weekStart.toISOString().split('T')[0];

        $('#weekStartDate').val(weekStartStr);
        $('#selectedDateInput').val(today.toISOString().split('T')[0]);

        generateWeekButtons(weekStartStr);
        updateSelectedDateDisplay($('#selectedDateInput').val());
        fetchData($('#selectedDateInput').val());

        $(document).on('click', '.date-button', function () {
            const selectedDate = $(this).data('date');
            if (new Date(selectedDate) < new Date().setHours(0, 0, 0, 0)) return;

            $('#selectedDateInput').val(selectedDate);
            updateSelectedDateDisplay(selectedDate);
            generateWeekButtons($('#weekStartDate').val());
            fetchData(selectedDate);
        });

        $('#prevDay').on('click', () => updateDateByOffset(-1));
        $('#nextDay').on('click', () => updateDateByOffset(1));
    });
</script>


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
        let selectedService = $('#service_type').val();
        let beds = $('#no_of_beds_select').val();
        let baths = $('#no_of_baths_select').val();
        let area = $('#no_of_sqft_select').val();

        $.ajax({
        url: "<?php echo e(route('check.cleaner.service')); ?>",
        method: "POST",
        data: {
            _token: '<?php echo e(csrf_token()); ?>',
            cleaner_id: cleanerId,
            service_type: selectedService,
            beds: beds,
            baths: baths,
            area: area
        },
        success: function(response) {
            if (response.exists) {
                $('.continuebtn').show();
            } else {
                let msg = "This cleaner doesn't meet your requirements.";
                if (response.reason === 'service') msg = "Cleaner doesn't offer " + selectedService;
                if (response.reason === 'beds') msg = "Cleaner doesn't support the selected number of Beds at "+  area + ".";
                if (response.reason === 'baths') msg = "Cleaner doesn't support the selected number of Baths at "+  area + ".";

                $('#serviceErrorMessage').text(msg);
                $('.error-div').show();
                $('.continuebtn').hide();
                setTimeout(() => $('.error-div').fadeOut(), 2000);
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
        }
        });

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

        let dateInput = $('#selectedDateInput').val();
        let cleanerId = $('#selectedCleanerId').val();
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/2025 Projects/updatedecopros/resources/views/frontend/quote-extended.blade.php ENDPATH**/ ?>