<?php

namespace App\Http\Controllers\Exam;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use ExamAuth;
use App\Models\Question;
use App\Models\AnswerBlankFill as Answer;

/**
 * Exam blank-fill question
 */
class BlankFillQuestion extends Controller
{
    // show all true-false questions
    public function show(ExamAuth $auth)
    {
        $answers = Answer::where('student', $auth->student->id)
            ->get();
        $answers = $answers->reduce(function($as, $a) {
            $as[$a->question . '-' . $a->order] = $a->answer;
            return $as;
        }, []);

        $questions = Question::where('exam', $auth->exam->id)
            ->where('type', config('constants.QUESTION_BLANK_FILL'))
            ->orderBy('id', 'asc')
            ->get();

        foreach ($questions as $question) {
            $order = 0;
            $question->description = preg_replace_callback('/@@/', function($m) use ($answers, $question, &$order) {
                $key = $question->id . '-' . $order++;
                $answer = isset($answers[$key]) ? $answers[$key] : '';
                return '<input class="form-control" type="text" name="' . $question->id . '[]" value="' . $answer . '" />';
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
        $questions = Question::where('exam', $auth->exam->id)
            ->where('type', config('constants.QUESTION_BLANK_FILL'))
            ->pluck('id');

        foreach ($questions as $q) {
            if ($answers = $request->input($q)) {
                $blanks = count($answers);
                for ($i = 0; $i < $blanks; $i++) {
                    if ($answer = $answers[$i]) {
                        $a = Answer::firstOrNew([
                            'student' => $auth->student->id,
                            'question' => $q,
                            'order' => $i,
                        ]);
                        $a->answer = $answer;
                        $a->save();
                    }
                }
            }
        }

        return back();
    }
}
