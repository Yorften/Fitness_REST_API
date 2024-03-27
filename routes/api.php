<?php

use App\Http\Controllers\SessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// This route is for unauthenticated users that attempts to use tha api without valid access, the auth:sanctum middleware redirects to api/login if not authenticated using 'GET' request. why? i don't know but this was my solution to display an error message to the user.
Route::get('login', [UserAuthController::class, function () {
    return response()->json([
        'message' => 'Access denied.'
    ]);
}])->name('login');


Route::post('register', [UserAuthController::class, 'register'])->name('api.register');
Route::post('login', [UserAuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [UserAuthController::class, 'logout'])->name('logout');
    Route::get('sessions', [SessionController::class, 'index'])->name('session.index');
    Route::get('users/@me', [UserController::class, 'show'])->name('user.show');
    Route::delete('unsubscribe', [UserController::class, 'destroy'])->name('user.destroy');


    Route::middleware(['session'])->group(function () {
        Route::get('sessions/{session}', [SessionController::class, 'show'])->name('session.show');
        Route::put('sessions/{session}', [SessionController::class, 'update'])->name('session.update');
        Route::patch('sessions/{session}/status', [SessionController::class, 'status'])->name('session.status');
        Route::delete('sessions/{session}', [SessionController::class, 'destroy'])->name('session.destroy');
    });

    Route::post('sessions', [SessionController::class, 'store'])->name('session.store');
});
