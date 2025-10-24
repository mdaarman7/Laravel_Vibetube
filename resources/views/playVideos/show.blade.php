<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $video->title }} - VibeTube</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 text-gray-900">
    <div class="min-h-screen flex flex-col lg:flex-row justify-center">
        {{-- Main Video Section --}}
        <main class="flex-1 p-6 flex justify-center">
            <div class="w-full max-w-[1000px]">
                {{-- Back to Home --}}
                <div class="mb-4">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition">
                        ← Back to Home
                    </a>
                </div>

                {{-- Video Player --}}
                <div class="bg-black rounded-xl overflow-hidden mb-4">
                    <video id="videoPlayer" class="w-full aspect-video object-contain" controls preload="metadata">
                        <source src="{{ route('videos.stream', $video->id) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>

                {{-- Video Info --}}
                <div class="bg-white shadow-md rounded-xl p-4 mb-8">
                    <h1 class="text-2xl font-bold mb-2">{{ $video->title }}</h1>
                    <p class="text-gray-600">{{ $video->description }}</p>
                </div>

                {{-- Recommended Videos Section --}}
                <div class="mt-8">
                    <h2 class="text-xl font-bold mb-4">Recommended for You</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach ($recommendedVideos as $item)
                        <a href="{{ route('videos.show', $item->id) }}"
                            class="block bg-white shadow-md hover:shadow-lg rounded-lg overflow-hidden transition">
                            <img src="{{ $item->thumbnail_path ? asset('storage/'.$item->thumbnail_path) : asset('images/default-thumb.jpg') }}"
                                alt="thumbnail" class="w-full h-40 object-cover">
                            <div class="p-3">
                                <h3 class="text-sm font-semibold">{{ Str::limit($item->title, 50) }}</h3>
                                <p class="text-xs text-gray-600 mt-1">{{ Str::limit($item->description, 60) }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </main>
 
        {{-- Sidebar: Up Next  --}}
        <aside class="w-full lg:w-[400px] bg-gray-50 border-l border-gray-200 p-4">
            <h2 class="text-xl font-bold mb-4">Up Next</h2>
            <div class="space-y-4">
                @foreach ($upNextVideos as $item)
                <a href="{{ route('videos.show', $item->id) }}"
                    class="flex items-start bg-white shadow-sm hover:shadow-md rounded-lg overflow-hidden transition">
                    <img src="{{ $item->thumbnail_path ? asset('storage/'.$item->thumbnail_path) : asset('images/default-thumb.jpg') }}"
                        alt="thumbnail"
                        class="w-40 h-24 object-cover flex-shrink-0">
                    <div class="p-3 flex flex-col justify-between">
                        <h3 class="text-sm font-semibold leading-tight">{{ Str::limit($item->title, 50) }}</h3>
                        <p class="text-xs text-gray-600 mt-1">{{ Str::limit($item->description, 60) }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </aside>
    </div>
</body>

</html>