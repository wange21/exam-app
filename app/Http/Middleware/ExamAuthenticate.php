<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use DB;
use App\Models\Exam;
use App\Models\Student;
use App\Models\Question;
use App\Models\Score;
use Carbon\Carbon;

class ExamAuthenticate
{
    // exam object
    public $exam;
    // student object
    public $student;
    // exam status
    public $pending = false;
    public $running = false;
    public $ended = false;
    // exam questions
    public $questions;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $exam = Exam::findOrFail($request->route('exam'));
        $student = session($exam->getSessionKey());
        // student id limited, global account login required
        if ($exam->type === config('constants.EXAM_STUDENTID_LIMITED')) {
            if (Auth::guard('user')->guest()) {
                return redirect()->guest('login');
            }

            if (is_null($student)) {
                $user = Auth::user();
                if ($student = Student::where('exam', $exam->id)
                    ->where('student', $user->student)
                    ->first()
                ) { // current student allow in this exam
                    // save information from user
                    $student->name = $user->name;
                    $student->major = $user->major;
                    $student->last = Carbon::now();
                    $student->ip = $request->ip();
                    $student->save();
                    // scores record
                    Score::firstOrCreate(['id' => $student->id]);
                    // store in session
                    session([
                        $exam->getSessionKey() => (object)$student->toArray()
                    ]);
                } else {
                    return redirect('exams/' . $exam->id . '/forbidden');
                }
            }
        } else if ($exam->type === config('constants.EXAM_IMPORT_LIMITED')) {
            if (is_null($student) || $student->exam !== $exam->id) {
                return redirect()->guest('exams/' . $exam->id . '/login');
            }
        } else if ($exam->type === config('constants.EXAM_PASSWORD_LIMITED')) {
            if (Auth::guard('user')->guest() || $student === null ||
                $student->exam !== $exam->id) {
                return redirect()->guest('exams/' . $exam->id . '/login');
            }
        }

        // exam infomation
        $this->exam = $exam;
        // current login student
        $this->student = $student;
        // exam status
        if ($exam->start > Carbon::now()) {
            $this->pending = true;
        } else if ($exam->start->addSeconds($exam->duration) < Carbon::now()) {
            $this->ended = true;
        } else {
            $this->running = true;
        }

        // if exam is pending, redirect all request to info page
        if ($this->pending && $request->route()->getActionName() !== 'App\Http\Controllers\Exam\Info@show') {
            return redirect('exams/'.$exam->id);
        }

        // exam questions
        $questions = Question::selectRaw('type, count(*) as count')
            ->where('exam', $exam->id)
            ->groupBy('type')
            ->get();
        $qs = [
            'trueFalse' => false,
            'multiChoice' => false,
            'blankFill' => false,
            'shortAnswer' => false,
            'general' => false,
            'programBlankFill' => false,
            'program' => false,
        ];
        $qsKeys = array_keys($qs);
        $questions = $questions->reduce(function($qs, $q) use ($qsKeys) {
            $qs[$qsKeys[$q->type]] = $q->count;
            return $qs;
        }, $qs);

        $this->questions = $questions;

        return $next($request);
    }
}
