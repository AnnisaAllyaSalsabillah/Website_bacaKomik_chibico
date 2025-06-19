<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'Chibico')</title>

  <!-- Tailwind CSS + DaisyUI -->
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.1/dist/full.css" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  @vite('resources/css/app.css')
  @vite('resources/js/app.js')

  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <style>
    body {
      background-color: #000000;
      color: #D7DAE1;
    }

    ::-webkit-scrollbar {
      width: 8px;
    }
    ::-webkit-scrollbar-thumb {
      background: #333;
      border-radius: 10px;
    }
    .modal {
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.3s ease;
    }
    .modal.show {
      opacity: 1;
      pointer-events: auto;
    }

  </style>
</head>
<body class="min-h-screen flex flex-col">

  <!-- Navbar -->
  <header class="shadow-sm">
    <div class="navbar container mx-auto">
      <div class="navbar-start">
        <a href="/" class="text-xl font-bold btn btn-ghost lg:ml-">Chibico</a>
      </div>

      <div class="navbar-center hidden sm:flex flex-wrap justify-center gap-2">
        <ul class="flex flex-wrap gap-2 px-1">
          <li><a class="btn btn-sm btn-ghost" href="{{ route('home') }}">Home</a></li>
          <li><a class="btn btn-sm btn-ghost" href="{{ route('explore') }}">Explore</a></li>
          <li><a class="btn btn-sm btn-ghost" href="{{ route('library') }}">Library</a></li>
          <li><a class="btn btn-sm btn-ghost" href="{{ route('user.search.index') }}">Search</a></li>
        </ul>
      </div>

      <div class="navbar-center sm:hidden">
        <div class="dropdown">
          <label tabindex="0" class="btn btn-ghost btn-circle">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </label>
          <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-48 z-[1]">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('explore') }}">Explore</a></li>
            <li><a href="{{ route('library') }}">Library</a></li>
            <li><a href="{{ route('user.search.index') }}">Search</a></li>
          </ul>
        </div>
      </div>

      <div class="navbar-end gap-2">
        

        <!-- Profile -->
        <div class="btn btn-ghost btn-circle avatar">
          <div class="w-10 rounded-full">
            @auth
              <a href="{{ route('user.profile.index') }}">
                @if(Auth::user()->profile_photo)
                  <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile">
                @else
                  <img src="{{ asset('/images/profile.png') }}" alt="Default Profile">
                @endif
              </a>
            @else
              <div tabindex="0" role="button" class="dropdown dropdown-end">
                <img src="{{ asset('/images/profile.png') }}" alt="Guest Profile" />
                <ul tabindex="0" class="mt-3 p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-60 z-[1]">
                  <li class="text-sm text-gray-700 px-2">Kamu belum login.</li>
                  <li><button onclick="showLoginPrompt()" class="text-left w-full text-blue-600">Login / Register</button></li>
                </ul>
              </div>
            @endauth
          </div>
        </div>

        <!-- Modal Login Prompt -->
        <div id="loginPrompt" class="modal hidden transition-opacity duration-200 fixed z-50 inset-0 bg-black bg-opacity-50 flex justify-center items-center">
          <div class="bg-white dark:bg-base-200 p-6 rounded-lg shadow-lg w-[90%] max-w-md text-center">
            <h2 class="text-lg font-semibold mb-2">Akses Ditolak</h2>
            <p class="mb-4 text-sm text-gray-600 dark:text-gray-300">Kamu harus login terlebih dahulu untuk mengakses fitur ini.</p>
            <div class="flex justify-center space-x-4">
              <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
              <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
            </div>
            <button onclick="hideLoginPrompt()" class="mt-4 text-xs text-gray-500 hover:underline">Batal</button>
          </div>
        </div>



      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main class="flex-grow container mx-auto py-5 px-4">
    @yield('content')
  </main>

  <!-- Footer -->
  <footer class="bg-base-200 text-center text-base-content py-4">
    <div class="container mx-auto">
      &copy; {{ date('Y') }} Chibico. All rights reserved.
    </div>
  </footer>

  <!-- Custom Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>
  <script>
  function showLoginPrompt() {
    const modal = document.getElementById('loginPrompt');
    modal.classList.add('show');
    modal.classList.remove('hidden');
  }
  function hideLoginPrompt() {
    const modal = document.getElementById('loginPrompt');
    modal.classList.remove('show');
    modal.classList.add('hidden');
  }
</script>


</body>
</html>
