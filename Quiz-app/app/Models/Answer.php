<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'quiz_attempt_id',
        'question_id',
        'option_id',
        'is_correct'
    ];
    
    public function quizAttempt()
    {
        return $this->belongsTo(QuizAttempt::class);
    }
    
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    
    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
