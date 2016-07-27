<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// index
Route::get('/', function() {
    return redirect('/exams/');
});
// add auth routes(/login, /register, /password/reset ...)
Route::auth();
Route::get('/home', function() {
    return redirect('/');
});

// exam list
Route::get('/exams/{type?}', 'Exam\Exam@getExams')
    ->where('type', 'all|pending|running|ended');
// exam auth
Route::group([
    'namespace' => 'Exam',
    'prefix' => 'exam/{exam}',
], function() {
    // exam login with import accounts and public password
    Route::get('login', 'AuthController@getLogin');
    Route::post('login', 'AuthController@postLogin');
    // exam logout
    Route::get('logout', 'AuthController@getLogout');
    // exam forbidden
    Route::get('forbidden', 'AuthController@getForbidden');
});
// exam routes
Route::group([
    'namespace' => 'Exam',
    'middleware' => 'auth.exam',
    'prefix' => 'exam/{exam}',
], function() {
    // exam infomation
    Route::get('/', 'Exam@getIndex');
    // true-false question
    Route::get('true-false', 'TrueFalseQuestion@show');
    Route::post('true-false', 'TrueFalseQuestion@save');
    // multi-choice question
    Route::get('multi-choice', 'MultiChoiceQuestion@show');
    Route::post('multi-choice', 'MultiChoiceQuestion@save');
    // blank-fill question
    Route::get('blank-fill', 'BlankFillQuestion@show');
    Route::post('blank-fill', 'BlankFillQuestion@save');
    // short-answer question
    Route::get('short-answer', 'ShortAnswerQuestion@show');
    Route::post('short-answer', 'ShortAnswerQuestion@save');
    // general question
    Route::get('general', 'GeneralQuestion@show');
    Route::post('general', 'GeneralQuestion@save');
    // program-blank-fill question
    // Route::get('program-blank-fill', 'ProgramBlankFillQuestion@show');
    // Route::post('program-blank-fill', 'ProgramBlankFillQuestion@save');
    // program question
    Route::get('program', 'ProgramQuestion@index');
    Route::get('program/{question}', 'ProgramQuestion@show');
    Route::post('program/{question}', 'ProgramQuestion@save');
});

// admin auth
Route::group([
    'namespace' => 'Admin',
    'prefix' => 'admin',
], function() {
    // admin login
    Route::get('login', 'AuthController@getLogin');
    Route::post('login', 'AuthController@postLogin');
    // admin logout
    Route::get('logout', 'AuthController@getLogout');
    // admin register
    Route::get('register', 'AuthController@getRegister');
    Route::post('register', 'AuthController@postRegister');
    // admin password reset
    Route::get('password/reset/{token?}', 'PasswordController@getReset');
    Route::post('password/email', 'PasswordController@postEmail');
    Route::post('password/reset', 'PasswordController@postReset');
});
// admin routes
Route::group([
    'namespace' => 'Admin',
    'prefix' => 'admin',
    'middleware' => 'auth.admin',
], function() {
    // admin index
    Route::get('/', 'Admin@getIndex');
    // all exams holder by cureent admin
    Route::get('exams', 'Admin@getExams');
    // exam infomation
    Route::get('exam/{exam}', 'Exam@getExam');
    Route::post('exam/{exam}', 'Exam@postExam');
    Route::get('exam/{exam}/delete', 'Exam@getExamDelete');
    // students
    Route::get('exam/{exam}/student', 'Student@getStudents');
    Route::get('exam/{exam}/student/{student}', 'Student@getStudent');
    Route::get('exam/{exam}/student/new', 'Student@getStudentNew');
    Route::post('exam/{exam}/student', 'Student@postStudent');
    Route::get('exam/{exam}/student/{student}/delete', 'Student@getStudentDelete');
    // true-false questions
    Route::get('exam/{exam}/true-false', 'TrueFalseQuestion@getIndex');
    Route::get('exam/{exam}/true-false/{question}', 'TrueFalseQuestion@getQuestion');
    Route::post('exam/{exam}/true-false/{question}', 'TrueFalseQuestion@postQuestion');
    // multi-choice questions
    Route::get('exam/{exam}/multi-choice', 'MultiChoiceQuestion@getIndex');
    Route::get('exam/{exam}/multi-choice/{question}', 'MultiChoiceQuestion@getQuestion');
    Route::post('exam/{exam}/multi-choice/{question}', 'MultiChoiceQuestion@postQuestion');
    // blank-fill questions
    Route::get('exam/{exam}/blank-fill', 'BlankFillQuestion@getIndex');
    Route::get('exam/{exam}/blank-fill/{question}', 'BlankFillQuestion@getQuestion');
    Route::post('exam/{exam}/blank-fill/{question}', 'BlankFillQuestion@postQuestion');
    // short-answer questions
    Route::get('exam/{exam}/short-answer', 'ShortAnswerQuestion@getIndex');
    Route::get('exam/{exam}/short-answer/{question}', 'ShortAnswerQuestion@getQuestion');
    Route::post('exam/{exam}/short-answer/{question}', 'ShortAnswerQuestion@postQuestion');
    // blank-fill questions
    Route::get('exam/{exam}/general', 'GeneralQuestion@getIndex');
    Route::get('exam/{exam}/general/{question}', 'GeneralQuestion@getQuestion');
    Route::post('exam/{exam}/general/{question}', 'GeneralQuestion@postQuestion');
    // blank-fill questions
    Route::get('exam/{exam}/program', 'ProgramQuestion@getIndex');
    Route::get('exam/{exam}/program/{question}', 'ProgramQuestion@getQuestion');
    Route::post('exam/{exam}/program/{question}', 'ProgramQuestion@postQuestion');
});
