<?php $__env->startSection('title', 'Create Custom Quiz'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Create Your Own Quiz</h1>
        
        <form action="<?php echo e(route('custom.quiz.store')); ?>" method="POST" id="quizForm">
            <?php echo csrf_field(); ?>
            
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Quiz Details</h2>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Subject *</label>
                    <select name="subject_id" required class="w-full px-3 py-2 border rounded-lg">
                        <option value="">Select Subject</option>
                        <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($subject->id); ?>" <?php echo e(isset($selectedSubject) && $selectedSubject->id == $subject->id ? 'selected' : ''); ?>>
                                <?php echo e($subject->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Quiz Title *</label>
                    <input type="text" name="title" required class="w-full px-3 py-2 border rounded-lg" placeholder="e.g., Advanced PHP Quiz">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full px-3 py-2 border rounded-lg" placeholder="Describe what this quiz is about..."></textarea>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Time Limit (seconds)</label>
                    <input type="number" name="duration_seconds" value="300" required class="w-full px-3 py-2 border rounded-lg" min="60" max="3600">
                    <p class="text-sm text-gray-500 mt-1">Minimum 60 seconds, maximum 3600 seconds (1 hour)</p>
                </div>
            </div>
            
            <div id="questions-container">
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Question 1</h2>
                        <button type="button" class="remove-question text-red-600 hover:text-red-800" style="display:none;">Remove</button>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Question Text *</label>
                        <input type="text" name="questions[0][content]" required class="w-full px-3 py-2 border rounded-lg" placeholder="Enter your question">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Points *</label>
                        <input type="number" name="questions[0][points]" value="10" required class="w-32 px-3 py-2 border rounded-lg" min="1" max="100">
                    </div>
                    
                    <div class="options-container">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Options *</label>
                        <div id="options-0">
                            <?php for($i = 0; $i < 4; $i++): ?>
                            <div class="flex items-center mb-2">
                                <input type="text" name="questions[0][options][<?php echo e($i); ?>][content]" required class="flex-1 px-3 py-2 border rounded-lg mr-2" placeholder="Option <?php echo e($i+1); ?>">
                                <label class="flex items-center">
                                    <input type="checkbox" name="questions[0][options][<?php echo e($i); ?>][is_correct]" value="1" class="mr-1">
                                    <span class="text-sm">Correct</span>
                                </label>
                            </div>
                            <?php endfor; ?>
                        </div>
                        <button type="button" class="add-option text-blue-600 hover:text-blue-800 text-sm" data-question="0">+ Add Option</button>
                    </div>
                </div>
            </div>
            
            <div class="flex space-x-3 mb-6">
                <button type="button" id="add-question" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                    + Add Another Question
                </button>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Create Quiz
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let questionCount = 1;

document.getElementById('add-question').addEventListener('click', function() {
    const container = document.getElementById('questions-container');
    const newQuestion = document.createElement('div');
    newQuestion.className = 'bg-white rounded-lg shadow p-6 mb-6';
    newQuestion.innerHTML = `
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Question ${questionCount + 1}</h2>
            <button type="button" class="remove-question text-red-600 hover:text-red-800">Remove</button>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Question Text *</label>
            <input type="text" name="questions[${questionCount}][content]" required class="w-full px-3 py-2 border rounded-lg">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Points *</label>
            <input type="number" name="questions[${questionCount}][points]" value="10" required class="w-32 px-3 py-2 border rounded-lg" min="1" max="100">
        </div>
        
        <div class="options-container">
            <label class="block text-gray-700 text-sm font-bold mb-2">Options *</label>
            <div id="options-${questionCount}">
                ${generateOptions(questionCount, 4)}
            </div>
            <button type="button" class="add-option text-blue-600 hover:text-blue-800 text-sm" data-question="${questionCount}">+ Add Option</button>
        </div>
    `;
    container.appendChild(newQuestion);
    questionCount++;
    
    // Add remove functionality
    newQuestion.querySelector('.remove-question').addEventListener('click', function() {
        newQuestion.remove();
    });
});

function generateOptions(questionIndex, count) {
    let html = '';
    for(let i = 0; i < count; i++) {
        html += `
            <div class="flex items-center mb-2">
                <input type="text" name="questions[${questionIndex}][options][${i}][content]" required class="flex-1 px-3 py-2 border rounded-lg mr-2" placeholder="Option ${i+1}">
                <label class="flex items-center">
                    <input type="checkbox" name="questions[${questionIndex}][options][${i}][is_correct]" value="1" class="mr-1">
                    <span class="text-sm">Correct</span>
                </label>
            </div>
        `;
    }
    return html;
}

// Add option functionality
document.addEventListener('click', function(e) {
    if(e.target.classList.contains('add-option')) {
        const questionIndex = e.target.dataset.question;
        const optionsContainer = document.getElementById(`options-${questionIndex}`);
        const optionCount = optionsContainer.children.length;
        
        const newOption = document.createElement('div');
        newOption.className = 'flex items-center mb-2';
        newOption.innerHTML = `
            <input type="text" name="questions[${questionIndex}][options][${optionCount}][content]" required class="flex-1 px-3 py-2 border rounded-lg mr-2" placeholder="Option ${optionCount + 1}">
            <label class="flex items-center">
                <input type="checkbox" name="questions[${questionIndex}][options][${optionCount}][is_correct]" value="1" class="mr-1">
                <span class="text-sm">Correct</span>
            </label>
            <button type="button" class="remove-option text-red-600 ml-2">×</button>
        `;
        optionsContainer.appendChild(newOption);
        
        newOption.querySelector('.remove-option').addEventListener('click', function() {
            newOption.remove();
        });
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /root/quiz-app/resources/views/quizzes/custom/create.blade.php ENDPATH**/ ?>