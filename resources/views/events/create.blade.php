@extends('layouts.app')
@vite('resources/js/event-create.js')

@section('content')
    <div id="event-create-app" data-organiser-id="{{ auth()->user()->id }}" data-organiser-name="{{ auth()->user()->name }}"></div>
@endsection