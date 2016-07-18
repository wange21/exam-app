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
    return view('index');
});

// exam list
Route::get('/exams/{type?}', 'Exam\Lists@show')
    ->where('type', 'all|pending|running|ended');

// exam auth
Route::group([
    'namespace' => 'Exam',
    'prefix' => 'exams/{exam}',
], function() {
    // exam login with import accounts and public password
    Route::get('login', 'Auth@showLoginForm');
    Route::post('login', 'Auth@login');
    // exam logout
    Route::get('logout', 'Auth@logout');
    // exam forbidden
    Route::get('forbidden', 'Auth@forbidden');
});
// exam routes
Route::group([
    'namespace' => 'Exam',
    'middleware' => 'auth.exam',
    'prefix' => 'exams/{exam}',
], function() {
    // exam infomation
    Route::get('/', 'Info@show');
    // exam true-false question
    Route::get('true-false', 'TrueFalseQuestion@show');
    Route::post('true-false', 'TrueFalseQuestion@save');
    // exam multi-choice question
    Route::get('multi-choice', 'MultiChoiceQuestion@show');
    Route::post('multi-choice', 'MultiChoiceQuestion@save');
    // exam blank-fill question
    Route::get('blank-fill', 'BlankFillQuestion@show');
    Route::post('blank-fill', 'BlankFillQuestion@save');
    // exam short-answer question
    Route::get('short-answer', 'ShortAnswerQuestion@show');
    Route::post('short-answer', 'ShortAnswerQuestion@save');
    // exam general question
    Route::get('general', 'GeneralQuestion@show');
    Route::post('general', 'GeneralQuestion@save');
    // exam program-blank-fill question
    Route::get('program-blank-fill', 'ProgramBlankFillQuestion@show');
    Route::post('program-blank-fill', 'ProgramBlankFillQuestion@save');
    // exam program question
    Route::get('program', 'ProgramQuestion@show');
    Route::post('program', 'ProgramQuestion@save');
});

// add auth routes(/login, /register, /password/reset ...)
Route::auth();
Route::get('/home', function() {
    return redirect('/');
});
