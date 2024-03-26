<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSessionRequest;
use App\Http\Requests\UpdateSessionRequest;
use App\Models\Session;
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
        $validated['user_id'] = auth()->id();
        $session = Session::create($validated);

        if ($session) {
            return response()->json([
                'message' => 'Session created successfully',
            ], 200);
        }
    }


    public function update(UpdateSessionRequest $request, $slug)
    {
        $validated = $request->validated();
        $sessionBySlug = Session::where('slug', $slug)->first();
        $sessionById = Session::where('id', $slug)->first();

        if (!is_null($sessionById)) {
            if ($sessionById->status == 'FINISHED') {
                return response()->json([
                    'message' => 'You can\'t update a finished session.',
                ], 200);
            }
            $sessionById->update($validated);
            return response()->json([
                'message' => 'The session has benn updated succesfully.',
            ], 200);
        }

        if (!is_null($sessionBySlug)) {
            if ($sessionBySlug->status == 'FINISHED') {
                return response()->json([
                    'message' => 'You can\'t update a finished session.',
                ], 200);
            }
            $sessionBySlug->update($validated);
            return response()->json([
                'message' => 'The session has benn updated succesfully.',
            ], 200);
        }
    }

    public function status($slug)
    {
        $sessionBySlug = Session::where('slug', $slug)->first();
        $sessionById = Session::where('id', $slug)->first();

        if (!is_null($sessionById)) {
            if ($sessionById->status == 'FINISHED') {
                return response()->json([
                    'message' => 'The session is already finished.',
                ], 200);
            }
            $sessionById->update([
                'status' => 'FINISHED',
            ]);
            return response()->json([
                'message' => 'The session has been set as finished.',
            ], 200);
        }

        if (!is_null($sessionBySlug)) {
            if ($sessionBySlug->status == 'FINISHED') {
                return response()->json([
                    'message' => 'The session is already finished.',
                ], 200);
            }
            $sessionBySlug->update([
                'status' => 'FINISHED',
            ]);
            return response()->json([
                'message' => 'The session has been set as finished.',
            ], 200);
        }
    }


    public function destroy($slug)
    {
        $sessionBySlug = Session::where('slug', $slug)->first();
        $sessionById = Session::where('id', $slug)->first();

        if (!is_null($sessionById)) {
            $sessionById->delete();
            return response()->json([
                'message' => 'The session has been deleted successfully.',
            ], 200);
        }

        if (!is_null($sessionBySlug)) {
            $sessionBySlug->delete();
            return response()->json([
                'message' => 'The session has been deleted successfully.',
            ], 200);
        }
    }
}
