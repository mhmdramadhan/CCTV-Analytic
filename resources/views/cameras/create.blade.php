<!-- resources/views/cameras/create.blade.php -->

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
            <h2 class="text-3xl font-bold text-gray-800">Tambah CCTV Baru</h2>
        </div>

        <!-- Form -->
        <form action="{{ route('cameras.store') }}" method="POST" class="bg-white rounded-lg shadow-lg p-8">
            @csrf

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
                            value="{{ old('name') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                            placeholder="e.g., Tugu Kujang"
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
                            value="{{ old('location') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="e.g., Bogor, Jawa Barat"
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
                            value="{{ old('stream_url') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('stream_url') border-red-500 @enderror"
                            placeholder="https://restreamer3.kotabogor.go.id/memfs/xxx.m3u8"
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
                            value="{{ old('latitude') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="-6.5971"
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
                            value="{{ old('longitude') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="106.8060"
                        >
                    </div>

                    <!-- Is Active -->
                    <div class="md:col-span-2">
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="is_active" 
                                value="1"
                                {{ old('is_active', true) ? 'checked' : '' }}
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
                                {{ old('lanes', 1) == 1 ? 'checked' : '' }}
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
                                {{ old('lanes') == 2 ? 'checked' : '' }}
                            >
                            <span class="ml-2 text-sm font-medium text-gray-700">2 Jalur</span>
                        </label>
                    </div>
                </div>

                <!-- Line 1 Config (Always shown) -->
                <div class="bg-cyan-50 rounded-lg p-6 mb-4 border border-cyan-200">
                    <h4 class="font-bold text-cyan-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                        Garis Counting <span x-show="lanes == 2">1</span>
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- P1 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Point 1 (x, y)</label>
                            <div class="flex space-x-2">
                                <input 
                                    type="number" 
                                    name="line_config[line1][p1][]"
                                    value="{{ old('line_config.line1.p1.0', 0) }}"
                                    placeholder="X"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500"
                                    required
                                >
                                <input 
                                    type="number" 
                                    name="line_config[line1][p1][]"
                                    value="{{ old('line_config.line1.p1.1', 300) }}"
                                    placeholder="Y"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500"
                                    required
                                >
                            </div>
                        </div>

                        <!-- P2 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Point 2 (x, y)</label>
                            <div class="flex space-x-2">
                                <input 
                                    type="number" 
                                    name="line_config[line1][p2][]"
                                    value="{{ old('line_config.line1.p2.0', 1280) }}"
                                    placeholder="X"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500"
                                    required
                                >
                                <input 
                                    type="number" 
                                    name="line_config[line1][p2][]"
                                    value="{{ old('line_config.line1.p2.1', 300) }}"
                                    placeholder="Y"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Direction (only for 2 lanes) -->
                        <div x-show="lanes == 2" class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Arah Kendaraan
                            </label>
                            <select 
                                name="line_config[line1][direction]"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500"
                            >
                                <option value="up" {{ old('line_config.line1.direction', 'up') == 'up' ? 'selected' : '' }}>↑ Dari Bawah ke Atas (UP)</option>
                                <option value="down" {{ old('line_config.line1.direction') == 'down' ? 'selected' : '' }}>↓ Dari Atas ke Bawah (DOWN)</option>
                                <option value="left" {{ old('line_config.line1.direction') == 'left' ? 'selected' : '' }}>← Dari Kanan ke Kiri (LEFT)</option>
                                <option value="right" {{ old('line_config.line1.direction') == 'right' ? 'selected' : '' }}>→ Dari Kiri ke Kanan (RIGHT)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Line 2 Config (Only for 2 lanes) -->
                <div x-show="lanes == 2" class="bg-purple-50 rounded-lg p-6 border border-purple-200">
                    <h4 class="font-bold text-purple-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                        Garis Counting 2
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- P1 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Point 1 (x, y)</label>
                            <div class="flex space-x-2">
                                <input 
                                    type="number" 
                                    name="line_config[line2][p1][]"
                                    value="{{ old('line_config.line2.p1.0', 640) }}"
                                    placeholder="X"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                                >
                                <input 
                                    type="number" 
                                    name="line_config[line2][p1][]"
                                    value="{{ old('line_config.line2.p1.1', 300) }}"
                                    placeholder="Y"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                                >
                            </div>
                        </div>

                        <!-- P2 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Point 2 (x, y)</label>
                            <div class="flex space-x-2">
                                <input 
                                    type="number" 
                                    name="line_config[line2][p2][]"
                                    value="{{ old('line_config.line2.p2.0', 1280) }}"
                                    placeholder="X"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                                >
                                <input 
                                    type="number" 
                                    name="line_config[line2][p2][]"
                                    value="{{ old('line_config.line2.p2.1', 300) }}"
                                    placeholder="Y"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                                >
                            </div>
                        </div>

                        <!-- Direction -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Arah Kendaraan
                            </label>
                            <select 
                                name="line_config[line2][direction]"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                            >
                                <option value="up" {{ old('line_config.line2.direction') == 'up' ? 'selected' : '' }}>↑ Dari Bawah ke Atas (UP)</option>
                                <option value="down" {{ old('line_config.line2.direction', 'down') == 'down' ? 'selected' : '' }}>↓ Dari Atas ke Bawah (DOWN)</option>
                                <option value="left" {{ old('line_config.line2.direction') == 'left' ? 'selected' : '' }}>← Dari Kanan ke Kiri (LEFT)</option>
                                <option value="right" {{ old('line_config.line2.direction') == 'right' ? 'selected' : '' }}>→ Dari Kiri ke Kanan (RIGHT)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Helper Text -->
                <div class="mt-4 bg-blue-50 border-l-4 border-blue-600 p-4 rounded">
                    <div class="flex">
                        <svg class="h-5 w-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm text-blue-800">
                            <p class="font-semibold mb-1">Tips Positioning Garis:</p>
                            <ul class="list-disc ml-5 space-y-1">
                                <li><strong>1 Jalur:</strong> Taruh garis horizontal/vertikal di tengah area traffic</li>
                                <li><strong>2 Jalur:</strong> Bagi frame menjadi 2 area (kiri-kanan atau atas-bawah)</li>
                                <li>Koordinat (0,0) = kiri atas, (1280,720) = kanan bawah</li>
                                <li>Hindari area terlalu dekat dengan edge frame</li>
                            </ul>
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
                    Simpan CCTV
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function cameraForm() {
    return {
        lanes: {{ old('lanes', 1) }}
    }
}
</script>
@endsection