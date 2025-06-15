<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\MicrosoftController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlumniController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

Route::get('/', function () {
    Log::info('Root route accessed. Checking custom auth state.');
    // Check for our custom authentication session variable
    if (session()->has('authenticated_user_email')) {
        Log::info('Root route: authenticated_user_email found in session. Redirecting to events.');
        return redirect()->route('events.index');
    }
    Log::info('Root route: User not authenticated (custom check). Showing landing page.');
    return Inertia::render('Landing'); // Or return view('app');
})->name('home');

Route::get('/about', function () {
    return view('about');
});

// Microsoft Authentication Routes
Route::get('/auth/microsoft', [MicrosoftController::class, 'redirectToMicrosoft'])->name('auth.microsoft');
Route::get('/auth/microsoft/callback', [MicrosoftController::class, 'handleMicrosoftCallback']);

// Profile completion routes (auth middleware only)
Route::middleware(['web'])->group(function () {
    Route::get('/complete-profile', [ProfileController::class, 'showCompleteProfileForm'])->name('complete-profile');
    Route::post('/complete-profile', [ProfileController::class, 'store'])->name('complete-profile.submit');
});

// Protected routes that require authentication using our custom middleware
Route::middleware(['custom.auth'])->group(function () { // Use our new middleware
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::resource('forum', ForumController::class);
    Route::resource('posts', PostController::class);
    // You might also need a route to clear the session for logout
    Route::post('/logout', function (Request $request) {
        session()->forget('authenticated_user_email');
        session()->forget('socialite_user_data');
        Log::info('User logged out (custom).');
        return redirect()->route('home')->with('success', 'You have been logged out.');
    })->name('logout');
});