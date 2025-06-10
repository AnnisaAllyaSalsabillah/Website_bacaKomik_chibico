@extends('layouts.app')

@section('title', 'Pengumuman')

@section('content')
<div class="bg-black text-[#D7DAE1] min-h-screen py-10">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-6">Pengumuman</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($pengumuman as $item)
                <a href="{{ route('user.pengumumans.show', $item->id) }}" class="bg-gray-900 rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                    <img src="{{ $item->thumbnail }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-semibold mb-2">{{ $item->title }}</h2>
                        <p class="text-gray-400 text-sm mb-2">{{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}</p>
                        <p class="text-gray-300 text-sm line-clamp-3">{{ Str::limit(strip_tags($item->content), 100) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
