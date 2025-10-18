<!DOCTYPE html>
<html>

<head>
    <title>Upload Video</title>
</head>

<body>
    @if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
    @endif

    @if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
    @endif

    <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="title" placeholder="Title" required><br><br>
        <textarea name="description" placeholder="Description"></textarea><br><br>
        <input type="file" name="video" accept="video/*" required><br><br>
        <label>Thumbnail (optional)</label>
        <input type="file" name="thumbnail" accept="image/*" ><br><br>
        <button type="submit">Upload Video</button>
    </form>
</body>

</html>