@extends('layouts.app')

@section('title', 'My Library')

@section('content')
@if(auth()->check())
    <span>{{ auth()->user()->name }}</span>
@else
    <span>Guest</span>
@endif



<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">My Library</h1>
                    <p class="text-gray-600 mt-1">Your reading history and saved comics</p>
                </div>
                <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>{{ auth()->user()->name ?? 'Guest' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <!-- Tab Buttons -->
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button onclick="switchTab('history')" 
                            id="history-tab"
                            class="tab-button w-1/2 py-4 px-6 text-center border-b-2 font-medium text-sm focus:outline-none transition-colors duration-200 border-blue-500 text-blue-600 bg-blue-50">
                        <div class="flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Reading History</span>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $histories->count() }}</span>
                        </div>
                    </button>
                    <button onclick="switchTab('bookmarks')" 
                            id="bookmarks-tab"
                            class="tab-button w-1/2 py-4 px-6 text-center border-b-2 font-medium text-sm focus:outline-none transition-colors duration-200 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        <div class="flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                            <span>Bookmarks</span>
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $bookmarks->count() }}</span>
                        </div>
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                <!-- History Tab -->
                <div id="history-content" class="tab-content">
                    @if($histories->count() > 0)
                        <div class="space-y-4">
                            @foreach($histories as $history)
                                <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                    <!-- Comic Cover -->
                                    <div class="flex-shrink-0">
                                        <img src="{{ $history->comic->cover_image ? asset('storage/' . $history->comic->cover_image) : '/images/placeholder.jpg' }}"
                                            alt="{{ $history->comic->title }}"
                                            class="w-16 h-20 object-cover rounded-lg shadow-sm">
                                    </div>
                                    
                                    <!-- Comic Info -->
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-semibold text-gray-900 truncate">
                                            {{ $history->comic->title }}
                                        </h3>
                                        <p class="text-sm text-gray-600 mt-1">
                                            Last read: Chapter {{ $history->chapter->chapter_number ?? 'N/A' }}
                                            @if($history->chapter)
                                                - {{ $history->chapter->title }}
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500 mt-2">
                                            {{ $history->updated_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    
                                    <!-- Action Button -->
                                    <div class="flex-shrink-0">
                                        <a href="{{ route('komiks.show', $history->comic->slug) }}" 
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                            Continue Reading
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Empty State for History -->
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No reading history</h3>
                            <p class="mt-1 text-sm text-gray-500">Start reading some comics to see your history here.</p>
                            <div class="mt-6">
                                <a href="{{ route('explore') }}" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Explore Comics
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Bookmarks Tab -->
                <div id="bookmarks-content" class="tab-content hidden">
                    @if($bookmarks->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach($bookmarks as $bookmark)
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden">
                                    <!-- Comic Cover -->
                                    <div class="aspect-w-3 aspect-h-4 bg-gray-200">
                                        <img src="{{ $bookmark->comic->cover_image ? asset('storage/' . $bookmark->comic->cover_image) : '/images/placeholder.jpg' }}"
                                            alt="{{ $bookmark->comic->title }}"
                                            class="w-full h-48 object-cover">
                                    </div>
                                    
                                    <!-- Comic Info -->
                                    <div class="p-4">
                                        <h3 class="text-sm font-semibold text-gray-900 truncate mb-2">
                                            {{ $bookmark->comic->title }}
                                        </h3>
                                        <p class="text-xs text-gray-600 mb-3">
                                            @if($bookmark->comic->genres)
                                                {{ $bookmark->comic->genres->pluck('name')->join(', ') }}
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500 mb-4">
                                            Bookmarked {{ $bookmark->created_at->diffForHumans() }}
                                        </p>
                                        
                                        <!-- Action Buttons -->
                                        <div class="flex space-x-2">
                                            <a href="{{ route('komiks.show', $bookmark->comic->slug) }}" 
                                                class="flex-1 bg-blue-600 text-white text-xs font-medium py-2 px-3 rounded text-center hover:bg-blue-700 transition-colors duration-200">
                                                Read
                                            </a>
                                            <form action="{{ route('user.bookmark.toggle', $bookmark->comic->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="bg-red-100 text-red-600 text-xs font-medium py-2 px-3 rounded hover:bg-red-200 transition-colors duration-200"
                                                        onclick="return confirm('Remove from bookmarks?')">
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Empty State for Bookmarks -->
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No bookmarks yet</h3>
                            <p class="mt-1 text-sm text-gray-500">Save your favorite comics to easily find them later.</p>
                            <div class="mt-6">
                                <a href="{{ route('explore') }}" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Discover Comics
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(tabName) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active styles from all tabs
    const tabButtons = document.querySelectorAll('.tab-button');
    tabButtons.forEach(button => {
        button.classList.remove('border-blue-500', 'text-blue-600', 'bg-blue-50');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById(tabName + '-content').classList.remove('hidden');
    
    // Add active styles to selected tab
    const activeTab = document.getElementById(tabName + '-tab');
    activeTab.classList.remove('border-transparent', 'text-gray-500');
    activeTab.classList.add('border-blue-500', 'text-blue-600', 'bg-blue-50');
}
</script>

@endsection