<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\Admin;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        // Use Laravel's built-in authentication system
        if (!Auth::check()) {
            return redirect()->route('auth.microsoft');
        }

        /** @var User $user */
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('auth.microsoft');
        }

        $user->load(['forums', 'posts', 'events.attendees.user']);

        // The resume path is stored relative to the 'storage/app/public' folder.
        // We need to create a public URL for it.
        if ($user->resume) {
            $user->resume_url = Storage::url($user->resume);
        } else {
            $user->resume_url = null;
        }

        foreach ($user->events as $event) {
            if ($event->image) {
                $event->image_url = Storage::url($event->image);
            } else {
                $event->image_url = null;
            }
        }

        return Inertia::render('Profile/Profile', [
            'user' => $user,
            'auth' => [
                'user' => $user,
            ],
        ]);
    }

    public function edit(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.microsoft');
        }

        /** @var User $user */
        $user = Auth::user();

        return Inertia::render('Profile/UpdateProfileForm', [
            'user' => $user,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('auth.microsoft');
        }

        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'phone' => 'required|string|max:20',
            'faculty' => 'required|string|max:255',
            'resume' => 'nullable|file|mimes:pdf|max:2048',
            'remove_resume' => 'nullable|boolean',
        ]);

        $user->phone = $validated['phone'];
        $user->faculty = $validated['faculty'];

        if ($request->boolean('remove_resume') && $user->resume) {
            Storage::disk('public')->delete($user->resume);
            $user->resume = null;
        } elseif ($request->hasFile('resume')) {
            if ($user->resume) {
                Storage::disk('public')->delete($user->resume);
            }
            $file = $request->file('resume');
            $username = Str::slug($user->username);
            $filename = $username . '_resume.' . $file->getClientOriginalExtension();
            $resumePath = $file->storeAs('resumes', $filename, 'public');
            $user->resume = $resumePath;
        }

        $user->save();

        return Redirect::route('profile.show');
    }

    public function showPublic(User $user)
    {
        $user->load(['forums', 'posts', 'events.attendees.user']);

        if ($user->resume) {
            $user->resume_url = Storage::url($user->resume);
        } else {
            $user->resume_url = null;
        }

        $authUser = Auth::check() ? Auth::user() : null;

        return Inertia::render('Profile/Profile', [
            'user' => $user,
            'auth' => [
                'user' => $authUser,
            ],
        ]);
    }

    public function showCompleteProfileForm()
    {
        $socialiteUserData = session('socialite_user_data');
        if (!$socialiteUserData) {
            return redirect()->route('home');
        }
        return Inertia::render('CompleteProfile', [
            'email' => $socialiteUserData['email'] ?? '',
            'name' => $socialiteUserData['name'] ?? '',
        ]);
    }

    public function store(Request $request)
    {
        Log::info('ProfileController: Starting profile completion process');
        
        // Validate the request
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'faculty' => 'required|string|max:255',
            'userType' => 'required|in:Alumni,Lecturer',
            'resume' => 'nullable|file|mimes:pdf|max:2048'
        ]);

        Log::info('ProfileController: Validation passed', [
            'email' => $validated['email'],
            'name' => $validated['name'],
            'userType' => $validated['userType']
        ]);

        try {
            // Handle resume upload if present
            $resumePath = null;
            if ($request->hasFile('resume')) {
                $file = $request->file('resume');
                $username = Str::slug($validated['name']);
                $filename = $username . '_resume.' . $file->getClientOriginalExtension();
                $resumePath = $file->storeAs('resumes', $filename, 'public');
                Log::info('ProfileController: Resume uploaded', ['path' => $resumePath]);
            }

            $socialiteUserData = session('socialite_user_data', []);

            // Generate a new user ID
            $lastUser = User::orderBy('userID', 'desc')->first();
            $lastIdNumber = $lastUser ? (int) substr($lastUser->userID, 4) : 0;
            $newId = 'usr_' . str_pad($lastIdNumber + 1, 3, '0', STR_PAD_LEFT);

            // Create new user
            $user = User::create([
                'userID' => $newId,
                'username' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'faculty' => $validated['faculty'],
                'userType' => $validated['userType'],
                'resume' => $resumePath,
                'microsoft_id' => $socialiteUserData['microsoft_id'] ?? null,
            ]);

            Log::info('ProfileController: User created successfully', ['id' => $user->userID]);
            
            // Use Laravel's authentication system to log in the new user
            Auth::login($user);
            
            // Regenerate session for security
            $request->session()->regenerate();
            
            // Clear the socialite data from session
            session()->forget('socialite_user_data');

            Log::info('ProfileController: Profile completion successful', [
                'email' => $validated['email'],
                'userType' => $validated['userType']
            ]);

            return Inertia::location(route('events.index'));

        } catch (\Exception $e) {
            Log::error('ProfileController: Error during profile completion', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors([
                'error' => 'An error occurred while saving your profile. Please try again.'
            ]);
        }
    }
}