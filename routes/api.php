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
Route::post('/answers/post-marks', 'AnswerAPIController@postMarksForAnswer');

Route::resource('candidates', 'CandidateAPIController');
Route::post('/candidates/login', 'CandidateAPIController@login');

Route::resource('jobs', 'JobAPIController');
Route::get('/test-for-jobs/{id}', 'JobAPIController@GetTestForJobs');
Route::get('/list-of-applicant-for-jobs/{id}', 'JobAPIController@GetListOfApplicantsForAJobs');
Route::get('/list-success-candidate-for-a-job/{id}', 'JobAPIController@GetListOfSuccessfulCandidateForAJobs');

Route::resource('job_applicants', 'JobApplicantAPIController');

Route::resource('tests', 'TestAPIController');

Route::resource('successful_candidates', 'SuccessfulCandidateAPIController');