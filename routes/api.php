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

Route::group(['middleware' => ['cors','checkTipid','checkIp','throttle:20']],function(){
    Route::post('/voterecord/storeB/11172','VoterecordController@store');
    Route::post('/voterecord/storeB/11173','VoterecordController@store');
    Route::post('/voterecord/storeB/11174','VoterecordController@store');
    Route::post('/voterecord/storeB/11175','VoterecordController@store');
    Route::post('/voterecord/storeB/11176','VoterecordController@store');
    Route::post('/voterecord/storeB/11177','VoterecordController@store');
    Route::post('/voterecord/storeB/11178','VoterecordController@store')->middleware('throttle:8');
    Route::post('/voterecord/storeB/11179','VoterecordController@store');
    Route::post('/voterecord/storeB/11180','VoterecordController@store');
    Route::post('/voterecord/storeB/11181','VoterecordController@store');
    Route::post('/voterecord/storeB/11182','VoterecordController@store')->middleware('throttle:10');
    Route::post('/voterecord/storeB/11183','VoterecordController@store');
    Route::post('/voterecord/storeB/11184','VoterecordController@store')->middleware('throttle:8');
    Route::post('/voterecord/storeB/11185','VoterecordController@store')->middleware('throttle:8');
    Route::post('/voterecord/storeB/11186','VoterecordController@store')->middleware('throttle:8');
    Route::post('/voterecord/storeB/11187','VoterecordController@store')->middleware('throttle:8');
    Route::post('/voterecord/storeB/11188','VoterecordController@store')->middleware('throttle:8');
    Route::post('/voterecord/storeB/11189','VoterecordController@store');
    Route::post('/voterecord/storeB/11190','VoterecordController@store')->middleware('throttle:8');
    Route::post('/voterecord/storeB/11191','VoterecordController@store');
});


