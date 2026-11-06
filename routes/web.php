<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RobuxController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\RobloxAccountController;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', [RobuxController::class, 'index'])
    ->name('home');


/*
|--------------------------------------------------------------------------
| Checkout
|--------------------------------------------------------------------------
*/

Route::prefix('checkout')->name('checkout.')->group(function () {

    Route::post('/', [CheckoutController::class, 'store'])
        ->name('store');

    Route::get('/', function () {
        $order = session('checkout_order');

        if (!$order) {
            return redirect()->route('home');
        }

        return view('page.choose-method', compact('order'));
    })->name('method');
    
    Route::get('/payment', function () {
        return view('page.payment');
    })->name('payment');
    
    });


/*
|--------------------------------------------------------------------------
| Roblox Checker
|--------------------------------------------------------------------------
*/

Route::prefix('roblox-checker')
    ->name('roblox.')
    ->middleware('throttle:20,1')
    ->group(function () {

        Route::post('/search', [RobloxAccountController::class, 'search'])
            ->name('search');

        Route::get('/users/{userId}', [RobloxAccountController::class, 'showUser'])
            ->whereNumber('userId')
            ->name('user');

        Route::get('/users/{userId}/avatar', [RobloxAccountController::class, 'avatar'])
            ->whereNumber('userId')
            ->name('avatar');

    });
