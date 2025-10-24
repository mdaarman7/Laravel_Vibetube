<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Symfony\Component\HttpFoundation\StreamedResponse;


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
            'video' => 'required|mimes:mp4,mov,avi|max:512000', // 500MB
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

        // Fetch recommended videos (random 6)
        $recommendedVideos = Video::where('id', '!=', $id)
            ->inRandomOrder()
            ->take(6)
            ->get();

        // Fetch up next videos (latest 8)
        $upNextVideos = Video::where('id', '!=', $id)
            ->latest()
            ->take(20)
            ->get();

        return view('playVideos.show', compact('video', 'recommendedVideos', 'upNextVideos'));
    }
    public function stream($id)
    {
        $video = Video::findOrFail($id);
        $path = storage_path('app/public/' . $video->file_path);

        if (!file_exists($path)) {
            abort(404);
        }

        $size = filesize($path);
        $length = $size;
        $start = 0;
        $end = $size - 1;

        // Handle range requests
        if (isset($_SERVER['HTTP_RANGE'])) {
            $range = $_SERVER['HTTP_RANGE'];
            $range = str_replace('bytes=', '', $range);
            $range = explode('-', $range);

            $start = intval($range[0]);
            if (isset($range[1]) && is_numeric($range[1])) {
                $end = intval($range[1]);
            }
            $length = $end - $start + 1;
        }

        $headers = [
            'Content-Type' => 'video/mp4',
            'Accept-Ranges' => 'bytes',
            'Content-Length' => $length,
            'Content-Range' => "bytes $start-$end/$size",
        ];

        $response = new StreamedResponse(function () use ($path, $start, $end) {
            $handle = fopen($path, 'rb');
            fseek($handle, $start);
            $buffer = 1024 * 8;

            while (!feof($handle) && ftell($handle) <= $end) {
                echo fread($handle, $buffer);
                ob_flush();
                flush();
            }
            fclose($handle);
        }, 206, $headers);

        return $response;
    }
}
