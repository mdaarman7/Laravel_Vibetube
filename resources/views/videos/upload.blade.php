<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Video - VibeTube</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gray-100 text-gray-900 min-h-screen flex items-center justify-center p-6"
      x-data="{ loading: false, dots: '' }"
      x-init="setInterval(() => { if (loading) dots = dots.length < 3 ? dots + '.' : ''; }, 500)">

    {{-- Upload Card --}}
    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-md mx-auto">
        
        {{-- Back Button --}}
        <div class="text-center mb-4">
            <a href="{{ route('home') }}" 
               class="text-gray-600 hover:text-blue-600 text-sm font-medium flex items-center justify-center gap-1 transition">
                ← Back to Home
            </a>
        </div>

        {{-- Header --}}
        <div class="text-center mb-6">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Upload a New Video</h1>
            <p class="text-gray-500 text-sm">Share your creativity with the world 🌍</p>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 border border-green-300 rounded-md p-3 mb-4 text-sm text-center">
                {{ session('success') }}
            </div>
        @endif

        {{-- Upload Form --}}
        <form id="uploadForm" action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data"
              class="flex flex-col space-y-4"
              @submit="loading = true">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Video Title</label>
                <input type="text" name="title" placeholder="Enter a catchy title" required
                       class="w-full border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" placeholder="Add a short description..."
                          class="w-full border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Video File</label>
                <input type="file" name="video" accept="video/*" required
                       class="w-full border border-gray-300 rounded-lg p-2.5 cursor-pointer bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Thumbnail (optional)</label>
                <input type="file" name="thumbnail" accept="image/*"
                       class="w-full border border-gray-300 rounded-lg p-2.5 cursor-pointer bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <button type="submit"
                    class="bg-blue-600 text-white py-2.5 rounded-lg font-medium hover:bg-blue-700 transition-all duration-200 shadow-md">
                ⬆️ Upload Video
            </button>
        </form>
    </div>

    {{-- Loading Overlay --}}
    <div x-show="loading" 
         class="fixed inset-0 bg-black bg-opacity-50 flex flex-col items-center justify-center z-50"
         style="display: none;">
        <img src="{{ asset('images/vibeTube_logo.png') }}" alt="Loading" class="w-20 h-20 animate-spin">
        <p class="text-white mt-4 text-lg font-semibold">
            Uploading<span x-text="dots"></span>
        </p>
    </div>

</body>
</html>
