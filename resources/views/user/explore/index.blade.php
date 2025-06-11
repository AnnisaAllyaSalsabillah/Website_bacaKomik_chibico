@extends('layouts.app')

@section('title', 'Explore')

@section('content')
<div class="container mx-auto px-4 py-8">

  {{-- Slider Gambar Komik --}}
  <div class="w-full flex justify-center mb-10">
    <div class="relative w-full max-w-4xl overflow-hidden rounded-lg">
      <div id="carousel" class="flex transition-transform duration-700 ease-in-out">
        @for ($i = 1; $i <= 4; $i++)
        <div class="w-full flex-shrink-0">
          <img src="https://via.placeholder.com/800x300?text=Komik+{{ $i }}" class="w-full h-[300px] object-cover rounded-lg" alt="Slide {{ $i }}">
        </div>
        @endfor
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
    @for ($i = 0; $i < 10; $i++)
    <div class="card bg-base-200 shadow-md">
      <figure>
        <img src="https://via.placeholder.com/150x200?text=Komik+{{ $i+1 }}" alt="Comic cover" class="w-full h-[200px] object-cover" />
      </figure>
      <div class="card-body p-4">
        <h2 class="card-title text-base truncate">Judul Komik {{ $i + 1 }}</h2>
        <p class="text-sm text-gray-400">Genre / Tag</p>
        <div class="card-actions justify-end">
          <a href="#" class="btn btn-sm btn-primary">Baca</a>
        </div>
      </div>
    </div>
    @endfor
  </div>
</div>
@endsection
