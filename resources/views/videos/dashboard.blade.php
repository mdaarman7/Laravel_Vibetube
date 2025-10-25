<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            
            {{-- Left side: User Name --}}
            <div class="flex items-center space-x-3">
                <h1 class="text-3xl font-bold">My Uploaded Videos</h1>
                <span class="text-gray-600">| {{ Auth::user()->name }}</span>
            </div>

            {{-- Right side: Buttons --}}
            <div class="flex items-center space-x-3">
                {{-- Upload Video Button --}}
                <a href="{{ route('videos.create') }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Upload Video
                </a>

                {{-- Home Button --}}
                <a href="{{ route('home') }}" 
                   class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 transition">
                    Home
                </a>
            </div>
        </div>

        {{-- Videos Grid --}}
        @if ($videos->isEmpty())
            <p class="text-gray-500">You haven't uploaded any videos yet.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($videos as $video)
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
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
