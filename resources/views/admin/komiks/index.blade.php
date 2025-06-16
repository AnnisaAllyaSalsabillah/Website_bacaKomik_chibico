@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col lg:flex-row justify-between items-center lg:items-center mb-6 gap-4">
        <div class="text-center">
            <h1 class="text-3xl font-bold text-base-content">Manajemen Komik</h1>
            <p class="text-base-content/70 mt-1">Kelola semua komik dalam aplikasi</p>
        </div>
        <button class="btn btn-primary gap-2" onclick="openAddModal()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Komik
        </button>
    </div>

    @if(session('success'))
        <div class="alert shadow-lg mb-6 animate-pulse" style="background-color: #065F46; color: #A7F3D0; border: 1px solid #047857; border-radius: 12px; padding: 16px;">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="stat bg-base-100 rounded-2xl shadow-sm border border-base-200">
            <div class="stat-figure text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div class="stat-title">Total Komik</div>
            <div class="stat-value text-primary">{{ $komiks->count() }}</div>
            <div class="stat-desc">Dari semua kategori</div>
        </div>
        
        <div class="stat bg-base-100 rounded-2xl shadow-sm border border-base-200">
            <div class="stat-figure text-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div class="stat-title">Ongoing</div>
            <div class="stat-value text-success">{{ $komiks->where('status', 'ongoing')->count() }}</div>
            <div class="stat-desc">Masih berlanjut</div>
        </div>
        
        <div class="stat bg-base-100 rounded-2xl shadow-sm border border-base-200">
            <div class="stat-figure text-info">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="stat-title">Completed</div>
            <div class="stat-value text-info">{{ $komiks->where('status', 'completed')->count() }}</div>
            <div class="stat-desc">Sudah tamat</div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="card bg-base-100 shadow-sm border border-base-200 mb-6">
        <div class="card-body p-4">
            <div class="flex flex-col lg:flex-row gap-4">
                <div class="form-control flex-1">
                    <input type="text" placeholder="Cari komik..." class="input input-bordered w-full" id="searchInput">
                </div>
                <div class="form-control lg:w-48">
                    <select class="select select-bordered w-full" id="typeFilter">
                        <option value="">Semua Tipe</option>
                        <option value="manga">Manga</option>
                        <option value="manhwa">Manhwa</option>
                        <option value="manhua">Manhua</option>
                    </select>
                </div>
                <div class="form-control lg:w-48">
                    <select class="select select-bordered w-full" id="statusFilter">
                        <option value="">Semua Status</option>
                        <option value="ongoing">Ongoing</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Comics Grid -->
    <div class="grid grid-cols-4 sm:grid-cols-5 md:grid-cols-8 lg:grid-cols-11 xl:grid-cols-14 2xl:grid-cols-16 gap-1 md:gap-2" id="comicsGrid">
        @foreach($komiks as $komik)
        <div class="card bg-base-100 shadow-md hover:shadow-xl transition-all duration-300 border border-base-200 comic-card group will-change-transform" 
            data-title="{{ strtolower($komik->title) }}" 
            data-type="{{ $komik->type }}" 
            data-status="{{ $komik->status }}">
            
            <!-- Cover Image - Dominant Height -->
            <figure class="relative overflow-hidden rounded-t-2xl">
                <img src="{{ $komik->cover_image ?? '/images/no-cover.png' }}" 
                    alt="{{ $komik->title }}" 
                    class="w-full h-60 sm:h-68 md:h-76 lg:h-84 object-cover transition-transform duration-300 group-hover:scale-105 will-change-transform"
                    loading="lazy" />
                
                <!-- Overlay with Action Buttons (Hidden by default, shown on hover) -->
                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center will-change-auto">
                    <div class="flex gap-2">
                        <button class="btn btn-sm btn-circle btn-ghost bg-white/20 backdrop-blur-sm hover:bg-white/30 transition-colors duration-200" 
                                onclick="viewComic({{ $komik->id }})" 
                                title="View Comic"
                                type="button"
                                aria-label="View Comic">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                        <!-- Tombol Chapters baru -->
                        <button class="btn btn-sm btn-circle btn-ghost bg-white/20 backdrop-blur-sm hover:bg-white/30 transition-colors duration-200" 
                                onclick="manageChapters({{ $komik->id }})" 
                                title="Manage Chapters"
                                type="button"
                                aria-label="Manage Chapters">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </button>
                        <button class="btn btn-sm btn-circle btn-ghost bg-white/20 backdrop-blur-sm hover:bg-white/30 transition-colors duration-200" 
                                onclick="editComic({{ $komik->id }})" 
                                title="Edit Comic"
                                type="button"
                                aria-label="Edit Comic">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <button class="btn btn-sm btn-circle btn-ghost bg-white/20 backdrop-blur-sm hover:bg-white/30 transition-colors duration-200" 
                                onclick="deleteComic({{ $komik->id }}, '{{ $komik->title }}')" 
                                title="Delete Comic"
                                type="button"
                                aria-label="Delete Comic">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="absolute top-2 right-2">
                    <div class="badge badge-{{ $komik->status === 'ongoing' ? 'success' : 'info' }} badge-sm font-medium">
                        {{ ucfirst($komik->status) }}
                    </div>
                </div>

                <!-- Type Badge -->
                <div class="absolute top-2 left-2">
                    <div class="badge badge-{{ $komik->type === 'manga' ? 'primary' : ($komik->type === 'manhwa' ? 'secondary' : 'accent') }} badge-sm font-medium">
                        {{ ucfirst($komik->type) }}
                    </div>
                </div>
            </figure>

            <!-- Card Content - Compact -->
            <div class="card-body p-3">
                <!-- Title -->
                <h2 class="card-title text-xs sm:text-sm font-bold line-clamp-2 leading-tight mb-2" title="{{ $komik->title }}">
                    {{ $komik->title }}
                </h2>
                
                <!-- Compact Info -->
                <div class="text-xs text-base-content/70 space-y-1">
                    @if($komik->author)
                        <p class="truncate" title="{{ $komik->author }}">
                            <span class="font-semibold">Author:</span> {{ $komik->author }}
                        </p>
                    @endif
                    @if($komik->release_year)
                        <p><span class="font-semibold">Year:</span> {{ $komik->release_year }}</p>
                    @endif
                    @if($komik->genres->count() > 0)
                        <p class="truncate" title="{{ $komik->genres->pluck('name')->implode(', ') }}">
                            <span class="font-semibold">Genre:</span> {{ $komik->genres->pluck('name')->take(2)->implode(', ') }}{{ $komik->genres->count() > 2 ? '...' : '' }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($komiks->count() === 0)
    <div class="text-center py-12">
        <div class="text-6xl mb-4">📚</div>
        <h3 class="text-2xl font-bold mb-2">Belum Ada Komik</h3>
        <p class="text-base-content/70 mb-4">Mulai tambahkan komik pertama Anda</p>
        <button class="btn btn-primary" onclick="openAddModal()">Tambah Komik</button>
    </div>
    @endif
</div>

<!-- Add Comic Modal -->
<dialog id="addModal" class="modal">
    <div class="modal-box w-11/12 max-w-4xl">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="font-bold text-lg mb-4">Tambah Komik Baru</h3>
        
        <form action="{{ route('admin.komiks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Grid Layout dengan 2 Kolom untuk Desktop -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Kolom Kiri -->
                <div class="space-y-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Judul <span class="text-error">*</span></span>
                        </label>
                        <input type="text" name="title" class="input input-bordered" required>
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Slug</span>
                        </label>
                        <input type="text" name="slug" class="input input-bordered">
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Author</span>
                        </label>
                        <input type="text" name="author" class="input input-bordered">
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Artist</span>
                        </label>
                        <input type="text" name="artist" class="input input-bordered">
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Judul Alternatif</span>
                        </label>
                        <input type="text" name="alternative" class="input input-bordered">
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="space-y-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Tipe <span class="text-error">*</span></span>
                        </label>
                        <select name="type" class="select select-bordered" required>
                            <option value="">Pilih Tipe</option>
                            <option value="manga">Manga</option>
                            <option value="manhwa">Manhwa</option>
                            <option value="manhua">Manhua</option>
                        </select>
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Status <span class="text-error">*</span></span>
                        </label>
                        <select name="status" class="select select-bordered" required>
                            <option value="">Pilih Status</option>
                            <option value="ongoing">Ongoing</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Tahun Rilis</span>
                        </label>
                        <input type="text" name="release_year" class="input input-bordered">
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Cover Image</span>
                        </label>
                        <input type="file" name="cover_image" class="file-input file-input-bordered" accept="image/*">
                        <div class="label">
                            <span class="label-text-alt">Max: 2MB | Format: JPG, PNG</span>
                        </div>
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Genre <span class="text-error">*</span></span>
                        </label>
                        <div class="grid grid-cols-2 gap-2 max-h-32 overflow-y-auto p-3 border border-base-300 rounded-lg bg-base-50">
                            @if(isset($genres) && $genres->count() > 0)
                                @foreach($genres as $genre)
                                <label class="label cursor-pointer justify-start gap-2 hover:bg-base-200 p-1 rounded">
                                    <input type="checkbox" name="genres[]" value="{{ $genre->id }}" class="checkbox checkbox-sm checkbox-primary">
                                    <span class="label-text text-sm">{{ $genre->name }}</span>
                                </label>
                                @endforeach
                            @else
                                <div class="col-span-full text-center py-4">
                                    <p class="text-sm text-base-content/60">Tidak ada genre tersedia.</p>
                                    <p class="text-xs text-base-content/40 mt-1">Silakan tambahkan genre terlebih dahulu.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sinopsis - Full Width -->
            <div class="form-control mt-6">
                <label class="label">
                    <span class="label-text font-medium">Sinopsis</span>
                </label>
                <textarea name="sinopsis" class="textarea textarea-bordered h-32 resize-none" placeholder="Masukkan sinopsis komik..."></textarea>
                
            </div>
            
            <div class="modal-action">
                <button type="button" class="btn btn-ghost" onclick="closeAddModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</dialog>

<!-- Edit Comic Modal -->
<dialog id="editModal" class="modal">
    <div class="modal-box w-11/12 max-w-4xl">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="font-bold text-lg mb-4">Edit Komik</h3>
        
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- Grid Layout dengan 2 Kolom untuk Desktop -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Kolom Kiri -->
                <div class="space-y-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Judul <span class="text-error">*</span></span>
                        </label>
                        <input type="text" name="title" id="edit_title" class="input input-bordered" required>
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Slug</span>
                        </label>
                        <input type="text" name="slug" id="edit_slug" class="input input-bordered">
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Author</span>
                        </label>
                        <input type="text" name="author" id="edit_author" class="input input-bordered">
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Artist</span>
                        </label>
                        <input type="text" name="artist" id="edit_artist" class="input input-bordered">
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Judul Alternatif</span>
                        </label>
                        <input type="text" name="alternative" id="edit_alternative" class="input input-bordered">
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Rank</span>
                        </label>
                        <input type="text" name="rank" id="edit_rank" class="input input-bordered">
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="space-y-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Tipe <span class="text-error">*</span></span>
                        </label>
                        <select name="type" id="edit_type" class="select select-bordered" required>
                            <option value="">Pilih Tipe</option>
                            <option value="manga">Manga</option>
                            <option value="manhwa">Manhwa</option>
                            <option value="manhua">Manhua</option>
                        </select>
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Status <span class="text-error">*</span></span>
                        </label>
                        <select name="status" id="edit_status" class="select select-bordered" required>
                            <option value="">Pilih Status</option>
                            <option value="ongoing">Ongoing</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Tahun Rilis</span>
                        </label>
                        <input type="text" name="release_year" id="edit_release_year" class="input input-bordered">
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Cover Image</span>
                        </label>
                        <input type="file" name="cover_image" class="file-input file-input-bordered" accept="image/*">
                        <div class="label">
                            <span class="label-text-alt">Kosongkan jika tidak ingin mengubah cover | Max: 2MB</span>
                        </div>
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Genre <span class="text-error">*</span></span>
                        </label>
                        <div id="editGenres" class="grid grid-cols-2 gap-2 max-h-32 overflow-y-auto p-3 border border-base-300 rounded-lg bg-base-50">
                            <!-- Genres will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sinopsis - Full Width -->
            <div class="form-control mt-6">
                <label class="label">
                    <span class="label-text font-medium">Sinopsis</span>
                </label>
                <textarea name="sinopsis" id="edit_sinopsis" class="textarea textarea-bordered h-32 resize-none" placeholder="Masukkan sinopsis komik..."></textarea>
            </div>
            
            <div class="modal-action">
                <button type="button" class="btn btn-ghost" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</dialog>

<!-- View komik -->
<dialog id="viewModal" class="modal">
    <div class="modal-box w-11/12 max-w-5xl max-h-[90vh] overflow-y-auto">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2 z-10">✕</button>
        </form>
        
        <div id="viewLoading" class="flex items-center justify-center py-12">
            <div class="loading loading-spinner loading-lg"></div>
        </div>
        
        <div id="viewContent" class="hidden">
            <div class="flex flex-col lg:flex-row gap-6 mb-6">
                <!-- Cover Image -->
                <div class="flex-shrink-0 mx-auto lg:mx-0">
                    <div class="w-48 h-64 sm:w-56 sm:h-72 lg:w-64 lg:h-80 relative overflow-hidden rounded-lg shadow-lg">
                        <img id="viewCover" 
                             src="" 
                             alt="Comic Cover" 
                             class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                             onerror="this.src='/images/no-cover.png'">
                    </div>
                </div>
                
                <!-- Basic Info -->
                <div class="flex-1 space-y-4">
                    <div>
                        <h1 id="viewTitle" class="text-2xl sm:text-3xl font-bold text-base-content mb-2"></h1>
                        <p id="viewAlternative" class="text-base-content/70 text-sm sm:text-base font-medium"></p>
                    </div>
                    
                    <div class="flex flex-wrap gap-2">
                        <span id="viewStatusBadge" class="badge badge-lg font-medium"></span>
                        <span id="viewTypeBadge" class="badge badge-lg font-medium"></span>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-3">
                            <div id="viewAuthorSection" class="hidden">
                                <span class="text-sm font-semibold text-base-content/70">Author:</span>
                                <p id="viewAuthor" class="font-medium"></p>
                            </div>
                            <div id="viewArtistSection" class="hidden">
                                <span class="text-sm font-semibold text-base-content/70">Artist:</span>
                                <p id="viewArtist" class="font-medium"></p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div id="viewYearSection" class="hidden">
                                <span class="text-sm font-semibold text-base-content/70">Release Year:</span>
                                <p id="viewYear" class="font-medium"></p>
                            </div>
                            <div id="viewRankSection" class="hidden">
                                <span class="text-sm font-semibold text-base-content/70">Rank:</span>
                                <p id="viewRank" class="font-medium"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="space-y-6">
                <div id="viewGenresSection" class="hidden">
                    <h3 class="text-lg font-semibold mb-3">Genres</h3>
                    <div id="viewGenres" class="flex flex-wrap gap-2"></div>
                </div>
                
                <div id="viewSinopsisSection" class="hidden">
                    <h3 class="text-lg font-semibold mb-3">Synopsis</h3>
                    <div class="prose prose-sm sm:prose max-w-none">
                        <p id="viewSinopsis" class="text-base-content/80 leading-relaxed whitespace-pre-line"></p>
                    </div>
                </div>
                
                <div class="bg-base-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-3">Additional Information</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-semibold text-base-content/70">Slug:</span>
                            <p id="viewSlug" class="font-mono text-xs bg-base-300 px-2 py-1 rounded mt-1"></p>
                        </div>
                        <div>
                            <span class="font-semibold text-base-content/70">Created:</span>
                            <p id="viewCreated" class="mt-1"></p>
                        </div>
                        <div>
                            <span class="font-semibold text-base-content/70">Last Updated:</span>
                            <p id="viewUpdated" class="mt-1"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</dialog>

<!-- Delete Konfirmasi -->
<dialog id="deleteModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Konfirmasi Hapus</h3>
        <p class="py-4">Apakah Anda yakin ingin menghapus komik "<span id="deleteComicTitle"></span>"?</p>
        <div class="modal-action">
            <button class="btn btn-ghost" onclick="closeDeleteModal()">Batal</button>
            <form id="deleteForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-error">Hapus</button>
            </form>
        </div>
    </div>
</dialog>

<script>
    // Search | Filter
    const searchInput = document.getElementById('searchInput');
    const typeFilter = document.getElementById('typeFilter');
    const statusFilter = document.getElementById('statusFilter');
    const comicsGrid = document.getElementById('comicsGrid');
    const comicCards = document.querySelectorAll('.comic-card');

    function filterComics() {
        const searchTerm = searchInput.value.toLowerCase();
        const typeValue = typeFilter.value;
        const statusValue = statusFilter.value;

        comicCards.forEach(card => {
            const title = card.getAttribute('data-title');
            const type = card.getAttribute('data-type');
            const status = card.getAttribute('data-status');

            const matchesSearch = title.includes(searchTerm);
            const matchesType = typeValue === '' || type === typeValue;
            const matchesStatus = statusValue === '' || status === statusValue;

            if (matchesSearch && matchesType && matchesStatus) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterComics);
    typeFilter.addEventListener('change', filterComics);
    statusFilter.addEventListener('change', filterComics);

    function openAddModal() {
        document.getElementById('addModal').showModal();
    }

    function closeAddModal() {
        document.getElementById('addModal').close();
    }

    function closeEditModal() {
        document.getElementById('editModal').close();
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').close();
    }

    // format date
    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function getStatusBadgeClass(status) {
        return status === 'ongoing' ? 'badge-success' : 'badge-info';
    }

    function getTypeBadgeClass(type) {
        switch (type) {
            case 'manga': return 'badge-primary';
            case 'manhwa': return 'badge-secondary';
            case 'manhua': return 'badge-accent';
            default: return 'badge-neutral';
        }
    }

    function viewComic(id) {
        const modal = document.getElementById('viewModal');
        const loading = document.getElementById('viewLoading');
        const content = document.getElementById('viewContent');
        
        loading.classList.remove('hidden');
        content.classList.add('hidden');
        modal.showModal();
        
        // Fetch detail komik
        fetch(`/admin/komiks/${id}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const komik = data.komik;
                
                document.getElementById('viewTitle').textContent = komik.title || 'No Title';
                document.getElementById('viewAlternative').textContent = komik.alternative || 'No Alternative Title';
                
                const coverImg = document.getElementById('viewCover');
                if (komik.cover_image) {
                    coverImg.src = komik.cover_image;
                } else {
                    coverImg.src = '/images/no-cover.png';
                }

                const statusBadge = document.getElementById('viewStatusBadge');
                statusBadge.textContent = komik.status ? komik.status.charAt(0).toUpperCase() + komik.status.slice(1) : 'Unknown';
                statusBadge.className = `badge badge-lg font-medium ${getStatusBadgeClass(komik.status)}`;
                
                const typeBadge = document.getElementById('viewTypeBadge');
                typeBadge.textContent = komik.type ? komik.type.charAt(0).toUpperCase() + komik.type.slice(1) : 'Unknown';
                typeBadge.className = `badge badge-lg font-medium ${getTypeBadgeClass(komik.type)}`;
                
                const authorSection = document.getElementById('viewAuthorSection');
                if (komik.author) {
                    document.getElementById('viewAuthor').textContent = komik.author;
                    authorSection.classList.remove('hidden');
                } else {
                    authorSection.classList.add('hidden');
                }
                
                const artistSection = document.getElementById('viewArtistSection');
                if (komik.artist) {
                    document.getElementById('viewArtist').textContent = komik.artist;
                    artistSection.classList.remove('hidden');
                } else {
                    artistSection.classList.add('hidden');
                }

                const yearSection = document.getElementById('viewYearSection');
                if (komik.release_year) {
                    document.getElementById('viewYear').textContent = komik.release_year;
                    yearSection.classList.remove('hidden');
                } else {
                    yearSection.classList.add('hidden');
                }
                
                const rankSection = document.getElementById('viewRankSection');
                if (komik.rank) {
                    document.getElementById('viewRank').textContent = komik.rank;
                    rankSection.classList.remove('hidden');
                } else {
                    rankSection.classList.add('hidden');
                }
                
                const genresSection = document.getElementById('viewGenresSection');
                const genresContainer = document.getElementById('viewGenres');
                if (komik.genres && komik.genres.length > 0) {
                    genresContainer.innerHTML = '';
                    komik.genres.forEach(genre => {
                        const genreBadge = document.createElement('span');
                        genreBadge.className = 'badge badge-outline badge-sm';
                        genreBadge.textContent = genre.name;
                        genresContainer.appendChild(genreBadge);
                    });
                    genresSection.classList.remove('hidden');
                } else {
                    genresSection.classList.add('hidden');
                }
                
                const sinopsisSection = document.getElementById('viewSinopsisSection');
                if (komik.sinopsis) {
                    document.getElementById('viewSinopsis').textContent = komik.sinopsis;
                    sinopsisSection.classList.remove('hidden');
                } else {
                    sinopsisSection.classList.add('hidden');
                }
                
                document.getElementById('viewSlug').textContent = komik.slug || 'N/A';
                document.getElementById('viewCreated').textContent = formatDate(komik.created_at);
                document.getElementById('viewUpdated').textContent = formatDate(komik.updated_at);
                
                loading.classList.add('hidden');
                content.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                loading.innerHTML = `
                    <div class="text-center py-12">
                        <div class="text-error text-lg mb-2">❌</div>
                        <h3 class="text-lg font-bold mb-2">Error Loading Comic</h3>
                        <p class="text-base-content/70 mb-4">Terjadi kesalahan saat memuat detail komik</p>
                        <button class="btn btn-primary btn-sm" onclick="viewComic(${id})">Try Again</button>
                    </div>
                `;
            });
    }

    function editComic(id) {
        fetch(`/admin/komiks/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                const komik = data.komik;
                const genres = data.genres;
                
                document.getElementById('edit_title').value = komik.title || '';
                document.getElementById('edit_slug').value = komik.slug || '';
                document.getElementById('edit_author').value = komik.author || '';
                document.getElementById('edit_artist').value = komik.artist || '';
                document.getElementById('edit_type').value = komik.type || '';
                document.getElementById('edit_status').value = komik.status || '';
                document.getElementById('edit_alternative').value = komik.alternative || '';
                document.getElementById('edit_release_year').value = komik.release_year || '';
                document.getElementById('edit_rank').value = komik.rank || '';
                document.getElementById('edit_sinopsis').value = komik.sinopsis || '';
                
                document.getElementById('editForm').action = `/admin/komiks/${id}`;
                
                const genresContainer = document.getElementById('editGenres');
                genresContainer.innerHTML = '';
                
                genres.forEach(genre => {
                    const isChecked = komik.genres.some(g => g.id === genre.id);
                    genresContainer.innerHTML += `
                        <label class="label cursor-pointer justify-start gap-2 hover:bg-base-200 p-1 rounded">
                            <input type="checkbox" name="genres[]" value="${genre.id}" class="checkbox checkbox-sm checkbox-primary" ${isChecked ? 'checked' : ''}>
                            <span class="label-text text-sm">${genre.name}</span>
                        </label>
                    `;
                });
                
                document.getElementById('editModal').showModal();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memuat data komik');
            });
    }

    function deleteComic(id, title) {
        document.getElementById('deleteComicTitle').textContent = title;
        document.getElementById('deleteForm').action = `/admin/komiks/${id}`;
        document.getElementById('deleteModal').showModal();
    }

    function manageChapters(komikId) {
    // Tampilkan loading indicator
    const loadingOverlay = document.createElement('div');
    loadingOverlay.innerHTML = `
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" id="chaptersLoadingOverlay">
            <div class="bg-base-100 rounded-lg p-6 flex items-center gap-3 shadow-xl">
                <div class="loading loading-spinner loading-md"></div>
                <span class="text-sm font-medium">Membuka Chapters</span>
            </div>
        </div>
    `;
    document.body.appendChild(loadingOverlay);

    // Redirect ke halaman chapters dengan smooth transition
    setTimeout(() => {
        window.location.href = `/admin/komiks/${komikId}/chapters`;
    }, 300);
}

// Fungsi untuk smooth scroll back dari chapter ke komik
function backToComics() {
    const loadingOverlay = document.createElement('div');
    loadingOverlay.innerHTML = `
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" id="backLoadingOverlay">
            <div class="bg-base-100 rounded-lg p-6 flex items-center gap-3 shadow-xl">
                <div class="loading loading-spinner loading-md"></div>
                <span class="text-sm font-medium">Kembali ke Komik</span>
            </div>
        </div>
    `;
    document.body.appendChild(loadingOverlay);

    setTimeout(() => {
        window.location.href = '/admin/komiks';
    }, 300);
}

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
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .comic-card {
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        will-change: transform;
        transform: translateZ(0);
    }
    
    .comic-card:hover {
        transform: translateY(-4px) translateZ(0);
    }

    #viewModal .modal-box {
        background: linear-gradient(135deg, oklch(var(--b1)) 0%, oklch(var(--b2)) 100%);
    }
    
    #viewCover {
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
        border: 2px solid oklch(var(--b3));
    }
    
    .prose p {
        text-align: justify;
        line-height: 1.7;
    }
    
    #viewContent {
        animation: fadeInUp 0.3s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .badge-lg {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 600;
        letter-spacing: 0.025em;
    }
    
    @media (max-width: 640px) {
        .comic-card .card-body {
            padding: 0.75rem;
        }
        
        .comic-card h2 {
            font-size: 0.75rem;
            line-height: 1rem;
        }
        
        .comic-card {
            transition: transform 0.2s ease-out, box-shadow 0.2s ease-out;
        }
        
        .comic-card:hover {
            transform: translateY(-2px) translateZ(0);
        }
        
        .comic-card img {
            transition: transform 0.2s ease-out;
        }
        
        .comic-card .group-hover\:opacity-100 {
            transition: opacity 0.2s ease-out;
        }
        
        #viewModal .modal-box {
            padding: 1rem;
            max-height: 95vh;
        }
        
        #viewCover {
            width: 12rem;
            height: 16rem;
        }
        
        .prose {
            font-size: 0.875rem;
        }
    }
    
    @media (min-width: 641px) {
        .comic-card {
            transition: transform 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94), box-shadow 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
    }
    
    .loading {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    #viewModal .modal-box::-webkit-scrollbar {
        width: 6px;
    }
    
    #viewModal .modal-box::-webkit-scrollbar-track {
        background: oklch(var(--b3));
        border-radius: 3px;
    }
    
    #viewModal .modal-box::-webkit-scrollbar-thumb {
        background: oklch(var(--bc) / 0.3);
        border-radius: 3px;
    }
    
    #viewModal .modal-box::-webkit-scrollbar-thumb:hover {
        background: oklch(var(--bc) / 0.5);
    }
</style>
@endsection