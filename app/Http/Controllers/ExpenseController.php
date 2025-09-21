<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user || !$user->household_id) {
            return response()->json(['message' => 'User does not belong to a household'], 403);
        }

        $householdId = $user->household_id;

        $request->validate([
            'month' => 'sometimes|integer|between:1,12',
            'year' => 'sometimes|integer|min:2000|max:' . date('Y'),
        ]);

        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $expenses = \App\Models\Expense::where('household_id', $householdId)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'household_id' => $householdId,
            'month' => (int)$month,
            'year' => (int)$year,
            'data' => $expenses,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'name'         => 'required|string',
            'amount'       => 'required|numeric',
            'method'       => 'required|in:cash,credit_card',
            'date'         => 'required|date',
        ]);

        $data['user_id'] = $request->user()->id;
        $data['household_id'] = $request->user()->household_id;

        $expense = \App\Models\Expense::create($data);

        return response()->json($expense, 201);
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
