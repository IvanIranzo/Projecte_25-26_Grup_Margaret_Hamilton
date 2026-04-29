<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizAttempt extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'total_points',
        'completed_at'
    ];
    
    protected $casts = [
        'completed_at' => 'datetime',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
    
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    
    public static function hasTaken($userId, $quizId)
    {
        return self::where('user_id', $userId)
                   ->where('quiz_id', $quizId)
                   ->exists();
    }
}
