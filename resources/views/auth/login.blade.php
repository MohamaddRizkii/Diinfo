@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto my-16 bg-white border border-gray-200 rounded-sm shadow-md overflow-hidden">
    <div class="bg-[#0c2340] text-white p-6 text-center border-b-4 border-[#c8102e]">
        <h2 class="text-xl font-serif font-bold tracking-tight">Selamat Datang Kembali</h2>
        <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">Masuk ke Akun Diinfo Anda</p>
    </div>
    
    <div class="p-6 md:p-8 space-y-4">
        <div id="alert-box" class="hidden p-3 rounded-sm text-xs font-bold"></div>

        <form id="login-form" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Alamat Email</label>
                <input type="email" id="email" required placeholder="nama@email.com" class="w-full border border-gray-300 rounded-sm px-3 py-2 text-sm focus:outline-none focus:border-blue-900 font-medium">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Kata Sandi</label>
                <input type="password" id="password" required placeholder="••••••••" class="w-full border border-gray-300 rounded-sm px-3 py-2 text-sm focus:outline-none focus:border-blue-900 font-medium">
            </div>
            <button type="submit" class="w-full bg-[#0c2340] text-white font-bold py-2.5 rounded-sm text-xs hover:bg-blue-900 transition tracking-widest uppercase mt-2 shadow-sm">
                MASUK SEKARANG
            </button>
        </form>

        <p class="text-xs text-center text-gray-500 pt-4 border-t border-gray-100">
            Belum terdaftar? <a href="/register" class="text-red-600 font-bold hover:underline">Buat akun baru</a>
        </p>
    </div>
</div>

<script>
    document.getElementById('login-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const alertBox = document.getElementById('alert-box');
        alertBox.classList.add('hidden');

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
            if (data.status === 'success') {
                localStorage.setItem('api_token', data.token);
                localStorage.setItem('user_data', JSON.stringify(data.user));

                alertBox.className = "p-3 rounded-sm text-xs font-bold bg-green-50 text-green-700 border border-green-200";
                alertBox.innerText = "Autentikasi berhasil. Mengalihkan hak akses...";
                alertBox.classList.remove('hidden');

                setTimeout(() => {
                    window.location.href = data.user.role === 'admin' ? '/admin/dashboard' : '/';
                }, 1000);
            } else {
                alertBox.className = "p-3 rounded-sm text-xs font-bold bg-red-50 text-red-700 border border-red-200";
                alertBox.innerText = data.message || "Kredensial yang dimasukkan tidak cocok.";
                alertBox.classList.remove('hidden');
            }
        });
    });
</script>
@endsection