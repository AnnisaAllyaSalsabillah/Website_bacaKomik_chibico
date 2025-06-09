@extends('layouts.app')

@section('content')
<div class="bg-gray-900 min-h-screen text-white py-10 px-4">
  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">

    <!-- Cover Komik -->
    <div>
      <img src="{{ asset('storage/' . $comic->cover) }}" alt="{{ $comic->title }}" class="w-full rounded-xl shadow-md">
    </div>

    <!-- Info Komik -->
    <div class="md:col-span-2">
      <h1 class="text-4xl font-bold mb-2">{{ $comic->title }}</h1>
      <p class="text-sm text-gray-400 mb-4">{{ $comic->genres->pluck('name')->join(', ') }} | Status: {{ $comic->status }}</p>
      <p class="text-gray-300 leading-relaxed mb-6">{{ $comic->description }}</p>

      <a href="{{ route('comic.read', [$comic->slug, $comic->chapters->first()->number]) }}" class="inline-block bg-blue-600 hover:bg-blue-500 px-6 py-2 rounded-lg font-semibold text-white">Mulai Baca</a>
    </div>
  </div>

  <!-- Daftar Chapter -->
  <div class="max-w-6xl mx-auto mt-10">
    <h2 class="text-2xl font-semibold mb-4">Daftar Chapter</h2>
    <ul class="space-y-3">
      @foreach($comic->chapters->sortByDesc('number') as $chapter)
      <li>
        <a href="{{ route('comic.read', [$comic->slug, $chapter->number]) }}" class="block bg-gray-800 hover:bg-gray-700 px-4 py-3 rounded-lg transition">
          Chapter {{ $chapter->number }} - {{ $chapter->title }}
        </a>
      </li>
      @endforeach
    </ul>
  </div>

</div>
@endsection
