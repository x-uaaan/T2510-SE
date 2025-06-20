<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'userID' => 'required|string',
            'eventID' => 'required|string',
        ]);

        // Prevent duplicate entries
        $existing = Attendee::where('userID', $validated['userID'])
                            ->where('eventID', $validated['eventID'])
                            ->first();

        if ($existing) {
            return response()->json(['message' => 'Already registered.'], 409);
        }

        // Generate new attendeesID
        $lastAttendee = Attendee::orderBy('attendeesID', 'desc')->first();
        $lastIdNumber = $lastAttendee ? (int) substr($lastAttendee->attendeesID, 4) : 0;
        $newId = 'att_' . str_pad($lastIdNumber + 1, 3, '0', STR_PAD_LEFT);

        $attendee = Attendee::create([
            'attendeesID' => $newId,
            'userID' => $validated['userID'],
            'eventID' => $validated['eventID'],
            'created_at' => now(),
        ]);

        return response()->json(['success' => true, 'attendee' => $attendee], 201);
    }

    /**
     * Check if a user is already registered for an event.
     */
    public function check(Request $request)
    {
        $validated = $request->validate([
            'userID' => 'required|string|exists:users,userID',
            'eventID' => 'required|string|exists:events,eventID',
        ]);

        $isRegistered = Attendee::where('userID', $validated['userID'])
                                ->where('eventID', $validated['eventID'])
                                ->exists();

        return response()->json(['registered' => $isRegistered]);
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
