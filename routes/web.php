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
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth as FacadesAuth;


Route::get('/komiks/{slug}', [ComicController::class, 'show'])->name('komiks.show');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
});

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/library', [LibraryController::class, 'index'])->name('user.library.index');
    Route::post('/bookmark/{id}/toggle', [BookmarkController::class, 'toggle'])->name('bookmark.toggle');
});

// HOME ROUTES
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/explore', [ExploreController::class, 'index'])->name('explore');
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

         Route::get('chapters/{chapterId}/view', [AdminChapterController::class, 'viewChapter'])->name('chapters.view');
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


    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/bookmarks', [\App\Http\Controllers\User\BookmarkController::class, 'index'])->name('bookmark.index');
    Route::post('/bookmark/{id}/toggle', [\App\Http\Controllers\User\BookmarkController::class, 'toggle'])->name('bookmark.toggle');
    Route::get('/profile/change-password', [ProfileController::class, 'editPassword'])->name('profile.password.edit');
    Route::put('/profile/change-password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    
});