<!DOCTYPE html>
<html>

<head>
    <title>All Videos</title>
</head>

<body>
    <h1>Uploaded Videos</h1>

    @foreach ($videos as $video)
    <div style="margin-bottom:40px;">
        <h3>{{ $video->title }}</h3>
        <p>{{ $video->description }}</p>

        <video width="640" height="360" controls
            @if($video->thumbnail_path) poster="{{ url('storage/' . $video->thumbnail_path) }}" @endif>
            <source src="{{ url('storage/' . $video->file_path) }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        {{-- Optional fallback thumbnail if poster isn't supported: --}}
        <!-- @if(!$video->thumbnail_path) -->
        <!-- <p><img src="{{ url('storage/default-thumbnail.jpg') }}" alt="default thumbnail" style="width:320px;"></p> -->
        @endif
    </div>
    @endforeach

</body>

</html>