@extends('layouts.app')

@section('title', 'My Custom Quizzes')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">My Custom Quizzes</h1>
        <a href="{{ route('custom.quiz.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
            + Create New Quiz
        </a>
    </div>
    
    @if($quizzes->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($quizzes as $quiz)
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-xl font-semibold text-purple-800">{{ $quiz->title }}</h2>
                    <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded">Custom</span>
                </div>
                
                <p class="text-gray-600 text-sm mb-4">{{ $quiz->description ?? 'No description' }}</p>
                
                <div class="space-y-2 text-sm mb-4">
                    <p><strong>Subject:</strong> {{ $quiz->subject->name }}</p>
                    <p><strong>Questions:</strong> {{ $quiz->questions->count() }}</p>
                    <p><strong>Total Points:</strong> {{ $quiz->total_points }}</p>
                    <p><strong>Time Limit:</strong> {{ floor($quiz->duration_seconds / 60) }} minutes</p>
                    <p><strong>Plays:</strong> {{ $quiz->plays_count ?? 0 }}</p>
                    @if($quiz->average_score)
                        <p><strong>Avg Score:</strong> {{ number_format($quiz->average_score, 1) }}%</p>
                    @endif
                    <p><strong>Created:</strong> {{ $quiz->created_at->diffForHumans() }}</p>
                </div>
                
                <div class="flex space-x-2">
                    <a href="{{ route('quizzes.show', $quiz) }}" class="flex-1 text-center bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 text-sm">
                        Take Quiz
                    </a>
                    <a href="{{ route('custom.quiz.edit', $quiz) }}" class="flex-1 text-center bg-yellow-600 text-white px-3 py-2 rounded-lg hover:bg-yellow-700 text-sm">
                        Edit
                    </a>
                    <form action="{{ route('custom.quiz.destroy', $quiz) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 text-white px-3 py-2 rounded-lg hover:bg-red-700 text-sm" onclick="return confirm('Are you sure you want to delete this quiz?')">
                            Delete
                        </button>
                    </form>
                </div>
                
                <div class="mt-3">
                    <form action="{{ route('custom.quiz.duplicate', $quiz) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-gray-600 hover:text-purple-600 text-sm">
                            📋 Duplicate Quiz
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-6">
            {{ $quizzes->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <div class="text-6xl mb-4">📝</div>
            <h2 class="text-2xl font-semibold mb-4">No Custom Quizzes Yet</h2>
            <p class="text-gray-600 mb-6">You haven't created any custom quizzes. Create your first quiz now!</p>
            <a href="{{ route('custom.quiz.create') }}" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700">
                Create Your First Quiz
            </a>
        </div>
    @endif
</div>
@endsection
