<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;

class RealQuestionsSeeder extends Seeder
{
    public function run()
    {
        // LITERATURE QUIZZES (IDs 1 and 2)
        $this->addLiteratureQuestions();
        
        // HISTORY QUIZZES (IDs 3 and 4)
        $this->addHistoryQuestions();
        
        // CHEMISTRY QUIZZES (IDs 5 and 6)
        $this->addChemistryQuestions();
        
        // PHYSICS QUIZZES (IDs 7 and 8)
        $this->addPhysicsQuestions();
        
        $this->command->info('Real questions added successfully!');
    }
    
    private function addLiteratureQuestions()
    {
        // Literature Quiz #1 (ID: 1)
        $quiz1 = Quiz::find(1);
        if ($quiz1) {
            // Clear existing generic questions
            $quiz1->questions()->where('content', 'like', 'Sample question%')->delete();
            
            $questions = [
                [
                    'content' => 'Who wrote "Romeo and Juliet"?',
                    'options' => [
                        ['content' => 'Charles Dickens', 'is_correct' => false],
                        ['content' => 'William Shakespeare', 'is_correct' => true],
                        ['content' => 'Jane Austen', 'is_correct' => false],
                        ['content' => 'Mark Twain', 'is_correct' => false],
                    ]
                ],
                [
                    'content' => 'In which city does "The Great Gatsby" primarily take place?',
                    'options' => [
                        ['content' => 'New York', 'is_correct' => true],
                        ['content' => 'Los Angeles', 'is_correct' => false],
                        ['content' => 'Chicago', 'is_correct' => false],
                        ['content' => 'Boston', 'is_correct' => false],
                    ]
                ],
                [
                    'content' => 'Who wrote "Pride and Prejudice"?',
                    'options' => [
                        ['content' => 'Emily Brontë', 'is_correct' => false],
                        ['content' => 'Jane Austen', 'is_correct' => true],
                        ['content' => 'Charlotte Brontë', 'is_correct' => false],
                        ['content' => 'Mary Shelley', 'is_correct' => false],
                    ]
                ],
                [
                    'content' => 'What is the name of the pirate in "Treasure Island"?',
                    'options' => [
                        ['content' => 'Captain Hook', 'is_correct' => false],
                        ['content' => 'Long John Silver', 'is_correct' => true],
                        ['content' => 'Blackbeard', 'is_correct' => false],
                        ['content' => 'Jack Sparrow', 'is_correct' => false],
                    ]
                ],
                [
                    'content' => 'Who is the author of "1984"?',
                    'options' => [
                        ['content' => 'Aldous Huxley', 'is_correct' => false],
                        ['content' => 'George Orwell', 'is_correct' => true],
                        ['content' => 'Ray Bradbury', 'is_correct' => false],
                        ['content' => 'Ernest Hemingway', 'is_correct' => false],
                    ]
                ],
            ];
            
            foreach ($questions as $index => $q) {
                $question = $quiz1->questions()->create([
                    'content' => $q['content'],
                    'points' => 10,
                    'order' => $index + 1,
                ]);
                
                foreach ($q['options'] as $option) {
                    $question->options()->create($option);
                }
            }
        }
        
        // Literature Quiz #2 (ID: 2)
        $quiz2 = Quiz::find(2);
        if ($quiz2) {
            $quiz2->questions()->where('content', 'like', 'Sample question%')->delete();
            
            $questions = [
                [
                    'content' => 'Who wrote "Hamlet"?',
                    'options' => [
                        ['content' => 'Christopher Marlowe', 'is_correct' => false],
                        ['content' => 'William Shakespeare', 'is_correct' => true],
                        ['content' => 'Ben Jonson', 'is_correct' => false],
                        ['content' => 'John Milton', 'is_correct' => false],
                    ]
                ],
                [
                    'content' => 'Which novel begins with "Call me Ishmael"?',
                    'options' => [
                        ['content' => 'Moby Dick', 'is_correct' => true],
                        ['content' => 'The Old Man and the Sea', 'is_correct' => false],
                        ['content' => 'Treasure Island', 'is_correct' => false],
                        ['content' => 'Robinson Crusoe', 'is_correct' => false],
                    ]
                ],
                [
                    'content' => 'Who wrote "The Great Gatsby"?',
                    'options' => [
                        ['content' => 'Ernest Hemingway', 'is_correct' => false],
                        ['content' => 'F. Scott Fitzgerald', 'is_correct' => true],
                        ['content' => 'John Steinbeck', 'is_correct' => false],
                        ['content' => 'William Faulkner', 'is_correct' => false],
                    ]
                ],
            ];
            
            foreach ($questions as $index => $q) {
                $question = $quiz2->questions()->create([
                    'content' => $q['content'],
                    'points' => 10,
                    'order' => $index + 1,
                ]);
                
                foreach ($q['options'] as $option) {
                    $question->options()->create($option);
                }
            }
        }
    }
    
    private function addHistoryQuestions()
    {
        // History Quiz #1 (ID: 3)
        $quiz3 = Quiz::find(3);
        if ($quiz3) {
            $quiz3->questions()->where('content', 'like', 'Sample question%')->delete();
            
            $questions = [
                [
                    'content' => 'Who was the first President of the United States?',
                    'options' => [
                        ['content' => 'Thomas Jefferson', 'is_correct' => false],
                        ['content' => 'George Washington', 'is_correct' => true],
                        ['content' => 'John Adams', 'is_correct' => false],
                        ['content' => 'Benjamin Franklin', 'is_correct' => false],
                    ]
                ],
                [
                    'content' => 'In which year did World War II end?',
                    'options' => [
                        ['content' => '1943', 'is_correct' => false],
                        ['content' => '1944', 'is_correct' => false],
                        ['content' => '1945', 'is_correct' => true],
                        ['content' => '1946', 'is_correct' => false],
                    ]
                ],
                [
                    'content' => 'Who painted the Mona Lisa?',
                    'options' => [
                        ['content' => 'Vincent van Gogh', 'is_correct' => false],
                        ['content' => 'Pablo Picasso', 'is_correct' => false],
                        ['content' => 'Leonardo da Vinci', 'is_correct' => true],
                        ['content' => 'Michelangelo', 'is_correct' => false],
                    ]
                ],
            ];
            
            foreach ($questions as $index => $q) {
                $question = $quiz3->questions()->create([
                    'content' => $q['content'],
                    'points' => 10,
                    'order' => $index + 1,
                ]);
                
                foreach ($q['options'] as $option) {
                    $question->options()->create($option);
                }
            }
        }
        
        // History Quiz #2 (ID: 4)
        $quiz4 = Quiz::find(4);
        if ($quiz4) {
            $quiz4->questions()->where('content', 'like', 'Sample question%')->delete();
            
            $questions = [
                [
                    'content' => 'Who discovered America in 1492?',
                    'options' => [
                        ['content' => 'Ferdinand Magellan', 'is_correct' => false],
                        ['content' => 'Marco Polo', 'is_correct' => false],
                        ['content' => 'Christopher Columbus', 'is_correct' => true],
                        ['content' => 'Vasco da Gama', 'is_correct' => false],
                    ]
                ],
                [
                    'content' => 'The French Revolution started in which year?',
                    'options' => [
                        ['content' => '1776', 'is_correct' => false],
                        ['content' => '1789', 'is_correct' => true],
                        ['content' => '1799', 'is_correct' => false],
                        ['content' => '1804', 'is_correct' => false],
                    ]
                ],
            ];
            
            foreach ($questions as $index => $q) {
                $question = $quiz4->questions()->create([
                    'content' => $q['content'],
                    'points' => 10,
                    'order' => $index + 1,
                ]);
                
                foreach ($q['options'] as $option) {
                    $question->options()->create($option);
                }
            }
        }
    }
    
    private function addChemistryQuestions()
    {
        // Chemistry Quiz #1 (ID: 5)
        $quiz5 = Quiz::find(5);
        if ($quiz5) {
            $quiz5->questions()->where('content', 'like', 'Sample question%')->delete();
            
            $questions = [
                [
                    'content' => 'What is the chemical symbol for Gold?',
                    'options' => [
                        ['content' => 'Go', 'is_correct' => false],
                        ['content' => 'Gd', 'is_correct' => false],
                        ['content' => 'Au', 'is_correct' => true],
                        ['content' => 'Ag', 'is_correct' => false],
                    ]
                ],
                [
                    'content' => 'What is the chemical symbol for Water?',
                    'options' => [
                        ['content' => 'O2', 'is_correct' => false],
                        ['content' => 'H2O', 'is_correct' => true],
                        ['content' => 'CO2', 'is_correct' => false],
                        ['content' => 'NaCl', 'is_correct' => false],
                    ]
                ],
                [
                    'content' => 'What is the pH value of pure water?',
                    'options' => [
                        ['content' => '5', 'is_correct' => false],
                        ['content' => '6', 'is_correct' => false],
                        ['content' => '7', 'is_correct' => true],
                        ['content' => '8', 'is_correct' => false],
                    ]
                ],
            ];
            
            foreach ($questions as $index => $q) {
                $question = $quiz5->questions()->create([
                    'content' => $q['content'],
                    'points' => 10,
                    'order' => $index + 1,
                ]);
                
                foreach ($q['options'] as $option) {
                    $question->options()->create($option);
                }
            }
        }
        
        // Chemistry Quiz #2 (ID: 6)
        $quiz6 = Quiz::find(6);
        if ($quiz6) {
            $quiz6->questions()->where('content', 'like', 'Sample question%')->delete();
            
            $questions = [
                [
                    'content' => 'What is the atomic number of Carbon?',
                    'options' => [
                        ['content' => '4', 'is_correct' => false],
                        ['content' => '5', 'is_correct' => false],
                        ['content' => '6', 'is_correct' => true],
                        ['content' => '7', 'is_correct' => false],
                    ]
                ],
                [
                    'content' => 'What is the chemical symbol for Sodium?',
                    'options' => [
                        ['content' => 'So', 'is_correct' => false],
                        ['content' => 'Na', 'is_correct' => true],
                        ['content' => 'Sd', 'is_correct' => false],
                        ['content' => 'N', 'is_correct' => false],
                    ]
                ],
            ];
            
            foreach ($questions as $index => $q) {
                $question = $quiz6->questions()->create([
                    'content' => $q['content'],
                    'points' => 10,
                    'order' => $index + 1,
                ]);
                
                foreach ($q['options'] as $option) {
                    $question->options()->create($option);
                }
            }
        }
    }
    
    private function addPhysicsQuestions()
    {
        // Physics Quiz #1 (ID: 7)
        $quiz7 = Quiz::find(7);
        if ($quiz7) {
            $quiz7->questions()->where('content', 'like', 'Sample question%')->delete();
            
            $questions = [
                [
                    'content' => 'What is the unit of force?',
                    'options' => [
                        ['content' => 'Joule', 'is_correct' => false],
                        ['content' => 'Watt', 'is_correct' => false],
                        ['content' => 'Newton', 'is_correct' => true],
                        ['content' => 'Pascal', 'is_correct' => false],
                    ]
                ],
                [
                    'content' => 'What is the speed of light in vacuum?',
                    'options' => [
                        ['content' => '300,000 km/s', 'is_correct' => true],
                        ['content' => '150,000 km/s', 'is_correct' => false],
                        ['content' => '450,000 km/s', 'is_correct' => false],
                        ['content' => '600,000 km/s', 'is_correct' => false],
                    ]
                ],
                [
                    'content' => 'Who developed the theory of relativity?',
                    'options' => [
                        ['content' => 'Isaac Newton', 'is_correct' => false],
                        ['content' => 'Galileo Galilei', 'is_correct' => false],
                        ['content' => 'Albert Einstein', 'is_correct' => true],
                        ['content' => 'Nikola Tesla', 'is_correct' => false],
                    ]
                ],
            ];
            
            foreach ($questions as $index => $q) {
                $question = $quiz7->questions()->create([
                    'content' => $q['content'],
                    'points' => 10,
                    'order' => $index + 1,
                ]);
                
                foreach ($q['options'] as $option) {
                    $question->options()->create($option);
                }
            }
        }
        
        // Physics Quiz #2 (ID: 8)
        $quiz8 = Quiz::find(8);
        if ($quiz8) {
            $quiz8->questions()->where('content', 'like', 'Sample question%')->delete();
            
            $questions = [
                [
                    'content' => 'What is the SI unit of energy?',
                    'options' => [
                        ['content' => 'Watt', 'is_correct' => false],
                        ['content' => 'Joule', 'is_correct' => true],
                        ['content' => 'Newton', 'is_correct' => false],
                        ['content' => 'Volt', 'is_correct' => false],
                    ]
                ],
                [
                    'content' => 'What is the acceleration due to gravity on Earth?',
                    'options' => [
                        ['content' => '9.8 m/s²', 'is_correct' => true],
                        ['content' => '8.9 m/s²', 'is_correct' => false],
                        ['content' => '10.8 m/s²', 'is_correct' => false],
                        ['content' => '7.8 m/s²', 'is_correct' => false],
                    ]
                ],
            ];
            
            foreach ($questions as $index => $q) {
                $question = $quiz8->questions()->create([
                    'content' => $q['content'],
                    'points' => 10,
                    'order' => $index + 1,
                ]);
                
                foreach ($q['options'] as $option) {
                    $question->options()->create($option);
                }
            }
        }
    }
}
