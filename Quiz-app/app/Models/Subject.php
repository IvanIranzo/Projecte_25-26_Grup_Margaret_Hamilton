<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'slug',
        'icon'
    ];
    
    // Add this relationship
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
