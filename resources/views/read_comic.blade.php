@extends('layouts.app')

@section('content')
<div class="bg-gray-900 min-h-screen text-white py-6 px-4">
  <div class="max-w-4xl mx-auto">
    <!-- Judul & Navigasi Chapter -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">{{ $comic->title }} - Chapter {{ $chapter->number }}</h1>
      <div class="space-x-2">
        @if($prevChapter)
        <a href="{{ route('comic.read', [$comic->slug, $prevChapter->number]) }}" class="bg-gray-700 hover:bg-gray-600 px-3 py-1 rounded">⬅ Sebelumnya</a>
        @endif

        @if($nextChapter)
        <a href="{{ route('comic.read', [$comic->slug, $nextChapter->number]) }}" class="bg-gray-700 hover:bg-gray-600 px-3 py-1 rounded">Selanjutnya ➡</a>
        @endif
      </div>
    </div>

    <!-- Gambar Halaman Komik -->
    <div class="space-y-4">
      @foreach($chapter->images as $image)
      <img src="{{ asset('storage/' . $image->file_path) }}" alt="Halaman" class="w-full rounded-lg shadow">
      @endforeach
    </div>

    <!-- Navigasi Bawah -->
    <div class="flex justify-between items-center mt-10">
      @if($prevChapter)
      <a href="{{ route('comic.read', [$comic->slug, $prevChapter->number]) }}" class="bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded">⬅ Chapter Sebelumnya</a>
      @endif

      @if($nextChapter)
      <a href="{{ route('comic.read', [$comic->slug, $nextChapter->number]) }}" class="bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded">Chapter Selanjutnya ➡</a>
      @endif
    </div>
  </div>
</div>
@endsection
