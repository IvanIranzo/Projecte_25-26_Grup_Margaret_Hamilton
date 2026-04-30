<?php $__env->startSection('title', $subject->name . ' - All Quizzes'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="<?php echo e(route('subjects.index')); ?>" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
            ← Back to Subjects
        </a>
        <h1 class="text-3xl font-bold"><?php echo e($subject->name); ?></h1>
        <p class="text-gray-600 mt-2">All available quizzes in this subject</p>
    </div>
    
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quiz</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Questions</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Points</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $quizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $isCompleted = in_array($quiz->id, $completedQuizzes);
                    ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900"><?php echo e($quiz->title); ?></div>
                            <?php if($quiz->description): ?>
                                <div class="text-sm text-gray-500"><?php echo e(Str::limit($quiz->description, 100)); ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <?php echo e($quiz->questions->count()); ?>

                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <?php echo e($quiz->total_points); ?>

                        </td>
                        <td class="px-6 py-4">
                            <?php if($isCompleted): ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    ✅ Completed
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    📝 Pending
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php if(!$isCompleted): ?>
                                <a href="<?php echo e(route('quizzes.show', $quiz)); ?>" 
                                   class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    Take Quiz
                                </a>
                            <?php else: ?>
                                <span class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-gray-400 bg-gray-100">
                                    Completed
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            No quizzes available in this subject yet.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">
        <div class="bg-blue-50 rounded-lg p-4">
            <p class="text-blue-800 text-sm">
                💡 <strong>Note:</strong> Each quiz can only be taken once. 
                Completed quizzes will show as "Completed" and cannot be retaken.
            </p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /root/quiz-app/resources/views/subjects/quizzes.blade.php ENDPATH**/ ?>