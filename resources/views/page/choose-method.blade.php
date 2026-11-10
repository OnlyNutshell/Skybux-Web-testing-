@extends('layout.welcome')

@section('modal')
    @include('component.checkout-modal')
@endsection

@section('progression')
    @include('component.page-proggresion', ['step' => 2])
@endsection


@section('content')
    
<section class="mx-4 mb-4 sm:mx-8 xl:mx-32">
    <form id="checkoutForm" action="{{ route('checkout.confirm') }}" method="POST" novalidate>
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 lg:gap-8">

        <div class="min-w-0 lg:col-span-2 space-y-5">

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="bg-sky-900 px-4 py-4 text-white">
                    <h2 class="font-semibold">
                        Detail
                    </h2>
                </div>

                <div class="border-b border-slate-200 px-4 py-3 flex items-center gap-2">
                    <img width="30" height="30" src="{{ $order['avatarImage']}}" alt="">
                    <p class="text-sm font-medium text-slate-700">
                        {{ $order['username'] }}
                    </p>
                </div>

                <div class="flex items-center gap-4 p-4">

                    <img src="https://img.icons8.com/ios-filled/50/22C3E6/robux--v1.png" alt="Robux" class="size-12 rounded-xl object-cover">

                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-medium text-slate-500">
                            ROBUX
                        </p>
                        <h3 class="font-semibold text-slate-900">
                            {{ $order['robux'] }}
                        </h3>
                    </div>

                    <p class="shrink-0 font-bold text-slate-900">
                        Rp{{ number_format($order['price'], 0, ',', '.') }}
                    </p>

                </div>
            </div>


            <!-- PAYMENT METHOD -->
            

<div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

    <!-- HEADER -->
    <div class="mb-5">
        <h2 class="text-lg font-bold text-slate-900">
            Metode Pembayaran
        </h2>
        <p class="mt-1 text-sm text-slate-500">
            Pilih metode pembayaran yang tersedia.
        </p>
    </div>


    <!-- QRIS -->
    <details id="qrisAccordion" class="group border-b border-slate-100 py-3">

        <summary class="flex cursor-pointer list-none items-center justify-between py-2">
            <h3 class="font-bold text-slate-900">QRIS</h3>

            <span class="text-2xl font-light leading-none text-slate-900 group-open:hidden">+</span>
            <span class="hidden text-2xl font-light leading-none text-slate-900 group-open:inline">−</span>
        </summary>

        <div class="pb-3 pt-2">
            <label class="flex cursor-pointer items-center gap-4 rounded-xl border border-sky-200 bg-sky-50/50 p-4 transition hover:bg-sky-50">

                <input
                    id="qrisRadio"
                    type="radio"
                    name="payment_method"
                    value="qris"
                    required
                    class="size-5 accent-sky-900"
                >

                <img
                    src="{{ asset('img/QRIS Logo.svg') }}"
                    alt="QRIS"
                    class="h-8 w-16 object-contain"
                >

                <span class="flex-1 font-semibold text-slate-900">
                    QRIS
                </span>

                <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-green-700">
                    Aktif
                </span>

            </label>
        </div>
    </details>

    <!-- E-WALLET -->
    <details class="group border-b border-slate-100 py-3">

        <summary class="flex cursor-pointer list-none items-center justify-between py-2">
            <h3 class="font-bold text-slate-900">
                E-Wallet
            </h3>

            <span class="text-2xl font-light leading-none text-slate-900 group-open:hidden">
                +
            </span>

            <span class="hidden text-2xl font-light leading-none text-slate-900 group-open:inline">
                −
            </span>
        </summary>

        <div class="divide-y divide-slate-100 pb-2 pt-1">

            <!-- DANA -->
            <div class="flex items-center gap-4 px-4 py-4 opacity-60">

                <input type="radio" disabled class="size-5">

                <img
                    src="{{ asset('img/Dana Icon.svg') }}"
                    alt="DANA"
                    class="h-9 w-16 object-contain"
                >

                <span class="flex-1 font-semibold text-slate-700">
                    DANA
                </span>

                <span class="rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-semibold text-amber-700">
                    Coming Soon
                </span>

            </div>

            <!-- GOPAY -->
            <div class="flex items-center gap-4 px-4 py-4 opacity-60">

                <input type="radio" disabled class="size-5">

                <img
                    src="{{ asset('img/GoPay Icon.png') }}"
                    alt="GoPay"
                    class="h-9 w-16 object-contain"
                >

                <span class="flex-1 font-semibold text-slate-700">
                    GoPay
                </span>

                <span class="rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-semibold text-amber-700">
                    Coming Soon
                </span>

            </div>

            <!-- SHOPEEPAY -->
            <div class="flex items-center gap-4 px-4 py-4 opacity-60">

                <input type="radio" disabled class="size-5">

                <img
                    src="{{ asset('img/ShopeePay Icon.png') }}"
                    alt="ShopeePay"
                    class="h-9 w-16 object-contain"
                >

                <span class="flex-1 font-semibold text-slate-700">
                    ShopeePay
                </span>

                <span class="rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-semibold text-amber-700">
                    Coming Soon
                </span>

            </div>

        </div>
    </details>


    <!-- TRANSFER BANK -->
    <details class="group py-3">

        <summary class="flex cursor-pointer list-none items-center justify-between py-2">
            <h3 class="font-bold text-slate-900">
                Transfer Bank
            </h3>

            <span class="text-2xl font-light leading-none text-slate-900 group-open:hidden">
                +
            </span>

            <span class="hidden text-2xl font-light leading-none text-slate-900 group-open:inline">
                −
            </span>
        </summary>

        <div class="divide-y divide-slate-100 pb-2 pt-1">

            <!-- BANK JAGO -->
            <div class="flex items-center gap-4 px-4 py-4 opacity-60">

                <input type="radio" disabled class="size-5">

                <img
                    src="{{ asset('img/Jago.svg') }}"
                    alt="Bank Jago"
                    class="h-9 w-16 object-contain"
                >

                <span class="flex-1 font-semibold text-slate-700">
                    Bank Jago
                </span>

                <span class="rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-semibold text-amber-700">
                    Coming Soon
                </span>

            </div>

            <!-- SEABANK -->
            <div class="flex items-center gap-4 px-4 py-4 opacity-60">

                <input type="radio" disabled class="size-5">

                <img
                    src="{{ asset('img/SeaBank Logo.svg') }}"
                    alt="SeaBank"
                    class="h-9 w-16 object-contain"
                >

                <span class="flex-1 font-semibold text-slate-700">
                    SeaBank
                </span>

                <span class="rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-semibold text-amber-700">
                    Coming Soon
                </span>

            </div>

        </div>
    </details>

</div>


        </div>


        <!-- RIGHT SIDEBAR -->
        <aside class="min-w-0 h-fit overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 p-4">

                <div class=" flex items-center gap-3 rounded-2xl bg-green-50 p-4">

                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-900">
                            Pasti Masuk dan Terkirim 100%
                        </p>
                        <p class="mt-1 text-xs text-slate-500">
                            Pesanan aman dijamin oleh Bang Bemsky!!
                        </p>
                    </div>

                    <div class="flex size-10 shrink-0 items-center justify-center rounded-full bg-green-600 text-white">
                        ✓
                    </div>

                </div>
            </div>


            <!-- EMAIL NOTIFICATION -->
            <div class="border-b border-slate-200 p-5">

            <h2 class="font-bold text-slate-900">
                Informasi Kontak
            </h2>

            <p class="mb-4 text-sm text-slate-500">
                Masukkan kontak yang aktif agar kami bisa menghubungi kamu jika ada informasi terkait pesanan.
            </p>

            <div class="space-y-4">

                
            <label class="block">
                <span class="mb-1 block text-xs text-slate-500">
                    WhatsApp Number*
                </span>

                <div class="relative">
                    <input
                        type="tel"
                        id="whatsapp"
                        name="whatsapp"
                        required
                        inputmode="numeric"
                        maxlength="15"
                        autocomplete="tel"
                        placeholder="08xxxxxxxxxx"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 pr-11 text-sm outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20"
                    >

                    <span
                        id="whatsappIcon"
                        class="pointer-events-none absolute right-4 top-1/2 hidden -translate-y-1/2"
                    ></span>
                </div>

                <p
                    id="whatsappError"
                    class="mt-1.5 hidden text-xs font-medium text-red-500"
                ></p>
            </label>


                
            <label class="block">
                <span class="mb-1 block text-xs text-slate-500">
                    TikTok Username
                    <span class="text-slate-400">(Optional)</span>
                </span>

                <div class="flex overflow-hidden rounded-xl border border-slate-300 transition focus-within:border-sky-500 focus-within:ring-2 focus-within:ring-sky-500/20">
                    <span class="flex items-center bg-slate-100 px-4 text-sm text-slate-500">
                        @
                    </span>

                    <input
                        type="text"
                        id="tiktok"
                        name="tiktok"
                        maxlength="30"
                        placeholder="username"
                        class="min-w-0 w-full bg-transparent px-3 py-3 text-sm outline-none"
                    >
                </div>
            </label>


            </div>

        </div>


            <!-- PAYMENT DETAIL -->
            <div class="p-5">

                <h3 class="mb-4 font-bold text-slate-900">
                    Detail Pembayaran
                </h3>

                <div class="space-y-3 text-sm">

                    <div class="flex justify-between gap-3">
                        <span class="text-slate-500">Total pesanan</span>
                        <span class="font-semibold text-slate-900">
                            Rp{{ number_format($order['price'], 0, ',', '.') }}
                        </span>
                    </div>

                </div>

            </div>

            <div class="border-t border-slate-200 p-5">

                <div class="flex items-center justify-between gap-3">
                    <span class="font-semibold text-slate-700">
                        Total pembayaran
                    </span>

                    <span class="text-xl font-bold text-slate-900">
                        Rp{{ number_format($order['price'], 0, ',', '.') }}
                    </span>
                </div>

                <button
                    id="checkoutButton"
                    type="button"
                    disabled
                    class="mt-5 w-full rounded-xl bg-sky-900 opacity-50 px-5 py-3 font-semibold text-white shadow-sm transition hover:bg-sky-800 active:scale-[0.98]"
                >
                    Bayar Sekarang
                </button>


            </div>

        </aside>

    </div>
    </form>

    

    
</section>

@endsection



@push('scripts')
    @vite('resources/js/page/checkout.js')
@endpush