@extends('layouts.app')

@section('title', $group->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold mb-2">{{ $group->name }}</h1>
            @if($group->is_private)
                <span class="inline-block bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded">🔒 Private Group</span>
            @else
                <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded">🌍 Public Group</span>
            @endif
        </div>
        
        @if(auth()->id() === $group->owner_id)
            <div class="space-x-2">
                <a href="{{ route('groups.edit', $group) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Edit Group
                </a>
                <form action="{{ route('groups.destroy', $group) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700" onclick="return confirm('Are you sure you want to delete this group?')">
                        Delete Group
                    </button>
                </form>
            </div>
        @endif
    </div>
    
    <p class="text-gray-600 mb-6">{{ $group->description ?? 'No description provided.' }}</p>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Group Information</h2>
            <div class="space-y-2">
                <p><strong>👑 Owner:</strong> {{ $group->owner->name ?? 'Unknown' }}</p>
                <p><strong>📅 Created:</strong> {{ $group->created_at->format('F j, Y') }}</p>
                <p><strong>👥 Total Members:</strong> {{ $group->users->count() }}</p>
                <p><strong>🔒 Privacy:</strong> {{ $group->is_private ? 'Private (approval required)' : 'Public (anyone can join)' }}</p>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
            <div class="space-y-2">
                <a href="{{ route('rankings.group', $group) }}" class="block text-blue-600 hover:text-blue-800">
                    📊 View Group Rankings →
                </a>
                
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
                
                @if($isMember)
                    <form action="{{ route('groups.leave', $group) }}" method="POST" class="inline-block w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 w-full text-left" onclick="return confirm('Are you sure you want to leave this group?')">
                            🚪 Leave Group
                        </button>
                    </form>
                @elseif($hasPendingRequest)
                    <div class="text-yellow-600">
                        ⏳ Pending Approval - Your request to join is waiting for owner approval
                    </div>
                @else
                    <form action="{{ route('groups.join', $group) }}" method="POST" class="inline-block w-full">
                        @csrf
                        <button type="submit" class="text-green-600 hover:text-green-800 w-full text-left">
                            {{ $group->is_private ? '✉️ Request to Join' : '✅ Join Group' }}
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Pending Join Requests (Owner only) -->
    @if(auth()->id() === $group->owner_id && isset($pendingRequests) && $pendingRequests->count() > 0)
    <div class="mt-6 bg-yellow-50 rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Pending Join Requests ({{ $pendingRequests->count() }})</h2>
        <div class="divide-y">
            @foreach($pendingRequests as $user)
            <div class="py-3 flex justify-between items-center">
                <div>
                    <span class="font-medium">{{ $user->name }}</span>
                    <span class="text-sm text-gray-500 ml-2">
                        Requested: 
                        @if($user->pivot->requested_at)
                            {{ \Carbon\Carbon::parse($user->pivot->requested_at)->diffForHumans() }}
                        @else
                            Recently
                        @endif
                    </span>
                </div>
                <div class="space-x-2">
                    <form action="{{ route('groups.approve', [$group, $user]) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                            ✓ Approve
                        </button>
                    </form>
                    <form action="{{ route('groups.reject', [$group, $user]) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                            ✗ Reject
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    
    <!-- Members List -->
    <div class="mt-6 bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Group Members ({{ $group->users->count() }})</h2>
        <div class="divide-y">
            @foreach($group->users as $member)
            <div class="py-3 flex justify-between items-center">
                <div>
                    <span class="font-medium">{{ $member->name }}</span>
                    <span class="text-sm text-gray-500 ml-2">
                        @if($member->pivot->role === 'owner')
                            👑 Owner
                        @else
                            👤 {{ ucfirst($member->pivot->role) }}
                        @endif
                    </span>
                    @if($member->pivot->approved_at)
                        <span class="text-xs text-gray-400 ml-2">
                            Joined: {{ \Carbon\Carbon::parse($member->pivot->approved_at)->format('M j, Y') }}
                        </span>
                    @endif
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-gray-600">
                        🏆 Total Score: {{ $member->quizAttempts()->sum('score') }}
                    </div>
                    
                    @if(auth()->id() === $group->owner_id && $member->id !== $group->owner_id)
                    <form action="{{ route('groups.remove', [$group, $member]) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('Remove {{ $member->name }} from the group?')">
                            Remove
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
    <div class="mt-6">
        <a href="{{ route('groups.index') }}" class="text-blue-600 hover:text-blue-800">← Back to All Groups</a>
    </div>
</div>
@endsection
