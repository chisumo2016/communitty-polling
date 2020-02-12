<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiresource('polls',          'PollController');
Route::apiresource('questions',     'QuestionController');
Route::get('polls/{poll}/questions' ,'PollController@questions');
Route::get('files/get',                 'FilesController@show');

Route::any('errors','PollController@errors');
//Route::resource('polls/{id}','PollController');
