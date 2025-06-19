<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

session_start();

Route::prefix("payment/rest")->group(function () {
    Route::get("register.do", [PaymentController::class, 'register']);
    Route::get("confirm.do", [PaymentController::class, 'confirm']);
    Route::get("refund.do", [PaymentController::class, 'refund']);
});

// Add route for payment webpage
Route::get('/paymentWebpage', function () {
    $orderId = request()->query('orderId');
    if (!$orderId) {
        return abort(404);
    }
    return view('paymentWebpage', ['data' => [
        'orderNumber' => $orderId,
        'confirmUrl'=>$_SESSION['returnUrl'],
        'failUrl'=>$_SESSION['failUrl'],
        // You might want to fetch other data from session or database here
    ]]);
});
