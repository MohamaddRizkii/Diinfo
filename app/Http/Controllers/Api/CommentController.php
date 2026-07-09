<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    // 1. Kirim Komentar Baru (Wajib Login - Bisa dilakukan Admin & User biasa)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'news_id' => 'required|exists:news,id',
            'content' => 'required|string|max:1000', // Batasi maksimal 1000 karakter
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'validation_error',
                'errors' => $validator->errors()
            ], 422);
        }

        $comment = Comment::create([
            'news_id' => $request->news_id,
            'user_id' => Auth::id(), // ID User yang sedang login diambil dari token manual
            'content' => $request->content,
        ]);

        // Ambil data komentar yang baru dibuat beserta info usernya agar bisa langsung ditampilkan di UI
        $commentWithUser = Comment::with('user')->find($comment->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Komentar Anda berhasil dikirim!',
            'data' => $commentWithUser
        ], 201);
    }

    // 2. Hapus / Moderasi Komentar (Hanya Admin)
    public function destroy($id)
    {
        // Proteksi Manual: Cek apakah yang login adalah admin
        if (Auth::user()->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak. Hanya admin yang bisa menghapus komentar.'
            ], 403);
        }

        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Komentar tidak ditemukan.'
            ], 404);
        }

        $comment->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Komentar berhasil dihapus oleh admin!'
        ], 200);
    }
}