<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subject;  // ← ADD THIS
use App\Models\Quiz;     // ← ADD THIS
use App\Models\Question; // ← ADD THIS
use App\Models\Option;   // ← ADD THIS

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            ['name' => 'Literature', 'slug' => 'literature', 'icon' => 'book-open'],
            ['name' => 'History',    'slug' => 'history',    'icon' => 'landmark'],
            ['name' => 'Chemistry',  'slug' => 'chemistry',  'icon' => 'flask'],
            ['name' => 'Physics',    'slug' => 'physics',    'icon' => 'atom'],
        ];

        foreach ($subjects as $subjectData) {
            $subject = Subject::create($subjectData);

            // Create 2 quizzes per subject
            for ($i = 1; $i <= 2; $i++) {
                $quiz = Quiz::create([
                    'subject_id'       => $subject->id,
                    'title'            => "{$subject->name} Quiz #{$i}",
                    'duration_seconds' => 300,
                    'total_points'     => 10,
                ]);

                // 10 questions each
                for ($q = 1; $q <= 10; $q++) {
                    $question = Question::create([
                        'quiz_id' => $quiz->id,
                        'content' => "Sample question #{$q} for {$subject->name}",
                        'points'  => 1,
                        'order'   => $q,
                    ]);

                    // 4 options, 1 correct
                    for ($o = 1; $o <= 4; $o++) {
                        Option::create([
                            'question_id' => $question->id,
                            'content'     => "Option {$o}",
                            'is_correct'  => $o === 1,
                        ]);
                    }
                }
            }
        }
    }
}
