<?php

namespace App\Http\Controllers\Exam;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use ExamAuth;
use App\Models\Question;
use App\Models\ProgramLimit;
use App\Models\AnswerProgram as Answer;

/**
 * Exam program question
 */
class ProgramQuestion extends Controller
{
    // redirect to the first program question
    public function index(ExamAuth $auth, Request $request)
    {
        $firstQuestion = Question::where('exam', $auth->exam->id)
            ->where('type', config('constants.QUESTION_PROGRAM'))
            ->orderBy('id', 'asc')
            ->value('id');
        return redirect('exams/'.$auth->exam->id.'/program/'.$firstQuestion);

    }
    // show specific program question
    public function show(ExamAuth $auth, Request $request)
    {
        $questionId = intval($request->route('program'));
        $questions = Question::select('id', 'score')
            ->where('exam', $auth->exam->id)
            ->where('type', config('constants.QUESTION_PROGRAM'))
            ->orderBy('id', 'asc')
            ->get();
        $answers = $answer = Answer::select('id', 'question', 'score')
            ->where('student', $auth->student->id)
            ->get();
        $answers = $answers->keyBy('question');
        foreach ($questions as &$q) {
            if (isset($answers[$q->id])) {
                if ($auth->ended) {
                    if ($answers[$q->id]->score > 0) {
                        $q->status = 'accepted';
                    } else {
                        $q->status = 'wrong';
                    }
                } else {
                    $q->status = 'touched';
                }
            } else {
                $q->status = 'untouched';
            }
        }

        $question = Question::join('question_program as p', 'questions.id', '=', 'p.id')
            ->findOrFail($questionId);

        $answer = Answer::where('student', $auth->student->id)
            ->where('question', $questionId)
            ->first();
        if ($answer) $question->answer = $answer->answer;

        //$limits = ProgramLimit::where('id', $question->id);

        return view('exam.program', [
            'active' => 'program',
            'auth' => $auth,
            'questions' => $questions,
            'question' => $question,
        ]);
    }
    // save answer
    public function save(ExamAuth $auth, Request $request)
    {
        $question = Question::find($request->route('program'));
        $answer = $request->input('code');

        if ($question && $answer) {
            $a = Answer::firstOrNew([
                'student' => $auth->student->id,
                'question' => $question->id,
            ]);
            $a->exam = $auth->exam->id;
            $a->answer = $answer;
            $a->save();
        }

        return back();
    }
}
