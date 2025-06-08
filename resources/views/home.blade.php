@extends('layouts.app')

@section('content')
<div id="bg-body" class="bg-base-dark transition-all duration-300 min-h-[100dvh] flex flex-col mb-20 lg:mb-0">
  <div class="flex-1 relative flex flex-col">
    <div class="md:pt-24 pt-4 px-4 md:px-24">
      <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">
          <div class="col-span-1 lg:col-span-2">
            <div class="splide relative w-full splide--slide splide--ltr splide--draggable is-active is-overflow is-initialized" id="splide04" role="region" aria-roledescription="carousel">
              <div class="splide__track splide__track--slide splide__track--ltr splide__track--draggable" id="splide04-track" style="padding-left: 0px; padding-right: 0px;" aria-live="off" aria-atomic="true" aria-busy="false">
                <div class="carousel carousel-center bg-neutral rounded-box max-w-4xl p-4 space-x-4">
                  <div class="carousel-item w-full border border-gray-300 rounded-box overflow-hidden">
                    <img
                      src="https://img.daisyui.com/images/stock/photo-1559703248-dcaaec9fab78.webp"
                      class="w-full object-cover h-[300px]" />
                  </div>
                  <div class="carousel-item w-full border border-gray-300 rounded-box overflow-hidden">
                    <img
                      src="https://img.daisyui.com/images/stock/photo-1565098772267-60af42b81ef2.webp"
                      class="w-full object-cover h-[300px]" />
                  </div>
                  <div class="carousel-item w-full border border-gray-300 rounded-box overflow-hidden">
                    <img
                      src="https://img.daisyui.com/images/stock/photo-1572635148818-ef6fd45eb394.webp"
                      class="w-full object-cover h-[300px]" />
                  </div>
                  <div class="carousel-item w-full border border-gray-300 rounded-box overflow-hidden">
                    <img
                      src="https://img.daisyui.com/images/stock/photo-1494253109108-2e30c049369b.webp"
                      class="w-full object-cover h-[300px]" />
                  </div>
                </div>
              </div>

              <div class="flex items-center gap-16 justify-center mt-16">
                <button class="w-36 h-36 bg-base-card rounded-4 flex items-center justify-center opacity-100"></button>
                <div class="flex items-center justify-center gap-8 p-2">
                  <button id="prev">Prev</button>

                  <!-- radio buttons -->
                  <input type="radio" name="carousel-radio" id="radio1" checked />
                  <label for="radio1"></label>
                  <input type="radio" name="carousel-radio" id="radio2" />
                  <label for="radio2"></label>
                  <input type="radio" name="carousel-radio" id="radio3" />
                  <label for="radio3"></label>

                  <!-- tombol kanan -->
                  <button id="next">Next</button>
                </div>
                <button class="w-36 h-36 bg-base-card rounded-4 flex items-center justify-center opacity-50"></button>
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
                  <!-- Slide 1 -->
                  <div class="carousel-item flex flex-col gap-4 w-full">
                    <a class="card card-side bg-base-100 shadow-md w-full hover:bg-base-200 transition" href="/pengumuman">
                      <figure class="w-24 h-24 p-2">
                        <img src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp" alt="Course 1" class="object-cover rounded-lg w-full h-full" />
                      </figure>
                      <div class="card-body p-4">
                        <h2 class="card-title text-base">Course Title 1</h2>
                        <p class="text-sm">Brief description for course 1.</p>
                      </div>
                    </a>
                    <a class="card card-side bg-base-100 shadow-md w-full hover:bg-base-200 transition">
                      <figure class="w-24 h-24 p-2">
                        <img src="https://img.daisyui.com/images/stock/photo-1565098772267-60af42b81ef2.webp" alt="Course 2" class="object-cover rounded-lg w-full h-full" />
                      </figure>
                      <div class="card-body p-4">
                        <h2 class="card-title text-base">Course Title 2</h2>
                        <p class="text-sm">Brief description for course 2.</p>
                      </div>
                    </a>
                  </div>

                  <!-- Slide 2 -->
                  <div class="carousel-item flex flex-col gap-4 w-full">
                    <button class="card card-side bg-base-100 shadow-md w-full hover:bg-base-200 transition">
                      <figure class="w-24 h-24 p-2">
                        <img src="https://img.daisyui.com/images/stock/photo-1572635148818-ef6fd45eb394.webp" alt="Course 3" class="object-cover rounded-lg w-full h-full" />
                      </figure>
                      <div class="card-body p-4">
                        <h2 class="card-title text-base">Course Title 3</h2>
                        <p class="text-sm">Brief description for course 3.</p>
                      </div>
                    </button>
                    <button class="card card-side bg-base-100 shadow-md w-full hover:bg-base-200 transition">
                      <figure class="w-24 h-24 p-2">
                        <img src="https://img.daisyui.com/images/stock/photo-1494253109108-2e30c049369b.webp" alt="Course 4" class="object-cover rounded-lg w-full h-full" />
                      </figure>
                      <div class="card-body p-4">
                        <h2 class="card-title text-base">Course Title 4</h2>
                        <p class="text-sm">Brief description for course 4.</p>
                      </div>
                    </button>
                  </div>

                  <!-- Tambahkan slide 3 dan 4 sesuai kebutuhan -->
                  <!-- Slide 3 -->
                  <div class="carousel-item flex flex-col gap-4 w-full">
                    <button class="card card-side bg-base-100 shadow-md w-full hover:bg-base-200 transition">
                      <figure class="w-24 h-24 p-2">
                        <img src="https://img.daisyui.com/images/stock/photo-1606788075761-0b7e9e7dfcfe.webp" alt="Course 5" class="object-cover rounded-lg w-full h-full" />
                      </figure>
                      <div class="card-body p-4">
                        <h2 class="card-title text-base">Course Title 5</h2>
                        <p class="text-sm">Brief description for course 5.</p>
                      </div>
                    </button>
                    <button class="card card-side bg-base-100 shadow-md w-full hover:bg-base-200 transition">
                      <figure class="w-24 h-24 p-2">
                        <img src="https://img.daisyui.com/images/stock/photo-1606829541836-25dc7f7a1d3c.webp" alt="Course 6" class="object-cover rounded-lg w-full h-full" />
                      </figure>
                      <div class="card-body p-4">
                        <h2 class="card-title text-base">Course Title 6</h2>
                        <p class="text-sm">Brief description for course 6.</p>
                      </div>
                    </button>
                  </div>

                  <!-- Slide 4 -->
                  <div class="carousel-item flex flex-col gap-4 w-full">
                    <button class="card card-side bg-base-100 shadow-md w-full hover:bg-base-200 transition">
                      <figure class="w-24 h-24 p-2">
                        <img src="https://img.daisyui.com/images/stock/photo-1607746882042-944635dfe10e.webp" alt="Course 7" class="object-cover rounded-lg w-full h-full" />
                      </figure>
                      <div class="card-body p-4">
                        <h2 class="card-title text-base">Course Title 7</h2>
                        <p class="text-sm">Brief description for course 7.</p>
                      </div>
                    </button>
                    <button class="card card-side bg-base-100 shadow-md w-full hover:bg-base-200 transition">
                      <figure class="w-24 h-24 p-2">
                        <img src="https://img.daisyui.com/images/stock/photo-1609982773473-1f3122c6cb2f.webp" alt="Course 8" class="object-cover rounded-lg w-full h-full" />
                      </figure>
                      <div class="card-body p-4">
                        <h2 class="card-title text-base">Course Title 8</h2>
                        <p class="text-sm">Brief description for course 8.</p>
                      </div>
                    </button>
                  </div>
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


      <div class="md:py-24 py-12 px-6 md:px-6">
  <h2 class="text-2xl font-semibold mb-6">Rekomendasi</h2>
  <div class="mb-6">
    <button class="btn btn-soft">Manhwa</button>
    <button class="btn btn-soft">Manga</button>
    <button class="btn btn-soft">Manhua</button>
  </div>
  
  <div class="grid grid-cols-3 gap-x-[2px] gap-y-[2px] max-w-[560px] mx-0">
    <!-- Card 1 -->
    <a href="/rekomendasi/1" class="block rounded-xl overflow-hidden shadow-md hover:shadow-lg transition" style="width: 180px;">
      <img
        src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
        alt="Rekomendasi 1"
        class="w-full h-96 object-cover"
      />
    </a>

    <!-- Card 2 -->
    <a href="/rekomendasi/2" class="block rounded-xl overflow-hidden shadow-md hover:shadow-lg transition" style="width: 180px;">
      <img
        src="https://img.daisyui.com/images/stock/photo-1565098772267-60af42b81ef2.webp"
        alt="Rekomendasi 2"
        class="w-full h-96 object-cover"
      />
    </a>

    <!-- Card 3 -->
    <a href="/rekomendasi/3" class="block rounded-xl overflow-hidden shadow-md hover:shadow-lg transition" style="width: 180px;">
      <img
        src="https://img.daisyui.com/images/stock/photo-1572635148818-ef6fd45eb394.webp"
        alt="Rekomendasi 3"
        class="w-full h-96 object-cover"
      />
    </a>
  </div>
</div>


      <div class="py-12 px-4 md:px-24">
        <a href="">Update</a>
      </div>

      <div class="md:py-24 py-12 px-12 md:px-24">
        <a href="">Populer</a>
      </div>
    </div>
  </div>
  
  
@endsection
