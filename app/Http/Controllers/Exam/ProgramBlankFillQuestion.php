<?php

namespace App\Http\Controllers\Exam;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use ExamAuth;

/**
 * Exam program-blank-fill question
 */
class ProgramBlankFillQuestion extends Controller
{
    public function show(ExamAuth $auth)
    {
        return view('exam.true-false', [
            'active' => 'program-blank-fill',
            'auth' => $auth,
        ]);
    }
}
