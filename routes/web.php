<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RobuxController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\RobloxAccountController;
use App\Http\Controllers\AdminController;

use Illuminate\Support\Facades\DB;

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

    $checkoutOrder = session('checkout_order');

    if (!$checkoutOrder || empty($checkoutOrder['order_id'])) {
        return redirect()->route('home');
    }

    $order = DB::table('orders')
        ->where('order_id', $checkoutOrder['order_id'])
        ->first();

    if (!$order) {
        return redirect()->route('home');
    }

    return view('page.payment', compact('order'));

})->name('payment');
    

    Route::post('/confirm', [CheckoutController::class, 'confirm'])
    ->name('confirm');

    Route::post('/payment/proof', [CheckoutController::class, 'uploadProof'])
    ->name('proof');
    
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

    /*
|--------------------------------------------------------------------------
| Admin Page
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');

    Route::patch('/orders/{order}/approve', [AdminController::class, 'approve'])
        ->name('orders.approve');

    Route::delete('/orders/{order}', [AdminController::class, 'destroy'])
        ->name('orders.destroy');
});

Route::get('/live/overlay', function () {
    return view('overlay-webhook.overlay');
})->name('overlay-webhook.overlay');