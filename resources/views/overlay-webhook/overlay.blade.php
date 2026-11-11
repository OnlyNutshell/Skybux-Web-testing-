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

    <div
        id="live-overlay"
        class="fixed w-full inset-0 z-[9999] flex items-start justify-center
               bg-transparent p-8 pointer-events-none"
    >
 <div
        id="alert-card"
        class="relative mt-16 ml-16 w-[520px] max-w-[calc(100vw-5rem)]
               rounded-[4rem] border border-black border-3
               bg-sky-700 px-6 py-6 pl-39
               text-white shadow-[0_15px_50px_rgba(0,0,0,0.4)]
               opacity-100 translate-y-0
               transition-all duration-500 ease-out"
    >

        <!-- MASKOT OVERFLOW -->
        <img
            src="{{ asset('img/Masuk-icon.png') }}"
            alt="Skybux Mascot"
            class="absolute -left-30 top-[90px] z-20
                   h-70 w-70 -translate-y-1/2
                   object-contain drop-shadow-2xl"
        >

        <!-- CONTENT -->
        <div class="relative z-10">

            <!-- TITLE -->
            <div class="flex items-center gap-2">
                <h2
                    id="alert-title"
                    class="text-5xl tracking-[0.1rem] font-extrabold"
                >
                    Order Baru!
                </h2>
            </div>

            <!-- USERNAME -->
            <p
                id="alert-username"
                class="mt-2 ml-2 text-2xl font-bold text-white"
            >
                Player123
            </p>

            <!-- AMOUNT -->
            <p
                id="alert-amount"
                class="mt-1 ml-2 text-xl font-bold text-white"
            >
                100 Robux
            </p>

            <!-- DIVIDER -->
            <div class="my-3 h-px bg-white"></div>

            <!-- DESCRIPTION -->
            <p
                id="alert-description"
                class="text-l ml-2 leading-relaxed text-white"
            >
                Pesanan masuk, mohon ditunggu yaaaaaa! 
            </p>

        </div>

        <!-- DECORATION -->
        <div
            class="pointer-events-none absolute right-5 top-5
                   h-16 w-16 rounded-full bg-sky-400/10 blur-2xl"
        ></div>

    </div>
</div>

    <!-- <div id="live-overlay"
         class="fixed inset-0 bg-black w-full z-[9999] flex items-start justify-center p-18 pointer-events-none">

        <div id="alert-card"
             class="w-1/3 rounded-2xl border border-sky-400/30
       bg-[#0D1726]/95 p-5 text-white shadow-2xl
       opacity-100 translate-y-0
       ">

            <div class="flex items-center gap-4">
                <img src="{{ asset('img/Masuk-icon.png') }}"  class="absolute bg-transparent" alt="" srcset="">
                <div id="alert-icon"
                     class="flex h-14 w-14 shrink-0 items-center justify-center
                            rounded-xl bg-sky-400/15 text-2xl">
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
    </div> -->

    <!-- <script>
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
    </script> -->

</body>

