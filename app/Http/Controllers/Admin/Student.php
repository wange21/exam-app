<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthenticate as Auth;
use App\Models\Exam;
use App\Models\Student as StudentModel;

class Student extends controller
{
    public function getStudents(Auth $auth, Exam $exam)
    {
        if ($auth->admin->cannot('update', $exam)) {
            return redirect('/admin/exam/'.$exam->id);
        }
        $students = StudentModel::where('exam', $exam->id)->get();

        return view('admin.exam.students', [
            'auth' => $auth,
            'exam' => $exam,
            'students' => $students,
        ]);
    }

    public function getStudent(Request $request, Auth $auth, Exam $exam, StudentModel $student)
    {
        if ($auth->admin->cannot('update', $exam)) {
            return redirect('/admin/exam/'.$exam->id);
        }
        return view('admin.exam.student', [
            'auth' => $auth,
            'exam' => $exam,
            'student' => $student,
        ]);
    }

    public function postStudent(Request $request, Auth $auth, Exam $exam)
    {
        if ($auth->admin->cannot('update', $exam)) {
            return redirect('/admin/exam/'.$exam->id);
        }
        $this->validate($request, [
            'name' => 'required|max:16',
            'student' => 'required|max:16',
            'major' => 'max:32',
            'password' => 'required_without:id|min:6',
        ]);

        $student = StudentModel::firstOrNew([
            'id' => $request->input('id'),
            'exam' => $exam->id,
        ]);

        $student->name = $request->input('name');
        $student->student = $request->input('student');
        $student->major = $request->input('major');
        if ($request->input('password') !== '') $student->password = bcrypt($request->input('password'));
        $student->save();

        return redirect('/admin/exam/'.$exam->id.'/student');
    }

    public function getStudentNew(Auth $auth, Exam $exam)
    {
        if ($auth->admin->cannot('update', $exam)) {
            return redirect('/admin/exam/'.$exam->id);
        }
        return view('admin.exam.student-new', [
            'auth' => $auth,
            'exam' => $exam,
        ]);
    }

    // not a good idea for deleting item with GET method
    public function getStudentDelete(Auth $auth, Exam $exam, StudentModel $student)
    {
        if ($auth->admin->cannot('update', $exam) || $student->exam !== $exam->id) {
            return redirect('/admin/exam/'.$exam->id);
        }
        // delete answers
        \DB::delete('DELETE answers, answer_true_false, answer_multi_choice, answer_blank_fill, answer_short_answer, answer_general, answer_program' .
            ' FROM answers LEFT JOIN answer_true_false ON answers.id = answer_true_false.id' .
            ' LEFT JOIN answer_multi_choice ON answers.id = answer_multi_choice.id' .
            ' LEFT JOIN answer_blank_fill ON answers.id = answer_blank_fill.id' .
            ' LEFT JOIN answer_short_answer ON answers.id = answer_short_answer.id' .
            ' LEFT JOIN answer_general ON answers.id = answer_general.id' .
            ' LEFT JOIN answer_program ON answers.id = answer_program.id' .
            ' WHERE answers.student = ?'
        , [$student->id]);
        // delete student
        $student->delete();

        return redirect('/admin/exam/'.$exam->id.'/student');
    }
}
