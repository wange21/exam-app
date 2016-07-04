<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Exam;

class ExamController extends Controller
{
    /**
     * Exam list
     */
    public function showList(Request $request, $type = 'all')
    {
        $exams = Exam::where('hidden', 0)
            ->join('teachers', 'exams.holder', '=', 'teachers.id')
            ->select('exams.id', 'exams.name', 'start', 'duration', 'teachers.name as teacher');

        if ($type === 'pending') {
            $exams = $exams->whereRaw("start > NOW()");
        } else if ($type === 'running') {
            $exams = $exams->whereRaw('start <= NOW()')
                ->whereRaw('ADDTIME(start, SEC_TO_TIME(duration)) >= NOW()');
        } else if ($type === 'ended') {
            $exams = $exams->whereRaw('ADDTIME(start, SEC_TO_TIME(duration)) < NOW()');
        }

        if ($keywords = $request->input('keywords')) {
            $exams = $exams->where('name', 'LIKE', "%$keywords%");
        }

        $exams = $exams->orderBy('start', 'desc')->paginate(10);
        if ($keywords) {
            $exams->appends(['keywords' => $keywords]);
        }

        return view('exam.list', [
            'type' => $type,
            'keywords' => $keywords,
            'exams' => $exams,
        ]);
    }

    /**
     * Exam detail
     */
    public function showDetail(Exam $exam) {
        return view('exam.detail', [
            'exam' => $exam
        ]);
    }
}
