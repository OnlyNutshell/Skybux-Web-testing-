@extends('layout.welcome')

@section('content')
    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-slate-500">
            <tr>
                <th class="p-4">Order ID</th>
                <th class="p-4">Username</th>
                <th class="p-4">Robux</th>
                <th class="p-4">Total</th>
                <th class="p-4">Metode</th>
                <th class="p-4">Bukti</th>
                <th class="p-4">Payment</th>
                <th class="p-4">Order</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-slate-100">
            @forelse ($orders as $order)
                <tr>
                    <td class="p-4 font-semibold">{{ $order->order_id }}</td>
                    <td class="p-4">{{ $order->roblox_username }}</td>
                    <td class="p-4">{{ number_format($order->robux_amount) }}</td>
                    <td class="p-4">Rp{{ number_format($order->total_price) }}</td>
                    <td class="p-4">{{ strtoupper($order->payment_method ?? '-') }}</td>

                    <td class="p-4">
                        @if ($order->proof_url)
                            <a href="{{ $order->proof_url }}" target="_blank"
                                class="font-semibold text-sky-600 hover:underline">
                                Lihat Bukti
                            </a>
                        @else
                            <span class="text-slate-400">Belum ada</span>
                        @endif
                    </td>

                    <td class="p-4">
                        <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                            {{ strtoupper($order->payment_status) }}
                        </span>
                    </td>

                    <td class="p-4">{{ strtoupper($order->order_status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="p-8 text-center text-slate-400">
                        Belum ada transaksi.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection