<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'owner_id',
        'is_private'
    ];
    
    protected $casts = [
        'is_private' => 'boolean',
    ];
    
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'group_members')
                    ->withPivot('role', 'status', 'requested_at', 'approved_at')
                    ->withTimestamps();
    }
    
    public function approvedMembers()
    {
        return $this->belongsToMany(User::class, 'group_members')
                    ->wherePivot('status', 'approved')
                    ->withPivot('role')
                    ->withTimestamps();
    }
    
    public function pendingRequests()
    {
        return $this->belongsToMany(User::class, 'group_members')
                    ->wherePivot('status', 'pending')
                    ->withPivot('role', 'requested_at');
    }
    
    public function isMember($userId)
    {
        return $this->users()->where('user_id', $userId)->wherePivot('status', 'approved')->exists();
    }
    
    public function hasPendingRequest($userId)
    {
        return $this->users()->where('user_id', $userId)->wherePivot('status', 'pending')->exists();
    }
}
