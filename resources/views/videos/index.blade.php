<!DOCTYPE html>
@include('layouts.header')
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>VibeTube - Home</title>
    @vite('resources/css/app.css','resources/js/app.js')
</head>


<body class="bg-white text-gray-900">

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