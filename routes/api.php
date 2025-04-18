<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StocksController;
use App\Http\Controllers\TenantsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\PendapatanTenantsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->middleware('api')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('me', [AuthController::class, 'me']);
    Route::resource('tenants', TenantsController::class);
    Route::resource('invoces', InvoicesController::class);
    Route::resource('stok', StocksController::class);
    Route::resource('pendapatan', PendapatanTenantsController::class);
});