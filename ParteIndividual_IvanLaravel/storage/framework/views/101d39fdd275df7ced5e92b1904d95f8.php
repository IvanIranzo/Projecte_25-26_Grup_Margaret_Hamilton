<?php $__env->startSection('title', 'Group Rankings - ' . $group->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-4">Group Rankings: <?php echo e($group->name); ?></h1>
    <p class="text-gray-600 mb-6">Ranking of members in this group</p>
    
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Player</th>
                    <th class="px-6 py-3 text-left">Total Score</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $rankings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="<?php echo e(auth()->id() === $user->id ? 'bg-yellow-50' : ''); ?>">
                    <td class="px-6 py-4"><?php echo e($rankings->firstItem() + $i); ?></td>
                    <td class="px-6 py-4"><?php echo e($user->name); ?></td>
                    <td class="px-6 py-4"><?php echo e($user->quiz_attempts_sum_score ?? 0); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div class="px-6 py-4">
            <?php echo e($rankings->links()); ?>

        </div>
    </div>
    
    <div class="mt-6">
        <a href="<?php echo e(route('groups.index')); ?>" class="text-blue-600 hover:text-blue-800">← Back to Groups</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /root/quiz-app/resources/views/rankings/group.blade.php ENDPATH**/ ?>