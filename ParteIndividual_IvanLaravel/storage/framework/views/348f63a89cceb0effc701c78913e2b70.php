<?php $__env->startSection('title', 'Subjects'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Subjects</h1>
        <div class="space-x-3">
            <a href="<?php echo e(route('quiz.random')); ?>" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 inline-block">
                🎲 Random Quiz
            </a>
            <a href="<?php echo e(route('custom.quiz.create')); ?>" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 inline-block">
                + Create Custom Quiz
            </a>
        </div>
    </div>
    
    <?php if($subjects->count() > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="p-6">
                    <div class="text-5xl mb-4"><?php echo e($subject->icon ?? '📚'); ?></div>
                    <h2 class="text-2xl font-bold mb-2"><?php echo e($subject->name); ?></h2>
                    <p class="text-gray-600 mb-4"><?php echo e($subject->quizzes->count()); ?> quiz(zes) available</p>
                    
                    <?php if($subject->quizzes->count() > 0): ?>
                        <div class="space-y-2 mb-4">
                            <?php $__currentLoopData = $subject->quizzes->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $hasTaken = App\Models\QuizAttempt::hasTaken(auth()->id(), $quiz->id);
                                ?>
                                
                                <?php if($hasTaken): ?>
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-400 line-through text-sm">📝 <?php echo e($quiz->title); ?></span>
                                        <span class="text-green-600 text-xs">✅ Completed</span>
                                    </div>
                                <?php else: ?>
                                    <a href="<?php echo e(route('quizzes.show', $quiz)); ?>" class="block text-blue-600 hover:text-blue-800 text-sm">
                                        📝 <?php echo e($quiz->title); ?>

                                    </a>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($subject->quizzes->count() > 5): ?>
                                <p class="text-gray-500 text-sm">And <?php echo e($subject->quizzes->count() - 5); ?> more...</p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mt-4 pt-4 border-t">
<a href="<?php echo e(route('subjects.quizzes', $subject)); ?>" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                            View all quizzes →
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <div class="text-6xl mb-4">📚</div>
            <h2 class="text-2xl font-semibold mb-4">No Subjects Available</h2>
            <p class="text-gray-600 mb-6">Create a random quiz or custom quiz to get started!</p>
            <div class="space-x-3">
                <a href="<?php echo e(route('quiz.random')); ?>" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 inline-block">
                    🎲 Generate Random Quiz
                </a>
                <a href="<?php echo e(route('custom.quiz.create')); ?>" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 inline-block">
                    + Create Custom Quiz
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /root/quiz-app/resources/views/subjects/index.blade.php ENDPATH**/ ?>