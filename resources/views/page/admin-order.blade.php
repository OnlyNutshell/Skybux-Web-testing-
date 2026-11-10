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
        </div>

        <span class="rounded-lg bg-sky-50 px-3 py-1.5 text-xs font-semibold text-sky-700">
            Live Orders
        </span>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full whitespace-nowrap text-left text-sm">

            <thead class="bg-slate-50/80 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                <tr>
                    <th class="px-6 py-4">Order ID</th>
                    <th class="px-6 py-4">Username</th>
                    <th class="px-6 py-4">Display Name</th>
                    <th class="px-6 py-4">Robux</th>
                    <th class="px-6 py-4">Total</th>
                    <th class="px-6 py-4">Metode</th>
                    <th class="px-6 py-4">Bukti</th>
                    <th class="px-6 py-4">Whatapp</th>
                    <th class="px-6 py-4">Tiktok</th>
                    <th class="px-6 py-4">Order</th>
                </tr>
            </thead>

            <tbody id="admin-orders" class="divide-y divide-slate-100/80">

                @forelse ($orders as $order)
                    <tr class="transition-colors duration-200 hover:bg-sky-50/40">

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

                                <span class="font-bold text-slate-600">
                                    {{ $order->roblox_username }}
                                </span>

                            </div>
                        </td>

                        {{-- Display Name --}}
                        <td class="px-6 py-5 text-center">
                            <span class="font-bold text-slate-600">
                                {{ $order->display_name }}
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

                        {{-- Payment Status --}}
                        <td class="px-6 py-5">

                            <span class="font-bold text-blue underline">
                                <a href="https://wa.me/6285182566640?">{{ $order->whatsapp }}</a>
                            </span>
                        </td>

                        {{-- Order Status --}}
                        <td class="px-6 py-5">
                            @if ($order->tiktok_username)
                                <span class="font-bold text-slate-700">
                                    {{ $order->tiktok_username }}
                                </span>
                                @else
                                    <span class="text-xs text-slate-400">
                                        Kaga dikirim mas Bems
                                    </span>
                                @endif
                            </span>
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