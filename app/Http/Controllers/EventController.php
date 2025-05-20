<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'eventName' => 'required|string|max:255',
            'eventDesc' => 'required',
            'eventDate' => 'required|date',
            'eventTime' => 'required',
            'eventVenue' => 'required|string|max:255',
        ]);

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
}