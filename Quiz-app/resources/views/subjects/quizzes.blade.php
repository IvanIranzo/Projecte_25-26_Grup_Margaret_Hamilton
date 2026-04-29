@extends('layouts.app')

@section('title', $subject->name . ' - All Quizzes')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('subjects.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
            ← Back to Subjects
        </a>
        <h1 class="text-3xl font-bold">{{ $subject->name }}</h1>
        <p class="text-gray-600 mt-2">All available quizzes in this subject</p>
    </div>
    
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quiz</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Questions</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Points</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($quizzes as $quiz)
                    @php
                        $isCompleted = in_array($quiz->id, $completedQuizzes);
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $quiz->title }}</div>
                            @if($quiz->description)
                                <div class="text-sm text-gray-500">{{ Str::limit($quiz->description, 100) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $quiz->questions->count() }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $quiz->total_points }}
                        </td>
                        <td class="px-6 py-4">
                            @if($isCompleted)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    ✅ Completed
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    📝 Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if(!$isCompleted)
                                <a href="{{ route('quizzes.show', $quiz) }}" 
                                   class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    Take Quiz
                                </a>
                            @else
                                <span class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-gray-400 bg-gray-100">
                                    Completed
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            No quizzes available in this subject yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">
        <div class="bg-blue-50 rounded-lg p-4">
            <p class="text-blue-800 text-sm">
                💡 <strong>Note:</strong> Each quiz can only be taken once. 
                Completed quizzes will show as "Completed" and cannot be retaken.
            </p>
        </div>
    </div>
</div>
@endsection
