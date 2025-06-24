<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\PostController;
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

/*
Route::middleware('auth:web')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
*/