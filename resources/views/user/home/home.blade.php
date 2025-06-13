@extends('layouts.app')

@section('content')
<div id="bg-body" class="bg-base-dark transition-all duration-300 min-h-[100dvh] flex flex-col mb-20 lg:mb-0">
  <div class="flex-1 relative flex flex-col">
    <div class="md:pt-0 pt-4 px-4 md:px-24">
      <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">
          <div class="col-span-1 lg:col-span-2">
            <div class="splide relative w-full splide--slide splide--ltr splide--draggable is-active is-overflow is-initialized" id="splide04" role="region" aria-roledescription="carousel">
              @php
                use App\Models\Comic;

                // Ambil komik berdasarkan ID manual yang ditentukan
                $manualComics = Comic::whereIn('id', [1, 1, 1, 2])->get()->keyBy('id');
                @endphp

                <div class="splide__track splide__track--slide splide__track--ltr splide__track--draggable" id="splide04-track">
                  <div class="carousel carousel-center bg-neutral rounded-box max-w-4xl p-4 space-x-4 overflow-x-auto snap-x snap-mandatory scroll-smooth" id="manualCarousel">

                    {{-- Slide 1 --}}
                    <a href="{{ route('komiks.show', $manualComics[1]->slug ?? '#') }}"
                      class="carousel-item w-full border border-gray-300 rounded-box overflow-hidden relative group snap-start">
                      <img src="https://i.pinimg.com/736x/d6/c3/7d/d6c37d49a59769fe4ccb119a9f30841c.jpg"
                          class="w-full object-cover h-[300px]" />
                      <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4 text-white">
                        <h3 class="text-lg font-bold">Judul Komik 1</h3>
                        <p class="text-sm">Deskripsi singkat komik 1 ditulis manual di sini.</p>
                      </div>
                    </a>

                    {{-- Slide 2 --}}
                    <a href="{{ route('komiks.show', $manualComics[3]->slug ?? '#') }}"
                      class="carousel-item w-full border border-gray-300 rounded-box overflow-hidden relative group snap-start">
                      <img src="https://i.pinimg.com/originals/0a/1a/8d/0a1a8d4c1bcae5ec83bbc0af395ca9a1.jpg"
                          class="w-full object-cover h-[300px]" />
                      <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4 text-white">
                        <h3 class="text-lg font-bold">Judul Komik 2</h3>
                        <p class="text-sm">Deskripsi singkat komik 2 yang kamu tulis sendiri di sini.</p>
                      </div>
                    </a>

                    {{-- Slide 3 --}}
                    <a href="{{ route('komiks.show', $manualComics[5]->slug ?? '#') }}"
                      class="carousel-item w-full border border-gray-300 rounded-box overflow-hidden relative group snap-start">
                      <img src="https://wallpapercave.com/wp/wp11998991.jpg"
                          class="w-full object-cover h-[300px]" />
                      <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4 text-white">
                        <h3 class="text-lg font-bold">Judul Komik 3</h3>
                        <p class="text-sm">Sinopsis singkat bisa kamu edit langsung di blade.</p>
                      </div>
                    </a>

                    {{-- Slide 4 --}}
                    <a href="{{ route('komiks.show', $manualComics[8]->slug ?? '#') }}"
                      class="carousel-item w-full border border-gray-300 rounded-box overflow-hidden relative group snap-start">
                      <img src="https://static0.gamerantimages.com/wordpress/wp-content/uploads/2024/10/solo.jpg"
                          class="w-full object-cover h-[300px]" />
                      <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4 text-white">
                        <h3 class="text-lg font-bold">Judul Komik 4</h3>
                        <p class="text-sm">Tulisan ini bisa kamu sesuaikan juga sesuai isi komik.</p>
                      </div>
                    </a>

                  </div>
                </div>


              <!-- Modern Carousel Controls -->
              <div class="flex items-center justify-center gap-8 mt-16">
                <!-- Left Navigation Button -->
                <button id="prev" class="group relative bg-gradient-to-r from-slate-800 to-slate-700 hover:from-indigo-600 hover:to-purple-600 text-white p-2.5 rounded-lg shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-105 active:scale-95">
                  <svg class="w-5 h-5 transition-transform duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                  </svg>
                </button>

                <!-- Radio Button Indicators -->
                <div class="flex items-center justify-center gap-4 px-5 py-2 bg-black/20 backdrop-blur-md rounded-full border border-white/10">
                  <label class="cursor-pointer">
                    <input type="radio" name="carousel-radio" id="radio1" class="sr-only peer" checked />
                    <div class="w-3 h-3 rounded-full bg-white/30 peer-checked:bg-gradient-to-r peer-checked:from-indigo-400 peer-checked:to-purple-400 peer-checked:shadow-md peer-checked:shadow-purple-400/50 transition-all duration-300 hover:scale-110 peer-checked:scale-125"></div>
                  </label>

                  <label class="cursor-pointer">
                    <input type="radio" name="carousel-radio" id="radio2" class="sr-only peer" />
                    <div class="w-3 h-3 rounded-full bg-white/30 peer-checked:bg-gradient-to-r peer-checked:from-indigo-400 peer-checked:to-purple-400 peer-checked:shadow-md peer-checked:shadow-purple-400/50 transition-all duration-300 hover:scale-110 peer-checked:scale-125"></div>
                  </label>

                  <label class="cursor-pointer">
                    <input type="radio" name="carousel-radio" id="radio3" class="sr-only peer" />
                    <div class="w-3 h-3 rounded-full bg-white/30 peer-checked:bg-gradient-to-r peer-checked:from-indigo-400 peer-checked:to-purple-400 peer-checked:shadow-md peer-checked:shadow-purple-400/50 transition-all duration-300 hover:scale-110 peer-checked:scale-125"></div>
                  </label>

                  <label class="cursor-pointer">
                    <input type="radio" name="carousel-radio" id="radio4" class="sr-only peer" />
                    <div class="w-3 h-3 rounded-full bg-white/30 peer-checked:bg-gradient-to-r peer-checked:from-indigo-400 peer-checked:to-purple-400 peer-checked:shadow-md peer-checked:shadow-purple-400/50 transition-all duration-300 hover:scale-110 peer-checked:scale-125"></div>
                  </label>
                </div>

                <!-- Right Navigation Button -->
                <button id="next" class="group relative bg-gradient-to-r from-slate-800 to-slate-700 hover:from-indigo-600 hover:to-purple-600 text-white p-2.5 rounded-lg shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-105 active:scale-95">
                  <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                  </svg>
                </button>
              </div>

            </div>
          </div>

          <div class="flex flex-col gap-16 col-span-1">
            <div class="flex items-end justify-between">
              <h2 class="font-semibold md:text-24 md:leading-28 text-20 leading-23">Pengumuman</h2>
              <a href="/pengumuman" class="md:text-20 md:leading-28 text-16 leading-22 text-general-300">Semua</a>
            </div>

            <div class="splide relative w-full splide--slide splide--ltr splide--draggable is-active is-overflow is-initialized" id="splide05" role="region" aria-roledescription="carousel">
              <div class="splide__track splide__track--slide splide__track--ltr splide__track--draggable" id="splide05-track" style="padding-left: 0px; padding-right: 0px;" aria-live="polite" aria-atomic="true">
                <ul class="splide__list" id="splide05-list" role="presentation" style="transform: translateX(0px);">
                  <div class="carousel w-full max-w-4xl space-y-4">

        @forelse($pengumuman->chunk(2) as $chunk)
          <!-- Slide -->
          <div class="carousel-item flex flex-col gap-4 w-full">
            @foreach($chunk as $item)
              <a class="card card-side bg-base-100 shadow-md w-full hover:bg-base-200 transition" href="{{ route('user.pengumuman.show', $item->id) }}">
                <figure class="w-24 h-24 p-2">
                  <img src="{{ $item->thumbnail }}" alt="{{ $item->title }}" class="object-cover rounded-lg w-full h-full" />
                </figure>
                <div class="card-body p-4">
                  <h2 class="card-title text-base">{{ $item->title }}</h2>
                  <p class="text-sm line-clamp-2">{{ Str::limit(strip_tags($item->content), 20) }}</p>
                </div>
              </a>
            @endforeach
          </div>
        @empty
          <p class="text-center text-gray-400 w-full py-10">Belum ada pengumuman.</p>
        @endforelse

      </div>

                </ul>
              </div>
              <div class="flex items-center gap-16 justify-center mt-16">
                <button class="w-36 h-36 bg-base-card rounded-4 flex items-center justify-center opacity-50"></button>
                <div class="flex items-center justify-center gap-8 p-2">
                  @for ($j = 1; $j <= 5; $j++)
                    <button class="w-16 h-16 flex items-center justify-center transition-all duration-300 rounded-full border border-transparent">
                      <div class="w-8 h-8 rounded-full bg-base-white"></div>
                    </button>
                  @endfor
                </div>
                <button class="w-36 h-36 bg-base-card rounded-4 flex items-center justify-center opacity-100"></button>
              </div>
            </div>
          </div>
        </div>
      </div>


  {{-- Section Rekomendasi --}}
<div class="md:py-6 py-8 px-6 md:px-6">
  <h2 class="text-2xl font-semibold mb-6">Rekomendasi</h2>

  {{-- Filter Button --}}
  <div class="mb-6 flex gap-2">
    <a href="{{ route('home', ['type' => 'Manhwa']) }}" class="btn btn-soft {{ $type == 'Manhwa' ? 'btn-active' : '' }}">Manhwa</a>
    <a href="{{ route('home', ['type' => 'Manga']) }}" class="btn btn-soft {{ $type == 'Manga' ? 'btn-active' : '' }}">Manga</a>
    <a href="{{ route('home', ['type' => 'Manhua']) }}" class="btn btn-soft {{ $type == 'Manhua' ? 'btn-active' : '' }}">Manhua</a>
  </div>

  {{-- Grid Rekomendasi --}}
  <div class="grid grid-cols-3 gap-[2px] max-w-[560px]">
    @foreach ($recommendedComics as $comic)
      <a href="{{ route('komiks.show', $comic->slug) }}" class="block rounded-xl overflow-hidden shadow hover:shadow-md transition" style="width: 180px;">
        <img
          src="{{ $comic->cover_image ?? 'https://via.placeholder.com/150x200?text=No+Image' }}"
          alt="{{ $comic->title }}"
          class="w-full h-72 object-cover"
        />
        <div class="p-2 bg-base-100">
          <p class="text-xs text-gray-500">{{ ucfirst($comic->status) }}</p>
          <p class="text-xs text-yellow-400 font-semibold">★ {{ $comic->upvotes_count }} Rating</p>
        </div>
      </a>
    @endforeach
  </div>
</div>

{{-- Section Update --}}
<div class="md:py-6 py-8 px-6 md:px-6">
  <h2 class="text-2xl font-semibold mb-6">Update</h2>

  <div class="grid grid-cols-3 gap-[2px] max-w-[560px]">
    @foreach ($latestUpdatedComics as $comic)
      <a href="{{ route('komiks.show', $comic->slug) }}" class="block rounded-xl overflow-hidden shadow hover:shadow-md transition" style="width: 180px;">
        <img
          src="{{ $comic->cover_image ?? 'https://via.placeholder.com/150x200?text=No+Image' }}"
          alt="{{ $comic->title }}"
          class="w-full h-72 object-cover"
        />
        <div class="p-2 bg-base-100">
          <p class="text-xs text-gray-500">
            {{ ucfirst($comic->status) }} — Chapter {{ $comic->latestChapter?->chapter ?? '-' }}
          </p>
          <p class="text-xs text-yellow-400 font-semibold">★ {{ $comic->upvotes_count }} Rating</p>
        </div>
      </a>
    @endforeach
  </div>
</div>

{{-- Section Populer --}}
<div class="md:py-6 py-8 px-6 md:px-6">
  <h2 class="text-2xl font-semibold mb-6">Populer</h2>

  <div class="grid grid-cols-3 gap-[2px] max-w-[560px]">
    @foreach ($popularComics as $comic)
      <a href="{{ route('komiks.show', $comic->slug) }}" class="block rounded-xl overflow-hidden shadow hover:shadow-md transition" style="width: 180px;">
        <img
          src="{{ $comic->cover_image ?? 'https://via.placeholder.com/150x200?text=No+Image' }}"
          alt="{{ $comic->title }}"
          class="w-full h-72 object-cover"
        />
        <div class="p-2 bg-base-100">
          <p class="text-xs text-gray-500">{{ ucfirst($comic->status) }}</p>
          <p class="text-xs text-yellow-400 font-semibold">★ {{ $comic->upvotes_count }} Rating</p>
        </div>
      </a>
    @endforeach
  </div>
</div>

  <script>
  document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.getElementById('manualCarousel');
    const slides = carousel.querySelectorAll('.carousel-item');
    let currentIndex = 0;

    function goToSlide(index) {
      currentIndex = index;
      const scrollAmount = slides[index].offsetLeft;
      carousel.scrollTo({
        left: scrollAmount,
        behavior: 'smooth'
      });
    }

    // Autoplay: Pindah slide tiap 4 detik
    setInterval(() => {
      currentIndex = (currentIndex + 1) % slides.length;
      goToSlide(currentIndex);
    }, 4000);
  });
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.getElementById('manualCarousel');
    const slides = carousel.querySelectorAll('.carousel-item');
    const radios = [
      document.getElementById('radio1'),
      document.getElementById('radio2'),
      document.getElementById('radio3'),
      document.getElementById('radio4'),
    ];
    const prevBtn = document.getElementById('prev');
    const nextBtn = document.getElementById('next');
    
    let currentIndex = 0;

    function goToSlide(index) {
      currentIndex = index;
      const scrollAmount = slides[index].offsetLeft;
      carousel.scrollTo({
        left: scrollAmount,
        behavior: 'smooth'
      });

      // update radio check
      if (radios[index]) radios[index].checked = true;
    }

    // Tombol next
    nextBtn.addEventListener('click', () => {
      currentIndex = (currentIndex + 1) % slides.length;
      goToSlide(currentIndex);
    });

    // Tombol prev
    prevBtn.addEventListener('click', () => {
      currentIndex = (currentIndex - 1 + slides.length) % slides.length;
      goToSlide(currentIndex);
    });

    // Radio buttons
    radios.forEach((radio, index) => {
      radio.addEventListener('change', () => {
        if (radio.checked) {
          goToSlide(index);
        }
      });
    });

    // Optional: update posisi saat scroll manual
    carousel.addEventListener('scroll', () => {
      slides.forEach((slide, i) => {
        if (Math.abs(carousel.scrollLeft - slide.offsetLeft) < slide.offsetWidth / 2) {
          currentIndex = i;
          if (radios[i]) radios[i].checked = true;
        }
      });
    });
  });
</script>

  
@endsection
