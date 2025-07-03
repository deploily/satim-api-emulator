<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\CarResController;
use App\Http\Controllers\OperationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

session_start();

Route::prefix("payment/rest")->group(function () {
    Route::get("register.do", [PaymentController::class, 'register']);
    Route::get("confirm.do", [PaymentController::class, 'confirm']);
    Route::get("refund.do", [PaymentController::class, 'refund']);
});
Route::controller(OperationController::class)->group(function (){
Route::get('sum/{a}/{b}','sum')
->whereNumber('a')
->whereNumber('b');

Route::get('substract/{a}/{b}','substract')
->whereNumber('a')
->whereNumber('b');

});
