<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () { return view('auth.login'); });
Route::get('/register', function () { return view('auth.register'); });

/*
|--------------------------------------------------------------------------
| RUTE BACKEND API (Prefix: /api)
|--------------------------------------------------------------------------
*/
Route::prefix('api')->group(function () {

    // 1. RUTE PUBLIK (Bisa diakses siapa saja tanpa login)
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // 2. RUTE PRIVAT (Wajib login & membawa token manual lewat HTTP Header)
    Route::middleware(['manual.auth'])->group(function () {

    // Fitur Logout
        Route::post('/logout', [AuthController::class, 'logout']);

    });

});