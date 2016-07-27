<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use AdminAuth as Auth;
use App\Models\Exam;

class Admin extends Controller
{
    public function getIndex(Request $request, Auth $auth)
    {
        $exams = Exam::where('holder', $auth->admin->id)
            ->orderBy('start', 'desc')
            ->take(5)
            ->get();

        return view('admin.index', [
            'auth' => $auth,
            'exams' => $exams,
        ]);
    }

    public function getExams(Request $request, Auth $auth)
    {
        $exams = Exam::where('holder', $auth->admin->id)
            ->orderBy('start', 'desc')
            ->paginate(15);

        return view('admin.exams', [
            'auth' => $auth,
            'exams' => $exams,
        ]);
    }
}
