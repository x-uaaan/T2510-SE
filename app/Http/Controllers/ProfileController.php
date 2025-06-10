<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        try {
            $user = Auth::user();
            if (!$user) {
                return redirect()->route('login')->with('error', 'Please log in to complete your profile.');
            }

            $validated = $request->validate([
                'username' => [
                    'required',
                    'string',
                    'min:5',
                    'max:255',
                    'unique:users,username,' . $user->id,
                    'regex:/^[a-zA-Z0-9_]+$/', // Only letters, numbers, and underscores
                ],
                'phone' => [
                    'required',
                    'string',
                    'max:20',
                    'regex:/^\+?[0-9\s-()]+$/', // Basic phone number format
                ],
                'faculty' => [
                    'required',
                    'string',
                    'max:255',
                    'in:' . implode(',', [
                        'Faculty of Engineering',
                        'Faculty of Engineering & Technology',
                        'Faculty of Artificial Intelligence & Engineering',
                        'Faculty of Business',
                        'Faculty of Management',
                        'Faculty of Computing & Infomatics',
                        'Faculty of Information Science & Technology',
                        'Faculty of Creative Multimedia',
                        'Faculty of Cinematic Arts',
                        'Faculty of Applied Communication',
                        'Faculty of Law'
                    ]),
                ],
                'resume' => [
                    'nullable',
                    'file',
                    'mimes:pdf',
                    'max:2048', // 2MB max
                ],
            ], [
                'username.regex' => 'Username can only contain letters, numbers, and underscores.',
                'phone.regex' => 'Please enter a valid phone number.',
                'faculty.in' => 'Please select a valid faculty.',
                'resume.mimes' => 'Resume must be a PDF file.',
                'resume.max' => 'Resume must be less than 2MB.',
            ]);

            DB::beginTransaction();

            try {
                // Handle resume upload if present
                if ($request->hasFile('resume')) {
                    $path = $request->file('resume')->store('resumes', 'public');
                    if (!$path) {
                        throw new \Exception('Failed to upload resume.');
                    }
                    $user->resume_path = $path;
                }

                // Update user profile
                $user->username = $validated['username'];
                $user->phone = $validated['phone'];
                $user->faculty = $validated['faculty'];
                $user->profile_completed = true;
                $user->save();

                // Create or update alumni record
                $alumni = \App\Models\Alumni::updateOrCreate(
                    ['alumniEmail' => $user->email],
                    [
                        'alumniName' => $user->name,
                        'alumniPhone' => $validated['phone'],
                        'alumniFaculty' => $validated['faculty'],
                        'alumniResume' => $user->resume_path,
                    ]
                );

                DB::commit();

                return redirect()->route('profile.show')
                    ->with('success', 'Profile completed successfully!');
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Profile completion error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while completing your profile. Please try again.');
        }
    }

    public function show(Request $request)
    {
        $user = $request->user();

        // Example: Adjust these queries to match your actual relationships
        $forums = \App\Models\Forum::where('user_id', $user->id)->get(['forumID as id', 'forumTitle as title']);
        $posts = \App\Models\Post::where('alumniID', $user->id)->get(['postID as id', 'postTitle as title']);
        $events = \App\Models\Event::where('organiser', $user->email)->get(['id', 'eventName as title']);

        // Determine tag
        $isLecturer = \App\Models\Lecturer::where('lecturerEmail', $user->email)->exists();
        $isAlumni = \App\Models\Alumni::where('alumniEmail', $user->email)->exists();

        return Inertia::render('Profile/Profile', [
            'user' => [
                'username' => $user->username,
                'email' => $user->email,
                'faculty' => $user->faculty,
                'resume_path' => $user->resume_path,
                'is_lecturer' => $isLecturer,
                'is_alumni' => $isAlumni,
            ],
            'forums' => $forums,
            'posts' => $posts,
            'events' => $events,
        ]);
    }
}
