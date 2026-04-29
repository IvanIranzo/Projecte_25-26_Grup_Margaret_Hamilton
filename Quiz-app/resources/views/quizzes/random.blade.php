@extends('layouts.app')

@section('title', 'Generate Random Quiz')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-center">🎲 Generate Random Quiz</h1>
        
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form action="{{ route('quiz.random.generate') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Quiz Topic</label>
                    <input type="text" name="subject" required 
                           placeholder="e.g., Science, History, Movies, Sports"
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Difficulty</label>
                    <select name="difficulty" class="w-full px-3 py-2 border rounded-lg">
                        <option value="">Any Difficulty</option>
                        <option value="easy">Easy</option>
                        <option value="medium">Medium</option>
                        <option value="hard">Hard</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Number of Questions</label>
                    <select name="question_count" class="w-full px-3 py-2 border rounded-lg">
                        <option value="5">5 Questions</option>
                        <option value="10" selected>10 Questions</option>
                        <option value="15">15 Questions</option>
                        <option value="20">20 Questions</option>
                        <option value="25">25 Questions</option>
                    </select>
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Category (Optional)</label>
                    <select name="category" class="w-full px-3 py-2 border rounded-lg">
                        <option value="">Any Category</option>
                        @foreach($categories as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-semibold">
                    🎯 Generate & Save Random Quiz
                </button>
            </form>
        </div>
        
        @if(isset($recentQuizzes) && $recentQuizzes->count() > 0)
        <div class="bg-green-50 rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">📚 Your Recent Random Quizzes</h2>
            <div class="space-y-2">
                @foreach($recentQuizzes as $savedQuiz)
                <div class="flex justify-between items-center p-3 bg-white rounded-lg">
                    <div>
                        <a href="{{ route('quizzes.show', $savedQuiz) }}" class="font-semibold text-blue-600 hover:text-blue-800">
                            {{ $savedQuiz->title }}
                        </a>
                        <p class="text-sm text-gray-500">{{ $savedQuiz->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="text-sm text-gray-600">
                        {{ $savedQuiz->questions->count() }} questions | 
                        Taken: {{ $savedQuiz->attempts->count() }} times
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
        <div class="bg-purple-50 rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-3">✨ Features</h2>
            <ul class="space-y-2">
                <li>✓ Questions fetched from Open Trivia Database</li>
                <li>✓ Quizzes are PERMANENTLY SAVED to your account</li>
                <li>✓ Access your generated quizzes anytime from "My Quizzes"</li>
                <li>✓ Choose your topic, difficulty, and category</li>
                <li>✓ Track your scores and progress over time</li>
                <li>✓ Share quizzes with other users</li>
            </ul>
        </div>
        
        <div class="mt-6 text-center">
            <a href="{{ route('subjects.index') }}" class="text-blue-600 hover:text-blue-800">
                ← Back to Subjects
            </a>
        </div>
    </div>
</div>
@endsection
