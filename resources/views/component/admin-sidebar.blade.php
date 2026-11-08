
<aside class="fixed inset-y-0 left-0 z-40 flex h-screen w-64 flex-col border-r border-slate-800 bg-[#0D1726] text-white">

    {{-- Logo --}}
    <div class="border-b border-white/5 px-6 py-7">
        <div class="flex items-center gap-3">
            <div class="flex size-10 items-center justify-center rounded-xl bg-sky-500/15 text-xl text-sky-400">
                🎮
            </div>

            <div>
                <h1 class="text-base font-bold tracking-tight">
                    Robux Admin
                </h1>
                <p class="mt-0.5 text-[11px] text-slate-500">
                    Management Panel
                </p>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 space-y-7 overflow-y-auto px-4 py-6">

        <div>
            <p class="mb-3 px-3 text-[10px] font-bold tracking-[0.15em] text-slate-500">
                MENU UTAMA
            </p>

            <div class="space-y-1">

                <a href="#"
                    class="flex items-center gap-3 rounded-xl bg-sky-500/10 px-3 py-3 text-sm font-semibold text-sky-400 ring-1 ring-inset ring-sky-500/10 transition hover:bg-sky-500/15">
                    <span class="text-base">📊</span>
                    Dashboard
                </a>

                <a href="#"
                    class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-slate-400 transition hover:bg-white/5 hover:text-white">
                    <span class="text-base">📦</span>
                    Input Stock
                </a>

                <a href="#"
                    class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-slate-400 transition hover:bg-white/5 hover:text-white">
                    <span class="text-base">💰</span>
                    Input Rate
                </a>

                <a href="#"
                    class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-slate-400 transition hover:bg-white/5 hover:text-white">
                    <span class="text-base">💳</span>
                    Nominal Item
                </a>

                <a href="#"
                    class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-slate-400 transition hover:bg-white/5 hover:text-white">
                    <span class="text-base">💳</span>
                    Status Toko
                </a>

                <a href="#"
                    class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-slate-400 transition hover:bg-white/5 hover:text-white">
                    <span class="text-base">🛒</span>
                    Orders
                </a>

            </div>
        </div>

    </nav>

    {{-- Footer --}}
    <div class="border-t border-white/5 p-4">
        <div class="flex items-center gap-3 rounded-xl bg-white/[0.03] p-3">
            <div class="flex size-9 items-center justify-center rounded-full bg-sky-500/15 text-sm font-bold text-sky-400">
                A
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-200">Administrator</p>
                <p class="mt-0.5 text-[10px] text-slate-500">Management Access</p>
            </div>
        </div>
    </div>

</aside>
