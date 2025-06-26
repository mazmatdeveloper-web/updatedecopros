<?php $__env->startSection('content'); ?>
<div class="container p-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-white border-0 pt-4">
                    <h2 class="text-center text-uppercase font-weight-bold" style="color: #026839;"><?php echo e(__('Reset Password')); ?></h2>
                    <p class="text-center text-muted mt-2">Enter your email to receive a reset link</p>
                </div>

                <div class="card-body px-5">
                    <?php if(session('status')): ?>
                        <div class="alert alert-success mb-4" role="alert" style="border-radius: 8px;">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('password.email')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="mb-4">
                            <label for="email" class="form-label text-muted"><?php echo e(__('Email Address')); ?></label>
                            <input id="email" type="email" class="form-control form-control-lg <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus
                                   style="border-radius: 8px; border: 1px solid #ddd; padding: 12px;">

                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block">
                                    <strong><?php echo e($message); ?></strong>
                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-lg text-white py-3 text-uppercase fw-bold" 
                                    style="background-color: #40D002; border-radius: 8px; border: none;">
                                <?php echo e(__('Send Password Reset Link')); ?>

                            </button>
                        </div>

                        <div class="text-center text-muted">
                            Remember your password? 
                            <a href="<?php echo e(route('login')); ?>" class="text-decoration-none fw-bold" style="color: #026839;">
                                <?php echo e(__('Login here')); ?>

                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<style>
    body {
        background-color: #f8f9fa;
    }
    .card {
        border-radius: 12px;
        border: none;
    }
    .form-control:focus {
        border-color: #40D002;
        box-shadow: 0 0 0 0.25rem rgba(64, 208, 2, 0.25);
    }
    .btn:hover {
        background-color: #026839 !important;
        transition: all 0.3s ease;
    }
    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
    }
    
</style>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/2025 Projects/updatedecopros/resources/views/auth/passwords/email.blade.php ENDPATH**/ ?>