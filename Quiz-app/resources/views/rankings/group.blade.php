@extends('layouts.app')

@section('title', 'Group Rankings - ' . $group->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-4">Group Rankings: {{ $group->name }}</h1>
    <p class="text-gray-600 mb-6">Ranking of members in this group</p>
    
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Player</th>
                    <th class="px-6 py-3 text-left">Total Score</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rankings as $i => $user)
                <tr class="{{ auth()->id() === $user->id ? 'bg-yellow-50' : '' }}">
                    <td class="px-6 py-4">{{ $rankings->firstItem() + $i }}</td>
                    <td class="px-6 py-4">{{ $user->name }}</td>
                    <td class="px-6 py-4">{{ $user->quiz_attempts_sum_score ?? 0 }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $rankings->links() }}
        </div>
    </div>
    
    <div class="mt-6">
        <a href="{{ route('groups.index') }}" class="text-blue-600 hover:text-blue-800">← Back to Groups</a>
    </div>
</div>
@endsection
