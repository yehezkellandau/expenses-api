<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'month' => 'sometimes|integer|between:1,12',
            'year' => 'sometimes|integer|min:2000|max:' . date('Y'),
        ]);

        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $user = $request->user();
        $householdIds = $user->households()->pluck('households.id');

        $expenses = Expense::whereIn('household_id', $householdIds)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();

        return response()->json([
            'month' => (int) $month,
            'year' => (int) $year,
            'data' => $expenses,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category' => 'required|string',
            'amount' => 'required|numeric',
            'type' => 'required|in:cash,credit_card',
            'date' => 'required|date',
        ]);

        $user = $request->user();
        $household = $user->households()->first(); // or add logic to choose

        $data['household_id'] = $household->id;

        return Expense::create($data);
    }

    public function show(Expense $expense)
    {
        return $expense;
    }

    public function update(Request $request, Expense $expense)
    {
        $data = $request->validate([
            'category' => 'sometimes|string',
            'amount' => 'sometimes|numeric',
            'type' => 'sometimes|in:cash,credit_card',
            'date' => 'sometimes|date',
        ]);

        $expense->update($data);
        return $expense;
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
