@extends('layouts.app')

@section('content')
<!-- SEKSI HEADLINE / BERITA UTAMA -->
<div id="headline-section" class="mb-12 hidden">
    <!-- Diisi otomatis oleh JS -->
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
    
    <!-- GRID UTAMA DAFTAR BERITA -->
    <div class="lg:col-span-2 space-y-6">
        <div class="border-b-2 border-gray-800 pb-2">
            <h2 class="text-xl font-serif font-bold text-gray-900 tracking-tight uppercase" id="page-title">
                Berita Terkini
            </h2>
        </div>

        <div id="loading" class="text-center py-20 text-gray-400 font-medium text-sm animate-pulse">Menghubungkan ke server satelit...</div>

        <!-- CONTAINER GRID DAFTAR BERITA -->
        <div id="news-grid" class="grid grid-cols-1 md:grid-cols-2 gap-6 hidden"></div>

        <!-- TOMBOL HALAMAN -->
        <div id="pagination-container" class="flex justify-center gap-1.5 pt-8 border-t border-gray-200"></div>
    </div>

    <!-- SIDEBAR KANAN -->
    <div class="space-y-8">
        <div class="bg-white border-t-4 border-[#0c2340] border-x border-b border-gray-200 p-5 shadow-sm rounded-b-sm">
            <h3 class="text-sm font-bold text-[#0c2340] border-b border-gray-100 pb-3 mb-4 uppercase tracking-wider">
                Trending Minggu Ini
            </h3>
            <ol class="divide-y divide-gray-100 text-sm font-serif">
                <li class="py-3 flex gap-3 items-start">
                    <span class="text-2xl font-sans font-black text-gray-300 leading-none">1</span>
                    <a href="#" class="hover:text-red-600 transition font-bold text-gray-800">Implementasi Clean Code RESTful API Laravel 12 Lulus Uji Validasi</a>
                </li>
                <li class="py-3 flex gap-3 items-start">
                    <span class="text-2xl font-sans font-black text-gray-300 leading-none">2</span>
                    <a href="#" class="hover:text-red-600 transition font-bold text-gray-800">Custom Auth Token Manual Sukses Gantikan Peran Sanctum Library</a>
                </li>
            </ol>
        </div>
    </div>
</div>

<script>
    const homeParams = new URLSearchParams(window.location.search);
    let categoryId = homeParams.get('category_id') || '';
    let searchQuery = homeParams.get('search') || ''; // Mengambil input cari dari Header Global atas

    if (categoryId) {
        document.getElementById('page-title').innerText = "Arsip Kategori";
    }

    function loadNews(page = 1) {
        document.getElementById('loading').classList.remove('hidden');
        document.getElementById('news-grid').classList.add('hidden');
        document.getElementById('headline-section').classList.add('hidden');
        
        let apiUrl = `/api/news?page=${page}&category_id=${categoryId}&search=${encodeURIComponent(searchQuery)}`;

        fetch(apiUrl)
            .then(res => res.json())
            .then(response => {
                document.getElementById('loading').classList.add('hidden');
                const newsGrid = document.getElementById('news-grid');
                const headlineSection = document.getElementById('headline-section');
                newsGrid.innerHTML = '';
                headlineSection.innerHTML = '';

                if (response.status === 'success' && response.data.data.length > 0) {
                    let articles = response.data.data;

                    // RENDER HEADLINE UTAMA WITH PREMIUM ANIMATION EFFECT
                    if (page === 1 && !searchQuery && !categoryId) {
                        let topArticle = articles[0];
                        let topImg = topArticle.image ? `/uploads/news/${topArticle.image}` : 'https://via.placeholder.com/1200x600';
                        
                        // UBAHAN: Ditambahkan class hover zoom & bayangan halus bergerak pada headline
                        headlineSection.innerHTML = `
                            <div class="group bg-white border border-gray-200 rounded-sm overflow-hidden shadow-sm grid grid-cols-1 lg:grid-cols-5 hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-500 ease-in-out">
                                <div class="lg:col-span-3 h-64 lg:h-[380px] overflow-hidden">
                                    <img src="${topImg}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-in-out" alt="${topArticle.title}">
                                </div>
                                <div class="p-6 md:p-8 lg:col-span-2 flex flex-col justify-between bg-white">
                                    <div class="space-y-3">
                                        <span class="text-xs font-black text-red-600 uppercase tracking-widest">${topArticle.category.name}</span>
                                        <h1 class="text-2xl md:text-3xl font-serif font-bold text-gray-900 group-hover:text-blue-900 transition-colors duration-300 leading-tight">
                                            <a href="/news/${topArticle.id}">${topArticle.title}</a>
                                        </h1>
                                        <p class="text-gray-600 text-xs md:text-sm line-clamp-4 leading-relaxed font-serif">${topArticle.content}</p>
                                    </div>
                                    <div class="text-[11px] text-gray-400 font-semibold pt-4 border-t border-gray-100 flex justify-between">
                                        <span>OLEH: <span class="text-gray-700">${topArticle.user.name}</span></span>
                                        <span>${new Date(topArticle.created_at).toLocaleDateString('id-ID', {day:'numeric', month:'short', year:'numeric'})}</span>
                                    </div>
                                </div>
                            </div>
                        `;
                        headlineSection.classList.remove('hidden');
                        articles = articles.slice(1);
                    }

                    // RENDER ARTIKEL GRID BAWAH WITH HOVER ANIMATION EFFECT
                    if(articles.length > 0) {
                        newsGrid.classList.remove('hidden');
                        articles.forEach(item => {
                            let imageUrl = item.image ? `/uploads/news/${item.image}` : 'https://via.placeholder.com/600x400';
                            let dateFormatted = new Date(item.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
                            
                            // UBAHAN: Menambahkan efek lift-up (-translate-y-2) & pembesaran gambar (scale-105) saat kursor diarahkan ke detail/card berita
                            newsGrid.innerHTML += `
                                <article class="group bg-white border border-gray-200 rounded-sm overflow-hidden shadow-xs flex flex-col justify-between hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 ease-in-out">
                                    <div>
                                        <div class="overflow-hidden h-44">
                                            <img src="${imageUrl}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-in-out" alt="${item.title}">
                                        </div>
                                        <div class="p-4 space-y-2">
                                            <span class="text-[10px] font-black text-red-600 uppercase tracking-wider">${item.category.name}</span>
                                            <h3 class="text-base font-serif font-bold text-gray-900 group-hover:text-blue-900 transition-colors duration-300 leading-snug">
                                                <a href="/news/${item.id}">${item.title}</a>
                                            </h3>
                                            <p class="text-gray-500 text-xs line-clamp-3 font-serif leading-relaxed">${item.content}</p>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center text-[10px] text-gray-400 font-bold border-t border-gray-50 p-4 bg-gray-50/50">
                                        <span>OLEH: <span class="text-gray-600">${item.user.name}</span></span>
                                        <span>${dateFormatted}</span>
                                    </div>
                                </article>
                            `;
                        });
                    }

                    renderPagination(response.data);
                } else {
                    document.getElementById('loading').innerHTML = '<div class="text-gray-400 py-12 text-xs">Arsip berita tidak ditemukan.</div>';
                    document.getElementById('loading').classList.remove('hidden');
                    document.getElementById('pagination-container').innerHTML = '';
                }
            });
    }

    function renderPagination(paginationData) {
        const container = document.getElementById('pagination-container');
        container.innerHTML = '';
        paginationData.links.forEach(link => {
            if (link.url) {
                let pageNumber = new URL(link.url).searchParams.get('page');
                let activeClass = link.active ? 'bg-[#0c2340] text-white font-bold' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200';
                container.innerHTML += `<button onclick="loadNews(${pageNumber})" class="px-2.5 py-1 text-xs font-semibold rounded-sm transition ${activeClass}">${link.label.replace('&laquo; Previous', '‹').replace('Next &raquo;', '›')}</button>`;
            }
        });
    }

    loadNews(1);
</script>
@endsection