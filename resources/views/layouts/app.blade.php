<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Campus Pulse')</title>
    <link rel="website icon" type="png" href="/image/CampusPulseIcon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-100 min-h-screen" style="margin:0px; overflow-y: scroll; -webkit-scrollbar: none; -ms-overflow-style: none;">
    <style>
      body::-webkit-scrollbar {
        display: none;
      }
    </style>
    @yield('content')

    @stack('scripts')
</body>
</html>