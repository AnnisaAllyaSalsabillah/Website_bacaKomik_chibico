@extends('layouts.app')

@section('title', $komik->title . ' - Chapter ' . $chapter->number)

@section('content')
<div class="min-h-screen bg-gray-900 text-white">
    <!-- Header Navigation -->
    <div class="sticky top-0 z-50 bg-gray-800 border-b border-gray-700 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Back to Comic -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('comic.show', $komik->slug) }}" 
                    class="inline-flex items-center text-gray-300 hover:text-white transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span class="hidden sm:inline">Back to Comic</span>
                    </a>
                    <div class="hidden md:block h-6 w-px bg-gray-600"></div>
                    <div class="hidden md:block">
                        <h1 class="text-lg font-semibold truncate max-w-xs lg:max-w-md">{{ $komik->title }}</h1>
                        <p class="text-sm text-gray-400">Chapter {{ $chapter->number }}</p>
                    </div>
                </div>

                <!-- Chapter Navigation -->
                <div class="flex items-center space-x-2">
                    @if($prevChapter)
                        <a href="{{ route('chapter.show', [$komik->slug, $prevChapter->number]) }}" 
                        class="inline-flex items-center px-3 py-2 bg-gray-700 hover:bg-gray-600 rounded-md transition-colors duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            <span class="hidden sm:inline">Prev</span>
                        </a>
                    @else
                        <span class="inline-flex items-center px-3 py-2 bg-gray-800 text-gray-500 rounded-md cursor-not-allowed">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            <span class="hidden sm:inline">Prev</span>
                        </span>
                    @endif

                    <!-- Chapter Selector -->
                    <div class="relative">
                        <select onchange="window.location.href=this.value" 
                                class="appearance-none bg-gray-700 border border-gray-600 text-white px-4 py-2 pr-8 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @for($i = 1; $i <= $komik->total_chapters; $i++)
                                <option value="{{ route('chapter.show', [$komik->slug, $i]) }}" 
                                        {{ $i == $chapter->number ? 'selected' : '' }}>
                                    Chapter {{ $i }}
                                </option>
                            @endfor
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>

                    @if($nextChapter)
                        <a href="{{ route('chapter.show', [$komik->slug, $nextChapter->number]) }}" 
                        class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 rounded-md transition-colors duration-200">
                            <span class="hidden sm:inline">Next</span>
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @else
                        <span class="inline-flex items-center px-3 py-2 bg-gray-800 text-gray-500 rounded-md cursor-not-allowed">
                            <span class="hidden sm:inline">Next</span>
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Chapter Title -->
    <div class="bg-gray-800 border-b border-gray-700">
        <div class="max-w-4xl mx-auto px-4 py-6 text-center">
            <h1 class="text-2xl md:text-3xl font-bold mb-2">{{ $komik->title }}</h1>
            <div class="flex items-center justify-center space-x-4 text-gray-400">
                <span class="inline-flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Chapter {{ $chapter->number }}
                </span>
                @if($chapter->title)
                    <span>•</span>
                    <span>{{ $chapter->title }}</span>
                @endif
                <span>•</span>
                <span>{{ $chapter->created_at->format('M d, Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Reader Controls -->
    <div class="bg-gray-800 border-b border-gray-700">
        <div class="max-w-4xl mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <!-- Reading Mode Toggle -->
                    <button onclick="toggleReadingMode()" 
                            class="inline-flex items-center px-3 py-1 bg-gray-700 hover:bg-gray-600 rounded-md text-sm transition-colors duration-200">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <span id="reading-mode-text">Single Page</span>
                    </button>

                    <!-- Auto Scroll -->
                    <button onclick="toggleAutoScroll()" 
                            class="inline-flex items-center px-3 py-1 bg-gray-700 hover:bg-gray-600 rounded-md text-sm transition-colors duration-200">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        </svg>
                        <span id="auto-scroll-text">Auto Scroll</span>
                    </button>
                </div>

                <div class="flex items-center space-x-2 text-sm text-gray-400">
                    <span>Page:</span>
                    <span id="current-page">1</span>
                    <span>/</span>
                    <span id="total-pages">{{ count($chapter->images ?? []) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Chapter Images/Content -->
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div id="chapter-content" class="space-y-2">
            @if($chapter->images && count($chapter->images) > 0)
                @foreach($chapter->images as $index => $image)
                    <div class="chapter-page flex justify-center" data-page="{{ $index + 1 }}">
                        <img src="{{ $image }}" 
                            alt="Page {{ $index + 1 }}" 
                            class="max-w-full h-auto shadow-lg rounded-lg"
                            loading="{{ $index < 3 ? 'eager' : 'lazy' }}"
                            onload="updatePageCounter()">
                    </div>
                @endforeach
            @elseif($chapter->content)
                <div class="prose prose-invert max-w-none">
                    {!! $chapter->content !!}
                </div>
            @else
                <div class="text-center py-16">
                    <svg class="w-16 h-16 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.291-1.004-5.824-2.709M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-300 mb-2">Content Not Available</h3>
                    <p class="text-gray-500">This chapter content is not available at the moment.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Bottom Navigation -->
    <div class="sticky bottom-0 bg-gray-800 border-t border-gray-700 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                @if($prevChapter)
                    <a href="{{ route('chapter.show', [$komik->slug, $prevChapter->number]) }}" 
                    class="inline-flex items-center px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <div class="text-left">
                            <div class="text-sm font-medium">Previous</div>
                            <div class="text-xs text-gray-400">Chapter {{ $prevChapter->number }}</div>
                        </div>
                    </a>
                @else
                    <div></div>
                @endif

                <!-- Back to Comic -->
                <a href="{{ route('comic.show', $komik->slug) }}" 
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Comic Details
                </a>

                @if($nextChapter)
                    <a href="{{ route('chapter.show', [$komik->slug, $nextChapter->number]) }}" 
                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 rounded-lg transition-colors duration-200">
                        <div class="text-right">
                            <div class="text-sm font-medium">Next</div>
                            <div class="text-xs text-gray-400">Chapter {{ $nextChapter->number }}</div>
                        </div>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @else
                    <div></div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let autoScrollInterval;
let isAutoScrolling = false;
let currentReadingMode = 'single'; // 'single' or 'continuous'

// Initialize page counter
function updatePageCounter() {
    const images = document.querySelectorAll('.chapter-page img');
    const viewport = window.innerHeight;
    let currentPage = 1;

    images.forEach((img, index) => {
        const rect = img.getBoundingClientRect();
        if (rect.top <= viewport / 2 && rect.bottom >= viewport / 2) {
            currentPage = index + 1;
        }
    });

    document.getElementById('current-page').textContent = currentPage;
}

// Toggle reading mode
function toggleReadingMode() {
    const content = document.getElementById('chapter-content');
    const modeText = document.getElementById('reading-mode-text');
    
    if (currentReadingMode === 'single') {
        content.classList.add('space-y-0');
        content.classList.remove('space-y-2');
        modeText.textContent = 'Continuous';
        currentReadingMode = 'continuous';
    } else {
        content.classList.add('space-y-2');
        content.classList.remove('space-y-0');
        modeText.textContent = 'Single Page';
        currentReadingMode = 'single';
    }
}

// Toggle auto scroll
function toggleAutoScroll() {
    const scrollText = document.getElementById('auto-scroll-text');
    
    if (isAutoScrolling) {
        clearInterval(autoScrollInterval);
        scrollText.textContent = 'Auto Scroll';
        isAutoScrolling = false;
    } else {
        autoScrollInterval = setInterval(() => {
            window.scrollBy(0, 2);
            
            // Stop when reaching bottom
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                clearInterval(autoScrollInterval);
                scrollText.textContent = 'Auto Scroll';
                isAutoScrolling = false;
            }
        }, 50);
        scrollText.textContent = 'Stop Scroll';
        isAutoScrolling = true;
    }
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (e.key === 'ArrowLeft' && !e.ctrlKey && !e.metaKey) {
        @if($prevChapter)
            window.location.href = '{{ route("chapter.show", [$komik->slug, $prevChapter->number]) }}';
        @endif
        e.preventDefault();
    } else if (e.key === 'ArrowRight' && !e.ctrlKey && !e.metaKey) {
        @if($nextChapter)
            window.location.href = '{{ route("chapter.show", [$komik->slug, $nextChapter->number]) }}';
        @endif
        e.preventDefault();
    }
});

// Update page counter on scroll
window.addEventListener('scroll', updatePageCounter);
window.addEventListener('load', updatePageCounter);
</script>
@endpush

@push('styles')
<style>
/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #374151;
}

::-webkit-scrollbar-thumb {
    background: #6B7280;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #9CA3AF;
}

/* Smooth transitions */
.chapter-page img {
    transition: transform 0.3s ease;
}

.chapter-page:hover img {
    transform: scale(1.02);
}
</style>
@endpush
@endsection