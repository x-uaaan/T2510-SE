<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use Illuminate\Http\Request;

class AttendeeController extends Controller
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
            'user_id' => 'required|string',
            'event_id' => 'required|string',
        ]);
        // Generate new attendeesID
        $lastAttendee = \App\Models\Attendee::orderBy('attendeesID', 'desc')->first();
        $lastIdNumber = $lastAttendee ? (int) substr($lastAttendee->attendeesID, 4) : 0;
        $newId = 'att_' . str_pad($lastIdNumber + 1, 3, '0', STR_PAD_LEFT);
        // Prevent duplicate RSVP
        $exists = \App\Models\Attendee::where('userID', $validated['user_id'])
            ->where('eventID', $validated['event_id'])
            ->exists();
        if ($exists) {
            return response()->json(['message' => 'Already registered'], 200);
        }
        $attendee = \App\Models\Attendee::create([
            'attendeesID' => $newId,
            'userID' => $validated['user_id'],
            'eventID' => $validated['event_id'],
        ]);
        return response()->json(['success' => true, 'attendee' => $attendee]);
    }

    /**
     * Check if a user is already registered for an event.
     */
    public function check(Request $request)
    {
        $userId = $request->query('user_id');
        $eventId = $request->query('event_id');
        $registered = \App\Models\Attendee::where('userID', $userId)
            ->where('eventID', $eventId)
            ->exists();
        return response()->json(['registered' => $registered]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendee $attendee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendee $attendee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendee $attendee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendee $attendee)
    {
        //
    }
}
