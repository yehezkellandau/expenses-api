<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Household;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'household_action' => 'required|in:create,join',
            'household_code' => 'required_if:household_action,join|exists:households,code'
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Create or Join household
        if ($request->household_action === 'create') {
            $household = Household::create([
                'name' => "{$user->name}'s Household",
                'code' => Str::uuid(),
            ]);
        } else {
            $household = Household::where('code', $request->household_code)->first();
        }

        $user->households()->attach($household->id);

        // **Remove this line:**
        // Auth::login($user);

        return response()->json([
            'message' => 'User registered',
            'token' => $user->createToken('auth_token')->plainTextToken,
            'household' => $household,
        ]);
    }

}
