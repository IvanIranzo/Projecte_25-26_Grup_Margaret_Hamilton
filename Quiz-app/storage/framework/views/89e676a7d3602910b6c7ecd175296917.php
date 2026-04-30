<?php $__env->startSection('title', 'Quiz Result'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow p-8 text-center">
        <h1 class="text-3xl font-bold mb-4">Quiz Results</h1>
        
        <div class="text-6xl font-bold mb-4">
            <?php echo e($attempt->score); ?> / <?php echo e($attempt->total_points); ?>

        </div>
        
        <p class="text-gray-600 mb-6">
            You scored <?php echo e(round(($attempt->score / $attempt->total_points) * 100)); ?>%
        </p>
        
        <a href="<?php echo e(route('subjects.index')); ?>" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            Back to Subjects
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /root/quiz-app/resources/views/quizzes/result.blade.php ENDPATH**/ ?>