<?php

// routes/api.php
use App\Http\Controllers\AnalyticsController;
use App\Models\Camera;
use Illuminate\Support\Facades\Route;

// Untuk Flask
Route::get('/cameras', function() {
    $cameras = Camera::where('is_active', true)->get();
    return response()->json(['success' => true, 'data' => $cameras]);
});

Route::post('/analytics', [AnalyticsController::class, 'store']);

// Untuk Frontend
Route::get('/analytics/latest/{camera_id}', [AnalyticsController::class, 'latest']);
Route::get('/analytics/realtime', [AnalyticsController::class, 'realtime']);