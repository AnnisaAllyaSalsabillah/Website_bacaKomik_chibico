@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-black text-mischka p-6">
  <!-- Top Navigation -->
  <div class="flex justify-between items-center mb-6">
    <ul class="flex gap-8 text-sm font-semibold">
      <li><a class="text-pink-500 border-b-2 border-pink-500 pb-1" href="#">Dashboard</a></li>
      <li><a href="{{ route('admin.komiks.index') }}">Komik</a></li>
      <li><a href="#">Pengumuman</a></li>
    </ul>
    
  </div>

  <!-- Stats Panel -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-gray-900 p-4 rounded-xl flex items-center justify-between">
      <div>
        <div class="text-sm">Total Likes</div>
        <div class="text-2xl font-bold text-blue-400">25.6K</div>
      </div>
      <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 9l-3 6h4l-3 6"></path></svg>
    </div>
    <div class="bg-gray-900 p-4 rounded-xl flex items-center justify-between">
      <div>
        <div class="text-sm">Page Views</div>
        <div class="text-2xl font-bold text-pink-500">2.6M</div>
      </div>
      <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m0-4h.01"></path></svg>
    </div>
    <div class="bg-gray-900 p-4 rounded-xl flex items-center justify-between">
      <div>
        <div class="text-sm">Users</div>
        <div class="text-2xl font-bold text-mischka">4,200</div>
      </div>
      <svg class="w-6 h-6 text-mischka" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m0 4h.01M12 6v2m0 4h.01"/></svg>
    </div>
  </div>

  <!-- Top Comics -->
  <div class="bg-gray-900 rounded-xl p-4">
    <h2 class="text-lg font-semibold mb-4">Top 5 Komik dengan Upvote Terbanyak</h2>
    <div class="space-y-4">
      @foreach($topUpvoteComics as $index => $komik)
      <div class="flex items-center gap-4">
        <div class="text-3xl font-extrabold opacity-30 w-10">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
        <img src="{{ $komik->cover_image }}" alt="{{ $komik->title }}" class="w-12 h-12 object-cover rounded-xl">
        <div>
          <div class="font-semibold">{{ $komik->title }}</div>
          <div class="text-xs text-mischka uppercase">{{ $komik->author ?? '-' }}</div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
