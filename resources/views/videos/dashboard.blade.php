<x-app-layout>
    <div x-data="{ open: false, deleteId: null }" class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">

        {{-- Header (only if videos exist) --}}
        @if($videos->count() > 0)
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('home') }}" 
               class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 transition">
                Home
            </a>

            <a href="{{ route('videos.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                + Upload Video
            </a>
        </div>
        @endif

        {{-- Videos --}}
        @if($videos->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($videos as $video)
            <div class="relative group bg-white border rounded-lg shadow hover:shadow-lg transition transform hover:-translate-y-1 overflow-hidden">

                {{-- Thumbnail --}}
                <a href="{{ route('videos.show', $video->id) }}">
                    <img src="{{ $video->thumbnail_path ? asset('storage/'.$video->thumbnail_path) : asset('images/default-thumb.jpg') }}"
                         alt="{{ $video->title }}"
                         class="w-full h-48 object-cover">
                </a>

                {{-- Edit/Delete --}}
                <div class="absolute top-2 right-2 flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <a href="{{ route('videos.edit', $video->id) }}"
                       class="bg-yellow-400 text-white px-2 py-1 rounded hover:bg-yellow-500 transition" title="Edit Video">
                        ✏️
                    </a>

                    <button @click.prevent="open = true; deleteId = {{ $video->id }}"
                            class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition"
                            title="Delete Video">
                        🗑️
                    </button>
                </div>

                {{-- Info --}}
                <div class="p-4">
                    <h3 class="text-lg font-semibold truncate">{{ $video->title }}</h3>
                    <p class="text-gray-600 text-sm mt-1">{{ Str::limit($video->description, 60) }}</p>
                </div>
            </div>
            @endforeach
        </div>

        @else
        {{-- No Videos Message with Animation --}}
        <div class="flex flex-col items-center justify-center text-center py-24 animate-fadeInUp">
            
            <h2 class="animate-bounceSlow text-2xl font-semibold text-gray-700 mb-3">No videos uploaded yet</h2>
            <p class="text-gray-500 mb-6">Start by uploading your first video to share your content.</p>
            <a href="{{ route('videos.create') }}" 
               class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                Upload Your First Video
            </a>
        </div>

        {{-- Custom Animations --}}
        <style>
            @keyframes fadeInUp {
                0% {
                    opacity: 0;
                    transform: translateY(30px);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes bounceSlow {
                0%, 100% {
                    transform: translateY(0);
                }
                50% {
                    transform: translateY(-10px);
                }
            }

            .animate-fadeInUp {
                animation: fadeInUp 0.8s ease-out both;
            }

            .animate-bounceSlow {
                animation: bounceSlow 2s infinite ease-in-out;
            }
        </style>
        @endif

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
                    <form :action="`/videos/${deleteId}`" method="POST">
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
</x-app-layout>
