<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenseController;

/*
|--------------------------------------------------------------------------
| Public API Routes (TEMP: no auth)
|--------------------------------------------------------------------------
| These routes are open so you can test your React app without login.
| Re-add auth later.
*/

Route::get('/expenses', [ExpenseController::class, 'index']);
Route::post('/expenses', [ExpenseController::class, 'store']);
Route::get('/expenses/{expense}', [ExpenseController::class, 'show']);
Route::put('/expenses/{expense}', [ExpenseController::class, 'update']);
Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy']);

Route::get('/expenses/current', function (Request $request) {
    $currentMonth = now()->month;
    $currentYear = now()->year;
    return redirect()->to("/api/expenses?month={$currentMonth}&year={$currentYear}");
});

// TEMP: remove Breeze auth from API layer
// require __DIR__ . '/auth.php';
