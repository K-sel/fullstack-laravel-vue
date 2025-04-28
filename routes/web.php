<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('showRegister')->middleware('guest');
Route::post('/register', [AuthController::class, 'createAccount'])->name('create');
Route::get('/login', [AuthController::class, 'showLogin'])->name('showLogin')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::delete('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Api routes
Route::prefix('api/v1')->group(function () {
  Route::get('/users/all', [ApiController::class, 'fetchAllUsers']);
  Route::get('/books/all', [ApiController::class, 'fetchAllBooks']);
  Route::get('/user/books', [ApiController::class, 'fetchUserBooks']);
  Route::get('/user/book/{id}', [ApiController::class, 'fetchBookById']);
  Route::delete('/user/book/{id}', [ApiController::class, 'deleteBookById']);
  Route::post('/new', [ApiController::class, 'createNewBook']);
});

// Vue routes
Route::get('/{any?}', function () {
  return view('index');
})->where('any', '^(?!api|login|register).*')->name('spa')->middleware('auth');
