<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // The issue is that Request doesn't have a user() method by default
        // We need to use Auth facade to get the authenticated user
        $user = Auth::user();
        if (!$user) {
            return Redirect::route('login');
        }

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function complete(Request $request)
    {
        if ($request->isMethod('get')) {
            return Inertia::render('CompleteProfile');
        }

        $validated = $request->validate([
            'username' => ['required', 'min:5'],
            'phone' => ['required'],
            'faculty' => ['required'],
            'resume' => ['nullable', 'file', 'max:2048'],
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Update user profile with validated data
        $user->username = $validated['username'];
        $user->phone = $validated['phone'];
        $user->faculty = $validated['faculty'];
        
        // Handle resume upload if provided
        if ($request->hasFile('resume')) {
            $path = $request->file('resume')->store('resumes', 'public');
            $user->resume_path = $path;
        }
        
        // Mark profile as completed
        $user->profile_completed = true;
        $user->save();

        return redirect()->route('events.index')->with('success', 'Profile completed successfully!');
    }
}
