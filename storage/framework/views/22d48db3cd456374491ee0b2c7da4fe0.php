<div class="row d-flex justify-content-center align-items-stretch">
                
                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <div class="col-md-5">
                <div class="card mb-2 border-0 h-100" data-employee-id="<?php echo e($employee->id); ?>">
                            <div class="card-body mb-2">
                            <div class="employee-profile-box d-flex align-items-center justify-content-between">
                                <div class="employee-name d-flex align-items-center gap-2">
                                    <?php if($employee->profile_picture): ?>
                                        <img src="<?php echo e(asset('storage/' . $employee->profile_picture)); ?>" alt="Profile Picture" width="150">
                                    <?php endif; ?>
                                    <p class='employeeId' style='display:none;'><?php echo e($employee->id); ?></p>
                                    <div>
                                        <h4 class='employeenames mb-0'><?php echo e($employee->name); ?> </h4>
                                    <?php if(!empty($employee->available_slots)): ?>    
                                        <span class='avialable-badge'>Available</span>
                                    <?php endif; ?>
                                    </div>
                                </div>
                            <div>
                                <span class='base_price'></span>
                                <span class="price-value"></span>
                            </div>
                            </div>    
                                <?php if(!empty($employee->available_slots)): ?>
                                    <?php $__currentLoopData = $employee->available_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class='timeslotstext' 
                                        data-slot="<?php echo e($slot); ?>" 
                                        data-employee-id="<?php echo e($employee->id); ?>">
                                        <?php echo e($slot); ?>

                                    </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <p class='notavailabletext'>Not available</p>
                                <?php endif; ?>
                            </div>
                        </div>
                </div>
                      
                
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                </div><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/2025 Projects/A1ClassicGarage/resources/views/frontend/partials/employees.blade.php ENDPATH**/ ?>