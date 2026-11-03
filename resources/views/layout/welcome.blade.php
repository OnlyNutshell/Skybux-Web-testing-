<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/rate-converter.js'])
    @vite(['resources/css/app.css', 'resources/js/validate-account.js'])

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
        </style>
    @endif
</head>
<body class="pb-6 bg-sky-500/20 backdrop-blur-[140px]">

    <!-- Header -->
    @include('component.header')

    <!-- Banner Di tengah -->
    @include('component.banner')

    <!-- Layout Metode Pembayaran -->
    <section id="metodePembayaranSection" class="bg-sky-900 text-white mx-4 sm:mx-8 xl:mx-32 mt-7 mb-5 px-4 sm:px-6 py-5 rounded-2xl flex flex-col xl:flex-row xl:gap-25 xl:items-center gap-5">
        <div class="flex items-center gap-3 shrink-0">
            <i data-lucide="shield-check" class="w-9 h-9 shrink-0 text-sky-300"></i>
            <h2 class="text-sm text-white font-bold sm:text-base">
                Metode Pembayaran <br>
                Lengkap dan Mudah
            </h2>
        </div>

        @include('component.metode-pembayaran-icon')

    </section>

    <div class="sm:mx-8 lg:p-6 px-6 py-4 mx-4 xl:mx-32 rounded-2xl mb-5 bg-sky-900 border-black">
        <h1 class=" text-white font-bold lg:text-2xl text-xl">Top Up Instant Robux Via Username</h1>
        <h2 class="sm:text-xl text-sm text-slate-500">Harga Rp 160 per Robux. Pilih satu nominal, lalu lengkapi data di kotak pesanan.</h2>
    </div>

    <!-- Store Form Section -->
    <section class=" flex mx-4 sm:mx-8 xl:mx-32">

    @include('component.element-bg-circle')
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="relative flex lg:col-span-2 min-w-0 flex-col items-center">
            <div class="relative overflow-hidden rounded-2xl w-full bg-sky-900 p-6">
            
            <div class="flex justify-between items-baseline-last mb-5">
                <h2 class="text-l text-white font-bold sm:text-xl">Pilih Nominal Robux</h2>
                <div class="flex justify-between items-center bg-green-500/50 text-green-400 gap-2 px-4 py-1.5 rounded-2xl">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <p class="text-xs">
                        IN STOCK
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">
                <div class="flex h-15 items-center gap-3 rounded-2xl border border-slate-300 bg-white px-4">

                    <label for="rupiah"
                        class="shrink-0 text-lg text-slate-700">
                        Rp
                    </label>

                    <input
                        id="rupiah"
                        type="number"
                        placeholder="Enter Robux price"
                        class="min-w-0 w-full border-0 bg-transparent
                            text-base text-slate-800 outline-none
                            placeholder:text-slate-500
                            focus:ring-0"
                    >
                </div>

                <div class="flex h-15 items-center gap-3 rounded-2xl
                            border border-slate-300 bg-white px-4">

                    <label for="robux"
                        class="min-w-0 text-lg text-slate-700">
                        RBX
                    </label>

                    <input
                        id="robux"
                        type="number"
                        placeholder="Enter Robux Amount"
                        class="min-w-0 w-full border-0 bg-transparent
                            text-base text-slate-800 outline-none
                            placeholder:text-slate-500
                            focus:ring-0"
                    >
                </div>
            </div>

            <div class="flex items-center my-4 gap-4">
                <div class=" flex-1 dotted-divider"></div>

                <span class="text-sm shrink-0 text-white">Atau Pilih Diantara Ini</span>

                <div class=" flex-1 dotted-divider"></div>
            </div>

            <div class="grid grid-cols-3 lg:grid-cols-4 gap-5">
                @foreach ($robux as $item)
                    @include('component.robux-item-card', ['item' => $item])
                @endforeach
            </div>
                </div>
        
        </div>
        <div class="min-w-0 h-fit"><section class="rounded-2xl border border-white/10
                            bg-[#171422] p-5 shadow-xl sm:p-7">

                    <div class="space-y-4">
                        <label for="username"
                            class="block text-sm font-medium text-gray-200">
                            Username Roblox
                        </label>

                        <input
                            id="username"
                            name="username"
                            type="text"
                            minlength="3"
                            maxlength="20"
                            pattern="[A-Za-z0-9_]+"
                            autocomplete="off"
                            placeholder="Ketik username Roblox..."
                            class="w-full rounded-xl border border-white/10
                                bg-[#0D0B16] px-4 py-3 text-white
                                outline-none transition
                                placeholder:text-gray-600
                                focus:border-violet-400 focus:ring-2
                                focus:ring-violet-400/20"
                        >

                        <p class="text-xs text-gray-500">
                            Gunakan username, bukan display name.
                        </p>

                        <p id="status"
                        role="status"
                        aria-live="polite"
                        class="hidden text-sm text-gray-400">
                        </p>

                        <div id="choicesWrapper" class="hidden">
                            <label for="accountChoices"
                                class="mb-2 block text-sm font-medium text-gray-200">
                                Pilih akun Roblox
                            </label>

                            <select
                                id="accountChoices"
                                class="w-full rounded-xl border border-white/10
                                    bg-[#171422] px-4 py-3 text-white
                                    outline-none focus:border-violet-400"
                            >
                                <option value="">Pilih akun...</option>
                            </select>
                        </div>
                    </div>

                    <div id="profile"
                        class="mt-5 hidden rounded-xl border text-white
                                border-white/10 bg-[#0D0B16] p-5">

                        <img
                            id="avatarImage"
                            src=""
                            alt="Avatar Roblox"
                            class="h-16 w-16 rounded-2xl border border-white/10
                                bg-white/5 object-cover"
                        />

                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <h2 id="displayName"
                                    class="wrap-break-word text-xl font-bold"></h2>

                                <p id="usernameResult"
                                class="mt-1 wrap-break-word text-sm text-gray-400">
                                </p>
                            </div>

                            <span id="accountStatus"
                                class="shrink-0 rounded-full bg-emerald-400/10
                                        px-3 py-1 text-xs font-medium
                                        text-emerald-300">
                                Ditemukan
                            </span>
                        </div>

                        <div class="mt-5 space-y-3 text-sm">
                            <div class="flex justify-between gap-4">
                                <span class="text-gray-400">User ID</span>
                                <span id="userId"
                                    class="break-all text-right"></span>
                            </div>
                        </div>

                        <a id="profileLink"
                            href="#"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="mt-5 inline-flex rounded-lg border
                            border-white/10 px-4 py-2 text-sm
                            font-medium transition hover:bg-white/5">
                            Buka profil Roblox ↗
                        </a>
                    </div>
            </section>

            <p class="mt-5 text-xs leading-5 text-gray-500">
                Data profil mengikuti informasi yang disediakan Roblox.
                Verified badge bukan bukti usia 18+. Status verifikasi usia
                tidak tersedia melalui pemeriksaan publik ini.
            </p></div>
    </div>
        

        </main>
    </div>
</body>

</html>

<script>
    window.robloxChecker = {
        searchUrl: @json(route('roblox.search')),
        userUrl: @json(url('/roblox-checker/users'))
    };
</script>

@vite(['resources/css/app.css', 'resources/js/validate-account.js'])
