<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AudioBookController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\NewBookController;
use App\Http\Controllers\HardController;
use App\Http\Controllers\SearchController;

Route::get('/audiobook/{id?}', [AudioBookController::class, 'getAudiobook']);

Route::get('/hardlinks/{id?}', [HardController::class, 'show']);

Route::get('/newbooks/search/{search?}', [BookController::class, 'searchBooks']);
Route::get('/audiobooks/{bookid?}', [NewBookController::class, 'newshow']);
Route::get('/audiobooks/genres/{genres?}', [AudiobookController::class, 'audiobooksByGenre']);
Route::get('/audiobooks/search/{name?}', [NewBookController::class, 'searchByName']);

Route::get('/newbooks/{id?}', [BookController::class, 'show']);
Route::get('/newbooks/genres/{genres?}', [BookController::class, 'showgenres']);
Route::get('/newbooks/search/{name?}', [NewBookController::class, 'searchByName']);

Route::post('/favorite', [FavoriteController::class, 'saveFavorite']);
Route::get('/favorites', [FavoriteController::class, 'getFavorites']);

Route::get('/search', [SearchController::class, 'search']);

