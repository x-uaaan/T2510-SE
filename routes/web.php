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
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    Log::info('Root route accessed. Checking auth state.');
    // Check if user is authenticated using Laravel's built-in auth system
    if (Auth::check()) {
        Log::info('Root route: User is authenticated. UserID: ' . Auth::id() . '. Redirecting to events.');
        return redirect()->route('events.index');
    }
    Log::info('Root route: User not authenticated. Showing landing page.');
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

// Protected routes that require authentication
Route::middleware(['auth', 'web'])->group(function () {
    Route::get('events', [EventController::class, 'index'])->name('events.index');
    Route::resource('forum', ForumController::class);
    Route::resource('posts', PostController::class);
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::patch('/events/{event}', [EventController::class, 'update'])->name('events.update');
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('home')->with('success', 'You have been logged out.');
})->name('logout');

Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

Route::get('/searchpage/{keyword}', [SearchController::class, 'search'])->name('search.show');

// Temporary debug route - remove after testing
Route::get('/debug-auth', function () {
    return response()->json([
        'authenticated' => Auth::check(),
        'user_id' => Auth::id(),
        'user' => Auth::user(),
        'session_data' => session()->all(),
        'guard' => Auth::getDefaultDriver(),
    ]);
})->name('debug.auth');

Route::get('/test', function () {
    return response()->json(['message' => 'Laravel is working!', 'timestamp' => now()]);
});

require __DIR__.'/auth.php';