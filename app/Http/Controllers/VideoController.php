<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;

class VideoController extends Controller
{
    public function create()
    {
        return view('videos.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video' => 'required|mimes:mp4,mov,avi|max:204800', // 200MB
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120', // 5MB
        ]);

        $videoPath = $request->file('video')->store('videos', 'public');
        $thumbnailPath = $request->hasFile('thumbnail')
            ? $request->file('thumbnail')->store('thumbnails', 'public')
            : null;

        Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $videoPath,
            'thumbnail_path' => $thumbnailPath,
        ]);

        return redirect()->route('videos.index')->with('success', 'Video uploaded successfully!');
    }

    public function index()
    {
        $videos = Video::latest()->get();
        return view('videos.index', compact('videos'));
    }

    public function home()
    {
        $videos = Video::inRandomOrder()->get();
        return view('videos.index', compact('videos'));
    }

    public function show($id)
    {
        $video = Video::findOrFail($id);
        $otherVideos = Video::where('id', '!=', $id)->inRandomOrder()->take(6)->get();

        return view('playVideos.show', compact('video', 'otherVideos'));
    }
    public function stream($id)
    {
        $video = Video::findOrFail($id);
        $path = storage_path('app/public/' . $video->file_path);

        $stream = fopen($path, 'rb');
        $size = filesize($path);

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
        }, 200, [
            'Content-Type' => 'video/mp4',
            'Content-Length' => $size,
            'Accept-Ranges' => 'bytes',
        ]);
    }
}
