<?php $__env->startSection('admin_content'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h4 class="mb-4">Update Customer</h4>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('update.customer', $customer->id)); ?>">
                <?php echo csrf_field(); ?>

                <div class="form-group mb-3">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" class="form-control" required value="<?php echo e($customer->name); ?>">
                </div>

                <div class="form-group mb-3">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" class="form-control" required value="<?php echo e($customer->email); ?>">
                </div>

                <div class="form-group mb-3">
                    <label for="email">Phone</label>
                    <input type="tel" name="phone" class="form-control" required value="<?php echo e($customer->phone); ?>">
                </div>


                <button type="submit" class="btn btn-primary w-100">Update User</button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/2025 Projects/updatedecopros/resources/views/admin/customers/edit.blade.php ENDPATH**/ ?>