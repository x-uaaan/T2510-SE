<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" type="png" href="/image/CampusPulseIcon.png">
    <title>Campus Pulse</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/js/app.js')
</head>
<body class="bg-[#232323] text-white font-['Inter']">
    @inertia
    <div id="app">
        <div class="w-full flex justify-end items-center px-8 py-6 bg-[#18191A] fixed top-0 left-0 z-50 shadow">
            <a href="{{ route('login.microsoft') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition">Login / Register with Microsoft</a>
        </div>
        <div class="pt-28">
        </div>
    </div>
</body>
</html>