<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class QuizApiService
{
    // Free API endpoints
    const OPENTDB_API = 'https://opentdb.com/api.php';
    const QUIZAPI_API = 'https://quizapi.io/api/v1/questions';
    
    /**
     * Fetch questions from Open Trivia Database (Free, no API key)
     */
    public static function fetchOpenTrivia($category = null, $difficulty = null, $limit = 10)
    {
        $params = [
            'amount' => $limit,
            'type' => 'multiple',
        ];
        
        if ($category) {
            $params['category'] = $category;
        }
        
        if ($difficulty) {
            $params['difficulty'] = $difficulty;
        }
        
        $response = Http::get(self::OPENTDB_API, $params);
        
        if ($response->successful() && $response->json()['response_code'] === 0) {
            return self::formatOpenTriviaQuestions($response->json()['results']);
        }
        
        return [];
    }
    
    /**
     * Format Open Trivia questions for our database
     */
    private static function formatOpenTriviaQuestions($questions)
    {
        $formatted = [];
        
        foreach ($questions as $q) {
            $options = array_merge([$q['correct_answer']], $q['incorrect_answers']);
            shuffle($options); // Randomize order
            
            $formatted[] = [
                'content' => html_entity_decode($q['question']),
                'points' => 10,
                'options' => array_map(function($option) use ($q) {
                    return [
                        'content' => html_entity_decode($option),
                        'is_correct' => $option === $q['correct_answer']
                    ];
                }, $options),
                'category' => $q['category'],
                'difficulty' => $q['difficulty']
            ];
        }
        
        return $formatted;
    }
    
    /**
     * Fetch from QuizAPI (requires API key but has more categories)
     */
    public static function fetchQuizAPI($category = null, $limit = 10)
    {
        $apiKey = env('QUIZAPI_KEY', '');
        
        if (!$apiKey) {
            return self::getFallbackQuestions($category, $limit);
        }
        
        $params = [
            'limit' => $limit,
            'apiKey' => $apiKey,
        ];
        
        if ($category) {
            $params['category'] = $category;
        }
        
        $response = Http::get(self::QUIZAPI_API, $params);
        
        if ($response->successful()) {
            return self::formatQuizApiQuestions($response->json());
        }
        
        return self::getFallbackQuestions($category, $limit);
    }
    
    /**
     * Format QuizAPI questions
     */
    private static function formatQuizApiQuestions($questions)
    {
        $formatted = [];
        
        foreach ($questions as $q) {
            $options = [];
            $correctAnswer = $q['correct_answer'];
            
            foreach ($q['answers'] as $key => $answer) {
                if ($answer) {
                    $options[] = [
                        'content' => $answer,
                        'is_correct' => $key === $correctAnswer
                    ];
                }
            }
            
            shuffle($options);
            
            $formatted[] = [
                'content' => $q['question'],
                'points' => 10,
                'options' => $options,
                'category' => $q['category'] ?? 'General',
                'difficulty' => $q['difficulty'] ?? 'medium'
            ];
        }
        
        return $formatted;
    }
    
    /**
     * Fallback questions if API fails
     */
    private static function getFallbackQuestions($category, $limit)
    {
        $allQuestions = [
            'General' => [
                [
                    'content' => 'What is the capital of France?',
                    'options' => [
                        ['content' => 'London', 'is_correct' => false],
                        ['content' => 'Berlin', 'is_correct' => false],
                        ['content' => 'Paris', 'is_correct' => true],
                        ['content' => 'Madrid', 'is_correct' => false],
                    ]
                ],
                [
                    'content' => 'What is 2 + 2?',
                    'options' => [
                        ['content' => '3', 'is_correct' => false],
                        ['content' => '4', 'is_correct' => true],
                        ['content' => '5', 'is_correct' => false],
                        ['content' => '6', 'is_correct' => false],
                    ]
                ],
            ],
            'Science' => [
                [
                    'content' => 'What is the chemical symbol for Gold?',
                    'options' => [
                        ['content' => 'Go', 'is_correct' => false],
                        ['content' => 'Gd', 'is_correct' => false],
                        ['content' => 'Au', 'is_correct' => true],
                        ['content' => 'Ag', 'is_correct' => false],
                    ]
                ],
            ],
        ];
        
        $categoryQuestions = $allQuestions[$category] ?? $allQuestions['General'];
        return array_slice($categoryQuestions, 0, $limit);
    }
}
