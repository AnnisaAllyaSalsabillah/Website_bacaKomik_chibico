<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminComicController;
use App\Http\Controllers\Admin\AdminGenreController;
use App\Http\Controllers\Admin\AdminChapterController;
use App\Http\Controllers\Admin\AdminPengumumanController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\User\ComicController;
use App\Http\Controllers\User\ChapterController;
use App\Http\Controllers\User\BookmarkController;
use App\Http\Controllers\User\UpvoteController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\HistoryController;
use App\Http\Controllers\User\SearchController;
use App\Http\Controllers\User\PengumumanController;

// ADMIN ROUTES 
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('komiks', AdminComicController::class);
    Route::resource('genres', AdminGenreController::class);
    Route::resource('chapters', AdminChapterController::class);
    Route::resource('pengumumans', AdminPengumumanController::class);
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// USER ROUTES
Route::prefix('user')->name('user.')->group(function () {
    Route::resource('komiks', ComicController::class);
    Route::resource('chapters', ChapterController::class);
    Route::resource('bookmark', BookmarkController::class);
    Route::resource('upvote', UpvoteController::class);
    Route::resource('comment', CommentController::class);
    Route::resource('history', HistoryController::class);
    Route::resource('search', SearchController::class);
    Route::resource('pengumumans', PengumumanController::class);
});

