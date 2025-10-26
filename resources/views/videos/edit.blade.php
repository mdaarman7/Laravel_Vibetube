<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Video - {{ $video->title }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="max-w-2xl mx-auto py-10">
        <h1 class="text-2xl font-bold mb-6">Edit Video</h1>

        <form action="{{ route('videos.update', $video->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Title</label>
                <input type="text" name="title" value="{{ old('title', $video->title) }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea name="description" rows="4"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('description', $video->description) }}</textarea>
            </div>

            <div class="flex space-x-3">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    💾 Save Changes
                </button>

                <a href="{{ route('videos.show', $video->id) }}"
                    class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</body>
</html>
