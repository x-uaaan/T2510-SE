@extends('layouts.app')
@vite('resources/js/event-create.js')

@section('content')
    <div id="event-create-app" data-organiser="{{ auth()->user()->id }}"></div>
@endsection