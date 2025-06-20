@extends('layouts.app')

@section('title', 'Cari Komik')

@section('content')
<div class="min-h-screen">
    <!-- Compact Header -->
    <div class="bg-gradient-to-r from-primary to-secondary py-6">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">
                Cari Komik? Gampang Banget!
            </h1>
            <p class="text-white/80 text-sm">
                Tinggal ketik, pilih, langsung baca. No ribet-ribet club!
            </p>
        </div>
    </div>

    <!-- Compact Search Form -->
    <div class="container mx-auto px-4 -mt-4 relative z-10 max-w-2xl">
        <div class="card shadow-lg">
            <div class="card-body p-4">
                <form action="{{ route('user.search.index') }}" method="GET">
                    <div class="join w-full">
                        <input 
                            type="text" 
                            name="query" 
                            value="{{ request('query') }}" 
                            placeholder="Ketik judul komik, author, artist..." 
                            class="input input-bordered join-item flex-1 focus:input-primary"
                            autocomplete="off"
                        >
                        <button type="submit" class="btn btn-primary join-item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </form>
                <!-- Search Tips -->
                    <div class="text-sm text-base-content/60 text-left">
                        <span class="badge badge-ghost mr-2">Tips:</span>
                        Pencarian berdasarkan <span class="font-semibold">judul</span>, 
                        <span class="font-semibold">nama alternatif</span>, 
                        <span class="font-semibold">author</span>, atau 
                        <span class="font-semibold">artist</span>
                    </div>
            </div>
        </div>
    </div>

    <!-- Results Section -->
    <div class="container mx-auto px-4 py-6">
        @if(isset($query) && $query)
            <!-- Results Header -->
            <div class="mb-4">
                <h2 class="text-lg font-semibold">
                    Hasil untuk: <span class="text-primary">"{{ $query }}"</span>
                </h2>
                @if(isset($result))
                    <p class="text-sm text-base-content/60">
                        {{ $result->count() }} komik ditemukan
                    </p>
                @endif
            </div>

            @if(isset($result) && $result->count() > 0)
                <!-- Compact Results Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">
                    @foreach($result as $comic)
                        <div class="card bg-base-100 shadow hover:shadow-md transition-shadow group">
                            <figure class="relative">
                                @if($comic->cover_image)
                                    <img 
                                        src="{{ $comic->cover_image }}" 
                                        alt="{{ $comic->title }}"
                                        class="w-full h-40 object-cover"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="w-full h-40 bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-base-content/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                @endif
                                
                                <div class="absolute top-1 right-1">
                                    <div class="badge badge-primary badge-xs">{{ $comic->status ?? 'Ongoing' }}</div>
                                </div>
                            </figure>
                            
                            <div class="card-body p-3">
                                <h3 class="font-semibold text-sm line-clamp-2 group-hover:text-primary transition-colors">
                                    {{ $comic->title }}
                                </h3>
                                
                                @if($comic->author)
                                    <p class="text-xs text-base-content/60 line-clamp-1">
                                        {{ $comic->author }}
                                    </p>
                                @endif
                                
                                <div class="card-actions justify-between items-center mt-2">
                                    @if($comic->genres)
                                        <div class="badge badge-outline badge-xs">
                                            {{ $comic->genres->first()->name ?? '' }}
                                        </div>
                                    @endif
                                    
                                    <a href="{{ route('user.komiks.show', $comic->slug) }}" 
                                       class="btn btn-primary btn-xs">
                                        Baca
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if(method_exists($result, 'links'))
                    <div class="mt-6 flex justify-center">
                        {{ $result->links() }}
                    </div>
                @endif
                
            @else
                <!-- No Results -->
                <div class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-base-content/30 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.137 0-4.146-.832-5.657-2.343m0 0L3.515 9.829A11.962 11.962 0 0112 3c2.137 0 4.146.832 5.657 2.343m0 0L20.485 9.829A11.962 11.962 0 0112 21c-2.137 0-4.146-.832-5.657-2.343" />
                    </svg>
                    <h3 class="text-lg font-semibold mb-1">Tidak ada hasil</h3>
                    <p class="text-sm text-base-content/60 mb-3">
                        Coba kata kunci yang berbeda
                    </p>
                    <div class="flex gap-2 justify-center flex-wrap">
                        <span class="badge badge-ghost badge-sm">Periksa ejaan</span>
                        <span class="badge badge-ghost badge-sm">Kata kunci umum</span>
                    </div>
                </div>
            @endif
        @else
            <!-- Welcome State -->
            <div class="text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-primary/30 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <h2 class="text-xl font-semibold mb-2">Cari Komik Favorit</h2>
                <p class="text-base-content/60 mb-4">
                    Ketik kata kunci di atas untuk memulai
                </p>
                
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .line-clamp-1 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
    }
    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus search input
    const searchInput = document.querySelector('input[name="query"]');
    if (searchInput && !searchInput.value) {
        searchInput.focus();
    }
});
</script>
@endpush