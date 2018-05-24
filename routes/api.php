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
Route::post('signup','UsersController@signup');
Route::post('verifyOtp','UsersController@verifyOtp');
Route::post('forgetPassword','UsersController@forgetPassword');
Route::post('updatePassword','UsersController@updatePassword');
Route::post('createProfile','UsersController@createProfile');
Route::post('sendEmail','UsersController@sendEmail');
Route::get('get-subject','UsersController@getSubjects');
Route::get('get-year','UsersController@getYears');
Route::post('get-papers-by-year','UsersController@getPapersByYear');
Route::post('change-email-contact','UsersController@ChangeEmailContact');
Route::post('comment','UsersController@comment');
Route::post('comment-like','UsersController@commentLike');



















