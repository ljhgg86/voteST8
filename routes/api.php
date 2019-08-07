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
Route::get('/chaosky/show/{id}','ChaoskyController@show')->middleware('cors');
//Route::post('/chaosky/updateReadnum','ChaoskyController@updateReadnum')->middleware('cors');
//Route::post('/voterecord/store','VoterecordController@store')->middleware('cors');
//Route::post('/voterecord/store111','VoterecordController@store')->middleware('cors','checkTipid');
Route::post('/voterecord/store222/{id}','VoterecordController@store222')->middleware('cors','checkTipid');
//Route::post('/votetitle/updateVotenum','VotetitleController@updateVotenum')->middleware('cors');
Route::post('/chaocomment/store','ChaocommentController@store')->middleware('cors');
Route::get('/chaocomment/getComments/{tipid}/{startid}/{counts}','ChaocommentController@getComments')->middleware('cors');
Route::get('/voteitem/getVoteitem/{id}','VoteitemController@getVoteitem')->middleware('cors');
