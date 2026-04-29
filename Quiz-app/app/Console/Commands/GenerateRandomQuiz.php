<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\QuizApiService;
use App\Models\Quiz;
use App\Models\Subject;
use App\Models\Question;
use App\Models\Option;

class GenerateRandomQuiz extends Command
{
    protected $signature = 'quiz:generate 
                            {--subject= : Subject name}
                            {--difficulty= : easy/medium/hard}
                            {--questions=10 : Number of questions}
                            {--category= : Category from API}';
    
    protected $description = 'Generate a random quiz from API';
    
    public function handle()
    {
        $subjectName = $this->option('subject') ?? 'Random Quiz';
        $difficulty = $this->option('difficulty');
        $questionCount = $this->option('questions');
        $category = $this->option('category');
        
        // Get or create subject
        $subject = Subject::firstOrCreate(
            ['slug' => \Str::slug($subjectName)],
            [
                'name' => $subjectName,
                'icon' => $this->getRandomIcon(),
            ]
        );
        
        $this->info("Generating quiz for: {$subject->name}");
        
        // Fetch questions from API
        $questions = QuizApiService::fetchOpenTrivia($category, $difficulty, $questionCount);
        
        if (empty($questions)) {
            $this->warn("API failed, using fallback questions");
            $questions = QuizApiService::getFallbackQuestions($subjectName, $questionCount);
        }
        
        // Create quiz
        $quiz = Quiz::create([
            'subject_id' => $subject->id,
            'title' => $this->generateQuizTitle($subjectName, $difficulty),
            'description' => "Random quiz generated with " . count($questions) . " questions",
            'duration_seconds' => count($questions) * 30, // 30 seconds per question
            'total_points' => 0,
            'is_published' => true,
        ]);
        
        // Add questions
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
        
        $this->info("✅ Quiz created successfully!");
        $this->info("Quiz ID: {$quiz->id}");
        $this->info("URL: " . route('quizzes.show', $quiz));
        
        return Command::SUCCESS;
    }
    
    private function generateQuizTitle($subject, $difficulty)
    {
        $difficultyText = $difficulty ? ucfirst($difficulty) . ' ' : '';
        $randomWords = ['Challenge', 'Mastery', 'Expert', 'Quick', 'Ultimate'];
        return "{$difficultyText}{$subject} " . $randomWords[array_rand($randomWords)];
    }
    
    private function getRandomIcon()
    {
        $icons = ['🎯', '📚', '🔬', '🎨', '💻', '🌍', '⚡', '🎮', '🧠', '🏆'];
        return $icons[array_rand($icons)];
    }
}
