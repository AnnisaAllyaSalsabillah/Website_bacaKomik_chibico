@extends('layouts.app')

@section('title', 'My Library')

@section('content')

<style>
    .tab-button {
        position: relative;
        background: none;
        border: none;
        outline: none;
    }

    .tab-button.active {
        color: #5600bf; /* hanya teks berubah warna */
    }

    .tab-button.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        height: 2px;
        width: 100%;
        background-color: #5600bf;
        border-radius: 1px;
    }

    .tab-button:hover {
        color: #D7DAE1;
        background-color: #5600bf
    }
</style>


<div class="min-h-screen bg-black py-10 px-4 text-[#D7DAE1]">
    <div class="max-w-7xl mx-auto">
        <!-- Tabs -->
        <div class="flex gap-6 mb-8 border-b border-gray-700">
            <button onclick="switchTab('history')" id="history-tab"
                class="btn btn-outline gap-2 hover:text-white tab-button  font-semibold text-lg text-gray-400 hover:text-white transition duration-200 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path d="M12 6v6l4 2" />
                    <circle cx="12" cy="12" r="10" />
                </svg>
                History
            </button>
            <button onclick="switchTab('bookmarks')" id="bookmarks-tab"
                class="btn btn-outline gap-2 hover:text-white tab-button  font-semibold text-lg text-gray-400 hover:text-white transition duration-200 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z" />
                </svg>
                Bookmarks
            </button>
        </div>



        <!-- Content Sections -->
        <div class="flex flex-col gap-16 lg:gap-32">

            <!-- Reading History -->
            <div id="history-content">
                @if($histories->count() > 0)
                <h2 class="text-2xl font-semibold mb-6">Your Reading History</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-4">
                    @foreach($histories as $history)
                    <a href="{{ route('komiks.show', $history->comic->slug) }}"
                        class="relative block rounded-xl overflow-hidden shadow hover:shadow-lg transition bg-[#1a1a1a]">

                        <!-- Chapter Badge -->
                        <div class="absolute top-2 right-2 z-10">
                            <div class="bg-blue-600 text-white text-xs px-2 py-0.5 rounded-full shadow">
                                Ch. {{ $history->chapter->chapter_number ?? '-' }}
                            </div>
                        </div>

                        <!-- Cover Image -->
                        <figure>
                            <img
                                src="{{ $history->comic->cover_image ?? 'https://via.placeholder.com/150x200?text=No+Image' }}"
                                alt="{{ $history->comic->title }}"
                                class="w-full h-72 object-cover"
                            />
                        </figure>

                        <!-- Info -->
                        <div class="p-2 bg-[#111]">
                            <h1 class="text-sm font-semibold text-white truncate">
                                {{ $history->comic->title }}
                            </h1>
                        </div>
                    </a>
                    @endforeach
                </div>
                @else
                <p class="text-gray-400">No reading history yet.</p>
                @endif
            </div>

            <!-- Bookmarks -->
            <div id="bookmarks-content" class="hidden">
                @if($bookmarks->count() > 0)
                <h2 class="text-2xl font-semibold mb-6">Your Bookmarks</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-4">
                    @foreach($bookmarks as $bookmark)
                    <a href="{{ route('komiks.show', $bookmark->comic->slug) }}"
                        class="relative block rounded-xl overflow-hidden shadow hover:shadow-lg transition bg-[#1a1a1a]">

                        <!-- Status Badge -->
                        <div class="absolute top-2 right-2 z-10">
                            <div class="bg-green-600 text-white text-xs px-2 py-0.5 rounded-full shadow">
                                {{ ucfirst($bookmark->comic->status) }}
                            </div>
                        </div>

                        <!-- Type Badge -->
                        <div class="absolute top-2 left-2 z-10">
                            <div class="bg-purple-600 text-white text-xs px-2 py-0.5 rounded-full shadow">
                                {{ ucfirst($bookmark->comic->type) }}
                            </div>
                        </div>

                        <!-- Cover Image -->
                        <figure>
                            <img
                                src="{{ $bookmark->comic->cover_image ?? 'https://via.placeholder.com/150x200?text=No+Image' }}"
                                alt="{{ $bookmark->comic->title }}"
                                class="w-full h-72 object-cover"
                            />
                        </figure>

                        <!-- Info -->
                        <div class="p-2 bg-[#111]">
                            <h1 class="text-sm font-semibold text-white truncate">
                                {{ $bookmark->comic->title }}
                            </h1>
                        </div>
                    </a>
                    @endforeach
                </div>
                @else
                <p class="text-gray-400">No bookmarks saved yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function switchTab(tab) {
        // Hide contents
        document.getElementById('history-content').classList.add('hidden');
        document.getElementById('bookmarks-content').classList.add('hidden');
        document.getElementById(tab + '-content').classList.remove('hidden');

        // Reset button style
        const buttons = document.querySelectorAll('.tab-button');
        buttons.forEach(btn => btn.classList.remove('active'));

        // Set active
        document.getElementById(tab + '-tab').classList.add('active');
    }

    document.addEventListener('DOMContentLoaded', function () {
        switchTab('history'); // default
    });
</script>



@endsection
