<?php $__env->startSection('content'); ?>



<?php
    $backUrl = route('quote.extended', [
        'employee' => $employee->id,
        'slot' => $slot,
        'selecteddate' => $selectedDate,
    ] + collect(json_decode($selectedServices, true))->pluck('id')->mapWithKeys(fn($id) => ["services[]" => $id])->all()
      + collect(json_decode($selectedAddons, true))->pluck('id')->mapWithKeys(fn($id) => ["addons[]" => $id])->all()
    );
?>


<!-- new code --> 
<div class="container my-5">
<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>
    <div class="row justify-content-center">
      <div class="col-lg-10">
      <a href="<?php echo e($backUrl); ?>" class="btn btn-secondary mb-3">← Back</a>

        <div class="d-flex summary-wrapper row-cols-md-2 flex-md-row flex-column">

          <!-- Left Panel -->
          <div class="left-panel col-md-6">
            <h4 class="mb-4">Service Details</h4>

            <div class="employee-profile-selected">
                        <div class="profile-picturebox">
                                <?php if($employee->profile_picture): ?>
                                    <img src="<?php echo e(asset('storage/' . $employee->profile_picture)); ?>" alt="Profile Picture" width="150">
                                <?php endif; ?>
                        </div>
                        <div class="employee-name-box">
                            <h4><?php echo e($employee->name); ?></h4>
                        </div>
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

            <?php if($selectedServices->isNotEmpty()): ?>
            <h5 class="mt-4 mb-3">Services</h5>
                <ul class="additional-list p-0">
                <?php if($selectedServices->isNotEmpty()): ?>
                    <?php $__currentLoopData = $selectedServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($service->service_name); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                </ul>
            <?php endif; ?>

           
            <?php if($selectedAddons->isNotEmpty()): ?>
            <h5 class="mt-4 mb-3">Addons</h5>
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
        

            <?php if(auth()->guard()->check()): ?>
                        <?php if(Auth::user()->role !== 'admin'): ?>
                        <form action="<?php echo e(route('book.appointment')); ?>" method='POST' id='payment-form'>
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name='employee_id' value='<?php echo e($employee->id); ?>'>
                            <input type="hidden" name='customer_id' value='<?php echo e(Auth::user()->id); ?>'>

                            <?php
                                $serviceId = collect(json_decode($selectedServices, true))->pluck('id')->toJson();
                            ?>
                            <input type="hidden" name="service_id" value="<?php echo e($serviceId); ?>">
                            <input type="hidden" name='appointment_date' value='<?php echo e($selectedDate); ?>'>
                            <?php
                                $parts = explode(' - ', $slot);
                                $start_time = $parts[0] . ':00';
                                $end_time = $parts[1] . ':00';
                            ?>

                            <input type="hidden" name="start_time" value="<?php echo e($start_time); ?>">
                            <input type="hidden" name="end_time" value="<?php echo e($end_time); ?>">
                            <input type="hidden" name="total_price" value="<?php echo e($totalPrice); ?>">
                            <?php
                                $addonIds = collect(json_decode($selectedAddons, true))->pluck('id')->toJson();
                            ?>

                            <input type="hidden" name="addon_ids" value="<?php echo e($addonIds); ?>">
                            <label class='mt-3' for="address">Address</label>
                            <input name="address" class='form-control bg-white text-dark' placeholder='Enter Your Address' id="address">
                            <label class='mt-2' for="additional_notes">Additional Notes</label>
                            <textarea name="additional_notes" class='form-control bg-white text-dark' placeholder='Enter Notes for employee' id="additional_notes" cols="30" rows="5"></textarea>
                           
                            
                            <div class="mt-3">
                                <label>Card Details</label>
                                <div id="card-element" class="form-control p-2"></div>
                            </div>

                            <input type="hidden" name="stripeToken" id="stripeToken">

                            <button class='continuebtn' type='submit' id="pay-button">Book Appointment</button>
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
                        <label>Phone</label>
                        <input type="tel" name='phone' placeholder='Phone Number' class='w-100'>
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

<script src="https://js.stripe.com/v3/"></script>

<script>
    const stripe = Stripe( "<?php echo e(env('STRIPE_KEY')); ?>");
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    const form = document.getElementById('payment-form');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const { token, error } = await stripe.createToken(card);

        if (error) {
            alert(error.message);
        } else {
            document.getElementById('stripeToken').value = token.id;
            form.submit();
        }
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/2025 Projects/A1ClassicGarage/resources/views/frontend/quote-checkout.blade.php ENDPATH**/ ?>