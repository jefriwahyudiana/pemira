<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Pemira 2025' }}</title>
    <link rel="icon" href="{{ asset('images/pemira.png') }}" type="image/x-icon">
    <script src="//unpkg.com/alpinejs" defer></script>
@php
    $isProduction = app()->environment('production');
    $manifestPath = public_path('build/manifest.json');
@endphp

@if ($isProduction && file_exists($manifestPath))
    @php
        $manifest = json_decode(file_get_contents($manifestPath), true);
    @endphp

    {{-- Load CSS --}}
    @if (isset($manifest['resources/css/app.css']))
        <link rel="stylesheet" href="{{ url('build/' . $manifest['resources/css/app.css']['file']) }}">
    @endif

    {{-- Load JS --}}
    @if (isset($manifest['resources/js/app.js']))
        <script type="module" src="{{ url('build/' . $manifest['resources/js/app.js']['file']) }}"></script>
    @endif
@else
    {{-- Development Mode --}}
    @viteReactRefresh
    @vite(['resources/js/app.js', 'resources/css/app.css'])
@endif
    @livewireStyles <!-- Tambahkan ini untuk Livewire -->
</head>
<body class="bg-gradient-to-r from-orange-200 to-blue-200 flex items-center justify-center min-h-screen">
    @yield('content')
    <main>
        @yield('livechart')
    </main>
    @livewireScripts <!-- Tambahkan ini untuk Livewire -->
    @vite('resources/js/app.js') <!-- Pastikan ini ada untuk Vite -->
    @stack('js')
</body>
</html>