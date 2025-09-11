<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
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
    public function register(Request $request) : JsonResponse
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|string|email|max:255|unique:users',
            'password'        => 'required|string|confirmed|min:8',
            'household_action'=> 'required|in:create,join',
            'household_code'  => 'required_if:household_action,join|exists:households,join_code',
            'household_name'  => 'required_if:household_action,create|string|max:255',
        ]);

        if ($request->household_action === 'create') {
            $household = Household::create([
                'name'      => $request->household_name,
                'join_code' => Str::uuid(),
            ]);
        } else {
            $household = Household::where('join_code', $request->household_code)->first();

            if (!$household) {
                return response()->json(['message' => 'Invalid join code'], 422);
            }
        }

        $user = User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'household_id' => $household->id,
        ]);

        return response()->json([
            'message'   => 'User registered successfully',
            'user'      => $user,
            'household' => $household,
            'token'     => $user->createToken('auth_token')->plainTextToken,
        ]);
    }
}
