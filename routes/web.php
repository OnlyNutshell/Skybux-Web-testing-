<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RobloxAccountController;

Route::get('/', function () {
    return view('layout.welcome');
});

Route::get('/checkout', function () {
    return view('layout.checkout');
});

Route::middleware('throttle:20,1')->group(function () {
    Route::post('/roblox-checker/search', [
        RobloxAccountController::class,
        'search',
    ])->name('roblox.search');

    Route::get('/roblox-checker/users/{userId}', [
        RobloxAccountController::class,
        'showUser',
    ])->whereNumber('userId')
      ->name('roblox.user');
    
      
      });

Route::get('/roblox-checker/users/{userId}/avatar', [
    RobloxAccountController::class,
    'avatar',
])->whereNumber('userId')->name('roblox.avatar');