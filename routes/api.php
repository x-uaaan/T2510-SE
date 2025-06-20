<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\PostController;
use App\Models\User;
use App\Http\Controllers\AttendeeController;

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
Route::post('/attendees', [AttendeeController::class, 'store']);
Route::get('/attendees/check', [AttendeeController::class, 'check']);

Route::middleware('web')->get('/user', function (Request $request) {
    $email = session('authenticated_user_email');
    $user = null;
    $role = null;
    $userId = null;
    $userName = null;
    if ($email) {
        if ($user = User::where('email', $email)->first()) {
            $role = strtolower($user->userType);
            $userId = $user->userID;
            $userName = $user->username; 
        }
    }
    return response()->json([
        'id' => $userId,
        'name' => $userName ?? 'User',
        'role' => $role,
    ]);
}); 