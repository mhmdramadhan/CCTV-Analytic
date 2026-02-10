<?php
// app/Http/Controllers/AnalyticsController.php

namespace App\Http\Controllers;

use App\Models\Camera;
use App\Models\TrafficAnalytic;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    /**
     * Store analytics dari Flask Worker
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'camera_id' => 'required|exists:cameras,id',
            'timestamp' => 'required|date',
            'sepeda_motor' => 'required|integer|min:0',
            'mobil_penumpang' => 'required|integer|min:0',
            'kendaraan_sedang' => 'required|integer|min:0',
            'bus_besar' => 'required|integer|min:0',
            'truk_barang' => 'required|integer|min:0',
            'total' => 'required|integer|min:0',
            'lane1_data' => 'nullable|array',  // ← BARU (untuk 2 lane)
            'lane2_data' => 'nullable|array'   // ← BARU (untuk 2 lane)
        ]);

        TrafficAnalytic::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Analytics data saved'
        ], 201);
    }

    /**
     * Get latest analytics untuk specific camera
     */
    public function latest($cameraId)
    {
        $analytic = TrafficAnalytic::where('camera_id', $cameraId)
            ->latest('timestamp')
            ->first();

        if (!$analytic) {
            return response()->json([
                'success' => false,
                'message' => 'No data found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $analytic
        ]);
    }

    /**
     * Get realtime data untuk semua active cameras
     */
    public function realtime()
    {
        $analytics = TrafficAnalytic::select('traffic_analytics.*')
            ->join('cameras', 'cameras.id', '=', 'traffic_analytics.camera_id')
            ->where('cameras.is_active', true)
            ->whereIn('traffic_analytics.id', function($query) {
                $query->selectRaw('MAX(id)')
                    ->from('traffic_analytics')
                    ->groupBy('camera_id');
            })
            ->get();

        return response()->json([
            'success' => true,
            'data' => $analytics
        ]);
    }
}