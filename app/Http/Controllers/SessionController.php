<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{

    public function index()
    {
        $sessions = Session::where('user_id', Auth::id())->get();
        
        if(count($sessions) == 0){
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
        $session = Session::where('slug', $slug)->first();
        return response()->json([
            'session' => $session ?? null,
        ], 200);
    }


    public function store()
    {
    }


    public function update()
    {
    }


    public function destroy()
    {
    }
}
