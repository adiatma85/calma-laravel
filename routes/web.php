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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\PermissionsController as AdminPermissionsControlelr;
use App\Http\Controllers\Admin\RolesController as AdminRolesController;
use App\Http\Controllers\Admin\UsersController as AdminUsersController;
use App\Http\Controllers\Admin\MusicItemController as AdminMusicItemController;
use App\Http\Controllers\Admin\PlaylistController as AdminPlaylistController;
use App\Http\Controllers\Admin\MusicTopicController as AdminMusicTopicController;
use App\Http\Controllers\Admin\CurhatanController as AdminCurhatanController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\JournalController as AdminJournalController;
use App\Http\Controllers\Admin\MoodTrackerController as AdminMoodTrackerController;
use App\Http\Controllers\Admin\MoodTrackerReasonController as AdminMoodTrackerReasonController;
use App\Http\Controllers\Admin\JourneyController as AdminJourneyController;

// Auth
use App\Http\Controllers\Auth\ChangePasswordController as AuthChangePasswordController;

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::prefix('admin')
    ->as('admin.')
    ->middleware(['auth'])
    ->group(function () {
        // Home Page
        Route::get('/', [AdminHomeController::class, 'index'])->name('home');

        // Permissions
        Route::delete('permissions/destroy', [AdminPermissionsControlelr::class, 'massDestroy'])->name('permissions.massDestroy');
        Route::resource('permissions', AdminPermissionsControlelr::class);

        // Roles
        Route::delete('roles/destroy', [AdminRolesController::class, 'massDestroy'])->name('roles.massDestroy');
        Route::resource('roles', AdminRolesController::class);

        // Users
        Route::delete('users/destroy', [AdminUsersController::class, 'massDestroy'])->name('users.massDestroy');
        Route::resource('users', AdminUsersController::class);

        // Music Item
        Route::delete('music-items/destroy', [AdminMusicItemController::class, 'massDestroy'])->name('music-items.massDestroy');
        Route::post('music-items/media', [AdminMusicItemController::class, 'storeMedia'])->name('music-items.storeMedia');
        Route::post('music-items/ckmedia', [AdminMusicItemController::class, 'storeCKEditorImages'])->name('music-items.storeCKEditorImages');
        Route::resource('music-items', AdminMusicItemController::class);

        // Playlist
        Route::delete('playlists/destroy', [AdminPlaylistController::class, "massDestroy"])->name('playlists.massDestroy');
        Route::post('playlists/media', [AdminPlaylistController::class, "storeMedia"])->name('playlists.storeMedia');
        Route::post('playlists/ckmedia', [AdminPlaylistController::class, "storeCKEditorImages"])->name('playlists.storeCKEditorImages');
        Route::resource('playlists', AdminPlaylistController::class);

        // Music Topic
        Route::delete('music-topics/destroy', [AdminMusicTopicController::class, 'massDestroy'])->name('music-topics.massDestroy');
        Route::post('music-topics/media', [AdminMusicTopicController::class, 'storeMEdia'])->name('music-topics.storeMedia');
        Route::post('music-topics/ckmedia', [AdminMusicTopicController::class, 'storeCKEditorImages'])->name('music-topics.storeCKEditorImages');
        Route::resource('music-topics', AdminMusicTopicController::class);

        // Curhatan
        Route::delete('curhatans/destroy', [AdminCurhatanController::class, 'massDestroy'])->name('curhatans.massDestroy');
        Route::post('curhatans/media', [AdminCurhatanController::class, 'storeMedia'])->name('curhatans.storeMedia');
        Route::post('curhatans/ckmedia', [AdminCurhatanController::class, 'storeCKEditorImages'])->name('curhatans.storeCKEditorImages');
        Route::resource('curhatans', AdminCurhatanController::class);

        // Comment
        Route::delete('comments/destroy', [AdminCommentController::class, 'massDestroy'])->name('comments.massDestroy');
        Route::post('comments/media', [AdminCommentController::class, 'storeMedia'])->name('comments.storeMedia');
        Route::post('comments/ckmedia', [AdminCommentController::class, 'storeCKEditorImages'])->name('comments.storeCKEditorImages');
        Route::resource('comments', AdminCommentController::class);

        // Journal
        Route::delete('journals/destroy', [AdminJournalController::class, 'massDestroy'])->name('journals.massDestroy');
        Route::post('journals/media', [AdminJournalController::class, 'storeMedia'])->name('journals.storeMedia');
        Route::post('journals/ckmedia', [AdminJournalController::class, 'storeCKEditorImages'])->name('journals.storeCKEditorImages');
        Route::resource('journals', AdminJournalController::class);

        // Mood Tracker
        Route::delete('mood-trackers/destroy', [AdminMoodTrackerController::class, 'massDestroy'])->name('mood-trackers.massDestroy');
        Route::resource('mood-trackers', AdminMoodTrackerController::class);

        // Mood Tracker Reason
        Route::delete('mood-tracker-reasons/destroy', [AdminMoodTrackerReasonController::class, 'massDestroy'])->name('mood-tracker-reasons.massDestroy');
        Route::resource('mood-tracker-reasons', AdminMoodTrackerReasonController::class);

        // Journey
        Route::delete('journeys/destroy', [AdminJourneyController::class, 'massDestroy'])->name('journeys.massDestroy');
        Route::resource('journeys', AdminJourneyController::class);
    });

// Profile
Route::prefix('profile-admin')
    ->as('profile.')
    ->middleware('auth')
    ->group(function () {
        if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
            Route::get('password', [AuthChangePasswordController::class, 'edit'])->name('password.edit');
            Route::post('password', [AuthChangePasswordController::class, 'update'])->name('password.update');
            Route::post('profile', [AuthChangePasswordController::class, 'updateProfile'])->name('password.updateProfile');
            Route::post('profile/destroy', [AuthChangePasswordController::class, 'destroyProfile'])->name('password.destroyProfile');
        }
    });