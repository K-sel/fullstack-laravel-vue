<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::prefix('api/v1')->group(function () {
  Route::get('/users', function () {
    $user = User::all();
    return response()->json($user);
  });
 
  Route::post('/register', [AuthController::class, 'createAccount'])->name('create');
  
  Route::delete('/', function () {
    return response()->json(['message' => 'Deleting']);
  });
}); 

// routes/web.php
Route::get('/{any?}', function () {
  return view('index');
})->where('any', '^(?!api).*')->name('spa');