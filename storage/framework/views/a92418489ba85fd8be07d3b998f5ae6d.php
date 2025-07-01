<aside class="sidebar">
  <button type="button" class="sidebar-close-btn">
    <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
  </button>
  <div>
    <a href="#" class="sidebar-logo">
      <img src="<?php echo e(asset('ecoproz-logo.png')); ?>" alt="EcoProz Logo" class="light-logo">
      <img src="<?php echo e(asset('ecoproz-logo.png')); ?>" alt="EcoProz Logo" class="dark-logo">
      <img src="<?php echo e(asset('ecoproz-logo.png')); ?>" alt="EcoProz Logo" class="logo-icon">
    </a>
  </div>
  <div class="sidebar-menu-area">
    <ul class="sidebar-menu" id="sidebar-menu">
      <li>
        <a href="<?php echo e(route('dashboard')); ?>">
          <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
          <span>Dashboard</span>
        </a>
      </li>
      <li>
        <a href="<?php echo e(route('all.cleaners')); ?>">
        <iconify-icon icon="solar:user-linear" class="menu-icon"></iconify-icon>
          <span>Cleaners</span>
        </a>
      </li>
      <li>
        <a href="<?php echo e(route('add.cleaner.availability')); ?>">
        <iconify-icon icon="solar:calendar-outline" class="menu-icon"></iconify-icon>
          <span>Availability</span>
        </a>
      </li>

      <li>
        <a href="<?php echo e(route('add.zipcode')); ?>">
        <iconify-icon icon="material-symbols:map-outline" class="menu-icon"></iconify-icon>
          <span>Zipcodes</span>
        </a>
      </li>
      <li>
        <a href="<?php echo e(route('addons')); ?>">
        <iconify-icon icon="material-symbols:map-outline" class="menu-icon"></iconify-icon>
          <span>Addons</span>
        </a>
      </li>
      <li>
        <a href="<?php echo e(route('appointments')); ?>">
        <iconify-icon icon="solar:calendar-outline" class="menu-icon"></iconify-icon>
          <span>Appointments</span>
        </a>
      </li>
      <li>
        <a href="<?php echo e(route('all.customers')); ?>">
        <iconify-icon icon="solar:user-linear" class="menu-icon"></iconify-icon>
          <span>Customers</span>
        </a>
      </li>
    </ul>
  </div>

</aside>

<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/2025 Projects/updatedecopros/resources/views/admin/layouts/sidebar.blade.php ENDPATH**/ ?>