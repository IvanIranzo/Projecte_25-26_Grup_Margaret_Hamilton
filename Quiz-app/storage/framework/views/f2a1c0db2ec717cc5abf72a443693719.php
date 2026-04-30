<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Quiz App'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow mb-6">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
<a href="<?php echo e(url('/')); ?>" class="flex items-center space-x-2">
    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo" class="h-8 w-auto">
    <span class="text-xl font-bold text-blue-600">Quiz App</span>
</a>
            <div class="space-x-4">
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('subjects.index')); ?>" class="text-gray-700 hover:text-blue-600">Subjects</a>
                    <a href="<?php echo e(route('rankings.global')); ?>" class="text-gray-700 hover:text-blue-600">Rankings</a>
                    <a href="<?php echo e(route('groups.index')); ?>" class="text-gray-700 hover:text-blue-600">Groups</a>
<a href="<?php echo e(route('quiz.random')); ?>" class="text-gray-700 hover:text-blue-600">🎲 Random Quiz</a>                    
<a href="<?php echo e(route('custom.my')); ?>" class="text-gray-700 hover:text-blue-600">📝 My Quizzes</a>
<form method="POST" action="<?php echo e(route('logout')); ?>" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="text-gray-700 hover:text-blue-600">Logout</button>
                    </form>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="text-gray-700 hover:text-blue-600">Login</a>
                    <a href="<?php echo e(route('register')); ?>" class="text-gray-700 hover:text-blue-600">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>
</body>
</html>
<?php /**PATH /root/quiz-app/resources/views/layouts/app.blade.php ENDPATH**/ ?>