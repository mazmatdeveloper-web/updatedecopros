<?php $__env->startSection('customer_content'); ?>


<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('update.customer.appoinmtent', $appointments->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <input type="hidden" name="appointment_id" value="<?php echo e($appointments->id ?? ''); ?>">
                            <!-- Service Name -->
                                <div class="mb-3">
                                    <label for="service_name" class="form-label fw-semibold">Service Name</label>
                                    <input type="text" class="form-control" id="service_name" name="service_name"
                                        value="<?php echo e(old('service_name', $appointments->service->service_name ?? '')); ?>" readonly>
                                        <input type="hidden" name='cleaner' id='cleaner_id' value='<?php echo e($appointments->cleaner_id); ?>'>
                                        <input type="hidden" name="appointment_id" value="<?php echo e($appointments->id ?? ''); ?>">
                                </div>

                                <!-- Date -->
                                <div class="mb-3">
                                    <label for="appointment_date" class="form-label fw-semibold">Appointment Date <span class='badge bg-success'><?php echo e($appointments->appointment_date); ?></span></label>
                                    <input type="date" class="form-control" id="appointment_date" name="appointment_date"
                                        value="<?php echo e(old('appointment_date', $appointments->appointment_date ?? '')); ?>">
                                </div>

                                <!-- Time Slot -->
                                <div class="mb-3">
                                    <label for="start_time" class="form-label fw-semibold">Time Slot <span class='badge bg-success'><?php echo e($appointments->start_time); ?> - <?php echo e($appointments->end_time); ?></span></label>
                                    <select class="form-select" id="start_time" name="start_time">
                                        <option value="">Select a time</option>
                                        <option value="<?php echo e(\Carbon\Carbon::parse($appointments->start_time)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($appointments->end_time)->format('H:i')); ?>" selected><?php echo e(\Carbon\Carbon::parse($appointments->start_time)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($appointments->end_time)->format('H:i')); ?></option>
                                        <!-- Time slots will be populated via JS -->
                                    </select>
                                </div>

                                <!-- Price -->
                                <div class="mb-3">
                                    <label for="price" class="form-label fw-semibold">Total Price ($)</label>
                                    <input type="number" step="0.01" class="form-control" id="price" name="price"
                                        value="<?php echo e(old('price', $appointments->total_price ?? '')); ?>">
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
        const dateInput = document.getElementById('appointment_date');
        const cleaner_id = document.getElementById('cleaner_id');
        const slotSelect = document.getElementById('start_time');

        async function fetchSlots() {
            const cleanerId = cleaner_id.value;
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
        dateInput.addEventListener('change', fetchSlots);
    });
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('customer.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/2025 Projects/updatedecopros/resources/views/customer/appointments/edit.blade.php ENDPATH**/ ?>