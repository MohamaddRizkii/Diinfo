<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () { return view('auth.login'); });
Route::get('/register', function () { return view('auth.register'); });

// Halaman Khusus UI Tampilan Admin
Route::get('/admin/dashboard', function () { return view('admin.dashboard'); });
Route::get('/admin/news', function () { return view('admin.news-manage'); });

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

        // Kelola Berita (Hanya Admin - Dicek di Controller)
        Route::post('/news', [NewsController::class, 'store']);
        Route::post('/news/{id}', [NewsController::class, 'update']); // Menggunakan POST untuk menghindari bug upload file PHP
        Route::delete('/news/{id}', [NewsController::class, 'destroy']);

        // Dashboard Statistik
        Route::get('/dashboard', [DashboardController::class, 'index']); // Hanya Admin

        // Fitur Edit Profil User & Admin
        Route::put('/profile/update', [AuthController::class, 'updateProfile']);

    });

});
