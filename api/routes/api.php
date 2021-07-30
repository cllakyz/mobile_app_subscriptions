<?php

use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (){
    // Device register
    Route::post('/auth/device/register', RegisterController::class)->name('auth.register');

    // Device Subscriptons
    Route::middleware('auth:device')->group(function () {
        Route::post('/subscriptions/purchase', [SubscriptionController::class, 'purchase'])->name('subscription.purchase');
        Route::get('/subscriptions/check', [SubscriptionController::class, 'check'])->name('subscription.check');
    });
});
