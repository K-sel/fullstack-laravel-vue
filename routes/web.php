<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/register',[AuthController::class, 'showRegister'])->name('showRegister');
Route::post('/register', [AuthController::class, 'createAccount'])->name('create');
Route::get('/login', [AuthController::class, 'showLogin'])->name('showLogin');
Route::post('/login', [AuthController::class, 'createAccount'])->name('login');


Route::prefix('api/v1')->group(function () {
  Route::get('/users', function () {
    $user = User::all();
    return response()->json($user);
  });
 }); 



// Route fallback pour SPA - n'intercepte pas login et register
Route::get('/{any?}', function () {
  return view('index');
})->where('any', '^(?!api|login|register).*$')->name('spa');