@extends('layouts.app')

@section('title', $comic->title)

@section('content')
<div class="relative bg-black">
  <!-- Background Cover -->
  <div class="absolute inset-0">
    <img src="{{ $comic->cover_image ?? '/images/no-cover.png' }}" 
        alt="background blur"
        class="w-full h-full object-cover blur-md opacity-20">
    <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/50 to-black/90"></div>
  </div>
  <!-- Konten Utama -->
  <div class="relative z-10 py-8 px-4 sm:px-8 max-w-6xl mx-auto">
    @if(session('success'))
    <div id="toast-notif" class="fixed top-24 left-1/2 transform -translate-x-1/2 w-full max-w-md 
        bg-purple-100/90 text-purple-900 px-6 py-4 rounded-xl shadow-md z-50 
        transition-opacity duration-500">
          <div class="flex items-center justify-between gap-4">
              <span class="font-semibold">{{ session('success') }}</span>
              <button onclick="document.getElementById('toast-notif').remove()" class="text-purple-500 hover:text-purple-700 text-xl leading-none">&times;</button>
          </div>
      </div>
  @endif


    <div class="py-8 px-4 sm:px-8 max-w-6xl mx-auto">
      
      <div class="flex flex-col lg:flex-row gap-6 mb-6">
        <!-- Cover Image -->
        <div class="flex-shrink-0 mx-auto lg:mx-0">
          <div class="w-48 h-64 sm:w-56 sm:h-72 lg:w-64 lg:h-80 relative overflow-hidden rounded-lg shadow-lg">
            <img src="{{ $comic->cover_image ?? '/images/no-cover.png' }}"
                alt="{{ $comic->title }}"
                class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
          </div>
        </div>

        <!-- Basic Info -->
        <div class="flex-1 space-y-4">
          <div class="mb-2">
            <div class="flex items-center justify-between flex-wrap gap-4">
              <h1 class="text-2xl sm:text-3xl font-bold text-base-content">
                {{ $comic->title }}
              </h1>

              <div class="flex items-center gap-2">
                <form action="{{ route('bookmark.toggle', $comic->id) }}" method="POST">
                  @csrf
                  <button type="submit"
                          class="btn btn-outline gap-2 text-yellow-500 border-yellow-500 hover:bg-yellow-500 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M5 3a2 2 0 00-2 2v14l7-4 7 4V5a2 2 0 00-2-2H5z" />
                    </svg>
                    Bookmark
                  </button>
                </form>
              </div>
            </div>

            @if ($comic->alternative_title)
              <p class="text-base-content/70 text-sm sm:text-base font-medium">
                {{ $comic->alternative_title }}
              </p>
            @endif
          </div>

          <div class="flex flex-wrap gap-2">
            <span class="badge badge-lg badge-{{ $comic->status === 'ongoing' ? 'success' : 'info' }} font-medium">
              {{ ucfirst($comic->status) }}
            </span>
            <span class="badge badge-lg badge-{{ $comic->type === 'manga' ? 'primary' : ($comic->type === 'manhwa' ? 'secondary' : 'accent') }} font-medium">
              {{ ucfirst($comic->type) }}
            </span>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="space-y-3">
              @if ($comic->author)
                <div>
                  <span class="text-sm font-semibold text-base-content/70">Author:</span>
                  <p class="font-medium">{{ $comic->author }}</p>
                </div>
              @endif

              @if ($comic->artist)
                <div>
                  <span class="text-sm font-semibold text-base-content/70">Artist:</span>
                  <p class="font-medium">{{ $comic->artist }}</p>
                </div>
              @endif

              @if ($comic->genres->isNotEmpty())
                <div>
                  <h3 class="text-lg font-semibold mb-3">Genres</h3>
                  <div class="flex flex-wrap gap-2">
                    @foreach ($comic->genres as $genre)
                      <span class="badge badge-outline">{{ $genre->name }}</span>
                    @endforeach
                  </div>
                </div>
              @endif
            </div>

            <div class="space-y-3">
              @if ($comic->release_year)
                <div>
                  <span class="text-sm font-semibold text-base-content/70">Release Year:</span>
                  <p class="font-medium">{{ $comic->release_year }}</p>
                </div>
              @endif

              @if ($comic->rank)
                <div>
                  <span class="text-sm font-semibold text-base-content/70">Rank:</span>
                  <p class="font-medium">#{{ $comic->upvotes_count }}</p>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>

      <div class="space-y-6">
        @if ($comic->sinopsis)
          <div>
            <h3 class="text-lg font-semibold mb-3">Sinopsis</h3>
            <div class="prose prose-sm sm:prose max-w-none">
              <p class="text-base-content/80 leading-relaxed whitespace-pre-line">{{ $comic->sinopsis }}</p>
            </div>
          </div>
        @endif

        <div class="flex gap-3 mt-4">
          <!-- Tombol Baca -->
          <a href="#" class="btn btn-primary gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
            Baca
          </a>
        </div>

        <div class="bg-base-200 rounded-lg p-4">
          <h3 class="text-lg font-semibold mb-3">Additional Information</h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div>
              <span class="font-semibold text-base-content/70">Slug:</span>
              <p class="font-mono text-xs bg-base-300 px-2 py-1 rounded mt-1">{{ $comic->slug }}</p>
            </div>
            <div>
              <span class="font-semibold text-base-content/70">Created:</span>
              <p class="mt-1">{{ $comic->created_at->diffForHumans() }}</p>
            </div>
            <div>
              <span class="font-semibold text-base-content/70">Last Updated:</span>
              <p class="mt-1">{{ $comic->updated_at->diffForHumans() }}</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const notif = document.getElementById('toast-notif');
        if (notif) {
            setTimeout(() => {
                notif.classList.add('opacity-0');
                setTimeout(() => notif.remove(), 500); 
            }, 2000); 
        }
    });
</script>

@endsection
