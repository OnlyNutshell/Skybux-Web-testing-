<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    @else
        <style>
        </style>
    @endif
</head>
<body class="pb-6 bg-sky-500/20 backdrop-blur-[140px]">

    <!-- Header -->
    @section('navbar')
        @include('component.header')
    @show
    
    @yield('content')

    @stack('scripts')

    <div id="roblox-config" data-search-url="{{ route('roblox.search') }}" data-user-url="{{ url('/roblox-checker/users') }}"></div>
</body>

</html>