<?php $__env->startSection('content'); ?>





<!-- new code --> 
<div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="d-flex summary-wrapper row-cols-md-2 flex-md-row flex-column">

          <!-- Left Panel -->
          <div class="left-panel col-md-6">
            <h4 class="mb-4">Service Details</h4>

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
                    
            <div class="icon-item">
              <span><i class="bi bi-house-door-fill"></i> Dimensions</span>
              <p class='mb-0'><span class='selected-beds'><?php echo e($beds); ?></span> BD / <span class='selected-baths'><?php echo e($baths); ?></span> BA / <span class='selected-area'><?php echo e($area_sqft); ?></span> sqft</p>
            </div>
           

            <div class="icon-item">
              <span><i class="bi bi-clock-fill"></i> Start Time</span>
              <span>
                <?php
                    use Carbon\Carbon;
                    $formattedDate = Carbon::parse($selectedDate)->format('D, M d');
                ?>
                <?php echo e($formattedDate); ?> at <?php echo e($slot); ?>

            </span>
            </div>
            <div class="icon-item">
              <span><i class="bi bi-repeat"></i> Frequency</span>
              <?php if($frequency === 'one_time'): ?>
                <span class='text-end'>One Time</span>
                <?php elseif($frequency === 'weekly'): ?>
                <span class='text-end'>Every Week</span>
                <?php elseif($frequency === 'biweekly'): ?>
                <span class='text-end'>Biweekly</span>
                <?php elseif($frequency === 'monthly'): ?>
                <span class='text-end'>Every Month</span>
                <?php endif; ?>
            </div>

            <h5 class="mt-4 mb-3">Additional Services</h5>
            <?php if($selectedAddons->isNotEmpty()): ?>
                <ul class="additional-list p-0">
                <?php if($selectedAddons->isNotEmpty()): ?>
                    <?php $__currentLoopData = $selectedAddons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($addon->addon_name); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                </ul>
            <?php endif; ?>
          </div>

          <!-- Right Panel -->
          <div class="right-panel col-md-6">
            <h4 class="mb-4">Summary</h4>

            <div class="price-item">
              <span>One-time Price</span>
              <span>$<?php echo e(number_format($oneTimePrice, 2)); ?></span>
            </div>
            <div class="price-item">
              
             <?php if(isset($discountAmounts[$frequency])): ?>
                
                    <?php if($frequency === 'weekly'): ?>
                           
                        <span>Weekly Discount (20% off)</span>
                        <span class="text-end text-success">- $<?php echo e(number_format($discountAmounts[$frequency], 2)); ?></span>
                        
                        <?php elseif($frequency === 'biweekly'): ?>
                        
                        <span>Biweekly Discount (10% off)</span>
                        <span class="text-end text-success">- $<?php echo e(number_format($discountAmounts[$frequency], 2)); ?></span>
                        
                        <?php elseif($frequency === 'monthly'): ?>
                       
                        <span>Monthly Discount (10% off)</span>
                    <span class="text-end text-success">- $<?php echo e(number_format($discountAmounts[$frequency], 2)); ?></span>
                    
                    <?php endif; ?>
            
            <?php endif; ?>

            </div>
            <div class="price-item price-total">
              <span>Total</span>
              <span class='text-end'>$<?php echo e(number_format($discountedPrices[$frequency], 2)); ?></span>
            </div>

            <?php if(auth()->guard()->check()): ?>
                        <?php if(Auth::user()->role !== 'admin'): ?>
                        <form action="<?php echo e(route('book.appointment')); ?>" method='POST'>
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name='cleaner_id' value='<?php echo e($cleaner->id); ?>'>
                            <input type="hidden" name='customer_id' value='<?php echo e(Auth::user()->id); ?>'>
                            <input type="hidden" name='beds_area_sqft_id' value='<?php echo e($bedPriceModel->id ?? ""); ?>'>
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
                            <input name="address" class='form-control bg-white text-dark' placeholder='Enter Your Address' id="address">
                            <label class='mt-2' for="additional_notes">Additional Notes</label>
                            <textarea name="additional_notes" class='form-control bg-white text-dark' placeholder='Enter Notes for cleaner' id="additional_notes" cols="30" rows="5"></textarea>
                           
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