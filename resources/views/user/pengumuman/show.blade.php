@extends('layouts.app')

@section('title', $pengumuman->title)

@section('content')
<div class="bg-black text-[#D7DAE1] min-h-screen py-10">
    <div class="container mx-auto px-4 max-w-2xl">

        <!-- Thumbnail -->
        <div class="flex justify-center mb-6">
            <img src="{{ $pengumuman->thumbnail }}"
                alt="{{ $pengumuman->title }}"
                class="w-28 h-28 rounded-lg object-cover shadow-md ring-1 ring-blue-500 hover:scale-105 transition duration-200">
        </div>

        <!-- Judul -->
        <h1 class="text-3xl sm:text-4xl font-bold text-center mb-2 tracking-wide">{{ $pengumuman->title }}</h1>
        <p class="text-center text-sm text-gray-400 mb-6">
            <span class="italic">Dipublikasikan pada</span> {{ \Carbon\Carbon::parse($pengumuman->date)->format('d M Y') }}
        </p>

        <!-- Konten -->
        <div class="bg-[#1a1a2e]/80 backdrop-blur-sm p-6 rounded-lg shadow-md border border-gray-700 mb-10 text-gray-200">
            <div class="prose prose-invert max-w-none">
                {!! nl2br(e($pengumuman->content)) !!}
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="text-center">
            <a href="{{ route('user.pengumuman.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Pengumuman
            </a>
        </div>
    </div>
</div>
@endsection
