<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Campus Pulse | Events')</title>
    <link rel="website icon" type="png" href="/image/CampusPulseIcon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
</head>

<body class="bg-gray-100 min-h-screen">
    @yield('content')

    @stack('scripts')
</body>
</html>