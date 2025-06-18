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
        $validatedData = $request->validate([
            'eventImage' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'eventName' => 'required|string|max:255',
            'startDate' => 'required|date|after_or_equal:today',
            'startTime' => 'required|date_format:H:i|after_or_equal:08:00|before_or_equal:24:00',
            'endDate' => 'required|date|after_or_equal:startDate|after_or_equal:startDate',
            'endTime' => 'required|date_format:H:i|after:startTime|before_or_equal:24:00',
            'eventDesc' => 'required',
            'eventVenue' => 'required|string|max:255',
            'capacity' => 'nullable|integer',
            'organiser' => 'required|string|max:255',
        ]);

        // Handle image upload
        if ($request->hasFile('eventImage')) {
            $imagePath = $request->file('eventImage')->store('event_images', 'public');
            $validatedData['eventImage'] = $imagePath;
        }

        \App\Models\Event::create($validatedData);

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