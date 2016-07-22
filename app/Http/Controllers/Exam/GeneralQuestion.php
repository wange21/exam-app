<?php

namespace App\Http\Controllers\Exam;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use ExamAuth;
use App\Models\Question;
use App\Models\AnswerGeneral as Answer;

/**
 * Exam general question
 */
class GeneralQuestion extends Controller
{
    // show all general questions
    public function show(ExamAuth $auth)
    {
        $questions = Question::where('exam', $auth->exam->id)
            ->where('type', config('constants.QUESTION_GENERAL'))
            ->orderBy('id', 'asc')
            ->get();

        $answers = Answer::where('student', $auth->student->id)->get()->keyBy('question');

        return view('exam.general', [
            'active' => 'general',
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
            ->where('type', config('constants.QUESTION_GENERAL'))
            ->pluck('id');

        foreach ($questions as $q) {
            $file = $request->file($q);
            $maxFileSize = \App\Utils::getSizeInBytes(ini_get('upload_max_filesize'));
            if ($file->isValid()) {
                $a = Answer::firstOrNew([
                    'student' => $auth->student->id,
                    'question' => $q,
                ]);
                $a->answer = $file->getClientOriginalName();
                $a->save();
                // move file
                $file->move(storage_path('files'), $q);
            }
        }

        return back();
    }
}
