<?php $__env->startSection('title', $quiz->title); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-4"><?php echo e($quiz->title); ?></h1>
    <p class="text-gray-600 mb-6">Time limit: <?php echo e($quiz->duration_seconds / 60); ?> minutes</p>
    
    <form action="<?php echo e(route('quizzes.submit', $quiz)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        
        <?php $__currentLoopData = $quiz->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white rounded-lg shadow p-6 mb-4">
            <h3 class="text-lg font-semibold mb-4">Question <?php echo e($index + 1); ?>: <?php echo e($question->content); ?></h3>
            <p class="text-sm text-gray-500 mb-3">Points: <?php echo e($question->points); ?></p>
            
            <div class="space-y-2">
                <?php $__currentLoopData = $question->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="flex items-center space-x-3">
                    <input type="radio" name="answers[<?php echo e($question->id); ?>]" value="<?php echo e($option->id); ?>" class="form-radio">
                    <span><?php echo e($option->content); ?></span>
                </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            Submit Quiz
        </button>
    </form>
</div>
<?php if($quiz->is_custom): ?>
    <div class="bg-purple-50 p-4 rounded-lg mb-4">
        <p class="text-purple-800">
            ✨ Custom Quiz created by <?php echo e($quiz->creator->name ?? 'Unknown'); ?>

        </p>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /root/quiz-app/resources/views/quizzes/show.blade.php ENDPATH**/ ?>