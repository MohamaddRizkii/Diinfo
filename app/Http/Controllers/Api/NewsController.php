<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class NewsController extends Controller
{
    // 1. Public Feed: Melihat semua berita (Dengan Pagination, Pencarian, & Filter Kategori)
    public function index(Request $request)
    {
        // Menggunakan Eager Loading ('category' & 'user') agar query database efisien
        $query = News::with(['category', 'user']);

        // Fitur Filter berdasarkan Kategori (?category_id=2)
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        // Fitur Pencarian Berdasarkan Judul atau Isi (?search=gempa)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%");
            });
        }

        // UBAHAN: Jika ada parameter 'all', tampilkan limit besar (semua berita) untuk admin
            if ($request->has('all')) {
                $news = $query->latest()->paginate(1000); 
            } else {
                $news = $query->latest()->paginate(7); // Untuk halaman depan pembaca tetap 8
            }

        return response()->json([
            'status' => 'success',
            'message' => 'Data berita berhasil diambil.',
            'data' => $news
        ], 200);
    }

    // 2. Tambah Berita Baru + Upload Gambar (Hanya Admin)
    public function store(Request $request)
    {
        // Cek Role Admin
        if (Auth::user()->role !== 'admin') {
            return response()->json(['status' => 'error', 'message' => 'Akses ditolak. Anda bukan admin.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255|unique:news,title',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimal 2MB
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'validation_error', 'errors' => $validator->errors()], 422);
        }

        // Proses Upload Gambar ke folder public/uploads/news
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/news'), $imageName);
        }

        $news = News::create([
            'category_id' => $request->category_id,
            'user_id' => Auth::id(), // ID Admin yang sedang login
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'image' => $imageName
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berita berhasil diterbitkan!',
            'data' => $news
        ], 201);
    }

    // 3. Detail Berita Tunggal + Menampilkan Komentar di dalamnya (Public)
    public function show($id)
    {
        // Ambil berita beserta kategori, penulis, dan semua komentar (+ nama pengomentar)
        $news = News::with(['category', 'user', 'comments.user'])->find($id);

        if (!$news) {
            return response()->json(['status' => 'error', 'message' => 'Berita tidak ditemukan.'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $news
        ], 200);
    }

    // 4. Ubah Berita (Hanya Admin) -> Kita gunakan POST untuk rute ini agar upload gambar aman
    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['status' => 'error', 'message' => 'Akses ditolak. Anda bukan admin.'], 403);
        }

        $news = News::find($id);

        if (!$news) {
            return response()->json(['status' => 'error', 'message' => 'Berita tidak ditemukan.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255|unique:news,title,' . $id,
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'validation_error', 'errors' => $validator->errors()], 422);
        }

        $imageName = $news->image; // Pake gambar lama dulu

        // Jika ada upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama dari folder lokal jika ada
            $oldImagePath = public_path('uploads/news/' . $news->image);
            if (File::exists($oldImagePath) && $news->image) {
                File::delete($oldImagePath);
            }

            // Upload gambar baru
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/news'), $imageName);
        }

        $news->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'image' => $imageName
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berita berhasil diperbarui!',
            'data' => $news
        ], 200);
    }

    // 5. Hapus Berita beserta Gambarnya (Hanya Admin)
    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['status' => 'error', 'message' => 'Akses ditolak. Anda bukan admin.'], 403);
        }

        $news = News::find($id);

        if (!$news) {
            return response()->json(['status' => 'error', 'message' => 'Berita tidak ditemukan.'], 404);
        }

        // Hapus file gambar dari komputer sebelum menghapus data di database
        $imagePath = public_path('uploads/news/' . $news->image);
        if (File::exists($imagePath) && $news->image) {
            File::delete($imagePath);
        }

        $news->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Berita berhasil dihapus!'
        ], 200);
    }
}
