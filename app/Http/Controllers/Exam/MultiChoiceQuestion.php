<?php

namespace App\Http\Controllers\Exam;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use ExamAuth;
use App\Models\Question;
use App\Models\AnswerMultiChoice as Answer;

/**
 * Exam true-false question
 */
class MultiChoiceQuestion extends Controller
{
    // show all true-false questions
    public function show(ExamAuth $auth)
    {
        // answers
        $answers = Answer::where('student', $auth->student->id)
            ->get();
        $answers = $answers->keyBy('question');

        $questions = Question::join('question_multi_choice as mc', 'mc.id', '=', 'questions.ref')
            ->where('exam', $auth->exam->id)
            ->where('type', config('constants.QUESTION_MULTI_CHOICE'))
            ->orderBy('questions.id', 'asc')
            ->get();

        $qs = [];
        $current = null;
        foreach($questions as $q) {
            if ($current && $current->id === $q->id) {
                $current->options[] = (object)[
                    'order' => $q->order,
                    'option' => $q->option
                ];
            } else {
                if ($current) $qs[] = $current;
                $current = (object)[
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
        }
        $qs[] = $current;

        return view('exam.multi-choice', [
            'active' => 'multi-choice',
            'auth' => $auth,
            'questions' => $qs,
        ]);
    }

    // save answer
    public function save(ExamAuth $auth, Request $request)
    {
        $questions = Question::where('exam', $auth->exam->id)
            ->where('type', config('constants.QUESTION_MULTI_CHOICE'))
            ->pluck('id');

        foreach ($questions as $q) {
            if ($answers = $request->input($q)) {
                $answer = 0;
                foreach ($answers as $a) {
                    $answer |= 1 << $a;
                }
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
