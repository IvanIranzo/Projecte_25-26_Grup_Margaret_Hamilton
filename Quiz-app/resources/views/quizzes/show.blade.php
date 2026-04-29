@extends('layouts.app')

@section('title', $quiz->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-4">{{ $quiz->title }}</h1>
    <p class="text-gray-600 mb-6">Time limit: {{ $quiz->duration_seconds / 60 }} minutes</p>
    
    <form action="{{ route('quizzes.submit', $quiz) }}" method="POST">
        @csrf
        
        @foreach($quiz->questions as $index => $question)
        <div class="bg-white rounded-lg shadow p-6 mb-4">
            <h3 class="text-lg font-semibold mb-4">Question {{ $index + 1 }}: {{ $question->content }}</h3>
            <p class="text-sm text-gray-500 mb-3">Points: {{ $question->points }}</p>
            
            <div class="space-y-2">
                @foreach($question->options as $option)
                <label class="flex items-center space-x-3">
                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" class="form-radio">
                    <span>{{ $option->content }}</span>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach
        
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            Submit Quiz
        </button>
    </form>
</div>
@if($quiz->is_custom)
    <div class="bg-purple-50 p-4 rounded-lg mb-4">
        <p class="text-purple-800">
            ✨ Custom Quiz created by {{ $quiz->creator->name ?? 'Unknown' }}
        </p>
    </div>
@endif
@endsection
