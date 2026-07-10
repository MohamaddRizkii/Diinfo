<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    // Mengarahkan pengguna ke halaman login Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Menangani callback/kembalian dari Google setelah user memilih akun
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cek apakah user dengan email ini sudah ada di database
            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                // Jika belum ada, buat user baru otomatis
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => bcrypt('password_dummy_123'), // Beri password acak
                    // Anda bisa menambahkan kolom 'google_id' => $googleUser->id jika sudah membuat kolomnya di database
                ]);
            }

            // Login-kan user
            Auth::login($user);

            // Karena sebelumnya form Anda menggunakan Token API (localStorage), 
            // Anda bisa generate token sanctum di sini (opsional, sesuaikan dengan sistem Anda)
            // $token = $user->createToken('auth_token')->plainTextToken;

            // Redirect ke halaman dashboard atau beranda
            return redirect()->intended('/admin/dashboard');

        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Terjadi kesalahan saat login dengan Google.');
        }
    }
}