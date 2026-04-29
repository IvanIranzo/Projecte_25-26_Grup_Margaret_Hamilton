<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function global()
    {
        $rankings = User::withSum('quizAttempts', 'score')
            ->orderBy('quiz_attempts_sum_score', 'desc')
            ->paginate(15);
            
        return view('rankings.global', compact('rankings'));
    }
    
    public function group(Group $group)
    {
        $rankings = $group->users()
            ->withSum('quizAttempts', 'score')
            ->orderBy('quiz_attempts_sum_score', 'desc')
            ->paginate(15);
            
        return view('rankings.group', compact('rankings', 'group'));
    }
}
