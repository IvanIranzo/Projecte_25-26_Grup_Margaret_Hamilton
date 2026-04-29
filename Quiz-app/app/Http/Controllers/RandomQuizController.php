<?php

namespace App\Http\Controllers;

use App\Services\QuizApiService;
use App\Models\Subject;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class RandomQuizController extends Controller
{
    public function showGenerator()
    {
        $categories = [
            '9' => 'General Knowledge',
            '17' => 'Science & Nature',
            '18' => 'Computers',
            '19' => 'Mathematics',
            '23' => 'History',
            '22' => 'Geography',
            '25' => 'Arts',
            '21' => 'Sports',
        ];
        
        // Get recently created random quizzes
        $recentQuizzes = Quiz::where('is_custom', false)
            ->where('title', 'like', '🎲 Random Quiz%')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('quizzes.random', compact('categories', 'recentQuizzes'));
    }
    
public function generate(Request $request)
{
    $request->validate([
        'subject' => 'required|string|max:255',
        'difficulty' => 'nullable|in:easy,medium,hard',
        'question_count' => 'required|integer|min:5|max:50',
        'category' => 'nullable|string',
    ]);
    
    // Get or create subject
    $subject = Subject::firstOrCreate(
        ['slug' => \Str::slug($request->subject)],
        [
            'name' => $request->subject,
            'icon' => $this->getRandomIcon(),
        ]
    );
    
    // Fetch questions from API
    $questions = QuizApiService::fetchOpenTrivia(
        $request->category,
        $request->difficulty,
        $request->question_count
    );
    
    if (empty($questions)) {
        return back()->with('error', 'Could not fetch questions. Please try again.');
    }
    
    // Create a permanent quiz with user ID
    $quiz = Quiz::create([
        'subject_id' => $subject->id,
        'title' => "🎲 Random Quiz: " . $request->subject,
        'description' => "Random quiz generated on " . now()->format('F j, Y \a\t H:i') . 
                        "\nDifficulty: " . ($request->difficulty ?? 'Any') .
                        "\nCategory: " . ($request->category ?? 'Any'),
        'duration_seconds' => $request->question_count * 30,
        'total_points' => 0,
        'is_published' => true,
        'is_custom' => false,
        'created_by' => Auth::id(),
    ]);
    
    $totalPoints = 0;
    
    foreach ($questions as $index => $q) {
        $question = Question::create([
            'quiz_id' => $quiz->id,
            'content' => $q['content'],
            'points' => $q['points'],
            'order' => $index + 1,
        ]);
        
        foreach ($q['options'] as $option) {
            Option::create([
                'question_id' => $question->id,
                'content' => $option['content'],
                'is_correct' => $option['is_correct'],
            ]);
        }
        
        $totalPoints += $q['points'];
    }
    
    $quiz->update(['total_points' => $totalPoints]);
    
    return redirect()->route('quizzes.show', $quiz)
        ->with('success', 'Random quiz generated and saved to your account!');
}
    public function saveCurrentQuiz(Request $request, Quiz $quiz)
    {
        // If quiz is temporary, save it permanently
        if (!$quiz->created_by) {
            $quiz->update([
                'created_by' => Auth::id(),
                'title' => $quiz->title . " (Saved)",
                'is_published' => true,
            ]);
            
            return redirect()->route('quizzes.show', $quiz)
                ->with('success', 'Quiz saved to your account!');
        }
        
        return redirect()->route('quizzes.show', $quiz);
    }
    
    private function getRandomIcon()
    {
        $icons = ['🎯', '📚', '🔬', '🎨', '💻', '🌍', '⚡', '🎮', '🧠', '🏆'];
        return $icons[array_rand($icons)];
    }
}
