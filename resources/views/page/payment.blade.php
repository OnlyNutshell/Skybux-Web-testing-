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
                    <div
                        id="payment-data"
                        data-amount="{{ $order->total_price }}"
                        class="p-5 border-2 bg-white rounded-2xl mb-5 border-black shadow-xl"
                    >
                        <canvas id="qr" class="max-w-full"></canvas>

                        <p class="mt-3 text-center font-bold text-slate-900">
                            Rp{{ number_format($order->total_price, 0, ',', '.') }}
                        </p>
                    </div>

                    <p id="qr-error" class="hidden mb-4 text-sm text-red-200"></p>
                    <button type="button" id="download-qr" class="inline-flex items-center gap-2 mb-5 rounded-lg border border-sky-200 bg-white px-4 py-2 text-sm font-semibold text-sky-700 shadow-sm transition hover:border-sky-300 hover:bg-sky-50 active:scale-95">
                        <i data-lucide="download" class="size-4"></i>
                            Unduh QR
                    </button>
                    <span class="block">Expires in :</span>
                    <span
                        id="payment-timer"
                        data-expires-at="{{ $order->expires_at }}"
                        class="block text-yellow-300 text-2xl tracking-wider font-bold mb-5"
                    >--:--</span>
                    

                    <form
                        action="{{ route('checkout.proof') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="mt-7 rounded-2xl border text-white bg-white w-full mb-6 p-5 sm:p-6"
                    >
                        @csrf

                        <div class="mb-5">
                            <h3 class="text-base font-semibold tracking-tight text-slate-900">
                                Bukti Pembayaran
                            </h3>
                            <p class="mt-1 text-xs text-slate-500">
                                Upload bukti transfer untuk melanjutkan pesanan.
                            </p>
                        </div>

                        <input
                            type="file"
                            name="payment_proof"
                            id="payment-proof"
                            accept="image/jpeg,image/png,image/webp"
                            required
                            class="hidden"
                        >

                        <!-- Input panjang -->
                        <label
                            for="payment-proof"
                            class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 px-4 py-3.5 transition hover:border-slate-400"
                        >
                            <i data-lucide="paperclip" class="size-5 shrink-0 text-slate-400"></i>

                            <span class="flex-1 text-sm text-slate-500">
                                Pilih file bukti pembayaran
                            </span>

                            <span class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700">
                                Browse
                            </span>
                        </label>

                        <p class="mt-2 text-[11px] text-slate-400">
                            JPG, PNG, WEBP · Maksimal 5 MB
                        </p>

                        <!-- File terpilih -->
                        <div id="proof-info" class="mt-4 hidden">
                            <div class="flex items-center gap-3">
                                <div class="flex size-9 shrink-0 items-center justify-center rounded-lg border border-slate-200">
                                    <i data-lucide="file-image" class="size-4 text-slate-500"></i>
                                </div>

                                <div class="min-w-0 flex-1">
                                    <p id="proof-name" class="truncate text-sm font-medium text-slate-800"></p>
                                    <p id="proof-size" class="text-xs text-slate-400"></p>
                                </div>

                                <button
                                    type="button"
                                    id="preview-proof"
                                    class="text-xs font-semibold text-slate-700 hover:text-black"
                                >
                                    Lihat preview
                                </button>

                                <button
                                    type="button"
                                    id="remove-proof"
                                    class="text-slate-400 transition hover:text-red-500"
                                >
                                    <i data-lucide="x" class="size-4"></i>
                                </button>
                            </div>
                        </div>

                        @error('payment_proof')
                            <p class="mt-3 text-xs text-red-500">{{ $message }}</p>
                        @enderror

                        <button
                            type="submit"
                            class="mt-6 flex w-full items-center justify-center gap-2 rounded-xl bg-slate-900 px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-slate-800 active:scale-[0.99]"
                        >
                            <i data-lucide="send" class="size-4"></i>
                            Kirim Bukti Pembayaran
                        </button>

                        <p class="mt-3 text-center text-[11px] text-slate-400">
                            Pastikan nominal dan status transaksi terlihat jelas.
                        </p>
                    </form>

                    <!-- Modal Preview -->
                    <div
                        id="proof-modal"
                        class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/70 p-4 backdrop-blur-sm"
                    >
                        <div class="relative w-full max-w-lg rounded-2xl bg-white p-3 shadow-2xl">
                            <div class="flex items-center justify-between px-2 py-2">
                                <p class="text-sm font-semibold text-slate-800">
                                    Preview Bukti Pembayaran
                                </p>

                                <button
                                    type="button"
                                    id="close-proof-modal"
                                    class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-800"
                                >
                                    <i data-lucide="x" class="size-5"></i>
                                </button>
                            </div>

                            <img
                                id="proof-preview-image"
                                src=""
                                alt="Preview bukti pembayaran"
                                class="max-h-[70vh] w-full rounded-xl object-contain"
                            >
                        </div>
                    </div>


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
