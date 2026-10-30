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
    <body>
        @include('component.header')
        @include('component.banner')
        <div class="bg-[#FDFDFC] flex p-6 lg:p-8 min-h-screen">
            @include('component.element-bg-circle')
            
    


    <main class="relative mx-auto flex w-full max-w-3xl flex-col items-center gap-6">


        <div class="relative overflow-hidden rounded-2xl border border-sky-300/20 w-full bg-linear-to-br from-sky-200/15 via-sky-400/10 to-blue-600/20
            p-8 shadow-[0_0_40px_rgba(56,189,248,0.08)]
            backdrop-blur-xl">
            <div class="pointer-events-none absolute
                -bottom-20 left-1/2 h-40 w-3/4
                -translate-x-1/2 rounded-full
                bg-sky-400/20 blur-[70px]">
            </div>

            <div class="flex justify-between">
                <div>
    <label for="rupiah">Rupiah</label>
    <input
        id="rupiah"
        type="number"
        placeholder="17000"
    >
</div>

<div>
    <label for="robux">Robux</label>
    <input
        id="robux"
        type="number"
        placeholder="100"
    >
</div>
            </div>

            <section class="rounded-2xl border border-white/10
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
                            class="break-words text-xl font-bold"></h2>

                        <p id="usernameResult"
                           class="mt-1 break-words text-sm text-gray-400">
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

                    <div class="flex justify-between gap-4">
                        <span class="text-gray-400">Verified badge</span>
                        <span id="verifiedBadge"
                              class="text-right"></span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-gray-400">Usia 18+</span>
                        <span id="ageStatus"
                              class="max-w-[60%] text-right text-amber-300">
                        </span>
                    </div>

                    <div>
                        <p class="mb-1 text-gray-400">Deskripsi</p>
                        <p id="description"
                           class="whitespace-pre-wrap break-words
                                  leading-6 text-gray-300"></p>
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
        </p>

            <p class="text-sm font-medium text-sky-300">
                NEXT GENERATION
            </p>

            <h1 class="mt-3 text-4xl font-bold tracking-tight">
                Build Beyond
                <span class="text-sky-300">Limits.</span>
            </h1>

            <p class="mt-4 text-gray-400">
                Clean design. Powerful technology.
            </p>

            <button class="mt-6 rounded-xl bg-sky-300
                px-5 py-3 font-semibold text-[#080B12]
                transition hover:bg-sky-200">
                Get Started
            </button>

            </div>
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
