
<div
    id="checkoutModal"
    class="fixed hidden inset-0 z-[99999999] items-center justify-center overflow-clip bg-slate-950/60 backdrop-blur-sm"
>
    <div class="flex ip:w-3/4 ip:max-w-[420px] ip:h-[min(520px,calc(100dvh-32px))] h-[min(600px,calc(100dvh-24px))]
                w-full max-w-md flex-col overflow-hidden
                rounded-2xl bg-white shadow-2xl">

        <!-- Header -->
        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 ip:px-3 ip:py-2.5">
            <div>
                <h2 class="font-bold text-sky-900 ip:text-sm">
                    Catatan Penting
                </h2>
                <p class="text-xs text-slate-500 ip:text-[10px]">
                    Baca sebelum melanjutkan pembayaran.
                </p>
            </div>

            <button
                type="button"
                id="closeModal"
                class="rounded-lg p-2 ip:p-1 text-slate-400 transition hover:bg-slate-100 hover:text-sky-900"
            >
                ✕
            </button>
        </div>

        <!-- Content -->
        <div class="min-h-0 flex-1 overflow-y-auto overscroll-contain p-4 ip:p-3 ip:text-xs">

            <p class="mb-4 font-semibold text-sky-900 ip:mb-2 ip:text-sm">
                Penting: Akun Roblox wajib 18+
            </p>

            <p class="mb-3 ip:mb-2">
                Akun Roblox yang belum 18+ tidak bisa menerima Robux Via Username, kecuali akunnya sudah terhubung dengan orang tua/wali. Pastikan dulu sebelum membayar.
            </p>

            <a
                href="https://wa.me/6285182566640?text=Halo%20admin%20Skybux%2C%20saya%20mau%20tanya%20soal%20syarat%20umur%20akun%20(18%2B)%20untuk%20Robux%20Via%20Username."
                target="_blank"
                rel="noopener noreferrer"
                class="mb-5 inline-block font-semibold text-sky-900 underline underline-offset-2 ip:mb-3"
            >
                Bingung? Tanya admin lewat WhatsApp →
            </a>

            <div class="mb-5 rounded-xl border border-sky-200 bg-sky-50 p-3 ip:mb-3 ip:p-2">
                <p class="font-bold text-sky-900">
                    Estimasi proses: 1–10 menit
                </p>
                <p class="mt-1 text-xs text-slate-600 ip:text-[10px]">
                    Maksimal 20 menit.
                </p>
            </div>

            <!-- Rules -->
            <div class="space-y-4 ip:space-y-2.5">

                <div>
                    <p class="font-bold text-sky-900">1. Cek username dan display name</p>
                    <p>Pastikan username dan display name Roblox sudah sesuai dengan akun tujuan.</p>
                </div>

                <div>
                    <p class="font-bold text-sky-900">2. Cek umur akun</p>
                    <p>Mohon cek umur akun sebelum order. Untuk akun di bawah 18+, pastikan akun sudah terhubung dengan orang tua/wali.</p>
                </div>

                <div>
                    <p class="font-bold text-sky-900">3. Akun yang kena limit</p>
                    <p>Jika akun sedang terkena limit, gunakan akun lain yang sudah siap menerima Robux.</p>
                </div>

                <div>
                    <p class="font-bold text-sky-900">4. Setelah Robux terkirim</p>
                    <p>Setelah Robux berhasil dikirim ke akun yang sudah kamu konfirmasi, perubahan akun/limit setelah proses selesai berada di luar kendali ByToblox. Admin tetap akan bantu cek kalau ada kendala.</p>
                </div>

                <div>
                    <p class="font-bold text-sky-900">5. Amankan akunmu</p>
                    <p>Nyalakan verifikasi 2 langkah di setting &gt; keamanan &gt; email agar akun lebih aman.</p>
                </div>

            </div>

            <!-- Warning -->
            <div class="mt-5 rounded-xl border border-rose-300 bg-rose-50 p-4 ip:mt-3 ip:p-2.5">
                <p class="font-bold text-rose-800">
                    ⚠ Perhatian!
                </p>
                <p class="mt-2 text-sm text-rose-800 ip:mt-1 ip:text-xs">
                    Kalau ternyata akunmu masih limit, Robux-nya bisa nyangkut dan nggak masuk penuh. Robux yang udah kekirim nggak bisa ditarik balik — jadi yang nyangkut nggak bisa direfund. Cek sekali lagi ya sebelum bayar.
                </p>
            </div>

            <!-- Agreements -->
            <div class="mt-5 space-y-3 ip:mt-3 ip:space-y-2">

                <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-sky-200 bg-sky-50 p-4 transition has-[:checked]:border-sky-900 has-[:checked]:bg-sky-100 ip:gap-2 ip:p-2.5">
                    <input
                        id="ageAgreement"
                        type="checkbox"
                        required
                        class="mt-0.5 size-5 shrink-0 accent-sky-900 ip:size-4"
                    >

                    <span class="font-semibold text-slate-800">
                        Akun saya sudah 18+ atau sudah terhubung dengan orang tua/wali.
                    </span>
                </label>

                <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 p-4 transition has-[:checked]:border-sky-900 has-[:checked]:bg-sky-50 ip:gap-2 ip:p-2.5">
                    <input
                        id="ruleAgreement"
                        type="checkbox"
                        required
                        class="mt-0.5 size-5 shrink-0 accent-sky-900 ip:size-4"
                    >

                    <span class="font-semibold text-slate-800">
                        Aku sudah baca dan setuju sama aturan di atas.
                    </span>
                </label>

                <p id="agreementError" class="hidden text-xs font-semibold text-rose-600">
                    Kamu harus menyetujui kedua persyaratan sebelum melanjutkan.
                </p>

            </div>
        </div>

        <!-- Footer -->
        <div class="flex shrink-0 gap-3 border-t border-slate-100 bg-white p-3 ip:gap-2 ip:p-2">

            <button
                type="button"
                id="cancelModal"
                class="flex-1 rounded-xl bg-slate-100 px-3 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-200 ip:py-2 ip:text-xs"
            >
                Batal
            </button>

            <button
                type="button"
                id="agreeButton"
                class="flex-[1.5] flex items-center justify-center gap-2 rounded-xl bg-sky-900 px-3 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-sky-800 active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-60 ip:gap-1 ip:py-2 ip:text-xs"
            >
                <i data-lucide="check" class="size-4 ip:size-3"></i>
                <span>Setuju & Lanjutkan</span>
            </button>

        </div>

    </div>
</div>
