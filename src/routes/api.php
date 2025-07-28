<?php


use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::prefix("payment/rest")->group(function () {
    Route::get("register.do", [PaymentController::class, 'register']);
    Route::get("confirmOrder.do", [PaymentController::class, 'confirm']);
    Route::get("refund.do", [PaymentController::class, 'refund']);
    Route::get("generateCredentials.do", [PaymentController::class, 'generateCredentials']);
});

 

