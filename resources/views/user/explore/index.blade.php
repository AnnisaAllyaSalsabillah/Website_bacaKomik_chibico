@extends('layouts.app')

@section('title', 'Explore')

@section('content')
<div class="container mx-auto px-4 py-8">

  {{-- Slider Gambar Komik --}}
<div class="w-full flex justify-center mb-10">
  <div class="relative w-full max-w-4xl overflow-hidden rounded-lg">
    <div id="carousel" class="flex transition-transform duration-700 ease-in-out">
      @foreach ($featuredComics as $komik)
      <a href="{{ route('komiks.show', $komik->slug) }}" class="w-full flex-shrink-0 relative group">
        <img src="{{ $komik->cover_image ?? 'https://via.placeholder.com/800x300?text=No+Image' }}"
             alt="{{ $komik->title }}"
             class="w-full h-[300px] object-cover rounded-lg">
        {{-- Overlay Info --}}
        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4 rounded-b-lg text-white">
          <h3 class="text-lg font-bold truncate">{{ $komik->title }}</h3>
          <p class="text-sm line-clamp-2">
            {{ Str::limit(strip_tags($komik->sinopsis), 100) }}
          </p>
        </div>
      </a>
      @endforeach
    </div>
  </div>
</div>
</div>

    </div>
  </div>

  <script>
    let currentIndex = 0;
    const carousel = document.getElementById('carousel');
    const totalSlides = carousel.children.length;

    setInterval(() => {
      currentIndex = (currentIndex + 1) % totalSlides;
      carousel.style.transform = `translateX(-${100 * currentIndex}%)`;
    }, 4000); // Ganti slide setiap 4 detik
  </script>

  {{-- Judul --}}
  <h1 class="text-2xl font-bold mb-4 text-center">Explore</h1>

  {{-- Grid Komik --}}
  <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
  @foreach ($comics as $komik)
    <div class="card bg-base-200 shadow-md">
      <figure>
        <img src="{{ $komik->cover_image ?? 'https://via.placeholder.com/150x200?text=No+Image' }}" 
             alt="{{ $komik->title }}" 
             class="w-full h-[200px] object-cover" />
      </figure>
      <div class="card-body p-4">
        <h2 class="card-title text-base truncate">{{ $komik->title }}</h2>
        <p class="text-sm text-gray-400">
          {{ $komik->genres->pluck('name')->take(2)->implode(', ') }}{{ $komik->genres->count() > 2 ? '...' : '' }}
        </p>
        <div class="card-actions justify-end">
          <a href="{{ route('komiks.show', $komik->slug) }}" class="btn btn-sm btn-primary">Baca</a>
        </div>
      </div>
    </div>
  @endforeach
</div>

</div>
@endsection
