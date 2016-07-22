<?php

namespace App\Http\Controllers\Exam;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use ExamAuth;
use App\Models\Question;
use App\Models\StandardTrueFalse as Standard;
use App\Models\AnswerTrueFalse as Answer;

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

        $answers = Answer::where('student', $auth->student->id)->get()->keyBy('question');

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
        if ($auth->ended) return back();
        $questions = Question::select('questions.id', 'score', 'answer')
            ->leftJoin('standard_true_false as tf', 'tf.id', '=', 'questions.id')
            ->where('exam', $auth->exam->id)
            ->where('type', config('constants.QUESTION_TRUE_FALSE'))
            ->get();

        $oldAnswers = Answer::where('student', $auth->student->id)->get()->keyBy('question');
        foreach ($questions as $q) {
            $answer = $request->input($q->id);
            $oldAnswer = isset($oldAnswers[$q->id]) ? $oldAnswers[$q->id]->answer : null;
            if ($answer || $oldAnswer) {
                // skip for performence
                if ($answer === $oldAnswer) continue;
                $a = Answer::firstOrNew([
                    'student' => $auth->student->id,
                    'question' => $q->id,
                ]);
                $a->answer = $answer;
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
