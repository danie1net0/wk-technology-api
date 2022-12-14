<?php

use App\Http\Controllers;
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

Route::apiResource('customers', Controllers\CustomerController::class);
Route::apiResource('products', Controllers\ProductController::class);
Route::apiResource('sales', Controllers\SaleController::class)->except('update', 'destroy');
