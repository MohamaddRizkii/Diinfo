@extends('layouts.app')

@section('content')
<script>
    const adminToken = localStorage.getItem('api_token');
    const adminUser = JSON.parse(localStorage.getItem('user_data'));
    if (!adminToken || !adminUser || adminUser.role !== 'admin') {
        alert('Akses Terbatas!'); window.location.href = '/login';
    }
</script>

<div class="space-y-8">
    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between border-b-2 border-gray-800 pb-5">
        <div>
            <span class="text-[10px] font-black text-red-600 uppercase tracking-widest">Pusat Kontrol Konten</span>
            <h1 class="text-3xl font-serif font-black text-gray-900 tracking-tight">Dashboard Eksekutif Diinfo</h1>
        </div>
        <div class="flex gap-2 w-full sm:w-auto">
            <a href="/admin/categories" class="bg-[#0c2340] text-white px-4 py-2.5 rounded-sm text-[10px] font-bold tracking-wider hover:bg-blue-900 transition shadow-xs w-full text-center sm:w-auto">KELOLA KATEGORI</a>
            <a href="/admin/news" class="bg-[#c8102e] text-white px-4 py-2.5 rounded-sm text-[10px] font-bold tracking-wider hover:bg-red-700 transition shadow-xs w-full text-center sm:w-auto">MANAJEMEN ARTIKEL</a>
        </div>
    </div>

    <!-- METRICS CARDS -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white border border-gray-200 p-5 rounded-sm shadow-xs border-l-4 border-blue-900 flex justify-between items-center">
            <div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block">Total Artikel</span>
                <h3 class="text-3xl font-bold text-gray-800 mt-1 font-mono" id="stat-news">0</h3>
            </div>
        </div>
        <div class="bg-white border border-gray-200 p-5 rounded-sm shadow-xs border-l-4 border-red-600 flex justify-between items-center">
            <div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block">Kategori</span>
                <h3 class="text-3xl font-bold text-gray-800 mt-1 font-mono" id="stat-categories">0</h3>
            </div>
        </div>
        <div class="bg-white border border-gray-200 p-5 rounded-sm shadow-xs border-l-4 border-green-600 flex justify-between items-center">
            <div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block">Komentar</span>
                <h3 class="text-3xl font-bold text-gray-800 mt-1 font-mono" id="stat-comments">0</h3>
            </div>
        </div>
        <div class="bg-white border border-gray-200 p-5 rounded-sm shadow-xs border-l-4 border-amber-500 flex justify-between items-center">
            <div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block">Total User</span>
                <h3 class="text-3xl font-bold text-gray-800 mt-1 font-mono" id="stat-users">0</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- POPULAR NEWS TABLE -->
        <div class="lg:col-span-2 bg-white border border-gray-200 p-6 rounded-sm shadow-xs">
            <h3 class="text-sm font-bold text-[#0c2340] uppercase tracking-wider border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                <span class="w-1.5 h-3.5 bg-blue-900 inline-block"></span> Artikel Terpopuler (Interaksi Tinggi)
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-400 border-b border-gray-200 uppercase font-bold tracking-wider">
                            <th class="py-3">Judul Publikasi</th>
                            <th class="py-3 text-center">Volume Respon</th>
                            <th class="py-3 text-right">Tautan</th>
                        </tr>
                    </thead>
                    <tbody id="popular-news-table" class="divide-y divide-gray-50 font-serif"></tbody>
                </table>
            </div>
        </div>

        <!-- MODERASI KOMENTAR -->
        <div class="bg-white border border-gray-200 p-6 rounded-sm shadow-xs">
            <h3 class="text-sm font-bold text-[#0c2340] uppercase tracking-wider border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                <span class="w-1.5 h-3.5 bg-red-600 inline-block"></span> Ruang Moderasi Komentar
            </h3>
            <div id="recent-comments-container" class="space-y-4 max-h-[420px] overflow-y-auto pr-1"></div>
        </div>
    </div>
</div>

<script>
    function loadDashboardData() {
        fetch('/api/dashboard', {
            method: 'GET',
            headers: { 'Authorization': 'Bearer ' + localStorage.getItem('api_token'), 'Accept': 'application/json' }
        })
        .then(res => (res.status === 403 || res.status === 401) ? (localStorage.clear(), window.location.href = '/login') : res.json())
        .then(response => {
            if (response.status === 'success') {
                const data = response.data;
                document.getElementById('stat-news').innerText = data.stats.total_news;
                document.getElementById('stat-categories').innerText = data.stats.total_categories;
                document.getElementById('stat-comments').innerText = data.stats.total_comments;
                document.getElementById('stat-users').innerText = data.stats.total_users;

                const popularTable = document.getElementById('popular-news-table');
                popularTable.innerHTML = '';
                data.popular_news.forEach(news => {
                    popularTable.innerHTML += `
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="py-3.5 font-bold text-gray-800 max-w-xs truncate">${news.title}</td>
                            <td class="py-3.5 text-center font-sans font-bold text-red-600">${news.comments_count} Opini</td>
                            <td class="py-3.5 text-right font-sans"><a href="/news/${news.id}" target="_blank" class="text-[11px] bg-gray-100 border border-gray-200 text-gray-600 px-2 py-1 rounded-sm hover:bg-blue-900 hover:text-white transition font-bold uppercase tracking-wider">Buka</a></td>
                        </tr>
                    `;
                });

                const commentsContainer = document.getElementById('recent-comments-container');
                commentsContainer.innerHTML = '';
                if(data.recent_comments.length > 0) {
                    data.recent_comments.forEach(comment => {
                        commentsContainer.innerHTML += `
                            <div class="bg-gray-50 border border-gray-200 p-3 rounded-sm space-y-2">
                                <div class="flex justify-between items-center text-[10px] font-bold uppercase tracking-wider">
                                    <span class="text-blue-900">${comment.user.name}</span>
                                    <span class="text-gray-400 text-[9px] truncate max-w-[120px]">ID: ${comment.news_id}</span>
                                </div>
                                <p class="text-xs text-gray-600 bg-white border p-2 rounded-sm italic font-serif leading-relaxed">"${comment.content}"</p>
                                <div class="text-end"><button onclick="deleteComment(${comment.id})" class="text-[9px] bg-red-50 text-red-700 px-2 py-1 border border-red-200 rounded-sm font-bold tracking-wider hover:bg-red-600 hover:text-white transition uppercase">Hapus Akses</button></div>
                            </div>
                        `;
                    });
                } else {
                    commentsContainer.innerHTML = `<p class="text-xs text-gray-400 italic text-center py-6">Bersih. Tidak ada komentar yang perlu dimoderasi.</p>`;
                }
            }
        });
    }

    function deleteComment(id) {
        if (confirm('Cabut hak tayang komentar ini?')) {
            fetch(`/api/comments/${id}`, {
                method: 'DELETE',
                headers: { 'Authorization': 'Bearer ' + localStorage.getItem('api_token'), 'Accept': 'application/json' }
            }).then(() => loadDashboardData());
        }
    }
    loadDashboardData();
</script>
@endsection