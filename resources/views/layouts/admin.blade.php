<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin — Komite SPKN BPK RI')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="d-flex">

    @include('partials.sidebar-admin')

    <div class="flex-grow-1 p-4">
        @include('partials.alert-messages')
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>