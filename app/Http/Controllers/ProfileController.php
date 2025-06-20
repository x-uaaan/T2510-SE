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

class ProfileController extends Controller
{
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
            'userType' => $validated['userType']
        ]);

        try {
            // Handle resume upload if present
            $resumePath = null;
            if ($request->hasFile('resume')) {
                $resumePath = $request->file('resume')->store('resumes', 'public');
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
            
            // Set the authenticated user email in session
            session(['authenticated_user_email' => $validated['email']]);
            
            // Clear the socialite data from session
            session()->forget('socialite_user_data');

            Log::info('ProfileController: Profile completion successful', [
                'email' => $validated['email'],
                'userType' => $validated['userType']
            ]);

            return redirect()->route('events.index');

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