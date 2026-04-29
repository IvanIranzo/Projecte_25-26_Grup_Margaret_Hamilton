<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::with('owner', 'users')->get();
        $myGroups = Auth::user()->groups()->wherePivot('status', 'approved')->get();
        $pendingRequests = Auth::user()->groups()->wherePivot('status', 'pending')->get();
        
        return view('groups.index', compact('groups', 'myGroups', 'pendingRequests'));
    }
    
    public function create()
    {
        return view('groups.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_private' => 'boolean',
        ]);
        
        $group = Group::create([
            'name' => $request->name,
            'description' => $request->description,
            'owner_id' => Auth::id(),
            'is_private' => $request->has('is_private'),
        ]);
        
        // Add owner as approved member
        $group->users()->attach(Auth::id(), [
            'role' => 'owner',
            'status' => 'approved',
            'approved_at' => now(),
        ]);
        
        return redirect()->route('groups.show', $group)->with('success', 'Group created successfully!');
    }
    
    public function show(Group $group)
    {
        $group->load(['owner', 'users' => function($query) {
            $query->wherePivot('status', 'approved');
        }]);
        
        $isMember = $group->isMember(Auth::id());
        $hasPendingRequest = $group->hasPendingRequest(Auth::id());
        $pendingRequests = null;
        
        if (Auth::id() === $group->owner_id) {
            $pendingRequests = $group->pendingRequests()->get();
        }
        
        return view('groups.show', compact('group', 'isMember', 'hasPendingRequest', 'pendingRequests'));
    }
    
    public function edit(Group $group)
    {
        // Check if user is the owner
        if (auth()->id() !== $group->owner_id) {
            return redirect()->route('groups.index')->with('error', 'Only the group owner can edit this group.');
        }
        return view('groups.edit', compact('group'));
    }
    
    public function update(Request $request, Group $group)
    {
        // Check if user is the owner
        if (auth()->id() !== $group->owner_id) {
            return redirect()->route('groups.index')->with('error', 'Only the group owner can update this group.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_private' => 'boolean',
        ]);
        
        $group->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_private' => $request->has('is_private'),
        ]);
        
        return redirect()->route('groups.show', $group)->with('success', 'Group updated successfully!');
    }
    
    public function destroy(Group $group)
    {
        // Check if user is the owner
        if (auth()->id() !== $group->owner_id) {
            return redirect()->route('groups.index')->with('error', 'Only the group owner can delete this group.');
        }
        
        $group->delete();
        
        return redirect()->route('groups.index')->with('success', 'Group deleted successfully!');
    }
    
    public function join(Group $group)
    {
        if ($group->is_private) {
            // Request to join
            if (!$group->hasPendingRequest(Auth::id())) {
                $group->users()->attach(Auth::id(), [
                    'role' => 'member',
                    'status' => 'pending',
                    'requested_at' => now(),
                ]);
                return back()->with('info', 'Join request sent to group owner!');
            }
            return back()->with('warning', 'You already have a pending request!');
        } else {
            // Public group - join immediately
            $group->users()->attach(Auth::id(), [
                'role' => 'member',
                'status' => 'approved',
                'approved_at' => now(),
            ]);
            return back()->with('success', 'Joined group successfully!');
        }
    }
    
    public function approveRequest(Group $group, $userId)
    {
        // Check if user is the owner
        if (auth()->id() !== $group->owner_id) {
            return back()->with('error', 'Only the group owner can approve requests.');
        }
        
        DB::table('group_members')
            ->where('group_id', $group->id)
            ->where('user_id', $userId)
            ->update([
                'status' => 'approved',
                'approved_at' => now(),
            ]);
        
        return back()->with('success', 'User approved to join the group!');
    }
    
    public function rejectRequest(Group $group, $userId)
    {
        // Check if user is the owner
        if (auth()->id() !== $group->owner_id) {
            return back()->with('error', 'Only the group owner can reject requests.');
        }
        
        DB::table('group_members')
            ->where('group_id', $group->id)
            ->where('user_id', $userId)
            ->delete();
        
        return back()->with('success', 'Join request rejected!');
    }
    
    public function leave(Group $group)
    {
        $group->users()->detach(Auth::id());
        return redirect()->route('groups.index')->with('success', 'Left group successfully!');
    }
    
    public function removeMember(Group $group, $userId)
    {
        // Check if user is the owner
        if (auth()->id() !== $group->owner_id) {
            return back()->with('error', 'Only the group owner can remove members.');
        }
        
        $group->users()->detach($userId);
        return back()->with('success', 'Member removed from group!');
    }
}
