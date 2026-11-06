@extends('layout.welcome')

@section('progression')
    @include('component.page-proggresion', ['step' => 3])
@endsection

@section('content')

<section class="mx-4 sm:mx-8 xl:mx-32 px-6">
    <div class="w-full ">

        <!-- Payment Information -->
        <div class="relative mb-5 flex min-w-0 flex-col items-center lg:mb-0">
            <div class="relative w-full overflow-hidden rounded-2xl border-2 shadow-xl border-black bg-sky-900 p-6">
                <div class="flex flex-col items-center text-white">
                    <span class=" text-lg font-semibold mb-5">Mohon Screenshoot Layar ini</span>
                    <div class="p-5 border-2 bg-white rounded-2xl mb-5 border-black shadow-xl">
                        <img class="lg:w-50 lg:h-50" src="{{ asset('img/Qris.png') }}" alt="">
                    </div>
                    <button type="button" class="inline-flex items-center gap-2 mb-5 rounded-lg border border-sky-200 bg-white px-4 py-2 text-sm font-semibold text-sky-700 shadow-sm transition hover:border-sky-300 hover:bg-sky-50 active:scale-95">
                        <i data-lucide="download" class="size-4"></i>
                            Unduh QR
                    </button>
                    <span class="block">Expires in :</span>
                    <span class="block text-yellow-300 text-2xl tracking-wider font-bold mb-5">14:00</span>
                    <div class="rounded-2xl border w-full border-black bg-white p-3 sm:p-6">
                        <h3 class="text-base font-bold text-slate-900">
                            Cara Pembayaran
                        </h3>
                        <p class="mt-1 mb-6 text-sm text-slate-500">
                            Ikuti langkah berikut untuk menyelesaikan pembayaran.
                        </p>

                        <div class="space-y-5">
                            <div class="flex items-start gap-3.5">
                                <span class="flex size-9 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sm font-bold text-sky-700">01</span>
                                <div>
                                    <h4 class="text-sm font-semibold text-slate-800">Buka aplikasi pembayaran</h4>
                                    <p class="mt-1 text-sm leading-relaxed text-slate-500">
                                        Gunakan aplikasi yang mendukung QRIS seperti DANA, OVO, GoPay, ShopeePay, atau mobile banking.
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3.5">
                                <span class="flex size-9 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sm font-bold text-sky-700">02</span>
                                <div>
                                    <h4 class="text-sm font-semibold text-slate-800">Pilih menu Scan QR</h4>
                                    <p class="mt-1 text-sm leading-relaxed text-slate-500">
                                        Cari opsi Bayar atau Scan QR pada aplikasi pembayaran.
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3.5">
                                <span class="flex size-9 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sm font-bold text-sky-700">03</span>
                                <div>
                                    <h4 class="text-sm font-semibold text-slate-800">Pindai kode QR</h4>
                                    <p class="mt-1 text-sm leading-relaxed text-slate-500">
                                        Arahkan kamera ke kode QRIS yang tersedia di halaman ini.
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3.5">
                                <span class="flex size-9 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sm font-bold text-sky-700">04</span>
                                <div>
                                    <h4 class="text-sm font-semibold text-slate-800">Selesaikan pembayaran</h4>
                                    <p class="mt-1 text-sm leading-relaxed text-slate-500">
                                        Periksa nominal tagihan, lalu konfirmasi pembayaran.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- <div class="mx-auto max-w-md rounded-2xl bg-[#171421] p-6 text-white">
    <h1 class="text-2xl font-bold">Pembayaran QRIS</h1>

    <label for="amount" class="mt-5 block text-sm text-gray-300">
        Nominal pembayaran
    </label>

    <input id="amount"
        class="mt-2 w-full rounded-xl bg-white/10 p-3">
        <option value="10000">Rp10.000</option>
        <option value="25000" selected>Rp25.000</option>
        <option value="50000">Rp50.000</option>
        <option value="100000">Rp100.000</option>
    </input>

    <button id="generate"
        class="mt-4 w-full rounded-xl bg-violet-600 p-3 font-semibold">
        Buat QRIS
    </button>

    <div id="result" class="mt-5 hidden text-center">
        <canvas id="qr" class="mx-auto rounded-lg bg-white p-3"></canvas>
        <p id="total" class="mt-3 text-xl font-bold"></p>
        <p class="mt-2 text-xs text-gray-400">
            QR hasil konversi. Validitas pembayaran harus diuji
            dengan penerbit QRIS.
        </p>
    </div>

    <p id="error" class="mt-3 text-sm text-red-400"></p>
</div> -->
@endsection

@push('scripts')
    @vite('resources/js/page/payment.js')
@endpush
