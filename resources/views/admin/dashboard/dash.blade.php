@extends('layouts.admin')

@section('content')
<div class="navbar bg-base-100 shadow-lg sticky top-0 z-50 transition-all duration-300">
  <div class="navbar-start">
    <a class="btn btn-ghost text-xl md:text-2xl text-secondary font-bold hover:scale-105 transition-transform duration-200">
      Chibico
    </a>
  </div>
  <div class="navbar-end">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-ghost text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="none" stroke="#d7dae1" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 17l5-5m0 0l-5-5m5 5H9" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 21H5a2 2 0 01-2-2V5a2 2 0 012-2h8" />
            </svg>
        </button>
    </form>
  </div>
</div>

<div class="min-h-screen bg-gradient-to-br from-base-200 to-base-300">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
    
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

    
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 mb-8">
  <!-- Total komik -->
  <div class="stat bg-base-100 shadow-lg rounded-2xl p-6 hover:shadow-xl transition-all duration-300 hover:scale-105">
    <div class="stat-figure text-primary">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-8 w-8 stroke-current text-secondary">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
      </svg>
    </div>
    <div class="stat-title text-sm sm:text-base">Total Komik</div>
    <div class="stat-value text-secondary text-2xl sm:text-3xl">{{ number_format($totalComics) }}</div>
  </div>

  <!-- Total chapters -->
  <div class="stat bg-base-100 shadow-lg rounded-2xl p-6 hover:shadow-xl transition-all duration-300 hover:scale-105">
    <div class="stat-figure text-secondary">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-8 w-8 stroke-current">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
      </svg>
    </div>
    <div class="stat-title text-sm sm:text-base">Total Chapter</div>
    <div class="stat-value text-secondary text-2xl sm:text-3xl">{{ number_format($totalChapters) }}</div>
  </div>

  <!-- Total users -->
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

    <!-- Quick Actions -->
    <div class="mb-8">
      <h2 class="text-xl lg:text-2xl font-bold mb-4 text-base-content">Quick Actions</h2>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 lg:gap-4 mb-4">
        <a href="{{ route('admin.komiks.index') }}" class="btn btn-primary btn-lg flex-col h-auto py-4 hover:scale-105 transition-all duration-200">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
          <span class="text-xs sm:text-sm">Komik</span>
        </a>
        
        <a href="{{ route('admin.genres.index') }}" class="btn btn-accent btn-lg flex-col h-auto py-4 hover:scale-105 transition-all duration-200">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
          </svg>
          <span class="text-xs sm:text-sm">Genre</span>
        </a>
      </div>
      
      
      <div class="grid grid-cols-1">
        <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-info btn-lg flex-col h-auto py-4 hover:scale-105 transition-all duration-200">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 5v14l-4-4H7a2 2 0 01-2-2V11a2 2 0 012-2h5l4-4z" />
          </svg>
          <span class="text-xs sm:text-sm">Pengumuman</span>
        </a>
      </div>
    </div>
  </div>
</div>

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

html {
  scroll-behavior: smooth;
}

.hover-lift:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

@media (max-width: 640px) {
  .stat-value {
    font-size: 1.5rem;
  }
}

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