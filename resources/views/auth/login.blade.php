<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Diinfo ID</title>
    
    <!-- Memuat Tailwind CSS dari project Laravel Anda -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Opsional: Jika Vite belum dikonfigurasi, hapus komentar di bawah ini untuk menggunakan CDN Tailwind sementara -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
</head>
<body class="bg-[#f5f5f5] antialiased">

    <!-- Container Utama (Memenuhi layar sepenuhnya) -->
    <div class="min-h-screen flex flex-col items-center justify-center py-10 px-4 sm:px-6 lg:px-8">
        
        <!-- Tombol Kembali -->
        <div class="w-full max-w-md mb-2">
            <a href="/" class="inline-flex items-center text-sm font-semibold text-gray-600 hover:text-gray-900 transition-colors bg-white px-4 py-3 w-full rounded-t-lg border-b border-gray-100 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Beranda
            </a>
        </div>

        <!-- Main Card -->
        <div class="w-full max-w-md bg-white rounded-b-lg shadow-sm p-6 sm:p-10 border border-gray-100">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Diinfo ID</h1>
                <p class="text-sm text-gray-500 px-4">
                    Login dengan Akun Diinfo ID untuk menggunakan layanan-layanan dari Diinfo.
                </p>
            </div>

           <!-- Form Login -->
            <form id="login-form" class="space-y-4">
                
                <!-- Input Group: Email -->
                <div class="flex items-stretch border border-gray-300 rounded focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 overflow-hidden bg-white min-h-[52px]">
                    <div class="w-1/3 px-3 flex items-center border-r border-gray-200/60">
                        <label for="email" class="text-xs font-bold text-gray-700 leading-tight">
                            Akun <br> Diinfo ID
                        </label>
                    </div>
                    <div class="w-2/3 flex items-center">
                        <input type="email" id="email" required placeholder="email" 
                            class="w-full px-3 py-2 text-sm text-gray-900 border-none focus:ring-0 bg-transparent placeholder-gray-400 outline-none">
                    </div>
                </div>

                <!-- Input Group: Password -->
                <div class="flex items-stretch border border-gray-300 rounded focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 overflow-hidden bg-white min-h-[52px]">
                    <div class="w-1/3 px-3 flex items-center border-r border-gray-200/60">
                        <label for="password" class="text-xs font-bold text-gray-700">
                            Password
                        </label>
                    </div>
                    <div class="w-2/3 flex items-center justify-between pr-3">
                        <input type="password" id="password" required placeholder="••••••••" 
                            class="w-full px-3 py-2 text-sm text-gray-900 border-none focus:ring-0 bg-transparent outline-none">
                        <button type="button" class="text-gray-400 hover:text-gray-600 focus:outline-none flex-shrink-0">
                            <!-- Icon Eye -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Tombol Login -->
                <button type="submit" id="submit-btn" 
                    class="w-full bg-[#1877f2] hover:bg-blue-700 text-white font-bold py-3 rounded text-sm transition-colors mt-2">
                    Login
                </button>
            </form>
            <!-- Links Lupa Sandi & Daftar -->
            <div class="text-center mt-5 text-sm text-gray-600">
                <a href="/register" class="text-[#1877f2] hover:underline">Daftar Akun Diinfo ID?</a> atau 
                <a href="#" class="text-[#1877f2] hover:underline">lupa password?</a>
            </div>

            <!-- Divider Atau -->
            <div class="relative mt-8 mb-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-xs">
                    <span class="px-3 bg-white text-gray-400">atau</span>
                </div>
            </div>

            <div class="text-center text-xs text-gray-500 mb-4">
                Login Diinfo ID dengan akun ini
            </div>

            <!-- Tombol Sosial -->
            <div class="space-y-3">
                <a href="{{ route('google.login') }}" class="w-full flex justify-center items-center gap-3 bg-white border border-gray-300 text-gray-700 font-semibold py-2.5 rounded text-sm hover:bg-gray-50 transition-colors shadow-sm">
                    <img src="https://raw.githubusercontent.com/lobehub/lobe-icons/refs/heads/master/packages/static-png/light/google-color.png" class="h-4 w-4" alt="Google">
                    Masuk dengan Google
                </a>
            </div>

            <!-- Footer Syarat & Ketentuan -->
            <div class="mt-8 text-center text-[10px] sm:text-xs text-gray-500 px-2 leading-relaxed">
                Dengan login di Diinfo ID, kamu menyetujui bahwa data dan informasi Akun Diinfo ID milikmu akan digunakan untuk memberikan layanan sesuai 
                <a href="#" class="text-[#1877f2] hover:underline">Kebijakan Data Pribadi Diinfo</a>.
            </div>

        </div>
    </div>

    <!-- Script JS -->
    <script>
        document.getElementById('login-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const alertBox = document.getElementById('alert-box');
            const submitBtn = document.getElementById('submit-btn');
            const originalBtnText = submitBtn.innerText;

            alertBox.classList.add('hidden');
            submitBtn.disabled = true;
            submitBtn.innerText = "Memproses...";
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');

            fetch('/api/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({
                    email: document.getElementById('email').value,
                    password: document.getElementById('password').value
                })
            })
            .then(res => res.json())
            .then(data => {
                alertBox.classList.remove('hidden');

                if (data.status === 'success') {
                    localStorage.setItem('api_token', data.token);
                    localStorage.setItem('user_data', JSON.stringify(data.user));

                    alertBox.className = "mb-4 p-3 rounded text-sm text-center font-semibold bg-green-50 text-green-700 border border-green-200";
                    alertBox.innerText = "Autentikasi berhasil. Mengalihkan...";

                    setTimeout(() => {
                        window.location.href = data.user.role === 'admin' ? '/admin/dashboard' : '/';
                    }, 1000);
                } else {
                    submitBtn.disabled = false;
                    submitBtn.innerText = originalBtnText;
                    submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');

                    alertBox.className = "mb-4 p-3 rounded text-sm text-center font-semibold bg-red-50 text-red-600 border border-red-200";
                    alertBox.innerText = data.message || "Email atau kata sandi tidak cocok.";
                }
            })
            .catch(err => {
                submitBtn.disabled = false;
                submitBtn.innerText = originalBtnText;
                submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                
                alertBox.classList.remove('hidden');
                alertBox.className = "mb-4 p-3 rounded text-sm text-center font-semibold bg-red-50 text-red-600 border border-red-200";
                alertBox.innerText = "Terjadi kesalahan pada server. Coba lagi.";
            });
        });
    </script>
</body>
</html>