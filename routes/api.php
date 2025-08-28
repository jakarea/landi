<?php

use App\Http\Controllers\CouponController;
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

// Coupon API routes
Route::post('/coupon/validate', [CouponController::class, 'validateCoupon'])->name('api.coupon.validate');
Route::post('/coupon/apply', [CouponController::class, 'applyCoupon'])->name('api.coupon.apply');
