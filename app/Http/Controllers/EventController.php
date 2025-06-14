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
        // Fetch all events from the database (including those seeded by EventSeeder)
        $events = \App\Models\Event::all();

        // Pass the events as JSON to the Blade view for Vue to consume
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
            'eventName' => 'required|string|max:255',
            'eventDesc' => 'required',
            'eventDate' => 'required|date',
            'eventTime' => 'required',
            'eventVenue' => 'required|string|max:255',
            'capacity' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('event_images', 'public');
            $validatedData['image'] = $imagePath;
        }

        // Set organiser as current user's name or email
        $validatedData['organiser'] = Auth::user() ? (Auth::user()->name ?? Auth::user()->email) : 'Unknown';

        Event::create($validatedData);
        return redirect()->route('events.index')->with('success', 'Event created successfully!');
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