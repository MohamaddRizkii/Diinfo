@extends('layouts.app')

@section('content')
<script>
    const token = localStorage.getItem('api_token');
    if (!token) window.location.href = '/login';
</script>

<div class="space-y-6">
    <div class="border-b-2 border-gray-800 pb-4">
        <a href="/admin/dashboard" class="text-[10px] text-gray-400 font-bold uppercase tracking-widest hover:text-blue-900 transition">&larr; Kembali Ke Dashboard</a>
        <h1 class="text-2xl font-serif font-black text-gray-900 tracking-tight mt-1">Struktur Kategori Redaksi</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- FORM PENGISIAN -->
        <div class="bg-white border border-gray-200 p-5 rounded-sm shadow-xs h-fit">
            <h3 class="text-xs font-bold uppercase tracking-wider text-gray-800 border-b border-gray-100 pb-2 mb-4" id="form-title">Tambah Kategori Baru</h3>
            <form id="category-form" class="space-y-4">
                <input type="hidden" id="category-id">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Deskriptor</label>
                    <input type="text" id="category-name" required placeholder="Misal: Teknologi" class="w-full border border-gray-300 rounded-sm px-3 py-2 text-sm focus:outline-none focus:border-blue-900 font-medium">
                </div>
                <div class="flex gap-2">
                    <button type="submit" id="btn-submit" class="bg-[#0c2340] text-white text-xs font-bold py-2 rounded-sm hover:bg-blue-900 transition w-full uppercase tracking-widest">Simpan</button>
                    <button type="button" id="btn-cancel" onclick="resetForm()" class="bg-gray-100 text-gray-600 text-xs font-bold py-2 rounded-sm hover:bg-gray-200 transition w-full uppercase tracking-widest hidden">Batal</button>
                </div>
            </form>
        </div>

        <!-- TABEL KATEGORI -->
        <div class="lg:col-span-2 bg-white border border-gray-200 p-5 rounded-sm shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-400 border-b border-gray-200 uppercase font-bold tracking-wider">
                            <th class="py-3">Nama Kategori</th>
                            <th class="py-3">Alamat Sipil (Slug)</th>
                            <th class="py-3 text-right">Manajemen</th>
                        </tr>
                    </thead>
                    <tbody id="categories-table-body" class="divide-y divide-gray-50 font-medium"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function loadCategories() {
        fetch('/api/categories')
            .then(res => res.json())
            .then(response => {
                const tbody = document.getElementById('categories-table-body');
                tbody.innerHTML = '';
                if(response.status === 'success') {
                    response.data.forEach(cat => {
                        tbody.innerHTML += `
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-3.5 text-gray-800 font-bold font-serif text-sm">${cat.name}</td>
                                <td class="py-3.5 text-gray-400 font-mono text-[11px]">/${cat.slug}</td>
                                <td class="py-3.5 text-right font-sans space-x-3"><button onclick="editCategory(${cat.id}, '${cat.name}')" class="text-blue-600 font-bold hover:underline uppercase text-[10px] tracking-wider">Ubah</button><button onclick="deleteCategory(${cat.id})" class="text-red-600 font-bold hover:underline uppercase text-[10px] tracking-wider">Hapus</button></td>
                            </tr>
                        `;
                    });
                }
            });
    }

    document.getElementById('category-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('category-id').value;
        const name = document.getElementById('category-name').value;
        fetch(id ? `/api/categories/${id}` : '/api/categories', {
            method: id ? 'PUT' : 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'Authorization': 'Bearer ' + token },
            body: JSON.stringify({ name: name })
        }).then(res => res.json()).then(() => { resetForm(); loadCategories(); });
    });

    function editCategory(id, name) {
        document.getElementById('category-id').value = id;
        document.getElementById('category-name').value = name;
        document.getElementById('form-title').innerText = 'Ubah Entitas Kategori';
        document.getElementById('btn-cancel').classList.remove('hidden');
    }

    function deleteCategory(id) {
        if(confirm('Peringatan: Menghapus kategori akan menghapus artikel di dalamnya!')) {
            fetch(`/api/categories/${id}`, {
                method: 'DELETE',
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
            }).then(() => loadCategories());
        }
    }

    function resetForm() {
        document.getElementById('category-id').value = '';
        document.getElementById('category-form').reset();
        document.getElementById('form-title').innerText = 'Tambah Kategori Baru';
        document.getElementById('btn-cancel').classList.add('hidden');
    }
    loadCategories();
</script>
@endsection
