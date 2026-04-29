<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomQuizController extends Controller
{
    public function create(Subject $subject = null)
    {
        $subjects = Subject::all();
        return view('quizzes.custom.create', compact('subjects', 'subject'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_seconds' => 'required|integer|min:60|max:3600',
            'questions' => 'required|array|min:1|max:50',
            'questions.*.content' => 'required|string',
            'questions.*.points' => 'required|integer|min:1|max:100',
            'questions.*.options' => 'required|array|min:2|max:6',
            'questions.*.options.*.content' => 'required|string',
            'questions.*.options.*.is_correct' => 'boolean',
        ]);
        
        // Ensure each question has at least one correct answer
        foreach ($request->questions as $question) {
            $hasCorrect = collect($question['options'])->contains('is_correct', true);
            if (!$hasCorrect) {
                return back()->withErrors(['questions' => 'Each question must have at least one correct answer']);
            }
        }
        
        $quiz = Quiz::create([
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'description' => $request->description,
            'duration_seconds' => $request->duration_seconds,
            'total_points' => 0,
            'is_published' => true,
            'is_custom' => true,
            'created_by' => Auth::id(),
        ]);
        
        $totalPoints = 0;
        
        foreach ($request->questions as $index => $qData) {
            $question = Question::create([
                'quiz_id' => $quiz->id,
                'content' => $qData['content'],
                'points' => $qData['points'],
                'order' => $index + 1,
            ]);
            
            foreach ($qData['options'] as $option) {
                Option::create([
                    'question_id' => $question->id,
                    'content' => $option['content'],
                    'is_correct' => $option['is_correct'] ?? false,
                ]);
            }
            
            $totalPoints += $qData['points'];
        }
        
        $quiz->update(['total_points' => $totalPoints]);
        
        return redirect()->route('quizzes.show', $quiz)
            ->with('success', 'Quiz created successfully! Share it with your friends!');
    }
    
    public function edit(Quiz $quiz)
    {
        // Only allow editing if user created it
        if ($quiz->created_by !== Auth::id()) {
            abort(403, 'You can only edit your own quizzes.');
        }
        
        $subjects = Subject::all();
        return view('quizzes.custom.edit', compact('quiz', 'subjects'));
    }
    
    public function update(Request $request, Quiz $quiz)
    {
        if ($quiz->created_by !== Auth::id()) {
            abort(403);
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_seconds' => 'required|integer|min:60|max:3600',
        ]);
        
        $quiz->update([
            'title' => $request->title,
            'description' => $request->description,
            'duration_seconds' => $request->duration_seconds,
        ]);
        
        return redirect()->route('quizzes.show', $quiz)
            ->with('success', 'Quiz updated successfully!');
    }
    
    public function destroy(Quiz $quiz)
    {
        if ($quiz->created_by !== Auth::id()) {
            abort(403);
        }
        
        $quiz->delete();
        
        return redirect()->route('subjects.index')
            ->with('success', 'Quiz deleted successfully!');
    }
    
    public function myQuizzes()
    {
        $quizzes = Quiz::where('created_by', Auth::id())
            ->with('subject')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('quizzes.custom.my', compact('quizzes'));
    }
    
    public function duplicate(Quiz $quiz)
    {
        // Create a copy of the quiz
        $newQuiz = $quiz->replicate();
        $newQuiz->title = $quiz->title . ' (Copy)';
        $newQuiz->created_by = Auth::id();
        $newQuiz->is_custom = true;
        $newQuiz->plays_count = 0;
        $newQuiz->average_score = null;
        $newQuiz->save();
        
        // Duplicate questions and options
        foreach ($quiz->questions as $question) {
            $newQuestion = $question->replicate();
            $newQuestion->quiz_id = $newQuiz->id;
            $newQuestion->save();
            
            foreach ($question->options as $option) {
                $newOption = $option->replicate();
                $newOption->question_id = $newQuestion->id;
                $newOption->save();
            }
        }
        
        return redirect()->route('quizzes.edit', $newQuiz)
            ->with('success', 'Quiz duplicated! You can now edit it.');
    }
}
