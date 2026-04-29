@extends('layouts.app')

@section('title', 'Quiz Result')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow p-8 text-center">
        <h1 class="text-3xl font-bold mb-4">Quiz Results</h1>
        
        <div class="text-6xl font-bold mb-4">
            {{ $attempt->score }} / {{ $attempt->total_points }}
        </div>
        
        <p class="text-gray-600 mb-6">
            You scored {{ round(($attempt->score / $attempt->total_points) * 100) }}%
        </p>
        
        <a href="{{ route('subjects.index') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            Back to Subjects
        </a>
    </div>
</div>
@endsection
