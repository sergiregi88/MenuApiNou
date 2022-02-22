<?php $__env->startSection('title', 'Error Detected'); ?>
 <?php $__env->startSection('meta_tags'); ?>

<?php $__env->startSection('header'); ?>
    <h2>Error on App<h2 >
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <h1>Error Description</h1>
    <?php echo e($message); ?>

<?php $__env->stopSection(); ?>​


<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/error.blade.php ENDPATH**/ ?>