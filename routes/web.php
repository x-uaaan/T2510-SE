<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Landing');
});

Route::get('/about', function () {
    return view('about');
});

Route::resource('events', EventController::class);
Route::resource('forums', ForumController::class);
Route::resource('posts', PostController::class);

Route::get('/auth/microsoft', [AuthController::class, 'redirectToMicrosoft']);
Route::get('/auth/microsoft/callback', [AuthController::class, 'handleMicrosoftCallback']);