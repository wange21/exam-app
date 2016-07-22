<?php

namespace App\Http\Controllers\Exam;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use ExamAuth;
use App\Models\Question;
use App\Models\AnswerMultiChoice as Answer;
use App\Models\StandardMultiChoice as Standard;

/**
 * Exam true-false question
 */
class MultiChoiceQuestion extends Controller
{
    // show all true-false questions
    public function show(ExamAuth $auth)
    {
        // answers
        $answers = Answer::where('student', $auth->student->id)->get()->keyBy('question');
        $questions = Question::join('question_multi_choice as mc', 'mc.id', '=', 'questions.ref')
            ->where('exam', $auth->exam->id)
            ->where('type', config('constants.QUESTION_MULTI_CHOICE'))
            ->orderBy('questions.id', 'asc')
            ->get()
            ->reduce(function($qs, $q) {
                if (isset($qs[$q->id])) {
                    $qs[$q->id]->options[] =  (object)[
                        'order' => $q->order,
                        'option' => $q->option
                    ];
                } else {
                    $qs[$q->id] = (object)[
                        'id' => $q->id,
                        'description' => $q->description,
                        'score' => $q->score,
                        'source' => $q->source,
                        'options' => [
                            (object)[
                                'order' => $q->order,
                                'option' => $q->option,
                            ]
                        ],
                        'answer' => isset($answers[$q->id]) ? $answers[$q->id]->answer : 0
                    ];
                }
                return $qs;
            }, []);

        return view('exam.multi-choice', [
            'active' => 'multi-choice',
            'auth' => $auth,
            'questions' => $questions,
        ]);
    }

    // save answer
    public function save(ExamAuth $auth, Request $request)
    {
        if ($auth->ended) return back();
        $questions = Question::select('questions.id', 'score', 'answer')
            ->leftJoin('standard_multi_choice as mc', 'mc.id', '=', 'questions.id')
            ->where('exam', $auth->exam->id)
            ->where('type', config('constants.QUESTION_MULTI_CHOICE'))
            ->get();

        $oldAnswers = Answer::where('student', $auth->student->id)->get()->keyBy('question');
        foreach ($questions as $q) {
            $answers = $request->input($q->id);
            $oldAnswer = isset($oldAnswers[$q->id]) ? $oldAnswers[$q->id]->answer : null;
            if ($answers || $oldAnswer) {
                if (is_null($answers)) $answers = [];
                $answer = 0;
                foreach ($answers as $a) {
                    $answer |= 1 << $a;
                }
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
