<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EventController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FeedbackController;

Route::get('/events', [EventController::class, 'index']);
Route::get('/forums', [ForumController::class, 'index']);
Route::resource('events', EventController::class);
Route::resource('forums', ForumController::class);
Route::resource('posts', PostController::class);
Route::resource('feedback', FeedbackController::class);

Route::get('/', function () {
    return view('welcome'); // Default Laravel welcome page
}); 