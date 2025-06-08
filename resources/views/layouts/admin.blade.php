<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel | @yield('title', 'Dashboard')</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

 @vite('resources/css/app.css')
 @vite('resources/js/app.js')

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
    

    {{-- Content --}}
    <main class="flex-1 p-6">
      @yield('content')
    </main>
  </div>
</body>
</html>
