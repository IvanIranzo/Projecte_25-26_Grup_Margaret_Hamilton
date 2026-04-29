@extends('layouts.app')

@section('title', 'Subjects')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Subjects</h1>
        <div class="space-x-3">
            <a href="{{ route('quiz.random') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 inline-block">
                🎲 Random Quiz
            </a>
            <a href="{{ route('custom.quiz.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 inline-block">
                + Create Custom Quiz
            </a>
        </div>
    </div>
    
    @if($subjects->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($subjects as $subject)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="p-6">
                    <div class="text-5xl mb-4">{{ $subject->icon ?? '📚' }}</div>
                    <h2 class="text-2xl font-bold mb-2">{{ $subject->name }}</h2>
                    <p class="text-gray-600 mb-4">{{ $subject->quizzes->count() }} quiz(zes) available</p>
                    
                    @if($subject->quizzes->count() > 0)
                        <div class="space-y-2 mb-4">
                            @foreach($subject->quizzes->take(5) as $quiz)
                                @php
                                    $hasTaken = App\Models\QuizAttempt::hasTaken(auth()->id(), $quiz->id);
                                @endphp
                                
                                @if($hasTaken)
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-400 line-through text-sm">📝 {{ $quiz->title }}</span>
                                        <span class="text-green-600 text-xs">✅ Completed</span>
                                    </div>
                                @else
                                    <a href="{{ route('quizzes.show', $quiz) }}" class="block text-blue-600 hover:text-blue-800 text-sm">
                                        📝 {{ $quiz->title }}
                                    </a>
                                @endif
                            @endforeach
                            @if($subject->quizzes->count() > 5)
                                <p class="text-gray-500 text-sm">And {{ $subject->quizzes->count() - 5 }} more...</p>
                            @endif
                        </div>
                    @endif
                    
                    <div class="mt-4 pt-4 border-t">
<a href="{{ route('subjects.quizzes', $subject) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                            View all quizzes →
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <div class="text-6xl mb-4">📚</div>
            <h2 class="text-2xl font-semibold mb-4">No Subjects Available</h2>
            <p class="text-gray-600 mb-6">Create a random quiz or custom quiz to get started!</p>
            <div class="space-x-3">
                <a href="{{ route('quiz.random') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 inline-block">
                    🎲 Generate Random Quiz
                </a>
                <a href="{{ route('custom.quiz.create') }}" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 inline-block">
                    + Create Custom Quiz
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
