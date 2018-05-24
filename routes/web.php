<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('logout','AdminController@logout');

Route::get('login','AdminController@login');
Route::post('login','AdminController@signin');
Route::get('profile','AdminController@profile');
Route::get('users','AdminController@users');
Route::get('block/{id}','AdminController@block');
Route::get('unblock/{id}','AdminController@unblock');
Route::get('news-mgt','AdminController@news');
Route::get('edit-profile','AdminController@editProfile');
Route::post('edit-profile','AdminController@updateProfile');

Route::get('change-password','AdminController@changePassword');
Route::post('change-password','AdminController@updatePassword');
Route::get('question-mgt','AdminController@questionMgt');
Route::get('edit-part','AdminController@selectClassEditPart');
Route::post('add-educations','AdminController@addEducations');
Route::post('delete-educations','AdminController@deleteEducations');



Route::post('edit-part','AdminController@education');
//Route::post('','AdminController@education');
Route::post('delete-year','AdminController@deleteYear');
Route::post('add-year','AdminController@addYear');
Route::post('delete-exam','AdminController@deleteExam');
Route::post('add-exam','AdminController@addExam');

Route::get('edit-year','AdminController@editYear');
Route::get('edit-exam','AdminController@editExam');
Route::get('edit-visiblity','AdminController@editVisiblity');

// Route::get('question-category','AdminController@showQuestionCategory');
// Route::get('question-type','AdminController@questionType');



Route::get('question-category','AdminController@showQuestionCategory');
Route::get('question-type','AdminController@questionType');
Route::get('edit-subject','AdminController@editSubject');
Route::get('edit-topic','AdminController@editTopic');
Route::get('edit-topic-section','AdminController@editTopicSection');
Route::get('edit-topic-sub-section','AdminController@editTopicSubSection');
Route::post('delete-subject','AdminController@deleteSubject');
Route::post('add-subject','AdminController@addSubject');
Route::post('delete-topic','AdminController@deleteTopic');
Route::post('add-topic','AdminController@addTopic');

Route::post('delete-topic-section','AdminController@deleteTopicSection');
Route::post('add-topic-sections','AdminController@addTopicSection');

Route::post('delete-topic-sub-section','AdminController@deleteTopicSubSection');
Route::post('add-topic-sub-sections','AdminController@addTopicSubSection');
Route::get('question-list','AdminController@questionList');
Route::get('correct-answer/{id}','AdminController@correctAnswer');
Route::get('delete-question/{id}','AdminController@deleteQuestion');













