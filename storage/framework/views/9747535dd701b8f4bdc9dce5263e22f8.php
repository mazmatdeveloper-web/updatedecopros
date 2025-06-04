<?php $__env->startSection('admin_content'); ?>

<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Addons</h6>
        
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addonaddModal">
        Add New Addon
        </button>
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

    <div class="row d-flex justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                   <table class='table' border="1" cellpadding="10" cellspacing="0" style='width:100%;'>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Price</th>
                                 <th style="width:20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $addons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($index + 1); ?></td>
                                    <td><?php echo e($addon->addon_name); ?></td>
                                    <td>$<?php echo e($addon->price); ?></td>
                                    <td style="display:flex;gap:10px;"><button type="button" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"> 
                                            <iconify-icon class="editZipBtn" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editzipcodeModal" 
                                        data-id="<?php echo e($addon->id); ?>" 
                                        data-name="<?php echo e($addon->addon_name); ?>"
                                        data-price="<?php echo e($addon->price); ?>"
                                        icon="lucide:edit" class="menu-icon"></iconify-icon>
                                        </button>
                                        <form>  
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="id" value="<?php echo e($addon->id); ?>">
                                            <button type="submit" formaction="<?php echo e(route('delete.addon', ['id' => $addon ->id])); ?>" class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"> 
                                            <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                        </button>
                                        </form>
                                      </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="3">No addons found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addonaddModal" tabindex="-1" aria-labelledby="zipcodeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="zipcodeModalLabel">New Addon</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body with Form -->
      <div class="modal-body">
      <form action="<?php echo e(route('insert.addon')); ?>" method='POST'>
            <?php echo csrf_field(); ?>
                <div class="row gy-3">
                    <div class="col-md-12">
                        <label class="form-label">Addon Name</label>
                        <input type="text" name="addon_name" class="form-control" placeholder="Interior Refrigerator">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Price</label>
                        <input type="number" name="price" class="form-control" placeholder="e.g 10.00">
                    </div>
                   <div class="col-md-12">
                   <button class='btn btn-primary' type='submit'>Save</button>
                   </div>
                </div>
           </form>
      </div>

    </div>
  </div>
</div>

<!-- Edit Zipcode Modal -->
<div class="modal fade" id="editzipcodeModal" tabindex="-1" aria-labelledby="editzipcodeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="zipcodeModalLabel">Edit Addon</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body with Form -->
      <div class="modal-body">
        <form method="POST" id="editZipForm" action="<?php echo e(route('update.addon', 0)); ?>">
          <?php echo csrf_field(); ?>
          <input type="hidden" name="id" id="editzipcode_id">
          <div class="mb-3">
            <label class="form-label">Addon</label>
            <input type="text" name="addon_name" class="form-control" id="editaddon_name">
          </div>
          <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="text" name="price" class="form-control" id="editaddon_price">
          </div>
          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>

      </div>

    </div>
  </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.editZipBtn');

        editButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                const addonId = this.getAttribute('data-id');
                const addonName = this.getAttribute('data-name');
                const addonPrice = this.getAttribute('data-price');

                // Fill modal fields
                document.getElementById('editzipcode_id').value = addonId;
                document.getElementById('editaddon_name').value = addonName;
                document.getElementById('editaddon_price').value = addonPrice;

                // Update action URL
                const form = document.getElementById('editZipForm');
                form.action = `/update-addon/${addonId}`; // or use route() if needed
            });
        });
    });
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\echopros1\echopros\resources\views/admin/addons/index.blade.php ENDPATH**/ ?>