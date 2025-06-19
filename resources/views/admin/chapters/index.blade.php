@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-base-200">
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-black/80">
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat blur-sm scale-110 opacity-30"
                 style="background-image: url('{{ $komik->cover_image ?? '/images/no-cover.png' }}');">
            </div>
        </div>
        
        <!-- Content -->
        <div class="relative z-10 container mx-auto px-4 py-8">
            <div class="breadcrumbs text-sm mb-6">
                <ul class="text-white/80">
                    <li>
                        <button onclick="backToComics()" class="text-white hover:text-secondary transition-colors duration-200 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                            </svg>
                            Kembali ke Komik
                        </button>
                    </li>
                    <li class="text-white/60">{{ $komik->title }}</li>
                </ul>
            </div>

            <!-- Komik Info -->
            <div class="flex flex-col lg:flex-row gap-8 items-start">
                <!-- komik Cover -->
                <div class="relative">
                    <div class="w-48 h-64 sm:w-56 sm:h-72 rounded-xl shadow-2xl overflow-hidden border-4 border-white/20">
                        <img src="{{ $komik->cover_image ?? '/images/no-cover.png' }}" 
                             alt="{{ $komik->title }}" 
                             class="w-full h-full object-cover" />
                    </div>
                    
                    <div class="absolute -top-2 -right-2">
                        <div class="badge badge-{{ $komik->status === 'ongoing' ? 'success' : 'info' }} badge-lg shadow-lg">
                            {{ ucfirst($komik->status) }}
                        </div>
                    </div>
                </div>

                <!-- Komik Detail -->
                <div class="flex-1 text-white min-w-0">
                    <!-- Judul -->
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4 leading-tight">
                        {{ $komik->title }}
                    </h1>
                    
                    <!-- Judul alternative -->
                    @if($komik->alternative)
                    <p class="text-lg text-white/80 mb-4 font-medium">{{ $komik->alternative }}</p>
                    @endif
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                        <!-- Author -->
                        @if($komik->author)
                        <div class="flex flex-col">
                            <span class="text-white/60 text-sm uppercase tracking-wide font-semibold">Author</span>
                            <span class="text-white font-medium">{{ $komik->author }}</span>
                        </div>
                        @endif
                        
                        <!-- Artist -->
                        @if($komik->artist)
                        <div class="flex flex-col">
                            <span class="text-white/60 text-sm uppercase tracking-wide font-semibold">Artist</span>
                            <span class="text-white font-medium">{{ $komik->artist }}</span>
                        </div>
                        @endif
                        
                        <!-- Type -->
                        <div class="flex flex-col">
                            <span class="text-white/60 text-sm uppercase tracking-wide font-semibold">Type</span>
                            <div class="flex items-center gap-2">
                                <div class="badge badge-{{ $komik->type === 'manga' ? 'primary' : ($komik->type === 'manhwa' ? 'secondary' : 'accent') }}">
                                    {{ ucfirst($komik->type) }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Total Chapters -->
                        <div class="flex flex-col">
                            <span class="text-white/60 text-sm uppercase tracking-wide font-semibold">Chapters</span>
                            <span class="text-white font-medium text-lg">{{ $chapters->count() }}</span>
                        </div>
                        
                        <!-- Tahun rilis -->
                        @if($komik->release_year)
                        <div class="flex flex-col">
                            <span class="text-white/60 text-sm uppercase tracking-wide font-semibold">Released</span>
                            <span class="text-white font-medium">{{ $komik->release_year }}</span>
                        </div>
                        @endif
                        
                    </div>
                    
                    <!-- Genres -->
                    @if($komik->genres && $komik->genres->count() > 0)
                    <div class="mb-6">
                        <span class="text-white/60 text-sm uppercase tracking-wide font-semibold block mb-2">Genres</span>
                        <div class="flex flex-wrap gap-2">
                            @foreach($komik->genres as $genre)
                            <span class="badge badge-outline badge-lg text-white border-white/30 hover:bg-white/10 transition-colors">
                                {{ $genre->name }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Synopsis -->
                    @if($komik->sinopsis)
                    <div class="mb-6">
                        <span class="text-white/60 text-sm uppercase tracking-wide font-semibold block mb-2">Sinopsis</span>
                        <p id="sinopsisText" class="text-white/90 leading-relaxed text-sm sm:text-base line-clamp-4 transition-all duration-300 ease-in-out">
                            {{ $komik->sinopsis }}
                        </p>
                        <button id="toggleSinopsis" class="mt-2 text-secondary-content hover:underline text-sm">
                            More
                        </button>
                    </div>
                    @endif
                    
                    <div class="flex flex-wrap gap-3">
                        <button onclick="openAddChapterModal()" 
                               class="btn btn-secondary btn-lg shadow-xl hover:shadow-2xl transition-all duration-300 gap-2 bg-white text-secondary hover:bg-white/90">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add Chapter
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
<div class="min-h-screen bg-base-50">
    <!-- Chapters Section -->
    <div class="container mx-auto px-4 py-8">
        @if(session('success'))
        <div class="alert alert-success mb-6 shadow-lg animate-fade-in">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <!-- Chapters Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div class="text-center">
                <h2 class="text-2xl sm:text-3xl font-bold text-base-content mb-2">Chapters</h2>
                <p class="text-base-content/70">Kelola semua chaptersnya disini~!</p>
            </div>
            
            <!-- Search Bar -->
            <div class="relative max-w-sm w-full sm:w-auto">
                <input type="text" 
                       placeholder="Cari chapters..." 
                       class="input input-bordered w-full pl-10 pr-4 shadow-md focus:ring-2 focus:ring-primary transition-all"
                       id="searchChapter">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-base-content/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        <div class="chapters-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @if($chapters->count() > 0)
                @foreach($chapters->sortBy('chapter') as $chapter)
                <div class="chapter-card bg-base-100 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 border border-base-300 group">
                    <!-- cover chapter -->
                    <div class="relative aspect-[3/4] bg-gradient-to-br from-base-200 to-base-300 overflow-hidden">
                        @if($chapter->images->first())
                            <img src="{{ $chapter->images->first()->image_path }}" 
                                 alt="Chapter {{ $chapter->chapter }}" 
                                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" />
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/10 to-secondary/10">
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-base-content/30 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-sm text-base-content/50 font-medium">No Preview</p>
                                </div>
                            </div>
                        @endif
                        
                        <div class="absolute top-3 left-3">
                            <div class="badge badge-secondary badge-lg font-bold shadow-lg">
                                Ch. {{ $chapter->chapter }}
                            </div>
                        </div>
                        
                        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center gap-3">
                            <button onclick="viewChapter({{ $chapter->id }})" 
                                    class="btn btn-circle btn-lg btn-ghost text-white hover:bg-white/20 shadow-xl transform hover:scale-110 transition-all"
                                    title="View Chapter">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            
                            <a href="javascript:void(0)" 
                                onclick="editChapter({{ $komik->id }}, {{ $chapter->id }})"
                                class="btn btn-circle btn-lg btn-secondary shadow-xl transform hover:scale-110 transition-all"
                                title="Edit Chapter">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            
                            <button onclick="deleteChapter({{ $komik->id }}, {{ $chapter->id }}, '{{ $chapter->chapter }}', '{{ $chapter->title }}')" 
                                    class="btn btn-circle btn-lg btn-error shadow-xl transform hover:scale-110 transition-all"
                                    title="Delete Chapter">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Chapter Info -->
                    <div class="p-4 sm:p-5">
                        <div class="flex items-start justify-between gap-2 mb-3">
                            <h3 class="font-bold text-lg text-secondary flex-1 min-w-0">
                                Chapter {{ $chapter->chapter }}
                            </h3>
                            <div class="badge badge-outline badge-sm shrink-0">
                                {{ $chapter->images->count() }} pages
                            </div>
                        </div>
                        
                        <h4 class="font-semibold text-base-content mb-3 line-clamp-2 text-sm leading-relaxed">
                            {{ $chapter->title }}
                        </h4>
                        
                        <div class="flex items-center justify-between text-xs text-base-content/60">
                            <span>
                                @if($chapter->release_at)
                                    {{ \Carbon\Carbon::parse($chapter->release_at)->format('d M Y') }}
                                @else
                                    Not released
                                @endif
                            </span>
                            <span class="text-success font-medium">
                                {{ $chapter->release_at ? \Carbon\Carbon::parse($chapter->release_at)->diffForHumans() : 'Draft' }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Empty State -->
                <div class="col-span-full">
                    <div class="card bg-base-100 shadow-xl border border-base-200">
                        <div class="card-body text-center py-16">
                            <div class="text-8xl mb-6">📖</div>
                            <h3 class="text-2xl font-bold mb-3">Yahh, Belum ada chapter saat ini</h3>
                            <p class="text-base-content/60 mb-8 text-lg">Ayo mulai tambahkan chapter pertamamu!</p>
                            <div class="flex justify-center">
                                <button onclick="openAddChapterModal()" 
                                        class="btn btn-secondary gap-2 px-6 py-2 shadow-lg hover:shadow-xl transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Tambah Chapter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Chapter -->
<dialog id="addChapterModal" class="modal">
    <div class="modal-box w-11/12 max-w-4xl max-h-[90vh] p-0 overflow-hidden">
        <div class="sticky top-0 z-10 bg-gradient-to-r from-primary to-secondary text-white p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white/20 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold">Tambah Chapter baru</h2>
                        <p class="text-white/80 text-sm">Buat chapter baru untuk {{ $komik->title }}</p>
                    </div>
                </div>
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost text-white hover:bg-white/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
            <form action="{{ route('admin.chapters.store', $komik->id) }}" method="POST" enctype="multipart/form-data" id="addChapterForm">
                @csrf
                
                <!-- Chapter Info Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-base">Chapter ke-</span>
                            <span class="label-text-alt text-xs text-error">*Wajib</span>
                        </label>
                        <input type="number" 
                            name="chapter" 
                            class="input input-bordered input-lg focus:ring-2 focus:ring-primary transition-all" 
                            placeholder="Enter chapter number" 
                            min="1"
                            value="{{ ($chapters->max('chapter') ?? 0) + 1 }}"
                            required>
                        <label class="label">
                            <span class="label-text-alt text-xs text-base-content/60">Next available: {{ ($chapters->max('chapter') ?? 0) + 1 }}</span>
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-base">Headline chapter</span>
                            <span class="label-text-alt text-xs text-error">*Wajib</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               class="input input-bordered input-lg focus:ring-2 focus:ring-primary transition-all" 
                               placeholder="Enter chapter title" 
                               required>
                        <label class="label">
                            <span class="label-text-alt text-xs text-base-content/60">Deskripsikan headline untuk chapter ini...</span>
                        </label>
                    </div>
                </div>

                <!-- Images Upload -->
                <div class="form-control mb-8">
                    <label class="label">
                        <span class="label-text font-semibold text-base">Konten chapter</span>
                        <span class="label-text-alt text-xs text-error">*Wajib</span>
                    </label>
                    
                    <div class="relative">
                        <input type="file" 
                               name="images[]" 
                               multiple 
                               accept="image/jpeg,image/png,image/jpg"
                               class="hidden" 
                               id="chapterImages"
                               required>
                        
                        <div id="uploadArea" class="border-2 border-dashed border-base-300 hover:border-secondary hover:bg-secondary/5 transition-all duration-300 rounded-xl p-8 text-center cursor-pointer group">
                            <div class="space-y-4">
                                <div class="mx-auto w-16 h-16 bg-secondary/10 rounded-full flex items-center justify-center group-hover:bg-secondary/20 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-lg font-semibold text-base-content mb-2">Drop gambarmu disini atau klik untuk browse</p>
                                    <p class="text-sm text-base-content/60">Support: JPEG, PNG, JPG • Max size: 2MB each</p>
                                </div>
                                <button type="button" class="btn btn-secondary btn-outline" id="chooseImagesBtn">
                                    Pilih
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Preview Area -->
                    <div id="imagePreview" class="hidden mt-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-semibold text-base">Gambar yang dipilih</h4>
                            <button type="button" id="clearImages" class="btn btn-sm btn-ghost text-error">
                                Hapus semua
                            </button>
                        </div>
                        <div id="previewContainer" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-base-200">
                    <button type="button" 
                            onclick="document.getElementById('addChapterModal').close()" 
                            class="btn btn-ghost btn-lg order-2 sm:order-1">
                        Batal
                    </button>
                    <button type="submit" 
                            class="btn btn-secondary btn-lg gap-2 order-1 sm:order-2 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300"
                            id="submitBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Buat Chapter
                    </button>
                </div>
            </form>
        </div>
    </div>
</dialog>

<!-- View Chapter -->
<dialog id="viewChapterModal" class="modal">
    <div class="modal-box w-11/12 max-w-6xl max-h-[90vh] overflow-y-auto">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2 z-10">✕</button>
        </form>
        
        <div id="chapterLoading" class="flex items-center justify-center py-16">
            <div class="text-center">
                <div class="loading loading-spinner loading-lg mb-4"></div>
                <p class="text-base-content/70">Loading chapter...</p>
            </div>
        </div>
        
        <div id="chapterContent" class="hidden">
            <div class="mb-8">
                <h2 id="chapterTitle" class="text-3xl font-bold mb-3"></h2>
                <p id="chapterInfo" class="text-base-content/70 text-lg"></p>
            </div>
            
            <div id="chapterImages" class="space-y-6"></div>
        </div>
    </div>
</dialog>

<!-- Edit Chapter -->
<dialog id="editChapterModal" class="modal">
    <div class="modal-box w-11/12 max-w-5xl max-h-[95vh] p-0 overflow-hidden bg-base-100 shadow-2xl">
        <div class="sticky top-0 z-10 bg-gradient-to-r from-primary via-primary to-primary-focus text-primary-content p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-secondary-content/20 rounded-xl backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <h2 class="text-2xl font-bold tracking-tight">Edit Chapter</h2>
                        <p class="text-secondary-content/80 text-sm font-medium">Perbarui konten chaptermu dan kelola gambar</p>
                    </div>
                </div>
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost text-secondary-content hover:bg-secondary-content/20 hover:rotate-90 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <div class="p-6 overflow-y-auto max-h-[calc(95vh-140px)] space-y-8">
            <form id="editChapterForm" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')
                
                <!-- Chapter Info Section -->
                <div class="card bg-base-50 shadow-sm border border-base-200">
                    <div class="card-body p-6">
                        <h3 class="card-title text-lg font-semibold text-secondary mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Chapter Info
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-base flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                        </svg>
                                        Chapter ke-
                                    </span>
                                    <span class="label-text-alt text-xs text-error font-medium">*Required</span>
                                </label>
                                <input type="number" 
                                    name="chapter" 
                                    id="editChapterNumber"
                                    class="input input-bordered input-lg focus:input-secondary focus:ring-2 focus:ring-secondary/20 transition-all duration-300 bg-base-100 hover:bg-base-50" 
                                    placeholder="Enter chapter number" 
                                    min="1"
                                    required>
                            </div>
                            
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-base flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        Headline chapter
                                    </span>
                                    <span class="label-text-alt text-xs text-error font-medium">*Required</span>
                                </label>
                                <input type="text" 
                                       name="title" 
                                       id="editChapterTitle"
                                       class="input input-bordered input-lg focus:input-secondary focus:ring-2 focus:ring-secondary/20 transition-all duration-300 bg-base-100 hover:bg-base-50" 
                                       placeholder="Enter chapter title" 
                                       required>
                            </div>
                        </div>

                        <!-- Slug -->
                        <div class="form-control mt-6">
                            <label class="label">
                                <span class="label-text font-semibold text-base flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                    Chapter Slug
                                </span>
                                <span class="label-text-alt text-xs text-base-content/60 font-medium">Auto-generated from title</span>
                            </label>
                            <input type="text" 
                                   name="slug" 
                                   id="editChapterSlug"
                                   class="input input-bordered input-lg focus:input-secondary focus:ring-2 focus:ring-secondary/20 transition-all duration-300 bg-base-100 hover:bg-base-50" 
                                   placeholder="chapter-slug" 
                                   required>
                        </div>
                    </div>
                </div>

                <!-- Current Images -->
                <div class="card bg-gradient-to-br from-base-50 to-base-100 shadow-sm border border-base-200">
                    <div class="card-body p-6">
                        <h3 class="card-title text-lg font-semibold text-secondary mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Gambar saat ini
                        </h3>
                        
                        <div id="currentImagesContainer" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                            
                        </div>
                    </div>
                </div>

                <!-- New Images Upload -->
                <div class="card bg-gradient-to-br from-primary/5 to-primary/10 shadow-sm border border-primary/20">
                    <div class="card-body p-6">
                        <h3 class="card-title text-lg font-semibold text-secondary mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Perbarui semua gambar
                            <span class="badge badge-secondary badge-sm">Optional</span>
                        </h3>

                        <div class="relative">
                            <input type="file" 
                                   name="images[]" 
                                   multiple 
                                   accept="image/jpeg,image/png,image/jpg"
                                   class="hidden" 
                                   id="editChapterImages">
                            
                            <div id="editUploadArea" class="border-2 border-dashed border-secondary/30 hover:border-secondary hover:bg-secondary/5 transition-all duration-300 rounded-2xl p-8 text-center cursor-pointer group relative overflow-hidden">
                                <div class="absolute inset-0 opacity-5">
                                    <div class="absolute inset-0 bg-gradient-to-br from-primary to-primary-focus"></div>
                                </div>
                                
                                <div class="relative space-y-6">
                                    <div class="mx-auto w-20 h-20 bg-gradient-to-br from-primary/20 to-primary/30 rounded-full flex items-center justify-center group-hover:scale-110 transition-all duration-300 shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                    </div>
                                    
                                    <div class="space-y-3">
                                        <h4 class="text-xl font-bold text-secondary">Upload Gambar Baru</h4>
                                        <p class="text-base-content/70 text-sm leading-relaxed max-w-md mx-auto">
                                            Pilih gambar baru untuk menggantikan chapter saat ini 
                                            <span class="font-medium text-secondary">Tinggalkan saja jika tidak ingin mengganti.</span>
                                        </p>
                                        <div class="flex flex-wrap justify-center gap-2 text-xs text-base-content/60">
                                            <span class="badge badge-outline badge-sm">JPEG</span>
                                            <span class="badge badge-outline badge-sm">PNG</span>
                                            <span class="badge badge-outline badge-sm">JPG</span>
                                            <span class="badge badge-outline badge-sm">Max 2MB each</span>
                                        </div>
                                    </div>
                                    
                                    <button type="button" class="btn btn-secondary btn-lg gap-2 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300" id="editChooseImagesBtn">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Pilih
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Preview Area | update -->
                        <div id="editImagePreview" class="hidden mt-8 animate-fade-in">
                            <div class="flex items-center justify-between mb-6">
                                <h4 class="font-bold text-base text-secondary flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Preview gambar baru
                                </h4>
                                <button type="button" id="editClearImages" class="btn btn-sm btn-ghost text-error hover:bg-error/10 gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus semua
                                </button>
                            </div>
                            <div id="editPreviewContainer" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                                
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="card bg-base-100 shadow-sm border border-base-200">
                    <div class="card-body p-6">
                        <div class="flex flex-col sm:flex-row gap-4 justify-end">
                            <button type="button" 
                                    onclick="document.getElementById('editChapterModal').close()" 
                                    class="btn btn-ghost btn-lg gap-2 order-2 sm:order-1 hover:bg-base-200 transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Batal
                            </button>
                            <button type="submit" 
                                    class="btn btn-secondary btn-lg gap-2 order-1 sm:order-2 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300"
                                    id="editSubmitBtn">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Update Chapter
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</dialog>

<!-- Delete Chapter -->
<dialog id="deleteChapterModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-xl mb-4 text-error">Hapus Chapter</h3>
        <p class="py-4 text-lg">Apa anda yakin ingin menghapus <span id="deleteChapterInfo" class="font-semibold text-error"></span>?</p>
        <p class="text-sm text-base-content/60 mb-6">Chapter yang telah dihapus tidak dapat dikembalikan.</p>
        
        <div class="modal-action">
            <form method="dialog">
                <button class="btn btn-ghost btn-lg">Batal</button>
            </form>
            <form id="deleteChapterForm" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-error btn-lg gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus Chapter
                </button>
            </form>
        </div>
    </div>
</dialog>

<script>
    let selectedFiles = [];
    
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
        }, 600);
    }

    function updateImagePreview() {
        const fileInput = document.getElementById('chapterImages');
        const imagePreview = document.getElementById('imagePreview');
        const previewContainer = document.getElementById('previewContainer');
        
        if (!fileInput || !imagePreview || !previewContainer) {
            console.log('Elements not found:', { fileInput, imagePreview, previewContainer });
            return;
        }
        
        const files = fileInput.files;
        
        if (files.length === 0) {
            imagePreview.classList.add('hidden');
            previewContainer.innerHTML = '';
            return;
        }

        imagePreview.classList.remove('hidden');
        previewContainer.innerHTML = '';

        const filePreviews = Array.from(files).map((file, index) => {
            const previewItem = document.createElement('div');
            previewItem.className = 'relative group';
            previewItem.innerHTML = `
                <div class="aspect-[3/4] bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                    <div class="loading loading-spinner loading-sm"></div>
                </div>
                <div class="absolute bottom-2 left-2 badge badge-secondary badge-sm">
                    Page ${index + 1}
                </div>
            `;
            previewContainer.appendChild(previewItem);
            return { element: previewItem, index };
        });

        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewItem = filePreviews[index].element;
                previewItem.innerHTML = `
                    <div class="aspect-[3/4] bg-gray-100 rounded-lg overflow-hidden">
                        <img src="${e.target.result}" 
                            alt="Page ${index + 1}" 
                            class="w-full h-full object-cover">
                    </div>
                    <button type="button" 
                            class="absolute top-2 right-2 btn btn-circle btn-sm btn-error opacity-0 group-hover:opacity-100 transition-opacity"
                            onclick="removeImage(${index})">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <div class="absolute bottom-2 left-2 badge badge-secondary badge-sm">
                        Page ${index + 1}
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        });
    }

    function removeImage(index) {
        const fileInput = document.getElementById('chapterImages');
        if (!fileInput) return;
        
        const files = Array.from(fileInput.files);
        files.splice(index, 1);
        
        const dt = new DataTransfer();
        files.forEach(file => dt.items.add(file));
        fileInput.files = dt.files;
        
        updateImagePreview();
        showToast('Gambar dihapus', 'info');
    }

    function openAddChapterModal() {
        const modal = document.getElementById('addChapterModal');
        if (modal) {
            modal.showModal();
        }
        
        // Reset form
        const form = document.getElementById('addChapterForm');
        if (form) {
            form.reset();
        }
        
        // Clear image
        const fileInput = document.getElementById('chapterImages');
        if (fileInput) {
            fileInput.value = '';
        }
        
        updateImagePreview();
        
        const nextChapter = {{ ($chapters->max('chapter') ?? 0) + 1 }};
        const chapterInput = document.querySelector('input[name="chapter"]');
        if (chapterInput) {
            chapterInput.value = nextChapter;
        }
    }

    // search function
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchChapter');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const chapterCards = document.querySelectorAll('.chapter-card');
                let visibleCount = 0;
                
                chapterCards.forEach((card, index) => {
                    const chapterText = card.textContent.toLowerCase();
                    if (chapterText.includes(searchTerm)) {
                        card.style.display = 'block';
                        card.style.animationDelay = `${visibleCount * 0.1}s`;
                        card.style.animation = 'fadeIn 0.5s ease-out forwards';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }
    });

    // notification
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        const typeClasses = {
            success: 'alert-success',
            error: 'alert-error', 
            warning: 'alert-warning',
            info: 'alert-info'
        };
        
        toast.className = `alert ${typeClasses[type]} fixed top-4 right-4 z-50 w-auto max-w-sm shadow-lg`;
        toast.innerHTML = `
            <div class="flex items-center gap-2">
                <span>${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="btn btn-ghost btn-xs">✕</button>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            if (toast.parentElement) {
                toast.remove();
            }
        }, 5000);
    }

    // synopsis
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('toggleSinopsis');
        const sinopsisText = document.getElementById('sinopsisText');

        if (toggleBtn && sinopsisText) {
            toggleBtn.addEventListener('click', function () {
                sinopsisText.classList.toggle('line-clamp-4');
                toggleBtn.textContent = sinopsisText.classList.contains('line-clamp-4')
                    ? 'Show More'
                    : 'Show Less';
            });
        }
    });

    function validateFile(file) {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        const maxSize = 2 * 1024 * 1024; 
        
        if (!allowedTypes.includes(file.type)) {
            showToast(`File ${file.name} bukan format yang didukung. Gunakan JPEG, PNG, atau JPG.`, 'error');
            return false;
        }
        
        if (file.size > maxSize) {
            showToast(`File ${file.name} terlalu besar (${(file.size / 1024 / 1024).toFixed(2)}MB). Maksimal 2MB.`, 'error');
            return false;
        }
        
        return true;
    }

    function handleFileSelection(files) {
        console.log('Files selected:', files.length);
        
        if (!files || files.length === 0) {
            console.log('No files provided');
            return;
        }
        
        const validFiles = Array.from(files).filter(file => {
            const isImage = file.type.startsWith('image/');
            const isValidSize = file.size <= 2 * 1024 * 1024; // 2MB
            const isValidType = ['image/jpeg', 'image/png', 'image/jpg'].includes(file.type);
            
            if (!isImage || !isValidType) {
                showToast(`File ${file.name} bukan gambar yang valid. Gunakan JPEG, PNG, atau JPG.`, 'error');
                return false;
            }
            
            if (!isValidSize) {
                showToast(`File ${file.name} terlalu besar. Maksimal 2MB.`, 'error');
                return false;
            }
            
            return true;
        });

        if (validFiles.length > 0) {
            const fileInput = document.getElementById('chapterImages');
            if (fileInput) {
                const dt = new DataTransfer();
                validFiles.forEach(file => dt.items.add(file));
                fileInput.files = dt.files;
                
                updateImagePreview();
                showToast(`${validFiles.length} gambar berhasil dipilih!`, 'success');
            } else {
                console.error('File input element not found');
            }
        } else {
            const fileInput = document.getElementById('chapterImages');
            if (fileInput) {
                fileInput.value = '';
                updateImagePreview();
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing...');
        
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('chapterImages');
        const clearImagesBtn = document.getElementById('clearImages');
        const form = document.getElementById('addChapterForm');
        const chooseImagesBtn = document.getElementById('chooseImagesBtn');

        console.log('Elements found:', {
            uploadArea: !!uploadArea,
            fileInput: !!fileInput,
            clearImagesBtn: !!clearImagesBtn,
            form: !!form,
            chooseImagesBtn: !!chooseImagesBtn
        });

        if (chooseImagesBtn && fileInput) {
            chooseImagesBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Choose Images button clicked');
                fileInput.click();
            });
        }

        if (uploadArea && fileInput) {
            uploadArea.addEventListener('click', function(e) {
                if (e.target !== chooseImagesBtn && !e.target.closest('button')) {
                    e.preventDefault();
                    console.log('Upload area clicked');
                    fileInput.click();
                }
            });
        }

        // Drag and drop 
        if (uploadArea) {
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                uploadArea.classList.add('border-secondary', 'bg-secondary/5');
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                uploadArea.classList.remove('border-secondary', 'bg-secondary/5');
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                uploadArea.classList.remove('border-secondary', 'bg-secondary/5');
                
                const files = Array.from(e.dataTransfer.files);
                console.log('Files dropped:', files.length);
                handleFileSelection(files);
            });
        }

        // File input handler
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                console.log('File input changed');
                const files = Array.from(e.target.files);
                console.log('Files from input:', files.length);
                
                if (files.length > 0) {
                    const validFiles = files.filter(validateFile);
                    if (validFiles.length !== files.length) {
                        const dt = new DataTransfer();
                        validFiles.forEach(file => dt.items.add(file));
                        fileInput.files = dt.files;
                    }
                    updateImagePreview();
                    if (validFiles.length > 0) {
                        showToast(`${validFiles.length} gambar berhasil dipilih!`, 'success');
                    }
                } else {
                    updateImagePreview();
                }
            });
        }

        // Clear images handler
        if (clearImagesBtn && fileInput) {
            clearImagesBtn.addEventListener('click', function() {
                console.log('Clearing images');
                fileInput.value = '';
                updateImagePreview();
                showToast('Semua gambar dihapus', 'info');
            });
        }

        // Form submission handler
        form?.addEventListener('submit', function(e) {
            console.log('Form submitting...');
            
            const fileInput = document.getElementById('chapterImages');
            console.log('Files count:', fileInput?.files.length || 0);
            
            if (!fileInput || fileInput.files.length === 0) {
                e.preventDefault();
                showToast('Pilih minimal 1 gambar untuk chapter!', 'error');
                return false;
            }

            const chapterNumber = form.querySelector('input[name="chapter"]')?.value;
            const chapterTitle = form.querySelector('input[name="title"]')?.value;
            
            if (!chapterNumber || !chapterTitle) {
                e.preventDefault();
                showToast('Harap lengkapi semua field yang required!', 'error');
                return false;
            }

            if (parseInt(chapterNumber) < 1) {
                e.preventDefault();
                showToast('Nomor chapter harus lebih dari 0!', 'error');
                return false;
            }

            console.log('Form validation passed');
            console.log('Chapter:', chapterNumber);
            console.log('Title:', chapterTitle);
            console.log('Files:', Array.from(fileInput.files).map(f => f.name));

            const submitBtn = document.getElementById('submitBtn');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <div class="loading loading-spinner loading-sm"></div>
                    Creating Chapter...
                `;
            }

            return true;
        });
    });

    // View chapter
    function viewChapter(chapterId) {
        const loadingOverlay = document.createElement('div');
        loadingOverlay.innerHTML = `
            <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" id="viewLoadingOverlay">
                <div class="bg-base-100 rounded-lg p-6 flex items-center gap-3 shadow-xl">
                    <div class="loading loading-spinner loading-md"></div>
                    <span class="text-sm font-medium">Loading Chapter...</span>
                </div>
            </div>
        `;
        document.body.appendChild(loadingOverlay);

        setTimeout(() => {
            window.location.href = `/admin/komiks/{{ $komik->id }}/chapters/${chapterId}/view`;
        }, 500);
    }

function editChapter(komikId, chapterId) {
    console.log('Edit chapter:', komikId, chapterId);
    
    const modal = document.getElementById('editChapterModal');
    const form = document.getElementById('editChapterForm');
    
    if (!modal || !form) {
        console.error('Modal atau form tidak ditemukan');
        return;
    }

    form.action = `/admin/komiks/${komikId}/chapters/${chapterId}`;
    
    modal.showModal();
    
    fetch(`/admin/komiks/${komikId}/chapters/${chapterId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const chapter = data.chapter;
            
            document.getElementById('editChapterNumber').value = chapter.chapter;
            document.getElementById('editChapterTitle').value = chapter.title;
            document.getElementById('editChapterSlug').value = chapter.slug;
            
            loadCurrentImages(chapter.images);
            
            const fileInput = document.getElementById('editChapterImages');
            if (fileInput) {
                fileInput.value = '';
                updateEditImagePreview();
            }
        })
        .catch(error => {
            console.error('Error loading chapter:', error);
            showToast('Error loading chapter data', 'error');
            modal.close();
        });
}

function loadCurrentImages(images) {
    const container = document.getElementById('currentImagesContainer');
    if (!container) return;
    
    container.innerHTML = '';
    
    if (!images || images.length === 0) {
        container.innerHTML = `
            <div class="col-span-full text-center py-8">
                <p class="text-base-content/60">No images found</p>
            </div>
        `;
        return;
    }
    
    images.forEach((image, index) => {
        const imageDiv = document.createElement('div');
        imageDiv.className = 'relative group';
        imageDiv.innerHTML = `
            <div class="aspect-[3/4] bg-gray-100 rounded-lg overflow-hidden">
                <img src="${image.image_path}" 
                    alt="Page ${image.page_number}" 
                    class="w-full h-full object-cover">
            </div>
            <div class="absolute bottom-2 left-2 badge badge-secondary badge-sm">
                Page ${image.page_number}
            </div>
        `;
        container.appendChild(imageDiv);
    });
}

function updateEditImagePreview() {
    const fileInput = document.getElementById('editChapterImages');
    const imagePreview = document.getElementById('editImagePreview');
    const previewContainer = document.getElementById('editPreviewContainer');
    
    if (!fileInput || !imagePreview || !previewContainer) {
        return;
    }
    
    const files = fileInput.files;
    
    if (files.length === 0) {
        imagePreview.classList.add('hidden');
        previewContainer.innerHTML = '';
        return;
    }

    imagePreview.classList.remove('hidden');
    previewContainer.innerHTML = '';

    const filePreviews = Array.from(files).map((file, index) => {
        const previewItem = document.createElement('div');
        previewItem.className = 'relative group';
        previewItem.innerHTML = `
            <div class="aspect-[3/4] bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                <div class="loading loading-spinner loading-sm"></div>
            </div>
            <div class="absolute bottom-2 left-2 badge badge-secondary badge-sm">
                Page ${index + 1}
            </div>
        `;
        previewContainer.appendChild(previewItem);
        return { element: previewItem, index };
    });

    Array.from(files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewItem = filePreviews[index].element;
            previewItem.innerHTML = `
                <div class="aspect-[3/4] bg-gray-100 rounded-lg overflow-hidden">
                    <img src="${e.target.result}" 
                        alt="Page ${index + 1}" 
                        class="w-full h-full object-cover">
                </div>
                <button type="button" 
                        class="absolute top-2 right-2 btn btn-circle btn-sm btn-error opacity-0 group-hover:opacity-100 transition-opacity"
                        onclick="removeEditImage(${index})">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div class="absolute bottom-2 left-2 badge badge-secondary badge-sm">
                    Page ${index + 1}
                </div>
            `;
        };
        reader.readAsDataURL(file);
    });
}

function removeEditImage(index) {
    const fileInput = document.getElementById('editChapterImages');
    if (!fileInput) return;
    
    const files = Array.from(fileInput.files);
    files.splice(index, 1);
    
    const dt = new DataTransfer();
    files.forEach(file => dt.items.add(file));
    fileInput.files = dt.files;
    
    updateEditImagePreview();
    showToast('Gambar dihapus', 'info');
}

document.addEventListener('DOMContentLoaded', function() {
    // ... existing code ...
    
    // Edit chapter form handlers
    const editUploadArea = document.getElementById('editUploadArea');
    const editFileInput = document.getElementById('editChapterImages');
    const editChooseImagesBtn = document.getElementById('editChooseImagesBtn');
    const editClearImagesBtn = document.getElementById('editClearImages');
    const editForm = document.getElementById('editChapterForm');

    if (editChooseImagesBtn && editFileInput) {
        editChooseImagesBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            editFileInput.click();
        });
    }

    if (editUploadArea && editFileInput) {
        editUploadArea.addEventListener('click', function(e) {
            if (e.target !== editChooseImagesBtn && !e.target.closest('button')) {
                e.preventDefault();
                editFileInput.click();
            }
        });
    }

    // Drag and drop edit
    if (editUploadArea) {
        editUploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            editUploadArea.classList.add('border-secondary', 'bg-secondary/5');
        });

        editUploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            editUploadArea.classList.remove('border-secondary', 'bg-secondary/5');
        });

        editUploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            editUploadArea.classList.remove('border-secondary', 'bg-secondary/5');
            
            const files = Array.from(e.dataTransfer.files);
            handleEditFileSelection(files);
        });
    }

    // File input change handler untuk edit
    if (editFileInput) {
        editFileInput.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            
            if (files.length > 0) {
                const validFiles = files.filter(validateFile);
                if (validFiles.length !== files.length) {
                    const dt = new DataTransfer();
                    validFiles.forEach(file => dt.items.add(file));
                    editFileInput.files = dt.files;
                }
                updateEditImagePreview();
                if (validFiles.length > 0) {
                    showToast(`${validFiles.length} gambar baru dipilih!`, 'success');
                }
            } else {
                updateEditImagePreview();
            }
        });
    }

    // Clear images handler untuk edit
    if (editClearImagesBtn && editFileInput) {
        editClearImagesBtn.addEventListener('click', function() {
            editFileInput.value = '';
            updateEditImagePreview();
            showToast('Gambar baru dihapus', 'info');
        });
    }

    const editTitleInput = document.getElementById('editChapterTitle');
    const editChapterNumberInput = document.getElementById('editChapterNumber');
    const editSlugInput = document.getElementById('editChapterSlug');
    
    if (editTitleInput && editChapterNumberInput && editSlugInput) {
        function updateEditSlug() {
            const chapter = editChapterNumberInput.value;
            const title = editTitleInput.value;
            if (chapter && title) {
                const slug = `ch-${chapter}-${title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '')}`;
                editSlugInput.value = slug;
            }
        }
        
        editTitleInput.addEventListener('input', updateEditSlug);
        editChapterNumberInput.addEventListener('input', updateEditSlug);
    }

    // Edit form submission handler
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            const chapterNumber = editForm.querySelector('input[name="chapter"]')?.value;
            const chapterTitle = editForm.querySelector('input[name="title"]')?.value;
            const chapterSlug = editForm.querySelector('input[name="slug"]')?.value;
            
            if (!chapterNumber || !chapterTitle || !chapterSlug) {
                e.preventDefault();
                showToast('Harap lengkapi semua field yang required!', 'error');
                return false;
            }

            if (parseInt(chapterNumber) < 1) {
                e.preventDefault();
                showToast('Nomor chapter harus lebih dari 0!', 'error');
                return false;
            }

            const editSubmitBtn = document.getElementById('editSubmitBtn');
            if (editSubmitBtn) {
                editSubmitBtn.disabled = true;
                editSubmitBtn.innerHTML = `
                    <div class="loading loading-spinner loading-sm"></div>
                    Updating Chapter...
                `;
            }

            return true;
        });
    }
});

    function handleEditFileSelection(files) {
        if (!files || files.length === 0) {
            return;
        }
        
        const validFiles = Array.from(files).filter(validateFile);

        if (validFiles.length > 0) {
            const fileInput = document.getElementById('editChapterImages');
            if (fileInput) {
                const dt = new DataTransfer();
                validFiles.forEach(file => dt.items.add(file));
                fileInput.files = dt.files;
                
                updateEditImagePreview();
                showToast(`${validFiles.length} gambar baru dipilih!`, 'success');
            }
        } else {
            const fileInput = document.getElementById('editChapterImages');
            if (fileInput) {
                fileInput.value = '';
                updateEditImagePreview();
            }
        }
    }

    function deleteChapter(komikId, chapterId, chapterNumber, chapterTitle) {
        const deleteChapterInfo = document.getElementById('deleteChapterInfo');
        const deleteChapterForm = document.getElementById('deleteChapterForm');
        
        if (deleteChapterInfo) {
            deleteChapterInfo.textContent = `Chapter ${chapterNumber}: ${chapterTitle}`;
        }
        
        if (deleteChapterForm) {
            
            deleteChapterForm.action = `/admin/komiks/${komikId}/chapters/${chapterId}`;
        }
        
        const modal = document.getElementById('deleteChapterModal');
        if (modal) modal.showModal();
    }

    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) {
            alert.style.transition = 'all 0.5s ease-out';
            alert.style.transform = 'translateY(-20px)';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    }, 5000);
</script>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slide-up {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in {
        animation: fade-in 0.5s ease-out;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-4 {
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .chapters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 2rem;
        animation: slide-up 0.8s ease-out;
    }

    @media (max-width: 640px) {
        .chapters-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 1rem;
        }
    }

    @media (min-width: 1024px) {
        .chapters-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    .chapter-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        animation: slide-up 0.6s ease-out;
        animation-fill-mode: both;
    }

    .chapter-card:hover {
        transform: translateY(-8px) scale(1.02);
    }

    .chapter-card:nth-child(1) { animation-delay: 0.1s; }
    .chapter-card:nth-child(2) { animation-delay: 0.2s; }
    .chapter-card:nth-child(3) { animation-delay: 0.3s; }
    .chapter-card:nth-child(4) { animation-delay: 0.4s; }
    .chapter-card:nth-child(5) { animation-delay: 0.5s; }
    .chapter-card:nth-child(6) { animation-delay: 0.6s; }


    .backdrop-blur {
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    .modal-box {
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
        scrool-behavior: smooth;
    }

    .modal-box::-webkit-scrollbar {
        width: 6px;
    }

    .modal-box::-webkit-scrollbar-track {
        background: transparent;
    }

    .modal-box::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }

    .modal-box::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }

    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .btn-outline:hover {
        transform: translateY(-2px);
    }

    * {
        transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }

    /* Loading animation */
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .loading-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @media (max-width: 480px) {
        .chapters-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
        
        .chapter-card .p-4 {
            padding: 0.75rem;
        }
    }

    .btn:focus-visible,
    .input:focus-visible {
        outline: 2px solid currentColor;
        outline-offset: 2px;
    }

    .badge {
        transition: all 0.2s ease;
    }

    .badge:hover {
        transform: scale(1.05);
    }

    img {
        transition: opacity 0.3s ease;
    }

    img[loading="lazy"] {
        opacity: 0;
    }

    img[loading="lazy"].loaded {
        opacity: 1;
    }
</style>

<script>

    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('img[loading="lazy"]');
        images.forEach(img => {
            img.addEventListener('load', function() {
                this.classList.add('loaded');
            });
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.chapter-card').forEach(card => {
            observer.observe(card);
        });
    });
</script>
@endsection