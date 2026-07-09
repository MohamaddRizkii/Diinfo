<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // 1. Ambil semua data kategori (Bisa diakses Publik & Admin)
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar semua kategori berhasil diambil.',
            'data' => $categories
        ], 200);
    }

    // 2. Tambah Kategori Baru (Hanya Admin)
    public function store(Request $request)
    {
        // Proteksi Manual: Cek apakah yang login adalah admin
        if (Auth::user()->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak. Anda bukan admin.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'validation_error',
                'errors' => $validator->errors()
            ], 422);
        }

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) // Otomatis bikin slug, misal: "Portal Berita" jadi "portal-berita"
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori baru berhasil ditambahkan!',
            'data' => $category
        ], 201);
    }

    // 3. Detail Kategori berdasarkan ID (Bisa diakses Publik & Admin)
    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kategori tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $category
        ], 200);
    }

    // 4. Ubah Kategori (Hanya Admin)
    public function update(Request $request, $id)
    {
        // Proteksi Manual: Cek apakah yang login adalah admin
        if (Auth::user()->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak. Anda bukan admin.'
            ], 403);
        }

        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kategori tidak ditemukan.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name,' . $id
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'validation_error',
                'errors' => $validator->errors()
            ], 422);
        }

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori berhasil diperbarui!',
            'data' => $category
        ], 200);
    }

    // 5. Hapus Kategori (Hanya Admin)
    public function destroy($id)
    {
        // Proteksi Manual: Cek apakah yang login adalah admin
        if (Auth::user()->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak. Anda bukan admin.'
            ], 403);
        }

        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kategori tidak ditemukan.'
            ], 404);
        }

        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori berhasil dihapus!'
        ], 200);
    }
}