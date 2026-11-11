<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function orders()
    {

        /*
        |--------------------------------------------------------------------------
        | 1. DATABASE QUERY
        |--------------------------------------------------------------------------
        */

        $orders = DB::table('orders')
            ->orderByDesc('created_at')
            ->paginate(8);

        $totalRobuxSent = DB::table('orders')
            ->where('order_status', 'done')
            ->sum('robux_amount');

        /*
        |--------------------------------------------------------------------------
        | 2. ROBLOX USERNAME & AVATAR
        |--------------------------------------------------------------------------
        */

        $usernames = $orders->getCollection()
            ->pluck('roblox_username')
            ->filter()
            ->unique()
            ->values();

        $avatarMap = [];
        $displayNameMap = [];

        $missingUsernames = [];

        // Periksa cache Roblox
        foreach ($usernames as $username) {
            $cacheKey = 'roblox-user:' . strtolower($username);

            $cachedUser = Cache::get($cacheKey);

            if ($cachedUser !== null) {
                $avatarMap[$username] = $cachedUser['avatar_url'];
                $displayNameMap[$username] = $cachedUser['display_name'];
            } else {
                $missingUsernames[] = $username;
            }
        }

        // Request hanya untuk username yang belum ada di cache
        if (!empty($missingUsernames)) {
            $usersResponse = Http::timeout(8)->post(
                'https://users.roblox.com/v1/usernames/users',
                [
                    'usernames' => $missingUsernames,
                    'excludeBannedUsers' => false,
                ]
            );

            if ($usersResponse->successful()) {
                $users = $usersResponse->json('data', []);

                $userIds = collect($users)
                    ->pluck('id')
                    ->filter()
                    ->values();

                $thumbnailMap = [];

                // Ambil avatar sekaligus
                if ($userIds->isNotEmpty()) {
                    $avatarResponse = Http::timeout(8)->get(
                        'https://thumbnails.roblox.com/v1/users/avatar-headshot',
                        [
                            'userIds' => $userIds->implode(','),
                            'size' => '150x150',
                            'format' => 'Png',
                            'isCircular' => 'false',
                        ]
                    );

                    if ($avatarResponse->successful()) {
                        foreach ($avatarResponse->json('data', []) as $thumbnail) {
                            $thumbnailMap[$thumbnail['targetId']] =
                                $thumbnail['imageUrl'] ?? null;
                        }
                    }
                }

                // Simpan hasil Roblox ke cache
                foreach ($users as $user) {
                    $username = $user['name'];

                    $userData = [
                        'avatar_url' => $thumbnailMap[$user['id']] ?? null,
                        'display_name' => $user['displayName'] ?? $username,
                    ];

                    Cache::put(
                        'roblox-user:' . strtolower($username),
                        $userData,
                        now()->addHours(24)
                    );

                    $avatarMap[$username] = $userData['avatar_url'];
                    $displayNameMap[$username] = $userData['display_name'];
                }
            }
        }

        // Pasang data Roblox ke order
        foreach ($orders->getCollection() as $order) {
            $username = $order->roblox_username;

            $order->avatar_url = $avatarMap[$username] ?? null;

            $order->display_name = $displayNameMap[$username]
                ?? $username;
        }

        /*
        |--------------------------------------------------------------------------
        | 3. SUPABASE SIGNED URL
        |--------------------------------------------------------------------------
        */


        $supabaseUrl = config('services.supabase.url');
        $secretKey = config('services.supabase.secret_key');

        foreach ($orders->getCollection() as $order) {
            $order->proof_url = null;

            if (!$order->payment_proof_path) {
                continue;
            }

            $path = $order->payment_proof_path;

            $cacheKey = 'payment-proof:' . sha1($path);

            $order->proof_url = Cache::remember(
                $cacheKey,
                now()->addMinutes(50),
                function () use ($path, $supabaseUrl, $secretKey) {
                    if (!$supabaseUrl || !$secretKey) {
                        return null;
                    }

                    $response = Http::timeout(8)
                        ->withHeaders([
                            'apikey' => $secretKey,
                            'Authorization' => 'Bearer ' . $secretKey,
                        ])
                        ->post(
                            rtrim($supabaseUrl, '/') .
                            '/storage/v1/object/sign/payment-proofs/' .
                            implode(
                                '/',
                                array_map(
                                    'rawurlencode',
                                    explode('/', $path)
                                )
                            ),
                            [
                                'expiresIn' => 3600,
                            ]
                        );

                    if (!$response->successful()) {
                        return null;
                    }

                    $signedUrl = $response->json('signedURL');

                    if (!$signedUrl) {
                        return null;
                    }

                    return rtrim($supabaseUrl, '/') .
                        '/storage/v1' . $signedUrl;
                }
            );
        }

        return view(
            'page.admin-order',
            compact('orders', 'totalRobuxSent')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVE ORDER
    |--------------------------------------------------------------------------
    */

    
    public function approve($order)
    {
        $orderData = DB::table('orders')
            ->where('order_id', $order)
            ->where('order_status', '!=', 'done')
            ->first();

        if (!$orderData) {
            return back()->with(
                'error',
                'Order tidak ditemukan atau sudah diproses.'
            );
        }

        DB::transaction(function () use ($orderData, $order) {
            DB::table('orders')
                ->where('order_id', $order)
                ->update([
                    'order_status' => 'done',
                    'updated_at' => now(),
                ]);

            DB::table('live_order_events')->insert([
                'event_type' => 'done',
                'roblox_username' => $orderData->roblox_username,
                'robux_amount' => $orderData->robux_amount,
                'created_at' => now(),
            ]);
        });

        return back()->with(
            'success',
            'Pembayaran berhasil disetujui!'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE ORDER
    |--------------------------------------------------------------------------
    */

    public function destroy($order)
    {
        $deleted = DB::table('orders')
            ->where('order_id', $order)
            ->delete();

        if (!$deleted) {
            return back()->with(
                'error',
                'Order tidak ditemukan.'
            );
        }

        return back()->with(
            'success',
            'Order berhasil dihapus!'
        );
    }
}
