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
use App\Http\Controllers\Auth\AuthenticatedSessionController; // <-- pastikan ini ada
use Illuminate\Support\Facades\Auth as FacadesAuth;


Route::get('/komiks/{slug}', [ComicController::class, 'show'])->name('komiks.show');


// HOME ROUTES
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/explore', [ExploreController::class, 'index'])->name('explore');
Route::get('/library', [LibraryController::class, 'index'])->name('library');
Route::get('/search', [SearchController::class, 'index'])->name('search');


Route::post('/logout', function () {
    FacadesAuth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


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
        Route::delete('chapters/{chapterId}', [AdminChapterController::class, 'destroy'])->name('chapters.destroy');
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
    Route::resource('pengumuman', PengumumanController::class);
    Route::get('/komik/{slug}', [ComicController::class, 'show'])->name('komiks.show');

    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    
});