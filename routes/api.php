<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// payment all routes
Route::post('/cash-in', [PaymentController::class, 'cashInPayment']);
Route::post('/cash-out', [PaymentController::class, 'cashOutPayment']);
Route::get('/payment-list', [PaymentController::class, 'PaymentListShow']);

Route::get('/payment-edit/{id}', [PaymentController::class, 'PaymentEdit']);
Route::post('/payment-update/{id}', [PaymentController::class, 'PaymentUpdate']);

Route::get('/payment-delete/{id}', [PaymentController::class, 'PaymentDelete']);

Route::get('/payment-calculation', [PaymentController::class, 'PaymentCalculation']);