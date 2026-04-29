@extends('layouts.app')

@section('title', 'Groups')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Groups</h1>
    
    <a href="{{ route('groups.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg mb-6 inline-block">
        + Create New Group
    </a>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($groups as $group)
        @php
            $isMember = $group->users->contains(auth()->id());
            $hasPendingRequest = false;
            if (auth()->user()) {
                $hasPendingRequest = $group->users()
                    ->where('user_id', auth()->id())
                    ->wherePivot('status', 'pending')
                    ->exists();
            }
        @endphp
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-2">{{ $group->name }}</h2>
            <p class="text-gray-600 mb-4">{{ $group->description ?? 'No description' }}</p>
            <p class="text-sm text-gray-500 mb-2">Owner: {{ $group->owner->name ?? 'Unknown' }}</p>
            <p class="text-sm text-gray-500 mb-4">Members: {{ $group->users->where('pivot.status', 'approved')->count() }}</p>
            @if($group->is_private)
                <p class="text-xs text-orange-600 mb-2">🔒 Private Group</p>
            @endif
            
            <div class="flex space-x-3">
                <a href="{{ route('groups.show', $group) }}" class="text-blue-600 hover:text-blue-800">View Group →</a>
                <a href="{{ route('rankings.group', $group) }}" class="text-green-600 hover:text-green-800">View Ranking →</a>
                
                @if(!$isMember && !$hasPendingRequest)
                    <form action="{{ route('groups.join', $group) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-green-600 hover:text-green-800">
                            {{ $group->is_private ? 'Request to Join' : 'Join' }}
                        </button>
                    </form>
                @elseif($hasPendingRequest)
                    <span class="text-yellow-600">Pending Approval</span>
                @elseif($isMember)
                    <form action="{{ route('groups.leave', $group) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">Leave</button>
                    </form>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    
    @if(isset($myGroups) && $myGroups->count() > 0)
    <div class="mt-12">
        <h2 class="text-2xl font-bold mb-4">My Groups</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($myGroups as $group)
            <div class="bg-green-50 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-2">{{ $group->name }}</h3>
                <p class="text-sm text-gray-600 mb-2">Role: {{ $group->pivot->role }}</p>
                <a href="{{ route('groups.show', $group) }}" class="text-blue-600 hover:text-blue-800">Manage →</a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    
    @if(isset($pendingRequests) && $pendingRequests->count() > 0)
    <div class="mt-12">
        <h2 class="text-2xl font-bold mb-4">Groups with Pending Requests</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($pendingRequests as $group)
            <div class="bg-yellow-50 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-2">{{ $group->name }}</h3>
                <p class="text-sm text-gray-600 mb-2">Status: {{ $group->pivot->status }}</p>
                <a href="{{ route('groups.show', $group) }}" class="text-blue-600 hover:text-blue-800">View →</a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
