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

        // Ambil username unik dari semua order
    $usernames = $orders
        ->pluck('roblox_username')
        ->filter()
        ->unique()
        ->values()
        ->all();

    $avatarMap = [];
    $displayNameMap = [];

    if (!empty($usernames)) {
        // Cari Roblox User ID berdasarkan username
        $usersResponse = Http::post(
            'https://users.roblox.com/v1/usernames/users',
            [
                'usernames' => $usernames,
                'excludeBannedUsers' => false,
            ]
        );

        if ($usersResponse->successful()) {
            $users = $usersResponse->json('data', []);

            foreach ($users as $user) {
                $displayNameMap[$user['name']] = $user['displayName'] ?? $user['name'];
            }

            $userIds = collect($users)
                ->pluck('id')
                ->filter()
                ->implode(',');

            if ($userIds) {
                // Ambil avatar headshot sekaligus
                $avatarResponse = Http::get(
                    'https://thumbnails.roblox.com/v1/users/avatar-headshot',
                    [
                        'userIds' => $userIds,
                        'size' => '150x150',
                        'format' => 'Png',
                        'isCircular' => 'false',
                    ]
                );

                if ($avatarResponse->successful()) {
                    $thumbnailData = $avatarResponse->json('data', []);

                    foreach ($users as $user) {
                        $thumbnail = collect($thumbnailData)->firstWhere(
                            'targetId',
                            $user['id']
                        );

                        $avatarMap[$user['name']] = $thumbnail['imageUrl'] ?? null;
                    }
                }
            }
        }
    }

    // Masukkan URL avatar ke setiap order
    foreach ($orders as $order) {
        $order->avatar_url = $avatarMap[$order->roblox_username] ?? null;
        $order->display_name = $displayNameMap[$order->roblox_username] ?? $order->roblox_username;
    }

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
