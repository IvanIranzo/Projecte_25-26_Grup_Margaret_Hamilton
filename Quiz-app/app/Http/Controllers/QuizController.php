<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Answer;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function subjects()
    {
        $subjects = Subject::with(['quizzes' => function($query) {
            $query->where('is_published', true);
        }])->has('quizzes')->get();
        
        return view('subjects.index', compact('subjects'));
    }
    
    public function show(Quiz $quiz)
    {
        // Check if user already took this quiz
        if (QuizAttempt::hasTaken(Auth::id(), $quiz->id)) {
            return redirect()->route('subjects.index')
                ->with('error', 'You have already completed this quiz. You can only take each quiz once!');
        }
        
        $quiz->load('questions.options');
        return view('quizzes.show', compact('quiz'));
    }

public function subjectQuizzes(Subject $subject)
{
    $quizzes = $subject->quizzes()
        ->where('is_published', true)
        ->withCount('attempts')
        ->get();
    
    // Get user's completed quizzes
    $completedQuizzes = QuizAttempt::where('user_id', Auth::id())
        ->whereIn('quiz_id', $quizzes->pluck('id'))
        ->pluck('quiz_id')
        ->toArray();
    
    return view('subjects.quizzes', compact('subject', 'quizzes', 'completedQuizzes'));
}
    
    public function submit(Request $request, Quiz $quiz)
    {
        // Check if user already took this quiz
        if (QuizAttempt::hasTaken(Auth::id(), $quiz->id)) {
            return redirect()->route('subjects.index')
                ->with('error', 'You have already completed this quiz. You cannot submit it again!');
        }
        
        $answers = $request->input('answers', []);
        $score = 0;
        
        // Calculate score - each question only once
        foreach ($answers as $questionId => $optionId) {
            $option = Option::find($optionId);
            if ($option && $option->is_correct) {
                $question = Question::find($questionId);
                $score += $question->points;
            }
        }
        
        // Make sure score doesn't exceed total points
        $total_points = $quiz->questions()->sum('points');
        
        // Create attempt
        $attempt = QuizAttempt::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'score' => $score,
            'total_points' => $total_points,
            'completed_at' => now(),
        ]);
        
        // Save individual answers
        foreach ($answers as $questionId => $optionId) {
            $option = Option::find($optionId);
            Answer::create([
                'quiz_attempt_id' => $attempt->id,
                'question_id' => $questionId,
                'option_id' => $optionId,
                'is_correct' => $option->is_correct ?? false,
            ]);
        }
        
        return redirect()->route('quizzes.result', $attempt);
    }
    
    public function result(QuizAttempt $attempt)
    {
        // Make sure user can only see their own results
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('quizzes.result', compact('attempt'));
    }
}
