<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Music Item
    Route::delete('music-items/destroy', 'MusicItemController@massDestroy')->name('music-items.massDestroy');
    Route::post('music-items/media', 'MusicItemController@storeMedia')->name('music-items.storeMedia');
    Route::post('music-items/ckmedia', 'MusicItemController@storeCKEditorImages')->name('music-items.storeCKEditorImages');
    Route::resource('music-items', 'MusicItemController');

    // Playlist
    Route::delete('playlists/destroy', 'PlaylistController@massDestroy')->name('playlists.massDestroy');
    Route::post('playlists/media', 'PlaylistController@storeMedia')->name('playlists.storeMedia');
    Route::post('playlists/ckmedia', 'PlaylistController@storeCKEditorImages')->name('playlists.storeCKEditorImages');
    Route::resource('playlists', 'PlaylistController');

    // Music Topic
    Route::delete('music-topics/destroy', 'MusicTopicController@massDestroy')->name('music-topics.massDestroy');
    Route::post('music-topics/media', 'MusicTopicController@storeMedia')->name('music-topics.storeMedia');
    Route::post('music-topics/ckmedia', 'MusicTopicController@storeCKEditorImages')->name('music-topics.storeCKEditorImages');
    Route::resource('music-topics', 'MusicTopicController');

    // Curhatan
    Route::delete('curhatans/destroy', 'CurhatanController@massDestroy')->name('curhatans.massDestroy');
    Route::post('curhatans/media', 'CurhatanController@storeMedia')->name('curhatans.storeMedia');
    Route::post('curhatans/ckmedia', 'CurhatanController@storeCKEditorImages')->name('curhatans.storeCKEditorImages');
    Route::resource('curhatans', 'CurhatanController');

    // Comment
    Route::delete('comments/destroy', 'CommentController@massDestroy')->name('comments.massDestroy');
    Route::post('comments/media', 'CommentController@storeMedia')->name('comments.storeMedia');
    Route::post('comments/ckmedia', 'CommentController@storeCKEditorImages')->name('comments.storeCKEditorImages');
    Route::resource('comments', 'CommentController');

    // Journal
    Route::delete('journals/destroy', 'JournalController@massDestroy')->name('journals.massDestroy');
    Route::post('journals/media', 'JournalController@storeMedia')->name('journals.storeMedia');
    Route::post('journals/ckmedia', 'JournalController@storeCKEditorImages')->name('journals.storeCKEditorImages');
    Route::resource('journals', 'JournalController');

    // Mood Tracker
    Route::delete('mood-trackers/destroy', 'MoodTrackerController@massDestroy')->name('mood-trackers.massDestroy');
    Route::resource('mood-trackers', 'MoodTrackerController');

    // Mood Tracker Reason
    Route::delete('mood-tracker-reasons/destroy', 'MoodTrackerReasonController@massDestroy')->name('mood-tracker-reasons.massDestroy');
    Route::resource('mood-tracker-reasons', 'MoodTrackerReasonController');

    // Journey
    Route::delete('journeys/destroy', 'JourneyController@massDestroy')->name('journeys.massDestroy');
    Route::resource('journeys', 'JourneyController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});