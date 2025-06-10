@extends('layouts.app')

@section('title', $pengumuman->title)

@section('content')
<div class="bg-black text-[#D7DAE1] min-h-screen py-10">
    <div class="container mx-auto px-4 max-w-3xl">
        <div class="mb-8">
            <img src="{{ $pengumuman->thumbnail }}" alt="{{ $pengumuman->title }}" class="w-full rounded-lg shadow">
        </div>

        <h1 class="text-3xl font-bold mb-4">{{ $pengumuman->title }}</h1>
        <p class="text-sm text-gray-400 mb-6">
            Dipublikasikan pada {{ \Carbon\Carbon::parse($pengumuman->date)->format('d M Y') }}
        </p>

        <div class="prose max-w-none text-gray-200 prose-invert">
            {!! nl2br(e($pengumuman->content)) !!}
        </div>

        <div class="mt-10">
            <a href="{{ route('user.pengumumans.index') }}" class="text-blue-400 hover:underline">&larr; Kembali ke daftar pengumuman</a>
        </div>
    </div>
</div>
@endsection
