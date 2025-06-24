<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Http\Resources\EventResource;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class EventController extends Controller
{
    public function index()
    {
        // Use Laravel's built-in authentication system
        if (!Auth::check()) {
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

        // 2. Get organiser from Laravel's authentication system
        if (!Auth::check()) {
            return redirect()->route('auth.microsoft')->with('error', 'You must be logged in to create an event.');
        }

        $user = Auth::user();
        if (!$user) {
            return back()->withErrors(['error' => 'Authenticated user not found.'])->withInput();
        }
        
        // 4. Generate new eventID
        $lastEvent = Event::orderBy('eventID', 'desc')->first();
        $lastIdNumber = $lastEvent ? (int) substr($lastEvent->eventID, 4) : 0;
        $newId = 'evt_' . str_pad($lastIdNumber + 1, 3, '0', STR_PAD_LEFT);

        // 3. Handle image upload (after eventID is generated)
        $imagePath = "event_images/{$newId}.jpg"; // Path to save in DB

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = "{$newId}.{$ext}";
            $imagePath = $file->storeAs('event_images', $filename, 'public');
        } else {
            // Copy the default image to the event_images directory with the event ID as the filename
            $defaultImage = public_path('image/CampusPulseLogo.jpg');
            $destination = public_path("storage/event_images/{$newId}.jpg");
            if (!File::exists(dirname($destination))) {
                File::makeDirectory(dirname($destination), 0755, true);
            }
            File::copy($defaultImage, $destination);
            // $imagePath is already set to event_images/{$newId}.jpg
        }

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

            return Inertia::location(route('events.index'));

        } catch (\Exception $e) {
            Log::error('Event creation failed: ' . $e->getMessage());
            return back()->withErrors(['image' => $e->getMessage()])->withInput();
        }
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        // Ensure the image URL is correctly formed for the frontend
        if ($event->image) {
            $event->image_url = Storage::url($event->image);
        } else {
            $event->image_url = null;
        }

        return Inertia::render('EventEditForm', [
            'event' => $event
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'eventName' => 'required|string|max:255',
            'eventDesc' => 'required|string',
            'startDate' => 'required|date',
            'startTime' => 'required',
            'endDate' => 'nullable|date|after_or_equal:startDate',
            'endTime' => 'nullable',
            'eventVenue' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'image' => 'nullable|image|max:2048', // Allow image updates
            'remove_image' => 'nullable|boolean',
        ]);

        // Handle image removal
        if ($request->boolean('remove_image') && $event->image) {
            Storage::disk('public')->delete($event->image);
            $validated['image'] = null;
        }
        // Handle new image upload
        elseif ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $file = $request->file('image');
            $eventName = Str::slug($validated['eventName']);
            $filename = $eventName . '_event.' . $file->getClientOriginalExtension();
            $validated['image'] = $file->storeAs('events', $filename, 'public');
        } else {
            // Keep the old image if no new one is uploaded and remove_image is false
            unset($validated['image']);
        }

        $event->update($validated);

        return Inertia::location(route('profile.show'));
    }

    public function destroy(Event $event)
    {
        // Delete attendees if not cascading
        $event->attendees()->delete();
        $event->delete();
        return response()->json(['success' => true]);
    }

    public function apiIndex()
    {
        $events = Event::all();
        return EventResource::collection($events);
    }
}