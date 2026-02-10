<!-- resources/views/cameras/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="cameraForm()">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('cameras.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar CCTV
            </a>
            <h2 class="text-3xl font-bold text-gray-800">Edit CCTV: {{ $camera->name }}</h2>
        </div>

        <!-- Form -->
        <form action="{{ route('cameras.update', $camera) }}" method="POST" class="bg-white rounded-lg shadow-lg p-8">
            @csrf
            @method('PUT')

            <!-- Basic Info Section -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b">Informasi Dasar</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama CCTV <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            value="{{ old('name', $camera->name) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                            required
                        >
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Lokasi
                        </label>
                        <input 
                            type="text" 
                            name="location"
                            value="{{ old('location', $camera->location) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                    </div>

                    <!-- Stream URL -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Stream URL (m3u8) <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="url" 
                            name="stream_url"
                            value="{{ old('stream_url', $camera->stream_url) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('stream_url') border-red-500 @enderror"
                            required
                        >
                        @error('stream_url')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Latitude -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Latitude
                        </label>
                        <input 
                            type="number" 
                            step="0.0000001" 
                            name="latitude"
                            value="{{ old('latitude', $camera->latitude) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                    </div>

                    <!-- Longitude -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Longitude
                        </label>
                        <input 
                            type="number" 
                            step="0.0000001" 
                            name="longitude"
                            value="{{ old('longitude', $camera->longitude) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                    </div>

                    <!-- Is Active -->
                    <div class="md:col-span-2">
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="is_active" 
                                value="1"
                                {{ old('is_active', $camera->is_active) ? 'checked' : '' }}
                                class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                            >
                            <span class="ml-3 text-sm font-medium text-gray-700">Aktifkan CCTV</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Lane Configuration Section -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b">Konfigurasi Jalur</h3>
                
                <!-- Number of Lanes -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Jumlah Jalur <span class="text-red-500">*</span>
                    </label>
                    <div class="flex space-x-4">
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="radio" 
                                name="lanes" 
                                value="1"
                                x-model="lanes"
                                class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-2 focus:ring-blue-500"
                                {{ old('lanes', $camera->lanes) == 1 ? 'checked' : '' }}
                            >
                            <span class="ml-2 text-sm font-medium text-gray-700">1 Jalur</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="radio" 
                                name="lanes" 
                                value="2"
                                x-model="lanes"
                                class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-2 focus:ring-blue-500"
                                {{ old('lanes', $camera->lanes) == 2 ? 'checked' : '' }}
                            >
                            <span class="ml-2 text-sm font-medium text-gray-700">2 Jalur</span>
                        </label>
                    </div>
                </div>

                @php
                    $lineConfig = old('line_config', $camera->line_config ?? []);
                    $line1 = $lineConfig['line1'] ?? ['p1' => [0, 300], 'p2' => [1280, 300]];
                    $line2 = $lineConfig['line2'] ?? ['p1' => [640, 300], 'p2' => [1280, 300], 'direction' => 'down'];
                @endphp

                <!-- Line 1 Config -->
                <div class="bg-cyan-50 rounded-lg p-6 mb-4 border border-cyan-200">
                    <h4 class="font-bold text-cyan-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                        Garis Counting <span x-show="lanes == 2">1</span>
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Point 1 (x, y)</label>
                            <div class="flex space-x-2">
                                <input 
                                    type="number" 
                                    name="line_config[line1][p1][]"
                                    value="{{ $line1['p1'][0] ?? 0 }}"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500"
                                    required
                                >
                                <input 
                                    type="number" 
                                    name="line_config[line1][p1][]"
                                    value="{{ $line1['p1'][1] ?? 300 }}"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500"
                                    required
                                >
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Point 2 (x, y)</label>
                            <div class="flex space-x-2">
                                <input 
                                    type="number" 
                                    name="line_config[line1][p2][]"
                                    value="{{ $line1['p2'][0] ?? 1280 }}"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500"
                                    required
                                >
                                <input 
                                    type="number" 
                                    name="line_config[line1][p2][]"
                                    value="{{ $line1['p2'][1] ?? 300 }}"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500"
                                    required
                                >
                            </div>
                        </div>

                        <div x-show="lanes == 2" class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Arah Kendaraan</label>
                            <select 
                                name="line_config[line1][direction]"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500"
                            >
                                <option value="up" {{ ($line1['direction'] ?? 'up') == 'up' ? 'selected' : '' }}>↑ UP</option>
                                <option value="down" {{ ($line1['direction'] ?? '') == 'down' ? 'selected' : '' }}>↓ DOWN</option>
                                <option value="left" {{ ($line1['direction'] ?? '') == 'left' ? 'selected' : '' }}>← LEFT</option>
                                <option value="right" {{ ($line1['direction'] ?? '') == 'right' ? 'selected' : '' }}>→ RIGHT</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Line 2 Config -->
                <div x-show="lanes == 2" class="bg-purple-50 rounded-lg p-6 border border-purple-200">
                    <h4 class="font-bold text-purple-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                        Garis Counting 2
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Point 1 (x, y)</label>
                            <div class="flex space-x-2">
                                <input 
                                    type="number" 
                                    name="line_config[line2][p1][]"
                                    value="{{ $line2['p1'][0] ?? 640 }}"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                                >
                                <input 
                                    type="number" 
                                    name="line_config[line2][p1][]"
                                    value="{{ $line2['p1'][1] ?? 300 }}"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                                >
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Point 2 (x, y)</label>
                            <div class="flex space-x-2">
                                <input 
                                    type="number" 
                                    name="line_config[line2][p2][]"
                                    value="{{ $line2['p2'][0] ?? 1280 }}"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                                >
                                <input 
                                    type="number" 
                                    name="line_config[line2][p2][]"
                                    value="{{ $line2['p2'][1] ?? 300 }}"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                                >
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Arah Kendaraan</label>
                            <select 
                                name="line_config[line2][direction]"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                            >
                                <option value="up" {{ ($line2['direction'] ?? '') == 'up' ? 'selected' : '' }}>↑ UP</option>
                                <option value="down" {{ ($line2['direction'] ?? 'down') == 'down' ? 'selected' : '' }}>↓ DOWN</option>
                                <option value="left" {{ ($line2['direction'] ?? '') == 'left' ? 'selected' : '' }}>← LEFT</option>
                                <option value="right" {{ ($line2['direction'] ?? '') == 'right' ? 'selected' : '' }}>→ RIGHT</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('cameras.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium">
                    Batal
                </a>
                <button 
                    type="submit" 
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium flex items-center"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update CCTV
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function cameraForm() {
    return {
        lanes: {{ old('lanes', $camera->lanes) }}
    }
}
</script>
@endsection