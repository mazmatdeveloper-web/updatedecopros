<?php $__env->startSection('content'); ?>

<div class="container">
    <h4 class='my-3 text-center'>Confirm Service</h4>
    <div class="row d-flex align-items-center justify-content-center">
        <div class="col-md-7">
           <div class="row py-5">
                <div class="col-md-7">
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
                    <div class="cleaner-profile-selected">
                        <div class="profile-picturebox">
                                <?php if($cleaner->profile_picture): ?>
                                    <img src="<?php echo e(asset('storage/' . $cleaner->profile_picture)); ?>" alt="Profile Picture" width="150">
                                <?php endif; ?>
                        </div>
                        <div class="cleaner-name-box">
                            <h4><?php echo e($cleaner->name); ?></h4>
                            <p>House Cleaning</p>
                        </div>
                    </div>

                    <div class="selected-items-container mt-3">
                        <table class='selected-items-table w-100'>
                            <tr>
                                <th>Dimensions</th>
                                <td class='text-end'><span class='selected-beds'><?php echo e($beds); ?></span> BD / <span class='selected-baths'><?php echo e($baths); ?></span> BA / <span class='selected-area'><?php echo e($area_sqft); ?></span> sqft</td>
                            </tr>
                            <tr>
                                <th>Start Time</th>
                                <?php
                                    use Carbon\Carbon;
                                    $formattedDate = Carbon::parse($selectedDate)->format('D, M d');
                                ?>

                                <td class='text-end'>
                                    <?php echo e($formattedDate); ?> at <?php echo e($slot); ?>

                                </td>
                            </tr>
                            <tr>
                                <th>Frequency</th>
                                <?php if($frequency === 'one_time'): ?>
                                <td class='text-end'>One Time</td>
                                <?php elseif($frequency === 'weekly'): ?>
                                <td class='text-end'>Every Week</td>
                                <?php elseif($frequency === 'biweekly'): ?>
                                <td class='text-end'>Biweekly</td>
                                <?php elseif($frequency === 'monthly'): ?>
                                <td class='text-end'>Every Month</td>
                                <?php endif; ?>
                            </tr>
                            <tr>
                                <?php if($selectedAddons->isNotEmpty()): ?>
                                <th class='d-flex'>Additional Services</th>
                                <td class='text-end'> 
                                    
                                        <ul class='addon-list' style='list-style:none;'>
                                            <?php $__currentLoopData = $selectedAddons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li><?php echo e($addon->addon_name); ?></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="selected-items-container mt-2">
                        <table class='selected-items-table w-100'>
                            <tr>
                                <th>One-time Price</th>
                                <td class='text-end'>$<?php echo e(number_format($oneTimePrice, 2)); ?></td>
                            </tr>
                            <?php if(isset($discountAmounts[$frequency])): ?>
                            <tr>     
                                    <?php if($frequency === 'weekly'): ?>
                                        <th>Weekly Discount (20% off)</th>
                                        <td class="text-end text-success">- $<?php echo e(number_format($discountAmounts[$frequency], 2)); ?></td>
                                    <?php elseif($frequency === 'biweekly'): ?>
                                        <th>Biweekly Discount (10% off)</th>
                                        <td class="text-end text-success">- $<?php echo e(number_format($discountAmounts[$frequency], 2)); ?></td>
                                    <?php elseif($frequency === 'one_time'): ?>
                                        <th></th>
                                        <td class="text-end text-success"></td>
                                    <?php elseif($frequency === 'monthly'): ?>
                                    <th>Monthly Discount (10% off)</th>
                                    <td class="text-end text-success">- $<?php echo e(number_format($discountAmounts[$frequency], 2)); ?></td>
                                    <?php endif; ?>
                            </tr>
                            <?php endif; ?>
                        </table>
                    </div>

                    <div class="selected-items-container mt-2">
                        <table class='selected-items-table w-100'>
                            <tr>
                                <th>Total</th>
                                <td class='text-end'>$<?php echo e(number_format($discountedPrices[$frequency], 2)); ?></td>
                            </tr>
                            
                        </table>
                    </div>

                    <?php if(auth()->guard()->check()): ?>
                        <?php if(Auth::user()->role !== 'admin'): ?>
                        <form action="<?php echo e(route('book.appointment')); ?>" method='POST'>
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name='cleaner_id' value='<?php echo e($cleaner->id); ?>'>
                            <input type="hidden" name='customer_id' value='<?php echo e(Auth::user()->id); ?>'>
                            <input type="hidden" name='beds_area_sqft_id' value='<?php echo e($bedPriceModel->id); ?>'>
                            <input type="hidden" name='baths_area_sqft_id' value='<?php echo e($bathPriceModel->id ?? ""); ?>'>
                            <input type="hidden" name='service_id' value='<?php echo e($servicePriceModel->id ?? ""); ?>'>
                            <input type="hidden" name='discount_label' value='<?php echo e($frequency); ?>'>
                            <input type="hidden" name='discount_price' value='<?php echo e(number_format($discountAmounts[$frequency], 2)); ?>'>
                            <input type="hidden" name='total_price' value='<?php echo e(number_format($discountedPrices[$frequency], 2)); ?>'>
                            <input type="hidden" name='appointment_date' value='<?php echo e($selectedDate); ?>'>
                            <?php
                                $parts = explode(' - ', $slot);
                                $start_time = $parts[0] . ':00';
                                $end_time = $parts[1] . ':00';
                            ?>

                            <input type="hidden" name="start_time" value="<?php echo e($start_time); ?>">
                            <input type="hidden" name="end_time" value="<?php echo e($end_time); ?>">
                            <?php
                                $addonIds = collect(json_decode($selectedAddons, true))->pluck('id')->toJson();
                            ?>

                            <input type="hidden" name="addon_ids" value='<?php echo e($addonIds); ?>'>
                            <label class='mt-3' for="address">Address</label>
                            <textarea name="address" class='form-control bg-white text-dark' placeholder='Enter Your Address' id="address" cols="30" rows="5">
                            </textarea>
                            <button class='continuebtn' type='submit'>Continue</button>
                        </form>
                            
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="login-btns-div">
                        <button type='button' class='loginbtn' data-bs-toggle="modal" data-bs-target="#pill-modal">
                            Login & Confirm
                        </button>
                        </div>
                    <?php endif; ?>
                    
                </div>
           </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="pill-modal" tabindex="-1" aria-labelledby="pillModalLabel" aria-hidden="true" data-bs-keyboard="true">
    <div class="modal-dialog modal-dialog-centered pillmodal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pillModalLabel">Log In</h5>
            </div>
            <div class="modal-body">

                
                <form action="<?php echo e(route('manual.login')); ?>" class="login-form auth-form" method='POST'>
                    <?php echo csrf_field(); ?>
                    <div class='form-group'>
                        <label>Email</label>
                        <input type="email" name='email' placeholder='Email Address' class='w-100'>
                    </div>
                    <div class='form-group mt-2'>
                        <label>Password</label>
                        <input type="password" name='password' placeholder='******' class='w-100'>
                    </div>
                    <button class='loginbtn mt-3 w-100' type='submit'>Login</button>
                    <p class="mt-3 text-center">
                        Don't have an account? <a href="#" onclick="toggleAuthForm('register')">Create one</a>
                    </p>
                </form>

                
                <form action="<?php echo e(route('manual.register')); ?>" class="register-form auth-form d-none" method='POST'>
                    <?php echo csrf_field(); ?>
                    <div class='form-group'>
                        <label>Name</label>
                        <input type="text" name='name' placeholder='Full Name' class='w-100'>
                    </div>
                    <div class='form-group mt-2'>
                        <label>Email</label>
                        <input type="email" name='email' placeholder='Email Address' class='w-100'>
                    </div>
                    <div class='form-group mt-2'>
                        <label>Password</label>
                        <input type="password" name='password' placeholder='******' class='w-100'>
                    </div>
                    <div class='form-group mt-2'>
                        <label>Confirm Password</label>
                        <input type="password" name='password_confirmation' placeholder='******' class='w-100'>
                    </div>
                    <button class='loginbtn mt-3 w-100' type='submit'>Register</button>
                    <p class="mt-3 text-center">
                        Already have an account? <a href="#" onclick="toggleAuthForm('login')">Login</a>
                    </p>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Toggle Script -->
<script>
    function toggleAuthForm(type) {
        const loginForm = document.querySelector('.login-form');
        const registerForm = document.querySelector('.register-form');
        const modalTitle = document.getElementById('pillModalLabel');

        if (type === 'register') {
            loginForm.classList.add('d-none');
            registerForm.classList.remove('d-none');
            modalTitle.innerText = 'Register';
        } else {
            registerForm.classList.add('d-none');
            loginForm.classList.remove('d-none');
            modalTitle.innerText = 'Log In';
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/2025 Projects/updatedecopros/resources/views/frontend/quote-checkout.blade.php ENDPATH**/ ?>