<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'min:3',
                'max:20',
                'regex:/^[A-Za-z0-9_]+$/',
            ],
            'robux' => [
                'required',
                'integer',
                'min:5',
            ],
            'avatarImage' => [
                'required',
                'url',
            ],
        ]);

        $robux = (int) $validated['robux'];

        if ($robux % 5 !== 0) {
            return response()->json([
                'message' => 'Jumlah Robux harus kelipatan 5.',
            ], 422);
        }

        $price = $robux * 170;

        session()->put('checkout_order', [
            'username' => $validated['username'],
            'robux' => $robux,
            'price' => $price,
            'avatarImage' => $validated['avatarImage'],
        ]);

        return response()->json([
            'redirect' => route('checkout.method'),
        ]);
    }

    public function confirm(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => [
                'required',
                'in:qris',
            ],
        ]);

        $order = session('checkout_order');

        if (!$order) {
            return redirect()->route('home');
        }

        // Gunakan ID yang sama jika tombol diklik berulang kali.
        $orderId = $order['order_id'] ?? 'SKY-' . strtoupper(Str::random(12));

        // Cek apakah order sudah pernah disimpan.
        $existingOrder = DB::table('orders')
            ->where('order_id', $orderId)
            ->first();

        if (!$existingOrder) {
            DB::table('orders')->insert([
                'order_id' => $orderId,
                'roblox_username' => $order['username'],
                'robux_amount' => $order['robux'],
                'total_price' => $order['price'] + 1,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'expires_at' => now()->addMinutes(14),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Simpan informasi order ke session.
        $order['order_id'] = $orderId;
        $order['payment_method'] = $validated['payment_method'];

        session()->put('checkout_order', $order);

        return redirect()->route('checkout.payment');
    }

    

    public function uploadProof(Request $request)
{
    $request->validate([
        'payment_proof' => [
            'required',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:5120',
        ],
    ]);

    $checkoutOrder = session('checkout_order');

    if (!$checkoutOrder || empty($checkoutOrder['order_id'])) {
        return redirect()->route('home');
    }

    $order = DB::table('orders')
        ->where('order_id', $checkoutOrder['order_id'])
        ->first();

    if (!$order || $order->payment_status !== 'pending') {
        return back()->withErrors([
            'payment_proof' => 'Pesanan tidak valid.',
        ]);
    }

    $file = $request->file('payment_proof');
    $extension = $file->extension();

    $path = $order->order_id . '/' . Str::uuid() . '.' . $extension;

    $url = rtrim(config('services.supabase.url'), '/');

    $response = Http::timeout(30)
        ->withHeaders([
            'apikey' => config('services.supabase.secret_key'),
            'Content-Type' => $file->getMimeType(),
            'x-upsert' => 'false',
        ])
        ->withBody(
            file_get_contents($file->getRealPath()),
            $file->getMimeType()
        )
        ->post(
            $url . '/storage/v1/object/payment-proofs/' .
            implode('/', array_map('rawurlencode', explode('/', $path)))
        );

    if (!$response->successful()) {
        dd([
            'status' => $response->status(),
            'response' => $response->body(),
        ]);

        return back()->withErrors([
            'payment_proof' => 'Upload gagal. Silakan coba lagi.',
        ]);
    }

    DB::table('orders')
        ->where('order_id', $order->order_id)
        ->update([
            'payment_proof_path' => $path,
            'updated_at' => now(),
        ]);

    return redirect()->route('home')
    ->with('success', 'Bukti pembayaran berhasil diupload.');
}
}
