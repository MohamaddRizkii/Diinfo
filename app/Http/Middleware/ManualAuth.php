<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ManualAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Ambil token dari Header HTTP (Authorization: Bearer <token>)
        $token = $request->bearerToken();

        // Jika user mengirim langsung tanpa kata 'Bearer ', kita coba ambil mentahnya
        if (!$token) {
            $token = $request->header('Authorization');
        }

        // 2. Jika token tidak dikirim, tolak akses
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak. Silahkan login terlebih dahulu untuk mendapatkan token.'
            ], 401);
        }

        // 3. Cari user di database yang memiliki api_token tersebut
        $user = User::where('api_token', $token)->first();

        // 4. Jika token salah / tidak ada di database, tolak akses
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak. Token tidak valid atau sudah kedaluwarsa.'
            ], 401);
        }

        // 5. Login-kan user ke sistem Laravel secara internal untuk request saat ini
        Auth::login($user);

        // Lolos pemeriksaan, izinkan lanjut ke fungsi utama (Controller)
        return $next($request);
    }
}