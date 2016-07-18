<?php

namespace App\Http\Controllers\Exam;

use Hash;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Score;

class Auth extends Controller
{
    // show login form
    public function showLoginForm(Exam $exam) {
        if ($exam->type === config('constants.EXAM_PASSWORD_LIMITED') &&
            \Auth::guard('user')->guest()) {
            return redirect()->guest('login');
        }
        return view('exam.login', [
            'exam' => $exam,
            'teacher' => Teacher::find($exam->holder)
        ]);
    }
    // process import accounts and public password login
    public function login(Request $request, Exam $exam) {
        if ($exam->type === config('constants.EXAM_IMPORT_LIMITED')) {
            $this->validate($request, [
                'student' => 'required|max:16',
                'password' => 'required',
            ]);
            $student = Student::where('exam', $exam->id)
                ->where('student', $request->input('student'))
                ->first();
            if ($student && Hash::check($request->input('password'), $student->password)) {
                $student->last = \Carbon\Carbon::now();
                $student->ip = $request->ip();
                $student->save();
                // scores record
                Score::firstOrCreate(['id' => $student->id]);
                // store in session
                session([
                    $exam->getSessionKey() => (object)$student->toArray()
                ]);
                return redirect('exams/' . $exam->id);
            }
            return back()
                ->withInput(['student' => $request->input('student')])
                ->withErrors(['student' => trans('exam.auth.failed')]);
        } else if ($exam->type === config('constants.EXAM_PASSWORD_LIMITED')) {
            $this->validate($request, [
                'password' => 'required',
            ]);
            if ($request->input('password') === $exam->password) {
                $user = $request->user();
                $student = Student::where('exam', $exam->id)
                    ->where('student', $user->student)
                    ->first();
                if (is_null($student)) {
                    // first login, insert new record
                    $student = new Student;
                    $student->exam = $exam->id;
                    $student->student = $user->student;
                    $student->name = $user->name;
                    $student->major = $user->major;
                }
                $student->last = \Carbon\Carbon::now();
                $student->ip = $request->ip();
                $student->save();
                // scores record
                Score::firstOrCreate(['id' => $student->id]);
                // store in session
                session([
                    $exam->getSessionKey() => (object)$student->toArray()
                ]);
                return redirect('exams/' . $exam->id);
            }
            return back()
                ->withErrors(['password' => trans('exam.auth.password')]);
        }
    }

    // exam logout
    public function logout(Exam $exam)
    {
        session()->forget($exam->getSessionKey());
        return redirect('/exams');
    }

    // exam forbidden
    public function forbidden(Exam $exam)
    {
        return view('exam.forbidden', [
            'exam' => $exam
        ]);
    }
}
