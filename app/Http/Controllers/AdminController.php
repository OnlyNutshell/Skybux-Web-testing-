<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{

public function orders()
{
    $orders = DB::table('orders')
        ->orderByDesc('created_at')
        ->get();

    $supabaseUrl = config('services.supabase.url');
    $secretKey = config('services.supabase.secret_key');

    foreach ($orders as $order) {
        $order->proof_url = null;

        if ($order->payment_proof_path) {
            $response = Http::withHeaders([
                'apikey' => $secretKey,
                'Authorization' => 'Bearer ' . $secretKey,
            ])->post(
                rtrim($supabaseUrl, '/') . '/storage/v1/object/sign/payment-proofs/' . 
                implode('/', array_map('rawurlencode', explode('/', $order->payment_proof_path))),
                ['expiresIn' => 3600]
            );

            if ($response->successful()) {
                $order->proof_url = rtrim($supabaseUrl, '/') .
                    '/storage/v1' . $response->json('signedURL');
            }
        }
    }

    return view('page.admin-order', compact('orders'));
}
}
