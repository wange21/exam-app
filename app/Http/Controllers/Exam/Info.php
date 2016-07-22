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
        if ($auth->pending) {
            return view('exam.info', [
                'auth' => $auth,
                'active' => 'info'
            ]);
        }

        $models = collect([
            \App\Models\AnswerTrueFalse::class,
            \App\Models\AnswerMultiChoice::class,
            \App\Models\AnswerBlankFill::class,
            \App\Models\AnswerShortAnswer::class,
            \App\Models\AnswerGeneral::class,
            null, // \App\Models\AnswerProgramBlankFill::class,
            \App\Models\AnswerProgram::class,
        ]);
        $answers = $models->reduce(function($as, $model) use (&$auth) {
            if (is_null($model)) {
                $as[] = [];
            } else {
                $as[] = $model::select('question', 'score')
                    ->where('student', $auth->student->id)
                    ->get()
                    ->keyBy('question');
            }
            return $as;
        }, []);

        $questiosTypes = [
            'trueFalse',
            'multiChoice',
            'blankFill',
            'shortAnswer',
            'general',
            'programBlankFill',
            'program',
        ];

        $questions = Question::select('id', 'type', 'score')
            ->where('exam', $auth->exam->id)
            ->orderBy('id', 'asc')
            ->get()
            ->reduce(function($qs, $q) use ($questiosTypes, &$answers, &$auth) {
                if (isset($answers[$q->type][$q->id])) {
                    $q->scoreGet = $answers[$q->type][$q->id]->score;
                    if ($auth->ended && $q->scoreGet !== null) {
                        if ($q->scoreGet > 0) {
                            $q->status = 'accepted';
                        } else {
                            $q->status = 'wrong';
                        }
                    } else {
                        $q->status = 'touched';
                    }
                } else {
                    $q->scoreGet = 0;
                    $q->status = 'untouched';
                }
                $qs[$questiosTypes[$q->type]][] = $q;
                return $qs;
            }, []);

        return view('exam.info', [
            'active' => 'info',
            'auth' => $auth,
            'questions' => $questions,
            'questionTypes' => $questiosTypes,
        ]);
    }
}
