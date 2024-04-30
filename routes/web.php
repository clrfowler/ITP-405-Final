<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavoriteController;

// Authorization Routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
Route::delete('/delete-account', [AuthController::class, 'deleteAccount'])->name('delete-account');


// Album Routes
Route::get('/albums/search', [DashboardController::class, 'search'])->name('albums.search');
Route::post('/albums/search', [DashboardController::class, 'search']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/details/{albumId}', [AlbumController::class, 'showDetails'])->name('album.details');


// Comment Routes
Route::post('/comments/store', [CommentController::class, 'store'])->name('comments.store');
Route::put('comments/{id}', [CommentController::class, 'update'])->name('comments.update');
Route::delete('comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
Route::get('comments/{id}/edit', [CommentController::class, 'edit'])->name('comments');
//Route::get('comments/album/{id}', [CommentController::class, 'commentsByAlbum'])->name('comments.album');

// Rating Routes
Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');
Route::put('/ratings/{id}', [RatingController::class, 'update'])->name('ratings.update');


// Profile/Favorites Routes
Route::get('/profile/{userid}', [ProfileController::class, 'index'])->name('profile');
Route::get('/favorited-albums/{userId}', [ProfileController::class, 'favoritedAlbums'])->name('favorited.albums');
Route::post('/toggle-favorite', [FavoriteController::class, 'toggleFavorite'])->name('toggle-favorite');


Route::get('/', function () {
    return view('welcome');
});
