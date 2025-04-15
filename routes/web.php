<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('index');
});

Route::prefix('api/v1/')->group(function () {
  Route::get('/', function () {
    return response()->json(['message' => 'Hello, World from api!']);
  });
  Route::delete('/', function () {
    return response()->json(['message' => 'Deleting']);
  });
});