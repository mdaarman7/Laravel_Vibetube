<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>VibeTube - Home</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("searchInput");
        const searchButton = document.getElementById("searchButton");
        const suggestions = document.getElementById("suggestions");

        // On typing → fetch suggestions
        searchInput.addEventListener("input", function() {
            const query = this.value.trim();

            if (query.length < 1) {
                suggestions.classList.add("hidden");
                return;
            }

            fetch(`/search?query=${encodeURIComponent(query)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    suggestions.innerHTML = "";
                    if (data.length > 0) {
                        data.forEach(title => {
                            const li = document.createElement("li");
                            li.textContent = title;
                            li.className = "px-4 py-2 hover:bg-gray-100 cursor-pointer";
                            li.addEventListener("click", () => {
                                searchInput.value = title;
                                suggestions.classList.add("hidden");
                                window.location.href = `/search?query=${encodeURIComponent(title)}`;
                            });
                            suggestions.appendChild(li);
                        });
                        suggestions.classList.remove("hidden");
                    } else {
                        suggestions.classList.add("hidden");
                    }
                });
        });

        // Search button click
        searchButton.addEventListener("click", () => {
            const query = searchInput.value.trim();
            if (query) window.location.href = `/search?query=${encodeURIComponent(query)}`;
        });

        // Hide suggestions on click outside
        document.addEventListener("click", (e) => {
            if (!e.target.closest("#searchInput") && !e.target.closest("#suggestions")) {
                suggestions.classList.add("hidden");
            }
        });
    });
</script>

<body class="bg-white text-gray-900">

    {{-- Top Navigation --}}
    <header class="flex justify-between items-center px-6 py-4 shadow-md bg-white sticky top-0 z-50">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center space-x-2">
            <img src="{{ asset('images/vibeTube_logo.png') }}" alt="VibeTube Logo" class="w-12 h-auto">
            <span class="text-2xl font-bold text-gray-800">VibeTube</span>
        </a>

        {{-- Search Bar --}}
        <div class="relative flex items-center w-1/2">
            <input type="text" id="searchInput" placeholder="Search..."
                class="w-full border border-gray-300 rounded-l-md px-4 py-2 focus:outline-none focus:ring-1 focus:ring-gray-400"
                autocomplete="off">

            <button id="searchButton"
                class="bg-gray-100 border border-l-0 border-gray-300 rounded-r-md px-4 py-2 hover:bg-gray-200 transition">
                🔍
            </button>

            {{-- Suggestion dropdown --}}
            <ul id="suggestions"
                class="absolute left-0 top-full mt-1 w-full bg-white border border-gray-300 rounded shadow-md z-50 hidden">
            </ul>
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

        {{-- Show search results title if searching --}}
        @if(!empty($query))
        <h2 class="text-xl font-semibold mb-4">Search results for "{{ $query }}"</h2>
        @endif

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