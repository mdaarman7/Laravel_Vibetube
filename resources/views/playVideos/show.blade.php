<!DOCTYPE html>
@include('layouts.header')

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $video->title }} - VibeTube</title>
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gray-100 text-gray-900">
    {{-- Top Navigation --}}
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
                    <video id="videoPlayer" class="w-full aspect-video object-contain" controls autoplay>
                        <source src="{{ route('videos.stream', $video->id) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>

                {{-- Video Info --}}
                <div class="bg-white shadow-md rounded-xl p-4 mb-4">
                    <h1 class="text-2xl font-bold mb-1">{{ $video->title }}</h1>

                    {{-- Display uploader name --}}
                    @if ($video->user)
                    <p class="text-sm text-gray-500 mb-3">
                        Uploaded by:
                        <span class="font-medium text-gray-800">{{ $video->user->name }}</span>
                    </p>
                    @endif

                    <p class="text-gray-600">{{ $video->description }}</p>
                </div>

                {{-- Show Edit/Delete buttons only for video owner --}}
                @if (Auth::check() && Auth::id() === $video->user_id)
                <div x-data="{ open: false }" class="flex space-x-3 mt-2">

                    {{-- Edit --}}
                    <a href="{{ route('videos.edit', $video->id) }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        ✏️ Edit
                    </a>

                    {{-- Delete --}}
                    <button @click="open = true"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                        🗑️ Delete
                    </button>

                    {{-- Delete Confirmation Modal --}}
                    <div x-show="open"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-90"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-90"
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                        style="display: none;">
                        <div @click.away="open = false" class="bg-white rounded-lg p-6 w-96 shadow-lg">
                            <h2 class="text-xl font-bold mb-4">Confirm Deletion</h2>
                            <p class="mb-6">Are you sure you want to delete this video? This action cannot be undone.</p>
                            <div class="flex justify-end space-x-3">
                                <button @click="open = false" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 transition">
                                    Cancel
                                </button>
                                <form action="{{ route('videos.destroy', $video->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

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

        {{-- Sidebar: Up Next --}}
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

    {{-- Autoplay First Up Next Video --}}
    <script>
        const mainVideo = document.getElementById('videoPlayer');
        mainVideo.addEventListener('ended', () => {
            const firstUpNext = document.querySelector('aside .space-y-4 a');
            if (firstUpNext) {
                window.location.href = firstUpNext.href;
            }
        });
    </script>
</body>

</html>