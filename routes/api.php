<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controller
use App\Http\Controllers\Api\V1\Guest\AuthController as ApiGuestAuthController;
use App\Http\Controllers\Api\V1\Guest\UserController as ApiGuestUserController;
use App\Http\Controllers\Api\V1\Guest\PlaylistController as ApiGuestPlaylistController;
use App\Http\Controllers\Api\V1\Guest\MusicController as ApiGuestMusicController;
use App\Http\Controllers\Api\V1\Guest\CurhatController as ApiGuestCurhatController;
use App\Http\Controllers\Api\V1\Guest\CommentController as ApiGuestCommentController;
use App\Http\Controllers\Api\V1\Guest\CurhatanLikeController as ApiGuestCurhatanLikesController;
use App\Http\Controllers\Api\V1\Guest\MoodTrackerController as ApiGuestMoodTrackerController;
use App\Http\Controllers\Api\V1\Guest\JourneyController as ApiGuestJourneyController;
use App\Http\Controllers\Api\V1\Guest\QuoteController as ApiGuestQuoteController;
use App\Http\Controllers\Api\V1\Guest\UserStoreJourneyComponentController as ApiGuestComponentHistory;

// Models
use App\Models\User;

// Helpers
use Illuminate\Support\Carbon;

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
            $tanggal12Oktober = Carbon::make("2021-10-13");
            // User lebih dari tanggal itu
            $ramdani = User::find(4);
            return response()->json([
                "success" => true,
                "message" => "berhasil testing",
                "12 oktober" => $tanggal12Oktober,
                "ramdani created" => $ramdani->created_at,
                "boolean" => $ramdani->created_at > $tanggal12Oktober,
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

                // User
                Route::prefix('user')
                    ->as('user.')
                    ->group(function () {
                        // Getuser by id
                        Route::post('/get_user', [ApiGuestUserController::class, 'getUserById'])->name('getUserById');
                    });

                // Playlist
                Route::prefix('playlists')
                    ->as('playlist.')
                    ->group(function () {
                        Route::get('/category/{categoryName}', [ApiGuestPlaylistController::class, 'getFromCategory'])->name('getFromCategory');
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
                        Route::get('/category/{categoryName}', [ApiGuestCurhatController::class, 'getIndexFromCategory'])->name('getIndexFromCategory');
                        Route::get('/{curhatanId}', [ApiGuestCurhatController::class, 'show'])->name('show');
                        Route::put('/{curhatanId}', [ApiGuestCurhatController::class, 'update'])->name('update');
                        Route::delete('/{curhatanId}', [ApiGuestCurhatController::class, 'delete'])->name('delete');
                        Route::post('/', [ApiGuestCurhatController::class, 'store'])->name('store');
                        Route::get('/', [ApiGuestCurhatController::class, 'index'])->name('index');
                    });

                // Comment
                Route::prefix('comments')
                    ->as('comment.')
                    ->group(function () {
                        Route::post('/', [ApiGuestCommentController::class, 'store'])->name('store');
                    });

                // Curhat Likes
                Route::prefix('likes')
                    ->as('like.')
                    ->group(function () {
                        Route::put('/', [ApiGuestCurhatanLikesController::class, 'like'])->name('like');
                    });

                // Mood Tracks
                Route::prefix('mood-tracks')
                    ->as('mood-track.')
                    ->group(function () {
                        Route::post('/index-harian', [ApiGuestMoodTrackerController::class, 'indexHarian'])->name('indexHarian');
                        Route::post('/index-mingguan', [ApiGuestMoodTrackerController::class, 'indexMingguan'])->name('indexMingguan');
                        Route::get('/home', [ApiGuestMoodTrackerController::class, 'home'])->name('home'); // Ketika akan mengakses HOME saat membuka aplikasi
                        Route::post('/', [ApiGuestMoodTrackerController::class, 'store'])->name('store'); // Ketika menyimpan
                    });

                // Journey
                Route::prefix('journeys')
                    ->as('journey.')
                    ->group(function () {
                        Route::post('/journal-submission', [ApiGuestComponentHistory::class, 'storeJournalHistory'])->name('storeJournalHistory');
                        Route::post('/music-submission', [ApiGuestComponentHistory::class, 'storeMusicHistory'])->name('storeMusicHistory');
                        Route::get('/component/{journeyId}', [ApiGuestJourneyController::class, 'getComponent'])->name('getComponent');
                        Route::get('/{journeyId}', [ApiGuestJourneyController::class, 'show'])->name('show');
                        Route::get('/', [ApiGuestJourneyController::class, 'index'])->name('index');
                    });

                // Quote
                Route::prefix('quotes')
                    ->as('quote.')
                    ->group(function () {
                        Route::get('/random', [ApiGuestQuoteController::class, 'getRandomQuote'])->name('getRandomQuote');
                        Route::get('/{journey_id}', [ApiGuestQuoteController::class, 'show'])->name('show');
                    });
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
