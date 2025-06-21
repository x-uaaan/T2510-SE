<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\PostController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::middleware('api')->get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

Route::get('/api/events', [EventController::class, 'apiIndex']);
Route::get('/forum', [ForumController::class, 'apiIndex']);
Route::get('/forum/{forum}', [ForumController::class, 'apiShow']);
Route::delete('/forums/{forum}', [ForumController::class, 'apiDestroy']);
Route::put('/forums/{forum}', [ForumController::class, 'apiUpdate']);
Route::get('/posts', [PostController::class, 'apiIndex']);
Route::post('/forum', [ForumController::class, 'store']);
Route::post('/posts', [PostController::class, 'store']);
Route::delete('/posts/{post}', [PostController::class, 'apiDestroy']);
Route::post('/posts/{post}/comments', [PostController::class, 'addComment']);
Route::post('/posts/{post}', [PostController::class, 'apiUpdate']);

Route::get('/user', function (Request $request) {
    if (!session()->has('authenticated_user_email')) {
        return response()->json(['message' => 'Unauthenticated.'], 401);
    }

    $email = session('authenticated_user_email');
    $user = User::where('email', $email)->first();

    if ($user) {
        return response()->json([
            'id' => $user->userID,
            'name' => $user->username,
            'role' => strtolower($user->userType),
        ]);
    }
    
    return response()->json(['message' => 'User not found.'], 404);
}); 