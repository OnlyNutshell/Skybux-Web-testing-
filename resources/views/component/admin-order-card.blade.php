<!-- <div
    class="overflow-hidden rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:shadow-md"
    data-order-id="{{ $order->order_id }}"
>
    {{-- Header: Order ID & Status --}}
    <div class="flex items-center justify-between gap-3">

        <div class="min-w-0">
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">
                Order ID
            </p>

            <p class="truncate text-sm font-bold text-slate-800">
                {{ $order->order_id }}
            </p>
        </div>

        @if (strtolower($order->order_status) === 'done')
            <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-[10px] font-bold text-emerald-700">
                <span class="size-1.5 rounded-full bg-emerald-500"></span>
                DONE
            </span>
        @else
            <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1.5 text-[10px] font-bold text-amber-700">
                <span class="size-1.5 rounded-full bg-amber-500"></span>
                {{ strtoupper($order->order_status ?? 'PENDING') }}
            </span>
        @endif

    </div>

    <div class="my-4 border-t border-slate-100"></div>

    {{-- Customer Identity --}}
    <div class="flex items-center gap-3">

        <img
            src="{{ $order->avatar_url ?? 'https://tr.rbxcdn.com/180DAY-AvatarHeadshot-Placeholder.png' }}"
            alt="Roblox Avatar"
            class="size-12 shrink-0 rounded-xl border border-slate-200 bg-slate-100 object-cover"
            onerror="this.src='https://placehold.co/150x150?text=User'"
        >

        <div class="min-w-0 flex-1">
            <p class="truncate text-sm font-bold text-slate-800">
                {{ $order->display_name }}
            </p>

            <p class="truncate text-xs text-slate-400">
                @ {{ $order->roblox_username }}
            </p>
        </div>

    </div>

    {{-- Transaction Information --}}
    <div class="mt-4 grid grid-cols-2 gap-3">

        <div class="rounded-xl bg-slate-50 p-3">
            <p class="text-[10px] font-semibold text-slate-400">
                JUMLAH ROBUX
            </p>

            <p class="mt-1 text-sm font-bold text-slate-800">
                {{ number_format($order->robux_amount) }} 
            </p>
        </div>

        <div class="rounded-xl text-end bg-slate-50 p-3">
            <p class="text-[10px] font-semibold text-slate-400">
                TOTAL PEMBAYARAN
            </p>

            <p class="mt-1 truncate text-sm font-bold text-slate-800">
                Rp{{ number_format($order->total_price) }}
            </p>
        </div>

    </div>

    {{-- Payment Information --}}
    <div class="mt-4 flex items-center justify-between gap-3">

        <div>
            <p class="text-[10px] font-semibold text-slate-400">
                METODE PEMBAYARAN
            </p>

            <span class="mt-1 inline-flex rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-600">
                {{ strtoupper($order->payment_method ?? '-') }}
            </span>
        </div>

        <div class="text-right">
            <p class="text-[10px] font-semibold text-slate-400">
                BUKTI PEMBAYARAN
            </p>

            @if ($order->proof_url)
                <a
                    href="{{ $order->proof_url }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="mt-1 inline-flex items-center gap-1 text-xs font-bold text-sky-600 hover:text-sky-800"
                >
                    Lihat Bukti
                    <i data-lucide="external-link" class="size-3"></i>
                </a>
            @else
                <span class="mt-1 block text-xs text-slate-400">
                    Belum upload
                </span>
            @endif
        </div>

    </div>

    <div class="my-4 border-t border-slate-100"></div>

    {{-- Contact Accordion --}}
    <details class="group">

        <summary class="flex cursor-pointer list-none items-center justify-between gap-3">

            <div class="flex items-center gap-2">
                <i data-lucide="contact-round" class="size-4 text-slate-400"></i>

                <span class="text-xs font-bold text-slate-600">
                    Contact Information
                </span>
            </div>

            <i
                data-lucide="chevron-down"
                class="size-4 text-slate-400 transition-transform duration-200 group-open:rotate-180"
            ></i>

        </summary>

        <div class="mt-3 space-y-3 rounded-xl bg-slate-50 p-3">

            {{-- WhatsApp --}}
            <div class="flex items-center gap-3">

                <i data-lucide="message-circle" class="size-5 shrink-0 text-emerald-600"></i>

                <div class="min-w-0 flex-1">
                    <p class="text-[10px] font-semibold text-slate-400">
                        WHATSAPP
                    </p>

                    @if ($order->whatsapp)
                        <a
                            href="https://wa.me/{{ preg_replace('/\D/', '', $order->whatsapp) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="break-all text-xs font-bold text-slate-700 hover:text-emerald-600"
                        >
                            {{ $order->whatsapp }}
                        </a>
                    @else
                        <p class="text-xs text-slate-400">
                            Tidak tersedia
                        </p>
                    @endif
                </div>

            </div>

            <div class="border-t border-slate-200"></div>

            {{-- TikTok --}}
            <div class="flex items-center gap-3">

                <i data-lucide="music-2" class="size-5 shrink-0 text-slate-600"></i>

                <div class="min-w-0 flex-1">
                    <p class="text-[10px] font-semibold text-slate-400">
                        TIKTOK
                    </p>

                    @if ($order->tiktok_username)
                        <p class="break-all text-xs font-bold text-slate-700">
                            {{ $order->tiktok_username }}
                        </p>
                    @else
                        <p class="text-xs text-slate-400">
                            Tidak tersedia
                        </p>
                    @endif
                </div>

            </div>

        </div>

    </details>

    <div class="my-4 border-t border-slate-100"></div>

    {{-- Order Date --}}
    <div class="mb-4 flex items-center gap-2 text-[10px] font-medium text-slate-400">
        <i data-lucide="calendar" class="size-3.5"></i>

        {{ $order->created_at }}
    </div>

    {{-- Actions --}}
    <div class="flex gap-2">

        {{-- ACC --}}
        @if ($order->order_status != 'done')
            <form
                action="{{ route('admin.orders.approve', $order->order_id) }}"
                method="POST"
                class="flex-1"
                onsubmit="return confirm('Yakin ingin ACC order {{ $order->order_id }}?')"
            >
                @csrf
                @method('PATCH')

                <button
                    type="submit"
                    class="flex min-h-11 w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-3 py-2.5 text-xs font-bold text-white transition hover:bg-emerald-700 active:scale-[0.98]"
                >
                    <i data-lucide="check" class="size-4"></i>
                    ACC Order
                </button>
            </form>
        @else
            <div class="flex min-h-11 flex-1 items-center justify-center gap-2 rounded-xl bg-emerald-50 px-3 py-2.5 text-xs font-bold text-emerald-700">
                <i data-lucide="check-check" class="size-4"></i>
                Order Selesai
            </div>
        @endif

        {{-- DELETE --}}
        <form
            action="{{ route('admin.orders.destroy', $order->order_id) }}"
            method="POST"
            onsubmit="return confirm('Yakin ingin menghapus order {{ $order->order_id }}? Data tidak bisa dikembalikan!')"
        >
            @csrf
            @method('DELETE')

            <button
                type="submit"
                aria-label="Hapus order"
                class="flex min-h-11 min-w-11 items-center justify-center rounded-xl border border-red-100 bg-red-50 px-3 text-red-600 transition hover:bg-red-100 active:scale-[0.98]"
            >
                <i data-lucide="trash-2" class="size-4"></i>
            </button>
        </form>

    </div>

</div> -->