<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controller
use App\Http\Controllers\Api\V1\Guest\AuthController as ApiGuestAuthController;
use App\Http\Controllers\Api\V1\Guest\PlaylistController as ApiGuestPlaylistController;
use App\Http\Controllers\Api\V1\Guest\MusicController as ApiGuestMusicController;
use App\Http\Controllers\Api\V1\Guest\CurhatController as ApiGuestCurhatController;

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

// Guests
Route::prefix('v1')
    ->as('api.')
    ->group(function () {
        // Testing
        Route::get('testing', function () {
            return response()->json([
                "success" => true,
                "message" => "berhasil testing"
            ]);
        });

        // Authentification
        Route::prefix('auth')
            ->as('auth.')
            ->group(function () {
                // Register
                Route::post('/register', [ApiGuestAuthController::class, 'register'])->name('register');
                // Login
                Route::post('/login', [ApiGuestAuthController::class, 'login'])->name('login');
            });

        // SubGroup with simple api validation grpup
        Route::middleware(['simpleapivalidation'])
            ->group(function () {
                // Playlist
                Route::prefix('playlists')
                    ->as('playlist.')
                    ->group(function () {
                        Route::get('/random', [ApiGuestPlaylistController::class, 'indexWithRandom'])->name('indexWithRandom');
                        Route::get('/{playListId}', [ApiGuestPlaylistController::class, 'show'])->name('show');
                        Route::get('/', [ApiGuestPlaylistController::class, 'index'])->name('index');
                    });

                // Musics
                Route::prefix('musics')
                    ->as('music.')
                    ->group(function () {
                        Route::get('/from-playlist/{playlistId}', [ApiGuestMusicController::class, 'getIndexFromPlaylistId'])->name('getIndexFromPlaylistId');
                        Route::get('/{musicId}', [ApiGuestMusicController::class, 'show']);
                    });

                // Curhats
                Route::prefix('curhatans')
                    ->as('curhatan.')
                    ->group(function () {
                        Route::get('/topic/{topicName}', [ApiGuestCurhatController::class, 'getIndexFromTopic'])->name('getIndexFromTopic');
                        Route::get('/{curhatanId}', [ApiGuestCurhatController::class, 'show'])->name('show');
                        Route::put('/{curhatanId}', [ApiGuestCurhatController::class, 'update'])->name('update');
                        Route::delete('/{curhatanId}', [ApiGuestCurhatController::class, 'delete'])->name('delete');
                        Route::get('/', [ApiGuestCurhatController::class, 'store'])->name('store');
                        Route::get('/', [ApiGuestCurhatController::class, 'index'])->name('index');
                    });

                // Mood Tracks
            });
    });



// Admin
// Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
//     // Permissions
//     Route::apiResource('permissions', 'PermissionsApiController');

//     // Roles
//     Route::apiResource('roles', 'RolesApiController');

//     // Users
//     Route::apiResource('users', 'UsersApiController');

//     // Music Item
//     Route::post('music-items/media', 'MusicItemApiController@storeMedia')->name('music-items.storeMedia');
//     Route::apiResource('music-items', 'MusicItemApiController');

//     // Playlist
//     Route::post('playlists/media', 'PlaylistApiController@storeMedia')->name('playlists.storeMedia');
//     Route::apiResource('playlists', 'PlaylistApiController');

//     // Music Topic
//     Route::post('music-topics/media', 'MusicTopicApiController@storeMedia')->name('music-topics.storeMedia');
//     Route::apiResource('music-topics', 'MusicTopicApiController');

//     // Curhatan
//     Route::post('curhatans/media', 'CurhatanApiController@storeMedia')->name('curhatans.storeMedia');
//     Route::apiResource('curhatans', 'CurhatanApiController');

//     // Comment
//     Route::post('comments/media', 'CommentApiController@storeMedia')->name('comments.storeMedia');
//     Route::apiResource('comments', 'CommentApiController');

//     // Journal
//     Route::post('journals/media', 'JournalApiController@storeMedia')->name('journals.storeMedia');
//     Route::apiResource('journals', 'JournalApiController');

//     // Mood Tracker
//     Route::apiResource('mood-trackers', 'MoodTrackerApiController');

//     // Mood Tracker Reason
//     Route::apiResource('mood-tracker-reasons', 'MoodTrackerReasonApiController');

//     // Journey
//     Route::apiResource('journeys', 'JourneyApiController');
// });
