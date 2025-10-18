<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;

class VideoController extends Controller
{
    public function create()
    {
        return view('videos.upload'); // form view
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video' => 'required|mimes:mp4,mov,avi|max:204800', // 200MB
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120', // 5MB
        ]);

        // Store video
        $videoPath = $request->file('video')->store('videos', 'public');

        // Store thumbnail if provided
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $videoPath,
            'thumbnail_path' => $thumbnailPath,
        ]);

        return redirect()->back()->with('success', 'Video uploaded successfully!');
    }
    public function index()
    {
        $videos = Video::latest()->get(); // get all videos
        return view('videos.index', compact('videos'));
    }

    // public function show(Video $video)
    // {
    //     return view('videos.show', compact('video'));
    // }
}
