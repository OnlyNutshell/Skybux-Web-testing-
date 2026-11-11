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
<body class="m-0 overflow-hidden bg-transparent">

    <div id="live-overlay"
         class="fixed inset-0 z-[9999] flex items-start justify-center p-8 pointer-events-none">

        <div id="alert-card"
             class="w-full max-w-md rounded-2xl border border-sky-400/30
       bg-[#0D1726]/95 p-5 text-white shadow-2xl
       opacity-0 -translate-y-8
       transition-all duration-1200 ease-in-out">

            <div class="mb-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="h-2 w-2 rounded-full bg-sky-400"></div>
                    <span class="text-xs font-bold tracking-widest text-sky-300">
                        SKYBUX LIVE ALERT
                    </span>
                </div>

                <span id="alert-label"
                      class="rounded-full bg-sky-400/15 px-3 py-1
                             text-[10px] font-bold text-sky-300">
                    NEW ORDER
                </span>
            </div>

            <div class="flex items-center gap-4">
                <div id="alert-icon"
                     class="flex h-14 w-14 shrink-0 items-center justify-center
                            rounded-xl bg-sky-400/15 text-2xl">
                    🛒
                </div>

                <div class="min-w-0">
                    <h2 id="alert-title" class="text-lg font-extrabold">
                        Order Baru!
                    </h2>

                    <p id="alert-username" class="mt-1 text-sm text-slate-300">
                        Roblox: Player123
                    </p>

                    <p id="alert-amount"
                       class="mt-1 text-sm font-bold text-sky-300">
                        100 Robux
                    </p>
                </div>
            </div>

            <div class="mt-4 h-px bg-white/10"></div>

            <p id="alert-description"
               class="mt-3 text-xs text-slate-400">
                Terima kasih sudah melakukan order!
            </p>
        </div>
    </div>

    <script>
        function showAlert() {
        const card = document.getElementById('alert-card');

        requestAnimationFrame(() => {
            card.classList.remove('opacity-0', '-translate-y-8');
            card.classList.add('opacity-100', 'translate-y-0');
        });
    }

    function hideAlert() {
        const card = document.getElementById('alert-card');

        card.classList.remove('opacity-100', 'translate-y-0');
        card.classList.add('opacity-0', '-translate-y-8');
    }

    setTimeout(showAlert, 500);
    setTimeout(hideAlert, 3000);
    </script>

</body>

