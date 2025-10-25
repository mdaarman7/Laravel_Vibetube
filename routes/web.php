<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

// Home → shows all videos
Route::get('/', [VideoController::class, 'home'])->name('home');

// Upload routes
Route::get('/videos/upload', [VideoController::class, 'create'])->name('videos.create');
Route::post('/videos/upload', [VideoController::class, 'store'])->name('videos.store');

// Video pages
Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');
Route::get('/videos/{id}', [VideoController::class, 'show'])->name('videos.show');

Route::get('/videos/stream/{id}', [VideoController::class, 'stream'])->name('videos.stream');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [VideoController::class, 'dashboard'])->name('dashboard');
});

Route::get('/search', [VideoController::class, 'search'])->name('videos.search');

// Auth routes (if using Breeze/Jetstream)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
