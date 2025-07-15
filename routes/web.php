<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/checkout', [PaymentController::class, 'showCheckout']);
Route::post('/checkout/process', [PaymentController::class, 'processCheckout']);
Route::get('/checkout/thanks', [PaymentController::class, 'thanks'])->name('checkout.thanks');
