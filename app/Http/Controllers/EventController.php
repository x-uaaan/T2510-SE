<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Http\Resources\EventResource;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

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
        // Only check for required fields and the three date/time rules
        $request->validate([
            'eventName' => 'required',
            'startDate' => 'required|date',
            'startTime' => 'required',
            'endDate' => 'required|date',
            'endTime' => 'required',
            'eventVenue' => 'required',
            'eventDesc' => 'required',
            'capacity' => 'required',
            'organiserId' => 'required',
            'organiserName' => 'required',
        ]);

        // Date/time logic
        $today = date('Y-m-d');
        if ($request->startDate < $today) {
            return response()->json(['message' => 'Start date must be today or later.'], 422);
        }
        if ($request->endDate < $request->startDate) {
            return response()->json(['message' => 'End date must be after or same as start date.'], 422);
        }
        if ($request->startDate === $request->endDate) {
            if (strtotime($request->endTime) <= strtotime($request->startTime)) {
                return response()->json(['message' => 'End time must be later than start time if on the same day.'], 422);
            }
        }

        // Handle image upload or set default
        if ($request->hasFile('eventImage')) {
            $imagePath = $request->file('eventImage')->store('event_images', 'public');
        } else {
            $imagePath = 'image/CampusPulseLogo.jpg'; // relative to public/
        }

        Event::create([
            'eventName' => $request->eventName,
            'eventImage' => $imagePath,
            'startDate' => $request->startDate,
            'startTime' => $request->startTime,
            'endDate' => $request->endDate,
            'endTime' => $request->endTime,
            'eventVenue' => $request->eventVenue,
            'eventDesc' => $request->eventDesc,
            'capacity' => $request->capacity,
            'organiser' => $request->organiserName,
            'organiserID' => $request->organiserId,
        ]);

        return response()->json(['success' => true]);
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