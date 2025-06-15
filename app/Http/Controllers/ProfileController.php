<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use App\Models\Alumni;
use App\Models\Lecturer;
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
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'faculty' => 'required|string|max:255',
            'role' => 'required|in:alumni,lecturer',
            'resume' => 'nullable|file|mimes:pdf|max:2048'
        ]);

        Log::info('ProfileController: Validation passed', [
            'email' => $validated['email'],
            'role' => $validated['role']
        ]);

        try {
            // Handle resume upload if present
            $resumePath = null;
            if ($request->hasFile('resume')) {
                $resumePath = $request->file('resume')->store('resumes', 'public');
                Log::info('ProfileController: Resume uploaded', ['path' => $resumePath]);
            }

            if ($validated['role'] === 'alumni') {
                // Check if alumni already exists
                $existingAlumni = Alumni::where('alumniEmail', $validated['email'])->first();
                if ($existingAlumni) {
                    Log::warning('ProfileController: Alumni already exists', ['email' => $validated['email']]);
                    return redirect()->route('events.index');
                }

                // Create new alumni
                $alumni = Alumni::create([
                    'alumniName' => $validated['name'],
                    'alumniEmail' => $validated['email'],
                    'alumniPhone' => $validated['phone'],
                    'alumniFaculty' => $validated['faculty'],
                    'alumniResume' => $resumePath
                ]);

                Log::info('ProfileController: Alumni created successfully', ['id' => $alumni->id]);
            } else {
                // Check if lecturer already exists
                $existingLecturer = Lecturer::where('lecturerEmail', $validated['email'])->first();
                if ($existingLecturer) {
                    Log::warning('ProfileController: Lecturer already exists', ['email' => $validated['email']]);
                    return redirect()->route('events.index');
                }

                // Create new lecturer
                $lecturer = Lecturer::create([
                    'lecturerName' => $validated['name'],
                    'lecturerEmail' => $validated['email'],
                    'lecturerPhone' => $validated['phone'],
                    'lecturerFaculty' => $validated['faculty'],
                    'lecturerResume' => $resumePath
                ]);

                Log::info('ProfileController: Lecturer created successfully', ['id' => $lecturer->id]);
            }

            // Set the authenticated user email in session
            session(['authenticated_user_email' => $validated['email']]);
            
            // Clear the socialite data from session
            session()->forget('socialite_user_data');

            Log::info('ProfileController: Profile completion successful', [
                'email' => $validated['email'],
                'role' => $validated['role']
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