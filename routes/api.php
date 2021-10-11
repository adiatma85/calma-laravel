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

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Music Item
    Route::post('music-items/media', 'MusicItemApiController@storeMedia')->name('music-items.storeMedia');
    Route::apiResource('music-items', 'MusicItemApiController');

    // Playlist
    Route::post('playlists/media', 'PlaylistApiController@storeMedia')->name('playlists.storeMedia');
    Route::apiResource('playlists', 'PlaylistApiController');

    // Music Topic
    Route::post('music-topics/media', 'MusicTopicApiController@storeMedia')->name('music-topics.storeMedia');
    Route::apiResource('music-topics', 'MusicTopicApiController');

    // Curhatan
    Route::post('curhatans/media', 'CurhatanApiController@storeMedia')->name('curhatans.storeMedia');
    Route::apiResource('curhatans', 'CurhatanApiController');

    // Comment
    Route::post('comments/media', 'CommentApiController@storeMedia')->name('comments.storeMedia');
    Route::apiResource('comments', 'CommentApiController');

    // Journal
    Route::post('journals/media', 'JournalApiController@storeMedia')->name('journals.storeMedia');
    Route::apiResource('journals', 'JournalApiController');

    // Mood Tracker
    Route::apiResource('mood-trackers', 'MoodTrackerApiController');

    // Mood Tracker Reason
    Route::apiResource('mood-tracker-reasons', 'MoodTrackerReasonApiController');

    // Journey
    Route::apiResource('journeys', 'JourneyApiController');
});

