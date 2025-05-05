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
Route::get('/edit-password', [App\Http\Controllers\PasswordController::class, 'edit'])
  ->name('password.edit')
  ->middleware('auth');

// Route pour traiter la modification du mot de passe
Route::post('/password/update', [App\Http\Controllers\PasswordController::class, 'update'])
  ->name('password.update')
  ->middleware('auth');

// Api routes
Route::prefix('api/v1')->group(function () {
  Route::get('/users/all', [ApiController::class, 'fetchAllUsers']);
  Route::get('/user', [ApiController::class, 'fetchUser']);
  Route::delete('/user/delete', [ApiController::class, 'deleteUser'])->middleware('auth');
  Route::get('/books/all', [ApiController::class, 'fetchAllBooks']);
  Route::get('/user/books', [ApiController::class, 'fetchUserBooks']);
  Route::post('/user/update', [ApiController::class, 'updateUserProfile']);
  Route::get('/user/book/{id}', [ApiController::class, 'fetchBookById']);
  Route::delete('/user/book/{id}', [ApiController::class, 'deleteBookById']);
  Route::patch('/update/{id}', [ApiController::class, 'updateBook']);

  // Uniques routes
  Route::post('/create', [ApiController::class, 'createNewBook']);

  // Pictures routes
  Route::get('/picture/book/{id}', [ApiController::class, 'fetchPicture']);
  Route::post('/picture/user/upload', [ApiController::class, 'changeProfilePicture'])->middleware('auth');
  //Route::get('/picture/user/{id}', [ApiController::class, 'fetchPicture']);
});

// Vue routes
Route::get('/{any?}', function () {
  return view('index');
})->where('any', '^(?!api|login|register).*')->name('spa')->middleware('auth');
