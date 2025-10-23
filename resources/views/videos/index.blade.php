<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>VibeTube - Home</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 bg-white p-6 shadow-md hidden md:block">
            <h2 class="text-xl font-bold mb-4">Trending</h2>
            <ul class="space-y-3 text-gray-700">
                <li><a href="#" class="hover:text-blue-600">#Football</a></li>
                <li><a href="#" class="hover:text-blue-600">#Gaming</a></li>
                <li><a href="#" class="hover:text-blue-600">#Music</a></li>
                <li><a href="#" class="hover:text-blue-600">#Vlogs</a></li>
                <li><a href="#" class="hover:text-blue-600">#Comedy</a></li>
            </ul>

            <div class="mt-8">
                <a href="{{ route('videos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Upload Video</a>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 p-6">
            <h1 class="text-3xl font-bold mb-6">Explore Videos</h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($videos as $video)
                    <a href="{{ route('videos.show', $video->id) }}" class="block bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                        <img src="{{ $video->thumbnail_path ? asset('storage/'.$video->thumbnail_path) : asset('images/default-thumb.jpg') }}"
                             alt="{{ $video->title }}"
                             class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold">{{ $video->title }}</h3>
                            <p class="text-gray-600 text-sm mt-1">{{ Str::limit($video->description, 60) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </main>
    </div>
</body>
</html>
