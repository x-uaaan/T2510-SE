<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MicrosoftController;
use App\Http\Controllers\ProfileController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Landing');
});

Route::get('/about', function () {
    return view('about');
});

Route::resource('events', EventController::class);
Route::resource('forum', ForumController::class);
Route::resource('posts', PostController::class);

Route::get('/auth/microsoft', [MicrosoftController::class, 'redirectToMicrosoft']);
Route::get('/auth/microsoft/callback', [MicrosoftController::class, 'handleMicrosoftCallback']);
Route::match(['get', 'post'], '/complete-profile', [ProfileController::class, 'complete'])->name('complete-profile');

Route::get('/events', function () {
    return view('events.index'); // Make sure this points to 'resources/views/events/index.blade.php'
});

Route::middleware(['auth'])->get('/profile', [ProfileController::class, 'show'])->name('profile.show');