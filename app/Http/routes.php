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
    return view('welcome');
});
// exam list
Route::get('/exams/{type?}', 'ExamController@showList')
    ->where('type', 'all|pending|running|ended');
// exam detail
Route::get('/exams/{exam?}', 'ExamController@showDetail')
    ->where('id', '\d+');
