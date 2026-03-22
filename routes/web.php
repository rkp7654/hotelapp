<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/discount', [HomeController::class, 'discount']);
Route::get('/inventory', [HomeController::class, 'inventory']);
Route::post('/search-rooms', [HomeController::class, 'searchRooms']);

Route::get('/room', function () {
    return view('room');
});