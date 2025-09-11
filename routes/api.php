<?php

use App\Http\Controllers\Auth\ApiLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenseController;

Route::post('/login', [ApiLoginController::class, 'login']);
Route::post('/logout', [ApiLoginController::class, 'logout'])
    ->middleware('auth:sanctum');

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
        Route::get('/expenses', [ExpenseController::class, 'index']);
        Route::post('/expenses', [ExpenseController::class, 'store']);
        Route::get('/expenses/{expense}', [ExpenseController::class, 'show']);
        Route::put('/expenses/{expense}', [ExpenseController::class, 'update']);
        Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy']);
});

Route::get('/expenses/current', function (Request $request) {
    $currentMonth = now()->month;
    $currentYear = now()->year;
    return redirect()->to("/api/expenses?month={$currentMonth}&year={$currentYear}");
});



