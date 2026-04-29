@extends('layouts.app')

@section('title', 'Edit Group - ' . $group->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Edit Group: {{ $group->name }}</h1>
    
    <form action="{{ route('groups.update', $group) }}" method="POST" class="bg-white rounded-lg shadow p-6 max-w-lg">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Group Name *</label>
            <input type="text" name="name" value="{{ old('name', $group->name) }}" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
            <textarea name="description" rows="4" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">{{ old('description', $group->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" name="is_private" value="1" {{ $group->is_private ? 'checked' : '' }} class="mr-2 w-4 h-4">
                <span class="text-gray-700">🔒 Private Group (users need approval to join)</span>
            </label>
            <p class="text-sm text-gray-500 mt-1 ml-6">If unchecked, the group will be public and anyone can join instantly.</p>
        </div>
        
        <div class="flex space-x-3">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                Update Group
            </button>
            <a href="{{ route('groups.show', $group) }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
