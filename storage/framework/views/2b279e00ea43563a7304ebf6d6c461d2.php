<?php $__env->startSection('admin_content'); ?>
<style>
    .form-check {
    border: 2px solid #d8d8d8;
    border-radius: 5px;
    padding: 3px 10px;
    box-shadow: 0px 0px 10px #d3d3d34f;
}

.form-check-input:checked::before   {
    background: #026536;


}


</style>
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Add Cleaner's Availability</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Cleaners
                </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Add Cleaner Availability</li>
            </ul>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <form method="POST" action="<?php echo e(route('availability.store')); ?>">
                <?php echo csrf_field(); ?>

                <!-- Cleaner Selection -->
                <div class="mb-3">
                    <label>Select Cleaner:</label><br>
                   <div class="form-group d-flex gap-3 align-items-center" required>
                    
                    <?php $__currentLoopData = $cleaners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cleaner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-check d-flex align-items-center">
                            <input class="form-check-input" type="radio" name="cleaner_id" id="cleaner_<?php echo e($cleaner->id); ?>" value="<?php echo e($cleaner->id); ?>" required>
                            <label class="form-check-label" for="cleaner_<?php echo e($cleaner->id); ?>">
                                <?php echo e($cleaner->name); ?>

                            </label>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                </div>
                <div>
                    <button class="btn btn-primary" type="button" id="recurring">Recurring Availability<button>
                    <button class="btn btn-danger mx-3" type="button" id="specific">Specific Date<button>
                </div>
                <!-- Recurring Availability -->
                <div class="mb-3" id="recurring_availiblity" style="display:none;">
                    <label class="form-label">Select Weekdays</label>
                    <div id="recurring-container">
                        <div class="d-flex gap-2 mb-2 recurring-row">
                            <select name="recurring[0][day]" class="form-control">
                                <option value="">Select Day</option>
                                <?php $__currentLoopData = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($day); ?>"><?php echo e(ucfirst($day)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <input type="time" name="recurring[0][start_time]" class="form-control" />
                            <input type="time" name="recurring[0][end_time]" class="form-control" />
                            <select name="recurring[0][interval]" class="form-control">
                                <option value="30">30 minutes</option>
                                <option value="60">1 hour</option>
                                <option value="90">1.5 hours</option>
                                <option value="120" selected>2 hours</option>
                                <option value="150" selected>2.5 hours</option>
                                <option value="180" selected>3 hours</option>
                                <option value="210" selected>3.5 hours</option>
                                <option value="240" selected>4 hours</option>
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" onclick="addRecurringSlot()">+ Add Recurring Slot</button>
                </div>

                <!-- Specific Date Availability -->
                <div class="mb-3" id="specific_date" style="display:none;">
                    <label class="form-label">Add Dates Manually</label>
                    <div id="specific-container">
                        <div class="specific-group border rounded p-3 mb-3">
                            <div class="mb-2">
                                <label>Date</label>
                                <input type="date" name="specific[0][date]" class="form-control" />
                            </div>
                            <div class="specific-timeslots">
                                <div class="d-flex gap-2 mb-2">
                                    <input type="time" name="specific[0][time_slots][0][start_time]" class="form-control" />
                                    <input type="time" name="specific[0][time_slots][0][end_time]" class="form-control" />
                                    <select name="specific[0][time_slots][0][interval]" class="form-control">
                                        <option value="30">30 minutes</option>
                                        <option value="60">1 hour</option>
                                        <option value="90">1.5 hours</option>
                                        <option value="120" selected>2 hours</option>
                                        <option value="150" selected>2.5 hours</option>
                                        <option value="180" selected>3 hours</option>
                                        <option value="210" selected>3.5 hours</option>
                                        <option value="240" selected>4 hours</option>
                                    </select>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addSpecificTimeSlot(this)">+ Add Time Slot</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" onclick="addSpecificGroup()">+ Add Another Date</button>
                </div>

                <button type="submit" class="btn btn-primary mt-2" id="submit_button" style="display:none">Submit</button>
            </form>

        </div>
    </div>
</div>


<script>
    let recurringIndex = 1;
    let specificIndex = 1;

    function addRecurringSlot() {
        const container = document.getElementById('recurring-container');
        const div = document.createElement('div');
        div.classList.add('d-flex', 'gap-2', 'mb-2', 'recurring-row');
        div.innerHTML = `
            <select name="recurring[${recurringIndex}][day]" class="form-control">
                <option value="">Select Day</option>
                <?php $__currentLoopData = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($day); ?>"><?php echo e(ucfirst($day)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <input type="time" name="recurring[${recurringIndex}][start_time]" class="form-control" />
            <input type="time" name="recurring[${recurringIndex}][end_time]" class="form-control" />
            <select name="recurring[${recurringIndex}][interval]" class="form-control">
                <option value="30">30 minutes</option>
                <option value="60">1 hour</option>
                <option value="90">1.5 hours</option>
                <option value="120" selected>2 hours</option>
            </select>
        `;
        container.appendChild(div);
        recurringIndex++;
    }

    function addSpecificGroup() {
        const container = document.getElementById('specific-container');
        const group = document.createElement('div');
        group.classList.add('specific-group', 'border', 'rounded', 'p-3', 'mb-3');
        group.innerHTML = `
            <div class="mb-2">
                <label>Date</label>
                <input type="date" name="specific[${specificIndex}][date]" class="form-control" />
            </div>
            <div class="specific-timeslots">
                <div class="d-flex gap-2 mb-2">
                    <input type="time" name="specific[${specificIndex}][time_slots][0][start_time]" class="form-control" />
                    <input type="time" name="specific[${specificIndex}][time_slots][0][end_time]" class="form-control" />
                    <select name="specific[${specificIndex}][time_slots][0][interval]" class="form-control">
                        <option value="30">30 minutes</option>
                        <option value="60">1 hour</option>
                        <option value="90">1.5 hours</option>
                        <option value="120" selected>2 hours</option>
                    </select>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addSpecificTimeSlot(this)">+ Add Time Slot</button>
        `;
        container.appendChild(group);
        specificIndex++;
    }

    function addSpecificTimeSlot(button) {
        const group = button.closest('.specific-group');
        const slotsContainer = group.querySelector('.specific-timeslots');
        const dateIndex = Array.from(document.querySelectorAll('.specific-group')).indexOf(group);
        const slotIndex = slotsContainer.children.length;

        const slotDiv = document.createElement('div');
        slotDiv.classList.add('d-flex', 'gap-2', 'mb-2');
        slotDiv.innerHTML = `
            <input type="time" name="specific[${dateIndex}][time_slots][${slotIndex}][start_time]" class="form-control" />
            <input type="time" name="specific[${dateIndex}][time_slots][${slotIndex}][end_time]" class="form-control" />
            <select name="specific[${dateIndex}][time_slots][${slotIndex}][interval]" class="form-control">
                <option value="30">30 minutes</option>
                <option value="60">1 hour</option>
                <option value="90">1.5 hours</option>
                <option value="120" selected>2 hours</option>
            </select>
        `;
        slotsContainer.appendChild(slotDiv);
    }
</script>

<script>
jQuery(document).ready(function(){
    $('#recurring').click(function(){
        $('#recurring_availiblity').slideDown();
        $('#submit_button').slideDown();
         
    });
    $('#specific').click(function(){
        $('#specific_date').slideDown();
        $('#submit_button').slideDown();
    });
});
</script>
<script>
    document.querySelectorAll('input[name="cleaner_id"]').forEach((input) => {
        input.addEventListener('change', function () {
            document.querySelectorAll('.form-check').forEach(el => el.classList.remove('selected-cleaner'));
            this.closest('.form-check').classList.add('selected-cleaner');
        });
    });
</script>

<style>
.selected-cleaner {
    background: #40d10978;
    border-radius: 5px;
}
</style>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\echopros1\echopros\updatedecopros\resources\views/admin/cleaners/add-availability.blade.php ENDPATH**/ ?>