<!-- resources/views/dashboard/show.blade.php - FIXED -->

@extends('layouts.app')

@section('content')
    <div x-data="cameraDetailApp({{ $camera->id }}, {{ $camera->lanes }})" x-init="init()">
        <!-- Back Button -->
        <div class="container mx-auto px-4 py-4">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>

        <!-- Camera Header -->
        <div class="container mx-auto px-4 pb-4">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">{{ $camera->name }}</h1>
                        <p class="text-gray-600 mt-2 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ $camera->location ?? 'Unknown Location' }}
                        </p>
                    </div>
                    <div class="text-right">
                        {{-- <span
                            class="inline-flex items-center bg-green-100 text-green-800 text-sm px-4 py-2 rounded-full font-semibold">
                            <span class="h-2 w-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                            LIVE AI
                        </span> --}}
                        <p class="text-sm text-gray-600 mt-2">
                            {{ $camera->lanes }} {{ $camera->lanes > 1 ? 'Lanes' : 'Lane' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Video & Analytics Grid -->
        <div class="container mx-auto px-4 pb-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Video Player (2/3 width) -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <!-- Video Container -->
                        <div class="relative bg-black" style="padding-top: 56.25%;">
                            <!-- Direct Flask Stream -->
                            <img id="videoStream" class="absolute top-0 left-0 w-full h-full object-cover"
                                src="{{ config('services.flask.url') }}/video/{{ $camera->id }}"
                                alt="{{ $camera->name }}">

                            <!-- Loading Overlay -->
                            <div id="loadingOverlay"
                                class="absolute inset-0 bg-black bg-opacity-75 flex items-center justify-center"
                                style="display: none;">
                                <div class="text-center">
                                    <div
                                        class="inline-block animate-spin rounded-full h-16 w-16 border-4 border-blue-200 border-t-blue-600 mb-4">
                                    </div>
                                    <p class="text-white text-lg">Loading video stream...</p>
                                </div>
                            </div>

                            <!-- Error Overlay -->
                            <div id="errorOverlay"
                                class="absolute inset-0 bg-red-900 bg-opacity-90 flex items-center justify-center"
                                style="display: none;">
                                <div class="text-center text-white p-6">
                                    <svg class="w-20 h-20 mx-auto mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h3 class="text-xl font-bold mb-2">Stream Error</h3>
                                    <p class="text-sm mb-4">Unable to connect to video stream</p>
                                    <button onclick="retryStream()"
                                        class="bg-white text-red-900 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100">
                                        Retry Connection
                                    </button>
                                </div>
                            </div>

                            <!-- LIVE Indicator -->
                            {{-- <div
                                class="absolute top-4 right-4 bg-red-600 text-white text-sm px-4 py-2 rounded-full flex items-center shadow-lg z-10">
                                <span class="h-2 w-2 bg-white rounded-full mr-2 animate-pulse"></span>
                                <span class="font-semibold">LIVE AI</span>
                            </div> --}}

                            <!-- Stream Info -->
                            <div
                                class="absolute bottom-4 left-4 bg-black bg-opacity-70 text-white text-xs px-3 py-2 rounded z-10">
                                <span id="streamStatus">🟢 Connected</span>
                            </div>
                        </div>

                        <!-- Stream Controls -->
                        <div class="p-4 bg-gray-50 border-t">
                            <div class="flex justify-between items-center">
                                <div class="text-sm text-gray-600">
                                    <span class="font-semibold">Stream Source:</span>
                                    <span class="text-gray-800 ml-2">{{ config('services.flask.url') }}</span>
                                </div>
                                <button onclick="toggleFullscreen()"
                                    class="text-blue-600 hover:text-blue-800 flex items-center text-sm font-medium">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4">
                                        </path>
                                    </svg>
                                    Fullscreen
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Analytics Panel (1/3 width) -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-lg p-6 sticky top-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-800">Traffic Analytics</h3>
                            <span class="text-xs text-gray-500" x-text="'Updated: ' + lastUpdate"></span>
                        </div>

                        <!-- 1 LANE VIEW -->
                        <template x-if="lanes === 1 && analytics">
                            <div>
                                <div class="space-y-3 mb-4">
                                    <div class="flex justify-between items-center bg-purple-50 rounded px-3 py-2">
                                        <span class="text-purple-700 font-medium">🏍️ Motor</span>
                                        <span class="font-bold text-purple-800 text-lg"
                                            x-text="analytics.sepeda_motor || 0"></span>
                                    </div>
                                    <div class="flex justify-between items-center bg-green-50 rounded px-3 py-2">
                                        <span class="text-green-700 font-medium">🚗 Mobil</span>
                                        <span class="font-bold text-green-800 text-lg"
                                            x-text="analytics.mobil_penumpang || 0"></span>
                                    </div>
                                    <div class="flex justify-between items-center bg-orange-50 rounded px-3 py-2">
                                        <span class="text-orange-700 font-medium">🚙 Sedang</span>
                                        <span class="font-bold text-orange-800 text-lg"
                                            x-text="analytics.kendaraan_sedang || 0"></span>
                                    </div>
                                    <div class="flex justify-between items-center bg-cyan-50 rounded px-3 py-2">
                                        <span class="text-cyan-700 font-medium">🚌 Bus</span>
                                        <span class="font-bold text-cyan-800 text-lg"
                                            x-text="analytics.bus_besar || 0"></span>
                                    </div>
                                    <div class="flex justify-between items-center bg-yellow-50 rounded px-3 py-2">
                                        <span class="text-yellow-700 font-medium">🚚 Truk</span>
                                        <span class="font-bold text-yellow-800 text-lg"
                                            x-text="analytics.truk_barang || 0"></span>
                                    </div>
                                </div>

                                <!-- Total -->
                                <div class="pt-4 border-t border-gray-200">
                                    <div
                                        class="flex justify-between items-center bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg px-4 py-4 border-2 border-blue-200">
                                        <span class="text-lg font-bold text-gray-700">TOTAL</span>
                                        <span class="text-5xl font-bold text-blue-600"
                                            x-text="analytics.total || 0"></span>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- 2 LANES VIEW -->
                        <template x-if="lanes === 2 && analytics">
                            <div>
                                <!-- Lane 1 -->
                                <div class="mb-4 bg-cyan-50 rounded-lg p-4 border border-cyan-200">
                                    <h4 class="font-semibold text-cyan-700 mb-3 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                        </svg>
                                        Lane 1
                                    </h4>
                                    <template x-if="analytics.lane1_data">
                                        <div class="space-y-2">
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-700">🏍️ Motor</span>
                                                <span class="font-bold text-cyan-800"
                                                    x-text="analytics.lane1_data.sepeda_motor || 0"></span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-700">🚗 Mobil</span>
                                                <span class="font-bold text-cyan-800"
                                                    x-text="analytics.lane1_data.mobil_penumpang || 0"></span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-700">🚙 Sedang</span>
                                                <span class="font-bold text-cyan-800"
                                                    x-text="analytics.lane1_data.kendaraan_sedang || 0"></span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-700">🚌 Bus</span>
                                                <span class="font-bold text-cyan-800"
                                                    x-text="analytics.lane1_data.bus_besar || 0"></span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-700">🚚 Truk</span>
                                                <span class="font-bold text-cyan-800"
                                                    x-text="analytics.lane1_data.truk_barang || 0"></span>
                                            </div>
                                            <div
                                                class="flex justify-between font-bold text-cyan-700 pt-2 border-t border-cyan-300">
                                                <span>Total</span>
                                                <span class="text-xl" x-text="analytics.lane1_data.total || 0"></span>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <!-- Lane 2 -->
                                <div class="mb-4 bg-purple-50 rounded-lg p-4 border border-purple-200">
                                    <h4 class="font-semibold text-purple-700 mb-3 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                        </svg>
                                        Lane 2
                                    </h4>
                                    <template x-if="analytics.lane2_data">
                                        <div class="space-y-2">
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-700">🏍️ Motor</span>
                                                <span class="font-bold text-purple-800"
                                                    x-text="analytics.lane2_data.sepeda_motor || 0"></span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-700">🚗 Mobil</span>
                                                <span class="font-bold text-purple-800"
                                                    x-text="analytics.lane2_data.mobil_penumpang || 0"></span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-700">🚙 Sedang</span>
                                                <span class="font-bold text-purple-800"
                                                    x-text="analytics.lane2_data.kendaraan_sedang || 0"></span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-700">🚌 Bus</span>
                                                <span class="font-bold text-purple-800"
                                                    x-text="analytics.lane2_data.bus_besar || 0"></span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-700">🚚 Truk</span>
                                                <span class="font-bold text-purple-800"
                                                    x-text="analytics.lane2_data.truk_barang || 0"></span>
                                            </div>
                                            <div
                                                class="flex justify-between font-bold text-purple-700 pt-2 border-t border-purple-300">
                                                <span>Total</span>
                                                <span class="text-xl" x-text="analytics.lane2_data.total || 0"></span>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <!-- Combined Total -->
                                <div class="pt-4 border-t-2 border-gray-300">
                                    <div
                                        class="flex justify-between items-center bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg px-4 py-4 border-2 border-blue-200">
                                        <span class="text-lg font-bold text-gray-700">TOTAL ALL</span>
                                        <span class="text-5xl font-bold text-blue-600"
                                            x-text="analytics.total || 0"></span>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Loading State -->
                        <template x-if="!analytics">
                            <div class="text-center py-12">
                                <div
                                    class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-blue-200 border-t-blue-600">
                                </div>
                                <p class="text-gray-500 text-sm mt-4">Loading analytics...</p>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Alpine.js Component
            function cameraDetailApp(cameraId, lanes) {
                return {
                    cameraId: cameraId,
                    lanes: lanes,
                    analytics: null,
                    lastUpdate: 'Loading...',

                    init() {
                        this.fetchAnalytics();
                        setInterval(() => this.fetchAnalytics(), 5000);
                        this.monitorStream();
                    },

                    async fetchAnalytics() {
                        try {
                            const response = await fetch(`/api/analytics/latest/${this.cameraId}`);
                            const data = await response.json();

                            if (data.success) {
                                this.analytics = data.data;
                                this.lastUpdate = new Date().toLocaleTimeString();
                            }
                        } catch (error) {
                            console.error('Error fetching analytics:', error);
                        }
                    },

                    monitorStream() {
                        const video = document.getElementById('videoStream');
                        const loading = document.getElementById('loadingOverlay');
                        const errorDiv = document.getElementById('errorOverlay');
                        const status = document.getElementById('streamStatus');

                        if (!video) return;

                        loading.style.display = 'flex';

                        video.addEventListener('load', function() {
                            loading.style.display = 'none';
                            errorDiv.style.display = 'none';
                            status.innerHTML = '🟢 Connected';
                        });

                        video.addEventListener('error', function() {
                            loading.style.display = 'none';
                            errorDiv.style.display = 'flex';
                            status.innerHTML = '🔴 Disconnected';
                        });

                        setInterval(() => {
                            if (video.naturalWidth === 0) {
                                status.innerHTML = '🟡 Connecting...';
                            }
                        }, 10000);
                    }
                }
            }

            function retryStream() {
                const video = document.getElementById('videoStream');
                const loading = document.getElementById('loadingOverlay');
                const errorDiv = document.getElementById('errorOverlay');

                errorDiv.style.display = 'none';
                loading.style.display = 'flex';

                const src = video.src;
                video.src = '';
                setTimeout(() => {
                    video.src = src;
                }, 1000);
            }

            function toggleFullscreen() {
                const container = document.querySelector('.relative.bg-black');

                if (!document.fullscreenElement) {
                    container.requestFullscreen().catch(err => {
                        console.error('Fullscreen error:', err);
                    });
                } else {
                    document.exitFullscreen();
                }
            }
        </script>
    @endpush
@endsection
