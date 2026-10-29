@vite(['resources/css/app.css', 'resources/js/app.js'])


<div class="mx-auto max-w-md rounded-2xl bg-[#171421] p-6 text-white">
    <h1 class="text-2xl font-bold">Pembayaran QRIS</h1>

    <label for="amount" class="mt-5 block text-sm text-gray-300">
        Nominal pembayaran
    </label>

    <input id="amount"
        class="mt-2 w-full rounded-xl bg-white/10 p-3">
        <!-- <option value="10000">Rp10.000</option>
        <option value="25000" selected>Rp25.000</option>
        <option value="50000">Rp50.000</option>
        <option value="100000">Rp100.000</option> -->
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
</div>
