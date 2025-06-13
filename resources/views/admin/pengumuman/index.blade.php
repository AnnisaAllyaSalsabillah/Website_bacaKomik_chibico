@extends('layouts.admin')

@section('title', 'Kelola Pengumuman')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-7xl">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-base-content mb-2">📢 Panel Pengumuman</h1>
            <p class="text-base-content/70">Tinggal ketik, klik, dan... boom! Semua pembaca langsung tahu.</p>
        </div>
        <button onclick="openCreateModal()" class="btn btn-primary gap-2 shadow-lg hover:shadow-xl transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah Pengumuman
        </button>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert shadow-lg mb-6 animate-pulse" style="background-color: #065F46; color: #A7F3D0; border: 1px solid #047857; border-radius: 12px; padding: 16px;">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="stats stats-vertical lg:stats-horizontal shadow-xl mb-8 w-full">
        <div class="stat bg-gradient-to-br from-primary/10 to-primary/5">
            <div class="stat-figure text-primary">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
            </div>
            <div class="stat-title">Total Pengumuman</div>
            <div class="stat-value text-primary">{{ $pengumuman->count() }}</div>
        </div>
        
        <div class="stat bg-gradient-to-br from-secondary/10 to-secondary/5">
            <div class="stat-figure text-secondary">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-title">Terbaru</div>
            <div class="stat-value text-secondary">{{ $pengumuman->where('created_at', '>=', now()->subDays(3))->count() }}</div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="card bg-base-100 shadow-xl mb-8">
        <div class="card-body">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="form-control flex-1">
                    <input type="text" id="searchInput" placeholder="Cari pengumuman..." class="input input-bordered w-full" onkeyup="filterPengumuman()">
                </div>
                <div class="form-control">
                    <select id="sortSelect" class="select select-bordered" onchange="sortPengumuman()">
                        <option value="newest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                        <option value="title">Judul A-Z</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengumuman Cards -->
    <div id="pengumumanContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($pengumuman as $item)
        <div class="pengumuman-card card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1" 
             data-title="{{ strtolower($item->title) }}" 
             data-date="{{ $item->created_at->timestamp }}">
            
            <!-- thumbnail image -->
            @if($item->thumbnail && $item->thumbnail !== '' && $item->thumbnail !== null)
            <figure class="relative overflow-hidden">
                <img src="{{ $item->thumbnail }}" alt="{{ $item->title }}" 
                    class="w-full h-48 object-cover transition-transform duration-300 hover:scale-110"
                    onerror="this.parentElement.style.display='none'">
                <div class="absolute top-4 right-4">
                    <div class="badge badge-primary badge-lg">{{ $item->created_at->diffForHumans() }}</div>
                </div>
            </figure>
            @else
            <figure class="bg-gradient-to-br from-primary/20 to-secondary/20 h-48 flex items-center justify-center">
                <svg class="w-16 h-16 text-base-content/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
            </figure>
            @endif

            <!-- Card Body -->
            <div class="card-body">
                <h2 class="card-title text-lg font-bold line-clamp-2">{{ $item->title }}</h2>
                <p class="text-base-content/70 line-clamp-3">{{ Str::limit(strip_tags($item->content), 100) }}</p>
                
                
                <div class="flex items-center gap-2 mt-2">
                    <div class="badge badge-outline">{{ $item->created_at->format('d M Y') }}</div>
                    <div class="badge badge-ghost">{{ str_word_count(strip_tags($item->content)) }} kata</div>
                </div>

                <!-- Actions -->
                <div class="card-actions justify-end mt-4">
                    <button onclick="viewPengumuman({{ $item->id }})" class="btn btn-ghost btn-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                    <button onclick="editPengumuman({{ $item->id }})" class="btn btn-warning btn-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                    <button onclick="deletePengumuman({{ $item->id }}, '{{ $item->title }}')" class="btn btn-error btn-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="card bg-base-200 shadow-xl">
                <div class="card-body items-center text-center py-16">
                    <svg class="w-24 h-24 text-base-content/30 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <h3 class="text-2xl font-bold mb-2">Belum ada pengumuman</h3>
                    <p class="text-base-content/70 mb-6">Mulai dengan menambahkan pengumuman pertama untuk pembaca komik</p>
                    <button onclick="openCreateModal()" class="btn btn-primary">Tambah Pengumuman Pertama</button>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>

<!-- Create/Edit Modal -->
<dialog id="pengumumanModal" class="modal">
    <div class="modal-box w-11/12 max-w-4xl">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        
        <h3 id="modalTitle" class="font-bold text-2xl mb-6">Tambah Pengumuman Baru</h3>
        
        <form id="pengumumanForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="methodField"></div>
            
            
            <div class="form-control w-full mb-6">
                <label class="label">
                    <span class="label-text font-semibold">Judul Pengumuman</span>
                    <span class="label-text-alt text-error">*wajib</span>
                </label>
                <input type="text" name="title" id="titleInput" placeholder="Masukkan judul..." 
                       class="input input-bordered w-full" required>
            </div>

            
            <div class="form-control w-full mb-6">
                <label class="label">
                    <span class="label-text font-semibold">Isi Pengumuman</span>
                    <span class="label-text-alt text-error">*wajib</span>
                </label>
                <textarea name="content" id="contentInput" placeholder="Tulis yang ingin kamu beritahu disini..." 
                          class="textarea textarea-bordered h-32" required></textarea>
            </div>

        
            <div class="form-control w-full mb-6">
                <label class="label">
                    <span class="label-text font-semibold">Thumbnail</span>
                    <span class="label-text-alt text-info">opsional</span>
                </label>
                <input type="file" name="thumbnail" id="thumbnailInput" accept="image/*" 
                       class="file-input file-input-bordered w-full" onchange="previewImage(this)">
                <label class="label">
                    <span class="label-text-alt">Format: JPG, PNG, JPEG (Max: 2MB)</span>
                </label>
                
                
                <div id="imagePreview" class="mt-4 hidden">
                    <img id="previewImg" class="w-full max-w-sm rounded-lg shadow-lg" alt="Preview">
                </div>
            </div>

            
            <div class="modal-action">
                <button type="button" onclick="document.getElementById('pengumumanModal').close()" class="btn btn-ghost">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <span id="submitText">Kirim</span>
                    <span id="loadingSpinner" class="loading loading-spinner loading-sm hidden"></span>
                </button>
            </div>
        </form>
    </div>
</dialog>

<!-- View Modal -->
<dialog id="viewModal" class="modal">
    <div class="modal-box w-11/12 max-w-3xl">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        
        <div id="viewContent">
            
        </div>
    </div>
</dialog>

<!-- Delete konfirmasi -->
<dialog id="deleteModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg text-error mb-4">⚠️ Konfirmasi Hapus</h3>
        <p class="mb-4">Apakah Anda yakin ingin menghapus pengumuman "<span id="deleteTitle" class="font-semibold"></span>"?</p>
        <p class="text-sm text-base-content/70 mb-6">Tindakan ini tidak dapat dibatalkan.</p>
        
        <div class="modal-action">
            <button onclick="document.getElementById('deleteModal').close()" class="btn btn-ghost">Batal</button>
            <form id="deleteForm" method="POST" style="display: inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-error">Ya, Hapus</button>
            </form>
        </div>
    </div>
</dialog>

<script>
let currentEditId = null;
let pengumumanData = @json($pengumumanData);
console.log(pengumumanData);

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing modal functions...');
    
    window.pengumumanModal = document.getElementById('pengumumanModal');
    window.viewModal = document.getElementById('viewModal');
    window.deleteModal = document.getElementById('deleteModal');
    
    console.log('Modals initialized:', {
        pengumumanModal: !!window.pengumumanModal,
        viewModal: !!window.viewModal,
        deleteModal: !!window.deleteModal
    });
});

function openCreateModal() {
    console.log('Opening create modal...');
    
    try {
        const modal = document.getElementById('pengumumanModal');
        const form = document.getElementById('pengumumanForm');
        
        if (!modal) {
            console.error('Modal not found!');
            return;
        }
        
        // Reset modal content
        document.getElementById('modalTitle').textContent = '📝 Tambah Pengumuman Baru';
        form.action = '{{ route("admin.pengumuman.store") }}';
        document.getElementById('methodField').innerHTML = '';
        document.getElementById('submitText').textContent = 'Simpan Pengumuman';
        
        // Reset form
        form.reset();
        document.getElementById('imagePreview').classList.add('hidden');
        currentEditId = null;
        
        
        modal.showModal();
        console.log('Modal opened successfully');
        
    } catch (error) {
        console.error('Error opening modal:', error);
        alert('Terjadi kesalahan saat membuka modal. Silakan refresh halaman.');
    }
}

// Edit pengumuman
function editPengumuman(id) {
    console.log('Editing pengumuman:', id);
    
    const pengumuman = pengumumanData.find(p => p.id === id);
    if (!pengumuman) {
        console.error('Pengumuman not found:', id);
        return;
    }
    
    try {
        const modal = document.getElementById('pengumumanModal');
        const form = document.getElementById('pengumumanForm');
        
        document.getElementById('modalTitle').textContent = '✏️ Edit Pengumuman';
        form.action = `/admin/pengumuman/${id}`;
        document.getElementById('methodField').innerHTML = '@method("PUT")';
        document.getElementById('submitText').textContent = 'Update Pengumuman';
        
        
        document.getElementById('titleInput').value = pengumuman.title;
        document.getElementById('contentInput').value = pengumuman.content;
        
        if (pengumuman.thumbnail && pengumuman.thumbnail !== '' && pengumuman.thumbnail !== null) {
            document.getElementById('imagePreview').classList.remove('hidden');
            document.getElementById('previewImg').src = pengumuman.thumbnail;
            document.getElementById('previewImg').onerror = function() {
                console.error('Failed to load image:', pengumuman.thumbnail);
                document.getElementById('imagePreview').classList.add('hidden');
            };
        } else {
            document.getElementById('imagePreview').classList.add('hidden');
        }
        
        currentEditId = id;
        modal.showModal();
        
    } catch (error) {
        console.error('Error editing pengumuman:', error);
        alert('Terjadi kesalahan saat membuka form edit.');
    }
}

// View pengumuman
function viewPengumuman(id) {
    console.log('Viewing pengumuman:', id);
    
    const pengumuman = pengumumanData.find(p => p.id === id);
    if (!pengumuman) {
        console.error('Pengumuman not found:', id);
        return;
    }
    
    try {
        let thumbnailHtml = '';
        if (pengumuman.thumbnail && pengumuman.thumbnail !== '' && pengumuman.thumbnail !== null) {
            thumbnailHtml = `<img src="${pengumuman.thumbnail}" alt="${pengumuman.title}" class="w-full max-w-md mx-auto rounded-lg shadow-lg mb-4" onerror="this.style.display='none'">`;
        }
        
        const content = `
            <div class="text-center mb-6">
                ${thumbnailHtml}
                <h2 class="text-2xl font-bold mb-2">${pengumuman.title}</h2>
                <div class="badge badge-primary">${pengumuman.formatted_date}</div>
            </div>
            <div class="prose max-w-none">
                <p class="text-base-content/80 leading-relaxed">${pengumuman.content}</p>
            </div>
        `;
        
        document.getElementById('viewContent').innerHTML = content;
        document.getElementById('viewModal').showModal();
        
    } catch (error) {
        console.error('Error viewing pengumuman:', error);
        alert('Terjadi kesalahan saat menampilkan pengumuman.');
    }
}

// Delete pengumuman
function deletePengumuman(id, title) {
    console.log('Deleting pengumuman:', id, title);
    
    try {
        document.getElementById('deleteTitle').textContent = title;
        document.getElementById('deleteForm').action = `/admin/pengumuman/${id}`;
        document.getElementById('deleteModal').showModal();
        
    } catch (error) {
        console.error('Error deleting pengumuman:', error);
        alert('Terjadi kesalahan saat membuka konfirmasi hapus.');
    }
}

// Preview image
function previewImage(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar. Maksimal 2MB.');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}

// Filter pengumuman
function filterPengumuman() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const cards = document.querySelectorAll('.pengumuman-card');
    
    cards.forEach(card => {
        const title = card.dataset.title;
        if (title.includes(searchTerm)) {
            card.style.display = 'block';
            card.classList.add('animate-fade-in');
        } else {
            card.style.display = 'none';
        }
    });
}

// Sorting pengumuman
function sortPengumuman() {
    const sortValue = document.getElementById('sortSelect').value;
    const container = document.getElementById('pengumumanContainer');
    const cards = Array.from(container.querySelectorAll('.pengumuman-card'));
    
    cards.sort((a, b) => {
        switch(sortValue) {
            case 'newest':
                return parseInt(b.dataset.date) - parseInt(a.dataset.date);
            case 'oldest':
                return parseInt(a.dataset.date) - parseInt(b.dataset.date);
            case 'title':
                return a.dataset.title.localeCompare(b.dataset.title);
            default:
                return 0;
        }
    });
    
    
    cards.forEach(card => container.appendChild(card));
}


document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('pengumumanForm');
    if (form) {
        form.addEventListener('submit', function() {
            document.getElementById('submitText').style.display = 'none';
            document.getElementById('loadingSpinner').classList.remove('hidden');
        });
    }
});

setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) {
            alert.style.transition = 'opacity 0.5s ease-out';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    }, 5000);
</script>

<style>
.animate-fade-in {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

@endsection