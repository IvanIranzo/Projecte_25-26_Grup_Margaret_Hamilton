<?php $__env->startSection('title', 'My Custom Quizzes'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">My Custom Quizzes</h1>
        <a href="<?php echo e(route('custom.quiz.create')); ?>" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
            + Create New Quiz
        </a>
    </div>
    
    <?php if($quizzes->count() > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $quizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-xl font-semibold text-purple-800"><?php echo e($quiz->title); ?></h2>
                    <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded">Custom</span>
                </div>
                
                <p class="text-gray-600 text-sm mb-4"><?php echo e($quiz->description ?? 'No description'); ?></p>
                
                <div class="space-y-2 text-sm mb-4">
                    <p><strong>Subject:</strong> <?php echo e($quiz->subject->name); ?></p>
                    <p><strong>Questions:</strong> <?php echo e($quiz->questions->count()); ?></p>
                    <p><strong>Total Points:</strong> <?php echo e($quiz->total_points); ?></p>
                    <p><strong>Time Limit:</strong> <?php echo e(floor($quiz->duration_seconds / 60)); ?> minutes</p>
                    <p><strong>Plays:</strong> <?php echo e($quiz->plays_count ?? 0); ?></p>
                    <?php if($quiz->average_score): ?>
                        <p><strong>Avg Score:</strong> <?php echo e(number_format($quiz->average_score, 1)); ?>%</p>
                    <?php endif; ?>
                    <p><strong>Created:</strong> <?php echo e($quiz->created_at->diffForHumans()); ?></p>
                </div>
                
                <div class="flex space-x-2">
                    <a href="<?php echo e(route('quizzes.show', $quiz)); ?>" class="flex-1 text-center bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 text-sm">
                        Take Quiz
                    </a>
                    <a href="<?php echo e(route('custom.quiz.edit', $quiz)); ?>" class="flex-1 text-center bg-yellow-600 text-white px-3 py-2 rounded-lg hover:bg-yellow-700 text-sm">
                        Edit
                    </a>
                    <form action="<?php echo e(route('custom.quiz.destroy', $quiz)); ?>" method="POST" class="flex-1">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="w-full bg-red-600 text-white px-3 py-2 rounded-lg hover:bg-red-700 text-sm" onclick="return confirm('Are you sure you want to delete this quiz?')">
                            Delete
                        </button>
                    </form>
                </div>
                
                <div class="mt-3">
                    <form action="<?php echo e(route('custom.quiz.duplicate', $quiz)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-full text-gray-600 hover:text-purple-600 text-sm">
                            📋 Duplicate Quiz
                        </button>
                    </form>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <div class="mt-6">
            <?php echo e($quizzes->links()); ?>

        </div>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <div class="text-6xl mb-4">📝</div>
            <h2 class="text-2xl font-semibold mb-4">No Custom Quizzes Yet</h2>
            <p class="text-gray-600 mb-6">You haven't created any custom quizzes. Create your first quiz now!</p>
            <a href="<?php echo e(route('custom.quiz.create')); ?>" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700">
                Create Your First Quiz
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /root/quiz-app/resources/views/quizzes/custom/my.blade.php ENDPATH**/ ?>