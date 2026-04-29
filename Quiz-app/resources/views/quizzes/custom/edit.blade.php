@extends('layouts.app')

@section('title', 'Edit Quiz - ' . $quiz->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Edit Quiz: {{ $quiz->title }}</h1>
        
        <form action="{{ route('custom.quiz.update', $quiz) }}" method="POST" class="bg-white rounded-lg shadow p-6">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Subject</label>
                <select name="subject_id" required class="w-full px-3 py-2 border rounded-lg">
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ $quiz->subject_id == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Quiz Title</label>
                <input type="text" name="title" value="{{ old('title', $quiz->title) }}" required class="w-full px-3 py-2 border rounded-lg">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 border rounded-lg">{{ old('description', $quiz->description) }}</textarea>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Time Limit (seconds)</label>
                <input type="number" name="duration_seconds" value="{{ old('duration_seconds', $quiz->duration_seconds) }}" required class="w-full px-3 py-2 border rounded-lg" min="60" max="3600">
                <p class="text-sm text-gray-500 mt-1">Current: {{ floor($quiz->duration_seconds / 60) }} minutes</p>
            </div>
            
            <div class="bg-yellow-50 p-4 rounded-lg mb-6">
                <p class="text-yellow-800 text-sm">
                    ⚠️ Note: You cannot edit individual questions after creation. 
                    To modify questions, please duplicate this quiz and edit the copy.
                </p>
            </div>
            
            <div class="flex space-x-3">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Update Quiz
                </button>
                <a href="{{ route('custom.my') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">
                    Cancel
                </a>
            </div>
        </form>
        
        <div class="mt-6 bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Questions ({{ $quiz->questions->count() }})</h2>
            <div class="space-y-4">
                @foreach($quiz->questions as $index => $question)
                <div class="border-l-4 border-purple-500 pl-4">
                    <p class="font-semibold">{{ $index + 1 }}. {{ $question->content }}</p>
                    <p class="text-sm text-gray-600">Points: {{ $question->points }}</p>
                    <div class="ml-4 mt-2">
                        @foreach($question->options as $option)
                            <p class="text-sm {{ $option->is_correct ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                                {{ $option->is_correct ? '✓' : '○' }} {{ $option->content }}
                            </p>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
