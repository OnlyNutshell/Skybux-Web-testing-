@extends('layout.welcome')

@include('component.header')

@section('content')
@if (session('success'))
    <div
        id="success-toast"
        class="fixed right-5 top-5 z-9999 flex items-center gap-3 rounded-xl border border-green-200 bg-white px-5 py-4 shadow-xl shadow-green-900/10 transition-all duration-500"
    >
        <div class="flex size-9 shrink-0 items-center justify-center rounded-full bg-green-100 text-green-600">
            <i data-lucide="check-circle" class="size-5"></i>
        </div>

        <div>
            <p class="text-sm font-semibold text-gray-900">Berhasil!</p>
            <p class="text-xs text-gray-500">{{ session('success') }}</p>
        </div>

        <button
            type="button"
            onclick="document.getElementById('success-toast').remove()"
            class="ml-3 text-gray-400 transition hover:text-gray-700"
        >
            <i data-lucide="x" class="size-4"></i>
        </button>
    </div>

    <script>
        setTimeout(() => {
            const toast = document.getElementById('success-toast');

            if (toast) {
                toast.classList.add('opacity-0', 'translate-x-5');

                setTimeout(() => toast.remove(), 500);
            }
        }, 4000);
    </script>
@endif

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
        <h2 class="sm:text-xl text-sm text-slate-300">Harga Rp 160 per Robux. Pilih satu nominal, lalu lengkapi data di kotak pesanan.</h2>
    </div>

    <!-- Store Form Section -->
    <section class="mx-4 mb-4 sm:mx-8 xl:mx-32">
    
    <div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-8">
        <div class="relative flex lg:col-span-2 min-w-0 mb-5 lg:mb-0 flex-col items-center">
            <div class="relative overflow-hidden rounded-2xl w-full bg-sky-900 p-6">
            <div class="flex justify-between items-baseline-last mb-5">
                <h2 class="text-l text-white font-bold sm:text-xl">Custom Robux atau Budget sesuai keinginan</h2>
                <div class="flex justify-between items-center bg-green-500/50 text-green-400 gap-2 px-4 py-1.5 rounded-2xl">
                    <i data-lucide="check" class="w-4 h-4"></i>

                    <span id="stock" class="tabular-nums">
                        <span class="inline-block animate-pulse">memuat...</span>
                    </span>
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
                        type="text"
                        inputmode="numeric"
                        autocomplete="off"
                        placeholder="Sesuaikan Budget"
                        class="converter-value min-w-0 w-full border-0 bg-transparent
                            text-base font-semibold placeholder:font-normal text-slate-800 outline-none
                            placeholder:text-slate-500
                            focus:ring-0"
                    >
                </div>

                <div class="flex h-15 items-center gap-3 rounded-2xl
                            border border-slate-300 bg-white px-4">

                    <label for="robux"
                        class="min-w-0 text-lg text-slate-700">
                        Robux
                    </label>

                    <input
                        id="robux"
                        type="text"
                        inputmode="numeric"
                        placeholder="Sesuaikan Robux"
                        class="converter-value min-w-0 w-full border-0 bg-transparent
                            text-base font-semibold placeholder:font-normal text-slate-800 outline-none
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
        <div class="min-w-0 h-fit">
            <section class="rounded-2xl border-2 border-black bg-sky-900 p-6 shadow-xl">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <label for="username" class="block text-xl font-bold text-white">
                                    Username Roblox
                                </label>
                                <span class="block text-sm text-slate-300">Gunakan username, bukan display name.</span>
                            </div>
                                <div class="relative inline-flex" data-tooltip>
                                <button type="button" aria-label="Informasi" class="flex h-5 w-5 items-center justify-center text-white hover:text-sky-400 cursor-pointer">
                                    <i data-lucide="info" class="text-xs"></i>
                                </button>

                                <div data-tooltip-content class=" absolute z-50 w-64 opacity-0 right-1/2 transition-all duration-200">
                                    <div class="overflow-hidden rounded-2xl border border-slate-200bg-white shadow-xl px-4 bg-slate-700">
                                        <img src="{{ asset('img/tooltipUsername.jpeg') }}" alt="Informasi Robux" class="h-20 pt-4 w-full object-cover">
                                        <div class="py-1">
                                            <span class="block text-xs leading-relaxed text-white">
                                                Pastikan kamu memasukkan Username yang ditandai merah, bukan Display Name
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                bg-white px-4 py-3 text-gray-600
                                outline-none transition
                                placeholder:text-gray-600
                                focus:border-violet-400 focus:ring-2
                                focus:ring-violet-400/20"
                        >

                        <p id="status"
                        role="status"
                        aria-live="polite"
                        class="hidden text-sm text-white">
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
                        class="mb-5 hidden items-center gap-5 rounded-2xl border border-white/10 bg-[#0D0B16] p-5 text-white">

                        {{-- Avatar --}}
                        <img
                            id="avatarImage"
                            src=""
                            alt="Avatar Roblox"
                            class="size-16 shrink-0 rounded-2xl border border-white/10 bg-white/5 object-cover"
                        />

                        {{-- User Information --}}
                        <div class="min-w-0 flex-1">
                            <h2 id="displayName"
                                class="wrap-break-word text-lg font-bold">
                            </h2>

                            <p id="usernameResult"
                                class="mt-0.5 text-sm text-gray-400">
                            </p>

                            <p class="mt-2 text-xs text-gray-500">
                                User ID:
                                <span id="userId" class="font-medium text-gray-300"></span>
                            </p>
                        </div>

                        {{-- Status & Action --}}
                        <div class="flex shrink-0 flex-col items-end gap-3">

                            <span id="accountStatus"
                                class="rounded-full bg-emerald-400/10 px-3 py-1 text-xs font-medium text-emerald-300">
                                Ditemukan
                            </span>

                            <a id="profileLink"
                                href="#"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 rounded-lg border border-white/10 px-3 py-2 text-xs font-semibold transition hover:bg-white/10">
                                Buka Profil ↗
                            </a>

                        </div>

                    </div>

                    <div class="flex items-center justify-between gap-4 rounded-xl border border-white/10 bg-white/4 px-4 py-3">
                    <div>
                        <p class="text-xs font-medium text-white/50">Total Robux</p>
                        <p class="mt-1 text-lg font-bold tracking-wide text-white">
                            <span id="total-robux">0</span>
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="text-xs font-medium text-white/50">Total Harga</p>
                        <p class="mt-1 text-lg font-bold tracking-wide text-sky-400">
                            Rp<span id="total-harga">0</span>
                        </p>
                    </div>
                </div>
                    <button type="button" id="checkout" class="w-full bg-sky-400/20 border mt-3 border-white hover:shadow-[inset_0_0_8px_rgba(0,0,0,0.45)] cursor-pointer py-2 font-bold text-white rounded-2xl">Checkout</button>
            </section>

            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @vite('resources/js/page/home.js')
@endpush