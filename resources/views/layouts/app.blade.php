<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diinfo - Informasi Akurat & Terpercaya</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT_Serif:ital,wght@0,400;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        serif: ['PT Serif', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        html { scroll-behavior: smooth; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-[#f8f9fa] text-gray-900 font-sans antialiased">

    <!-- TOPBAR -->
    <div class="bg-gray-100 border-b border-gray-200 text-[11px] text-gray-600 py-2">
        <div class="container mx-auto px-4 flex justify-between items-center max-w-7xl">
            <span id="current-date" class="font-medium uppercase tracking-wider"></span>
        </div>
    </div>

    <!-- MAIN HEADER: LOGO DI KIRI, SEARCH DI TENGAH, PROFILE DI KANAN -->
    <header class="bg-white py-5 border-b border-gray-100">
        <div class="container mx-auto px-4 max-w-7xl flex flex-col md:flex-row items-center justify-between gap-4">
            
            <!-- UBAHAN KIRI: Logo Pojok Kiri Atas -->
            <div class="flex flex-col items-center md:items-start flex-shrink-0">
                <a href="/" class="text-4xl font-serif font-black tracking-tight text-[#0c2340] select-none">
                    Di<span class="text-[#c8102e]">info</span>
                </a>
                <p class="text-[9px] tracking-[0.2em] uppercase text-gray-400 font-bold mt-0.5">Informasi Akurat & Terpercaya</p>
            </div>

            <!-- UBAHAN TENGAH: Kolom Searching Pindah Ke Atas -->
            <div class="w-full md:w-96 flex border border-gray-300 rounded bg-white overflow-hidden focus-within:border-blue-900 transition shadow-2xs">
                <input type="text" id="global-search-input" placeholder="Cari artikel berita..." class="px-3 py-2 text-xs focus:outline-none w-full font-medium">
                <button onclick="handleGlobalSearch()" class="bg-[#0c2340] text-white px-4 text-xs font-bold hover:bg-blue-900 transition">CARI</button>
            </div>

            <!-- UBAHAN KANAN: Tempat Auth & Dropdown Edit Profil -->
            <div id="nav-auth" class="relative z-50"></div>
        </div>
    </header>

    <!-- NAVBAR KATEGORI -->
    <nav class="bg-[#0c2340] text-white shadow-md sticky top-0 z-40 border-b-4 border-[#c8102e]">
        <div class="container mx-auto px-4 flex items-center justify-between max-w-7xl">
            <div class="overflow-x-auto flex items-center space-x-1 py-1 text-xs font-bold uppercase tracking-wider" id="category-menu">
                <a href="/" class="px-4 py-3.5 hover:bg-white/5 text-gray-300 hover:text-white transition-all duration-300 flex-shrink-0" id="menu-home">Home</a>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="container mx-auto px-4 py-8 max-w-7xl min-h-screen">
        @yield('content')
    </main>

    <!-- === POP-UP MODAL EDIT PROFIL (TERSEMBUNYI DEFAULT) === -->
    <div id="edit-profile-modal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white border border-gray-200 rounded-sm shadow-xl max-w-md w-full overflow-hidden transform scale-95 transition-transform duration-300">
            <div class="bg-[#0c2340] text-white p-4 font-serif font-bold text-sm tracking-wide flex justify-between items-center">
                <span>PENGATURAN PROFIL AKUN</span>
                <button onclick="toggleProfileModal()" class="text-gray-400 hover:text-white text-lg">&times;</button>
            </div>
            <form id="edit-profile-form" class="p-5 space-y-4">
                <div id="modal-alert" class="hidden p-2.5 rounded-sm text-xs font-bold"></div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Lengkap</label>
                    <input type="text" id="modal-name" required class="w-full border border-gray-300 rounded-sm px-3 py-2 text-xs focus:outline-none focus:border-blue-900 font-medium">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat Email</label>
                    <input type="email" id="modal-email" required class="w-full border border-gray-300 rounded-sm px-3 py-2 text-xs focus:outline-none focus:border-blue-900 font-medium">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Password Baru (Kosongkan jika tidak diubah)</label>
                    <input type="password" id="modal-password" placeholder="••••••••" class="w-full border border-gray-300 rounded-sm px-3 py-2 text-xs focus:outline-none focus:border-blue-900 font-medium">
                </div>
                <div class="flex justify-end gap-2 pt-2 border-t border-gray-100">
                    <button type="button" onclick="toggleProfileModal()" class="bg-gray-100 text-gray-600 text-[11px] font-bold px-4 py-2 rounded-sm hover:bg-gray-200 uppercase">Batal</button>
                    <button type="submit" class="bg-blue-900 text-white text-[11px] font-bold px-4 py-2 rounded-sm hover:bg-blue-800 uppercase tracking-wider shadow-xs">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- FOOTER -->
        <footer class="bg-[#0c2340] text-gray-400 text-xs py-12 mt-20 border-t-8 border-gray-900">
            <div class="container mx-auto px-4 max-w-7xl grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="space-y-3">
                    <h4 class="text-white font-serif font-bold text-lg">Di<span class="text-red-500">info</span></h4>
                    <p class="leading-relaxed text-gray-400">Diinfo – Sumber informasi terpercaya yang menghadirkan berita terbaru, aktual, dan relevan untuk menemani Anda mengikuti perkembangan setiap hari.</p>
                    <p class="pt-4 text-[11px] text-gray-600">&copy; 2026 Diinfo. All Rights Reserved.</p>
                </div>
                <div></div>
        </div>
    </footer>

    <script>
        document.getElementById('current-date').innerText = new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        
        const token = localStorage.getItem('api_token');
        const user = JSON.parse(localStorage.getItem('user_data'));
        const authContainer = document.getElementById('nav-auth');
        const categoryMenu = document.getElementById('category-menu');
        const urlParams = new URLSearchParams(window.location.search);
        const activeCatId = urlParams.get('category_id');

        // Fungsi Searching Global di Atas
        function handleGlobalSearch() {
            const query = document.getElementById('global-search-input').value;
            window.location.href = `/?search=${encodeURIComponent(query)}`;
        }
        document.getElementById('global-search-input').addEventListener('keypress', function(e) {
            if(e.key === 'Enter') handleGlobalSearch();
        });

        // Sinkronisasi teks input cari jika parameter URL ada
        if(urlParams.get('search')) {
            document.getElementById('global-search-input').value = urlParams.get('search');
        }

        // Render Navigasi Akun & Dropdown Edit Profil
        if (token && user) {
            let adminLink = user.role === 'admin' ? `<a href="/admin/dashboard" class="block px-4 py-2 text-xs text-gray-700 hover:bg-gray-100 font-bold border-b border-gray-50">Panel Kontrol Admin</a>` : '';
            
            authContainer.innerHTML = `
                <div class="flex items-center gap-2">
                    <!-- Tombol Utama Pill Akun -->
                    <button onclick="toggleDropdown()" class="flex items-center gap-2 bg-[#051326] px-3 py-1.5 rounded-full border border-blue-900 text-white font-medium shadow-inner hover:bg-[#0c2340] transition select-none focus:outline-none">
                        <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                        <span class="tracking-wide text-[11px] text-gray-200">${user.name}</span>
                        <span class="text-[9px] text-gray-400">&nbsp;▼</span>
                    </button>
                    
                    <!-- KOTAK DROPDOWN MENU EDIT PROFIL -->
                    <div id="profile-dropdown" class="hidden absolute right-0 mt-32 w-48 bg-white border border-gray-200 rounded-sm shadow-lg py-1 text-left">
                        ${adminLink}
                        <button onclick="openEditModal()" class="w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-100 font-semibold">Edit Profil Akun</button>
                        <button onclick="handleLogout()" class="w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 font-bold border-t border-gray-100 uppercase tracking-wider">Logout</button>
                    </div>
                </div>
            `;
        } else {
            authContainer.innerHTML = `
                <div class="flex gap-2 text-xs font-bold">
                    <a href="/login" class="text-gray-300 hover:text-white bg-[#0c2340] px-3 py-1.5 rounded-sm border border-blue-900 transition">LOGIN</a>
                    <a href="/register" class="bg-[#c8102e] text-white px-3 py-1.5 rounded-sm hover:bg-red-700 transition">DAFTAR</a>
                </div>
            `;
        }

        // Dropdown Menu Toggler
        function toggleDropdown() {
            const dd = document.getElementById('profile-dropdown');
            dd.classList.toggle('hidden');
        }
        window.addEventListener('click', function(e) {
            const dd = document.getElementById('profile-dropdown');
            if (dd && !e.target.closest('#nav-auth')) dd.classList.add('hidden');
        });

        // Logika Pengendali Pop-Up Modal Edit Profil
        function toggleProfileModal() {
            const modal = document.getElementById('edit-profile-modal');
            const box = modal.querySelector('div');
            if(modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                setTimeout(() => { modal.classList.remove('opacity-0'); box.classList.remove('scale-95'); }, 20);
            } else {
                modal.classList.add('opacity-0');
                box.classList.add('scale-95');
                setTimeout(() => modal.classList.add('hidden'), 300);
            }
        }

        function openEditModal() {
            document.getElementById('modal-name').value = user.name;
            document.getElementById('modal-email').value = user.email;
            document.getElementById('modal-password').value = '';
            document.getElementById('modal-alert').classList.add('hidden');
            toggleProfileModal();
        }

        // Simpan Hasil Edit Profil via Fetch API PUT
        document.getElementById('edit-profile-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const alertBox = document.getElementById('modal-alert');
            
            fetch('/api/profile/update', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                body: JSON.stringify({
                    name: document.getElementById('modal-name').value,
                    email: document.getElementById('modal-email').value,
                    password: document.getElementById('modal-password').value || null
                })
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    localStorage.setItem('user_data', JSON.stringify(data.user));
                    alertBox.className = "p-2.5 rounded-sm text-xs font-bold bg-green-50 text-green-700 border border-green-200";
                    alertBox.innerText = "Profil berhasil disimpan! Memuat ulang Halaman...";
                    alertBox.classList.remove('hidden');
                    setTimeout(() => window.location.reload(), 1200);
                } else {
                    alertBox.className = "p-2.5 rounded-sm text-xs font-bold bg-red-50 text-red-700 border border-red-200";
                    alertBox.innerText = data.message || "Gagal mengubah data.";
                    alertBox.classList.remove('hidden');
                }
            });
        });

        // Render Menu Kategori dengan Highlight Aktif
        if(!activeCatId) document.getElementById('menu-home').className = 'px-4 py-3.5 text-red-400 border-b-2 border-red-400 font-bold bg-white/5 flex-shrink-0';
        
        fetch('/api/categories')
            .then(res => res.json())
            .then(response => {
                if(response.status === 'success') {
                    response.data.forEach(cat => {
                        let activeStyle = (activeCatId == cat.id) ? 'text-red-400 border-b-2 border-red-400 font-bold bg-white/5' : 'text-gray-300 hover:text-white hover:bg-white/5';
                        categoryMenu.innerHTML += `<a href="/?category_id=${cat.id}" class="px-4 py-3.5 transition-all duration-300 flex-shrink-0 ${activeStyle}">${cat.name}</a>`;
                    });
                }
            });

        function handleLogout() {
            fetch('/api/logout', { method: 'POST', headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' } })
            .then(() => { localStorage.clear(); window.location.href = '/'; });
        }
    </script>
</body>
</html>
