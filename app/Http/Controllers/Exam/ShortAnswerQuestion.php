<?php

namespace App\Http\Controllers\Exam;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use ExamAuth;
use App\Models\Question;
use App\Models\AnswerShortAnswer as Answer;

/**
 * Exam short-answer question
 */
class ShortAnswerQuestion extends Controller
{
    // show all short-answer questions
    public function show(ExamAuth $auth)
    {
        $questions = Question::where('exam', $auth->exam->id)
            ->where('type', config('constants.QUESTION_SHORT_ANSWER'))
            ->orderBy('id', 'asc')
            ->get();

        $answers = Answer::where('student', $auth->student->id)->get()->keyBy('question');

        return view('exam.short-answer', [
            'active' => 'short-answer',
            'auth' => $auth,
            'questions' => $questions,
            'answers' => $answers,
        ]);
    }
    // save answer
    public function save(ExamAuth $auth, Request $request)
    {
        if ($auth->ended) return back();
        $questions = Question::where('exam', $auth->exam->id)
            ->where('type', config('constants.QUESTION_SHORT_ANSWER'))
            ->pluck('id');

        foreach ($questions as $q) {
            if ($answer = $request->input($q)) {
                $a = Answer::firstOrNew([
                    'student' => $auth->student->id,
                    'question' => $q,
                ]);
                $a->answer = $answer;
                $a->save();
            }
        }

        return back();
    }
}
