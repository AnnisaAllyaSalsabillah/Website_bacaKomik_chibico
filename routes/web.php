<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminComicController;
use App\Http\Controllers\Admin\AdminGenreController;
use App\Http\Controllers\Admin\AdminChapterController;
use App\Http\Controllers\Admin\AdminPengumumanController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\ComicController;
use App\Http\Controllers\User\ChapterController;
use App\Http\Controllers\User\BookmarkController;
use App\Http\Controllers\User\UpvoteController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\HistoryController;
use App\Http\Controllers\User\SearchController;
use App\Http\Controllers\User\PengumumanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\ExploreController;
use App\Http\Controllers\User\LibraryController;
use App\Http\Controllers\User\ProfileController;


Route::get('/komiks/{slug}', [ComicController::class, 'show'])->name('komiks.show');

// HOME ROUTES
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/explore', [ExploreController::class, 'index'])->name('explore');
Route::get('/library', [LibraryController::class, 'index'])->name('library');
Route::get('/search', [SearchController::class, 'index'])->name('search');

// ADMIN ROUTES
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('komiks', AdminComicController::class);
    Route::resource('genres', AdminGenreController::class);
    Route::resource('pengumuman', AdminPengumumanController::class);

    Route::prefix('komiks/{id}')->group(function () {
        Route::get('chapters', [AdminChapterController::class, 'index'])->name('chapters.index');
        Route::get('chapters/create', [AdminChapterController::class, 'create'])->name('chapters.create');
        Route::post('chapters', [AdminChapterController::class, 'store'])->name('chapters.store');
        Route::get('chapters/{chapterId}/edit', [AdminChapterController::class, 'edit'])->name('chapters.edit');
        Route::put('chapters/{chapterId}', [AdminChapterController::class, 'update'])->name('chapters.update');
        // Route untuk delete chapter - PENTING: pastikan ini sesuai dengan parameter controller
        Route::delete('chapters/{chapterId}', [AdminChapterController::class, 'destroy'])->name('chapters.destroy');
    
        // Route untuk API get chapter images
        Route::get('chapters/{chapterId}/images', [AdminChapterController::class, 'getImages'])->name('chapters.images');

         Route::get('chapters/{chapterId}', [AdminChapterController::class, 'show'])->name('chapters.show');
    });

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

