<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Auth\GoogleController;

/*
|--------------------------------------------------------------------------
| RUTE FRONTEND / TAMPILAN WEB (Tempat Mengakses Halaman HTML/Blade)
|--------------------------------------------------------------------------
*/
Route::get('/', function () { 
    return view('home'); // UBAHAN: Sudah diganti dari 'welcome' ke 'home'
});
Route::get('/login', function () { return view('auth.login'); });
Route::get('/register', function () { return view('auth.register'); });
Route::get('/news/{id}', function ($id) { return view('news-detail', ['id' => $id]); });

// Halaman Khusus UI Tampilan Admin
Route::get('/admin/dashboard', function () { return view('admin.dashboard'); });
Route::get('/admin/news', function () { return view('admin.news-manage'); });
Route::get('/admin/categories', function () { return view('admin.categories-manage'); });

/*
|--------------------------------------------------------------------------
| RUTE BACKEND API (Prefix: /api)
|--------------------------------------------------------------------------
*/
Route::prefix('api')->group(function () {
    
    // 1. RUTE PUBLIK (Bisa diakses siapa saja tanpa login)
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Rute Kategori (Melihat Daftar & Detail Kategori)
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);

    // Rute Berita (Melihat Feed Berita & Detail Baca Berita)
    Route::get('/news', [NewsController::class, 'index']);
    Route::get('/news/{id}', [NewsController::class, 'show']);

<<<<<<< HEAD
    Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

=======
>>>>>>> 56ce0f7ee8fabcdabdd13479c79f5f92c4ff900b
    // 2. RUTE PRIVAT (Wajib login & membawa token manual lewat HTTP Header)
    Route::middleware(['manual.auth'])->group(function () {
        
        // Fitur Logout
        Route::post('/logout', [AuthController::class, 'logout']);

        // Kelola Kategori (Hanya Admin - Dicek di Controller)
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{id}', [CategoryController::class, 'update']);
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

        // Kelola Berita (Hanya Admin - Dicek di Controller)
        Route::post('/news', [NewsController::class, 'store']);
        Route::post('/news/{id}', [NewsController::class, 'update']); // Menggunakan POST untuk menghindari bug upload file PHP
        Route::delete('/news/{id}', [NewsController::class, 'destroy']);

        // Kelola Komentar
        Route::post('/comments', [CommentController::class, 'store']); // Bisa Admin & User Biasa (Wajib Login)
        Route::delete('/comments/{id}', [CommentController::class, 'destroy']); // Hanya Admin untuk moderasi

        // Dashboard Statistik
        Route::get('/dashboard', [DashboardController::class, 'index']); // Hanya Admin

        // Fitur Edit Profil User & Admin
        Route::put('/profile/update', [AuthController::class, 'updateProfile']);
        
    });

});
