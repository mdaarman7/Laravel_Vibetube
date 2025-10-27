<!DOCTYPE html>
<html>
<head>
    <title>Upload Video</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900 p-8" x-data="{ loading: false, dots: '' }" x-init="
    setInterval(() => {
        if(loading) dots = dots.length < 3 ? dots + '.' : '';
    }, 500);
">

    {{-- Back Button --}}
    <a href="{{ route('home') }}" class="text-blue-600 hover:underline">← Back to Home</a>

    <h1 class="text-3xl font-bold mt-4 mb-6">Upload a New Video</h1>

    {{-- Success Message --}}
    @if(session('success'))
        <p class="text-green-600">{{ session('success') }}</p>
    @endif

    {{-- Upload Form --}}
    <form id="uploadForm" action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white shadow-md rounded-lg p-6 w-full max-w-lg"
          @submit="loading = true">
        @csrf

        <input type="text" name="title" placeholder="Video Title" required
               class="w-full border rounded p-2 mb-4">

        <textarea name="description" placeholder="Description" class="w-full border rounded p-2 mb-4"></textarea>

        <label class="block mb-2">Video File</label>
        <input type="file" name="video" accept="video/*" required class="mb-4">

        <label class="block mb-2">Thumbnail (optional)</label>
        <input type="file" name="thumbnail" accept="image/*" class="mb-6">

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Upload Video
        </button>
    </form>

    {{-- Loading Overlay --}}
    <div x-show="loading" 
         class="fixed inset-0 bg-black bg-opacity-50 flex flex-col items-center justify-center z-50"
         style="display: none;">
        <img src="{{ asset('images/vibeTube_logo.png') }}" alt="Loading" class="w-24 h-24 animate-spin">
        <p class="text-white mt-4 text-lg font-semibold">
            Uploading<span x-text="dots"></span>
        </p>
    </div>

</body>
</html>
