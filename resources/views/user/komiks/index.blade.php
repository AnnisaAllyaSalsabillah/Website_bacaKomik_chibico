@extends('layouts.app')

@section('title', 'Daftar Komik')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Daftar Komik</h1>
            <p class="text-gray-600">Temukan komik favorit Anda dari koleksi terlengkap</p>
        </div>

        <!-- Search & Filter Section (Optional) -->
        <div class="mb-8 bg-white rounded-lg shadow-sm p-6">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" placeholder="Cari komik..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="sm:w-48">
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Genre</option>
                        <option value="action">Action</option>
                        <option value="romance">Romance</option>
                        <option value="comedy">Comedy</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Comics Grid -->
        @if($komiks->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6 mb-8">
                @foreach($komiks as $comic)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden group">
                        <!-- Comic Cover -->
                        <div class="relative aspect-[3/4] overflow-hidden">
                            @if($comic->cover)
                                <img src="{{ asset('storage/' . $comic->cover) }}" 
                                     alt="{{ $comic->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Overlay dengan info tambahan -->
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-end">
                                <div class="w-full p-3 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <p class="text-white text-sm font-medium">{{ $comic->chapters_count ?? 0 }} Chapter</p>
                                </div>
                            </div>
                        </div>

                        <!-- Comic Info -->
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                <a href="{{ route('user.komiks.show', $comic->slug) }}">
                                    {{ $comic->title }}
                                </a>
                            </h3>
                            
                            <!-- Author -->
                            @if($comic->author)
                                <p class="text-sm text-gray-600 mb-2">{{ $comic->author }}</p>
                            @endif

                            <!-- Genres -->
                            @if($comic->genres->count() > 0)
                                <div class="flex flex-wrap gap-1 mb-3">
                                    @foreach($comic->genres->take(2) as $genre)
                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                            {{ $genre->name }}
                                        </span>
                                    @endforeach
                                    @if($comic->genres->count() > 2)
                                        <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">
                                            +{{ $comic->genres->count() - 2 }}
                                        </span>
                                    @endif
                                </div>
                            @endif

                            <!-- Rating & Status -->
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <div class="flex items-center">
                                    @if($comic->rating)
                                        <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        <span>{{ number_format($comic->rating, 1) }}</span>
                                    @endif
                                </div>
                                
                                @if($comic->status)
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $comic->status === 'ongoing' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($comic->status) }}
                                    </span>
                                @endif
                            </div>

                            <!-- Updated date -->
                            <div class="mt-2 text-xs text-gray-400">
                                Update: {{ $comic->updated_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $komiks->links('pagination::tailwind') }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada komik</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada komik yang tersedia saat ini.</p>
            </div>
        @endif
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection