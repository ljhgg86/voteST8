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
//Route::post('/voterecord/storeAll','VoterecordController@store')->middleware('cors');
//Route::post('/voterecord/store/{id}','VoterecordController@storeList')->middleware('cors','checkTipid');
//Route::post('/votetitle/updateVotenum','VotetitleController@updateVotenum')->middleware('cors');
Route::post('/chaocomment/store','ChaocommentController@store')->middleware('cors');
Route::get('/chaocomment/getComments/{tipid}/{startid}/{counts}','ChaocommentController@getComments')->middleware('cors');
Route::get('/voteitem/getVoteitem/{id}','VoteitemController@getVoteitem')->middleware('cors');

Route::post('/voterecord/storeA/11172','VoterecordController@store')->middleware('cors');
Route::post('/voterecord/storeA/11173','VoterecordController@store')->middleware('cors');
Route::post('/voterecord/storeA/11174','VoterecordController@store')->middleware('cors');
Route::post('/voterecord/storeA/11175','VoterecordController@store')->middleware('cors');
Route::post('/voterecord/storeA/11176','VoterecordController@store')->middleware('cors');
Route::post('/voterecord/storeA/11177','VoterecordController@store')->middleware('cors');
Route::post('/voterecord/storeA/11178','VoterecordController@store')->middleware('cors');
Route::post('/voterecord/storeA/11179','VoterecordController@store')->middleware('cors');
Route::post('/voterecord/storeA/11180','VoterecordController@store')->middleware('cors');
Route::post('/voterecord/storeA/11181','VoterecordController@store')->middleware('cors');
Route::post('/voterecord/storeA/11182','VoterecordController@store')->middleware('cors');
Route::post('/voterecord/storeA/11183','VoterecordController@store')->middleware('cors');
Route::post('/voterecord/storeA/11184','VoterecordController@store')->middleware('cors');
Route::post('/voterecord/storeA/11185','VoterecordController@store')->middleware('cors');
Route::post('/voterecord/storeA/11186','VoterecordController@store')->middleware('cors');
Route::post('/voterecord/storeA/11187','VoterecordController@store')->middleware('cors');
Route::post('/voterecord/storeA/11188','VoterecordController@store')->middleware('cors');
Route::post('/voterecord/storeA/11189','VoterecordController@store')->middleware('cors');
Route::post('/voterecord/storeA/11190','VoterecordController@store')->middleware('cors');
Route::post('/voterecord/storeA/11191','VoterecordController@store')->middleware('cors');
