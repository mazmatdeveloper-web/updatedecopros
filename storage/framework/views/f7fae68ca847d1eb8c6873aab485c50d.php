<?php $__env->startSection('admin_content'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDNECwhx76acUzGrfxknooV5O9LJFJSyKA&libraries=places"></script>
    

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('update.availability', $appointment->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <input type="hidden" name="appointment_id" value="<?php echo e($appointment->id ?? ''); ?>">
                            <!-- Service Name -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Select Services</label>
                                <div class="form-check">
                                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            name="service_ids[]" 
                                            value="<?php echo e($service->id); ?>" 
                                            id="service_<?php echo e($service->id); ?>"
                                            <?php echo e(in_array($service->id, $selectedServiceIds) ? 'checked' : ''); ?>

                                        >
                                        <label class="form-check-label" for="service_<?php echo e($service->id); ?>">
                                            <?php echo e($service->service_name); ?>

                                        </label>
                                        <br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="status" class="form-label fw-semibold">Appointment Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <?php $__currentLoopData = ['pending', 'confirmed', 'completed', 'cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($status); ?>" <?php echo e((old('status', $appointment->status) === $status) ? 'selected' : ''); ?>>
                                                <?php echo e(ucfirst($status)); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <!-- employee -->
                                <div class="mb-3">
                                    <label for="employee" class="form-label fw-semibold">Assigned employee</label>
                                    <select class="form-select" id="employee" name="employee">
                                        <option value="">Select employee</option>
                                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($employee->id); ?>"
                                                <?php echo e($appointment->employee_id == $employee->id ? 'selected' : ''); ?>>
                                                <?php echo e($employee->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <input type="hidden" id="employee_id" name="employee_id" value="<?php echo e($appointment->employee_id); ?>">
                                </div>

                                <div class="row">
                                    <!-- Date -->
                                <div class="mb-3 col-md-6">
                                    <label for="appointment_date" class="form-label fw-semibold">Appointment Date <span class='badge bg-success'><?php echo e($appointment->appointment_date); ?></span></label>
                                    <input type="date" class="form-control" id="appointment_date" name="appointment_date"
                                        value="<?php echo e(old('appointment_date', $appointment->appointment_date ?? '')); ?>">
                                </div>

                                <!-- Time Slot -->
                                <div class="mb-3 col-md-6">
                                    <label for="start_time" class="form-label fw-semibold">Time Slot <span class='badge bg-success'><?php echo e($appointment->start_time); ?> - <?php echo e($appointment->end_time); ?></span></label>
                                    <select class="form-select" id="start_time" name="start_time">
                                        <option value="">Select a time</option>
                                        <option value="<?php echo e(\Carbon\Carbon::parse($appointment->start_time)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($appointment->end_time)->format('H:i')); ?>" selected><?php echo e(\Carbon\Carbon::parse($appointment->start_time)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($appointment->end_time)->format('H:i')); ?></option>
                                        <!-- Time slots will be populated via JS -->
                                    </select>
                                </div>
                                </div>

                                <!-- Address -->
                                <div class="mb-3">
                                    <label for="start_time" class="form-label fw-semibold">Address</label>
                                    <input type="text" name='address' id="autocomplete" class="zipcode-field form-control"
                                    value='<?php echo e($appointment->address); ?>'>
                                    <input type="hidden" id="old_address" value="<?php echo e($appointment->address ?? ''); ?>">
                                    <div id="address-error" class="text-danger mt-1" style="display:none;"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label fw-semibold">Additional Notes</label>
                                   <textarea name="notes" id="notes" class='form-control' cols="30" rows="3"><?php echo e($appointment->additional_notes); ?></textarea>
                                </div>

                                <!-- Price -->
                                <div class="mb-3">
                                    <label for="price" class="form-label fw-semibold">Total Price ($)</label>
                                    <input type="number" step="0.01" class="form-control" id="price" name="price"
                                        value="<?php echo e(old('price', $appointment->total_price ?? '')); ?>">
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
        const employeeSelect = document.getElementById('employee');
        const dateInput = document.getElementById('appointment_date');
        const slotSelect = document.getElementById('start_time');

        async function fetchSlots() {
            const employeeId = employeeSelect.value;
            const date = dateInput.value;

            if (!employeeId || !date) {
                slotSelect.innerHTML = '<option value="">Select a time</option>';
                return;
            }

            try {
                const response = await fetch(`/admin/employee-slots?employee_id=${employeeId}&date=${date}`);
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

        employeeSelect.addEventListener('change', fetchSlots);
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
            url: "<?php echo e(route('check.zipcode')); ?>",
            type: "POST",
            data: {
                _token: "<?php echo e(csrf_token()); ?>",
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/2025 Projects/A1ClassicGarage/resources/views/admin/appointments/edit.blade.php ENDPATH**/ ?>