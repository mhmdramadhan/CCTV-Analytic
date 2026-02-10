<?php

namespace App\Http\Controllers;

use App\Models\Camera;

class DashboardController extends Controller
{
    public function index()
    {
        $cameras = Camera::where('is_active', true)
            ->with('latestAnalytic')
            ->get();

        return view('dashboard.index', compact('cameras'));
    }

    /**
     * Detail: Show single CCTV dengan video analytics
     */
    public function show(Camera $camera)
    {
        $camera->load('latestAnalytic');
        
        return view('dashboard.show', compact('camera'));
    }
}
