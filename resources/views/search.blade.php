@extends('layouts.app')

@section('content')
<div class="bg-gray-900 min-h-screen text-white py-8 px-4">
  <div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Cari Komik</h1>

    <!-- Form Pencarian -->
    <form action="{{ route('search') }}" method="GET" class="mb-8">
      <input type="text" name="q" placeholder="Masukkan judul komik..." value="{{ request('q') }}"
        class="w-full md:w-1/2 px-4 py-3 rounded-lg text-black focus:outline-none" />
    </form>

    <!-- Hasil Pencarian -->
    @if($comics->count())
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
      @foreach($comics as $comic)
      <a href="{{ route('comic.detail', $comic->slug) }}" class="bg-gray-800 hover:bg-gray-700 rounded-lg overflow-hidden shadow-md transition">
        <img src="{{ asset('storage/' . $comic->cover) }}" alt="{{ $comic->title }}" class="w-full h-64 object-cover">
        <div class="p-4">
          <h2 class="font-semibold text-lg leading-tight truncate">{{ $comic->title }}</h2>
          <p class="text-sm text-gray-400 mt-1">{{ $comic->genres->pluck('name')->join(', ') }}</p>
        </div>
      </a>
      @endforeach
    </div>
    @else
    <p class="text-gray-400">Tidak ada komik yang ditemukan untuk kata kunci: <strong>{{ request('q') }}</strong></p>
    @endif
  </div>
</div>
@endsection
