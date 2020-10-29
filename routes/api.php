<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::resource('admins', 'AdminAPIController');

Route::resource('users', 'UsersAPIController');

Route::resource('answers', 'AnswerAPIController');

Route::resource('candidates', 'CandidateAPIController');
Route::post('/candidates/login', 'CandidateAPIController@login');

Route::resource('jobs', 'JobAPIController');

Route::resource('job_applicants', 'JobApplicantAPIController');

Route::resource('tests', 'TestAPIController');