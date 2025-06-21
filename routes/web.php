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
use Illuminate\Foundation\Application;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SearchController;

Route::get('/', function () {
    Log::info('Root route accessed. Checking custom auth state.');
    // Check for our custom authentication session variable
    if (session()->has('authenticated_user_email')) {
        Log::info('Root route: authenticated_user_email found in session. Redirecting to events.');
        return redirect()->route('events.index');
    }
    Log::info('Root route: User not authenticated (custom check). Showing landing page.');
    return Inertia::render('Landing');
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

Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/profile/{user}', [ProfileController::class, 'showPublic'])->name('profile.public.show');

// Protected routes that require authentication using our custom middleware
Route::get('events', [EventController::class, 'index'])->name('events.index');
Route::resource('forum', ForumController::class);
Route::resource('posts', PostController::class);
Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
Route::post('/events', [EventController::class, 'store'])->name('events.store');
Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
Route::patch('/events/{event}', [EventController::class, 'update'])->name('events.update');

Route::post('/logout', function (Request $request) {
    session()->forget('authenticated_user_email');
    session()->forget('socialite_user_data');
    return redirect()->route('home')->with('success', 'You have been logged out.');
})->name('logout');

Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

Route::get('/searchpage/{keyword}', [SearchController::class, 'search'])->name('search.show');

require __DIR__.'/auth.php';