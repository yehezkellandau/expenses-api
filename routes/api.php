<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenseController;

// All routes in this group require authentication
Route::middleware(['auth:sanctum'])->group(function () {
    // Get the authenticated user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Expenses CRUD
    Route::get('/expenses', [ExpenseController::class, 'index']);
    Route::post('/expenses', [ExpenseController::class, 'store']);
    Route::get('/expenses/{expense}', [ExpenseController::class, 'show']);
    Route::put('/expenses/{expense}', [ExpenseController::class, 'update']);
    Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy']);

    // Shortcut to current month expenses
    Route::get('/expenses/current', function (Request $request) {
        $currentMonth = now()->month;
        $currentYear = now()->year;
        return redirect()->to("/api/expenses?month={$currentMonth}&year={$currentYear}");
    });
});

// Register and login routes from Laravel Breeze (must be below)
require __DIR__.'/auth.php';
