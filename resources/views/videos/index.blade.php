<!DOCTYPE html>
<html>
<head>
    <title>All Videos</title>
</head>
<body>
    <h1>Uploaded Videos</h1>

    @foreach ($videos as $video)
        <div style="margin-bottom: 40px;">
            <h3>{{ $video->title }}</h3>
            <p>{{ $video->description }}</p>

            <video width="640" height="360" controls>
                <source src="{{ url('storage/' . $video->file_path) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>

            <!-- <p>Debug URL: {{ url('storage/' . $video->file_path) }}</p> -->
        </div>
    @endforeach
</body>
</html>
