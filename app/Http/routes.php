<?php
Route::get('/', function () {
    return view('layouts.start');
});
Route::get('guide', function () {
  return view('layouts.guide');
});
Route::get('profile', [
    'uses'       => 'UsersController@showProfile',
    'as'         => 'student.profile'
]);
Route::post('profile', [
    'uses'       => 'UsersController@fetchScore',
    'as'         => 'student.score'
]);
Route::group(['prefix' => 'signup'], function () {
    Route::get('/', [
        'uses' => 'AuthController@showSignup',
        'as'   => 'auth.showSignup'
    ]);
    Route::post('/register', [
        'uses' => 'AuthController@signup',
        'as'   => 'auth.signup'
    ]);
});
Route::get('login', [
    'uses' => 'AuthController@showLogin',
    'as'   => 'auth.showLogin'
]);
Route::post('login', [
    'uses' => 'AuthController@login',
    'as'   => 'auth.login'
]);
Route::get('logout', [
    'uses' => 'AuthController@logout',
    'as'   => 'auth.logout'
]);
Route::group(['prefix' => 'examiner', 'middleware' => 'examiner.auth'], function () {
    Route::get('/', [
        'uses' => 'ExaminersController@index',
        'as'   => 'examiner.index'
    ]);
    Route::get('/check-status', [
        'uses' => 'ExaminersController@checkStartExamFlag',
        'as'   => 'examiner.check'
    ]);
    Route::post('/send-question', [
        'uses' => 'ExaminersController@sendQuestion',
        'as'   => 'examiner.send'
    ]);
    Route::get('/check-question', [
        'uses' => 'ExaminersController@checkNextQuestion',
        'as'   => 'examiner.checkNext'
    ]);
    Route::get('/check-finish', [
        'uses' => 'ExaminersController@checkFinishExamFlag',
        'as'   => 'examiner.finish'
    ]);
});
Route::group(['prefix' => 'questions', 'middleware' => 'student.auth'], function () {
    Route::get('/', [
        'uses' => 'QuestionsController@index',
        'as'   => 'questions.index'
    ]);
    Route::post('/set-status', [
        'uses' => 'QuestionsController@setStartExamFlag',
        'as'   => 'questions.set'
    ]);
    Route::post('/fetch-question', [
        'uses' => 'QuestionsController@fetchQuestion',
        'as'   => 'questions.fetch'
    ]);
    Route::post('/next-question', [
        'uses' => 'QuestionsController@nextQuestion',
        'as'   => 'questions.next'
    ]);
    Route::post('/wait-question', [
        'uses' => 'QuestionsController@waitQuestion',
        'as'   => 'questions.wait'
    ]);
});
Route::get('finish', function () {
    return view('layouts.finish');
});
Route::post('clear-cache', [
    'uses' => 'QuestionsController@clearCache',
    'as'   => 'questions.clear'
]);
Route::get('cache', [
    'uses' => 'QuestionsController@cache',
    'as'   => 'questions.cache'
]);
