<?php

namespace App\Http\Controllers\Exam;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use ExamAuth;
use App\Models\Question;

/**
 * Exam infomation
 */
class Info extends Controller
{
    public function show(ExamAuth $auth)
    {
        $questions = Question::select('id', 'type', 'score')
            ->where('exam', $auth->exam->id)
            ->orderBy('id', 'asc')
            ->get();

        $qs = [
            'trueFalse' => [],
            'multiChoice' => [],
            'blankFill' => [],
            'shortAnswer' => [],
            'general' => [],
            'programBlankFill' => [],
            'program' => [],
        ];
        $qsKeys = array_keys($qs);
        $questions = $questions->reduce(function($qs, $q) use ($qsKeys) {
            $qs[$qsKeys[$q->type]][] = $q;
            return $qs;
        }, $qs);

        return view('exam.info', [
            'active' => 'info',
            'auth' => $auth,
            'questions' => $questions,
            'questionTypes' => $qsKeys,
        ]);
    }
}
