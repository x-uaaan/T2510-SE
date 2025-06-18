<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\PostController;
use App\Models\Alumni;
use App\Models\Lecturer;
use App\Models\Admin;

Route::middleware('api')->get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

Route::get('/api/events', [EventController::class, 'apiIndex']);
Route::get('/forum', [ForumController::class, 'apiIndex']);
Route::get('/posts', [PostController::class, 'apiIndex']);


Route::middleware('web')->get('/user', function (Request $request) {
    $email = session('authenticated_user_email');
    $user = null;
    $role = null;
    $userId = null;
    $userName = null;
    if ($email) {
        if ($alumni = Alumni::where('alumniEmail', $email)->first()) {
            $user = $alumni;
            $role = 'alumni';
            $userId = $alumni->id;
            $userName = $alumni->alumniName;
        } elseif ($lecturer = Lecturer::where('lecturerEmail', $email)->first()) {
            $user = $lecturer;
            $role = 'lecturer';
            $userId = $lecturer->id;
            $userName = $lecturer->lecturerName;
        } elseif ($admin = Admin::where('AdminEmail', $email)->first()) {
            $user = $admin;
            $role = 'admin';
            $userId = $admin->id;
            $userName = $admin->adminName;
        }
    }
    return response()->json([
        'id' => $userId,
        'name' => $userName ?? 'User',
        'role' => $role,
    ]);
}); 