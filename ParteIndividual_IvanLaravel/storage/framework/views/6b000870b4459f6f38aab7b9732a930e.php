<?php $__env->startSection('title', $group->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold mb-2"><?php echo e($group->name); ?></h1>
            <?php if($group->is_private): ?>
                <span class="inline-block bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded">🔒 Private Group</span>
            <?php else: ?>
                <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded">🌍 Public Group</span>
            <?php endif; ?>
        </div>
        
        <?php if(auth()->id() === $group->owner_id): ?>
            <div class="space-x-2">
                <a href="<?php echo e(route('groups.edit', $group)); ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Edit Group
                </a>
                <form action="<?php echo e(route('groups.destroy', $group)); ?>" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700" onclick="return confirm('Are you sure you want to delete this group?')">
                        Delete Group
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>
    
    <p class="text-gray-600 mb-6"><?php echo e($group->description ?? 'No description provided.'); ?></p>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Group Information</h2>
            <div class="space-y-2">
                <p><strong>👑 Owner:</strong> <?php echo e($group->owner->name ?? 'Unknown'); ?></p>
                <p><strong>📅 Created:</strong> <?php echo e($group->created_at->format('F j, Y')); ?></p>
                <p><strong>👥 Total Members:</strong> <?php echo e($group->users->count()); ?></p>
                <p><strong>🔒 Privacy:</strong> <?php echo e($group->is_private ? 'Private (approval required)' : 'Public (anyone can join)'); ?></p>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
            <div class="space-y-2">
                <a href="<?php echo e(route('rankings.group', $group)); ?>" class="block text-blue-600 hover:text-blue-800">
                    📊 View Group Rankings →
                </a>
                
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
                
                <?php if($isMember): ?>
                    <form action="<?php echo e(route('groups.leave', $group)); ?>" method="POST" class="inline-block w-full">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="text-red-600 hover:text-red-800 w-full text-left" onclick="return confirm('Are you sure you want to leave this group?')">
                            🚪 Leave Group
                        </button>
                    </form>
                <?php elseif($hasPendingRequest): ?>
                    <div class="text-yellow-600">
                        ⏳ Pending Approval - Your request to join is waiting for owner approval
                    </div>
                <?php else: ?>
                    <form action="<?php echo e(route('groups.join', $group)); ?>" method="POST" class="inline-block w-full">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="text-green-600 hover:text-green-800 w-full text-left">
                            <?php echo e($group->is_private ? '✉️ Request to Join' : '✅ Join Group'); ?>

                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Pending Join Requests (Owner only) -->
    <?php if(auth()->id() === $group->owner_id && isset($pendingRequests) && $pendingRequests->count() > 0): ?>
    <div class="mt-6 bg-yellow-50 rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Pending Join Requests (<?php echo e($pendingRequests->count()); ?>)</h2>
        <div class="divide-y">
            <?php $__currentLoopData = $pendingRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="py-3 flex justify-between items-center">
                <div>
                    <span class="font-medium"><?php echo e($user->name); ?></span>
                    <span class="text-sm text-gray-500 ml-2">
                        Requested: 
                        <?php if($user->pivot->requested_at): ?>
                            <?php echo e(\Carbon\Carbon::parse($user->pivot->requested_at)->diffForHumans()); ?>

                        <?php else: ?>
                            Recently
                        <?php endif; ?>
                    </span>
                </div>
                <div class="space-x-2">
                    <form action="<?php echo e(route('groups.approve', [$group, $user])); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                            ✓ Approve
                        </button>
                    </form>
                    <form action="<?php echo e(route('groups.reject', [$group, $user])); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                            ✗ Reject
                        </button>
                    </form>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Members List -->
    <div class="mt-6 bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Group Members (<?php echo e($group->users->count()); ?>)</h2>
        <div class="divide-y">
            <?php $__currentLoopData = $group->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="py-3 flex justify-between items-center">
                <div>
                    <span class="font-medium"><?php echo e($member->name); ?></span>
                    <span class="text-sm text-gray-500 ml-2">
                        <?php if($member->pivot->role === 'owner'): ?>
                            👑 Owner
                        <?php else: ?>
                            👤 <?php echo e(ucfirst($member->pivot->role)); ?>

                        <?php endif; ?>
                    </span>
                    <?php if($member->pivot->approved_at): ?>
                        <span class="text-xs text-gray-400 ml-2">
                            Joined: <?php echo e(\Carbon\Carbon::parse($member->pivot->approved_at)->format('M j, Y')); ?>

                        </span>
                    <?php endif; ?>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-gray-600">
                        🏆 Total Score: <?php echo e($member->quizAttempts()->sum('score')); ?>

                    </div>
                    
                    <?php if(auth()->id() === $group->owner_id && $member->id !== $group->owner_id): ?>
                    <form action="<?php echo e(route('groups.remove', [$group, $member])); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('Remove <?php echo e($member->name); ?> from the group?')">
                            Remove
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    
    <div class="mt-6">
        <a href="<?php echo e(route('groups.index')); ?>" class="text-blue-600 hover:text-blue-800">← Back to All Groups</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /root/quiz-app/resources/views/groups/show.blade.php ENDPATH**/ ?>