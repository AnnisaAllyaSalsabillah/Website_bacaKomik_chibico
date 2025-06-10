@extends('layouts.app')

@section('title', 'Hasil Pencarian')

@section('content')
<div class="bg-black text-[#D7DAE1] min-h-screen py-10">
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-semibold mb-4">Hasil pencarian untuk: <span class="text-blue-400">"{{ $query }}"</span></h1>

        @if($result->isEmpty())
            <p class="text-gray-400">Tidak ada komik yang cocok dengan pencarianmu.</p>
        @else
            <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-6 mt-6">
                @foreach($result as $comic)
                    <a href="{{ route('user.komiks.show', $comic->slug) }}"
                       class="bg-gray-900 hover:bg-gray-800 rounded-lg overflow-hidden shadow-md transition">
                        <img src="{{ $comic->thumbnail }}" alt="{{ $comic->title }}" class="w-full h-60 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold truncate">{{ $comic->title }}</h3>
                            <p class="text-sm text-gray-400">Author: {{ $comic->author }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
