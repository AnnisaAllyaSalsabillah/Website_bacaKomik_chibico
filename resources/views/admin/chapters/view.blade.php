@extends('layouts.admin')

@section('content')
<div class="min-h-screen">
    <!-- Header -->
    <div id="header" class="fixed top-0 left-0 right-0 z-50 bg-black/90 backdrop-blur-md border-b border-gray-800 transition-transform duration-300">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button onclick="window.history.back()" 
                            class="p-2 rounded-full hover:bg-white/10 transition-colors">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <div class="text-white">
                        <h1 class="font-bold text-lg sm:text-xl truncate max-w-[500px] sm:max-w-none">{{ $komik->title }}</h1>
                        <p class="text-gray-300 text-sm">Chapter {{ $chapter->chapter }}: {{ $chapter->title }}</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-2">
                    <div class="hidden sm:flex items-center gap-2">
                        <span class="px-2 py-1 bg-blue-600 text-white text-xs rounded">
                            {{ $chapter->images->count() }} Pages
                        </span>
                        <span class="px-2 py-1 bg-gray-600 text-white text-xs rounded">
                            {{ $chapter->release_at ? \Carbon\Carbon::parse($chapter->release_at)->format('M d, Y') : 'Draft' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div id="floatingNav" class="fixed bottom-6 left-1/2 transform -translate-x-1/2 z-50 transition-all duration-300">
        <div class="bg-black/80 backdrop-blur-md rounded-full px-4 py-2 flex items-center gap-1 border border-gray-700">
            <button onclick="previousPage()" id="prevBtn" 
                    class="p-3 rounded-full hover:bg-white/10 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            
            <div class="px-4 py-2 text-white text-sm font-medium min-w-[80px] text-center">
                <span id="currentPage">1</span> / {{ $chapter->images->count() }}
            </div>
            
            <button onclick="nextPage()" id="nextBtn"
                    class="p-3 rounded-full hover:bg-white/10 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            
            <button onclick="toggleSettings()" 
                    class="p-3 rounded-full hover:bg-white/10 transition-colors ml-2">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Settings Panel -->
    <div id="settingsPanel" class="fixed bottom-24 left-1/2 transform -translate-x-1/2 z-50 bg-black/90 backdrop-blur-md rounded-lg p-4 border border-gray-700 hidden">
        <div class="flex flex-col gap-3 min-w-[200px]">
            <div class="flex items-center justify-between">
                <span class="text-white text-sm">Auto Scroll</span>
                <button onclick="toggleAutoScroll()" id="autoScrollBtn"
                        class="px-3 py-1 bg-gray-600 hover:bg-gray-700 text-white text-xs rounded transition-colors">
                    Off
                </button>
            </div>
        </div>
    </div>

    <!-- Chapter Content -->
    <div class="pt-20 pb-20">
        @if($chapter->images->count() > 0)
            <div id="verticalMode" class="flex flex-col max-w-3xl mx-auto">
                @foreach($chapter->images->sortBy('page_number') as $index => $image)
                    <div class="chapter-page relative w-full" 
                         data-page="{{ $index + 1 }}"
                         id="page-{{ $index + 1 }}">
                        
                        <img src="{{ $image->image_path }}" 
                             alt="Page {{ $image->page_number }}"
                             class="w-full h-auto object-cover block"
                             loading="{{ $index < 3 ? 'eager' : 'lazy' }}" />
                    </div>
                @endforeach
            </div>

        @else
            <div class="flex items-center justify-center min-h-screen">
                <div class="text-center">
                    <div class="text-6xl mb-4">📄</div>
                    <h3 class="text-xl font-bold text-white mb-2">Tidak ada gambar ditemukan</h3>
                    <p class="text-gray-400 mb-4">Chapter ini belum memiliki gambar.</p>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
let currentPageIndex = 0;
let totalPages = {{ $chapter->images->count() }};
let isVerticalMode = true;
let isAutoScrolling = false;
let autoScrollInterval;
let headerVisible = true;
let lastScrollTop = 0;

document.addEventListener('DOMContentLoaded', function() {
    updateNavigationState();
    setupIntersectionObserver();
    setupAutoHideHeader();
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft' || e.key === 'a' || e.key === 'A') {
            e.preventDefault();
            previousPage();
        } else if (e.key === 'ArrowRight' || e.key === 'd' || e.key === 'D') {
            e.preventDefault();
            nextPage();
        } else if (e.key === 'Escape') {
            closeSettings();
        } else if (e.key === ' ') {
            e.preventDefault();
            nextPage();
        }
    });

    // Mobile
    let touchStartX = 0;
    let touchStartY = 0;
    
    document.addEventListener('touchstart', function(e) {
        touchStartX = e.touches[0].clientX;
        touchStartY = e.touches[0].clientY;
    });
    
    document.addEventListener('touchend', function(e) {
        if (!touchStartX || !touchStartY) return;
        
        let touchEndX = e.changedTouches[0].clientX;
        let touchEndY = e.changedTouches[0].clientY;
        
        let diffX = touchStartX - touchEndX;
        let diffY = touchStartY - touchEndY;
        
        
        
        touchStartX = 0;
        touchStartY = 0;
    });
});

// Setup vertical
function setupIntersectionObserver() {
    if (!isVerticalMode) return;
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting && entry.intersectionRatio > 0.5) {
                const pageNum = parseInt(entry.target.dataset.page);
                if (pageNum !== currentPageIndex + 1) {
                    currentPageIndex = pageNum - 1;
                    updateNavigationState();
                }
            }
        });
    }, {
        threshold: [0.5],
        rootMargin: '-20% 0px -20% 0px'
    });

    document.querySelectorAll('.chapter-page').forEach(page => {
        observer.observe(page);
    });
}

function setupAutoHideHeader() {
    let scrollTimeout;
    
    window.addEventListener('scroll', function() {
        const currentScroll = window.pageYOffset;
        const header = document.getElementById('header');
        const floatingNav = document.getElementById('floatingNav');
        
        if (currentScroll > lastScrollTop && currentScroll > 100) {
            // Scroll down
            header.style.transform = 'translateY(-100%)';
            headerVisible = false;
        } else {
            // Scroll up
            header.style.transform = 'translateY(0)';
            headerVisible = true;
        }
        
        lastScrollTop = currentScroll;
        
        floatingNav.style.opacity = '1';
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(() => {
            if (!document.getElementById('settingsPanel').classList.contains('hidden')) return;
            floatingNav.style.opacity = isVerticalMode ? '0.7' : '1';
        }, 2000);
    });
}

function previousPage() {
    if (currentPageIndex > 0) {
        currentPageIndex--;
        if (isVerticalMode) {
            scrollToPage(currentPageIndex);
        } else {
            showPageHorizontal(currentPageIndex);
        }
    }
}

function nextPage() {
    if (currentPageIndex < totalPages - 1) {
        currentPageIndex++;
        if (isVerticalMode) {
            scrollToPage(currentPageIndex);
        } else {
            showPageHorizontal(currentPageIndex);
        }
    }
}

function scrollToPage(index) {
    const page = document.getElementById(`page-${index + 1}`);
    if (page) {
        page.scrollIntoView({ 
            behavior: 'smooth', 
            block: 'start'
        });
    }
    updateNavigationState();
}


function updateNavigationState() {
    document.getElementById('currentPage').textContent = currentPageIndex + 1;
    
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    prevBtn.disabled = currentPageIndex === 0;
    nextBtn.disabled = currentPageIndex === totalPages - 1;
}

function toggleAutoScroll() {
    const autoScrollBtn = document.getElementById('autoScrollBtn');
    
    if (isAutoScrolling) {
        clearInterval(autoScrollInterval);
        isAutoScrolling = false;
        autoScrollBtn.textContent = 'Off';
        autoScrollBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
        autoScrollBtn.classList.add('bg-gray-600', 'hover:bg-gray-700');
    } else {
        if (!isVerticalMode) {
            alert('Auto scroll only works in vertical mode');
            return;
        }
        
        isAutoScrolling = true;
        autoScrollBtn.textContent = 'On';
        autoScrollBtn.classList.remove('bg-gray-600', 'hover:bg-gray-700');
        autoScrollBtn.classList.add('bg-green-600', 'hover:bg-green-700');
        
        autoScrollInterval = setInterval(() => {
            window.scrollBy({
                top: 5,
                behavior: 'smooth'
            });
        }, 30);
    }
    
    closeSettings();
}

function toggleSettings() {
    const settingsPanel = document.getElementById('settingsPanel');
    settingsPanel.classList.toggle('hidden');
}

function closeSettings() {
    document.getElementById('settingsPanel').classList.add('hidden');
}
</script>

<style>

html {
    scroll-behavior: smooth;
}

::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #1f2937;
}

::-webkit-scrollbar-thumb {
    background: #4b5563;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #6b7280;
}

.chapter-page {
    transition: opacity 0.3s ease-in-out;
}

#floatingNav {
    opacity: 0.7;
}

#floatingNav:hover {
    opacity: 1;
}

#verticalMode {
    gap: 0;
}

#verticalMode .chapter-page {
    margin: 0;
    padding: 0;
    line-height: 0;
}

#verticalMode .chapter-page img {
    display: block;
    width: 100%;
    height: auto;
    object-fit: cover;
    vertical-align: bottom;
    margin: 0;
    padding: 0;
}

/* Mobile */
@media (max-width: 640px) {
    #floatingNav {
        bottom: 1rem;
        opacity: 1;
    }
    
    #floatingNav .bg-black\/80 {
        padding: 0.5rem 1rem;
    }
    
    #header {
        padding: 0.75rem 1rem;
    }
}

#floatingNav, #header, #settingsPanel {
    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.chapter-page {
    animation: fadeIn 0.3s ease-in-out;
}
</style>
@endsection