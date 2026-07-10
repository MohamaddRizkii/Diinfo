@extends('layouts.app')

@section('content')
<script>
    const token = localStorage.getItem('api_token');
    if (!token) window.location.href = '/login';
</script>

<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b-2 border-gray-800 pb-4 gap-2">
        <div>
            <a href="/admin/dashboard" class="text-[10px] text-gray-400 font-bold uppercase tracking-widest hover:text-blue-900 transition">&larr; Dashboard</a>
            <h1 class="text-2xl font-serif font-black text-gray-900 tracking-tight mt-1">Bilik Penulisan Artikel</h1>
        </div>
        <button onclick="showCreateForm()" class="bg-[#c8102e] text-white text-[10px] font-bold px-4 py-2.5 rounded-sm hover:bg-red-700 transition uppercase tracking-wider shadow-xs"> + Buat Manuskrip Baru </button>
    </div>

    <!-- FORM BOX DIALOG (HIDDEN DEFAULT) -->
    <div id="news-form-container" class="bg-white border border-gray-200 p-6 rounded-sm shadow-md hidden space-y-4">
        <h3 class="text-base font-serif font-bold text-gray-800 border-b border-gray-100 pb-2" id="form-title">Tulis Manuskrip</h3>
        <form id="news-form" class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <input type="hidden" id="news-id">
            <div class="space-y-4">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Judul Utama Publikasi</label>
                    <input type="text" id="news-title" required class="w-full border border-gray-300 rounded-sm px-3 py-2 text-sm focus:outline-none focus:border-blue-900 font-medium">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Kategori Kolom</label>
                    <select id="news-category-id" required class="w-full border border-gray-300 rounded-sm px-3 py-2 text-sm focus:outline-none focus:border-blue-900 bg-white font-medium"></select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">File Gambar (Thumbnail Medial)</label>
                    <input type="file" id="news-image" accept="image/*" class="w-full border border-gray-300 rounded-sm px-2 py-1.5 text-xs bg-white font-medium">
                </div>
            </div>
            <div class="flex flex-col">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Narasi Konten Berita</label>
                <textarea id="news-content-text" required rows="7" placeholder="Tuliskan berita secara komprehensif di sini..." class="w-full border border-gray-300 rounded-sm p-3 text-sm focus:outline-none focus:border-blue-900 flex-grow font-serif leading-relaxed"></textarea>
            </div>
            <div class="md:col-span-2 flex justify-end gap-2 border-t border-gray-100 pt-4">
                <button type="button" onclick="hideForm()" class="bg-gray-100 text-gray-600 text-xs font-bold px-4 py-2 rounded-sm hover:bg-gray-200 uppercase tracking-wide">Batal</button>
                <button type="submit" class="bg-[#0c2340] text-white text-xs font-bold px-5 py-2 rounded-sm hover:bg-blue-900 uppercase tracking-wide shadow-sm">Terbitkan Sekarang</button>
            </div>
        </form>
    </div>

    <!-- MAIN MANAGE TABLE -->
    <div class="bg-white border border-gray-200 p-5 rounded-sm shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-gray-400 border-b border-gray-200 uppercase font-bold tracking-wider">
                        <th class="py-3 w-20">Media</th>
                        <th class="py-3">Judul Publikasi</th>
                        <th class="py-3">Kategori</th>
                        <th class="py-3 text-right">Aksi Manajemen</th>
                    </tr>
                </thead>
                <tbody id="news-table-body" class="divide-y divide-gray-50 align-middle"></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function loadCategoriesDropdown() {
        fetch('/api/categories').then(res => res.json()).then(response => {
            const select = document.getElementById('news-category-id');
            select.innerHTML = '<option value="">-- Tentukan Bidang --</option>';
            if(response.status === 'success') {
                response.data.forEach(cat => { select.innerHTML += `<option value="${cat.id}">${cat.name}</option>`; });
            }
        });
    }

    function loadAdminNews() {
        fetch('/api/news?all=1').then(res => res.json()).then(response => {
            const tbody = document.getElementById('news-table-body');
            tbody.innerHTML = '';
            if(response.status === 'success' && response.data.data.length > 0) {
                response.data.data.forEach(item => {
                    let imgUrl = item.image ? `/uploads/news/${item.image}` : 'https://via.placeholder.com/80x50';
                    tbody.innerHTML += `
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="py-3"><img src="${imgUrl}" class="w-14 h-9 object-cover rounded-sm border shadow-2xs"></td>
                            <td class="py-3 font-serif font-bold text-gray-800 text-sm max-w-xs truncate">${item.title}</td>
                            <td class="py-3"><span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded-xs text-[10px] font-bold uppercase">${item.category.name}</span></td>
                            <td class="py-3 text-right font-sans space-x-3"><button onclick="editNews(${item.id})" class="text-blue-600 font-bold hover:underline uppercase text-[10px]">Ubah</button><button onclick="deleteNews(${item.id})" class="text-red-600 font-bold hover:underline uppercase text-[10px]">Hapus</button></td>
                        </tr>
                    `;
                });
            } else {
                tbody.innerHTML = `<tr><td colspan="4" class="text-center py-8 text-gray-400 italic">Belum ada naskah yang terarsip.</td></tr>`;
            }
        });
    }

    document.getElementById('news-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('news-id').value;
        const formData = new FormData();
        formData.append('category_id', document.getElementById('news-category-id').value);
        formData.append('title', document.getElementById('news-title').value);
        formData.append('content', document.getElementById('news-content-text').value);
        
        const imgFile = document.getElementById('news-image').files[0];
        if(imgFile) formData.append('image', imgFile);

        fetch(id ? `/api/news/${id}` : '/api/news', {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token },
            body: formData
        }).then(res => res.json()).then(() => { hideForm(); loadAdminNews(); });
    });

    function editNews(id) {
        fetch(`/api/news/${id}`).then(res => res.json()).then(response => {
            if(response.status === 'success') {
                const news = response.data;
                document.getElementById('news-id').value = news.id;
                document.getElementById('news-title').value = news.title;
                document.getElementById('news-category-id').value = news.category_id;
                document.getElementById('news-content-text').value = news.content;
                document.getElementById('news-image').required = false;
                document.getElementById('form-title').innerText = 'Revisi Manuskrip Berita';
                document.getElementById('news-form-container').classList.remove('hidden');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    }

    function deleteNews(id) {
        if(confirm('Hapus dokumen naskah berita ini?')) {
            fetch(`/api/news/${id}`, { method: 'DELETE', headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' } })
            .then(() => loadAdminNews());
        }
    }

    function showCreateForm() {
        document.getElementById('news-id').value = '';
        document.getElementById('news-form').reset();
        document.getElementById('news-image').required = true;
        document.getElementById('form-title').innerText = 'Tulis Manuskrip Baru';
        document.getElementById('news-form-container').classList.remove('hidden');
    }

    function hideForm() { document.getElementById('news-form-container').classList.add('hidden'); }

    loadCategoriesDropdown();
    loadAdminNews();
</script>
@endsection
