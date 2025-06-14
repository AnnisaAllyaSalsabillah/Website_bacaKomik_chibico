@extends('layouts.app')

@section('title', $comic->title)

@section('content')
<div class="relative bg-black">
  <!-- Background Cover -->
  <div class="absolute inset-0">
    <img src="{{ $comic->cover_image ?? '/images/no-cover.png' }}" 
         alt="background blur"
         class="w-full h-full object-cover blur-md opacity-20">
    <!-- Optional Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/50 to-black/90"></div>
  </div>

  <!-- Konten utama -->
  <div class="relative z-10 py-8 px-4 sm:px-8 max-w-6xl mx-auto">


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
      <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-base-content mb-2">{{ $comic->title }}</h1>
        @if ($comic->alternative_title)
          <p class="text-base-content/70 text-sm sm:text-base font-medium">{{ $comic->alternative_title }}</p>
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
@endsection
