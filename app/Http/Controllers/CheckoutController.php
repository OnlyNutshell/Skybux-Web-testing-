<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        ]);

        return response()->json([
            'redirect' => route('checkout.method'),
        ]);
    }
}
