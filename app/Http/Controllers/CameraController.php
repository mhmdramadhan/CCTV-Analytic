<?php

// app/Http/Controllers/CameraController.php
namespace App\Http\Controllers;

use App\Models\Camera;
use Illuminate\Http\Request;

class CameraController extends Controller
{
    public function index()
    {
        $cameras = Camera::latest()->get();
        return view('cameras.index', compact('cameras'));
    }

    public function create()
    {
        return view('cameras.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'stream_url' => 'required|url',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_active' => 'boolean',
            'lanes' => 'required|integer|min:1|max:2',
            'line_config' => 'required|array'
        ]);

        $validated['is_active'] = true;

        Camera::create($validated);

        return redirect()->route('cameras.index')
            ->with('success', 'CCTV berhasil ditambahkan!');
    }

    public function edit(Camera $camera)
    {
        return view('cameras.edit', compact('camera'));
    }

    public function update(Request $request, Camera $camera)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'stream_url' => 'required|url',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_active' => 'boolean',
            'lanes' => 'required|integer|min:1|max:2',
            'line_config' => 'required|array'
        ]);

        $camera->update($validated);

        return redirect()->route('cameras.index')
            ->with('success', 'CCTV berhasil diupdate!');
    }

    public function destroy(Camera $camera)
    {
        $camera->delete();

        return redirect()->route('cameras.index')
            ->with('success', 'CCTV berhasil dihapus!');
    }

    public function toggle(Camera $camera)
    {
        $camera->update(['is_active' => !$camera->is_active]);

        return back()->with('success', 'Status CCTV berhasil diubah!');
    }
}
