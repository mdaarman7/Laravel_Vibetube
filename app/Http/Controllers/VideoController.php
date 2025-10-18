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
        // Validate the input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video' => 'required|mimes:mp4,mov,avi|max:204800', // max 200MB
        ]);

        // Store the video in public/videos
        $path = $request->file('video')->store('videos', 'public');

        // Save info in DB
        Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
        ]);

        return redirect()->back()->with('success', 'Video uploaded successfully!');
    }
    // public function index()
    // {
    //     $videos = Video::latest()->get(); // get all videos
    //     return view('videos.index', compact('videos'));
    // }

    // public function show(Video $video)
    // {
    //     return view('videos.show', compact('video'));
    // }
}
