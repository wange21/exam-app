<?php

namespace App\Http\Controllers\Exam;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use ExamAuth;
use App\Models\Question;
use App\Models\StandardBlankFill as Standard;
use App\Models\AnswerBlankFill as Answer;

/**
 * Exam blank-fill question
 */
class BlankFillQuestion extends Controller
{
    // show all true-false questions
    public function show(ExamAuth $auth)
    {
        $questions = Question::where('exam', $auth->exam->id)
            ->where('type', config('constants.QUESTION_BLANK_FILL'))
            ->orderBy('id', 'asc')
            ->get();

        $answers = Answer::where('student', $auth->student->id)
            ->get()
            ->reduce(function($as, $a) {
                $as[$a->question . '-' . $a->order] = $a->answer;
                return $as;
            }, []);


        foreach ($questions as $question) {
            $order = 0;
            $question->description = preg_replace_callback('/@@/', function($m) use (&$answers, &$question, &$order, &$auth) {
                $key = $question->id . '-' . $order++;
                $answer = isset($answers[$key]) ? $answers[$key] : '';
                return '<input class="form-control" type="text" name="'.$question->id.'[]" value="'.$answer.'"'.($auth->ended ? ' disabled' : '').' />';
            }, $question->description);
        }

        return view('exam.blank-fill', [
            'active' => 'blank-fill',
            'auth' => $auth,
            'questions' => $questions,
            'answers' => $answers,
        ]);
    }
    // save answer
    public function save(ExamAuth $auth, Request $request)
    {
        if ($auth->ended) return back();
        $questions = Question::select('id', 'score')
            ->where('exam', $auth->exam->id)
            ->where('type', config('constants.QUESTION_BLANK_FILL'))
            ->get();

        $standards = Standard::where('student', $auth->student->id)
            ->get()
            ->reduce(function($sds, $item) {
                $sds[$item->id.'-'.$item->order] = $item;
                return $sds;
            }, []);

        $oldAnswers = Answer::where('student', $auth->student->id)
            ->get()
            ->reduce(function($as, $a) {
                $as[$a->question . '-' . $a->order] = $a->answer;
                return $as;
            }, []);

        foreach ($questions as $q) {
            $answers = $request->input($q->id);
            if (is_null($answers)) $answers = [];

            $blanks = count($answers);
            for ($i = 0; $i < $blanks; $i++) {
                $oldAnswer = isset($oldAnswers[$q->id.'-'.$i]) ? $oldAnswers[$q->id.'-'.$i]->answer : null;
                $standardAnswer = isset($standards[$q->id.'-'.$i]) ? $standards[$q->id.'-'.$i]->answer : null;
                if ($answer = $answers[$i] || $oldAnswer) {
                    $a = Answer::firstOrNew([
                        'student' => $auth->student->id,
                        'question' => $q->id,
                        'order' => $i,
                    ]);
                    $a->answer = $answer;
                    if ($answer === $standardAnswer) {
                        $a->score = $q->score;
                    } else {
                        $a->score = 0;
                    }
                    $a->save();
                }
            }
        }

        return back();
    }
}
