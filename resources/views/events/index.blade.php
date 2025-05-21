@extends('app')
@section('content')
<div class="min-h-screen bg-[#181828] py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-white mb-8">Events</h1>
        <div class="space-y-6">
            @forelse($events as $event)
                <div class="bg-[#23233a] rounded-xl shadow-lg flex items-center p-6 gap-6">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($event->eventName) }}&background=23233a&color=fff&size=128" alt="Event" class="w-20 h-20 rounded-full object-cover border-4 border-[#2d2d44]">
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-semibold text-white">{{ $event->eventName }}</h2>
                            <span class="text-sm text-gray-400">Organized by <span class="font-bold">{{ $event->admin->adminName ?? 'Unknown' }}</span></span>
                        </div>
                        <div class="flex flex-wrap items-center gap-4 mt-2 text-gray-300">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>{{ \Carbon\Carbon::parse($event->eventDate)->format('M d, Y') }} {{ $event->eventTime }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m13-6.13V7a4 4 0 00-3-3.87M9 4a4 4 0 00-3 3.87V7m0 0a4 4 0 003 3.87m6-3.87a4 4 0 013 3.87v.1"/></svg>
                                <span>{{ $event->attendees->count() }} {{ $event->attendees->count() === 1 ? 'attendee' : 'attendees' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 12.414a4 4 0 10-1.414 1.414l4.243 4.243a1 1 0 001.414-1.414z"/></svg>
                                <span>{{ $event->eventVenue === 'Online' ? 'Online' : $event->eventVenue }}</span>
                            </div>
                        </div>
                        <div class="mt-2 text-gray-400 text-sm">{{ $event->eventDesc }}</div>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-400 py-16">No events found.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
