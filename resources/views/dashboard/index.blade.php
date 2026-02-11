<!-- resources/views/dashboard/index.blade.php - FIXED MAP SECTION -->

@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8" x-data="dashboardMap()">
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-3xl font-bold">Traffic Monitoring System</h2>
            <a href="{{ route('cameras.create') }}"
                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah CCTV
            </a>
        </div>

        <!-- Search & Map Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <!-- Search Bar -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Ruas:</label>
                <div class="flex gap-4">
                    <input type="text" x-model="searchQuery" @input="filterCameras()"
                        placeholder="Cari CCTV berdasarkan nama atau lokasi..."
                        class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <button @click="filterCameras()"
                        class="bg-yellow-500 text-white px-8 py-3 rounded-lg hover:bg-yellow-600 font-semibold">
                        Cari
                    </button>
                </div>
            </div>

            <!-- Interactive Map Container - FIXED -->
            <div class="relative border-4 border-blue-200 rounded-lg overflow-hidden" style="height: 500px;">
                <!-- Map Element -->
                <div id="map" class="w-full h-full"></div>

                <!-- Map Legend -->
                <div class="absolute bottom-4 right-4 bg-white rounded-lg shadow-lg p-4 z-[1000]">
                    <h4 class="font-bold text-sm mb-2">Legend</h4>
                    <div class="space-y-2 text-xs">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-green-500 rounded-full mr-2"></div>
                            <span>Active CCTV</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-red-500 rounded-full mr-2"></div>
                            <span>Inactive CCTV</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-blue-500 rounded-full mr-2"></div>
                            <span>1 Lane</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-purple-500 rounded-full mr-2"></div>
                            <span>2 Lanes</span>
                        </div>
                    </div>
                </div>

                <!-- Map Stats -->
                <div class="absolute top-4 left-4 bg-white rounded-lg shadow-lg p-4 z-[1000]">
                    <h4 class="font-bold text-sm mb-2">Quick Stats</h4>
                    <div class="space-y-1 text-xs">
                        <div><span class="font-semibold">Total CCTV:</span> <span x-text="cameras.length"></span></div>
                        <div><span class="font-semibold">Active:</span> <span
                                x-text="cameras.filter(c => c.is_active).length"></span></div>
                        <div><span class="font-semibold">1 Lane:</span> <span
                                x-text="cameras.filter(c => c.lanes === 1).length"></span></div>
                        <div><span class="font-semibold">2 Lanes:</span> <span
                                x-text="cameras.filter(c => c.lanes === 2).length"></span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CCTV Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <template x-for="camera in filteredCameras" :key="camera.id">
                <a :href="`/camera/${camera.id}`" class="block">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1 cursor-pointer"
                        @mouseenter="highlightMarker(camera.id)" @mouseleave="unhighlightMarker(camera.id)">
                        <!-- Thumbnail -->
                        <div class="relative bg-gray-900 h-48 flex items-center justify-center">
                            <svg class="w-20 h-20 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                </path>
                            </svg>

                            <!-- Status Badge -->
                            <div class="absolute top-3 right-3 flex items-center text-xs px-3 py-1 rounded-full"
                                :class="camera.is_active ? 'bg-green-500 text-white' : 'bg-red-500 text-white'">
                                <span class="h-2 w-2 bg-white rounded-full mr-2"
                                    :class="{ 'animate-pulse': camera.is_active }"></span>
                                <span x-text="camera.is_active ? 'ACTIVE' : 'INACTIVE'"></span>
                            </div>

                            <!-- Lanes Badge -->
                            <div class="absolute top-3 left-3 text-white text-xs px-3 py-1 rounded-full font-semibold"
                                :class="camera.lanes === 2 ? 'bg-purple-600' : 'bg-blue-600'">
                                <span x-text="camera.lanes + (camera.lanes > 1 ? ' LANES' : ' LANE')"></span>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="p-5">
                            <h3 class="text-xl font-bold mb-2 text-gray-800" x-text="camera.name"></h3>
                            <p class="text-gray-600 text-sm mb-4 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span x-text="camera.location || 'Unknown Location'"></span>
                            </p>

                            <!-- Latest Count -->
                            <template x-if="camera.latest_analytic">
                                <div
                                    class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 border border-blue-100">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-700 text-sm font-medium">Total Kendaraan</span>
                                        <span class="text-3xl font-bold text-blue-600"
                                            x-text="camera.latest_analytic.total"></span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2"
                                        x-text="formatTime(camera.latest_analytic.timestamp)"></p>
                                </div>
                            </template>
                            <template x-if="!camera.latest_analytic">
                                <div class="bg-gray-100 rounded-lg p-4 text-center">
                                    <p class="text-gray-500 text-sm">Belum ada data</p>
                                </div>
                            </template>

                            <!-- View Detail Button -->
                            <div class="mt-4 text-center">
                                <span class="text-blue-600 text-sm font-semibold">
                                    Lihat Detail & Live Video →
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </template>

            <!-- Empty State -->
            <template x-if="filteredCameras.length === 0">
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                        </path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada CCTV ditemukan</h3>
                    <p class="mt-2 text-sm text-gray-500" x-show="searchQuery">Coba kata kunci pencarian lain</p>
                    <p class="mt-2 text-sm text-gray-500" x-show="!searchQuery && cameras.length === 0">Mulai dengan
                        menambahkan CCTV pertama Anda</p>
                    <div class="mt-6" x-show="cameras.length === 0">
                        <a href="{{ route('cameras.create') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            + Tambah CCTV
                        </a>
                    </div>
                </div>
            </template>
        </div>
    </div>

    @push('styles')
        <!-- Leaflet CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <style>
            /* Ensure map fills container properly */
            #map {
                width: 100% !important;
                height: 100% !important;
                z-index: 1;
            }

            /* Custom marker styles */
            .camera-marker {
                border-radius: 50%;
                border: 3px solid white;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            }

            .camera-marker.active {
                animation: pulse 2s infinite;
            }

            @keyframes pulse {

                0%,
                100% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.1);
                }
            }

            /* Fix for Leaflet attribution */
            .leaflet-container {
                font-family: inherit;
            }
        </style>
    @endpush

    @push('scripts')
        <!-- Leaflet JS -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        <script>
            function dashboardMap() {
                return {
                    cameras: @json($cameras),
                    filteredCameras: [],
                    searchQuery: '',
                    map: null,
                    markers: {},

                    init() {
                        this.filteredCameras = this.cameras;

                        // Wait for DOM to be ready
                        this.$nextTick(() => {
                            // Small delay to ensure container is rendered
                            setTimeout(() => {
                                this.initMap();
                            }, 100);
                        });
                    },

                    initMap() {
                        // Check if map container exists
                        const mapContainer = document.getElementById('map');
                        if (!mapContainer) {
                            console.error('Map container not found');
                            return;
                        }

                        // Initialize map centered on Bogor
                        this.map = L.map('map', {
                            center: [-6.5971, 106.8060],
                            zoom: 12,
                            zoomControl: true,
                            scrollWheelZoom: true
                        });

                        // Add OpenStreetMap tiles
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                            maxZoom: 19,
                            minZoom: 3
                        }).addTo(this.map);

                        // Force map to recalculate size
                        setTimeout(() => {
                            this.map.invalidateSize();
                        }, 200);

                        // Add markers for all cameras
                        this.addMarkers();

                        // Auto-fit bounds if cameras exist
                        if (this.cameras.length > 0) {
                            const bounds = [];
                            this.cameras.forEach(camera => {
                                if (camera.latitude && camera.longitude) {
                                    bounds.push([camera.latitude, camera.longitude]);
                                }
                            });
                            if (bounds.length > 0) {
                                this.map.fitBounds(bounds, {
                                    padding: [50, 50],
                                    maxZoom: 15
                                });
                            }
                        }
                    },

                    addMarkers() {
                        this.cameras.forEach(camera => {
                            if (camera.latitude && camera.longitude) {
                                // Determine marker color
                                let color = camera.is_active ?
                                    (camera.lanes === 2 ? '#9333ea' : '#3b82f6') :
                                    '#ef4444';

                                // Create custom icon
                                const icon = L.divIcon({
                                    className: 'custom-marker',
                                    html: `<div style="
                            width: 36px; 
                            height: 36px; 
                            background-color: ${color}; 
                            border-radius: 50%; 
                            border: 3px solid white;
                            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            color: white;
                            font-weight: bold;
                            font-size: 14px;
                            ${camera.is_active ? 'animation: pulse 2s infinite;' : ''}
                        ">${camera.lanes}</div>`,
                                    iconSize: [36, 36],
                                    iconAnchor: [18, 36],
                                    popupAnchor: [0, -36]
                                });

                                // Create marker
                                const marker = L.marker([camera.latitude, camera.longitude], {
                                        icon
                                    })
                                    .addTo(this.map);

                                // Create popup content
                                const popupContent = `
                        <div style="min-width: 220px; max-width: 300px;">
                            <h3 style="font-weight: bold; font-size: 16px; margin-bottom: 8px; color: #1f2937;">${camera.name}</h3>
                            <p style="color: #6b7280; font-size: 13px; margin-bottom: 12px; display: flex; align-items: center; gap: 4px;">
                                <svg style="width: 14px; height: 14px;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                                ${camera.location || 'Unknown Location'}
                            </p>
                            <div style="background: linear-gradient(to right, #dbeafe, #e0e7ff); padding: 14px; border-radius: 8px; margin-bottom: 12px; border: 1px solid #bfdbfe;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                    <span style="font-size: 13px; color: #374151; font-weight: 500;">Total Kendaraan</span>
                                    <span style="font-size: 28px; font-weight: bold; color: #2563eb;">
                                        ${camera.latest_analytic ? camera.latest_analytic.total : 0}
                                    </span>
                                </div>
                                ${camera.latest_analytic ? 
                                    `<p style="font-size: 11px; color: #6b7280; margin: 0;">
                                                ${this.formatTime(camera.latest_analytic.timestamp)}
                                            </p>` : 
                                    '<p style="font-size: 11px; color: #6b7280; margin: 0;">Belum ada data</p>'
                                }
                            </div>
                            <div style="text-align: center;">
                                <a href="/camera/${camera.id}" 
                                   style="display: inline-block; background: #2563eb; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 600; transition: background 0.2s;">
                                    Lihat Detail & Live Video →
                                </a>
                            </div>
                        </div>
                    `;

                                marker.bindPopup(popupContent, {
                                    maxWidth: 300,
                                    className: 'custom-popup'
                                });

                                // Click to open popup
                                marker.on('click', function() {
                                    marker.openPopup();
                                });

                                // Store marker reference
                                this.markers[camera.id] = marker;
                            }
                        });
                    },

                    filterCameras() {
                        const query = this.searchQuery.toLowerCase();
                        this.filteredCameras = this.cameras.filter(camera => {
                            return camera.name.toLowerCase().includes(query) ||
                                (camera.location && camera.location.toLowerCase().includes(query));
                        });

                        // Highlight matching markers
                        Object.keys(this.markers).forEach(id => {
                            const marker = this.markers[id];
                            const camera = this.cameras.find(c => c.id == id);

                            if (this.filteredCameras.includes(camera)) {
                                marker.setOpacity(1);
                            } else {
                                marker.setOpacity(0.3);
                            }
                        });

                        // Fit bounds to filtered results
                        if (this.filteredCameras.length > 0 && this.searchQuery) {
                            const bounds = [];
                            this.filteredCameras.forEach(camera => {
                                if (camera.latitude && camera.longitude) {
                                    bounds.push([camera.latitude, camera.longitude]);
                                }
                            });
                            if (bounds.length > 0) {
                                this.map.fitBounds(bounds, {
                                    padding: [50, 50],
                                    maxZoom: 15
                                });
                            }
                        }
                    },

                    highlightMarker(cameraId) {
                        if (this.markers[cameraId]) {
                            this.markers[cameraId].openPopup();
                        }
                    },

                    unhighlightMarker(cameraId) {
                        if (this.markers[cameraId]) {
                            this.markers[cameraId].closePopup();
                        }
                    },

                    formatTime(timestamp) {
                        const date = new Date(timestamp);
                        const now = new Date();
                        const diffMs = now - date;
                        const diffMins = Math.floor(diffMs / 60000);

                        if (diffMins < 1) return 'Baru saja';
                        if (diffMins < 60) return `${diffMins} menit yang lalu`;

                        const diffHours = Math.floor(diffMins / 60);
                        if (diffHours < 24) return `${diffHours} jam yang lalu`;

                        return date.toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'short',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    }
                }
            }
        </script>
    @endpush
@endsection
