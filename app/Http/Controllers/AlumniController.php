<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|min:5',
            'phone' => 'required|string',
            'faculty' => 'required|string',
            'resume' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        // Get Microsoft email from authenticated alumni
        $alumni = $request->user();
        $email = $alumni ? $alumni->email : null;

        // Handle resume upload
        $resumeUrl = null;
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
            $resumeUrl = asset('storage/' . $resumePath);
        }

        // Save to alumni table
        $alumni = \App\Models\Alumni::create([
            'alumniName' => $validated['username'],
            'alumniEmail' => $email,
            'alumniPhone' => $validated['phone'],
            'alumniFaculty' => $validated['faculty'],
            'alumniResume' => $resumeUrl,
        ]);

        // Optionally, mark alumni profile as completed
        if ($alumni) {
            $alumni->profile_completed = true;
            $alumni->save();
        }

        return redirect()->route('dashboard')->with('success', 'Profile completed successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Alumni $alumni)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alumni $alumni)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alumni $alumni)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumni $alumni)
    {
        //
    }
}
