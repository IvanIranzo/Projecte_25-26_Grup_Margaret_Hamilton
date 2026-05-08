<?php $__env->startSection('title', 'Groups'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Groups</h1>
    
    <a href="<?php echo e(route('groups.create')); ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg mb-6 inline-block">
        + Create New Group
    </a>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $isMember = $group->users->contains(auth()->id());
            $hasPendingRequest = false;
            if (auth()->user()) {
                $hasPendingRequest = $group->users()
                    ->where('user_id', auth()->id())
                    ->wherePivot('status', 'pending')
                    ->exists();
            }
        ?>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-2"><?php echo e($group->name); ?></h2>
            <p class="text-gray-600 mb-4"><?php echo e($group->description ?? 'No description'); ?></p>
            <p class="text-sm text-gray-500 mb-2">Owner: <?php echo e($group->owner->name ?? 'Unknown'); ?></p>
            <p class="text-sm text-gray-500 mb-4">Members: <?php echo e($group->users->where('pivot.status', 'approved')->count()); ?></p>
            <?php if($group->is_private): ?>
                <p class="text-xs text-orange-600 mb-2">🔒 Private Group</p>
            <?php endif; ?>
            
            <div class="flex space-x-3">
                <a href="<?php echo e(route('groups.show', $group)); ?>" class="text-blue-600 hover:text-blue-800">View Group →</a>
                <a href="<?php echo e(route('rankings.group', $group)); ?>" class="text-green-600 hover:text-green-800">View Ranking →</a>
                
                <?php if(!$isMember && !$hasPendingRequest): ?>
                    <form action="<?php echo e(route('groups.join', $group)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="text-green-600 hover:text-green-800">
                            <?php echo e($group->is_private ? 'Request to Join' : 'Join'); ?>

                        </button>
                    </form>
                <?php elseif($hasPendingRequest): ?>
                    <span class="text-yellow-600">Pending Approval</span>
                <?php elseif($isMember): ?>
                    <form action="<?php echo e(route('groups.leave', $group)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="text-red-600 hover:text-red-800">Leave</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    
    <?php if(isset($myGroups) && $myGroups->count() > 0): ?>
    <div class="mt-12">
        <h2 class="text-2xl font-bold mb-4">My Groups</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php $__currentLoopData = $myGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-green-50 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-2"><?php echo e($group->name); ?></h3>
                <p class="text-sm text-gray-600 mb-2">Role: <?php echo e($group->pivot->role); ?></p>
                <a href="<?php echo e(route('groups.show', $group)); ?>" class="text-blue-600 hover:text-blue-800">Manage →</a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if(isset($pendingRequests) && $pendingRequests->count() > 0): ?>
    <div class="mt-12">
        <h2 class="text-2xl font-bold mb-4">Groups with Pending Requests</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php $__currentLoopData = $pendingRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-yellow-50 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-2"><?php echo e($group->name); ?></h3>
                <p class="text-sm text-gray-600 mb-2">Status: <?php echo e($group->pivot->status); ?></p>
                <a href="<?php echo e(route('groups.show', $group)); ?>" class="text-blue-600 hover:text-blue-800">View →</a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /root/quiz-app/resources/views/groups/index.blade.php ENDPATH**/ ?>