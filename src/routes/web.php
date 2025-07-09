<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\CarResController;
use App\Http\Controllers\OperationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;



Route::get('paymentWebpage',[PaymentController::class,'paymentWebpage']);
