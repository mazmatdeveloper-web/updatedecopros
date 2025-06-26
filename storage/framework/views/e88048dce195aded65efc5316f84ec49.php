<?php $__env->startSection('admin_content'); ?>
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center gap-3 mb-24 justify-content-between">
        <div>
    <?php if($cleaner->profile_picture): ?>
        <img src="<?php echo e(asset('storage/' . $cleaner->profile_picture)); ?>" alt="Profile Picture" class='cleaner-profile-picture'>
    <?php endif; ?>    
    <h6 class="fw-semibold mb-0"><?php echo e($cleaner->name); ?></h6>
    </div>
    <?php if($errors->any()): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Something went wrong...',
            html: `<?php echo implode('<br>', $errors->all()); ?>`,
            position: 'top-end',
            toast: true,
            timer: 500000,
            showCloseButton: true,
            showConfirmButton: false,
            timerProgressBar: true,
        });
    </script>
    <?php endif; ?>
    <div>
        <button  
            data-bs-toggle="modal" 
            data-bs-target="#cleaneraddModal"
            data-id="<?php echo e($cleaner->id); ?>" 
            data-name="<?php echo e($cleaner->name); ?>" 
            data-email="<?php echo e($cleaner->email); ?>"
            data-phone="<?php echo e($cleaner->phone); ?>"
            data-bio="<?php echo e($cleaner->bio); ?>"
            data-price="<?php echo e($cleaner->price); ?>"
            class="btn btn-primary">Update Profile
        </button>
    </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- Buttons to open modal -->

             <!-- Tabs -->
                    <ul class="nav nav-tabs mt-4" id="cleanerTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="bed-area-tab" data-bs-toggle="tab" data-bs-target="#bedarea" type="button"
                                role="tab" aria-controls="bed-area" aria-selected="false">Bedrooms Area Sqft</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="bath-area-tab" data-bs-toggle="tab" data-bs-target="#batharea" type="button"
                                role="tab" aria-controls="bath-area" aria-selected="false">Bathroom</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="service-tab" data-bs-toggle="tab" data-bs-target="#service" type="button"
                                role="tab" aria-controls="service" aria-selected="false">Services</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="availability-tab" data-bs-toggle="tab" data-bs-target="#availability" type="button"
                                role="tab" aria-controls="availability" aria-selected="false">Availability</button>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content mt-4" id="cleanerTabContent">
                        <!-- Bedroom Area Sqft Tab -->
                        <div class="tab-pane fade active show" id="bedarea" role="tabpanel" aria-labelledby="bed-area-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class='my-20'>Area Sqft with Bedroom Options</h6>
                                </div>
                                <div class="col-md-6 text-end">
                                    <button class="btn btn-primary open-modal" data-type="bedroom">Add Bedrooms Sqft Option</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Sqft Range</th>
                                                        <th>Bedrooms</th>
                                                        <th>Price</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__empty_1 = true; $__currentLoopData = $cleaner->bed_area_sqfts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <tr>
                                                            <td><?php echo e($index + 1); ?></td>
                                                            <td><?php echo e($area->no_of_sqft); ?></td>
                                                            <td><?php echo e($area->beds); ?></td>
                                                            <td>$<?php echo e(number_format($area->price, 2)); ?></td>
                                                            <td class='d-flex align-items-center gap-1'>
                                                                <button
                                                                    class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle edit-option-btn"
                                                                    data-id="<?php echo e($area->id); ?>"
                                                                    data-type="bedroom"
                                                                    data-record='<?php echo json_encode($area, 15, 512) ?>'
                                                                >
                                                                <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                                                </button>
                                                                <form action="<?php echo e(route('delete.bed.areasqft.options', $area->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this bedroom option?');" style="display:inline;">
                                                                    <?php echo csrf_field(); ?>
                                                                    <?php echo method_field('DELETE'); ?>
                                                                    <button type="submit" class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                                        <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                        <tr>
                                                            <td colspan="5" class="text-center">No area sqft options available.</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bathroom Area Sqft Tab -->
                        <div class="tab-pane fade" id="batharea" role="tabpanel" aria-labelledby="bath-area-tab">
                            <div class="row">
                               
                                <div class="col-md-12 text-end">
                                    <button class="btn btn-primary open-modal" data-type="bathroom">Add Bathroom Sqft Option</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body d-flex align-items-center justify-content-between">
                                        <?php $__empty_1 = true; $__currentLoopData = $cleaner->bath_area_sqfts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <p class='mb-0'>Bathroom price is set to: <strong>$<?php echo e(number_format($area->price, 2)); ?></strong></p> 
                                                    <button
                                                        class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle edit-option-btn"
                                                        data-id="<?php echo e($area->id); ?>"
                                                        data-type="bathroom"
                                                        data-record='<?php echo json_encode($area, 15, 512) ?>'
                                                    >
                                                    <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>

                                                    </button>  
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                        Your did not set bathroom price
                                                    <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Services Tab -->
                        <div class="tab-pane fade" id="service" role="tabpanel" aria-labelledby="service-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class='my-20'>Services</h6>
                                </div>
                                <div class="col-md-6 text-end">
                                    <button class="btn btn-primary open-modal" data-type="service">Add Service</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Price</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__empty_1 = true; $__currentLoopData = $cleaner->service; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <tr>
                                                            <td><?php echo e($index + 1); ?></td>
                                                            <td><?php echo e($service->service_name); ?></td>
                                                            <td>$<?php echo e(number_format($service->price, 2)); ?></td>
                                                            <td class='d-flex align-items-center gap-1'>
                                                                <button
                                                                    class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle edit-option-btn"
                                                                    data-id="<?php echo e($service->id); ?>"
                                                                    data-type="service"
                                                                    data-record='<?php echo json_encode($service, 15, 512) ?>'
                                                                >
                                                                <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                                                </button>
                                                                <form action="<?php echo e(route('delete.service', $service->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this service?');" style="display:inline;">
                                                                    <?php echo csrf_field(); ?>
                                                                    <?php echo method_field('DELETE'); ?>
                                                                    <button type="submit" class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                                    <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                        <tr>
                                                            <td colspan="4" class="text-center">No services available.</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                         <!-- Availability Tab -->
                         <div class="tab-pane fade" id="availability" role="tabpanel" aria-labelledby="availability-tab">
                          
                            <h6 class='my-20'>Availability</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Specific Dates Availability</h6>
                                    <div class="card">
                                        <div class="card-body">
                                            <table class='table w-100'>
                                                <?php $__empty_1 = true; $__currentLoopData = $cleaner->availableDates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <tr>
                                                        <th><?php echo e(\Carbon\Carbon::parse($date->dates)->format('F j, Y')); ?></th>
                                                        <td class="list-group">
                                                            <?php $__currentLoopData = $date->timeSlots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                
                                                                    <?php echo e(\Carbon\Carbon::parse($slot->start_time)->format('g:i A')); ?>

                                                                    -
                                                                    <?php echo e(\Carbon\Carbon::parse($slot->end_time)->format('g:i A')); ?>

                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr>
                                                    <td>No one-time availability.</td>
                                                </tr>
                                                <?php endif; ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h6>Weekly Recurring Availability</h6>

                                    <div class="card">
                                        <div class="card-body">
                                            <table class='table w-100'>

                                            <?php $__empty_1 = true; $__currentLoopData = $cleaner->recurringAvailabilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recurring): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                                            <tr>
                                                <th><?php echo e(ucfirst($recurring->day_of_week)); ?></th>
                                                <td>  <?php echo e(\Carbon\Carbon::parse($recurring->start_time)->format('g:i A')); ?>

                                                    -
                                                    <?php echo e(\Carbon\Carbon::parse($recurring->end_time)->format('g:i A')); ?>

                                                </td>
                                                <td><?php if($recurring->is_active === 0): ?>
                                                    <span class='badge bg-danger'>In-Active</span>
                                                    <?php else: ?>
                                                    <span class='badge bg-success'>Active</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                <a 
                                                    style="cursor:pointer;" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#timeslotmodal"
                                                    data-id="<?php echo e($recurring->id); ?>"
                                                    data-day="<?php echo e($recurring->day_of_week); ?>"
                                                    data-start="<?php echo e($recurring->start_time); ?>"
                                                    data-end="<?php echo e($recurring->end_time); ?>"
                                                    data-interval="<?php echo e($recurring->interval); ?>"
                                                    data-active="<?php echo e($recurring->is_active); ?>"
                                                    class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle open-timeslot-modal"
                                                > 
                                                    <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                                </a>
                                                </td>
                                            </tr>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td>No recurring availability.</td>
                                            </tr>
                                            <?php endif; ?>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
        </div>
    </div>
</div>

<!-- option Modal -->
<div class="modal fade" id="optionModal" tabindex="-1" aria-labelledby="optionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="dynamicForm" method="POST" action="">
        <?php echo csrf_field(); ?>
        <div class="modal-header">
          <h6 class="modal-title" id="optionModalLabel">Add Option</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="cleaner_id" value="<?php echo e($cleaner->id ?? ''); ?>">

          <!-- Sqft -->
          <div class="mb-3" id="sqftGroup">
            <label>Area (Sqft)</label>
            <select name="no_of_sqft" class="form-control">
                <option>Select Area Range</option>
                <?php
                    $start = 0;
                    $end = 1000;
                    while ($end <= 6500) {
                        $label = $end === 6500 ? "{$start} - {$end}+" : "{$start} - {$end}";
                        echo "<option value=\"{$label}\">{$label}</option>";
                        $start = $end;
                        $end += 500;
                    }
                ?>
            </select>
          </div>

          <!-- Beds -->
          <div class="mb-3" id="bedGroup">
            <label>No of Bedrooms</label>
            <!-- <input type="number" name="beds" class="form-control" placeholder="e.g. 2"> -->
            <select name="beds" class='form-control'>
                <option selected>Select</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
            </select>
          </div>


          <!-- Service Name -->
          <div class="mb-3" id="serviceGroup">
            <label>Service Name</label>
            <input type="text" name="service_name" class="form-control" placeholder="e.g. Deep Cleaning">
          </div>

          <!-- Price -->
          <div class="mb-3" id="priceGroup">
            <label>Price</label>
            <input type="number" name="price" class="form-control" step="0.01" placeholder="e.g. 50.00">
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="cleaneraddModal" tabindex="-1" aria-labelledby="zipcodeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="zipcodeModalLabel">Update Cleaner</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body with Form -->
      <div class="modal-body">
      <form action="<?php echo e(route('cleaners.update')); ?>" method='POST' enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
                <div class="row gy-3">
                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" id="firstname" value='<?php echo e($cleaner->name); ?>'>
                        <input type="hidden" name="cleaner_id" class="form-control" id="cleaner_id" value='<?php echo e($cleaner->id); ?>'>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value='<?php echo e($cleaner->email); ?>'>
                    </div>
                </div>
                <div class='row gy-3'>
                    <div class="col-12">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" id="cleaner_phone" value='<?php echo e($cleaner->phone); ?>'>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Bio</label>
                        <textarea name="bio" class="form-control" rows="4" cols="50" id="cleaner_bio"><?php echo e($cleaner->bio); ?></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Price</label>
                        <input type="text" name="price" class="form-control" value='<?php echo e($cleaner->price); ?>'>
                    </div>
                    <div class="col-12">
                        <label for="profile_picture">Profile Picture</label>
                        <input type="file" name='profile_picture' id='profile_picture' class='form-control'>
                        <img style='width:130px;' src="<?php echo e(asset('storage/' . $cleaner->profile_picture)); ?>" alt="">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="*******">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary-600">Update</button>
                    </div>
                </div>
           </form>
      </div>

    </div>
  </div>
</div>


<!-- Timeslots Modal -->
<div class="modal fade" id="timeslotmodal" tabindex="-1" aria-labelledby="timeslotmodalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo e(route('recurring-availability.update')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="id" id="modal_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Availability</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="modal_day" class="form-label">Day of Week</label>
                        <input type="text" class="form-control" id="modal_day" name="day_of_week" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="modal_start" class="form-label">Start Time</label>
                        <input type="time" class="form-control" id="modal_start" name="start_time">
                    </div>
                    <div class="mb-3">
                        <label for="modal_end" class="form-label">End Time</label>
                        <input type="time" class="form-control" id="modal_end" name="end_time">
                    </div>
                    <div class="mb-3">
                        <label for="modal_interval" class="form-label">Interval (minutes)</label>
                        <input type="number" class="form-control" id="modal_interval" name="interval">
                    </div>
                    <div class="mb-3">
                        <label for="modal_active" class="form-label">Status</label>
                        <select class="form-select" name="is_active" id="modal_active">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Availability</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Edit Option Modal -->
<div class="modal fade" id="editOptionModal" tabindex="-1" aria-labelledby="editOptionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editForm" method="POST" action="">
        <?php echo csrf_field(); ?>
        <div class="modal-header">
          <h6 class="modal-title" id="editOptionModalLabel">Edit Option</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="cleaner_id" value="<?php echo e($cleaner->id ?? ''); ?>">
          <input type="hidden" name="id" id="edit_id">

          <!-- Sqft -->
          <div class="mb-3" id="editSqftGroup">
            <label>Sqft Range</label>
            <select name="edit_no_of_sqft" id="edit_no_of_sqft" class="form-control">
                <?php
                    $start = 0;
                    $end = 1000;
                    while ($end <= 6500) {
                        $label = ($end === 6500) ? "{$start} - {$end}+" : "{$start} - {$end}";
                        echo "<option value=\"{$label}\">{$label}</option>";
                        $start = $end;
                        $end += 500;
                    }
                ?>
            </select>
        </div>

          <!-- Beds -->
          <div class="mb-3" id="editBedGroup">
            <label>No of Bedrooms</label>
            <select name="beds" id="edit_beds" class='form-control'>
                <option selected>Select</option>
                <?php for($i = 1; $i <= 7; $i++): ?>
                    <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                <?php endfor; ?>
            </select>
          </div>

          <!-- Service Name -->
          <div class="mb-3" id="editServiceGroup">
            <label>Service Name</label>
            <input type="text" name="service_name" id="edit_service_name" class="form-control" placeholder="e.g. Deep Cleaning">
          </div>

          <!-- Price -->
          <div class="mb-3" id="editPriceGroup">
            <label>Price</label>
            <input type="number" name="price" id="edit_price" class="form-control" step="0.01" placeholder="e.g. 50.00">
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>



<script>
const forms = {
  bedroom: {
    action: '<?php echo e(route("insert.bed.areasqft.options")); ?>'
  },
  bathroom: {
    action: '<?php echo e(route("insert.bath.areasqft.options")); ?>'
  },
  service: {
    action: '<?php echo e(route("insert.service")); ?>'
  }
};

$(document).on('click', '.open-modal', function () {
  const type = $(this).data('type');
  const formInfo = forms[type];

  // Set form action
  $('#dynamicForm').attr('action', formInfo.action);

  // Reset all fields
  $('#sqftGroup, #bedGroup, #bathGroup, #serviceGroup, #priceGroup').hide();

  // Show relevant fields
  if (type === 'bedroom') {
    $('#sqftGroup, #bedGroup, #priceGroup').show();
  } else if (type === 'bathroom') {
    $('#priceGroup').show();
  } else if (type === 'service') {
    $('#serviceGroup, #priceGroup').show();
  }

  // Show modal
  const modal = new bootstrap.Modal(document.getElementById('optionModal'));
  modal.show();
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.open-timeslot-modal').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('modal_id').value = this.dataset.id;
            document.getElementById('modal_day').value = this.dataset.day;
            document.getElementById('modal_start').value = this.dataset.start;
            document.getElementById('modal_end').value = this.dataset.end;
            document.getElementById('modal_interval').value = this.dataset.interval;
            document.getElementById('modal_active').value = this.dataset.active;
        });
    });
});



const editForms = {
  bedroom: {
    actionBase: '/bed-area-sqft/update/',
    fieldsToShow: ['editSqftGroup', 'editSqftGroup2', 'editBedGroup', 'editPriceGroup']
  },
  bathroom: {
    actionBase: '/bathroom-price/update/',
    fieldsToShow: ['editPriceGroup']
  },
  service: {
    actionBase: '/services/update/',
    fieldsToShow: ['editServiceGroup', 'editPriceGroup']
  }
};

$(document).on('click', '.edit-option-btn', function () {
  const type = $(this).data('type');
  const id = $(this).data('id');
  const data = $(this).data('record');

  const formMeta = editForms[type];
  $('#editForm').attr('action', formMeta.actionBase + id);
  $('#edit_id').val(data.id); 
  // Hide all
  $('#editSqftGroup, #editSqftGroup2, #editBedGroup, #editServiceGroup, #editPriceGroup').hide();

  // Show relevant fields
  formMeta.fieldsToShow.forEach(id => $('#' + id).show());

  // Populate fields
  if (data.no_of_sqft) {
    $('#edit_no_of_sqft').val(data.no_of_sqft.trim());
    } else {
        $('#edit_no_of_sqft').val('');
    }
  $('#edit_beds').val(data.beds ?? '');
  $('#edit_service_name').val(data.service_name ?? '');
  $('#edit_price').val(data.price ?? '');

  // Show modal
  const modal = new bootstrap.Modal(document.getElementById('editOptionModal'));
  modal.show();
});

</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/2025 Projects/updatedecopros/resources/views/admin/cleaners/single_cleaner/profile.blade.php ENDPATH**/ ?>