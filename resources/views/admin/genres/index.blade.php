@extends('layouts.admin')
@section('content')
<div class="min-h-screen p-4 sm:p-6 lg:p-8" style="background-color: #000000; color: #D7DAE1;">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="text-center">
                <h1 class="text-3xl font-bold" style="color: #FFFFFF;">Genre Playground</h1>
                <p class="mt-1" style="color: #9CA3AF;">Kelola semua genre yang tersedia di sistem</p>
            </div>
            <button class="btn gap-2 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105" 
                    style="background: linear-gradient(135deg, #E91E63, #9C27B0); color: white; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 600;"
                    onclick="add_genre_modal.showModal()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Genre
            </button>
        </div>
    </div>

    
    @if(session('success'))
        <div class="alert shadow-lg mb-6 animate-pulse" style="background-color: #065F46; color: #A7F3D0; border: 1px solid #047857; border-radius: 12px; padding: 16px;">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="stat shadow-lg bg-base-100 border-2 border-pink-500 rounded-2xl p-6 hover:border-pink-400 transition-colors duration-300">
        <div class="stat-figure text-pink-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
        </div>
        <div class="stat-title text-base-content opacity-70">Total Genre</div>
        <div class="stat-value text-pink-500">{{ $genres->count() }}</div>
    </div>

    <div class="stat shadow-lg bg-base-100 border-2 border-purple-500 rounded-2xl p-6 hover:border-purple-400 transition-colors duration-300">
        <div class="stat-figure text-purple-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="stat-title text-base-content opacity-70">Terakhir Ditambahkan</div>
        <div class="stat-value text-2xl text-purple-500">{{ $genres->last() ? $genres->last()->created_at->diffForHumans() : 'N/A' }}</div>
    </div>
</div>

    <!-- Search | Filter -->
    <div class="rounded-xl p-6 mb-6 shadow-lg" style="background-color: #1F2937; border: 1px solid #374151;">
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="form-control flex-1">
                <div class="input-group">
                    <input type="text" placeholder="Cari genre..." 
                           class="input flex-1" 
                           style="background-color: #374151; border: 1px solid #4B5563; color: #D7DAE1; border-radius: 8px 0 0 8px; padding: 12px 16px;"
                           id="searchInput">
                    <button class="btn" style="background: linear-gradient(135deg, #E91E63, #9C27B0); color: white; border: none; border-radius: 0 8px 8px 0; padding: 12px 16px;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </div>
            <select class="select" style="background-color: #374151; border: 1px solid #4B5563; color: #D7DAE1; border-radius: 8px; padding: 10px 16px;" id="sortSelect">
                <option>Urutkan berdasarkan</option>
                <option value="name_asc">Nama A-Z</option>
                <option value="name_desc">Nama Z-A</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="genreGrid">
        @forelse($genres as $genre)
            <div class="card shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 genre-card" 
                 style="background-color: #1F2937; border: 1px solid #374151; border-radius: 16px;"
                 data-name="{{ strtolower($genre->name) }}">
                <div class="card-body p-6">
                    <div class="flex items-start justify-between mb-4">
                        
                    </div>
                    
                    <h2 class="card-title text-xl mb-2" style="color: #FFFFFF;">{{ $genre->name }}</h2>
                    <p class="text-sm mb-4" style="color: #9CA3AF;">
                        Dibuat {{ $genre->created_at->diffForHumans() }}
                    </p>
                    
                    <div class="card-actions justify-between items-center">
                        <div class="badge" style="background-color: #065F46; color: #A7F3D0; border: 1px solid #047857; padding: 4px 12px; border-radius: 16px;">Active</div>
                        <div class="flex gap-2">
                            <button class="btn btn-sm" 
                                    style="background-color: transparent; border: 1px solid #60A5FA; color: #60A5FA; border-radius: 8px; padding: 6px 12px;"
                                    onclick="openEditModal({{ $genre->id }}, '{{ $genre->name }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button class="btn btn-sm" 
                                    style="background-color: transparent; border: 1px solid #F87171; color: #F87171; border-radius: 8px; padding: 6px 12px;"
                                    onclick="confirmDelete({{ $genre->id }}, '{{ $genre->name }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="max-w-md mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto mb-4" style="color: #6B7280;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <h3 class="text-lg font-semibold mb-2" style="color: #FFFFFF;">Belum Ada Genre</h3>
                    <p class="mb-4" style="color: #9CA3AF;">Mulai dengan menambahkan genre pertama Anda</p>
                    <button class="btn" 
                            style="background: linear-gradient(135deg, #E91E63, #9C27B0); color: white; border: none; padding: 12px 24px; border-radius: 8px;"
                            onclick="add_genre_modal.showModal()">Tambah Genre</button>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Add Genre -->
    <dialog id="add_genre_modal" class="modal">
        <form method="POST" action="{{ route('admin.genres.store') }}" class="modal-box w-11/12 max-w-lg" 
              style="background-color: #1F2937; border: 1px solid #374151; border-radius: 16px;">
            @csrf
            <h3 class="font-bold text-2xl mb-6 text-center" style="color: #E91E63;">Tambah Genre Baru</h3>
            
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text font-semibold text-base" style="color: #D7DAE1;">Nama Genre</span>
                </label>
                <input type="text" name="name" placeholder="Masukkan nama genre..." 
                       class="input w-full" 
                       style="background-color: #374151; border: 1px solid #4B5563; color: #D7DAE1; border-radius: 8px; padding: 12px 16px;"
                       required maxlength="255">
                <label class="label">
                    <span class="label-text-alt" style="color: #9CA3AF;">Maksimal 255 karakter</span>
                </label>
            </div>

            <div class="modal-action">
                <button type="button" class="btn" 
                        style="background-color: transparent; border: 1px solid #6B7280; color: #9CA3AF; border-radius: 8px; padding: 12px 24px;"
                        onclick="add_genre_modal.close()">Batal</button>
                <button type="submit" class="btn" 
                        style="background: linear-gradient(135deg, #E91E63, #9C27B0); color: white; border: none; border-radius: 8px; padding: 12px 24px;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Genre
                </button>
            </div>
        </form>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <!-- Edit Genre -->
    <dialog id="edit_genre_modal" class="modal">
        <form method="POST" id="editForm" class="modal-box w-11/12 max-w-lg" 
              style="background-color: #1F2937; border: 1px solid #374151; border-radius: 16px;">
            @csrf
            @method('PUT')
            <h3 class="font-bold text-2xl mb-6 text-center" style="color: #60A5FA;">Edit Genre</h3>
            
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text font-semibold text-base" style="color: #D7DAE1;">Nama Genre</span>
                </label>
                <input type="text" name="name" id="editGenreName" placeholder="Masukkan nama genre..." 
                       class="input w-full" 
                       style="background-color: #374151; border: 1px solid #4B5563; color: #D7DAE1; border-radius: 8px; padding: 12px 16px;"
                       required maxlength="255">
                <label class="label">
                    <span class="label-text-alt" style="color: #9CA3AF;">Maksimal 255 karakter</span>
                </label>
            </div>

            <div class="modal-action">
                <button type="button" class="btn" 
                        style="background-color: transparent; border: 1px solid #6B7280; color: #9CA3AF; border-radius: 8px; padding: 12px 24px;"
                        onclick="edit_genre_modal.close()">Batal</button>
                <button type="submit" class="btn" 
                        style="background-color: #60A5FA; color: white; border: none; border-radius: 8px; padding: 12px 24px;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Update Genre
                </button>
            </div>
        </form>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <!-- Delete - Konfirmasi -->
    <dialog id="delete_genre_modal" class="modal">
        <div class="modal-box w-11/12 max-w-md text-center" 
             style="background-color: #1F2937; border: 1px solid #374151; border-radius: 16px;">
            <h3 class="font-bold text-2xl mb-4" style="color: #F87171;">Konfirmasi Hapus</h3>
            <div class="mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4" style="color: #F87171;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
                <p style="color: #D7DAE1;">Apakah Anda yakin ingin menghapus genre <strong id="deleteGenreName" style="color: #F87171;"></strong>?</p>
                <p class="text-sm mt-2" style="color: #9CA3AF;">Genre yang telah dihapus tidak dapat dibatalkan.</p>
            </div>
            
            <div class="modal-action justify-center">
                <button type="button" class="btn" 
                        style="background-color: transparent; border: 1px solid #6B7280; color: #9CA3AF; border-radius: 8px; padding: 12px 24px;"
                        onclick="delete_genre_modal.close()">Batal</button>
                <form method="POST" id="deleteForm" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn" 
                            style="background-color: #DC2626; color: white; border: none; border-radius: 8px; padding: 12px 24px;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
</div>

<script>
    // Edit Genre
    function openEditModal(id, name) {
        document.getElementById('editGenreName').value = name;
        document.getElementById('editForm').action = `/admin/genres/${id}`;
        document.getElementById('edit_genre_modal').showModal();
    }

    // Delete - Konfirmasi
    function confirmDelete(id, name) {
        document.getElementById('deleteGenreName').textContent = name;
        document.getElementById('deleteForm').action = `/admin/genres/${id}`;
        document.getElementById('delete_genre_modal').showModal();
    }

    // Search 
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const genreCards = document.querySelectorAll('.genre-card');
        
        genreCards.forEach(card => {
            const genreName = card.getAttribute('data-name');
            if (genreName.includes(searchTerm)) {
                card.style.display = 'block';
                card.classList.add('animate-pulse');
                setTimeout(() => card.classList.remove('animate-pulse'), 300);
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Sorting
    document.getElementById('sortSelect').addEventListener('change', function(e) {
        const sortType = e.target.value;
        const genreGrid = document.getElementById('genreGrid');
        const genreCards = Array.from(document.querySelectorAll('.genre-card'));
        
        if (sortType === 'name_asc') {
            genreCards.sort((a, b) => a.getAttribute('data-name').localeCompare(b.getAttribute('data-name')));
        } else if (sortType === 'name_desc') {
            genreCards.sort((a, b) => b.getAttribute('data-name').localeCompare(a.getAttribute('data-name')));
        }
        
        genreCards.forEach(card => {
            genreGrid.appendChild(card);
            card.classList.add('animate-pulse');
            setTimeout(() => card.classList.remove('animate-pulse'), 300);
        });
    });

    // success alert
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) {
            alert.style.transition = 'opacity 0.5s ease-out';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    }, 5000);

    // page load
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.genre-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>
@endsection