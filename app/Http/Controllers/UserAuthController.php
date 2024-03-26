<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        return response()->json([
            'message' => 'User Created.',
        ]);
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        $user = User::where('email', $validated['email'])->first();
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }
        if ($user->tokens()->exists()) {
            return response()->json([
                'access_token' => $user->tokens()->first()->token,
            ]);
        } else {
            $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;
        }
        return response()->json([
            'access_token' => $token,
        ]);
    }

    public function logout()
    {
        /** @disregard P1013  | tokens() marked as undefined but it works fine **/
        auth()->user()->tokens()->delete();
        return response()->json([
            "message" => "Logged Out"
        ]);
    }
}
