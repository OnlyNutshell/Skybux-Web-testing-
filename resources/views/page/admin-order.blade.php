@extends('layout.admin')

@section('title', 'Dashboard')

@section('content')
    
<div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-[0_8px_30px_rgba(15,23,42,0.04)]">

    {{-- Table Header --}}
    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
        <div>
            <h2 class="text-lg font-bold tracking-tight text-slate-800">
                Recent Transactions
            </h2>
            <p class="mt-1 text-xs text-slate-400">
                Manage and monitor customer orders
            </p>
            <div class="mt-1 text-sm font-bold text-slate-400">
                Total Robux dikirim : <p class="font-bold"> {{ number_format($totalRobuxSent) }}</p>
            </div>
        </div>

        <div
            id="liveOrderStatus"
            class="inline-flex items-center gap-2 rounded-lg bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-700"
        >
            <span
                id="liveOrderIndicator"
                class="size-2 rounded-full bg-current animate-pulse"
            ></span>

            <span id="liveOrderText">Menghubungkan...</span>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full min-w-312.5 whitespace-nowrap text-left text-sm">

            <thead class="bg-slate-50/80 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                <tr>
                    <th class="min-w-[150px] px-6 py-4">Status Order</th>
                    <th class="min-w-[150px] px-6 py-4">Order ID</th>
                    <th class="min-w-[90px] px-6 py-4">Avatar</th>
                    <th class="min-w-[190px] px-6 py-4">Display / Usn</th>
                    <th class="min-w-[90px] px-6 py-4">Robux</th>
                    <th class="min-w-[120px] px-6 py-4">Total</th>
                    <th class="min-w-[110px] px-6 py-4">Metode</th>
                    <th class="min-w-[150px] px-6 py-4">Bukti</th>
                    <th class="min-w-[180px] px-6 py-4">WhatsApp / TikTok</th>
                    <th class="min-w-[180px] text-center px-6 py-4">Acc / delete</th>
                    <th class="min-w-[150px] px-6 py-4">Order</th>
                </tr>
            </thead>

            <tbody id="admin-orders" class="divide-y divide-slate-100/80">

                @forelse ($orders as $order)
                    <tr class="transition-colors duration-200 hover:bg-sky-50/40">

                        <td class="px-6 py-5">
                            @if (strtolower($order->order_status) === 'done')
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700">
                                    <span class="size-1.5 rounded-full bg-emerald-500"></span>
                                    DONE
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1.5 text-xs font-bold text-amber-700">
                                    <span class="size-1.5 rounded-full bg-amber-500"></span>
                                    {{ strtoupper($order->order_status ?? 'PENDING') }}
                                </span>
                            @endif
                        </td>

                        {{-- Order ID --}}
                        <td class="px-6 py-5">
                            <span class="font-bold text-slate-700">
                                {{ $order->order_id }}
                            </span>
                        </td>

                        {{-- Username --}}
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">

                                <img
                                    src="{{ $order->avatar_url ?? 'https://tr.rbxcdn.com/180DAY-AvatarHeadshot-Placeholder.png' }}"
                                    alt="Roblox Avatar"
                                    class="size-10 rounded-xl border border-slate-200 bg-slate-100 object-cover"
                                    onerror="this.src='https://placehold.co/150x150?text=User'"
                                >
                            </div>
                        </td>

                        {{-- Display Name --}}
                        <td class="px-6 py-5 flex flex-col text-center">
                                <span class="font-bold text-slate-600">
                                    Dis : {{ $order->display_name }}
                                </span>
                                <span class="font-bold text-slate-600">
                                    Usn : @ {{ $order->roblox_username }}
                                    </span>
                        </td>

                        {{-- Robux --}}
                        <td class="px-6 py-5 font-medium text-slate-600">
                            {{ number_format($order->robux_amount) }}
                        </td>

                        {{-- Total --}}
                        <td class="px-6 py-5 font-bold text-slate-800">
                            Rp{{ number_format($order->total_price) }}
                        </td>

                        {{-- Method --}}
                        <td class="px-6 py-5">
                            <span class="rounded-lg bg-slate-100 px-2.5 py-1.5 text-xs font-bold text-slate-600">
                                {{ strtoupper($order->payment_method ?? '-') }}
                            </span>
                        </td>

                        {{-- Proof --}}
                        <td class="px-6 py-5">
                            @if ($order->proof_url)
                                <a href="{{ $order->proof_url }}" target="_blank"
                                    rel="noopener noreferrer"
                                    class="font-semibold text-sky-600 transition hover:text-sky-800 hover:underline">
                                    Bukti Pembayaran ↗
                                </a>
                            @else
                                <span class="text-xs text-slate-400">
                                    Belom Upload Bems
                                </span>
                            @endif
                        </td>
                            
                            {{-- Order Status --}}
                            <td class="px-6 py-5 flex-col flex text-center">
                                @if ($order->whatsapp)
                                <span class="font-bold text-blue underline">
                                    <a href="https://wa.me/6285182566640?">{{ $order->whatsapp }}</a>
                                </span>
                                <span class="font-bold text-slate-700">
                                    {{ $order->tiktok_username ?? 'gada tiktok'}}
                                </span>
                                @else
                                    <span class="text-xs text-slate-400">
                                        Kaga dikirim mas Bems
                                    </span>
                                @endif
                        </td>

                        {{-- ACC --}}
                        {{-- Actions --}}
                        <td class="py-5">
                            <div class="flex items-center justify-center gap-2">

                                {{-- ACC --}}
                                @if ($order->order_status != 'done')
                                    <form
                                    action="{{ route('admin.orders.approve', $order->order_id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin ACC order {{ $order->order_id }}?')"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="rounded-lg bg-emerald-50 p-2 text-emerald-700 transition hover:bg-emerald-100"
                                            title="Approve"
                                        >
                                            <i data-lucide="check" class="size-4"></i>
                                        </button>
                                    </form>
                                @endif

                                {{-- DEL --}}
                                <form
                                    action="{{ route('admin.orders.destroy', $order->order_id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus order {{ $order->order_id }}? Data tidak bisa dikembalikan!')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="rounded-lg bg-red-50 p-2 text-red-700 transition hover:bg-red-100"
                                        title="Delete"
                                    >
                                        <i data-lucide="trash-2" class="size-4"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                        </td>

                        {{-- Created At --}}
                        <td class="px-6 py-5 text-xs font-medium text-slate-500">
                            {{ $order->created_at }}
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-16 text-center">
                            <div class="text-sm font-semibold text-slate-500">
                                No transactions yet
                            </div>
                            <p class="mt-1 text-xs text-slate-400">
                                New orders will appear here.
                            </p>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
    @vite('resources/js/order-realtime.js')
@endpush