<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Throwable;

class RobloxAccountController extends Controller
{
    private const BASE_URL = 'https://users.roblox.com';

    public function index()
    {
        return view('roblox-checker');
    }

    public function search(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'min:3',
                'max:20',
                'regex:/^[a-zA-Z0-9_]+$/',
            ],
        ]);

        $username = trim($validated['username']);

        try {
            // 1. Cek username persis terlebih dahulu.
            $exactResponse = Http::acceptJson()
                ->timeout(10)
                ->post(self::BASE_URL . '/v1/usernames/users', [
                    'usernames' => [$username],
                    'excludeBannedUsers' => false,
                ]);

            if (! $exactResponse->successful()) {
                return response()->json([
                    'message' => 'Roblox gagal memproses pencarian. Coba lagi.',
                ], 502);
            }

            $exactUsers = $exactResponse->json('data', []);

            $exactUser = collect($exactUsers)->first(
                fn (array $user) =>
                    strcasecmp($user['name'] ?? '', $username) === 0
            );

            if ($exactUser) {
                return response()->json([
                    'status' => 'found',
                    'mode' => 'exact',
                    'user' => $this->formatUser($exactUser),
                ]);
            }

            // 2. Jika tidak ada username persis, cari alternatif.
            $searchResponse = Http::acceptJson()
                ->timeout(10)
                ->get(self::BASE_URL . '/v1/users/search', [
                    'keyword' => $username,
                    'limit' => 10,
                ]);

            if (! $searchResponse->successful()) {
                return response()->json([
                    'message' => 'Pencarian alternatif gagal. Coba lagi.',
                ], 502);
            }

            $users = collect($searchResponse->json('data', []))
                ->filter(fn ($user) =>
                    isset($user['id'], $user['name'])
                )
                ->unique('id')
                ->take(10)
                ->map(fn (array $user) =>
                    $this->formatUser($user)
                )
                ->values();

            if ($users->isEmpty()) {
                return response()->json([
                    'status' => 'not_found',
                    'message' => 'Akun tidak ditemukan.',
                    'users' => [],
                ]);
            }

            return response()->json([
                'status' => 'choices',
                'mode' => 'search',
                'message' => 'Username persis tidak ditemukan. Pilih akun yang sesuai.',
                'users' => $users,
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'Tidak dapat terhubung ke Roblox. Coba lagi nanti.',
            ], 502);
        }
    }

    public function showUser(string $userId): JsonResponse
    {
        if (! ctype_digit($userId) || (int) $userId < 1) {
            return response()->json([
                'message' => 'User ID tidak valid.',
            ], 422);
        }

        try {
            $response = Http::acceptJson()
                ->timeout(10)
                ->get(self::BASE_URL . '/v1/users/' . $userId);

            if ($response->status() === 404) {
                return response()->json([
                    'message' => 'Profil tidak ditemukan.',
                ], 404);
            }

            if (! $response->successful()) {
                return response()->json([
                    'message' => 'Gagal mengambil detail profil Roblox.',
                ], 502);
            }

            $user = $response->json();

            return response()->json([
                'status' => 'found',
                'user' => [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'displayName' => $user['displayName'] ?? $user['name'],
                    'description' => $user['description'] ?? '',
                    'created' => $user['created'] ?? null,
                    'hasVerifiedBadge' => $user['hasVerifiedBadge'] ?? false,
                    'profileUrl' => 'https://www.roblox.com/users/'
                        . $user['id'] . '/profile',
                    'ageVerification' => [
                        'status' => 'unavailable',
                        'label' => 'Tidak tersedia secara publik',
                    ],
                ],
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'Tidak dapat mengambil profil Roblox.',
            ], 502);
        }
    }

    private function formatUser(array $user): array
    {
        return [
            'id' => $user['id'],
            'name' => $user['name'],
            'displayName' => $user['displayName'] ?? $user['name'],
            'hasVerifiedBadge' => $user['hasVerifiedBadge'] ?? false,
        ];
    }

    
public function avatar(string $userId): JsonResponse
{
    if (! ctype_digit($userId) || (int) $userId < 1) {
        return response()->json([
            'message' => 'User ID tidak valid.',
        ], 422);
    }

    try {
        $response = Http::acceptJson()
            ->timeout(10)
            ->get('https://thumbnails.roblox.com/v1/users/avatar-headshot', [
                'userIds' => $userId,
                'size' => '150x150',
                'format' => 'Png',
                'isCircular' => 'false',
            ]);

        if (! $response->successful()) {
            return response()->json([
                'message' => 'Gagal mengambil avatar.',
            ], 502);
        }

        $avatar = collect($response->json('data', []))->first();

        return response()->json([
            'imageUrl' => $avatar['imageUrl'] ?? null,
        ]);
    } catch (\Throwable $exception) {
        report($exception);

        return response()->json([
            'message' => 'Tidak dapat mengambil avatar Roblox.',
        ], 502);
    }
}

}
