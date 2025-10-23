<!DOCTYPE html>
<html>
<head>
    <title>Upload Video</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 text-gray-900 p-8">
    <a href="{{ route('home') }}" class="text-blue-600 hover:underline">← Back to Home</a>

    <h1 class="text-3xl font-bold mt-4 mb-6">Upload a New Video</h1>

    @if(session('success'))
        <p class="text-green-600">{{ session('success') }}</p>
    @endif

    <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6 w-full max-w-lg">
        @csrf
        <input type="text" name="title" placeholder="Video Title" required class="w-full border rounded p-2 mb-4">
        <textarea name="description" placeholder="Description" class="w-full border rounded p-2 mb-4"></textarea>
        <label class="block mb-2">Video File</label>
        <input type="file" name="video" accept="video/*" required class="mb-4">
        <label class="block mb-2">Thumbnail (optional)</label>
        <input type="file" name="thumbnail" accept="image/*" class="mb-6">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Upload Video</button>
    </form>
</body>
</html>
