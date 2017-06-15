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

//rutas a endpoints

Route::get('/twitter/search/{search_id}', 'PublicApiController@getTotalTweets');
Route::get('/twitter/search/{search_id}/user', 'PublicApiController@getTopUser');
Route::get('/twitter/search/{search_id}/hashtag', 'PublicApiController@getTopTenHashtag');
Route::get('/twitter/search/{search_id}/percents', 'PublicApiController@getTweetsPercents');
