<?php $__env->startSection('title', 'Create Group'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Create New Group</h1>
    
    <form action="<?php echo e(route('groups.store')); ?>" method="POST" class="bg-white rounded-lg shadow p-6 max-w-lg">
        <?php echo csrf_field(); ?>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Group Name *</label>
            <input type="text" name="name" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
            <textarea name="description" rows="4" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"></textarea>
        </div>
        
        <div class="mb-6">
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" name="is_private" value="1" class="mr-2 w-4 h-4">
                <span class="text-gray-700">🔒 Private Group (users need approval to join)</span>
            </label>
            <p class="text-sm text-gray-500 mt-1 ml-6">If unchecked, the group will be public and anyone can join instantly.</p>
        </div>
        
        <div class="flex space-x-3">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                Create Group
            </button>
            <a href="<?php echo e(route('groups.index')); ?>" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">
                Cancel
            </a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /root/quiz-app/resources/views/groups/create.blade.php ENDPATH**/ ?>