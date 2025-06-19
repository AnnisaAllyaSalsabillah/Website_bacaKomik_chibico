@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-base-200">
    <!-- Hero Section with Blurred Background -->
    <div class="relative overflow-hidden">
        <!-- Blurred Background Image -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-black/80">
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat blur-sm scale-110 opacity-30"
                 style="background-image: url('{{ $komik->cover_image ?? '/images/no-cover.png' }}');">
            </div>
        </div>
        
        <!-- Content Overlay -->
        <div class="relative z-10 container mx-auto px-4 py-8">
            <!-- Breadcrumb -->
            <div class="breadcrumbs text-sm mb-6">
                <ul class="text-white/80">
                    <li>
                        <button onclick="backToComics()" class="text-white hover:text-primary transition-colors duration-200 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                            </svg>
                            Kembali ke Komik
                        </button>
                    </li>
                    <li class="text-white/60">{{ $komik->title }}</li>
                </ul>
            </div>

            <!-- Comic Info Section -->
            <div class="flex flex-col lg:flex-row gap-8 items-start">
                <!-- Comic Cover -->
                <div class="relative">
                    <div class="w-48 h-64 sm:w-56 sm:h-72 rounded-xl shadow-2xl overflow-hidden border-4 border-white/20">
                        <img src="{{ $komik->cover_image ?? '/images/no-cover.png' }}" 
                             alt="{{ $komik->title }}" 
                             class="w-full h-full object-cover" />
                    </div>
                    
                    <!-- Status Badge -->
                    <div class="absolute -top-2 -right-2">
                        <div class="badge badge-{{ $komik->status === 'ongoing' ? 'success' : 'info' }} badge-lg shadow-lg">
                            {{ ucfirst($komik->status) }}
                        </div>
                    </div>
                </div>

                <!-- Comic Details -->
                <div class="flex-1 text-white min-w-0">
                    <!-- Title -->
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4 leading-tight">
                        {{ $komik->title }}
                    </h1>
                    
                    <!-- Subtitle/Alternative Title -->
                    @if($komik->alternative)
                    <p class="text-lg text-white/80 mb-4 font-medium">{{ $komik->alternative }}</p>
                    @endif
                    
                    <!-- Meta Information Grid -->
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
                        
                        <!-- Release Year -->
                        @if($komik->release_year)
                        <div class="flex flex-col">
                            <span class="text-white/60 text-sm uppercase tracking-wide font-semibold">Released</span>
                            <span class="text-white font-medium">{{ $komik->release_year }}</span>
                        </div>
                        @endif
                        
                        <!-- Rating -->
                        @if($komik->rating)
                        <div class="flex flex-col">
                            <span class="text-white/60 text-sm uppercase tracking-wide font-semibold">Rank</span>
                            <div class="flex items-center gap-1">
                                <span class="text-white font-medium">{{ number_format($komik->rank, 1) }}</span>
                                <div class="rating rating-sm">
                                    @for($i = 1; $i <= 5; $i++)
                                    <input type="radio" class="mask mask-star-2 bg-orange-400" disabled {{ $i <= round($komik->rank) ? 'checked' : '' }} />
                                    @endfor
                                </div>
                            </div>
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
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-3">
                        <button onclick="openAddChapterModal()" 
                               class="btn btn-primary btn-lg shadow-xl hover:shadow-2xl transition-all duration-300 gap-2 bg-white text-primary hover:bg-white/90">
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
        <!-- Success Alert -->
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
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-base-content mb-2">Chapters</h2>
                <p class="text-base-content/70">Manage all chapters for this comic</p>
            </div>
            
            <!-- Search Bar -->
            <div class="relative max-w-sm w-full sm:w-auto">
                <input type="text" 
                       placeholder="Search chapters..." 
                       class="input input-bordered w-full pl-10 pr-4 shadow-md focus:ring-2 focus:ring-primary transition-all"
                       id="searchChapter">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-base-content/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        <!-- Chapters Grid -->
        <div class="chapters-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @if($chapters->count() > 0)
                @foreach($chapters->sortBy('chapter') as $chapter)
                <div class="chapter-card bg-base-100 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 border border-base-300 group">
                    <!-- Chapter Thumbnail -->
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
                        
                        <!-- Chapter Number Badge -->
                        <div class="absolute top-3 left-3">
                            <div class="badge badge-primary badge-lg font-bold shadow-lg">
                                Ch. {{ $chapter->chapter }}
                            </div>
                        </div>
                        
                        <!-- Action Buttons Overlay -->
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
                                class="btn btn-circle btn-lg btn-warning shadow-xl transform hover:scale-110 transition-all"
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
                            <h3 class="font-bold text-lg text-primary flex-1 min-w-0">
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
                            <h3 class="text-2xl font-bold mb-3">No Chapters Yet</h3>
                            <p class="text-base-content/60 mb-8 text-lg">Start building your comic by adding the first chapter!</p>
                            <div class="flex justify-center">
                                <button onclick="openAddChapterModal()" 
                                        class="btn btn-primary gap-2 px-6 py-2 shadow-lg hover:shadow-xl transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Add Chapter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Chapter Modal -->
<dialog id="addChapterModal" class="modal">
    <div class="modal-box w-11/12 max-w-4xl max-h-[90vh] p-0 overflow-hidden">
        <!-- Modal Header -->
        <div class="sticky top-0 z-10 bg-gradient-to-r from-primary to-secondary text-white p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white/20 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold">Add New Chapter</h2>
                        <p class="text-white/80 text-sm">Create a new chapter for {{ $komik->title }}</p>
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

        <!-- Modal Body -->
        <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
            <form action="{{ route('admin.chapters.store', $komik->id) }}" method="POST" enctype="multipart/form-data" id="addChapterForm">
                @csrf
                
                <!-- Chapter Info Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-base">Chapter Number</span>
                            <span class="label-text-alt text-xs text-error">*Required</span>
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
                            <span class="label-text font-semibold text-base">Chapter Title</span>
                            <span class="label-text-alt text-xs text-error">*Required</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               class="input input-bordered input-lg focus:ring-2 focus:ring-primary transition-all" 
                               placeholder="Enter chapter title" 
                               required>
                        <label class="label">
                            <span class="label-text-alt text-xs text-base-content/60">Descriptive title for this chapter</span>
                        </label>
                    </div>
                </div>

                <!-- Images Upload Section -->
                <div class="form-control mb-8">
                    <label class="label">
                        <span class="label-text font-semibold text-base">Chapter Images</span>
                        <span class="label-text-alt text-xs text-error">*Required</span>
                    </label>
                    
                    <!-- Custom Upload Area -->
                    <div class="relative">
                        <input type="file" 
                               name="images[]" 
                               multiple 
                               accept="image/jpeg,image/png,image/jpg"
                               class="hidden" 
                               id="chapterImages"
                               required>
                        
                        <div id="uploadArea" class="border-2 border-dashed border-base-300 hover:border-primary transition-all duration-300 rounded-xl p-8 text-center cursor-pointer group">
                            <div class="space-y-4">
                                <div class="mx-auto w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center group-hover:bg-primary/20 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-lg font-semibold text-base-content mb-2">Drop your images here or click to browse</p>
                                    <p class="text-sm text-base-content/60">Support: JPEG, PNG, JPG • Max size: 2MB each</p>
                                </div>
                                <button type="button" class="btn btn-primary btn-outline" id="chooseImagesBtn">
                                    Choose Images
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Preview Area -->
                    <div id="imagePreview" class="hidden mt-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-semibold text-base">Selected Images</h4>
                            <button type="button" id="clearImages" class="btn btn-sm btn-ghost text-error">
                                Clear All
                            </button>
                        </div>
                        <div id="previewContainer" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            <!-- Preview items will be inserted here -->
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-base-200">
                    <button type="button" 
                            onclick="document.getElementById('addChapterModal').close()" 
                            class="btn btn-ghost btn-lg order-2 sm:order-1">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="btn btn-primary btn-lg gap-2 order-1 sm:order-2 sm:ml-auto"
                            id="submitBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Create Chapter
                    </button>
                </div>
            </form>
        </div>
    </div>
</dialog>

<!-- View Chapter Modal -->
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

<!-- Edit Chapter Modal -->
<dialog id="editChapterModal" class="modal">
    <div class="modal-box w-11/12 max-w-4xl max-h-[90vh] p-0 overflow-hidden">
        <!-- Modal Header -->
        <div class="sticky top-0 z-10 bg-gradient-to-r from-warning to-orange-500 text-white p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white/20 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold">Edit Chapter</h2>
                        <p class="text-white/80 text-sm">Update chapter information and images</p>
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

        <!-- Modal Body -->
        <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
            <form id="editChapterForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Chapter Info Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-base">Chapter Number</span>
                            <span class="label-text-alt text-xs text-error">*Required</span>
                        </label>
                        <input type="number" 
                            name="chapter" 
                            id="editChapterNumber"
                            class="input input-bordered input-lg focus:ring-2 focus:ring-warning transition-all" 
                            placeholder="Enter chapter number" 
                            min="1"
                            required>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-base">Chapter Title</span>
                            <span class="label-text-alt text-xs text-error">*Required</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               id="editChapterTitle"
                               class="input input-bordered input-lg focus:ring-2 focus:ring-warning transition-all" 
                               placeholder="Enter chapter title" 
                               required>
                    </div>
                </div>

                <!-- Slug Field -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold text-base">Chapter Slug</span>
                        <span class="label-text-alt text-xs text-base-content/60">Auto-generated</span>
                    </label>
                    <input type="text" 
                           name="slug" 
                           id="editChapterSlug"
                           class="input input-bordered input-lg focus:ring-2 focus:ring-warning transition-all" 
                           placeholder="chapter-slug" 
                           required>
                </div>

                <!-- Current Images Display -->
                <div class="mb-8">
                    <h4 class="font-semibold text-base mb-4">Current Images</h4>
                    <div id="currentImagesContainer" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-6">
                        <!-- Current images will be loaded here -->
                    </div>
                </div>

                <!-- New Images Upload Section -->
                <div class="form-control mb-8">
                    <label class="label">
                        <span class="label-text font-semibold text-base">Replace All Images</span>
                        <span class="label-text-alt text-xs text-base-content/60">Optional - Leave empty to keep current images</span>
                    </label>
                    
                    <!-- Custom Upload Area -->
                    <div class="relative">
                        <input type="file" 
                               name="images[]" 
                               multiple 
                               accept="image/jpeg,image/png,image/jpg"
                               class="hidden" 
                               id="editChapterImages">
                        
                        <div id="editUploadArea" class="border-2 border-dashed border-base-300 hover:border-warning transition-all duration-300 rounded-xl p-8 text-center cursor-pointer group">
                            <div class="space-y-4">
                                <div class="mx-auto w-16 h-16 bg-warning/10 rounded-full flex items-center justify-center group-hover:bg-warning/20 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-warning" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-lg font-semibold text-base-content mb-2">Upload new images to replace all current images</p>
                                    <p class="text-sm text-base-content/60">Support: JPEG, PNG, JPG • Max size: 2MB each</p>
                                </div>
                                <button type="button" class="btn btn-warning btn-outline" id="editChooseImagesBtn">
                                    Choose New Images
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Preview Area for New Images -->
                    <div id="editImagePreview" class="hidden mt-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-semibold text-base">New Images Preview</h4>
                            <button type="button" id="editClearImages" class="btn btn-sm btn-ghost text-error">
                                Clear All
                            </button>
                        </div>
                        <div id="editPreviewContainer" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            <!-- Preview items will be inserted here -->
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-base-200">
                    <button type="button" 
                            onclick="document.getElementById('editChapterModal').close()" 
                            class="btn btn-ghost btn-lg order-2 sm:order-1">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="btn btn-warning btn-lg gap-2 order-1 sm:order-2 sm:ml-auto"
                            id="editSubmitBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Update Chapter
                    </button>
                </div>
            </form>
        </div>
    </div>
</dialog>

<!-- Delete Chapter Modal -->
<dialog id="deleteChapterModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-xl mb-4 text-error">Delete Chapter</h3>
        <p class="py-4 text-lg">Are you sure you want to delete <span id="deleteChapterInfo" class="font-semibold text-error"></span>?</p>
        <p class="text-sm text-base-content/60 mb-6">This action cannot be undone and will permanently delete all chapter images.</p>
        
        <div class="modal-action">
            <form method="dialog">
                <button class="btn btn-ghost btn-lg">Cancel</button>
            </form>
            <form id="deleteChapterForm" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-error btn-lg gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete Chapter
                </button>
            </form>
        </div>
    </div>
</dialog>

<script>
    // Global variables
    let selectedFiles = [];
    
    // Smooth back navigation
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

    // Global function to update image preview
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

        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewItem = document.createElement('div');
                previewItem.className = 'relative group';
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
                    <div class="absolute bottom-2 left-2 badge badge-primary badge-sm">
                        Page ${index + 1}
                    </div>
                `;
                previewContainer.appendChild(previewItem);
            };
            reader.readAsDataURL(file);
        });
    }

    // Global function to remove image
    function removeImage(index) {
        const fileInput = document.getElementById('chapterImages');
        if (!fileInput) return;
        
        const files = Array.from(fileInput.files);
        files.splice(index, 1);
        
        // Create new FileList
        const dt = new DataTransfer();
        files.forEach(file => dt.items.add(file));
        fileInput.files = dt.files;
        
        updateImagePreview();
        showToast('Gambar dihapus', 'info');
    }

    // Open Add Chapter Modal
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
        
        // Clear file input and preview
        const fileInput = document.getElementById('chapterImages');
        if (fileInput) {
            fileInput.value = '';
        }
        
        updateImagePreview();
        
        // Set next chapter number
        const nextChapter = {{ ($chapters->max('chapter') ?? 0) + 1 }};
        const chapterInput = document.querySelector('input[name="chapter"]');
        if (chapterInput) {
            chapterInput.value = nextChapter;
        }
    }

    // Enhanced search functionality
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

    // Toast notification function
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

    // Toggle synopsis functionality
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


    // Improved file validation
    function validateFile(file) {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        const maxSize = 2 * 1024 * 1024; // 2MB sesuai dengan controller validation
        
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

    // Handle file selection with better validation
    function handleFileSelection(files) {
        console.log('Files selected:', files.length);
        
        if (!files || files.length === 0) {
            console.log('No files provided');
            return;
        }
        
        // Filter dan validasi file
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
                // Update file input dengan file yang valid
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

    // DOMContentLoaded event listener
    // GANTI SELURUH BAGIAN DOMContentLoaded INI
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

        // Handle click pada button "Choose Images"
        if (chooseImagesBtn && fileInput) {
            chooseImagesBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Choose Images button clicked');
                fileInput.click();
            });
        }

        // Upload area click handler (hanya untuk area selain button)
        if (uploadArea && fileInput) {
            uploadArea.addEventListener('click', function(e) {
                // Jika yang diklik bukan button, baru trigger file input
                if (e.target !== chooseImagesBtn && !e.target.closest('button')) {
                    e.preventDefault();
                    console.log('Upload area clicked');
                    fileInput.click();
                }
            });
        }

        // Drag and drop functionality
        if (uploadArea) {
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                uploadArea.classList.add('border-primary', 'bg-primary/5');
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                uploadArea.classList.remove('border-primary', 'bg-primary/5');
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                uploadArea.classList.remove('border-primary', 'bg-primary/5');
                
                const files = Array.from(e.dataTransfer.files);
                console.log('Files dropped:', files.length);
                handleFileSelection(files);
            });
        }

        // File input change handler
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

    // View chapter images with enhanced loading
    function viewChapter(chapterId) {
        // Show loading overlay
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

        // Navigate to chapter view page
        setTimeout(() => {
            window.location.href = `/admin/komiks/{{ $komik->id }}/chapters/${chapterId}/view`;
        }, 500);
    }

    // Global function untuk edit chapter
function editChapter(komikId, chapterId) {
    console.log('Edit chapter:', komikId, chapterId);
    
    const modal = document.getElementById('editChapterModal');
    const form = document.getElementById('editChapterForm');
    
    if (!modal || !form) {
        console.error('Modal atau form tidak ditemukan');
        return;
    }

    // Set form action URL
    form.action = `/admin/komiks/${komikId}/chapters/${chapterId}`;
    
    // Show modal dengan loading state
    modal.showModal();
    
    // Load chapter data dari endpoint yang benar
    fetch(`/admin/komiks/${komikId}/chapters/${chapterId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const chapter = data.chapter;
            
            // Populate form fields
            document.getElementById('editChapterNumber').value = chapter.chapter;
            document.getElementById('editChapterTitle').value = chapter.title;
            document.getElementById('editChapterSlug').value = chapter.slug;
            
            // Load current images
            loadCurrentImages(chapter.images);
            
            // Clear new image selection
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

// Function untuk load current images
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
            <div class="absolute bottom-2 left-2 badge badge-warning badge-sm">
                Page ${image.page_number}
            </div>
        `;
        container.appendChild(imageDiv);
    });
}

// Function untuk update preview edit images
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

    Array.from(files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewItem = document.createElement('div');
            previewItem.className = 'relative group';
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
                <div class="absolute bottom-2 left-2 badge badge-warning badge-sm">
                    Page ${index + 1}
                </div>
            `;
            previewContainer.appendChild(previewItem);
        };
        reader.readAsDataURL(file);
    });
}

// Function untuk remove edit image
function removeEditImage(index) {
    const fileInput = document.getElementById('editChapterImages');
    if (!fileInput) return;
    
    const files = Array.from(fileInput.files);
    files.splice(index, 1);
    
    // Create new FileList
    const dt = new DataTransfer();
    files.forEach(file => dt.items.add(file));
    fileInput.files = dt.files;
    
    updateEditImagePreview();
    showToast('Gambar dihapus', 'info');
}

// Event listeners untuk edit chapter (tambahkan ke DOMContentLoaded)
document.addEventListener('DOMContentLoaded', function() {
    // ... existing code ...
    
    // Edit chapter form handlers
    const editUploadArea = document.getElementById('editUploadArea');
    const editFileInput = document.getElementById('editChapterImages');
    const editChooseImagesBtn = document.getElementById('editChooseImagesBtn');
    const editClearImagesBtn = document.getElementById('editClearImages');
    const editForm = document.getElementById('editChapterForm');

    // Handle click pada button "Choose Images" untuk edit
    if (editChooseImagesBtn && editFileInput) {
        editChooseImagesBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            editFileInput.click();
        });
    }

    // Upload area click handler untuk edit
    if (editUploadArea && editFileInput) {
        editUploadArea.addEventListener('click', function(e) {
            if (e.target !== editChooseImagesBtn && !e.target.closest('button')) {
                e.preventDefault();
                editFileInput.click();
            }
        });
    }

    // Drag and drop untuk edit
    if (editUploadArea) {
        editUploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            editUploadArea.classList.add('border-warning', 'bg-warning/5');
        });

        editUploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            editUploadArea.classList.remove('border-warning', 'bg-warning/5');
        });

        editUploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            editUploadArea.classList.remove('border-warning', 'bg-warning/5');
            
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

    // Auto-generate slug ketika title berubah di edit form
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

    // Function untuk handle file selection di edit
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
            // Perbaikan route sesuai dengan parameter controller yang benar
            deleteChapterForm.action = `/admin/komiks/${komikId}/chapters/${chapterId}`;
        }
        
        const modal = document.getElementById('deleteChapterModal');
        if (modal) modal.showModal();
    }

    // Auto-hide success alerts with smooth animation
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
        animation: fade-in 0.6s ease-out;
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

    /* Hero section backdrop blur */
    .backdrop-blur {
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    /* Custom scrollbar for modal */
    .modal-box {
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
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

    /* Enhanced button hover effects */
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .btn-outline:hover {
        transform: translateY(-2px);
    }

    /* Smooth transitions for all interactive elements */
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

    /* Responsive text scaling */
    @media (max-width: 480px) {
        .chapters-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
        
        .chapter-card .p-4 {
            padding: 0.75rem;
        }
    }

    /* Enhanced focus states for accessibility */
    .btn:focus-visible,
    .input:focus-visible {
        outline: 2px solid currentColor;
        outline-offset: 2px;
    }

    /* Custom badge animations */
    .badge {
        transition: all 0.2s ease;
    }

    .badge:hover {
        transform: scale(1.05);
    }

    /* Smooth image loading */
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
    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        // Add loaded class to images when they finish loading
        const images = document.querySelectorAll('img[loading="lazy"]');
        images.forEach(img => {
            img.addEventListener('load', function() {
                this.classList.add('loaded');
            });
        });

        // Smooth reveal animation for chapter cards
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