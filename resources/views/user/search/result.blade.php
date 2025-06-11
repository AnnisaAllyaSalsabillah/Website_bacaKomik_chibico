{{-- resources/views/user/search/result.blade.php --}}
@extends('layouts.app')

@section('title', 'Hasil Pencarian: ' . $query)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-4">
                <i class="fas fa-search mr-2"></i>Pencarian Komik
            </h1>
        </div>

        <!-- Search Form -->
        <div class="max-w-2xl mx-auto mb-8">
            <form action="{{ route('search.result') }}" method="GET" class="relative">
                <div class="relative">
                    <input type="text" 
                           name="query" 
                           value="{{ $query }}"
                           placeholder="Cari berdasarkan judul, alternatif, author, atau artist..."
                           class="w-full px-6 py-4 pr-16 text-lg border-2 border-gray-200 rounded-full shadow-lg focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300"
                           required>
                    <button type="submit" 
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white px-6 py-2 rounded-full transition-all duration-300 shadow-lg hover:shadow-xl">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Search Results Header -->
        <div class="mb-6">
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-1">
                            Hasil pencarian untuk: <span class="text-blue-600">"{{ $query }}"</span>
                        </h2>
                        <p class="text-gray-600">
                            <i class="fas fa-list-ul mr-1"></i>
                            Ditemukan {{ $result->count() }} komik
                        </p>
                    </div>
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-clock mr-1"></i>
                        {{ now()->format('d M Y, H:i') }}
                    </div>
                </div>
            </div>
        </div>

        @if($result->count() > 0)
            <!-- Search Results Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($result as $comic)
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden group">
                    <!-- Comic Cover -->
                    <div class="relative overflow-hidden">
                        <img src="{{ $comic->cover_image ?? 'https://via.placeholder.com/300x400/4F46E5/FFFFFF?text=' . urlencode($comic->title) }}" 
                             alt="{{ $comic->title }}" 
                             class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-110">
                        
                        <!-- Overlay on Hover -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="absolute bottom-4 left-4 right-4">
                                <a href="{{ route('comic.show', $comic->id) }}" 
                                   class="w-full bg-white/90 hover:bg-white text-gray-800 font-medium py-2 px-4 rounded-lg text-center block transition-all duration-200 transform hover:scale-105">
                                    <i class="fas fa-book-open mr-2"></i>Baca Komik
                                </a>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        @if($comic->status)
                        <div class="absolute top-3 right-3">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                {{ $comic->status == 'ongoing' ? 'bg-green-500 text-white' : 
                                   ($comic->status == 'completed' ? 'bg-blue-500 text-white' : 'bg-gray-500 text-white') }}">
                                {{ ucfirst($comic->status) }}
                            </span>
                        </div>
                        @endif
                    </div>

                    <!-- Comic Info -->
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors duration-200">
                            {{ $comic->title }}
                        </h3>

                        @if($comic->alternative && $comic->alternative != $comic->title)
                        <p class="text-sm text-gray-500 mb-2 line-clamp-1">
                            <i class="fas fa-tag mr-1"></i>
                            {{ $comic->alternative }}
                        </p>
                        @endif

                        <div class="space-y-1 mb-3">
                            @if($comic->author)
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-user-edit mr-2 text-blue-500"></i>
                                <span class="font-medium">Author:</span> {{ $comic->author }}
                            </p>
                            @endif

                            @if($comic->artist && $comic->artist != $comic->author)
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-paint-brush mr-2 text-purple-500"></i>
                                <span class="font-medium">Artist:</span> {{ $comic->artist }}
                            </p>
                            @endif
                        </div>

                        @if($comic->description)
                        <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                            {{ $comic->description }}
                        </p>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                            <div class="flex items-center space-x-3 text-sm text-gray-500">
                                @if($comic->rank)
                                <div class="flex items-center">
                                    <i class="fas fa-star text-yellow-500 mr-1"></i>
                                    <span>{{ $comic->rank }}</span>
                                </div>
                                @endif

                                @if($comic->views)
                                <div class="flex items-center">
                                    <i class="fas fa-eye text-gray-400 mr-1"></i>
                                    <span>{{ number_format($comic->views) }}</span>
                                </div>
                                @endif
                            </div>

                            <a href="{{ route('comic.show', $comic->id) }}" 
                               class="text-blue-600 hover:text-blue-800 font-semibold text-sm hover:underline transition-colors duration-200">
                                Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Load More atau Pagination (jika ada) -->
            <div class="mt-12 text-center">
                <button class="bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white font-semibold py-3 px-8 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <i class="fas fa-plus-circle mr-2"></i>Muat Lebih Banyak
                </button>
            </div>

        @else
            <!-- No Results Found -->
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <!-- Illustration -->
                    <div class="w-32 h-32 mx-auto mb-6 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                        <i class="fas fa-search text-4xl text-gray-400"></i>
                    </div>
                    
                    <h3 class="text-2xl font-bold text-gray-600 mb-4">
                        Tidak Ada Hasil Ditemukan
                    </h3>
                    
                    <p class="text-gray-500 mb-6 leading-relaxed">
                        Maaf, kami tidak dapat menemukan komik yang sesuai dengan pencarian <strong>"{{ $query }}"</strong>. 
                        Coba gunakan kata kunci yang berbeda atau periksa ejaan Anda.
                    </p>

                    <!-- Search Suggestions -->
                    <div class="bg-blue-50 rounded-xl p-6 mb-6">
                        <h4 class="font-semibold text-gray-700 mb-3">
                            <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>Tips Pencarian:
                        </h4>
                        <ul class="text-sm text-gray-600 space-y-2 text-left">
                            <li>• Gunakan kata kunci yang lebih umum</li>
                            <li>• Periksa ejaan kata yang Anda masukkan</li>
                            <li>• Coba cari berdasarkan nama author atau artist</li>
                            <li>• Gunakan judul alternatif jika ada</li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('comics.index') }}" 
                           class="bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white font-semibold py-3 px-6 rounded-full shadow-lg hover:shadow-xl transition-all duration-300">
                            <i class="fas fa-home mr-2"></i>Lihat Semua Komik
                        </a>
                        
                        <button onclick="document.querySelector('input[name=query]').focus()" 
                                class="bg-white hover:bg-gray-50 text-gray-700 font-semibold py-3 px-6 rounded-full border-2 border-gray-200 hover:border-gray-300 transition-all duration-300">
                            <i class="fas fa-search mr-2"></i>Cari Lagi
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Back to Top Button -->
        <button id="backToTop" 
                class="fixed bottom-6 right-6 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white p-3 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 opacity-0 invisible"
                onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
            <i class="fas fa-arrow-up"></i>
        </button>
    </div>
</div>

<style>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
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

<script>
// Back to Top Button
window.addEventListener('scroll', function() {
    const backToTop = document.getElementById('backToTop');
    if (window.pageYOffset > 300) {
        backToTop.classList.remove('opacity-0', 'invisible');
        backToTop.classList.add('opacity-100', 'visible');
    } else {
        backToTop.classList.add('opacity-0', 'invisible');
        backToTop.classList.remove('opacity-100', 'visible');
    }
});

// Auto focus search input when page loads
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="query"]');
    if (searchInput && !searchInput.value) {
        setTimeout(() => searchInput.focus(), 500);
    }
});

// Highlight search terms in results
document.addEventListener('DOMContentLoaded', function() {
    const query = '{{ $query }}';
    const searchTerms = query.toLowerCase().split(' ');
    
    // Function to highlight text
    function highlightText(element, terms) {
        let html = element.innerHTML;
        terms.forEach(term => {
            if (term.length > 2) { // Only highlight terms longer than 2 characters
                const regex = new RegExp(`(${term})`, 'gi');
                html = html.replace(regex, '<mark class="bg-yellow-200 px-1 rounded">$1</mark>');
            }
        });
        element.innerHTML = html;
    }
    
    // Highlight in titles and descriptions
    document.querySelectorAll('.line-clamp-2, .line-clamp-3').forEach(element => {
        highlightText(element, searchTerms);
    });
});
</script>
@endsection