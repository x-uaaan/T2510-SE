<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Event; // Make sure to import the Event model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AttendeeController extends Controller
{
    /**
     * Store a newly created resource in storage (One-Click RSVP).
     */
    public function store(Request $request, Event $event)
    {
        // Get the authenticated user
        $user = Auth::user();

        // If no user is authenticated, return an error
        if (!$user) {
            return response()->json(['message' => 'Authentication required.'], 401);
        }

        // Check if the user is already attending this event to prevent duplicates
        if (Attendee::where('userID', $user->userID)->where('eventID', $event->eventID)->exists()) {
            return response()->json(['message' => 'You are already attending this event.'], 409); // Conflict status code
        }

        try {
            $attendeeId = (string) Str::uuid();

            // Create a new attendee record with correct column names
            $attendee = Attendee::create([
                'attendeesID' => $attendeeId,
                'userID' => $user->userID,
                'eventID' => $event->eventID,
                'created_at' => now(),
            ]);

            // You can optionally return more data about the attendee if needed
            return response()->json([
                'message' => 'Successfully registered as an attendee.',
                'attendee' => $attendee
            ], 201); // 201 Created status code
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error registering attendee: ' . $e->getMessage(), ['user_id' => $user->userID, 'event_id' => $event->eventID]);
            return response()->json(['message' => 'Failed to register attendance. Please try again.'], 500); // Internal Server Error
        }
    }

    /**
     * Check if the authenticated user is attending a specific event.
     */
    public function checkAttendance(Event $event)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['isAttending' => false, 'message' => 'Not logged in.'], 200);
        }

        $isAttending = Attendee::where('userID', $user->userID)
                               ->where('eventID', $event->eventID)
                               ->exists();

        $message = $isAttending ? 'You are attending this event.' : '';

        return response()->json(['isAttending' => $isAttending, 'message' => $message]);
    }


    // The rest of your AttendeeController methods (index, create, show, edit, update, destroy) remain unchanged
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