<?php

namespace App\Http\Controllers\Exam;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Exam;

/**
 * Must use Lists as class name, because List is a reserved keyword
 */
class Lists extends Controller
{
    /**
     * Exam list
     */
    public function show(Request $request, $type = 'all')
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
            $exams = $exams->where('exams.name', 'LIKE', "%$keywords%");
        }

        $exams = $exams->orderBy('start', 'desc')->paginate(12);
        if ($keywords) {
            $exams->appends(['keywords' => $keywords]);
        }

        return view('exam.list', [
            'type' => $type,
            'keywords' => $keywords,
            'exams' => $exams,
        ]);
    }
}
