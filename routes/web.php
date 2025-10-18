<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/videos/upload', [VideoController::class, 'create']);
Route::post('/videos/upload', [VideoController::class, 'store'])->name('videos.store');
 
Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');
