<?php

namespace App\Http\Controllers\Exam;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use ExamAuth;
use App\Models\Question;
use App\Models\AnswerTrueFalse as Answer;
use App\Models\StandardTrueFalse as Standard;

/**
 * Exam true-false question
 */
class TrueFalseQuestion extends Controller
{
    // show all true-false questions
    public function show(ExamAuth $auth)
    {
        $questions = Question::where('exam', $auth->exam->id)
            ->where('type', config('constants.QUESTION_TRUE_FALSE'))
            ->orderBy('id', 'asc')
            ->get();

        $answers = Answer::where('student', $auth->student->id)
            ->get();
        $answers = $answers->keyBy('question');

        return view('exam.true-false', [
            'active' => 'true-false',
            'auth' => $auth,
            'questions' => $questions,
            'answers' => $answers,
        ]);
    }
    // save answer
    public function save(ExamAuth $auth, Request $request)
    {
        $questions = Question::select('questions.score', 'standard.*')
            ->join('standard_true_false as standard', 'questions.id', '=', 'standard.id')
            ->where('exam', $auth->exam->id)
            ->where('type', config('constants.QUESTION_TRUE_FALSE'))
            ->get();

        foreach ($questions as $q) {
            if ($answer = $request->input($q->id)) {
                $a = Answer::firstOrNew([
                    'student' => $auth->student->id,
                    'question' => $q->id,
                ]);
                $a->answer = $answer;
                // score
                if ($answer === $q->answer) {
                    $a->score = $q->score;
                } else {
                    $a->score = 0;
                }
                $a->save();
            }
        }

        return back();
    }
}
