@extends('layouts.app')

@section('title', 'Pengumuman')

@section('content')
<div class="bg-black text-[#D7DAE1] min-h-screen py-10">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-6">Pengumuman</h1>
        <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 mb-6 text-sm font-medium text-blue-400 border border-blue-400 rounded hover:bg-blue-500 hover:text-white transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Home
        </a>

        <div class="flex flex-col gap-4">
            @forelse ($pengumuman as $item)
                <a href="{{ route('user.pengumuman.show', $item->id) }}" class="flex items-start bg-gray-900 hover:bg-gray-800 rounded-lg overflow-hidden shadow transition p-3">
                    <div class="w-24 h-24 p-2">
                        <img src="{{ $item->thumbnail }}" alt="{{ $item->title }}" class="w-full h-full object-cover rounded-md">
                    </div>
                    <div class="ml-4 flex-1">
                        <h2 class="text-lg font-semibold mb-1">{{ $item->title }}</h2>
                        <p class="text-sm text-gray-400 mb-2">{{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}</p>
                        <p class="text-sm text-gray-300 line-clamp-2">{{ Str::limit(strip_tags($item->content), 120) }}</p>
                    </div>
                </a>
            @empty
                <p class="text-gray-400 text-sm">Belum ada pengumuman.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
