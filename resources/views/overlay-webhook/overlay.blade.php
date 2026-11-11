
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Skybux') }}</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="m-0 overflow-hidden bg-transparent">

    <div id="live-overlay"
         class="fixed inset-0 z-[9999] flex items-start justify-center
                bg-transparent p-10 pointer-events-none">

        <div id="alert-card"
             class="relative mt-20 ml-24
                    w-[850px] max-w-[calc(100vw-8rem)]
                    rounded-[4rem]
                    border-[5px] border-black
                    bg-sky-700
                    px-12 py-12 pl-[270px]
                    text-white
                    shadow-[0_25px_80px_rgba(0,0,0,0.5)]
                    opacity-100 translate-y-0
                    transition-all duration-700 ease-in-out">

            <!-- MASKOT -->
            <img
                src="{{ asset('img/masuk-icon.png') }}"
                alt="Skybux Mascot"
                class="absolute
                       -left-[198px] top-[172px]
                       z-20
                       h-[500px] w-[500px]
                       -translate-y-1/2
                       object-contain
                       drop-shadow-2xl"
            >

            <!-- CONTENT -->
            <div class="relative z-10">

                <!-- TITLE -->
                <h2 id="alert-title"
                    class="text-[64px] leading-tight
                           tracking-wide font-black">
                    ORDER BARU!
                </h2>

                <!-- USERNAME -->
                <p id="alert-username"
                   class="mt-5 text-[36px] font-extrabold">
                    Player123
                </p>

                <!-- AMOUNT -->
                <p id="alert-amount"
                   class="mt-3 text-[32px] font-black text-sky-200">
                    100 Robux
                </p>

                <!-- DIVIDER -->
                <div class="my-6 h-[3px] bg-white/50"></div>

                <!-- DESCRIPTION -->
                <p id="alert-description"
                   class="text-[23px] font-semibold leading-relaxed">
                    Pesanan masuk, mohon ditunggu yaaaaaa!
                </p>

            </div>

            <!-- DECORATION -->
            <div class="pointer-events-none absolute
                        right-8 top-8 h-32 w-32
                        rounded-full bg-sky-300/20 blur-3xl">
            </div>

        </div>
    </div>

    <!-- <script>
        function testSkybuxAlert(type = 'order') {
            const card = document.getElementById('alert-card');

            clearTimeout(window.skybuxAlertTimeout);

            card.classList.remove('opacity-100', 'translate-y-0');
            card.classList.add('opacity-0', '-translate-y-12');

            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    card.classList.remove('opacity-0', '-translate-y-12');
                    card.classList.add('opacity-100', 'translate-y-0');
                });
            });

            window.skybuxAlertTimeout = setTimeout(() => {
                card.classList.remove('opacity-100', 'translate-y-0');
                card.classList.add('opacity-0', '-translate-y-12');
            }, 5000);
        }
    </script> -->

</body>
</html>
