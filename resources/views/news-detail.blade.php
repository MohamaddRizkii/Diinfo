@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white border border-gray-200 rounded-sm shadow-sm overflow-hidden">
    
    <div id="loading" class="text-center py-24 text-gray-400 font-medium text-sm animate-pulse">
        Membuka dokumen arsip...
    </div>

    <article id="news-content" class="hidden p-6 md:p-10 space-y-6">
        <span id="news-category" class="inline-block text-xs font-black text-red-600 uppercase tracking-widest border-b-2 border-red-600 pb-0.5"></span>
        
        <h1 id="news-title" class="text-3xl md:text-4xl lg:text-5xl font-serif font-bold text-gray-900 leading-tight tracking-tight"></h1>
        
        <div class="flex flex-wrap items-center gap-2 text-xs font-bold text-gray-400 border-y border-gray-100 py-3 uppercase tracking-wider">
            <span>OLEH: <span id="news-author" class="text-gray-700"></span></span>
            <span class="text-gray-300 hidden sm:inline">&bull;</span>
            <span id="news-date" class="font-semibold text-gray-500"></span>
        </div>

        <div class="w-full h-[300px] md:h-[450px] overflow-hidden rounded-sm bg-gray-100 shadow-xs">
            <img id="news-image" class="w-full h-full object-cover hover:scale-101 transition duration-500" src="" alt="">
        </div>

        <div id="news-text" class="text-gray-800 leading-relaxed text-base md:text-lg space-y-5 whitespace-pre-line font-serif pt-4">
            </div>
    </article>

    <div class="bg-gray-50/50 border-t border-gray-200 p-6 md:p-10">
        <div class="border-b border-gray-200 pb-3 mb-6 flex justify-between items-center">
            <h3 class="text-lg font-serif font-bold text-[#0c2340] tracking-tight uppercase">
                Opini Pembaca (<span id="comment-count">0</span>)
            </h3>
        </div>

        <div id="comment-form-container" class="mb-8">
            </div>

        <div id="comments-list" class="space-y-4">
            </div>
    </div>
</div>

<script>
    const newsId = "{{ $id }}";
    const token = localStorage.getItem('api_token');

    // 1. Fetch Detail Artikel & Daftar Komentarnya
    function fetchNewsDetail() {
        fetch(`/api/news/${newsId}`)
            .then(res => res.json())
            .then(response => {
                document.getElementById('loading').classList.add('hidden');
                
                if (response.status === 'success') {
                    const news = response.data;
                    
                    // Suntik teks artikel ke HTML
                    document.getElementById('news-content').classList.remove('hidden');
                    document.getElementById('news-title').innerText = news.title;
                    document.getElementById('news-category').innerText = news.category.name;
                    document.getElementById('news-author').innerText = news.user.name;
                    document.getElementById('news-date').innerText = new Date(news.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                    
                    let imageUrl = news.image ? `/uploads/news/${news.image}` : 'https://via.placeholder.com/800x450';
                    document.getElementById('news-image').src = imageUrl;
                    document.getElementById('news-image').alt = news.title;
                    document.getElementById('news-text').innerText = news.content;

                    // Atur angka counter komentar
                    document.getElementById('comment-count').innerText = news.comments.length;

                    // Render list kotak komentar
                    const commentsList = document.getElementById('comments-list');
                    commentsList.innerHTML = '';

                    if (news.comments.length > 0) {
                        news.comments.forEach(comment => {
                            let commentDate = new Date(comment.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute:'2-digit' });
                            
                            commentsList.innerHTML += `
                                <div class="bg-white border border-gray-200 p-4 rounded-sm shadow-xs flex gap-3 items-start">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-900 font-bold text-xs flex items-center justify-center flex-shrink-0 uppercase">
                                        ${comment.user.name.substring(0, 2)}
                                    </div>
                                    <div class="space-y-1 w-full">
                                        <div class="flex justify-between items-center">
                                            <strong class="text-xs text-[#0c2340] font-bold uppercase tracking-wide">${comment.user.name}</strong>
                                            <span class="text-[10px] text-gray-400 font-semibold">${commentDate}</span>
                                        </div>
                                        <p class="text-sm text-gray-700 leading-relaxed font-sans">${comment.content}</p>
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        commentsList.innerHTML = `
                            <div class="text-center py-8 text-xs text-gray-400 italic font-medium bg-white border border-dashed border-gray-200 rounded-sm">
                                Belum ada opini masuk. Tulis pemikiran Anda di bawah ini.
                            </div>
                        `;
                    }
                } else {
                    document.getElementById('loading').innerHTML = '<div class="text-red-600 font-bold text-xs py-12">Artikel tidak ditemukan atau telah diarsipkan.</div>';
                    document.getElementById('loading').classList.remove('hidden');
                }
            });
    }

    // 2. Cek Status Token untuk Tampilan Form Komentar
    function renderCommentForm() {
        const container = document.getElementById('comment-form-container');
        
        if (token) {
            container.innerHTML = `
                <form id="comment-form" class="space-y-3 bg-white p-4 border border-gray-200 rounded-sm shadow-xs">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kirim Opini Anda</span>
                    <textarea id="comment-content" required rows="3" placeholder="Sampaikan komentar Anda secara logis, santun, dan sesuai fakta..." class="w-full border border-gray-300 rounded-sm p-3 text-sm focus:outline-none focus:border-blue-900 font-sans"></textarea>
                    <div class="text-end">
                        <button type="submit" class="bg-[#0c2340] text-white px-5 py-2 rounded-sm text-xs font-bold hover:bg-blue-900 transition tracking-wider">KIRIM KOMENTAR</button>
                    </div>
                </form>
            `;
            document.getElementById('comment-form').addEventListener('submit', handleCommentSubmit);
        } else {
            container.innerHTML = `
                <div class="bg-blue-50 border border-blue-100 p-5 rounded-sm text-center">
                    <p class="text-xs font-semibold text-blue-900 mb-3">Seksi diskusi ini dilindungi. Anda diwajibkan masuk akun terlebih dahulu untuk mengirim komentar.</p>
                    <a href="/login" class="inline-block bg-[#0c2340] text-white px-5 py-1.5 rounded-sm text-xs font-bold hover:bg-blue-900 transition tracking-wider">LOGIN SEKARANG</a>
                </div>
            `;
        }
    }

    // 3. Eksekusi Pengiriman Komentar via API Ber-Token
    function handleCommentSubmit(e) {
        e.preventDefault();
        const contentInput = document.getElementById('comment-content');
        
        fetch('/api/comments', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token
            },
            body: JSON.stringify({
                news_id: newsId,
                content: contentInput.value
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                contentInput.value = '';
                fetchNewsDetail(); // Tarik ulang data biar komentar barunya langsung nembus ke layar
            } else {
                alert(data.message || 'Gagal mengirim komentar.');
            }
        });
    }

    // Jalankan prosedur utama
    fetchNewsDetail();
    renderCommentForm();
</script>
@endsection