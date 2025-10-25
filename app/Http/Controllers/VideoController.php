<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
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
            'video' => 'required|mimes:mp4,mov,avi|max:512000',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        // Upload video
        $videoPath = $request->file('video')->store('videos', 'public');

        // Upload thumbnail (optional)
        $thumbnailPath = $request->hasFile('thumbnail')
            ? $request->file('thumbnail')->store('thumbnails', 'public')
            : null;

        // Create video with user_id of currently logged-in user
        Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $videoPath,
            'thumbnail_path' => $thumbnailPath,
            'user_id' => Auth::id(), //  
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

        // Fetch up next videos (Random 10)
        $upNextVideos = Video::where('id', '!=', $id)
        ->inRandomOrder()
        ->take(10)
        ->get();
        
        // Fetch recommended videos (random 10)
        $recommendedVideos = Video::where('id', '!=', $id)
            ->latest()
            ->take(10)
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
    public function dashboard()
    {
        // Get videos uploaded by the logged-in user
        $videos = Video::where('user_id', Auth::id())->latest()->get();

        return view('videos.dashboard', compact('videos'));
    }
    public function search(Request $request)
    {
        $query = $request->get('query', '');

        $videos = Video::where('title', 'like', "%{$query}%")->get();

        // For AJAX suggestions
        if ($request->ajax()) {
            return response()->json($videos->pluck('title'));
        }

        // Return to the same page as your home/index page
        return view('videos.index', compact('videos'));
    }
}
