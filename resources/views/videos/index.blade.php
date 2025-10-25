<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>VibeTube - Home</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-white text-gray-900">

    {{-- Top Navigation --}}
    <header class="flex justify-between items-center px-6 py-4 shadow-md bg-white sticky top-0 z-50">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center space-x-2">
            <img src="{{ asset('images/vibeTube_logo.png') }}" alt="VibeTube Logo" class="w-12 h-auto">
            <span class="text-2xl font-bold text-gray-800">VibeTube</span>
        </a>

        {{-- Search Bar --}}
        <div class="flex items-center w-1/2">
            <input type="text" placeholder="Search..."
                class="w-full border border-gray-300 rounded-l-md px-4 py-2 focus:outline-none focus:ring-1 focus:ring-gray-400">
            <button class="bg-gray-100 border border-l-0 border-gray-300 rounded-r-md px-4 py-2 hover:bg-gray-200 transition">
                🔍
            </button>
        </div>

        {{-- Auth Buttons / User Info --}}
        <div class="flex items-center space-x-3">
            @auth
                <span class="text-gray-700 font-medium">Hello, {{ Auth::user()->name }}</span>

                <a href="{{ route('dashboard') }}" class="bg-gray-100 text-gray-800 px-4 py-2 rounded hover:bg-gray-200 transition">
                    Dashboard
                </a>

                <a href="{{ route('videos.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded hover:bg-gray-800 transition">
                    Upload
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 transition">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="bg-gray-900 text-white px-4 py-2 rounded hover:bg-gray-800 transition">
                    Login
                </a>
                <a href="{{ route('register') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 transition">
                    Register
                </a>

                {{-- Upload button redirects to login if not authenticated --}}
                <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Upload
                </a>
            @endauth
        </div>

    </header>

    {{-- Main Content --}}
    <main class="p-6">
        <h1 class="text-3xl font-bold mb-6">Explore Videos</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($videos as $video)
                <a href="{{ route('videos.show', $video->id) }}"
                    class="block bg-white border rounded-lg shadow hover:shadow-lg transition transform hover:-translate-y-1 overflow-hidden">
                    <img src="{{ $video->thumbnail_path ? asset('storage/'.$video->thumbnail_path) : asset('images/default-thumb.jpg') }}"
                        alt="{{ $video->title }}"
                        class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold truncate">{{ $video->title }}</h3>
                        <p class="text-gray-600 text-sm mt-1">{{ Str::limit($video->description, 60) }}</p>
                    </div>
                </a>
            @empty
                <p class="text-gray-500 text-center w-full">No videos found.</p>
            @endforelse
        </div>
    </main>
</body>

</html>
