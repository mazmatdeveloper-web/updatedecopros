<?php $__currentLoopData = $cleaners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cleaner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="card mb-2 border-0" data-cleaner-id="<?php echo e($cleaner->id); ?>">
        <div class="card-body">
        <div class="cleaner-profile-box">
            <?php if($cleaner->profile_picture): ?>
                <img src="<?php echo e(asset('storage/' . $cleaner->profile_picture)); ?>" alt="Profile Picture" width="150">
            <?php endif; ?>
            <p class='cleanerId' style='display:none;'><?php echo e($cleaner->id); ?></p>
            <h4 class='cleanernames'><?php echo e($cleaner->name); ?> <span class="price-value"></span></h4>
        </div>    
            <?php if(!empty($cleaner->available_slots)): ?>
                <?php $__currentLoopData = $cleaner->available_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class='timeslotstext'><?php echo e($slot); ?></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <p class='notavailabletext'>Not available</p>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/2025 Projects/updatedecopros/resources/views/frontend/partials/cleaners.blade.php ENDPATH**/ ?>