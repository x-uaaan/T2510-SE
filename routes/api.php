<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\PostController;

Route::middleware('api')->get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

Route::get('/events', [EventController::class, 'apiIndex']);
Route::get('/forum', [ForumController::class, 'apiIndex']);
Route::get('/posts', [PostController::class, 'apiIndex']); 