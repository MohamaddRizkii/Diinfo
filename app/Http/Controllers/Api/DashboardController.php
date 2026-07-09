<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\News;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Mengambil ringkasan data statistik untuk halaman Dashboard Admin
    public function index()
    {
        // Proteksi Manual: Cek apakah yang login adalah admin
        if (Auth::user()->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak. Halaman ini khusus admin.'
            ], 403);
        }

        // 1. Hitung Angka Total (Agregasi Data)
        $totalUsers = User::where('role', 'user')->count();
        $totalNews = News::count();
        $totalComments = Comment::count();
        $totalCategories = Category::count();

        // 2. Ambil 5 Berita Terpopuler (Berdasarkan jumlah komentar terbanyak)
        $popularNews = News::withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->take(5)
            ->get();

        // 3. Ambil 5 Komentar Terbaru yang Masuk
        $recentComments = Comment::with(['user', 'news'])
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data statistik dashboard berhasil dimuat.',
            'data' => [
                'stats' => [
                    'total_users' => $totalUsers,
                    'total_news' => $totalNews,
                    'total_comments' => $totalComments,
                    'total_categories' => $totalCategories
                ],
                'popular_news' => $popularNews,
                'recent_comments' => $recentComments
            ]
        ], 200);
    }
}