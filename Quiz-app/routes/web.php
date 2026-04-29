<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\GroupController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
Route::get('/subjects/{subject}/quizzes', [QuizController::class, 'subjectQuizzes'])->name('subjects.quizzes');
    // Subjects & quizzes
    Route::get('/subjects', [QuizController::class, 'subjects'])->name('subjects.index');
    Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
    Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submit'])->name('quizzes.submit');
    Route::get('/attempts/{attempt}/result', [QuizController::class, 'result'])->name('quizzes.result');

    // Rankings
    Route::get('/rankings', [RankingController::class, 'global'])->name('rankings.global');
    Route::get('/groups/{group}/ranking', [RankingController::class, 'group'])->name('rankings.group');

    // Groups
    Route::resource('groups', GroupController::class);
    Route::post('/groups/{group}/join', [GroupController::class, 'join'])->name('groups.join');
    Route::delete('/groups/{group}/leave', [GroupController::class, 'leave'])->name('groups.leave');
    
    // Group management routes
Route::post('/groups/{group}/approve/{user}', [GroupController::class, 'approveRequest'])->name('groups.approve');
Route::delete('/groups/{group}/reject/{user}', [GroupController::class, 'rejectRequest'])->name('groups.reject');
Route::delete('/groups/{group}/remove/{user}', [GroupController::class, 'removeMember'])->name('groups.remove');
});

// Random quiz routes
Route::get('/quiz/random', [App\Http\Controllers\RandomQuizController::class, 'showGenerator'])->name('quiz.random');
Route::post('/quiz/random/generate', [App\Http\Controllers\RandomQuizController::class, 'generate'])->name('quiz.random.generate');
Route::get('/quiz/random/new', [App\Http\Controllers\RandomQuizController::class, 'getRandomQuiz'])->name('quiz.random.new');

// Custom quiz routes
Route::prefix('custom')->name('custom.')->group(function () {
    Route::get('/quiz/create/{subject?}', [App\Http\Controllers\CustomQuizController::class, 'create'])->name('quiz.create');
    Route::post('/quiz/store', [App\Http\Controllers\CustomQuizController::class, 'store'])->name('quiz.store');
    Route::get('/my-quizzes', [App\Http\Controllers\CustomQuizController::class, 'myQuizzes'])->name('my');
    Route::get('/quiz/{quiz}/edit', [App\Http\Controllers\CustomQuizController::class, 'edit'])->name('quiz.edit');
    Route::put('/quiz/{quiz}', [App\Http\Controllers\CustomQuizController::class, 'update'])->name('quiz.update');
    Route::delete('/quiz/{quiz}', [App\Http\Controllers\CustomQuizController::class, 'destroy'])->name('quiz.destroy');
    Route::post('/quiz/{quiz}/duplicate', [App\Http\Controllers\CustomQuizController::class, 'duplicate'])->name('quiz.duplicate');
});

require __DIR__.'/auth.php';
