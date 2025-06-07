<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel | @yield('title', 'Dashboard')</title>
  <style>
    body {
      background-color: #000000;
      color: #D7DAE1;
    }

    /* Scrollbar styling (optional) */
    ::-webkit-scrollbar {
      width: 8px;
    }
    ::-webkit-scrollbar-thumb {
      background: #333;
      border-radius: 10px;
    }
  </style>
</head>
<body class="min-h-screen font-sans">
  {{-- Main Layout --}}
  <div class="flex min-h-screen">
    {{-- Sidebar --}}
    <aside class="w-64 bg-base-100 border-r border-gray-800">
      <div class="p-4 text-xl font-bold border-b border-gray-700">Admin Panel</div>
      <ul class="menu p-4 text-sm text-[#D7DAE1]">
        <li><a class="{{ request()->is('admin/dashboard') ? 'active font-semibold' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li><a href="{{ route('admin.komiks.index') }}">Komik</a></li>
        <li><a href="{{ route('admin.chapters.index') }}">Chapter</a></li>
        <li><a href="{{ route('user.comment.index') }}">Komentar</a></li>
        
      </ul>
    </aside>

    {{-- Content --}}
    <main class="flex-1 p-6">
      @yield('content')
    </main>
  </div>
</body>
</html>
