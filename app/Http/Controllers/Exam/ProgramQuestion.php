<?php

namespace App\Http\Controllers\Exam;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use ExamAuth;

/**
 * Exam program question
 */
class ProgramQuestion extends Controller
{
    public function show(ExamAuth $auth)
    {
        return view('exam.true-false', [
            'active' => 'program',
            'auth' => $auth,
        ]);
    }
}
