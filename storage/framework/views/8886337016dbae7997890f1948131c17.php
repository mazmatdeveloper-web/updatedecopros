<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EcoProz Admin</title>
  <link rel="icon" type="image/png" href="<?php echo e(asset('assets/images/favicon.png')); ?>" sizes="16x16">

  <!-- remix icon font css  -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/remixicon.css')); ?>">
  <!-- BootStrap css -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/lib/bootstrap.min.css')); ?>">
  <!-- Apex Chart css -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/lib/apexcharts.css')); ?>">
  <!-- Data Table css -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/lib/dataTables.min.css')); ?>">
  <!-- Text Editor css -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/lib/editor-katex.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/lib/editor.atom-one-dark.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/lib/editor.quill.snow.css')); ?>">
  <!-- Date picker css -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/lib/flatpickr.min.css')); ?>">
  <!-- Calendar css -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/lib/full-calendar.css')); ?>">
  <!-- Vector Map css -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/lib/jquery-jvectormap-2.0.5.css')); ?>">
  <!-- Popup css -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/lib/magnific-popup.css')); ?>">
  <!-- Slick Slider css -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/lib/slick.css')); ?>">
  <!-- prism css -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/lib/prism.css')); ?>">
  <!-- file upload css -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/lib/file-upload.css')); ?>">
  
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/lib/audioplayer.css')); ?>">
  <!-- main css -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
 
  <style>
    h2#swal2-title {
    font-size: 15px !important;
    color: black;
    font-weight: 700;
}
.swal2-container.swal2-top-end.swal2-backdrop-show {
    width: 27rem !important;
}
.swal2-toast div:where(.swal2-html-container) {
    font-size: 13px !important;
    font-weight: 700;
    color: red;
    line-height: 1.5em;
}
  </style>

  

</head>
<body>
    <div class="dashboard-main">
        <?php echo $__env->make('admin.layouts.topbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('admin.layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="dashboard-main-body">
            <?php echo $__env->yieldContent('admin_content'); ?>
        </div>   
    </div>

  
     <!-- jQuery library js -->
 <script src="<?php echo e(asset('assets/js/lib/jquery-3.7.1.min.js')); ?>"></script>

    <!-- Apex Chart js -->
    <script src="<?php echo e(asset('assets/js/lib/apexcharts.min.js')); ?>"></script>
    <!-- Data Table js -->
    <script src="<?php echo e(asset('assets/js/lib/dataTables.min.js')); ?>"></script>
    <!-- Iconify Font js -->
    <script src="<?php echo e(asset('assets/js/lib/iconify-icon.min.js')); ?>"></script>
    <!-- jQuery UI js -->
    <script src="<?php echo e(asset('assets/js/lib/jquery-ui.min.js')); ?>"></script>
    <!-- Vector Map js -->
    <script src="<?php echo e(asset('assets/js/lib/jquery-jvectormap-2.0.5.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/lib/jquery-jvectormap-world-mill-en.js')); ?>"></script>
    <!-- Popup js -->
    <script src="<?php echo e(asset('assets/js/lib/magnifc-popup.min.js')); ?>"></script>
    <!-- Slick Slider js -->
    <script src="<?php echo e(asset('assets/js/lib/slick.min.js')); ?>"></script>
    <!-- Prism js -->
    <script src="<?php echo e(asset('assets/js/lib/prism.js')); ?>"></script>
    <!-- File upload js -->
    <script src="<?php echo e(asset('assets/js/lib/file-upload.js')); ?>"></script>
    <!-- Audio Player js -->
    <script src="<?php echo e(asset('assets/js/lib/audioplayer.js')); ?>"></script>
   
    <!-- Custom chart js -->
    <script src="<?php echo e(asset('assets/js/homeOneChart.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/app.js')); ?>"></script>
    <?php echo $__env->make('sweetalert::alert', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/2025 Projects/updatedecopros/resources/views/admin/layouts/app.blade.php ENDPATH**/ ?>