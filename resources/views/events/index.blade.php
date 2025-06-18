@extends('layouts.app')
@section('title', 'Campus Pulse | Events')
@section('content')
    <div id="event-app" data-events='@json($events)'></div>
@endsection

@vite('resources/js/event-page.js')