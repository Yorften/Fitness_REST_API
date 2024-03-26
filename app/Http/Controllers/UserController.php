<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show()
    {
        $tokens = auth()->user()->tokens->map(function ($token) {
            return $token->token;
        });
    
        return response()->json([
            'My Information' => auth()->user(),
            'Tokens' => $tokens
        ], 200);
    }

    public function destroy()
    {
        /** @disregard P1013 */
        auth()->user()->tokens()->delete();
        /** @disregard P1013 */
        auth()->user()->delete();
    }
}
