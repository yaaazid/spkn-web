<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Komite SPKN BPK RI')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    {{-- Navbar sengaja ditaruh di sini (langsung anak <body>), BUKAN di dalam
         hero.blade.php. Navbar posisinya fixed + perlu selalu di atas semua
         section lain; kalau nested di dalam elemen yang punya isolation/transform
         (spt .spkn-hero), dia bisa "kejebak" di stacking context itu dan malah
         ketutup section lain yang render setelahnya. Taruh di sini paling aman. --}}
    @include('partials.navbar.navbar')

    @yield('content')

    @include('partials.footer')

    @stack('scripts')
</body>
</html>