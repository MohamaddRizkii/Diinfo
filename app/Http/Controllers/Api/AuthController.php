<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Fungsi Registrasi Akun Baru
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'in:admin,user' // Memastikan role hanya bisa admin atau user
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'validation_error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'user', // Default rutenya adalah user biasa
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Registrasi akun berhasil!',
            'data' => $user
        ], 201);
    }

    // 2. Fungsi Login (Generate Token Manual)
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'validation_error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Cek apakah user ada dan password-nya cocok
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email atau password yang Anda masukkan salah.'
            ], 401);
        }

        // Kunci Manual Auth: Generate string acak 60 karakter untuk token
        $token = Str::random(60);
        
        // Simpan token ke kolom api_token user tersebut di database
        $user->update(['api_token' => $token]);

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil!',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ]
        ], 200);
    }

    // 3. Fungsi Logout (Hapus Token)
    public function logout(Request $request)
    {
        // Ambil data user yang sedang login dari request yang lolos middleware
        $user = Auth::user();

        if ($user) {
            // Hapus token di database dengan mengubahnya kembali jadi null
            User::where('id', $user->id)->update(['api_token' => null]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Logout berhasil, token telah dihapus.'
        ], 200);
    }

    public function updateProfile(\Illuminate\Http\Request $request)
    {
        $user = $request->user; // Diambil dari middleware ManualAuth kita

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Profil Anda berhasil diperbarui!',
            'user' => $user
        ]);
    }
}