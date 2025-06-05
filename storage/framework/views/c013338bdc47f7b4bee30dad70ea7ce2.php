<?php $__env->startSection('content'); ?>

<div class="container">
    <h4 class='my-3 text-center'>Confirm Service</h4>
    <div class="row d-flex align-items-center justify-content-center">
        <div class="col-md-7">
           <div class="row py-5">
                <div class="col-md-7">
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

                    <?php if(!Auth::check()): ?>
                    <div class="login-btns-div">
                    <button type='button' class='loginbtn' data-bs-toggle="modal" data-bs-target="#pill-modal">
                           Login & Confirm
                        </button>
                    </div>
                    <?php else: ?>
                    <button class='continuebtn'>Continue</button>
                    <?php endif; ?>
                    
                </div>
           </div>
        </div>
    </div>
</div>


<div class="modal fade" id="pill-modal" tabindex="-1" aria-labelledby="pillModalLabel" aria-hidden="true"
        data-bs-keyboard="true">
        <div class="modal-dialog modal-dialog-centered pillmodal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pillModalLabel">Log In</h5>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('manual.login')); ?>" class="login-form" method='POST'>
                        <?php echo csrf_field(); ?>
                       <div class='form-group'>
                            <label for="">Email</label><br>
                            <input type="email" name='email' placeholder='Email Address' class='w-100'>
                       </div>
                       <div class='form-group mt-2'>
                            <label for="">Password</label><br>
                            <input type="password" name='password' placeholder='******' class='w-100'>
                       </div>
                       <button class='loginbtn' type='submit'>Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/2025 Projects/updatedecopros/resources/views/frontend/quote-checkout.blade.php ENDPATH**/ ?>