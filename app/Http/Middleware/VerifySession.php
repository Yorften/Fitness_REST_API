<?php

namespace App\Http\Middleware;

use App\Models\Session;
use Closure;
use Hamcrest\Type\IsInteger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use function PHPUnit\Framework\isEmpty;

class VerifySession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route('session');

        $sessionById = Session::where('id', $slug)->first();
        $sessionBySlug = Session::where('slug', $slug)->first();


        if (is_null($sessionById) && is_null($sessionBySlug)) {
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        if (!is_null($sessionById)) {
            if ($sessionById->user_id !== Auth::id()) {
                return response()->json([
                    'message' => 'Forbidden'
                ], 403);
            }
        }
        
        if (!is_null($sessionBySlug)) {
            if ($sessionBySlug->user_id !== Auth::id()) {
                return response()->json([
                    'message' => 'Forbidden'
                ], 403);
            }
        }


        return $next($request);
    }
}
