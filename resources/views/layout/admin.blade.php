
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') | Skybux</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50">

    {{-- Sidebar --}}
    @include('component.admin-sidebar')

    {{-- Main Content --}}
    <main class="ml-64 min-h-screen px-8 py-8">

        @yield('content')

    </main>

    {{-- Scripts --}}
    @stack('scripts')

    <div
        id="roblox-config"
        data-search-url="{{ route('roblox.search') }}"
        data-user-url="{{ url('/roblox-checker/users') }}">
    </div>

</body>
</html>
