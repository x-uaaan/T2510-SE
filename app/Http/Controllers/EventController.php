<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Http\Resources\EventResource;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    public function index()
    {
        // Check authentication in controller
        $authenticatedUserEmail = session('authenticated_user_email');
        
        if (!$authenticatedUserEmail) {
            return redirect()->route('auth.microsoft');
        }

        // Fetch all events from the database (including those seeded by EventSeeder)
        $events = \App\Models\Event::all();
        
        return view('events.index', [
            'events' => $events->toJson()
        ]);
    }

    public function create()
    {
        return Inertia::render('EventCreateForm');
    }

    public function store(Request $request)
    {
        // 1. Validate the request data
        $validatedData = $request->validate([
            'eventName' => 'required|string|max:255',
            'eventDesc' => 'required|string',
            'startDate' => 'nullable|date',
            'startTime' => 'nullable',
            'endDate' => 'nullable|date|after_or_equal:startDate',
            'endTime' => 'nullable',
            'eventVenue' => 'required|string|max:255',
            'capacity' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. Get organiser from session
        $userEmail = session('authenticated_user_email');
        if (!$userEmail) {
            return redirect()->route('login')->with('error', 'You must be logged in to create an event.');
        }

        $user = User::where('email', $userEmail)->first();
        if (!$user) {
            return back()->withErrors(['error' => 'Authenticated user not found.'])->withInput();
        }
        
        // 3. Handle image upload
        $imagePath = 'image/CampusPulseLogo.jpg'; // Default image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('event_images', 'public');
        }

        // 4. Generate new eventID
        $lastEvent = Event::orderBy('eventID', 'desc')->first();
        $lastIdNumber = $lastEvent ? (int) substr($lastEvent->eventID, 4) : 0;
        $newId = 'evt_' . str_pad($lastIdNumber + 1, 3, '0', STR_PAD_LEFT);
        
        // 5. Create and save the event
        try {
            Event::create([
                'eventID' => $newId,
                'eventName' => $validatedData['eventName'],
                'eventDesc' => $validatedData['eventDesc'],
                'startDate' => $validatedData['startDate'],
                'startTime' => $validatedData['startTime'],
                'endDate' => $validatedData['endDate'],
                'endTime' => $validatedData['endTime'],
                'eventVenue' => $validatedData['eventVenue'],
                'capacity' => $validatedData['capacity'],
                'organiserName' => $user->username,
                'organiserID' => $user->userID,
                'image' => $imagePath,
            ]);

            return redirect()->route('events.index')->with('success', 'Event created successfully!');

        } catch (\Exception $e) {
            Log::error('Event creation failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'An unexpected error occurred while creating the event. Please try again.'])->withInput();
        }
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validatedData = $request->validate([
            'eventName' => 'required|string|max:255',
            'eventDesc' => 'required',
            'eventDate' => 'required|date',
            'eventTime' => 'required',
            'eventVenue' => 'required|string|max:255',
        ]);

        $event->update($validatedData);
        return redirect()->route('events.index')->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully!');
    }

    public function apiIndex()
    {
        $events = Event::all();
        return EventResource::collection($events);
    }
}