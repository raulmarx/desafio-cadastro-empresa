<?php

use App\Http\Controllers\API\BillingInfoClientEnterpriseController;
use App\Http\Controllers\API\ClientEnterpriseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('client-enterprise',ClientEnterpriseController::class);
Route::apiResource('billing-info',BillingInfoClientEnterpriseController::class);
