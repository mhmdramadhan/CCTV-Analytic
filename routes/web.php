<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CameraController;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/camera/{camera}', [DashboardController::class, 'show'])->name('dashboard.show');

// CRUD Cameras
Route::resource('cameras', CameraController::class);
Route::patch('cameras/{camera}/toggle', [CameraController::class, 'toggle'])
    ->name('cameras.toggle');

// Video Proxy
// Route::get('/video-proxy/{camera_id}', function($cameraId) {
//     $flaskUrl = "http://localhost:5001/video/{$cameraId}";
    
//     return response()->stream(function() use ($flaskUrl) {
//         $context = stream_context_create([
//             'http' => ['timeout' => 300, 'ignore_errors' => true]
//         ]);
        
//         $stream = @fopen($flaskUrl, 'r', false, $context);
        
//         if ($stream) {
//             while (!feof($stream)) {
//                 echo fread($stream, 8192);
//                 @flush();
//             }
//             fclose($stream);
//         }
//     }, 200, [
//         'Content-Type' => 'multipart/x-mixed-replace; boundary=frame',
//         'Cache-Control' => 'no-cache, no-store, must-revalidate',
//         'Pragma' => 'no-cache',
//         'Expires' => '0',
//     ]);
// })->name('video.proxy');