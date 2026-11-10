@extends('layout.admin')

@section('title', 'Dashboard')

@section('content')
    
<div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-[0_8px_30px_rgba(15,23,42,0.04)]">

    {{-- Table Header --}}
    <div class="flex md:flex-row flex-col items-center justify-between border-b border-slate-100 px-6 py-5">
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

    {{-- Mobile Orders --}}
    
    {{-- Desktop Orders --}}
    <div class="hidden md:block">
        @include('component.admin-order-table', [
        'orders' => $orders
        ])
    </div>
    
</div>

<div id="admin-orders-mobile" class="space-y-4 pt-4 md:hidden">
    @foreach ($orders as $order)
        @include('component.admin-order-card', [
            'order' => $order
        ])
    @endforeach
</div>

@endsection

@push('scripts')
    @vite('resources/js/order-realtime.js')
@endpush