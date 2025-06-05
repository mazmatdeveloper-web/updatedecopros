<?php $__env->startSection('admin_content'); ?>
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center gap-3 mb-24 justify-content-between">
        <div>
    <?php if($cleaner->profile_picture): ?>
        <img src="<?php echo e(asset('storage/' . $cleaner->profile_picture)); ?>" alt="Profile Picture" class='cleaner-profile-picture'>
    <?php endif; ?>    
    <h6 class="fw-semibold mb-0"><?php echo e($cleaner->name); ?></h6>
    </div>
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
class="btn btn-primary">Update Profile</button>
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
                                role="tab" aria-controls="bath-area" aria-selected="false">Bathrooms Area Sqft</button>
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
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__empty_1 = true; $__currentLoopData = $cleaner->bed_area_sqfts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <tr>
                                                            <td><?php echo e($index + 1); ?></td>
                                                            <td><?php echo e($area->no_of_sqft); ?></td>
                                                            <td><?php echo e($area->beds); ?></td>
                                                            <td>$<?php echo e(number_format($area->price, 2)); ?></td>
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
                                <div class="col-md-6">
                                    <h6 class='my-20'>Area Sqft with Bathroom Options</h6>
                                </div>
                                <div class="col-md-6 text-end">
                                    <button class="btn btn-primary open-modal" data-type="bathroom">Add Bathroom Sqft Option</button>
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
                                                        <th>Bathrooms</th>
                                                        <th>Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__empty_1 = true; $__currentLoopData = $cleaner->bath_area_sqfts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <tr>
                                                            <td><?php echo e($index + 1); ?></td>
                                                            <td><?php echo e($area->no_of_sqft); ?></td>
                                                            <td><?php echo e($area->baths); ?></td>
                                                            <td>$<?php echo e(number_format($area->price, 2)); ?></td>
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
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__empty_1 = true; $__currentLoopData = $cleaner->service; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <tr>
                                                            <td><?php echo e($index + 1); ?></td>
                                                            <td><?php echo e($service->service_name); ?></td>
                                                            <td>$<?php echo e(number_format($service->price, 2)); ?></td>
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

<!-- Modal -->
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
            <label>No of Sqft</label>
            <input type="text" name="no_of_sqft" class="form-control" placeholder="e.g. 1000">
          </div>

          <!-- Beds -->
          <div class="mb-3" id="bedGroup">
            <label>No of Bedrooms</label>
            <input type="number" name="beds" class="form-control" placeholder="e.g. 2">
          </div>

          <!-- Baths -->
          <div class="mb-3" id="bathGroup">
            <label>No of Bathrooms</label>
            <input type="number" name="baths" class="form-control" placeholder="e.g. 1">
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
    $('#sqftGroup, #bathGroup, #priceGroup').show();
  } else if (type === 'service') {
    $('#serviceGroup, #priceGroup').show();
  }

  // Show modal
  const modal = new bootstrap.Modal(document.getElementById('optionModal'));
  modal.show();
});
</script>


<!-- <script>
document.addEventListener('DOMContentLoaded', function () {
    const updateButtons = document.querySelectorAll('[data-bs-target="#cleaneraddModal"]');

    updateButtons.forEach(button => {
        button.addEventListener('click', function () {
            const name = button.getAttribute('data-name');
            const email = button.getAttribute('data-email');
            const phone = button.getAttribute('data-phone');
            const bio = button.getAttribute('data-bio');
            const price = button.getAttribute('data-price');

            // Fill form fields
            document.getElementById('firstname').value = name;
            document.querySelector('input[name="email"]').value = email;
            document.getElementById('cleaner_phone').value = phone;
            document.getElementById('cleaner_bio').value = bio;
            document.querySelector('input[name="price"]').value = price;

            // Optional: set form action to update instead of insert
            document.querySelector('#cleaneraddModal form').setAttribute('action', '<?php echo e(route("cleaners.update", ["id" => $cleaner->id])); ?>');
        });
    });
});
</script> -->




<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/2025 Projects/updatedecopros/resources/views/admin/cleaners/single_cleaner/profile.blade.php ENDPATH**/ ?>