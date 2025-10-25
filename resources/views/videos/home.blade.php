<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VibeTube - Home</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-900 text-white">

    <!-- Nav bar -->
    <nav class="bg-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-red-500">VibeTube</h1>
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="hover:text-red-400">Home</a>
                <a href="{{ url('/videos/upload') }}" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg font-medium">Upload</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-6 flex gap-6">
        
        <!-- Left Sidebar -->
        <aside class="w-1/4 bg-gray-800 rounded-xl p-4 flex flex-col gap-4">
            <h2 class="text-xl font-semibold mb-2">Trending</h2>
            <ul class="flex flex-col gap-2">
                @foreach($videos->take(5) as $video)
                    <li class="hover:bg-gray-700 rounded p-2">
                        <a href="{{ url('storage/' . $video->file_path) }}" class="flex items-center gap-2">
                            <img src="{{ $video->thumbnail_path ? url('storage/'.$video->thumbnail_path) : asset('images/default-thumb.jpg') }}" 
                                 class="w-16 h-10 object-cover rounded" alt="{{ $video->title }}">
                            <span class="truncate text-sm">{{ $video->title }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>

            <h2 class="text-xl font-semibold mt-4 mb-2">Categories</h2>
            <ul class="flex flex-col gap-2 text-gray-400 text-sm">
                <li class="hover:text-white cursor-pointer">Music</li>
                <li class="hover:text-white cursor-pointer">Gaming</li>
                <li class="hover:text-white cursor-pointer">Sports</li>
                <li class="hover:text-white cursor-pointer">News</li>
            </ul>
        </aside>

        <!-- Right Content (Videos Grid) -->
        <main class="flex-1">
            <h2 class="text-2xl font-semibold mb-4">Recommended Videos</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($videos as $video)
                    <div class="bg-gray-800 rounded-xl overflow-hidden hover:shadow-lg hover:scale-105 transform transition-all">
                        <a href="{{ url('storage/' . $video->file_path) }}" target="_blank">
                            <img src="{{ $video->thumbnail_path ? url('storage/'.$video->thumbnail_path) : asset('images/default-thumb.jpg') }}" 
                                 alt="{{ $video->title }}" class="w-full h-48 object-cover">
                        </a>
                        <div class="p-3">
                            <h3 class="text-lg font-semibold truncate">{{ $video->title }}</h3>
                            <p class="text-sm text-gray-400 mt-1 line-clamp-2">{{ $video->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </main>

    </div>
</body>
</html>
