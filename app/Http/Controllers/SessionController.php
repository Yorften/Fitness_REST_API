<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSessionRequest;
use App\Http\Requests\UpdateSessionRequest;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{

    public function index()
    {
        $sessions = Session::where('user_id', Auth::id())->get();

        if (count($sessions) == 0) {
            return response()->json([
                'message' => 'Not Found',
            ], 404);
        }

        return response()->json([
            'sessions' => $sessions,
        ], 200);
    }


    public function show($slug)
    {
        $sessionBySlug = Session::where('slug', $slug)->first();
        $sessionById = Session::where('id', $slug)->first();

        if (!is_null($sessionById)) {
            return response()->json([
                'session' => $sessionById,
            ], 200);
        }

        if (!is_null($sessionBySlug)) {
            return response()->json([
                'session' => $sessionBySlug,
            ], 200);
        }
    }


    public function store(StoreSessionRequest $request)
    {
        $validated = $request->validated();
        $session = Session::create($validated);

        if ($session) {
            return response()->json([
                'message' => 'Session created successfully',
            ], 200);
        }
    }


    public function update(UpdateSessionRequest $request, $slug)
    {
        $session = Session::where('slug', $slug)->first();
    }


    public function destroy()
    {
    }
}
