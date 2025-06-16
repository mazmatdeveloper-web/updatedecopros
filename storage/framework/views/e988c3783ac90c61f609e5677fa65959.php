<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row" style='height:100vh;'>
        <div class="col-md-9">

            

        </div>
        
        
        
        
        <div class="col-md-3 cart-col">
            <h2 class='cart-col-title mb-4'>Summary</h2>

            <div class="cleaner-div mb-4">
            <div class="cleaner-profile-selected">
                        <div class="profile-picturebox">
                                
                                    <img src="http://127.0.0.1:8000/storage/cleaners/yT6Cj7FzsMoeydSxNiwf14DaliqpFgwaeXMAeYGV.jpg" alt="Profile Picture" width="150">
                               
                        </div>
                        <div class="cleaner-name-box">
                            <h4>John Doe</h4>
                            <p>House Cleaning</p>
                        </div>
                    </div>
            </div>
            
            <h3 class='summary-labels'>Dimensions</h3>
            <div class="dimensions-div mb-4">
                <table class='dimensions-table w-100'>
                    <tr>
                        <th>Bedroom:</th>
                        <td>1 BD</td>
                    </tr>
                    <tr>
                        <th>Bathroom:</th>
                        <td>1 BA</td>
                    </tr> 
                    <tr>
                        <th>Area Sqft:</th>
                        <td>0 - 1000</td>
                    </tr>
                </table>
            </div>
           
            <h3 class='summary-labels'>Additional Services</h3>
            <div class="additional-services-div mb-4">
                <table class='additional-services-table w-100'>
                <tr>
                    <th>Interior Refrigerator</th>
                    <td>$50</td>
                </tr> 
                <tr>
                    <th>Interior Oven</th>
                    <td>$200</td>
                </tr>   
                
                </table>    
            </div>

            <h3 class='summary-labels'>Frequency</h3>
            <div class="frequency-div mb-4">
                <table class='frequency-table w-100'>
                <tr>
                    <th>Frequency:</th>
                    <td>One Time</td>
                </tr> 
                <tr>
                    <th>One Time price:</th>
                    <td>$200</td>
                </tr> 
                <tr>
                    <th>Biweekly Discount (10% off)</th>
                    <td>-$60.75</td>
                </tr>   
                </table>    
            </div>

            <div class="total-price-div">
                <table class='total-price-table w-100'>
                    <tr>
                        <th>Total</th>
                        <td>$500.00</td>
                    </tr>
                </table>
            </div>

            <?php if(auth()->guard()->check()): ?>
                        <?php if(Auth::user()->role !== 'admin'): ?>
                        <form action="<?php echo e(route('book.appointment')); ?>" method='POST'>
                            <?php echo csrf_field(); ?>
                           
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/2025 Projects/updatedecopros/resources/views/frontend/updated.blade.php ENDPATH**/ ?>