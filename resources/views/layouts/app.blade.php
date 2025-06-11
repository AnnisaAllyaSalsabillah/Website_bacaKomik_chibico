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
  </style>
</head>
<body class="min-h-screen flex flex-col">

  <!-- Navbar -->
  <header class="shadow-sm bg-base-100">
    <div class="navbar container mx-auto">
      <div class="navbar-start">
        <a href="/" class="text-xl font-bold btn btn-ghost lg:ml-">Chibico</a>
      </div>

      <!-- Menu Tengah: hanya tampil di layar sm ke atas -->
      <div class="navbar-center hidden sm:flex flex-wrap justify-center gap-2">
        <ul class="flex flex-wrap gap-2 px-1">
          <li><a class="btn btn-sm btn-ghost" href="{{ route('home') }}">Home</a></li>
          <li><a class="btn btn-sm btn-ghost" href="{{ route('explore') }}">Explore</a></li>
          <li><a class="btn btn-sm btn-ghost" href="{{ route('library') }}">Library</a></li>
          <li><a class="btn btn-sm btn-ghost" href="{{ route('user.search.index') }}">Search</a></li>
        </ul>
      </div>

      <!-- Menu Hamburger: hanya tampil di layar kecil -->
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
        <!-- Search Form -->
        <form class="hidden md:flex gap-2" role="search">
          <input
            type="text"
            placeholder="Search Komik"
            class="input input-bordered w-32 md:w-40 focus:w-64 transition-all duration-300 ease-in-out"
          />
        </form>

        <!-- Profile -->
        <div class="dropdown dropdown-end">
          <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
            <div class="w-10 rounded-full">
              <img src="/images/profile.png" alt="Profile" />
            </div>
          </div>
          <ul class="mt-3 p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-48 z-[1] ml-4 ">
            <li><a>Profile</a></li>
            <li><a>Logout</a></li>
          </ul>
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
  
</body>
</html>
