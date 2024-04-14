<?php

use App\Http\Controllers\PartnerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('partners', PartnerController::class);
Route::apiResource('customers', CustomerController::class);
Route::apiResource('suppliers', SupplierController::class);