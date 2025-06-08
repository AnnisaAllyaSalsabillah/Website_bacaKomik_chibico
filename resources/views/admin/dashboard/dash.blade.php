@extends('layouts.admin')

@section('content')
<!-- Navbar dengan animasi smooth -->
<div class="navbar bg-base-100 shadow-lg sticky top-0 z-50 transition-all duration-300">
  <!-- Logo Section -->
  <div class="navbar-start">
    <a class="btn btn-ghost text-xl md:text-2xl text-secondary font-bold hover:scale-105 transition-transform duration-200">
      Chibico
    </a>
  </div>
  <div class="navbar-end">
    <button class="btn btn-ghost text-white">
      <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="none" stroke="#d7dae1" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M16 17l5-5m0 0l-5-5m5 5H9" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M13 21H5a2 2 0 01-2-2V5a2 2 0 012-2h8" />
      </svg>

    </button>
  </div>
</div>

<!-- Main Content Area -->
<div class="min-h-screen bg-gradient-to-br from-base-200 to-base-300">
  <!-- Container dengan padding responsive -->
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
    
    <!-- Welcome Section -->
    <div class="mb-8 animate-fade-in">
      <div class="bg-gradient-to-r from-pink-500 to-purple-600 text-white p-6 lg:p-8 rounded-2xl shadow-xl">
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-2">
          Halo, Team Sky!
        </h1>
        <p class="text-sm sm:text-base lg:text-lg opacity-90">
          Komik? Chapter? Cover? Semua ada di bawah kendali kita!
        </p>
      </div>
    </div>

    <!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 mb-8">
  <!-- Total komik Card -->
  <div class="stat bg-base-100 shadow-lg rounded-2xl p-6 hover:shadow-xl transition-all duration-300 hover:scale-105">
    <div class="stat-figure text-primary">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-8 w-8 stroke-current">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
      </svg>
    </div>
    <div class="stat-title text-sm sm:text-base">Total Komik</div>
    <div class="stat-value text-primary text-2xl sm:text-3xl">{{ number_format($totalComics) }}</div>
  </div>

  <!-- Total chapters Card -->
  <div class="stat bg-base-100 shadow-lg rounded-2xl p-6 hover:shadow-xl transition-all duration-300 hover:scale-105">
    <div class="stat-figure text-secondary">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-8 w-8 stroke-current">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
      </svg>
    </div>
    <div class="stat-title text-sm sm:text-base">Total Chapter</div>
    <div class="stat-value text-secondary text-2xl sm:text-3xl">{{ number_format($totalChapters) }}</div>
  </div>

  <!-- Total users Card -->
  <div class="stat bg-base-100 shadow-lg rounded-2xl p-6 hover:shadow-xl transition-all duration-300 hover:scale-105 sm:col-span-2 lg:col-span-1">
    <div class="stat-figure text-secondary">
      <div class="stat-figure text-secondary">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          class="inline-block h-8 w-8 stroke-current"
          >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"
          ></path>
        </svg>
      </div>
      </div>
      <div class="stat-title text-sm sm:text-base">Total User</div>
      <div class="stat-value text-secondary text-2xl sm:text-3xl">{{ number_format($totalUser) }}</div>
    </div>
  </div>

    <!-- Quick Actions Section -->
<div class="mb-8">
  <h2 class="text-xl lg:text-2xl font-bold mb-4 text-base-content">Quick Actions</h2>
  <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 lg:gap-4">
    <a href="{{ route('admin.komiks.index') }}" class="btn btn-primary btn-lg flex-col h-auto py-4 hover:scale-105 transition-all duration-200">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
      </svg>
      <span class="text-xs sm:text-sm">Komik</span>
    </a>
    
    
    <a href="#" class="btn btn-secondary btn-lg flex-col h-auto py-4 hover:scale-105 transition-all duration-200">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
      </svg>
      <span class="text-xs sm:text-sm">Chapter</span>
    </a>
    
    <a href="{{ route('admin.genres.index') }}" class="btn btn-accent btn-lg flex-col h-auto py-4 hover:scale-105 transition-all duration-200">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
      </svg>
      <span class="text-xs sm:text-sm">Genre</span>
    </a>
    
    <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-info btn-lg flex-col h-auto py-4 hover:scale-105 transition-all duration-200">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 5v14l-4-4H7a2 2 0 01-2-2V11a2 2 0 012-2h5l4-4z" />
      </svg>
      <span class="text-xs sm:text-sm">Pengumuman</span>
    </a>
  </div>
</div>

    <!-- Top 5 Komik dengan Upvote Terbanyak Section -->
    <div class="mb-8">
      <h2 class="text-xl lg:text-2xl font-bold mb-6 text-base-content flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
        </svg>
        Top 5 Komik Terpopuler
      </h2>
      
      <div class="bg-base-100 rounded-2xl shadow-lg p-6 lg:p-8">
        @if($topUpvoteComics->count() > 0)
          <div class="grid gap-4">
            @foreach($topUpvoteComics as $index => $komik)
              <div class="flex items-center space-x-4 p-4 bg-base-200 rounded-xl hover:bg-base-300 transition-all duration-200 hover:scale-[1.02]">
                <!-- Ranking Badge -->
                <div class="flex-shrink-0">
                  <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-white
                    {{ $index == 0 ? 'bg-gradient-to-r from-yellow-400 to-yellow-600' : '' }}
                    {{ $index == 1 ? 'bg-gradient-to-r from-gray-400 to-gray-600' : '' }}
                    {{ $index == 2 ? 'bg-gradient-to-r from-orange-400 to-orange-600' : '' }}
                    {{ $index > 2 ? 'bg-gradient-to-r from-blue-400 to-blue-600' : '' }}
                  ">
                    @if($index == 0)
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l14 9-14 9V3z" />
                      </svg>
                    @else
                      {{ $index + 1 }}
                    @endif
                  </div>
                </div>

                <!-- Comic Cover (jika ada) -->
                <div class="flex-shrink-0">
                  <div class="w-16 h-20 bg-gradient-to-br from-primary/20 to-secondary/20 rounded-lg flex items-center justify-center overflow-hidden">
                    @if(isset($komik->cover_image) && $komik->cover_image)
                      <img src="{{ asset('storage/' . $komik->cover_image) }}" alt="{{ $komik->title }}" class="w-full h-full object-cover">
                    @else
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-base-content/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.168 18.477 18.582 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                      </svg>
                    @endif
                  </div>
                </div>

                <!-- Comic Info -->
                <div class="flex-1 min-w-0">
                  <h3 class="font-bold text-base sm:text-lg text-base-content truncate">{{ $komik->title }}</h3>
                  <p class="text-sm text-base-content/70 truncate">
                    @if(isset($komik->description))
                      {{ Str::limit($komik->description, 60) }}
                    @else
                      Deskripsi tidak tersedia
                    @endif
                  </p>
                  <div class="flex items-center mt-2 space-x-4">
                    <!-- Upvote Count -->
                    <div class="flex items-center space-x-1 text-red-500">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                      </svg>
                      <span class="text-sm font-semibold">{{ number_format($komik->upvotes_count) }}</span>
                    </div>
                    <!-- Chapter Count (jika ada relasi) -->
                    @if(isset($komik->chapters_count))
                      <div class="flex items-center space-x-1 text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="text-sm">{{ $komik->chapters_count ?? 0 }} Chapter</span>
                      </div>
                    @endif
                  </div>
                </div>

                <!-- Action Button -->
                <div class="flex-shrink-0">
                  <button class="btn btn-sm btn-circle btn-ghost hover:btn-primary transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                  </button>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <!-- Empty State -->
          <div class="text-center py-12">
            <div class="w-24 h-24 mx-auto mb-4 bg-base-200 rounded-full flex items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.168 18.477 18.582 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-base-content/70 mb-2">Belum ada komik</h3>
            <p class="text-sm text-base-content/50">Tambahkan komik pertama untuk melihat statistik upvote</p>
          </div>
        @endif
      </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="bg-base-100 rounded-2xl shadow-lg p-6 lg:p-8">
      <h2 class="text-xl lg:text-2xl font-bold mb-6 text-base-content">Aktivitas Terbaru</h2>
      <div class="space-y-4">
        <div class="flex items-center space-x-4 p-4 bg-base-200 rounded-lg hover:bg-base-300 transition-all duration-200">
          <div class="avatar">
            <div class="w-10 h-10 rounded-full bg-primary text-primary-content flex items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
              </svg>
            </div>
          </div>
          <div class="flex-1">
            <p class="font-semibold text-sm sm:text-base">Komik baru ditambahkan</p>
            <p class="text-xs sm:text-sm text-base-content/70">2 jam yang lalu</p>
          </div>
        </div>
        
        <div class="flex items-center space-x-4 p-4 bg-base-200 rounded-lg hover:bg-base-300 transition-all duration-200">
          <div class="avatar">
            <div class="w-10 h-10 rounded-full bg-secondary text-secondary-content flex items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
            </div>
          </div>
          <div class="flex-1">
            <p class="font-semibold text-sm sm:text-base">Pengumuman diperbarui</p>
            <p class="text-xs sm:text-sm text-base-content/70">5 jam yang lalu</p>
          </div>
        </div>
        
        <div class="flex items-center space-x-4 p-4 bg-base-200 rounded-lg hover:bg-base-300 transition-all duration-200">
          <div class="avatar">
            <div class="w-10 h-10 rounded-full bg-accent text-accent-content flex items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
            </div>
          </div>
          <div class="flex-1">
            <p class="font-semibold text-sm sm:text-base">User baru bergabung</p>
            <p class="text-xs sm:text-sm text-base-content/70">1 hari yang lalu</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Custom CSS untuk animasi -->
<style>
@keyframes fade-in {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fade-in 0.6s ease-out;
}

/* Smooth scrolling */
html {
  scroll-behavior: smooth;
}

/* Custom hover effects */
.hover-lift:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

/* Responsive text scaling */
@media (max-width: 640px) {
  .stat-value {
    font-size: 1.5rem;
  }
}

/* Enhanced mobile menu animation */
.dropdown-content {
  animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
@endsection