<?php $__env->startSection('admin_content'); ?>

<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Zipcodes</h6>
        
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#zipcodeModal">
        Add New Zipcode
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
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                   <table class='table' border="1" cellpadding="10" cellspacing="0" style='width:100%;'>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ZIP Code</th>
                                <th style="width:20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $zipcodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $zipcode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($index + 1); ?></td>
                                    <td><?php echo e($zipcode->codes); ?></td>
                                    <td style="display:flex;gap:10px;"><button type="button" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"> 
                                            <iconify-icon class="editZipBtn" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editzipcodeModal" 
                                        data-id="<?php echo e($zipcode->id); ?>" 
                                        data-code="<?php echo e($zipcode->codes); ?>" icon="lucide:edit" class="menu-icon"></iconify-icon>
                                        </button>
                                        <form>  
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="id" value="<?php echo e($zipcode->id); ?>">
                                            <button type="submit" formaction="<?php echo e(route('delete.zipcode', ['id' => $zipcode->id])); ?>" class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"> 
                                            <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                        </button>
                                        </form>
                                      </td>
                                       
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="3">No ZIP codes found.</td>
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
<div class="modal fade" id="zipcodeModal" tabindex="-1" aria-labelledby="zipcodeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="zipcodeModalLabel">Edit Zipcode</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body with Form -->
      <div class="modal-body">
        <form action="<?php echo e(route('insert.zipcode')); ?>" method='POST'>
          <?php echo csrf_field(); ?>
          <div class="mb-3">
            <label class="form-label">Add Zipcode</label>
            <input type="text" name="codes" class="form-control" placeholder="33004">
          </div>
          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Submit</button>
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
        <h5 class="modal-title" id="zipcodeModalLabel">Add New Zipcode</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body with Form -->
      <div class="modal-body">
        <form method="POST" id="editZipForm" action="<?php echo e(route('update.zipcode', 0)); ?>">
          <?php echo csrf_field(); ?>
          <input type="hidden" name="id" id="editzipcode_id">
          <div class="mb-3">
            <label class="form-label">Zipcode</label>
            <input type="text" name="codes" class="form-control" id="editzipcode_code">
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
                const zipId = this.getAttribute('data-id');
                const zipCode = this.getAttribute('data-code');

                // Set values in modal
                document.getElementById('editzipcode_id').value = zipId;
                document.getElementById('editzipcode_code').value = zipCode;

                // Dynamically update form action
                const form = document.getElementById('editZipForm');
                form.action = `/update-zipcode/${zipId}`; 
            });
        });
    });
</script>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\echopros1\echopros\resources\views/admin/zipcode/add-zipcode.blade.php ENDPATH**/ ?>