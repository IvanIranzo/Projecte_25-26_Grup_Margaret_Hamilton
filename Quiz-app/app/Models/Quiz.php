<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'subject_id',
        'title',
        'duration_seconds',
        'total_points'
    ];
    
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    
    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }
}
